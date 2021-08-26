<?php

class PessoasLocalidadesController extends AppController {

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

        $this->loadModel('PessoaLocalidade');
        $dados = $this->PessoaLocalidade->findById($id);

        if ( count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "A Localidade que você está tentando excluir não existe."))));
        }

        if ( $this->PessoaLocalidade->delete($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Localidade excluída com sucesso."))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir a Localidade. Por favor, tente mais tarde."))));   
        }

    }

    public function alterar($id = null) {
        if ( !empty($this->request->data) ) {
            if ( $this->request->data['PessoaLocalidade']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Localidade a ser alterada não informada."))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        if ($id == null) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Localidade inexistente."))));
        }

        $this->loadModel('PessoaLocalidade');
	    $dados = $this->PessoaLocalidade->findById($id);

        if (count($dados) == 0) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Dados não encontrados."))));
        }
    }

    private function update() {
        $dados_request = $this->request->data;
        
        if ( !isset($dados_request['PessoaLocalidade']['id']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Localidade não informada."))));
        }
        
        $this->loadModel('PessoaLocalidade');
        $dados = $this->PessoaLocalidade->findById($dados_request['PessoaLocalidade']['id']);

        if ( !$dados || count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
        }      

        $this->PessoaLocalidade->set($dados_request);
        
        if ( $this->PessoaLocalidade->validates() ) {
            // die(debug($dados_request));
            if ( $this->PessoaLocalidade->save($dados_request) ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Localidade alterada com sucesso!"))));
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar a Localidade. Por favor, tente novamente em alguns instantes."))));
                //debug($this->PessoaLocalidade->getDataSource()->getLog(false, false));
            }
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->PessoaLocalidade->validationErrors[key($this->PessoaLocalidade->validationErrors)] ))));
        }

    }

    public function selectLocalidadeByPessoaId($id = null) {
        $this->layout = null;
        $html = '<option value="">Selecione ...</option>';
        if (is_null($id)) return new CakeResponse( array( 'type' => 'html', 'body' => $html));
        $this->loadModel('PessoaLocalidade');
        $localidades = $this->PessoaLocalidade->findAllLocalidadesByPessoaId($id);
        foreach ($localidades as $localidade) {
            $html.= '<option value="'.$localidade['PessoaLocalidade']['id'].'">'.$localidade['PessoaLocalidade']['localidade'].'</option>';
        }
        return new CakeResponse( array( 'type' => 'html', 'body' => $html));
    }

}
