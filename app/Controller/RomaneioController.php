<?php

class RomaneioController extends AppController {

    public function isAuthorized($user = null) {
        if (!parent::isAuthorized($user)) {
            return false;
        }
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'metronic';
        $this->Auth->allow(array('teste'));
    }

    public $components = array('dataTable');

    private function excluir( $id = null ) {
        $this->layout = 'ajax';

        if ( is_null($id) || !is_numeric($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado." ))));
        }

        $this->loadModel('Romaneio');
        $dados = $this->Romaneio->findById($id);

        if ( count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "O Romaneio que você está tentando excluir não existe."))));
        }

        if ( $this->Romaneio->delete($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Romaneio excluído com sucesso." ))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir o Romaneio. Por favor, tente mais tarde."))));
        }

    }

    public function excluirArquivo( $id = null ) {
        $this->layout = 'ajax';

        if ( $id == null || !is_numeric($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado."))));
        }

        $this->loadModel('RomaneioArquivo');
        $dados = $this->RomaneioArquivo->findById($id);

        if ( count($dados) <= 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "O Arquivo que você está tentando excluir não existe."))));
        }

        if ( $this->RomaneioArquivo->delete($id) ) {
            // unlink($this->webroot.'files/romaneios_arquivos/'.$dados['RomaneioArquivo']['arquivo']); delete jah exclui arquivo
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Arquivo excluído com sucesso."))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir o Arquivo. Por favor, tente mais tarde."))));   
        }
    }

    protected function validZeroToDivision($val = 0) {
        return (float) ($val==0)? 1: $val;
    }

    public function teste() {
        if (true) {
            die('OK GooGle');
        }
    }

}