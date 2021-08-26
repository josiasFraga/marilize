<?php

class EspeciesController extends AppController {

    public function isAuthorized($user = null) {
        if (!parent::isAuthorized($user)) {
            return false;
        }
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'metronic';
        // $this->Auth->allow(array(''));
    }

    public $components = array('dataTable');

    public function index() {
        $this->set('title_for_layout', 'Espécies');
        if ( $this->request->is('post') ) {
            $this->layout = "ajax";
            return $this->dataTable();
        }
    }

    private function dataTable() {

        $this->layout = "ajax";

        if ( !$this->request->is('post') || empty($this->request->data) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Requisição inválida!'))));
        }

        if ( isset($this->request->data['order']) ) $order = $this->request->data['order'];

        $arr_columns_order = array(
            '',
            "RomaneioEspecie.especie",
        );

        $conditions = array();

        if ( $this->dataTable->check_filtro("especie","text") === true){
            $conditions = array_merge($conditions, array("RomaneioEspecie.especie LIKE" => "%".$this->request->data["especie"]."%"));
        }

        if ( isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc')) {
            $order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];
        }

        $this->loadModel('RomaneioEspecie');

        $iTotalRecords = $this->RomaneioEspecie->find('count');

        $iDisplayLength = intval($this->request->data['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($this->request->data['start']);

        $dados = $this->RomaneioEspecie->find('all',array(
                'conditions' => $conditions,
                'order' => $order,
                'fields' => array(
                    "RomaneioEspecie.*",
                ),
                'link' => array(),
                'offset' => $iDisplayStart,
                'limit' => $iDisplayLength
            )
        );

        $registrosFiltrados = $this->RomaneioEspecie->find("count", array(
            'conditions' => $conditions,
            'link' => array()
        ));

        // die(debug($dados));

        $iRecordsFiltered = $registrosFiltrados;
        $sEcho = intval($this->request->data['draw']);
        $records = array();
        $records["data"] = array();
        if ( count($dados) > 0 ) {
            foreach ( $dados as $dado ) {

                $radio = '<input type="checkbox" name="id[]" value="'.$dado['RomaneioEspecie']['id'].'">';

                $especie = $dado['RomaneioEspecie']['especie'];

                $btn_alterar = '<button title="Alterar Espécie" type="button" class="btn btn-icon-only green" data-toggle="modal" data-target="#editEspecie" data-esp-id="'.$dado['RomaneioEspecie']['id'].'" data-esp-nm="'.$dado['RomaneioEspecie']['especie'].'"><i class="fa fa-pencil"></i></button>';

                $records["data"][] = array(
                    $radio,
                    $especie,
                    $btn_alterar
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

    public function adicionar() {
        $this->set('title_for_layout', 'Adicionar Espécie');
		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
        }
	}

    private function save() {
        $dados_request = $this->request->data;

        $this->loadModel('RomaneioEspecie');
        $this->RomaneioEspecie->set($dados_request);
        if ( !$this->RomaneioEspecie->validates() ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->RomaneioEspecie->validationErrors[key($this->RomaneioEspecie->validationErrors)] ) ) ) );
        }

        // die(debug($dados_request));
        $this->RomaneioEspecie->create();
        if ( $this->RomaneioEspecie->save($dados_request) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Cadastro realizado com sucesso!" ))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar o Cadastro. Por favor, tente novamente em alguns instantes." ))));
        }
    }

    public function alterar($id = null) {
        $this->set('title_for_layout', 'Alterar Espécie');
        
        if ( !empty($this->request->data) ) {
            if ( $this->request->data['RomaneioEspecie']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Romaneio a ser alterado não informado."))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        if ($id == null) {
            $this->redirect(array('action' => 'index'));
            die();
        }

        $this->loadModel('RomaneioEspecie');
        $dados = $this->RomaneioEspecie->findById($id);
        
        if (count($dados) <= 0) {
            $this->Session->setFlash('Espécie Incorreta!!!', 'flash_error');
            return $this->routing();
        }

        $this->set(compact('dados'));

    }

    private function update() {
        $dados_request = $this->request->data;
        
        if ( !isset($dados_request['RomaneioEspecie']['id']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Espécie não informada."))));
        }
        
        $this->loadModel('RomaneioEspecie');
        $dados = $this->RomaneioEspecie->findById($dados_request['RomaneioEspecie']['id']);
        
        if ( !$dados || count($dados) <= 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
        }

        $this->loadModel('RomaneioEspecie');
        $this->RomaneioEspecie->set($dados_request);
        if ( !$this->RomaneioEspecie->validates() ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->RomaneioEspecie->validationErrors[key($this->RomaneioEspecie->validationErrors)] ) ) ) );
        }

        // die(debug($dados_request));
        if ( $this->RomaneioEspecie->save($dados_request) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Alteração realizada com sucesso!" ))));
        } else {
            // debug($this->RomaneioEspecie->getDataSource()->getLog(false, false));
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar a Alteração. Por favor, tente novamente em alguns instantes." ))));
        }
    }

}

?>