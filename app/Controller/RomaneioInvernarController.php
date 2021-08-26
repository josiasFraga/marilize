<?php

App::uses('RomaneioController', 'Controller');

class RomaneioInvernarController extends RomaneioController {


	public $components = array(
		'Mpdf.Mpdf',
		'dataTable'
	);


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

	public function index() {
		$this->set('title_for_layout', 'Romaneios Invernar');
		if ( $this->request->is('post') ) {
			$this->layout = "ajax";
			return $this->_dataTable();
		}
	}

	   public function imprimir() {
		$this->layout = 'pdf';

		$this->set('title_for_layout', 'Romaneios Invernar');

		$dados = $this->Session->read('invernar_filtro');
		if (!isset($dados)) {
			echo "Por favor, realize o filtro na tela anterior e tente novamente.";
			die();
		}

		unset($dados['offset']);
		unset($dados['limit']);
		//unset($dados['order']);

		$this->loadModel('Romaneio');

		$itens = $this->Romaneio->find('all', array_merge($dados, [
			'order' => ['Romaneio.data_emissao', 'Romaneio.numero']
		]));

		foreach ($itens as $key => $val) {
		$this->Romaneio->RomaneioItem->virtualFields['_total_cabecas'] = 'SUM(RomaneioItem.cabecas)';

			$total_cab = $this->Romaneio->RomaneioItem->find('first', [
				'fields' => ['RomaneioItem._total_cabecas'],
				'conditions' => [
					'RomaneioItem.romaneio_id' => $val['Romaneio']['id']
				]
			]);

			$itens[$key]['Romaneio']['_cabecas'] = $total_cab['RomaneioItem']['_total_cabecas'];

			$pgtos_vendedor = $this->Romaneio->RomaneioVencimento->find('all', [
				'conditions' => [
					'RomaneioVencimento.romaneio_id' => $val['Romaneio']['id'],
				]
			]);
			if (count($pgtos_vendedor) == 1) {
				if ($pgtos_vendedor[0]['RomaneioVencimento']['pago'] == 0) {
					$itens[$key]['Romaneio']['_pgto'] = date('d/m/Y', strtotime($pgtos_vendedor[0]['RomaneioVencimento']['vencimento_em']));
				} else {
					$itens[$key]['Romaneio']['_pgto'] = '0 PENDENTES';

				}
			} else if (count($pgtos_vendedor) > 1) {
				$qtd_parcelas_aberto = 0;
				foreach ($pgtos_vendedor as $pgto) {
					if ($pgto['RomaneioVencimento']['pago'] == 0) {
						$qtd_parcelas_aberto++;
					}
				}
				$itens[$key]['Romaneio']['_pgto'] = $qtd_parcelas_aberto . ' PENDENTES';

			} else if (count($pgtos_vendedor) == 0) {
				$itens[$key]['Romaneio']['_pgto'] = 'N/I';

			}
		}

		$this->Mpdf->init();

		// setting filename of output pdf file
		$this->Mpdf->setFilename('file.pdf');

		// setting output to I, D, F, S
		$this->Mpdf->setOutput('I');
		$this->Mpdf->SetFooter("Orelhano - Romaneios");

		// you can call any mPDF method via component, for example:
		$this->Mpdf->SetWatermarkText("Draft");

		$this->set(compact('itens'));
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

		$this->loadModel('Romaneio');

		$this->Romaneio->virtualFields['total_cabecas'] = "SUM(RomaneioItem.cabecas)";
		$this->Romaneio->virtualFields['numero_formatado'] = "CAST(Romaneio.numero AS UNSIGNED)";

		$dados = $this->Romaneio->find('all',[
			'conditions' => [
				'Romaneio.tipo' => 1
			],
			'fields' => [
				'Romaneio.data_emissao',
				'Romaneio.total_cabecas',
				'Romaneio.comissao_comprador_valor',
				'Romaneio.comissao_comprador_data_pgto',
				'Romaneio.valor_liquido',
				'Romaneio.comissao_vendedor_valor',
				'Romaneio.comissao_vendedor_data_pgto',
				'Pessoa.nome_fantasia',
				'PessoaVendedor.nome_fantasia',
				'Romaneio.comissao_vendedor_pago',
				'Romaneio.comissao_comprador_pago',
				'Romaneio.comprador_id',
				'Romaneio.vendedor_id'
			],
			'group' => ['Romaneio.id'],
			'link' => ['RomaneioItem', 'Pessoa', 'PessoaVendedor'],
			'order' => ['Romaneio.data_emissao', 'Romaneio.numero_formatado'],
		]);

		$thead = ['Data', 'Quant', 'Vencto', 'Valor de Venda', 'Comprador', 'Comissão', 'PGTO', 'Vendedor', 'Comissão', 'PGTO'];
		$widthArr = [90, 50, 90, 130, 250, 130, 50, 250, 130, 50];
		
		//precisei criar essa var prq a ordem dos campos estava cagada
		$dados_retornar = ['dados' => [], 'thead' => $thead, 'widthArr' => $widthArr, 'totais' => []];

		$total_quantidade = 0;
		$total_valor_venda = 0;
		$total_comissao_comprador = 0;
		$total_comissao_vendedor = 0;

		foreach( $dados as $key => $dado ){
			$dados_retornar['dados'][$key]['Romaneio']['data_emissao'] = $this->dateEnBr($dado['Romaneio']['data_emissao']);
			//$dados[$key]['totais']['comissao_comprador_valor'] = $dado['Romaneio']['comissao_comprador_valor'];
			//$dados[$key]['totais']['valor_liquido'] = $dado['Romaneio']['valor_liquido'];
			$dados_retornar['dados'][$key]['anomes'] = date('Y',strtotime($dado['Romaneio']['data_emissao'])).(int)date('m',strtotime($dado['Romaneio']['data_emissao']));
			$dados_retornar['dados'][$key]['Romaneio']['total_cabecas'] = $dado['Romaneio']['total_cabecas'];
			$dados_retornar['dados'][$key]['Romaneio']['comissao_comprador_data_pgto'] = $this->dateEnBr($dado['Romaneio']['comissao_comprador_data_pgto']);
			$dados_retornar['dados'][$key]['Romaneio']['valor_liquido'] = 'R$ '.number_format($dado['Romaneio']['valor_liquido'], 2,',','.');
			$dados_retornar['dados'][$key]['Romaneio']['comprador'] = $dado['Pessoa']['nome_fantasia'];
			$dados_retornar['dados'][$key]['Romaneio']['comissao_comprador_valor'] = 'R$ '.number_format($dado['Romaneio']['comissao_comprador_valor'], 2,',','.');
			$dados_retornar['dados'][$key]['Romaneio']['comprador_PGTO'] = $dado['Romaneio']['comissao_comprador_pago'] == 1 ? 'ok' : '';
			$dados_retornar['dados'][$key]['Romaneio']['vendedor'] = $dado['PessoaVendedor']['nome_fantasia'];
			$dados_retornar['dados'][$key]['Romaneio']['comissao_vendedor_valor'] = 'R$ '.number_format($dado['Romaneio']['comissao_vendedor_valor'], 2,',','.');
			$dados_retornar['dados'][$key]['Romaneio']['vendedor_PGTO'] = $dado['Romaneio']['comissao_vendedor_pago'] == 1 ? 'ok' : '';
			$dados_retornar['dados'][$key]['comprador_id'] = $dado['Romaneio']['comprador_id'];
			$dados_retornar['dados'][$key]['vendedor_id'] = $dado['Romaneio']['vendedor_id'];

			$dados_retornar['dados'][$key]['total_cabecas'] = (float)$dado['Romaneio']['total_cabecas'];
			$dados_retornar['dados'][$key]['valor_liquido'] = (float)$dado['Romaneio']['valor_liquido'];
			$dados_retornar['dados'][$key]['comissao_comprador_valor'] = (float)$dado['Romaneio']['comissao_comprador_valor'];
			$dados_retornar['dados'][$key]['comissao_vendedor_valor'] = (float)$dado['Romaneio']['comissao_vendedor_valor'];
			$total_quantidade += $dado['Romaneio']['total_cabecas'];
			$total_valor_venda += $dado['Romaneio']['valor_liquido'];
			$total_comissao_comprador += $dado['Romaneio']['comissao_comprador_valor'];
			$total_comissao_vendedor += $dado['Romaneio']['comissao_vendedor_valor'];
			
		}

		$dados_retornar['totais'] = [
			'',
			number_format($total_quantidade,0,',','.'),
			'',
			'R$ '.number_format($total_valor_venda,2,',','.'),
			'',
			'R$ '.number_format($total_comissao_comprador,2,',','.'),
			'',
			'',
			'R$ '.number_format($total_comissao_vendedor,2,',','.'),
			''
		];

		return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "romaneios_invernar" => $dados_retornar))));
	}

	
    public function excluir($id) {
        $this->loadModel('Romaneio');
        $this->loadModel('RomaneioItem');

        if ($id == '') {
            $this->Session->setFlash('Erro ao excluir romaneio.', 'flash_error');
            return $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        }

		
        $usuario_id = $this->Auth->user('id');
        $this->loadModel('Log');
        $this->Log->create();
        $this->Log->save([
            'usuario_id' => $usuario_id,
            'descricao' => 'Deletou o romaneio '.$id
        ]);
        
		
        $this->RomaneioItem->deleteAll(['RomaneioItem.romaneio_id' => $id]);
        $this->Romaneio->deleteAll(['Romaneio.id' => $id]);

        $this->Session->setFlash('Romaneio removido com sucesso!', 'flash_success');
        return $this->redirect(array('controller' => $this->name, 'action' => 'index'));
    }


	private function _dataTable() {

		if ( !$this->request->is('post') || empty($this->request->data) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Requisição inválida!'))));
		}

		if ( isset($this->request->data['order']) ) $order = $this->request->data['order'];

		$arr_columns_order = array(
			'',
			"Romaneio.data_emissao",
			"Romaneio.numero",
			"Pessoa.nome_fantasia",
			'Romaneio.comissao_comprador_valor',
			'PessoaVendedor.nome_fantasia',
			'Romaneio.comissao_vendedor_valor',
			'Romaneio.valor_liquido'
		);

		$conditions = array("Romaneio.tipo" => 1);
		

		if (empty($this->request->data['data_mes']) && empty($this->request->data['data_ano'])) {
			$conditions = array_merge($conditions, array("MONTH(Romaneio.data_emissao)" => date('m')));
			$conditions = array_merge($conditions, array("YEAR(Romaneio.data_emissao)" => date('Y')));
		} else {

			if ( $this->dataTable->check_filtro("data_mes", "numeric") === true) {
				$conditions = array_merge($conditions, array("MONTH(Romaneio.data_emissao)" => $this->request->data['data_mes']));
			}

			if ( $this->dataTable->check_filtro("data_ano", "numeric") === true) {
				$conditions = array_merge($conditions, array("YEAR(Romaneio.data_emissao)" => $this->request->data['data_ano']));
			}
		}

		if ( $this->dataTable->check_filtro("nromaneio","text") === true){
			$conditions = array_merge($conditions, array("Romaneio.numero LIKE" => "%".$this->request->data["nromaneio"]."%"));
		}

		if ( ($this->dataTable->check_filtro("comprador","text") === true) && ($this->dataTable->check_filtro("vendedor","text") === true) ) {
			// $conditions = array_merge($conditions, array('or' => array("Pessoa.razao_social LIKE" => "%".$this->request->data["comprador"]."%", "Pessoa.nome_fantasia LIKE" => "%".$this->request->data["vendedor"]."%")));
			$conditions = array_merge($conditions, array(
				'OR' => array(
					array("Pessoa.nome_fantasia LIKE" => "%".$this->request->data["comprador"]."%"),
					array("PessoaVendedor.nome_fantasia LIKE" => "%".$this->request->data["vendedor"]."%")
				)
			));
		} else if ( $this->dataTable->check_filtro("comprador","text") === true ) {
			// $conditions = array_merge($conditions, array("Pessoa.razao_social LIKE" => "%".$this->request->data["comprador"]."%"));
			$conditions = array_merge($conditions, array("Pessoa.nome_fantasia LIKE" => "%".$this->request->data["comprador"]."%"));
		} else if ( $this->dataTable->check_filtro("vendedor","text") === true ) {
			// $conditions = array_merge($conditions, array("Pessoa.razao_social LIKE" => "%".$this->request->data["vendedor"]."%"));
			$conditions = array_merge($conditions, array("PessoaVendedor.nome_fantasia LIKE" => "%".$this->request->data["vendedor"]."%"));
		}

		if ( isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc')) {
			$order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];
		}

		$this->loadModel('Pessoa');
		$this->loadModel('Romaneio');

		$iTotalRecords = $this->Romaneio->find('count', [
			'conditions' => [
				'Romaneio.tipo' => 1
			]
		]);

		$iDisplayLength = intval($this->request->data['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart = intval($this->request->data['start']);
		$query_busca = array(
			'conditions' => $conditions,
			'order' => $order,
			'fields' => array(
				"Romaneio.*",
				'Pessoa.nome_fantasia',
				'PessoaVendedor.nome_fantasia',
			),
			'link' => array(
				'Pessoa',
				'PessoaVendedor'
			),
			'offset' => $iDisplayStart,
			'limit' => $iDisplayLength
		);
		$this->Session->write('invernar_filtro', $query_busca);

		$dados = $this->Romaneio->find('all',$query_busca);
		// debug($this->Romaneio->getDataSource()->getLog(false, false));die();

		$this->Romaneio->virtualFields['_total_vendido'] = 'SUM(Romaneio.valor_liquido)';
		$this->Romaneio->virtualFields['_total_comissoes'] = 'SUM(Romaneio.comissao_comprador_valor + Romaneio.comissao_vendedor_valor)';
		$this->Romaneio->virtualFields['_count'] = 'COUNT(Romaneio.id)';

		$totais = $this->Romaneio->find("first", array(
			'conditions' => $conditions,
			'link' => array(
				'Pessoa',
				'PessoaVendedor'
			)
		));
		$this->Romaneio->RomaneioItem->virtualFields['_total_cabecas'] = 'SUM(RomaneioItem.cabecas)';
		$total_cabecas = $this->Romaneio->RomaneioItem->find("first", [
			'fields' => ['RomaneioItem._total_cabecas'],
			'conditions' => $conditions,
			'link' => ['Romaneio' => ['Pessoa', 'PessoaVendedor']]
		]);

		$registrosFiltrados = $totais['Romaneio']['_count'];


		$sEcho = intval($this->request->data['draw']);
		$records = array();
		$records["data"] = array();
		if ( count($dados) > 0 ) {
			foreach ( $dados as $dado ) {

				$radio = '<input type="checkbox" name="id[]" value="'.$dado['Romaneio']['id'].'">';

				$data_emissao = $this->dateEnBr($dado['Romaneio']['data_emissao']);

				$nromaneio = $dado['Romaneio']['numero'];

				$comprador = $dado['Pessoa']['nome_fantasia'];
			
				$comprador_comissao = 'R$ ' . number_format($dado['Romaneio']['comissao_comprador_valor'], 2, ',', '.');

				$vendedor = $dado['PessoaVendedor']['nome_fantasia'];
				$vendedor_comissao = 'R$ ' . number_format($dado['Romaneio']['comissao_vendedor_valor'], 2, ',', '.');

				$valor_total = 'R$ ' . number_format($dado['Romaneio']['valor_liquido'], 2, ',', '.');

				$btn_view = ""; // '<a href="'.Router::url(array('controller' => 'Pessoas', 'action' => 'view', $dado['Pessoa']['id'])).'" class="btn btn-icon-only blue" data-toggle=""><i class="fa fa-eye"></i></a>';

				$btn_alterar = '<a href="'.Router::url(array('controller' => $this->name, 'action' => 'alterar', $dado['Romaneio']['id'])).'" class="btn btn-icon-only green" data-toggle="" title="Alterar Romaneio"><i class="fa fa-pencil"></i></a>';

				$btn_excluir = '<a href="'.Router::url(array('controller' => $this->name, 'action' => 'excluir', $dado['Romaneio']['id'])).'" onclick="return confirm(\'Tem certeza de que deseja remover este romaneio?\')" class="btn btn-icon-only red" title="Excluir"><i class="fa fa-trash-o"></i></a>';

				$actions = "";

				$actions = $btn_view.' '.$btn_alterar.' '.$btn_excluir;

				$records["data"][] = array(
					$radio,
					$data_emissao,
					$nromaneio,
					$comprador,
					$comprador_comissao,
					$vendedor,
					$vendedor_comissao,
					$valor_total,
					$actions
				);
			}
		}
			
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $registrosFiltrados;

		$records["total_vendido"] = 'R$ ' . number_format($totais['Romaneio']['_total_vendido'], 2, ',', '.');
		$records["total_cabecas"] = $total_cabecas['RomaneioItem']['_total_cabecas'];
		$records["total_comissoes"] = 'R$ ' . number_format($totais['Romaneio']['_total_comissoes'], 2, ',', '.');


		return new CakeResponse(
			array(
				'type' => 'json',
				'body' => json_encode($records)
			)
		);

	}
	public function adicionar() {
		$this->set('title_for_layout', 'Adicionar Romaneio Invernar');
		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
		}

		$this->loadModel('Pessoa');
		$listaProdutores = $listaFrigorificos = $this->Pessoa->findListAllPessoas();

		$this->loadModel('RomaneioEspecie');
		$listaEspecies = $this->RomaneioEspecie->listaRomaneioEspecie();

		$this->set(compact('listaFrigorificos', 'listaProdutores', 'listaEspecies'));
	}

	private function save() {
		$dados_request = $this->request->data;

		$this->loadModel('RomaneioArquivo');
		$erros = array();
		if (!empty($dados_request['RomaneioArquivo']) && $dados_request['RomaneioArquivo'][0]['arquivo']['error'] != 4) {
			foreach ($dados_request['RomaneioArquivo'] as $arquivo) {
				$this->RomaneioArquivo->set($arquivo);
				if (!$this->RomaneioArquivo->validates()) {
					$erros = array_merge($erros, $this->RomaneioArquivo->validationErrors[key($this->RomaneioArquivo->validationErrors)]);
				}
			}
		} else {
			unset($dados_request['RomaneioArquivo']);
		}
		if (!empty($erros)) {
			$erro = implode(" | ", $erros);
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $erro ))));
		}

		unset($dados_request['aux']);

		$dados_salvar = $dados_request;

		$this->loadModel('RomaneioInvernar');

		if (isset($dados_salvar['RomaneioVencimento'])) {
			foreach ($dados_salvar['RomaneioVencimento'] as $key_venc => $romaneio_vencimento) {
				$valor = $this->currencyToFloat($romaneio_vencimento['valor']);
				if ($valor > 0 && !empty($romaneio_vencimento['vencimento_em'])) {
					$dados_salvar['RomaneioVencimento'][$key_venc]['valor'] = $valor;
					$dados_salvar['RomaneioVencimento'][$key_venc]['vencimento_em'] = $this->dateBrEn($romaneio_vencimento['vencimento_em']);
					$dados_salvar['RomaneioVencimento'][$key_venc]['pago'] = 0;
					if (isset($romaneio_vencimento['pago'])) {
						$dados_salvar['RomaneioVencimento'][$key_venc]['pago'] = 1;
					}
				} else {
					unset($dados_salvar['RomaneioVencimento'][$key_venc]);
				}
			}
		}


		$this->RomaneioInvernar->set($dados_salvar);
		if ( !$this->RomaneioInvernar->validates() ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->RomaneioInvernar->validationErrors[key($this->RomaneioInvernar->validationErrors)] ) ) ) );
		}

		if ($dados_request['RomaneioInvernar']['valor_liquido'] == '0,00') {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Valor Total Líquido não pode ser igual à R$ 0,00.' ))));
		}

		// die(debug($dados_salvar));
		$this->RomaneioInvernar->create();
		if ( $this->RomaneioInvernar->saveAssociated($dados_salvar) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Cadastro realizado com sucesso!" ))));
		} else {
			// debug($this->RomaneioInvernar->getDataSource()->getLog(false, false));
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar o Cadastro. Por favor, tente novamente em alguns instantes." ))));
		}
	}

	public function alterar($id = null) {
		$this->set('title_for_layout', 'Alterar Romaneio Invernar');
		if ( !empty($this->request->data) ) {
			if ( $this->request->data['RomaneioInvernar']['id'] == null ){
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Romaneio a ser alterado não informado."))));
			}
			$this->layout = "ajax";
			return $this->update();
		}

		if ($id == null) {
			$this->redirect(array('action' => 'index'));
			die();
		}

		$this->loadModel('RomaneioInvernar');
		$dados = $this->RomaneioInvernar->findById($id);
		
		if (count($dados) <= 0) {
			$this->Session->setFlash('Romaneio Incorreto!!!', 'flash_error');
			return $this->routing();
		}

		$this->loadModel('RomaneioItem');
		$itens = $this->RomaneioItem->find('all', array(
			'conditions' => array(
				'RomaneioItem.romaneio_id' => $id
			),
			'fields' => array(
				'RomaneioItem.*',
				'RomaneioEspecie.*'
			),
			'link' => array(
				'RomaneioEspecie'
			),
			'order' => array(
				'RomaneioItem.id ASC'
			)
		));

		$vencimentos = $this->RomaneioInvernar->RomaneioVencimento->find('all', [
			'conditions' => [
				'RomaneioVencimento.romaneio_id' => $id
			],
			'link' => [],
			'order' => 'RomaneioVencimento.vencimento_em'
		]);
		foreach ($vencimentos as $key => $val) {
			$vencimentos[$key]['RomaneioVencimento']['vencimento_em'] = $this->dateEnBr($vencimentos[$key]['RomaneioVencimento']['vencimento_em']);
			$vencimentos[$key]['RomaneioVencimento']['valor'] = number_format($vencimentos[$key]['RomaneioVencimento']['valor'], 2, ',', '.');
		}

		$totais_peso = $totais_cabecas = $totais_valor_unitario = 0.0;
		$index = 0;
		$this->loadModel('RomaneioEspecie');
		foreach ($itens as $item) {
			$especie = $this->RomaneioEspecie->findById($item['RomaneioItem']['especie_id']);
			$dados['RomaneioItem'][$index]['especie']        = $especie['RomaneioEspecie']['especie'];
			$dados['RomaneioItem'][$index]['id']             = $item['RomaneioItem']['id'];
			$dados['RomaneioItem'][$index]['especie_id']     = $item['RomaneioItem']['especie_id'];
			$dados['RomaneioItem'][$index]['peso']           = $item['RomaneioItem']['peso'];
			$dados['RomaneioItem'][$index]['cabecas']        = $item['RomaneioItem']['cabecas'];
			$dados['RomaneioItem'][$index]['valor_unitario'] = $item['RomaneioItem']['valor_unitario'];
			$dados['RomaneioItem'][$index]['valor_total']    = $item['RomaneioItem']['valor_total'];

			$totais_peso+= $item['RomaneioItem']['peso'];
			$totais_cabecas+= $item['RomaneioItem']['cabecas'];
			$totais_valor_unitario+= $item['RomaneioItem']['valor_unitario'];

			$index++;
		}

		$dados['aux']['RomaneioInvernar_media_carcaca'] = $totais_peso / $this->validZeroToDivision($totais_cabecas);
		$dados['aux']['RomaneioInvernar_media_cabeca'] = $totais_valor_unitario / $this->validZeroToDivision($index);

		$this->loadModel('Pessoa');
		$listaVendedores = $listaCompradores = $this->Pessoa->findListAllPessoas();
		
		$this->loadModel('PessoaLocalidade');
		
		$rilocalidade['comprador_localidade_id']['id'] = '';
		$rilocalidade['comprador_localidade_id']['localidade'] = '';
		if (!is_null($dados['RomaneioInvernar']['comprador_localidade_id'])) {
			$localidade = $this->PessoaLocalidade->findById($dados['RomaneioInvernar']['comprador_localidade_id']);
			$rilocalidade['comprador_localidade_id']['id'] = $localidade['PessoaLocalidade']['id'];
			$rilocalidade['comprador_localidade_id']['localidade'] = $localidade['PessoaLocalidade']['localidade'];
		}

		$rilocalidade['vendedor_localidade_id']['id'] = '';
		$rilocalidade['vendedor_localidade_id']['localidade'] = '';
		if (!is_null($dados['RomaneioInvernar']['vendedor_localidade_id'])) {
			$localidade = $this->PessoaLocalidade->findById($dados['RomaneioInvernar']['vendedor_localidade_id']);
			$rilocalidade['vendedor_localidade_id']['id'] = $localidade['PessoaLocalidade']['id'];
			$rilocalidade['vendedor_localidade_id']['localidade'] = $localidade['PessoaLocalidade']['localidade'];
		}
		$dados = array_merge($dados, $rilocalidade);

		$this->loadModel('RomaneioEspecie');
		$listaEspecies = $this->RomaneioEspecie->listaRomaneioEspecie();

		$this->loadModel('RomaneioArquivo');
		$arquivos = $this->RomaneioArquivo->arquivosByRomaneioId($id);

		$this->set(compact('dados', 'listaCompradores', 'listaVendedores', 'listaEspecies', 'arquivos', 'vencimentos'));

	}

	private function update() {
		$dados_request = $this->request->data;
		
		if ( !isset($dados_request['RomaneioInvernar']['id']) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Romaneio não informado."))));
		}
		
		$this->loadModel('RomaneioInvernar');
		$dados = $this->RomaneioInvernar->findById($dados_request['RomaneioInvernar']['id']);
		
		if ( !$dados || count($dados) <= 0 ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
		}
		
		$erros = array();
		$this->loadModel('RomaneioArquivo');
		if (!empty($dados_request['RomaneioArquivo']) && $dados_request['RomaneioArquivo'][0]['arquivo']['error'] != 4) {
			foreach ($dados_request['RomaneioArquivo'] as $arquivo) {
				$this->RomaneioArquivo->set($arquivo);
				if (!$this->RomaneioArquivo->validates()) {
					$erros = array_merge($erros, $this->RomaneioArquivo->validationErrors[key($this->RomaneioArquivo->validationErrors)]);
				}
			}
		} else {
			unset($dados_request['RomaneioArquivo']);
		}
		if (!empty($erros)) {
			$erro = implode(" | ", $erros);
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $erro ))));
		}

		unset($dados_request['aux']);
		
		$dados_salvar = $dados_request;

		if (isset($dados_salvar['RomaneioVencimento'])) {
			foreach ($dados_salvar['RomaneioVencimento'] as $key_venc => $romaneio_vencimento) {
				$valor = $this->currencyToFloat($romaneio_vencimento['valor']);
				if ($valor > 0 && !empty($romaneio_vencimento['vencimento_em'])) {
					$dados_salvar['RomaneioVencimento'][$key_venc]['valor'] = $valor;
					$dados_salvar['RomaneioVencimento'][$key_venc]['vencimento_em'] = $this->dateBrEn($romaneio_vencimento['vencimento_em']);
					$dados_salvar['RomaneioVencimento'][$key_venc]['pago'] = 0;
					if (isset($romaneio_vencimento['pago'])) {
						$dados_salvar['RomaneioVencimento'][$key_venc]['pago'] = 1;
					}
				} else {
					unset($dados_salvar['RomaneioVencimento'][$key_venc]);
				}
			}

			$this->RomaneioInvernar->RomaneioVencimento->deleteAll(['RomaneioVencimento.romaneio_id' => $dados_salvar['RomaneioInvernar']['id']]);
		}

		$this->loadModel('RomaneioInvernar');
		$this->RomaneioInvernar->set($dados_salvar);
		if ( !$this->RomaneioInvernar->validates() ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->RomaneioInvernar->validationErrors[key($this->RomaneioInvernar->validationErrors)] ) ) ) );
		}

		if ($dados_request['RomaneioInvernar']['valor_liquido'] == '0,00') {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Valor Total Líquido não pode ser igual à R$ 0,00.' ))));
		}

		// die(debug($dados_salvar));
		if ( $this->RomaneioInvernar->saveAssociated($dados_salvar) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Alteração realizada com sucesso!" ))));
		} else {
			// debug($this->RomaneioInvernar->getDataSource()->getLog(false, false));
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar a Alteração. Por favor, tente novamente em alguns instantes." ))));
		}
	}

	public function excluirEspecie($id = null) {
		$this->layout = 'ajax';

		if ( is_null($id) || !is_numeric($id) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado." ))));
		}

		$this->loadModel('RomaneioItem');
		$dados = $this->RomaneioItem->findById($id);

		if ( count($dados) == 0 ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "O Item do Romaneio que você está tentando excluir não existe."))));
		}
		
		if ( $this->RomaneioItem->delete($id) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Item do Romaneio excluído com sucesso." ))));
		} else {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir o Item do Romaneio. Por favor, tente mais tarde."))));
		}
	}

}

?>