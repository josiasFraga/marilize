<?php
class SafrasController extends AppController {
	
	public $components = array('dataTable');
    
	public function isAuthorized($user = null) { // Quando retorna false e não existe um `loginRedirect`, manda para `/`
		return true;
	}
    
    public function beforeFilter() {
		$this->layout = 'metronic';
		$this->set('title_for_layout', 'Safras');

	}

    public function index(){
        $this->set('title_for_layout', 'Administrar Safras');

        if ( $this->request->is('post') ){

			$this->layout = "ajax";
			return $this->dataTable();

		}

    }

    public function adicionar() {

        $this->set('title_for_layout', 'Adicionar Safra');

		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
		}

	}

	public function alterar( $id = null) {

        $this->set('title_for_layout', 'Alterar Safra');

		if ( !empty($this->request->data) ) {

			$this->layout = "ajax";
			return $this->update();
		}
		
		//se não setou id do safra a ser alterado
		if ( $id == null ) {
			$this->redirect(array('controller' => 'safras', 'action' => 'index'));
		}

		$this->loadModel("Safra");
		$dados = $this->Safra->find('first',array(
			'conditions' => array(
				'Safra.id' => $id
			)
		));

		$dados['Safra']['periodo'] = $this->dateEnBr($dados['Safra']['inicio'])." até ".$this->dateEnBr($dados['Safra']['fim']);
		$this->set('dados', $dados);

	}

	private function update() {
		$this->loadModel('Safra');

		$this->Safra->id = $this->request->data['Safra']['id'];
		$this->Safra->set($this->request->data);
		if ( $this->Safra->validates() ) {
			if ( $this->Safra->save() )
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'msg' => "Dados atualizados com sucesso!"))));
			else
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => "Ocorreu um erro ao atualizar os dados do safra!"))));
		} else {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => $this->Safra->validationErrors[key($this->Safra->validationErrors)]))));
		}
	}

	private function save() {

		$this->loadModel('Safra');

		$this->Safra->set($this->request->data);

		if ( $this->Safra->validates() ) {

			$this->Safra->create();
			if ( $this->Safra->saveAssociated($this->request->data) ) 
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'msg' => "Cadastrado com sucesso!"))));
			else{
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar cadastrar o safra. Por favor, tente novamente em alguns instantes."))));
				//debug($this->Safra->getDataSource()->getLog(false, false));
			}
	
			
		} else {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => $this->Safra->validationErrors[key($this->Safra->validationErrors)]))));
		}
	}


	public function excluir( $id = null ) {

		$this->layout = 'ajax';

		
		if ( $id == null || !is_numeric($id) ){
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "warning", "msg" => "Item não encontrado."))));
		}

		$this->loadModel('Safra');

		$safra = $this->Safra->findById($id);

		if ( count($safra) == 0 ) {
		    return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "erro", "msg" => "A safra que você está tentando excluir não existe."))));
		}

		$safra['Safra']['ativa'] = 'N';
		
		if ( $this->Safra->save($safra) )
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "ok", "msg" => "Safra excluída com sucesso."))));
		else
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "erro", "msg" => "Ocorreu um erro ao excluir a Safra. Por favor, tente mais tarde."))));
	
	}

	private function dataTable(){

		$this->layout = "ajax";

		if ( !$this->request->is('post') || empty($this->request->data) ){
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => 'Requisição inválida!'))));
		} 

		if ( isset($this->request->data['order']) )
			$order = $this->request->data['order'];

		$arr_columns_order = array(
			'',
			"Safra.nome",
			"Safra.inicio",
			"Safra.fim"
		);

		$conditions = ['Safra.ativa' => 'Y'];

		if ( $this->dataTable->check_filtro("nome","text") === true)
			$conditions = array_merge($conditions, array("Safra.nome LIKE" => "%".$this->request->data["nome"]."%"));

		if ( $this->dataTable->check_filtro("inicio_de","date") === true){
			$data = $this->dateBrEn($this->request->data["inicio_de"]);
			$conditions = array_merge($conditions, array("DATE(Safra.inicio) >=" => $data));
		}

		if ( $this->dataTable->check_filtro("inicio_ate","date") === true){
			$data = $this->dateBrEn($this->request->data["inicio_ate"]);
			$conditions = array_merge($conditions, array("DATE(Safra.inicio) <=" => $data));
		}

		if ( $this->dataTable->check_filtro("fim_de","date") === true){
			$data = $this->dateBrEn($this->request->data["fim_de"]);
			$conditions = array_merge($conditions, array("Safra.fim >=" => $data));
		}

		if ( $this->dataTable->check_filtro("fim_ate","date") === true){
			$data = $this->dateBrEn($this->request->data["fim_ate"]);
			$conditions = array_merge($conditions, array("Safra.fim <=" => $data));
		}


		$this->loadModel('Safra');

		if (isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc'))
				$order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];

		$iTotalRecords = $this->Safra->find('count',array(
			/*'conditions' => array(
				"Safra.id" => $empresas_permitidas
			)*/
		));
 		$iDisplayLength = intval($this->request->data['length']);
 		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
 		$iDisplayStart = intval($this->request->data['start']);
		
		$dados = $this->Safra->find("all",array(
			'conditions' => $conditions,
			'order' => $order,
			'fields' =>		array(
				"Safra.*"
			),
			'link' => array(
			),
			'offset' => $iDisplayStart,
			'limit' => $iDisplayLength
		));

		$registrosFiltrados = $this->Safra->find("count", array(
			'conditions' => $conditions,
            'link' => array(
            )
		));

		$iRecordsFiltered = $registrosFiltrados;
		$sEcho = intval($this->request->data['draw']);
  		$records = array();
  		$records["data"] = array();
  
 		if ( count($dados) > 0 ){
 			foreach($dados as $dado){

				$radio =  '<input type="checkbox" name="id[]" value="'.$dado['Safra']['id'].'">';
				
				$nome = $dado['Safra']['nome'];
				$inicio = $this->dateEnBr($dado['Safra']['inicio']);
				$fim = $this->dateEnBr($dado['Safra']['fim']);
				
				$btn_alterar = '<a href="'.Router::url(array('controller' => 'Safras', 'action' => 'alterar', $dado['Safra']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>';
				$btn_excluir = '<a href="#" class="btn btn-icon-only red btn-remove" data-id="'.$dado['Safra']['id'].'"><i class="fa fa-trash"></i></a>';
	
				$actions = $btn_alterar.' '.$btn_excluir;

				$records["data"][] = array(
					$radio,
					$nome,
					$inicio,
					$fim,
					$actions
				);
				
			}
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iRecordsFiltered;

		return new CakeResponse(array('type' => 'json', 'body' => json_encode($records)));
	}
}