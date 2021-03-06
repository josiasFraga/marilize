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

	}

	public function index() {
		$this->set('title_for_layout', 'Pessoas');
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
			"PessoaTipo.tipo_pessoa",
			"Pessoa.razao_social",
			"Pessoa.nome_fantasia",
			"",
			"",
		);

		$conditions = array('Pessoa.ativo' => 1);

		// $conditions = array_merge($conditions, array("Pessoa.id !=" => '1')); // deixar de fora o cadastro do admin

		if ( $this->dataTable->check_filtro("tipo","text") === true){
			$conditions = array_merge($conditions, array("Pessoa.tipo_pessoa_id" => $this->request->data["tipo"]));
		}

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
				"Pessoa.*", 'PessoaTipo.*'
			),
			'link' => array('PessoaTipo'),
			'offset' => $iDisplayStart,
			'limit' => $iDisplayLength
		));

		$registrosFiltrados = $this->Pessoa->find("count", array(
			'conditions' => $conditions,
			'link' => array('PessoaTipo')
		));

		// die(debug($dados));

		$iRecordsFiltered = $registrosFiltrados;
		$sEcho = intval($this->request->data['draw']);
		$records = array();
		$records["data"] = array();
		if ( count($dados) > 0 ) {
			foreach ( $dados as $dado ) {

				$radio = '<input type="checkbox" name="id[]" value="'.$dado['Pessoa']['id'].'">';

				$tipo = $dado['PessoaTipo']['tipo_pessoa'];

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
					$tipo,
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
		$this->loadModel('PessoaGrupo');
		$listaPessoaGrupo = $this->PessoaGrupo->listaPessoaGrupo();
		$this->set(compact('listaPessoaTipo', 'listaPessoaGrupo'));
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



		$this->loadModel('Pessoa');
		$conditions_pessoa = [
			'OR' => [],
			'Pessoa.tipo_pessoa_id' => $dados_request['Pessoa']['tipo_pessoa_id'],
			'Pessoa.ativo' => 1
		];


		$this->Pessoa->set($dados_request);

		if ( $this->Pessoa->validates() ) {       
			// die(debug($dados_request));
			$this->Pessoa->create();
			$dados_pessoa = $this->Pessoa->saveAssociated($dados_request);
			if ( $dados_pessoa ) {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Cadastro realizado com sucesso!", 'id' => $this->Pessoa->getInsertID() ))));
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
		$this->loadModel('PessoaGrupo');
		$listaPessoaGrupo = $this->PessoaGrupo->listaPessoaGrupo();

		$this->set(compact('dados', 'listaPessoaTipo', 'listaPessoaGrupo'));

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
