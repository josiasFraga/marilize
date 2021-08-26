<?php

App::uses('CakeEmail', 'Network/Email');

class PessoasController extends AppController {
	
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
		$this->Auth->allow(['sync']);

	}

	public function sync() {
		
		$this->layout = 'ajax';
		
		$dados = $this->request->query;

		if ( !isset($dados['token']) || empty($dados['token']) ) {
			throw new BadRequestException('Token não informado!', 400);
		}

		if ( !isset($dados['email']) || empty($dados['email']) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL) ) {
			throw new BadRequestException('Usuário não informado!', 400);
		}

		$email = $dados['email'];
		$token = $dados['token'];

		//busca os dados da sessão
		$dados_token = $this->isLogged($email,$token);

		if ( $dados_token['Token']['data_validade'] < date('Y-m-d') ) {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', "msg" => "Usuário não logado. Token Expirado", 'code' => 8))));
		}

		if ( !$dados_token ) {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', "msg" => "Usuário não logado.", 'code' => 9))));
		}

		$this->loadModel('Pessoa');
		$this->loadModel('PessoaLocalidade');
		$this->loadModel('PessoaBanco');

		$pessoas = $this->Pessoa->find('all',[
			'conditions' => ['Pessoa.ativo' => 1],
			'order' => [
				'Pessoa.razao_social'
			],
			'contain' => [],
			'fields' => [
				'Pessoa.*'
			]
		]);

		foreach( $pessoas as $key => $pessoa ) {
			$pessoas[$key]['Localidades'] = $this->PessoaLocalidade->find('all',[
				'conditions' => [
					'PessoaLocalidade.pessoa_id' => $pessoa['Pessoa']['id']
				]
			]);
			$pessoas[$key]['Contas'] = $this->PessoaBanco->findAllBancosByPessoaId($pessoa['Pessoa']['id']);
				
			
			$pessoas[$key]['Pessoa']['cnpj_cpf'] = $pessoas[$key]['Pessoa']['cpf'].$pessoas[$key]['Pessoa']['cnpj'];
			$pessoas[$key]['Pessoa']['foto'] = $this->images_path . $pessoa['Pessoa']['foto'];
			
			$pessoas[$key]['Pessoa']['razao_social'] = $this->remove_accents($pessoas[$key]['Pessoa']['razao_social']);
			$pessoas[$key]['Pessoa']['nome_fantasia'] = $this->remove_accents($pessoas[$key]['Pessoa']['nome_fantasia']);
		}

		return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "pessoas" => $pessoas))));
	}

	private function remove_accents($string) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    $chars = array(
    // Decompositions for Latin-1 Supplement
    chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
    chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
    chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
    chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
    chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
    chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
    chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
    chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
    chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
    chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
    chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
    chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
    chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
    chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
    chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
    chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
    chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
    chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
    chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
    chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
    chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
    chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
    chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
    chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
    chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
    chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
    chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
    chr(195).chr(191) => 'y',
    // Decompositions for Latin Extended-A
    chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
    chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
    chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
    chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
    chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
    chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
    chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
    chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
    chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
    chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
    chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
    chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
    chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
    chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
    chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
    chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
    chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
    chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
    chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
    chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
    chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
    chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
    chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
    chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
    chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
    chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
    chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
    chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
    chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
    chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
    chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
    chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
    chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
    chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
    chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
    chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
    chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
    chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
    chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
    chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
    chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
    chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
    chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
    chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
    chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
    chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
    chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
    chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
    chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
    chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
    chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
    chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
    chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
    chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
    chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
    chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
    chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
    chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
    chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
    chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
    chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
    chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
    chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
    chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
    );

    $string = strtr($string, $chars);

    return $string;
}

	public function index($tipo = 'clientes') {
		$this->Session->write('menu_pessoas', $tipo);
		$this->set('title_for_layout', 'Pessoas');
		if ( $this->request->is('post') ) {
			$this->layout = "ajax";
			return $this->dataTable($tipo);
		}
	}

	private function dataTable($tipo) {

		$this->layout = "ajax";

		if ( !$this->request->is('post') || empty($this->request->data) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Requisição inválida!'))));
		}

		if ( isset($this->request->data['order']) ) $order = $this->request->data['order'];

		$arr_columns_order = array(
			'',
			"Pessoa.razao_social",
			"Pessoa.nome_fantasia",
			"Pessoa.telefone1",
			"Pessoa.telefone2",
		);

		$conditions = array('Pessoa.ativo' => 1);

		// $conditions = array_merge($conditions, array("Pessoa.id !=" => '1')); // deixar de fora o cadastro do admin

		if ( $this->dataTable->check_filtro("razao_social","text") === true){
			$conditions = array_merge($conditions, array("Pessoa.razao_social LIKE" => "%".$this->request->data["razao_social"]."%"));
		}

		if ( $this->dataTable->check_filtro("nome_fantasia","text") === true){
			$conditions = array_merge($conditions, array("Pessoa.nome_fantasia LIKE" => "%".$this->request->data["nome_fantasia"]."%"));
		}

		if ( $this->dataTable->check_filtro("telefone1","numeric") === true){
			$conditions = array_merge($conditions, array("Pessoa.telefone1" => "%".$this->request->data["telefone1"]."%"));
		}

		if ( $this->dataTable->check_filtro("telefone2","text") === true){
			$conditions = array_merge($conditions, array("Pessoa.telefone2" => "%".$this->request->data["telefone2"]."%"));
		}

		if ($tipo == 'clientes') {
			$conditions = array_merge($conditions, array("Pessoa.tipo_pessoa_id" => 1));
		} else if ($tipo == 'fornecedores') {
			$conditions = array_merge($conditions, array("Pessoa.tipo_pessoa_id" => 2));
		}

		if ( isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc')) {
			$order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];
		}

		$this->loadModel('Pessoa');

		$iTotalRecords = $this->Pessoa->find('count', [
			'conditions' => [
				'Pessoa.ativo' => 1
			]
		]);

		$iDisplayLength = intval($this->request->data['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = intval($this->request->data['start']);

		$dados = $this->Pessoa->find('all',array(
			'conditions' => $conditions,
			'order' => $order,
			'fields' => array(
				"Pessoa.*",
			),
			'link' => array(),
			'offset' => $iDisplayStart,
			'limit' => $iDisplayLength
		));

		$registrosFiltrados = $this->Pessoa->find("count", array(
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

				$radio = '<input type="checkbox" name="id[]" value="'.$dado['Pessoa']['id'].'">';

				$razao_social = $dado['Pessoa']['razao_social'];

				$nome_fantasia = $dado['Pessoa']['nome_fantasia'];

				$telefone1 = $dado['Pessoa']['telefone1'];

				$telefone2 = $dado['Pessoa']['telefone2'];

				$btn_view = ""; // '<a href="'.Router::url(array('controller' => 'Pessoas', 'action' => 'view', $dado['Pessoa']['id'])).'" class="btn btn-icon-only blue" data-toggle=""><i class="fa fa-eye"></i></a>';

				$btn_alterar = '<a href="'.Router::url(array('controller' => 'Pessoas', 'action' => 'alterar', $dado['Pessoa']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>';

				$btn_excluir = '<a href="#" class="btn btn-icon-only red btn-remove" data-id="'.$dado['Pessoa']['id'].'"><i class="fa fa-trash"></i></a>';

				$actions = "";

				$actions = $btn_view.' '.$btn_alterar.' '.$btn_excluir;

				$records["data"][] = array(
					$radio,
					$razao_social,
					$nome_fantasia,
					$telefone1,
					$telefone2,
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
		$this->set('title_for_layout', 'Adicionar Pessoa');
		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
		}

		$this->loadModel('PessoaTipo');
		$listaPessoaTipo = $this->PessoaTipo->listaPessoaTipo();
		$this->set(compact('listaPessoaTipo'));
	}

	private function save() {

		$dados_request = $this->request->data;

		unset($dados_request['aux']);

		$cpf = trim($dados_request['Pessoa']['cpf']);
		$cnpj = trim($dados_request['Pessoa']['cnpj']);

		if (!empty($cnpj) && !empty($cpf)) {
			$dados_request['Pessoa']['cnpj_cpf'] = $cnpj;
		} else if (!empty($cnpj) && empty($cpf)) {
			$dados_request['Pessoa']['cnpj_cpf'] = $cnpj;
		} else if (empty($cnpj) && !empty($cpf)) {
			$dados_request['Pessoa']['cnpj_cpf'] = $cpf;
		}
		if (empty($cpf) && empty($cnpj)) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "O CPF ou O CNPJ deve ser informado!" ))));
		} else if (!empty($cpf) && strlen($cpf) < 14) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "CPF inválido!" ))));
		} else if (!empty($cnpj) && strlen($cnpj) < 18) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "CNPJ inválido!" ))));
		}


		$this->loadModel('Pessoa');
		$conditions_pessoa = [
			'OR' => [],
			'Pessoa.tipo_pessoa_id' => $dados_request['Pessoa']['tipo_pessoa_id'],
			'Pessoa.ativo' => 1
		];

		if (!empty($cpf) && empty($cnpj)) {
			$conditions_pessoa['OR']['Pessoa.cpf'] = $cpf;
		} else if (empty($cpf) && !empty($cnpj)) {
			$conditions_pessoa['OR']['Pessoa.cnpj'] = $cnpj;
		} else {
			$conditions_pessoa['OR']['Pessoa.cpf'] = $cpf;
			$conditions_pessoa['OR']['Pessoa.cnpj'] = $cnpj;
		}

		$pessoa_existente = $this->Pessoa->find('count', [
			'conditions' => $conditions_pessoa
		]);
		if ($pessoa_existente > 0) {
			if ($dados_request['Pessoa']['tipo_pessoa_id'] == 1) {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "Já existe um cliente com este CPF/CNPJ!" ))));
			} else if ($dados_request['Pessoa']['tipo_pessoa_id'] == 2) {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "Já existe um fornecedor com este CPF/CNPJ!" ))));
			}
		}


		$this->Pessoa->set($dados_request);

		if ( $this->Pessoa->validates() ) {       
			// die(debug($dados_request));
			$this->Pessoa->create();
			if ( $this->Pessoa->saveAssociated($dados_request) ) {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Cadastro realizado com sucesso!" ))));
			} else {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar o Cadastro. Por favor, tente novamente em alguns instantes." ))));
				//debug($this->Pessoa->getDataSource()->getLog(false, false));
			}
		} else {
			return new CakeResponse(
				array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->Pessoa->validationErrors[key($this->Pessoa->validationErrors)] ) ) ) );
		}

	}

	public function view($id = null) {

		if ( !empty($this->request->data) ) {
			if ( $this->request->data['Pessoa']['id'] == null ){
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Pessoa não informada."))));
			}

			$this->layout = "ajax";
		}

		if ($id == null) {
			$this->redirect(array('action' => 'index'));
			die();
		}

		$this->set('title_for_layout', 'Visualização');

		$this->loadModel('Pessoa');
		$dados = $this->Pessoa->findById($id);
		
		if ( count($dados) == 0 || !$dados['Pessoa']['ativo']) {
			echo 'Os dados da Pessoa não foram encontrados.';
			die();
		}

		$this->set(compact('dados'));

		// debug($dados); die();

	}

	public function alterar($id = null) {

		$this->set('title_for_layout', 'Alterar Pessoa');

		if ( !empty($this->request->data) ) {
			if ( $this->request->data['Pessoa']['id'] == null ){
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Pessoa a ser alterada não informada."))));
			}
			$this->layout = "ajax";
			return $this->update();
		}

		if ($id == null) {
			$this->redirect(array('action' => 'index'));
			die();
		}

		$this->loadModel('Pessoa');
		$dados = $this->Pessoa->findById($id);
		$this->loadModel('PessoaBanco');
		$dados['bancos'] = $this->PessoaBanco->findAllBancosByPessoaId($id);
		$this->loadModel('PessoaLocalidade');
		$dados['localidades'] = $this->PessoaLocalidade->findAllLocalidadesByPessoaId($id);

		if (count($dados) == 0 || !$dados['Pessoa']['ativo']) {
			echo 'Os dados não foram encontrados.';
			die();
		}

		$this->loadModel('PessoaTipo');
		$listaPessoaTipo = $this->PessoaTipo->listaPessoaTipo();

		$this->set(compact('dados', 'listaPessoaTipo'));

	}

	public function imprimir($tipo) {
		$this->layout = 'pdf';

		

		if ($tipo == 'clientes') {
			$tipo = 1;
		} else if ($tipo == 'fornecedores') {
			$tipo = 2;
		}

		$this->loadModel('Pessoa');
		if ($tipo == 2) {
			$pessoas = $this->Pessoa->find('all', [
				'fields' => [
					'Pessoa.nome_fantasia',
					'Pessoa.observacoes',
					'PessoaBanco.banco',
					'PessoaBanco.titular',
					'PessoaBanco.agencia',
					'PessoaBanco.conta',
					'PessoaBanco.cpf',
					'PessoaBanco.cnpj',
					'Pessoa.tipo_pessoa_id'
				],
				'conditions' => [
					'Pessoa.tipo_pessoa_id' => $tipo,
					'Pessoa.ativo' => 1
				],
				'link' => 'PessoaBanco',
				'order' => 'Pessoa.nome_fantasia',
			]);
		} else if ($tipo == 1) {
			$pessoas = $this->Pessoa->find('all', [
				'fields' => [
					'Pessoa.nome_fantasia',
					'Pessoa.cpf',
					'Pessoa.cnpj',
					'Pessoa.telefone1',
					'Pessoa.telefone2',
					'Pessoa.id'
				],
				'conditions' => [
					'Pessoa.tipo_pessoa_id' => $tipo,
					'Pessoa.ativo' => 1
				],
				'limit' => 20,
				'order' => 'Pessoa.nome_fantasia',
			]);

			foreach ($pessoas as $key => $pessoa) {
				$pessoas[$key]['_localidades'] = $this->Pessoa->PessoaLocalidade->find('all', [
					'conditions' => [
						'PessoaLocalidade.pessoa_id' => $pessoa['Pessoa']['id']
					]
				]);
				$pessoas[$key]['_contas'] = $this->Pessoa->PessoaBanco->find('all', [
					'conditions' => [
						'PessoaBanco.pessoa_id' => $pessoa['Pessoa']['id']
					]
				]);
			}
		}


		$this->set(compact('pessoas', 'tipo'));


        $this->Mpdf->init();
$this->Mpdf->packTableData  = true; // necessario pq não gerava pq tinha mt registro
        $this->Mpdf->setFilename('file.pdf');
        $this->Mpdf->setOutput('I');
        $this->Mpdf->SetFooter("Marilize - Fornecedores");
		$this->Mpdf->SetWatermarkText("Draft");
		
	}

	public function imprimirConta($id) {
		$this->layout = 'pdf';

		


		$this->loadModel('PessoaBanco');
		$conta = $this->PessoaBanco->find('first', [
			'fields' => [
				'PessoaBanco.banco',
				'PessoaBanco.titular',
				'PessoaBanco.agencia',
				'PessoaBanco.conta',
				'PessoaBanco.cpf',
				'PessoaBanco.cnpj'
			],
			'conditions' => [
				'PessoaBanco.id' => $id
			]
		]);
		$this->set(compact('conta'));


        $this->Mpdf->init();
$this->Mpdf->packTableData  = true; // necessario pq não gerava pq tinha mt registro
        $this->Mpdf->setFilename('file.pdf');
        $this->Mpdf->setOutput('I');
        $this->Mpdf->SetFooter("Marilize - Conta Bancária");
		$this->Mpdf->SetWatermarkText("Draft");
		
	}

	private function update() {

		$this->loadModel('Pessoa');

		if ( !isset($this->request->data['Pessoa']['id']) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Pessoa não informada."))));
		}

		$dados_request = $this->request->data;

		unset($dados_request['aux']);

		$cpf = trim($dados_request['Pessoa']['cpf']);
		$cnpj = trim($dados_request['Pessoa']['cnpj']);

		if (!empty($cnpj) && !empty($cpf)) {
			$dados_request['Pessoa']['cnpj_cpf'] = $cnpj;
		} else if (!empty($cnpj) && empty($cpf)) {
			$dados_request['Pessoa']['cnpj_cpf'] = $cnpj;
		} else if (empty($cnpj) && !empty($cpf)) {
			$dados_request['Pessoa']['cnpj_cpf'] = $cpf;
		}
		if (empty($cpf) && empty($cnpj)) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "O CPF ou O CNPJ deve ser informado!" ))));
		} else if (!empty($cpf) && strlen($cpf) < 14) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "CPF inválido!" ))));
		} else if (!empty($cnpj) && strlen($cnpj) < 18) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "CNPJ inválido!" ))));
		}

		$dados = $this->Pessoa->findById($dados_request['Pessoa']['id']);

		if ( !$dados || count($dados) == 0 ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
		}

		$this->Pessoa->set($dados_request);
		
		if ( $this->Pessoa->validates() ) {
			// die(debug($dados_request));
			if ( $this->Pessoa->saveAssociated($dados_request) ) {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Pessoa alterada com sucesso!"))));
			} else {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar o Pessoa. Por favor, tente novamente em alguns instantes."))));
				//debug($this->Pessoa->getDataSource()->getLog(false, false));
			}
		} else {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->Pessoa->validationErrors[key($this->Pessoa->validationErrors)] ))));
		}

	}

	public function excluir( $id = null ) {

		$this->layout = 'ajax';

		if ( $id == null || !is_numeric($id) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado."))));
		}

		$this->loadModel('Pessoa');
		$dados = $this->Pessoa->findById($id);

		if ( count($dados) == 0 ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "A Pessoa que você está tentando excluir não existe."))));
		}

		if ( $this->Pessoa->delete($id) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Pessoa excluída com sucesso."))));
		} else {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir a Pessoa. Por favor, tente mais tarde."))));   
		}

	}

}
