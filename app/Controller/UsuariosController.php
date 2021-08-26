<?php

App::uses('CakeEmail', 'Network/Email');

class UsuariosController extends AppController {
    
    public $components = array('dataTable');

    public function isAuthorized($user = null) {
        if ($this->action === 'meusdados') {
            return true;
        }
        if (!parent::isAuthorized($user)) {
            return false;
        }
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'metronic';
        $this->Auth->allow(['API_login']);
    }

    public function API_login() {

        $this->layout = 'ajax';

        $dados = $this->request->data;
        $dados  = (object)$dados;
        $this->log($this->request->data, 'debug');
        if ( !isset($dados->email) || !filter_var($dados->email, FILTER_VALIDATE_EMAIL) ) {
            throw new BadRequestException('Email inválido!', 400);
        }
        
        if ( !isset($dados->password) || $dados->password == '' ) {
            throw new BadRequestException('Senha não informada', 400);
        }

        $email = $dados->email;
        $senha = $dados->password;

        $this->loadModel('Usuario');

        $usuario = $this->Usuario->find('first',array(
            'conditions' => array(
                'Usuario.email' => $email
            )
        ));

        if ( count($usuario) == 0 ) {
            throw new BadRequestException('Login e/ou Senha não conferem.', 401);
        }

        if ( sha1(Configure::read('Security.salt').trim($senha)) != $usuario['Usuario']['senha'] ) {
            throw new BadRequestException('Login e/ou Senha não conferem.', 401);
        }

        unset($usuario['Usuario']['senha']);
        
        $token = $this->busca_app_token($usuario['Usuario']['id']);
        $this->log($token, 'debug');
        if ( !$token ) {
            $token = $this->gera_app_token($usuario['Usuario']['id'], $usuario['Usuario']['email']);
        } else {            
            $token = $this->update_app_token($usuario['Usuario']['id'], $token);
        }
        $this->log($token, 'debug');
        

        if ( !$token ) {
            throw new BadRequestException('Erro ao salvar o Token', 500);
        }
        
        //remove a senha do usuário para não retonrar na api
        unset($usuario['Usuario']['senha']);
        unset($token['Token']['id']);
        $usuario['Usuario']['foto'] = $this->images_path.$usuario['Usuario']['foto'];
        
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'dados' => array_merge($usuario, $token)))));
    }

    public function index() {
        $this->set('title_for_layout', 'Usuários');
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
            "Usuario.nome",
            "Usuario.email",
            "Usuario.ativo",
        );

        $conditions = array();

        $conditions = array_merge($conditions, array("Usuario.id !=" => '1')); // deixar de fora o cadastro do admin

        if ( $this->dataTable->check_filtro("nome","text") === true){
            $conditions = array_merge($conditions, array("Usuario.nome LIKE" => "%".$this->request->data["nome"]."%"));
        }

        if ( $this->dataTable->check_filtro("email","text") === true){
            $conditions = array_merge($conditions, array("Usuario.email LIKE" => "%".$this->request->data["email"]."%"));
        }

        if ( $this->dataTable->check_filtro("ativo","text") === true){
            $conditions = array_merge($conditions, array("Usuario.ativo" => $this->request->data["ativo"]));
        }

        if ( isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc')) {
            $order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];
        }

        $this->loadModel('Usuario');

        $iTotalRecords = $this->Usuario->find('count');

        $iDisplayLength = intval($this->request->data['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($this->request->data['start']);

        $dados = $this->Usuario->find('all',array(
                'conditions' => $conditions,
                'order' => $order,
                'fields' => array(
                    "Usuario.*",
                ),
                'link' => array(),
                'offset' => $iDisplayStart,
                'limit' => $iDisplayLength
            )
        );

        $registrosFiltrados = $this->Usuario->find("count", array(
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

                $radio = '<input type="checkbox" name="id[]" value="'.$dado['Usuario']['id'].'">';

                $nome = $dado['Usuario']['nome'];

                $email = $dado['Usuario']['email'];

                $ativo = ($dado['Usuario']['ativo'] == 'Y')? 'Sim': 'Não';

                $btn_view = ""; // '<a href="'.Router::url(array('controller' => 'Pessoas', 'action' => 'view', $dado['Pessoa']['id'])).'" class="btn btn-icon-only blue" data-toggle=""><i class="fa fa-eye"></i></a>';

                $btn_alterar = '<a href="'.Router::url(array('controller' => 'Usuarios', 'action' => 'alterar', $dado['Usuario']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>';

                $btn_excluir = '<a href="#" class="btn btn-icon-only red btn-remove" data-id="'.$dado['Usuario']['id'].'" title="Excluir"><i class="fa fa-trash-o"></i></a>';

                $actions = "";

                $actions = $btn_view.' '.$btn_alterar.' '.$btn_excluir;

                $records["data"][] = array(
                    $radio,
                    $nome,
                    $email,
                    $ativo,
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

    public function adicionar() {
        $this->set('title_for_layout', 'Adicionar Usuário');
		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
        }
        $this->loadModel('SistemaPermissao');
        $permissoes = $this->SistemaPermissao->listaSistemaPermissaoFiltroActionIndex();
        $this->set(compact('permissoes'));
	}

    private function save() {
        $dados_request = $this->request->data;
        
        if ($dados_request['Usuario']['senha'] != $dados_request['Usuario']['rsenha']) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "As Senhas não coincidem."))));
        }
        unset($dados_request['Usuario']['rsenha']);
        
        $dados_salvar = $dados_request;
        
        if (!empty($dados_request['UsuarioSistemaPermissao'])) {
            $this->loadModel('SistemaPermissao');
            unset($dados_salvar['UsuarioSistemaPermissao']);
            foreach ($dados_request['UsuarioSistemaPermissao'] as $per) {
                $allpermissoes = $this->SistemaPermissao->sistemaPermissaoByControllerIndexId($per['sistema_permissao_id']);
                foreach ($allpermissoes as $permissionID) {
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = $permissionID;
                }
                // if ($per['sistema_permissao_id'] == '3') { // add permissoes invisiveis link com alterar pessoas
                if ($per['sistema_permissao_id'] == '1') { // add permissoes invisiveis link com alterar pessoas
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 25;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 26;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 27;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 28;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 29;
                }
                // if ($per['sistema_permissao_id'] == '19' || $per['sistema_permissao_id'] == '23') { // add permissoes invisiveis link com romaneio alterar
                if ($per['sistema_permissao_id'] == '17') { // add permissoes invisiveis link com romaneio gordo alterar
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 30;
                }
                if ($per['sistema_permissao_id'] == '21') { // add permissoes invisiveis link com romaneio invernar alterar
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 31;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 32;
                }
            }
        }

        $this->loadModel('Usuario');
        $this->Usuario->set($dados_salvar);
        if ( $this->Usuario->validates() ) {       
            // die(debug($dados_salvar));
            $this->Usuario->create();
            if ( $this->Usuario->saveAssociated($dados_salvar) ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Usuário adicionado com sucesso!" ))));
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar adicionar o Usuário. Por favor, tente novamente em alguns instantes." ))));
                //debug($this->Usuario->getDataSource()->getLog(false, false));
            }
        } else {
            return new CakeResponse(
                array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->Usuario->validationErrors[key($this->Usuario->validationErrors)] ) ) ) );
        }

    }

    public function alterar($id = null) {

        $this->set('title_for_layout', 'Alterar Usuário');

        if ( !empty($this->request->data) ) {
            if ( $this->request->data['Usuario']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Usuário a ser alterado não informado."))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        if ($id == null) {
            $this->redirect(array('action' => 'index'));
            die();
        }

        $this->loadModel('Usuario');
        $dados = $this->Usuario->findById($id);

        if (count($dados) <= 0) {
            $this->Session->setFlash('Usuário Incorreto!!!', 'flash_error');
            return $this->routing();
        }

        $this->loadModel('SistemaPermissao');
        $permissoes = $this->SistemaPermissao->listaSistemaPermissaoFiltroActionIndex();
        $this->loadModel('UsuarioSistemaPermissao');
        $userpermissoes = $this->UsuarioSistemaPermissao->sistemaPermissoesByUsuarioId($id);

        $this->set(compact('dados', 'permissoes', 'userpermissoes'));

    }

    public function excluir( $id = null ) {
        $this->layout = 'ajax';

        if ( is_null($id) || !is_numeric($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Usuário não encontrado."))));
        }

        $this->loadModel('Usuario');
        $dados = $this->Usuario->findById($id);

        if ( count($dados) <= 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Usuário que você está tentando excluir não existe."))));
        }

        if ( $this->Usuario->delete($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Usuário excluído com sucesso."))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir o Usuário. Por favor, tente mais tarde."))));   
        }

    }

    public function meusdados() {
        $this->set('title_for_layout', 'Meus Dados');

        if ( !empty($this->request->data) ) {
            if ( $this->request->data['Usuario']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Usuário a ser alterado não informado."))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        $meuId = $this->Auth->user('id');
        $this->loadModel('Usuario');
        $dados = $this->Usuario->findById($meuId);

        if (count($dados) <= 0) {
            $this->Session->setFlash('Usuário Incorreto!!!', 'flash_error');
            return $this->routing();
        }

        $this->set(compact('dados'));
    }

    private function update() {

        $dados_request = $this->request->data;

        if ( !isset($dados_request['Usuario']['id']) ) {   
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Usuário não informado."))));
        }

        $alterar_senha = false;
        if (!isset($dados_request['alterar_senha'])) {
            unset($dados_request['Usuario']['senha']);
            unset($dados_request['Usuario']['rsenha']);
        } else {
            if ($dados_request['Usuario']['senha'] != $dados_request['Usuario']['rsenha']) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "As Senhas não coincidem."))));
            }
            if (strlen($dados_request['Usuario']['senha']) < 6) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Senha muita curta."))));
            }
            $alterar_senha = true;
            unset($dados_request['alterar_senha']);
            unset($dados_request['Usuario']['rsenha']);
        }
        
        $this->loadModel('Usuario');
        $dados = $this->Usuario->findById($dados_request['Usuario']['id']);

        if ( !$dados || count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
        }

        $delPermission = false;
        if (isset($dados_request['permissao']) && is_numeric($dados_request['permissao'])) {
            $delPermission = true;
            unset($dados_request['permissao']);
        }

        $dados_salvar = $dados_request;

        if ($delPermission) {
            $this->loadModel('SistemaPermissao');
            unset($dados_salvar['UsuarioSistemaPermissao']);
            foreach ($dados_request['UsuarioSistemaPermissao'] as $per) {
                $allpermissoes = $this->SistemaPermissao->sistemaPermissaoByControllerIndexId($per['sistema_permissao_id']);
                foreach ($allpermissoes as $permissionID) {
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = $permissionID;
                }
                // if ($per['sistema_permissao_id'] == '3') { // add permissoes invisiveis link com alterar pessoas
                if ($per['sistema_permissao_id'] == '1') { // add permissoes invisiveis link com alterar pessoas
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 25;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 26;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 27;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 28;
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 29;
                }
                // if ($per['sistema_permissao_id'] == '19' || $per['sistema_permissao_id'] == '23') { // add permissoes invisiveis link com romaneio alterar
                if ($per['sistema_permissao_id'] == '17' || $per['sistema_permissao_id'] == '21') { // add permissoes invisiveis link com romaneio alterar
                    $dados_salvar['UsuarioSistemaPermissao'][]['sistema_permissao_id'] = 30;
                }
            }
        }

        $this->Usuario->set($dados_salvar);
        if ( $this->Usuario->validates() ) {
            // die(debug($dados_salvar));
            if ($delPermission) {
                $this->loadModel('UsuarioSistemaPermissao');
                $this->UsuarioSistemaPermissao->deleteAll(array('UsuarioSistemaPermissao.usuario_id' => $dados_salvar['Usuario']['id']), false);
            }
            if ( $this->Usuario->saveAssociated($dados_salvar) ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Dados alterados com sucesso!", 'deslogar' => $alterar_senha))));
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar os Dados. Por favor, tente novamente em alguns instantes.", 'deslogar' => $alterar_senha))));
                //debug($this->Usuario->getDataSource()->getLog(false, false));
            }
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->Usuario->validationErrors[key($this->Usuario->validationErrors)], 'deslogar' => $alterar_senha))));
        }

    }

}
