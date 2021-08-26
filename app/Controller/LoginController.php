<?php

// App::uses('CakeEmail', 'Network/Email');

class LoginController extends AppController {

	public function isAuthorized($user = null) {
		return true;
	}

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('entrar', 'logout');
	}
	
	public $uses = array('User');

	public function senha() {
		exit(debug(AuthComponent::password('sdfsdf')));		
	}

	public function entrar() {
		$this->layout = null;
		// exit(debug(AuthComponent::password('zap123')));

		if ( $this->request->is('post') ) {
			// die(debug($this->request->data));
			$this->loadModel('Usuario');
			$ativo = $this->Usuario->isAtivo($this->request->data['Usuario']['email']);
			if ($ativo) {
				if ($this->Auth->login()) {
					return $this->routing();
				} else {
					$this->Session->setFlash('Usuário ou senha incorretos.', 'flash_error');
					return $this->redirect(array('controller' => 'login', 'action' => 'entrar'));
				}
			} else {
				$this->Session->setFlash('Usuário ou senha incorretos.', 'flash_error');
				return $this->redirect(array('controller' => 'login', 'action' => 'entrar'));
			}
		}
	}

	public function deslogar() {
		return $this->redirect($this->Auth->logout());
	}

}