<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
 	public $month_arr = ['','Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
	public $images_path = "https://orelhano.com.br/sistema/img/";
 	
    public $components = array(
        // 'DebugKit.Toolbar',
		'Session',
		'Auth' => array(
			'authorize' => array('Controller'),
			'logoutRedirect' => array(
				'controller' => 'login',
				'action' => 'entrar'
			),
			'loginAction' => array(
				'controller' => 'login',
				'action' => 'entrar'
			),
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'Usuario',
					'fields' => array(
						'username' => 'email',
						'password' => 'senha'
					)
				)
			)
		)
	);


	public function update_app_token( $usuario_id = null, $dados_token = null ) {

		if ( $usuario_id == null || $dados_token == null ) {
			return false;
		}

		$dados_salvar = array(
			'Token' => array(
				'id' => $dados_token['Token']['id'],
				'token' => $dados_token['Token']['token'],
				'usuario_id' => $usuario_id,
				'data_validade' => date('Y-m-d', strtotime(date("Y-m-d"). ' + 30 days'))
			)
		);

		$this->loadModel('Token');
		$this->Token->set($dados_salvar);
		if ( $this->Token->save() )
			return $dados_salvar;
		else {
			return false;
		}
	}

	public function isLogged( $usuario_email = null, $token = null ){

		if ( $usuario_email == null || $token == null ) {
			return false;
		}

		$this->loadModel('Token');
		$dados_token = $this->Token->find('first',array(
			'fields' => array('Token.*', 'Usuario.id'),
			'conditions' => array(
				'Token.token' => $token,
				'Usuario.email' => $usuario_email
			),
			'link' => 'Usuario'
		));

		if ( count($dados_token) == 0 ) {
			return false;
		}

		return $dados_token;
	}

	public function gera_app_token($usuario_id = null, $usuario_email = null) {

		if ($usuario_email == null || $usuario_id == null) {
			return false;
		}

		$this->loadModel('Token');

		$token = md5(uniqid($usuario_email, true));
		$dados_salvar = array(
			'Token' => array(
				'token' => $token,
				'usuario_id' => $usuario_id,
				'data_validade' => date('Y-m-d', strtotime(date("Y-m-d"). ' + 30 days'))
			)
		);

		$this->Token->create();
		$this->Token->set($dados_salvar);
		
		return $this->Token->save();
	}

	public function busca_app_token($usuario_id = null) {

		$conditions = [
			'Token.usuario_id' => $usuario_id,
			'Token.data_validade >=' => date('Y-m-d')
		];

		$this->loadModel('Token');
		$dados_token = $this->Token->find('first',array(
			'conditions' => $conditions
		));

		if ( count($dados_token) == 0 )
			return false;
		else
			return $dados_token;
	}

	public function routing() {
		return $this->redirect(array('controller' => 'Dashboard', 'action' => 'index'));
	}

	public function beforeRender() {
		$this->set('version', '1.0');
		$usuario_foto = null; // $this->Auth->user('foto');
		$usuario_nivel = $this->Auth->user('role');
		$favicon = 'favicon.png';
		$logo = 'logo.png';

		$menu_pessoas = '';
		if ($this->Session->read('menu_pessoas')) {
			$menu_pessoas = $this->Session->read('menu_pessoas');
		}

		$this->set(compact('usuario_foto', 'usuario_nivel', 'favicon', 'logo', 'menu_pessoas'));
	}

	public function dateBrEn( $data ) {
		$data = explode("/",$data);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$data = date("Y-m-d", strtotime($data));
		return $data;
	}

	public function dateBrEnDois( $data ) {
		$data = explode("-",$data);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$data = date("Y-m-d", strtotime($data));
		return $data;
	}

	public function dateEnBr( $data ) {
		$data = date("d/m/Y", strtotime($data));
		return $data;
	}

	public function beforeFilter() {
		// Impedir de acessar a página de login quando está logado
		$allowed = array(
			'Login' => array('entrar'),
			// 'Clientes' => array('cadastro')
		);
		if ( !$this->Auth->loggedIn() ) { return; }

		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
                $this->routing();
			}
		}
	}

	public function isAuthorized($user) {
		// Admin pode acessar todas as actions
		if (isset($user['role']) && $user['role'] == 'admin') {
			return true;
		}
		$this->loadModel('SistemaPermissao');
        $sistemapermite = $this->SistemaPermissao->sistemaPermissaoByControllerAndAction(strtolower($this->name), strtolower($this->request->action));
		$this->loadModel('UsuarioSistemaPermissao');
		$userpermissoes = $this->UsuarioSistemaPermissao->sistemaPermissoesByUsuarioId($user['id']);
		if (in_array($sistemapermite, $userpermissoes)) {
			return true;
		}
		// Bloqueia acesso por padrão
		return false;
	}

	public function email_receiver() {
		return array();
	}

	public function dateTimeEnBr( $data ) {
		$data = date("d/m/Y H:i:s", strtotime($data));
		return $data;
	}

	public function dateTimeBrEn( $data_tempo ) {
		list($data,$hora) = explode(" - ",$data_tempo);
		list($dia,$mes,$ano) = explode('/',$data);
		return $ano."-".$mes."-".$dia." ".$hora;
	}

	public function addSlug($slug) {

		if (is_string($slug)) {
			$slug = strtolower(trim(utf8_decode($slug)));
			$before = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
			$after  = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
			$slug = strtr($slug, utf8_decode($before), $after);
			$replace = array('/[^a-z0-9.-]/' => '-', '/-+/' => '-', '/\-{2,}/' => '');
			$slug = preg_replace(array_keys($replace), array_values($replace), $slug);
		}

		return $slug;

	}

	public function horaParaMinuto( $hora ) {
		$tempo = explode(':', $hora);
		$minutos = $tempo[0] * 60;
		$minutos+= $tempo[1];
		return $minutos;
	}

	public function minutoParaHora( $minuto ) {
		$horas = floor($minuto / 60);
		$minutos = ($minuto % 60);
		return str_pad($horas, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
	}

	public function currencyToFloat($currency) {
		if (!is_float($currency) && preg_match('/\D/', $currency)) {
			return (float) preg_replace('/\D/', '', $currency) / 100;
		}
		return $currency;
	}

	public function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false ) {

        $valor = $this->currencyToFloat( $valor );

        $singular = null;
        $plural = null;

        if ( $bolExibirMoeda ) {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        } else {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");


        if ( $bolPalavraFeminina ) {
            if ($valor == 1)  {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            } else  {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");            
        }

		$z = 0;

        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );

        for ( $i = 0; $i < count( $inteiro ); $i++ ){
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        $rt = mb_substr( $rt, 1 );

        return($rt ? trim( $rt ) : "zero");

	}
	
	public function dateToString($date){
		$days_week_arr = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
		$month_arr = ['','Janeiro','Fevereiro','Maço','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
		$date_list = explode("-",$date);
		return $days_week_arr[(int)date('w', strtotime($date))].', '.$date_list[2].' de '.$month_arr[(int)$date_list[1]].' de '.$date_list[0];
    }
    
}
