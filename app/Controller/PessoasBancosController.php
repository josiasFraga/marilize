<?php

class PessoasBancosController extends AppController {

    public function isAuthorized($user = null) {
        if (!parent::isAuthorized($user)) {
            return false;
        }
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'metronic';
        $this->Auth->allow(array(''));
    }

    public function excluir( $id = null ) {

        $this->layout = 'ajax';

        if ( $id == null || !is_numeric($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado."))));
        }

        $this->loadModel('PessoaBanco');
        $dados = $this->PessoaBanco->findById($id);

        if ( count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "O Banco que você está tentando excluir não existe."))));
        }

        if ( $this->PessoaBanco->delete($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Banco excluído com sucesso."))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir a Banco. Por favor, tente mais tarde."))));   
        }

    }

    public function alterar($id = null) {
        if ( !empty($this->request->data) ) {
            if ( $this->request->data['PessoaBanco']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Banco a ser alterado não informada."))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        if ($id == null) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Banco inexistente."))));
        }

        $this->loadModel('PessoaBanco');
	    $dados = $this->PessoaBanco->findById($id);

        if (count($dados) == 0) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Dados não encontrados."))));
        }
    }

    private function update() {
        $dados_request = $this->request->data;

        if ( !isset($dados_request['PessoaBanco']['id']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Banco não informado."))));
        }
        
        if ($dados_request['PessoaBanco']['cpf'] == "" && $dados_request['PessoaBanco']['cnpj'] == "") {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo cpf e/ou cnpj devem ser preenchidos para alterar o Banco!'))));
        }
        
        $this->loadModel('PessoaBanco');
        $dados = $this->PessoaBanco->findById($dados_request['PessoaBanco']['id']);

        if ( !$dados || count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
        }

        $this->PessoaBanco->set($dados_request);
        
        if ( $this->PessoaBanco->validates() ) {
            // die(debug($dados_request));
            if ( $this->PessoaBanco->save($dados_request) ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Banco alterado com sucesso!"))));
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar o Banco. Por favor, tente novamente em alguns instantes."))));
                //debug($this->PessoaBanco->getDataSource()->getLog(false, false));
            }
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->PessoaBanco->validationErrors[key($this->PessoaBanco->validationErrors)] ))));
        }

    }

}
