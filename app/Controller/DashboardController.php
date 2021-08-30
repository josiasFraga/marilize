<?php

class DashboardController extends AppController {

    // public function isAuthorized($user = null) {
    // // Quando retorna false e não existe um `loginRedirect`, manda para `/`
	// 	return true;
    // }
    
    public function isAuthorized($user = null) {
        if ($this->action === 'index') {
            return true;
        }
        if (!parent::isAuthorized($user)) {
            return false;
        }
        return true;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('infobarData', 'infobar2Data', 'graphData', 'topCompradores', 'topVendedores', 'topClientes'));
    }

	public function index() {
		$this->layout = 'metronic';

        $this->set('title_for_layout', 'Início');

        /*$this->loadModel('Romaneio');
        $romaneios_gordo_vencimentos = $this->Romaneio->RomaneioVencimento->find('all', [
            'fields' => [
                'Romaneio.id',
                'Pessoa.nome_fantasia',
                'PessoaVendedor.nome_fantasia',
                'Romaneio.numero',
                'RomaneioVencimento.vencimento_em',
                'RomaneioVencimento.valor',
                'Romaneio.data_emissao'
            ],
            'conditions' => [
                'RomaneioVencimento.vencimento_em <=' => date('Y-m-d'),
                'Romaneio.tipo' => 0,
                'RomaneioVencimento.pago' => 0
            ],
            'link' => ['Romaneio' => ['Pessoa', 'PessoaVendedor']],
            'order' => 'RomaneioVencimento.vencimento_em'
        ]);


        $romaneios_invernar_vencimentos = $this->Romaneio->RomaneioVencimento->find('all', [
            'fields' => [
                'Romaneio.id',
                'Pessoa.nome_fantasia',
                'PessoaVendedor.nome_fantasia',
                'Romaneio.numero',
                'RomaneioVencimento.vencimento_em',
                'RomaneioVencimento.valor',
                'Romaneio.data_emissao',
            ],
            'conditions' => [
                'RomaneioVencimento.vencimento_em <=' => date('Y-m-d'),
                'Romaneio.tipo' => 1,
                'RomaneioVencimento.pago' => 0
            ],
            'link' => ['Romaneio' => ['Pessoa', 'PessoaVendedor']],
            'order' => 'RomaneioVencimento.vencimento_em'
        ]);

        $romaneios_gordo_vencimentos = $this->_verificaRomaneiosAtrasados($romaneios_gordo_vencimentos);
        $romaneios_invernar_vencimentos = $this->_verificaRomaneiosAtrasados($romaneios_invernar_vencimentos);

        $this->set(compact('romaneios_gordo_vencimentos', 'romaneios_invernar_vencimentos'));*/
    }

    private function _verificaRomaneiosAtrasados($romaneios) {
        return array_map(function($romaneio) {
            $romaneio['RomaneioVencimento']['_atrasado'] = false;
            if ($romaneio['RomaneioVencimento']['vencimento_em'] < date('Y-m-d')) {
                $romaneio['RomaneioVencimento']['_atrasado'] = true;
            }
            return $romaneio;
        }, $romaneios);
    }

    public function infobarData() {
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
        $this->Romaneio->virtualFields['_total_cabecas'] = "SUM(RomaneioItem.cabecas)";
        $this->Romaneio->virtualFields['_total_comissao'] = "COALESCE(SUM(Romaneio.comissao_comprador_valor),0)+COALESCE(SUM(Romaneio.comissao_vendedor_valor),0)";

        $total_gordo = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.tipo' => 0,
                'Romaneio.data_emissao >=' => date('Y')."-01-01",
            ],
            'fields' => [
                'Romaneio._total_comissao',
                'Romaneio._total_cabecas',
            ],
            'link' => ['RomaneioItem'],
        ]);

        $total_invernar = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.tipo' => 1,
                'Romaneio.data_emissao >=' => date('Y')."-01-01",
            ],
            'fields' => [
                'Romaneio._total_comissao',
                'Romaneio._total_cabecas',
            ],
            'link' => ['RomaneioItem'],
        ]);

        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "dados" => [
            'gordo_valor' => (float)$total_gordo[0]['Romaneio']['_total_comissao'],
            'gordo_qtd' => (float)$total_gordo[0]['Romaneio']['_total_cabecas'],
            'invernar_valor'=> (float)$total_invernar[0]['Romaneio']['_total_comissao'],
            'invernar_qtd'=> (float)$total_invernar[0]['Romaneio']['_total_cabecas'],
        ]))));
    }

    public function infobar2Data() {
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
        $this->Romaneio->virtualFields['_total_comissao'] = "COALESCE(SUM(Romaneio.comissao_comprador_valor),0)+COALESCE(SUM(Romaneio.comissao_vendedor_valor),0)";
        $this->Romaneio->virtualFields['_total_cabecas'] = "SUM(RomaneioItem.cabecas)";

        $total = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.data_emissao >=' => date('Y')."-01-01",
            ],
            'fields' => [
                'Romaneio._total_comissao',
                'Romaneio._total_cabecas',
            ],
            'link' => ['RomaneioItem'],
        ]);


        $total_ano_passado = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.data_emissao >=' => (date('Y')-1)."-01-01",
                'Romaneio.data_emissao <=' => (date('Y')-1).date("-m-d"),
            ],
            'fields' => [
                'Romaneio._total_cabecas',
            ],
            'link' => ['RomaneioItem'],
        ]);
        
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "dados" => [
            'total_vendido' => (float)$total[0]['Romaneio']['_total_comissao'],
            'cabecas_vendidas' => (float)$total[0]['Romaneio']['_total_cabecas'],
            'ano_passado'=> (float)$total_ano_passado[0]['Romaneio']['_total_cabecas'],
        ]))));
    }

    public function graphData() {
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
        $this->Romaneio->virtualFields['_total_comissao'] = "COALESCE(SUM(Romaneio.comissao_comprador_valor),0)+COALESCE(SUM(Romaneio.comissao_vendedor_valor),0)";
        $this->Romaneio->virtualFields['_mes'] = "MONTH(Romaneio.data_emissao)";

        $totais = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.data_emissao >=' => date('Y')."-01-01",
            ],
            'fields' => [
                'Romaneio._total_comissao',
                'Romaneio._mes',
            ],
            'link' => ['RomaneioItem'],
            'order' => ['Romaneio.data_emissao'],
            'group' => ['MONTH(Romaneio.data_emissao)']
        ]);

        $labels = [];
        $totais_retornar = [];
        
        foreach($totais as $key => $total) {
            $labels[] = $this->month_arr[(int)$total['Romaneio']['_mes']];
            $totais_retornar[] = (float)number_format($total['Romaneio']['_total_comissao']/1000,0,',','.');
        }
        
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "dados" => [
            'labels' => $labels,
            'datasets' => [
              [
                'data' => $totais_retornar,
              ],
            ],
          
        ]))));
    }

    public function topCompradores($tipo) {
        $tipo = ($tipo == 'gordo') ? 0 : 1;

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

        $this->Romaneio->virtualFields['_total_comissao'] = "SUM(IFNULL(Romaneio.comissao_comprador_valor,0))";
        $this->Romaneio->virtualFields['_total_cabecas'] = "SUM(RomaneioItem.cabecas)";

        $totais = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.tipo' => $tipo,
                'Romaneio.data_emissao >=' => date('Y')."-01-01",
            ],
            'fields' => [
                'Romaneio._total_comissao',
                'Romaneio._total_cabecas',
                //'Pessoa.razao_social',
                //'Pessoa.foto',
                'Pessoa.nome_fantasia',
                'Pessoa.id'
            ],
            //'link' => ['RomaneioItem', 'Pessoa'],
            'joins' => [
                [
                    'table' => 'romaneio_itens',
                    'alias' => 'RomaneioItem',
                    'type' => 'LEFT',
                    'conditions' => [
                        'RomaneioItem.romaneio_id = Romaneio.id'
                    ]
                ],
                [
                    'table' => 'pessoas',
                    'alias' => 'PessoaTmpGrupo',
                    'type' => 'LEFT',
                    'conditions' => [
                        'PessoaTmpGrupo.id = Romaneio.comprador_id'
                    ]
                ],
                [
                    'table' => 'pessoas',
                    'alias' => 'Pessoa',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Pessoa.id = PessoaTmpGrupo.grupo_id'
                    ]
                ]
            ],
            'order' => ['Romaneio._total_cabecas DESC'],
            'group' => ['Pessoa.grupo_id'],
            'limit' => 10
        ]);
        
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "dados" => $totais))));

    }

    public function topVendedores($tipo) {
        $tipo = ($tipo == 'gordo') ? 0 : 1;

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
        $this->Romaneio->virtualFields['_total_comissao'] = "SUM(IFNULL(Romaneio.comissao_vendedor_valor,0))";
        $this->Romaneio->virtualFields['_total_cabecas'] = "SUM(RomaneioItem.cabecas)";

        // @gambi.. criamos os grupos para poder AGRUPAR os clientes que são da mesma familia .. e sempre buscamos o nome do parent do grupo ..
        $totais = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.tipo' => $tipo,
                'Romaneio.data_emissao >=' => date('Y')."-01-01",
            ],
            'fields' => [
                'Romaneio._total_comissao',
                'Romaneio._total_cabecas',
                'PessoaVendedor.nome_fantasia',
                'PessoaVendedor.id',
            ],
            //'link' => ['RomaneioItem', 'PessoaVendedor'],
            'joins' => [
                [
                    'table' => 'romaneio_itens',
                    'alias' => 'RomaneioItem',
                    'type' => 'LEFT',
                    'conditions' => [
                        'RomaneioItem.romaneio_id = Romaneio.id'
                    ]
                ],
                [
                    'table' => 'pessoas',
                    'alias' => 'PessoaVendedorTmpGrupo',
                    'type' => 'LEFT',
                    'conditions' => [
                        'PessoaVendedorTmpGrupo.id = Romaneio.vendedor_id'
                    ]
                ],
                [
                    'table' => 'pessoas',
                    'alias' => 'PessoaVendedor',
                    'type' => 'LEFT',
                    'conditions' => [
                        'PessoaVendedor.id = PessoaVendedorTmpGrupo.grupo_id'
                    ]
                ]
            ],
            'order' => ['Romaneio._total_cabecas DESC'],
            'group' => ['PessoaVendedor.grupo_id'],
            'limit' => 10
        ]);

        foreach ($totais as $key => $value) {
            $totais[$key]['Pessoa'] = $totais[$key]['PessoaVendedor'];
            unset($totais[$key]['PessoaVendedor']);
        }
        
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "dados" => $totais))));

    }


    public function topClientes() {

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

        $this->Romaneio->virtualFields['_total_comissao_comprador'] = "SUM(IFNULL(Romaneio.comissao_comprador_valor,0))";
        $this->Romaneio->virtualFields['_total_comissao_vendedor'] = "SUM(IFNULL(Romaneio.comissao_vendedor_valor,0))";
        $this->Romaneio->virtualFields['_total_cabecas'] = "SUM(RomaneioItem.cabecas)";

        $vendas_total = $this->Romaneio->find('all', [
            'conditions' => [
                'Romaneio.data_emissao >=' => date('Y')."-01-01",

            ],
            'fields' => [
                'Romaneio.vendedor_id',
                'Romaneio._total_comissao_vendedor',
                'Romaneio.comprador_id',
                'Romaneio._total_comissao_comprador',
                'Romaneio._total_cabecas'
            ],
            'link' => ['RomaneioItem'],
            'group' => 'Romaneio.id'
        ]);

        // iniciamos a desmembrar por cada cliente
        $clientes = [];
        foreach ($vendas_total as $venda) {
            $comprador_id = $venda['Romaneio']['comprador_id'];
            $vendedor_id = $venda['Romaneio']['vendedor_id'];
            if (!isset($clientes[$comprador_id])) {
                $clientes[$comprador_id] = [
                    'total_comissao' => 0,
                    'total_cabecas' => 0,
                    'id' => $comprador_id
                ];
            }
            if (!isset($clientes[$vendedor_id])) {
                $clientes[$vendedor_id] = [
                    'total_comissao' => 0,
                    'total_cabecas' => 0,
                    'id' => $vendedor_id
                ];
            }

            $clientes[$comprador_id]['total_comissao'] += (float) $venda['Romaneio']['_total_comissao_comprador'];
            $clientes[$comprador_id]['total_cabecas'] += (float) $venda['Romaneio']['_total_cabecas'];
            $clientes[$vendedor_id]['total_comissao'] += (float) $venda['Romaneio']['_total_comissao_vendedor'];
            $clientes[$vendedor_id]['total_cabecas'] += (float) $venda['Romaneio']['_total_cabecas'];
        }

        foreach ($clientes as $key => $cliente) {
            if (in_array($cliente['id'], [966,1045,50550,50930,51124,50339,50537])) {
                unset($clientes[$key]);
            }
        }

        usort($clientes, function($a, $b) {
            return $b['total_cabecas'] - $a['total_cabecas'];
        });

        $clientes = array_slice($clientes, 0, 10);

        $this->loadModel('Pessoa');
        foreach ($clientes as $key => $cliente) {
            $dados_cliente = $this->Pessoa->find('first', [
                'fields' => ['Pessoa.nome_fantasia'],
                'conditions' => [
                    'Pessoa.id' => $cliente['id']
                ]
            ]);

            $clientes[$key] = [
                'Romaneio' => [
                    '_total_comissao' => $cliente['total_comissao'],
                    '_total_cabecas' => $cliente['total_cabecas']
                ],
                'Pessoa' => [
                    'nome_fantasia' => $dados_cliente['Pessoa']['nome_fantasia'],
                    'id' => $cliente['id']
                ]
            ];
        }
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "dados" => $clientes))));
    }
}
?>