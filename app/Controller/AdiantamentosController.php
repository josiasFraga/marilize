<?php
class AdiantamentosController extends AppController {
    public $components = array('dataTable', 'Mpdf.Mpdf');

    public function isAuthorized($user = null) {
        if (!parent::isAuthorized($user)) {
            return false;
        }
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'metronic';
    }
    
    protected function dataTable($tipo = null) {

        $this->layout = "ajax";

        if ( !$this->request->is('post') || empty($this->request->data) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Requisição inválida!' ))));
        }

        if ( isset($this->request->data['order']) ) $order = $this->request->data['order'];

        $arr_columns_order = array(
            "",
            "Credor.razao_social",
            "Tomador.razao_social",
            "Adiantamento.emissao",
            "Adiantamento.entrada",
            "Adiantamento.saida",
            "Adiantamento.saldo",
            "Adiantamento.obs",
        );

        $conditions = array();

		if ( $this->dataTable->check_filtro("nome_fantasia_credor","text") === true){
			$conditions = array_merge($conditions, array("Credor.razao_social LIKE" => "%".$this->request->data["nome_fantasia_credor"]."%"));
		}

		if ( $this->dataTable->check_filtro("nome_fantasia","text") === true){
			$conditions = array_merge($conditions, array("Tomador.razao_social LIKE" => "%".$this->request->data["nome_fantasia"]."%"));
		}

        if (isset($this->request->data['emissao_de']) && !empty($this->request->data['emissao_de'])) {
            $conditions = array_merge($conditions, array("Adiantamento.emissao >=" => $this->request->data["emissao_de"]));
        }

        if (isset($this->request->data['emissao_ate']) && !empty($this->request->data['emissao_ate'])) {
            $conditions = array_merge($conditions, array("Adiantamento.emissao <=" => $this->request->data['emissao_ate']));
        }

        if ( $this->dataTable->check_filtro("entrada", "float") === true){
            $conditions = array_merge($conditions, array("Adiantamento.entrada" => $this->request->data["entrada"]));
        }

        if ( $this->dataTable->check_filtro("saida", "float") === true){
            $conditions = array_merge($conditions, array("Adiantamento.saida" => $this->request->data["saida"]));
        }

        if ( $this->dataTable->check_filtro("saldo", "float") === true){
            $conditions = array_merge($conditions, array("Adiantamento.saldo" => $this->request->data["saldo"]));
        }

		if ( $this->dataTable->check_filtro("obs","text") === true){
			$conditions = array_merge($conditions, array("Adiantamento.obs LIKE" => "%".$this->request->data["obs"]."%"));
		}

        if ( isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc')) {
            $order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];
        }

        $this->loadModel('Adiantamento');

		$iTotalRecords = $this->Adiantamento->find('count', [
			'conditions' => []
		]);

		$iDisplayLength = intval($this->request->data['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = intval($this->request->data['start']);

		$dados = $this->Adiantamento->find('all',array(
			'conditions' => $conditions,
			'order' => $order,
			'fields' => array(
                "Adiantamento.*",
                "Credor.razao_social",
                "Tomador.razao_social"
			),
			'link' => ['Credor', 'Tomador'],
			'offset' => $iDisplayStart,
			'limit' => $iDisplayLength
		));

		$registrosFiltrados = $this->Adiantamento->find("count", array(
			'conditions' => $conditions,
			'link' => ['Credor', 'Tomador'],
		));

        // debug($dados); die();

        $iRecordsFiltered = $registrosFiltrados;
        $sEcho = intval($this->request->data['draw']);
        $records = array();
        $records["data"] = array();

        $hoje = date('Y-m-d');

        if ( count($dados) > 0 ) {

            foreach ( $dados as $dado ) {

                $radio = '<input type="checkbox" name="id[]" value="'.$dado['Adiantamento']['id'].'">';

                $credor = $dado['Credor']['razao_social'];
                
                $tomador = $dado['Tomador']['razao_social'];

                $emissao = date('d/m/Y', strtotime($dado['Adiantamento']['emissao']));

                $entrada = "R&#36; ".number_format($dado['Adiantamento']['entrada'], 2, ',', '.');

                $saida = "R&#36; ".number_format($dado['Adiantamento']['saida'], 2, ',', '.');

                $saldo = "R&#36; ".number_format($dado['Adiantamento']['saldo'], 2, ',', '.');

                $obs = $dado['Adiantamento']['obs'];
                
                $actions = "";

                $btn_alterar = '<a href="'.Router::url(array('controller' => $this->name, 'action' => 'alterar', $dado['Adiantamento']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>';

                $btn_excluir = '<a href="#" class="btn btn-icon-only red btn-remove" data-id="'.$dado['Adiantamento']['id'].'"><i class="fa fa-trash"></i></a>';

                $actions = $btn_alterar.' '.$btn_excluir;

                $records["data"][] = array(
                    $radio,
                    $credor,
                    $tomador,
                    $emissao,
                    $entrada,
                    $saida,
                    $saldo,
                    $obs,
                    $actions
                );
            
            }
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iRecordsFiltered;

        return new CakeResponse(
            array(
                'type' => 'json',
                'body' => json_encode($records)
            )
        );

    }

    public function excluir( $id = null ) {
        $this->layout = 'ajax';

        if ( is_null($id) || !is_numeric($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado." ))));
        }

        $this->loadModel('Adiantamento');
        $dados = $this->Adiantamento->findById($id);

        if ( count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "O adiantamento que você está tentando excluir não existe."))));
        }

        if ( $this->Adiantamento->delete($id) ) {
            $this->Adiantamento->reacalculaSaldos($dados['Adiantamento']['pessoa_id']);
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Adiantamento excluído com sucesso." ))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir o adiantamento. Por favor, tente mais tarde."))));
        }

    }

    protected function save() {
        $dados_request = $this->request->data;
        if ( $dados_request['tipo'] == 'E' ) {
            $dados_request['Adiantamento']['entrada'] = $dados_request['Adiantamento']['valor'];
            $dados_request['Adiantamento']['saida'] = 0;
        } else if ( $dados_request['tipo'] == 'S' ){
            $dados_request['Adiantamento']['entrada'] = 0;
            $dados_request['Adiantamento']['saida'] = $dados_request['Adiantamento']['valor'];
        }

        $this->loadModel('Adiantamento');
        $this->Adiantamento->create();
        if (!$this->Adiantamento->save($dados_request) ) {
            
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar cadastrar o adiantamento. Por favor, tente novamente em alguns instantes." ))));
            // debug($this->PagamentoData->getDataSource()->getLog(false, false));
        }

        $this->Adiantamento->reacalculaSaldos($dados_request['Adiantamento']['credor_id'], $dados_request['Adiantamento']['tomador_id']);

        return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Adiantamento cadastrado com sucesso!" ))));

    }

    protected function update() {
        $dados_request = $this->request->data;
        if ( !isset($dados_request['Adiantamento']['id']) || !is_numeric($dados_request['Adiantamento']['id']) ) {            
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Adiantamento não informado!" ))));
        }

        if ( $dados_request['tipo'] == 'E' ) {
            $dados_request['Adiantamento']['entrada'] = $dados_request['Adiantamento']['valor'];
            $dados_request['Adiantamento']['saida'] = 0;
        } else if ( $dados_request['tipo'] == 'S' ){
            $dados_request['Adiantamento']['entrada'] = 0;
            $dados_request['Adiantamento']['saida'] = $dados_request['Adiantamento']['valor'];
        }

        $this->loadModel('Adiantamento');
        $dados_diantamento = $this->Adiantamento->find('first',[
            'conditions' => [
                'Adiantamento.id' => $dados_request['Adiantamento']['id']
            ]
        ]);

        if ( count($dados_diantamento) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Adiantamento não encontrado!" ))));
        }


        if (!$this->Adiantamento->save($dados_request) ) {
            
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar o adiantamento. Por favor, tente novamente em alguns instantes." ))));
            // debug($this->PagamentoData->getDataSource()->getLog(false, false));
        }

        //if ( $dados_diantamento['Adiantamento']['credor_id'] != $dados_request['Adiantamento']['pessoa_id'] )
            //$this->Adiantamento->reacalculaSaldos($dados_diantamento['Adiantamento']['pessoa_id']);
            
        $this->Adiantamento->reacalculaSaldos($dados_request['Adiantamento']['credor_id'], $dados_request['Adiantamento']['tomador_id']);

        return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Adiantamento alterado com sucesso!" ))));

    }

	public function index() {
		$this->set('title_for_layout', 'Adiantamentos');
		if ( $this->request->is('post') ) {
			$this->layout = "ajax";
			return $this->dataTable();
		}
    }

    public function adicionar() {
        $this->set('title_for_layout', 'Adicionar Adiantamento');
		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
        }
        
        $this->loadModel('Credor');
        $credores = $this->Credor->listCredores([1]);
        
        $this->loadModel('Tomador');
        $tomadores = $this->Tomador->listTomadores([1]);

        $this->loadModel('Banco');
        $bancos = $this->Banco->find('all',[
            'fields' => [                
                'Banco.*'
            ],
            'order' => [
                'Banco.cod'
            ]
        ]);

        $this->set(compact('credores', 'tomadores', 'bancos'));

    }
    
    public function alterar($id = null) {
        $this->set('title_for_layout', 'Alterar Adiantamento');
		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->update();
        }

        if ( $id == null ) {
			return $this->redirect(array('action' => 'index'));
        }
        
        $this->loadModel('Credor');
        $credores = $this->Credor->listCredores();
        
        $this->loadModel('Tomador');
        $tomadores = $this->Tomador->listTomadores();
        
        $this->loadModel('Banco');
        $bancos = $this->Banco->find('all',[
            'fields' => [                
                'Banco.*'
            ],
            'order' => [
                'Banco.cod'
            ]
        ]);

        
        $this->loadModel('Adiantamento');
        $dados = $this->Adiantamento->find('first',[
            'conditions' => [
                'Adiantamento.id' => $id
            ],
        ]);

        $this->set(compact('dados', 'credores', 'tomadores', 'bancos'));

    }
    
    public function imprimir() {
		$this->layout = 'pdf';
        
        $conditions = array();

        $this->request->data = $this->request->query;


		if ( $this->dataTable->check_filtro("nome_fantasia_credor","text") === true){
			$conditions = array_merge($conditions, array("Credor.razao_social LIKE" => "%".$this->request->data["nome_fantasia_credor"]."%"));
		}

		if ( $this->dataTable->check_filtro("nome_fantasia","text") === true){
			$conditions = array_merge($conditions, array("Tomador.razao_social LIKE" => "%".$this->request->data["nome_fantasia"]."%"));
		}

        if (isset($this->request->data['emissao_de']) && !empty($this->request->data['emissao_de'])) {
            $conditions = array_merge($conditions, array("Adiantamento.emissao >=" => $this->request->data["emissao_de"]));
        }

        if (isset($this->request->data['emissao_ate']) && !empty($this->request->data['emissao_ate'])) {
            $conditions = array_merge($conditions, array("Adiantamento.emissao <=" => $this->request->data['emissao_ate']));
        }

        if ( $this->dataTable->check_filtro("entrada", "float") === true){
            $conditions = array_merge($conditions, array("Adiantamento.entrada" => $this->request->data["entrada"]));
        }

        if ( $this->dataTable->check_filtro("saida", "float") === true){
            $conditions = array_merge($conditions, array("Adiantamento.saida" => $this->request->data["saida"]));
        }

        if ( $this->dataTable->check_filtro("saldo", "float") === true){
            $conditions = array_merge($conditions, array("Adiantamento.saldo" => $this->request->data["saldo"]));
        }

		if ( $this->dataTable->check_filtro("obs","text") === true){
			$conditions = array_merge($conditions, array("Adiantamento.obs LIKE" => "%".$this->request->data["obs"]."%"));
        }

        $this->loadModel('Adiantamento');
        $dados = $this->Adiantamento->find('all',array(
			'conditions' => $conditions,
			'fields' => array(
                "Adiantamento.*",
                "Credor.razao_social",
                "Tomador.razao_social"
			),
			'link' => ['Credor', 'Tomador']
        ));
        $this->Mpdf->init();
		$this->Mpdf->packTableData  = true; // necessario pq não gerava pq tinha mt registro
        $this->Mpdf->setFilename('file.pdf');
        $this->Mpdf->setOutput('I');
        $this->Mpdf->SetFooter("Orelhano - Adiantamentos");
		$this->Mpdf->SetWatermarkText("Draft");
        
        $this->set(compact('dados'));

    }

}