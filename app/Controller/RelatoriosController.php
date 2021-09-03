<?php

class RelatoriosController extends AppController {

	public $components = array(
		'Mpdf.Mpdf'
	);

	public function isAuthorized($user = null) {
		if (!parent::isAuthorized($user)) {
			return false;
		}
		return true;
	}


	public function resultados($ano = null) {
		$this->layout = 'relatorios';

		$this->loadModel('Romaneio');
		$retorno = $this->Romaneio->relatorios($ano);

		$dados = $retorno['dados'];
		$totais = $retorno['totais'];
		$medias_se = $retorno['medias_se'];
		$medias = $retorno['medias'];

		$this->set(compact('dados', 'totais', 'medias_se', 'medias'));
	}

	public function resumo($ano = null) {
		$this->layout = 'relatorios';

		$this->loadModel('Romaneio');
		$retorno = $this->Romaneio->relatorios($ano);

		$dados = $retorno['dados'];
		$totais = $retorno['totais'];
		$medias_se = $retorno['medias_se'];
		$medias = $retorno['medias'];

		$this->set(compact('dados', 'totais', 'medias_se', 'medias'));
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'metronic';
		$this->Auth->allow(array('resultados', 'resumo'));
	}

	public function anual() {
		$this->layout = 'ajax';
		$dados = $this->request->query;

		if ( !isset($dados['token']) || empty($dados['token']) ) {
			throw new BadRequestException('Token não informado!', 400);
		}

		if ( !isset($dados['email']) || empty($dados['email']) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL) ) {
			throw new BadRequestException('Usuário não informado!', 400);
		}

		if ( !isset($dados['ano']) || empty($dados['ano']) ) {
			$dados['ano'] = date('Y');
		}

		$email = $dados['email'];
		$token = $dados['token'];
		$ano = $dados['ano'];

		//busca os dados da sessão
		$dados_token = $this->isLogged($email,$token);

		if ( $dados_token['Token']['data_validade'] < date('Y-m-d') ) {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', "msg" => "Usuário não logado. Token Expirado", 'code' => 8))));
		}

		if ( !$dados_token ) {
			return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'erro', "msg" => "Usuário não logado.", 'code' => 9))));
		}

		$this->loadModel('Romaneio');
		$this->Romaneio->virtualFields['_total_cabecas'] = "SUM(RomaneioItem.cabecas)";

		$total_gordo = $this->Romaneio->find('all',[
			'conditions' => [
				'Romaneio.tipo' => 0,
				'Romaneio.data_emissao >=' => $ano."-01-01",
				'Romaneio.data_emissao <=' => $ano."-12-31",
			],
			'fields' => [
				'Romaneio._total_cabecas',
				'Romaneio.data_emissao'
			],
			'link' => ['RomaneioItem'],
			'group' => ['MONTH(Romaneio.data_emissao)']
		]);

		$total_invernar = $this->Romaneio->find('all',[
			'conditions' => [
				'Romaneio.tipo' => 1,
				'Romaneio.data_emissao >=' => $ano."-01-01",
				'Romaneio.data_emissao <=' => $ano."-12-31",
			],
			'fields' => [
				'Romaneio._total_cabecas',
				'Romaneio.data_emissao'
			],
			'link' => ['RomaneioItem'],
			'group' => ['MONTH(Romaneio.data_emissao)']
		]);
		
		$dados = [];
		$count = 0;
		$tot_gordo = 0;
		$tot_invernar = 0;
		$totais = [
			'totais' => [
				'label' => 'Totais', 'gordo' => 0, 'invernar' => 0, 'total' => 0
			],
			'medias' => [
				'label' => 'Médias', 'gordo' => 0, 'invernar' => 0, 'total' => 0
			]
		];

		$n_meses = 0;
		for($i=1;$i<=12;$i++) {
			$dados[$count] = ['mes' => $this->month_arr[$i], 'gordo'=>0, 'invernar' => 0, 'total' => 0];
			foreach($total_gordo as $totg) {
				if ( (int)date('m',strtotime($totg['Romaneio']['data_emissao'])) == $i ) {
					$dados[$count] = ['mes' => $this->month_arr[$i], 'gordo'=>$totg['Romaneio']['_total_cabecas'], 'invernar' => 0, 'total' =>  $dados[$count]['total']+$totg['Romaneio']['_total_cabecas']];
					$tot_gordo += $totg['Romaneio']['_total_cabecas'];
					$n_meses++;
				}
			}
			foreach($total_invernar as $toti) {
				if ( (int)date('m',strtotime($toti['Romaneio']['data_emissao'])) == $i ) {
					$dados[$count] = ['mes' => $this->month_arr[$i], 'gordo' => $dados[$count]['gordo'], 'invernar'=>$toti['Romaneio']['_total_cabecas'], 'total' =>  $dados[$count]['total']+$toti['Romaneio']['_total_cabecas']];
					$tot_invernar += $toti['Romaneio']['_total_cabecas'];
				}
			}
			$count++;
		}
		$totais['totais']['gordo'] = $tot_gordo;
		$totais['totais']['invernar'] = $tot_invernar;
		$totais['totais']['total'] = $tot_gordo+$tot_invernar;

		$totais['medias']['gordo'] = number_format($tot_gordo/$n_meses, 0, '', '');
		$totais['medias']['invernar'] = number_format($tot_invernar/$n_meses,0, '', '');
		$totais['medias']['total'] = number_format(($tot_gordo+$tot_invernar)/$n_meses,0, '', '');
		

		$thead = ['','Gordo', 'Invernar', 'Total'];
		$widthArr = [130, 90, 130, 130, 130];
		
		//precisei criar essa var prq a ordem dos campos estava cagada
		$dados_retornar = ['dados' => $dados, 'thead' => $thead, 'widthArr' => $widthArr, 'totais' => $totais['totais'], 'medias' => $totais['medias']];

		return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "resultado_anual" => $dados_retornar))));
	}

	public function index() {
		$this->set('title_for_layout', 'Relatórios');
	}

	public function clientes_vencer() {
		$this->layout = 'pdf';
		$this->loadModel('Romaneio');
		$romanios_n_pagos_compradores = $this->Romaneio->find('all',[
			'fields' => [
				'Pessoa.razao_social',
				'Romaneio.data_emissao',
				'Romaneio.numero',
				'Romaneio.comissao_comprador_valor',
				'Romaneio.comissao_comprador_data_pgto'
			],
			'conditions' => [
				['Romaneio.comissao_comprador_pago' => 0]
			],
			'order' => [
				'Pessoa.razao_social',
			],
			'link' => [
				'Pessoa'
			],
			'limit' => 100
		]);
		$romanios_n_pagos_vendedores = $this->Romaneio->find('all',[
			'fields' => [
				'PessoaVendedor.razao_social',
				'Romaneio.data_emissao',
				'Romaneio.numero',
				'Romaneio.comissao_vendedor_valor',
				'Romaneio.comissao_vendedor_data_pgto',
			],
			'conditions' => [
				'Romaneio.comissao_vendedor_pago' => 0,
				'Romaneio.tipo' => 1
			],
			'order' => [
				'PessoaVendedor.razao_social',
			],
			'link' => [
				'PessoaVendedor'
			],
			'limit' => 100
		]);

		$this->Mpdf->init();

		// setting filename of output pdf file
		$this->Mpdf->setFilename('file.pdf');

		// setting output to I, D, F, S
		$this->Mpdf->setOutput('I');
		$this->Mpdf->SetFooter("Marilize - Romaneios em Aberto");

		// you can call any mPDF method via component, for example:
		$this->Mpdf->SetWatermarkText("Draft");
		$dias_semana = array('Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado');
		$this->set(compact('romanios_n_pagos_compradores', 'dias_semana', 'romanios_n_pagos_vendedores'));
		//debug($romanios_n_pagos_compradores);
		//die();
	}

	public function despesas() {
        $this->set('title_for_layout', 'Relatório de Despesas');

        $this->loadModel('PagamentoStatus');
        $status = $this->PagamentoStatus->listaPagamentoStatus();

        $this->loadModel('PagamentoCategoria');
        $categorias = $this->PagamentoCategoria->listaPagamentoCategoria();

        $this->loadModel('PagamentoForma');
        $listformas = $this->PagamentoForma->listaPagamentoForma();

        $this->loadModel('Fazenda');
        $fazendas = $this->Fazenda->listaFazendas();

        $this->loadModel('Pessoa');
        $fornecedores = $this->Pessoa->findListAllPessoas(2);

        $this->loadModel('ContaGrupo');
        $grupos = $this->ContaGrupo->listaGrupos();
    
        $this->loadModel('Safra');
        $safras = $this->Safra->listaSafras();


        $safra_atual = $this->Safra->buscaSafraAtual();


        $this->set(compact('status', 'categorias', 'listformas', 'fazendas', 'fornecedores', 'grupos', 'safras', 'safra_atual'));

	}

	public function dados_despesas() {
	
		$this->layout = 'ajax';
		$this->loadModel('PagamentoData');
		$dados_request = $this->request->data;

	
        if (empty($dados_request['Relatorio']['safra_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A safra não pode estar em branco!"))));
        }
		
        if (empty($dados_request['Relatorio']['fazenda_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A fazenda não pode estar em branco!"))));
        }
		
        if (empty($dados_request['Relatorio']['categoria_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A categoria não pode estar em branco!"))));
        }
		
        if (empty($dados_request['Relatorio']['inicio_fim'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "O período não pode estar em branco!"))));
        }

		list($inicio,$fim) = explode(" até ",$dados_request['Relatorio']['inicio_fim']);
		$dados_request['Relatorio']['inicio'] = $this->dateBrEn($inicio);
		$dados_request['Relatorio']['fim'] = $this->dateBrEn($fim);

		$group = ['PagamentoData.grupo_id', 'PagamentoData.subgrupo_id'];

		$conditions = [
			'PagamentoData.tipo' => 'S',
			'PagamentoData.ativo' => 'Y',
			'PagamentoData.data_venc >=' => $dados_request['Relatorio']['inicio'],
			'PagamentoData.data_venc <=' => $dados_request['Relatorio']['fim'],
			'PagamentoData.safra_id' => $dados_request['Relatorio']['safra_id'],
			'PagamentoData.fazenda_id' => $dados_request['Relatorio']['fazenda_id'],
			'PagamentoData.categoria_id' => $dados_request['Relatorio']['categoria_id'],
		];

        if (isset($dados_request['Relatorio']['fornecedor_id']) && !empty($dados_request['Relatorio']['fornecedor_id'])) {
			$conditions = array_merge($conditions,[
				'PagamentoData.fornecedor_id' => $dados_request['Relatorio']['fornecedor_id'],
			]);
		}

        if (isset($dados_request['Relatorio']['grupo_id']) && !empty($dados_request['Relatorio']['grupo_id'])) {
			$conditions = array_merge($conditions,[
				'PagamentoData.grupo_id' => $dados_request['Relatorio']['grupo_id'],
			]);
		}

        if (isset($dados_request['Relatorio']['status_id']) && !empty($dados_request['Relatorio']['status_id'])) {
			$conditions = array_merge($conditions,[
				'PagamentoData.status_id' => $dados_request['Relatorio']['status_id'],
			]);
		}

        if (isset($dados_request['Relatorio']['forma_id']) && !empty($dados_request['Relatorio']['forma_id'])) {
			$conditions = array_merge($conditions,[
				'PagamentoData.forma_id' => $dados_request['Relatorio']['forma_id'],
			]);
		}

		if ( $dados_request['Relatorio']['categoria_id'] == 64 ) {
			$group = ['CONCAT_WS(YEAR(PagamentoData.data_venc),MONTH(PagamentoData.data_venc)) '];
			$this->PagamentoData->virtualFields['ano'] = "YEAR(PagamentoData.data_venc)";
			$this->PagamentoData->virtualFields['mes'] = "MONTH(PagamentoData.data_venc)";
		}

		$this->PagamentoData->virtualFields['_total'] = "SUM(PagamentoData.valor)";
		$dados = $this->PagamentoData->find('all',[
			'fields' => ['*'],
			'conditions' => $conditions,
			'group' => $group,
			'link' => ['ContaSubgrupo', 'ContaGrupo', 'Fazenda'],
			'order' => [
				'PagamentoData.data_venc'
			]
		]);

		if ( count($dados) == 0 ){
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "Nenhum dado encontrado"))));
		}

		$dados_retornar = [];
		$totais = [];
		
		foreach( $dados as $key => $dado ){

			$agrupar_itens_por = $dado['ContaGrupo']['id'];
			
			if ( $dados_request['Relatorio']['categoria_id'] == 64 ) {
				$agrupar_itens_por = 0;
			}

			if ( !isset($totais[$agrupar_itens_por]) ) {
				$totais[$agrupar_itens_por] = (float)$dado['PagamentoData']['_total'];
			}else{
				$totais[$agrupar_itens_por] += (float)$dado['PagamentoData']['_total'];
				
			}
		}

		//debug($totais); die();

		foreach( $dados as $key => $dado ){

			$agrupar_itens_por = $dado['ContaGrupo']['id'];
			$subtitulo = $dado['ContaGrupo']['nome'];
			$nome_pedaco = $dado['ContaSubgrupo']['nome']." - R$ ".number_format($dado['PagamentoData']['_total'],2,",",".");

			
			if ( $dados_request['Relatorio']['categoria_id'] == 64 ) {
				$agrupar_itens_por = 0;
				$nome_pedaco = $this->month_arr[(int)$dado['PagamentoData']['mes']]."/".$dado['PagamentoData']['ano']." - R$ ".number_format($dado['PagamentoData']['_total'],2,",",".");
				$subtitulo = '';
			}

			if ( !isset($dados_retornar[$agrupar_itens_por]) ) {
				$dados_retornar[$agrupar_itens_por] = [
					'titulo' => 'Despesas '.$dado['Fazenda']['nome'].' de '.$dados_request['Relatorio']['inicio_fim'],
					'subtitle' => $subtitulo,
					'data' => [[
						'name' => $nome_pedaco, 
						'y' => (float)($dado['PagamentoData']['_total']*100)/$totais[$agrupar_itens_por],
					]]
				];

			} else {
				$dados_retornar[$agrupar_itens_por]['data'][] = [
					'name' => $nome_pedaco, 
					'y' => (float)($dado['PagamentoData']['_total']*100)/$totais[$agrupar_itens_por],
				];

			}
		}

		$dados_retornar = array_values($dados_retornar);

		return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'dados' => $dados_retornar))));


	}

	public function imprimir_pizzas() {
        $this->layout = 'pdf';

		
        $this->Mpdf->init();

        // setting filename of output pdf file
        $this->Mpdf->setFilename('file.pdf');

        // setting output to I, D, F, S
        $this->Mpdf->setOutput('I');
        $this->Mpdf->SetFooter("Marilize - Gráficos de Despesas");

        // you can call any mPDF method via component, for example:
        $this->Mpdf->SetWatermarkText("Draft");
        
		$photos = $this->request->query;
        $this->set(compact('photos'));

	}

}

?>