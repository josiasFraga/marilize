<?php
class FazendasController extends AppController {
	
	public $components = array('dataTable');
    
	public function isAuthorized($user = null) { // Quando retorna false e não existe um `loginRedirect`, manda para `/`
		return true;
	}
    
    public function beforeFilter() {
		$this->layout = 'metronic';
		$this->set('title_for_layout', 'Fazendas');

	}

    public function index(){
        $this->set('title_for_layout', 'Administrar Fazendas');

        if ( $this->request->is('post') ){
			$this->layout = "ajax";
			return $this->dataTable();
		}
    }

    public function adicionar() {

        $this->set('title_for_layout', 'Adicionar Fazenda');


		if ( !empty($this->request->data) ) {

			$this->layout = "ajax";
			return $this->save();
		}

	}

	public function alterar( $id = null) {

        $this->set('title_for_layout', 'Alterar Fazenda');

		if ( !empty($this->request->data) ) {

			$this->layout = "ajax";
			return $this->update();
		}
		
		//se não setou id do safra a ser alterado
		if ( $id == null ) {
			$this->redirect(array('controller' => 'Fazendas', 'action' => 'index'));
		}

		$this->loadModel("Fazenda");
		$dados = $this->Fazenda->find('first',array(
			'conditions' => array(
				'Fazenda.id' => $id
			),
			'link' => []
		));

		$this->set('dados', $dados);

	}

	private function update() {
		$this->loadModel('Fazenda');

		$this->Fazenda->id = $this->request->data['Fazenda']['id'];
		$this->Fazenda->set($this->request->data);
		if ( $this->Fazenda->validates() ) {
			if ( $this->Fazenda->save() )
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'msg' => "Dados atualizados com sucesso!"))));
			else
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => "Ocorreu um erro ao atualizar os dados do safra!"))));
		} else {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => $this->Fazenda->validationErrors[key($this->Fazenda->validationErrors)]))));
		}
	}

	private function save() {

		$this->loadModel('Fazenda');

		$this->Fazenda->set($this->request->data);

		if ( $this->Fazenda->validates() ) {

			$this->Fazenda->create();
			if ( $this->Fazenda->save($this->request->data) ) 
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'msg' => "Cadastrado com sucesso!"))));
			else{
				return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar cadastrar o safra. Por favor, tente novamente em alguns instantes."))));
				//debug($this->Fazenda->getDataSource()->getLog(false, false));
			}
	
			
		} else {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', 'msg' => $this->Fazenda->validationErrors[key($this->Fazenda->validationErrors)]))));
		}
	}

	public function excluir( $id = null ) {

		$this->layout = 'ajax';

		
		if ( $id == null || !is_numeric($id) ){
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "warning", "msg" => "Item não encontrado."))));
		}

		$this->loadModel('Fazenda');

		$fazenda = $this->Fazenda->findById($id);

		if ( count($fazenda) == 0 ) {
		    return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "erro", "msg" => "A fazenda que você está tentando excluir não existe."))));
		}

		$fazenda['Fazenda']['ativa'] = 'N';
		
		if ( $this->Fazenda->save($fazenda) )
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "ok", "msg" => "Fazenda excluída com sucesso."))));
		else
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array("status" => "erro", "msg" => "Ocorreu um erro ao excluir a fazenda. Por favor, tente mais tarde."))));
	
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
			"Fazenda.nome",
			"Fazenda.localizacao",
			"Fazenda.ie",
			"",
			"Fazenda.ativa"
		);

		$conditions = array();

		if ( $this->dataTable->check_filtro("nome","text") === true)
			$conditions = array_merge($conditions, array("Fazenda.nome LIKE" => "%".$this->request->data["nome"]."%"));
		
		if ( $this->dataTable->check_filtro("ie","text") === true)
			$conditions = array_merge($conditions, array("Fazenda.ie LIKE" => "%".$this->request->data["ie"]."%"));
		
		if ( $this->dataTable->check_filtro("localizacao","text") === true)
			$conditions = array_merge($conditions, array("Fazenda.localizacao LIKE" => "%".$this->request->data["localizacao"]."%"));
		
		if ( $this->dataTable->check_filtro("obs","text") === true)
			$conditions = array_merge($conditions, array("Fazenda.obs LIKE" => "%".$this->request->data["obs"]."%"));
		
		if ( $this->dataTable->check_filtro("ativa","text") === true)
			$conditions = array_merge($conditions, array("Fazenda.ativa" => $this->request->data["ativa"]));

		$this->loadModel('Fazenda');

		if (isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc'))
				$order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];

		$iTotalRecords = $this->Fazenda->find('count');
 		$iDisplayLength = intval($this->request->data['length']);
 		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
 		$iDisplayStart = intval($this->request->data['start']);
		
		$dados = $this->Fazenda->find("all",array(
			'conditions' => $conditions,
			'order' => $order,
			'fields' =>		array(
				"Fazenda.*"
			),
			'link' => 	array(
			),
			'offset' => $iDisplayStart,
			'limit' => $iDisplayLength
		));

		$registrosFiltrados = $this->Fazenda->find("count", array(
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

				$radio =  '<input type="checkbox" name="id[]" value="'.$dado['Fazenda']['id'].'">';
				
				$nome = $dado['Fazenda']['nome'];
				$ie = $dado['Fazenda']['ie'];
				$localizacao = $dado['Fazenda']['localizacao'];
				$obs = $dado['Fazenda']['obs'];
				$ativa = $dado['Fazenda']['ativa'] == 'Y' ? 'Sim' : 'Não';
				
				$btn_alterar = '<a href="'.Router::url(array('controller' => 'Fazendas', 'action' => 'alterar', $dado['Fazenda']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>';
				$btn_excluir = '<a href="#" class="btn btn-icon-only red btn-remove" data-id="'.$dado['Fazenda']['id'].'"><i class="fa fa-trash"></i></a>';
	
				$actions = $btn_alterar.' '.$btn_excluir;

				$records["data"][] = array(
					$radio,
					$nome,
					$ie,
					$localizacao,
					$obs,
					$ativa,
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