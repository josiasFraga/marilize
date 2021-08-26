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
		$this->Mpdf->SetFooter("Orelhano - Romaneios em Aberto");

		// you can call any mPDF method via component, for example:
		$this->Mpdf->SetWatermarkText("Draft");
		$dias_semana = array('Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado');
		$this->set(compact('romanios_n_pagos_compradores', 'dias_semana', 'romanios_n_pagos_vendedores'));
		//debug($romanios_n_pagos_compradores);
		//die();
	}

}

?>