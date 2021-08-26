<?php

App::uses('RomaneioController', 'Controller');

class RomaneioGordoController extends RomaneioController {


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
        $this->set('title_for_layout', 'Romaneios Gordo');
        if ( $this->request->is('post') ) {
            $this->layout = "ajax";
            return $this->_dataTable();
        }
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
        $this->Romaneio->virtualFields['numero_formatado'] = "CAST(Romaneio.numero AS UNSIGNED )";

        $dados = $this->Romaneio->find('all',[
            'conditions' => [
                'Romaneio.tipo' => 0
            ],
            'fields' => [
                'Romaneio.data_emissao',
                'Romaneio.numero_formatado',
                'Romaneio.total_cabecas',
                'Romaneio.comprador_id',
                'Romaneio.vendedor_id',
                'Romaneio.comissao_comprador_valor',
                'Romaneio.comissao_comprador_data_pgto',
                'Romaneio.valor_liquido',
                'PessoaVendedor.nome_fantasia',
                'Pessoa.nome_fantasia'
            ],
            'group' => ['Romaneio.id'],
            'link' => ['RomaneioItem', 'Pessoa', 'PessoaVendedor'],
            'order' => ['Pessoa.nome_fantasia', 'Romaneio.data_emissao', 'Romaneio.numero_formatado'],
            //'limit' => 10
        ]);

        $thead = ['Data', 'Quant', 'Comissão', 'Vencto', 'Valor', 'Produtor'];
        $widthArr = [90, 50, 130, 90, 130, 250];
        
        //precisei criar essa var prq a ordem dos campos estava com problema
        $dados_retornar = ['dados' => [], 'thead' => $thead, 'widthArr' => $widthArr, 'totais' => []];

        $total_quantidade = 0;
        $total_valor_venda = 0;
        $total_comissao_comprador = 0;
        
        $count = 0;
        $ultimoComprador = '';
        foreach( $dados as $key => $dado ){

            if ( $ultimoComprador != $dado['Pessoa']['nome_fantasia'] ) {
                $dados_retornar['dados'][$count]['Romaneio']['frigorifico'] = $dado['Pessoa']['nome_fantasia'];
                $dados_retornar['dados'][$count]['total_cabecas'] = (float)0;
                $dados_retornar['dados'][$count]['valor_liquido'] = (float)0;
                $dados_retornar['dados'][$count]['comissao_comprador_valor'] = (float)0;
                $dados_retornar['dados'][$count]['anomes'] = '';
                $ultimoComprador = $dado['Pessoa']['nome_fantasia'];
                $count++;
            }            
            
            $dados_retornar['dados'][$count]['Romaneio']['data_emissao'] = $this->dateEnBr($dado['Romaneio']['data_emissao']);
            //$dados[$count]['totais']['comissao_comprador_valor'] = $dado['Romaneio']['comissao_comprador_valor'];
            //$dados[$count]['totais']['valor_liquido'] = $dado['Romaneio']['valor_liquido'];
            $dados_retornar['dados'][$count]['Romaneio']['total_cabecas'] = $dado['Romaneio']['total_cabecas'];
            $dados_retornar['dados'][$count]['Romaneio']['comissao_comprador_valor'] = 'R$ '.number_format($dado['Romaneio']['comissao_comprador_valor'], 2,',','.');
            $dados_retornar['dados'][$count]['Romaneio']['comissao_comprador_data_pgto'] = $this->dateEnBr($dado['Romaneio']['comissao_comprador_data_pgto']);
            $dados_retornar['dados'][$count]['Romaneio']['valor_liquido'] = 'R$ '.number_format($dado['Romaneio']['valor_liquido'], 2,',','.');
            $dados_retornar['dados'][$count]['Romaneio']['produtor'] = $dado['PessoaVendedor']['nome_fantasia'];
            $dados_retornar['dados'][$count]['anomes'] = date('Y',strtotime($dado['Romaneio']['data_emissao'])).(int)date('m',strtotime($dado['Romaneio']['data_emissao']));

            $dados_retornar['dados'][$count]['comprador_id'] = $dado['Romaneio']['comprador_id'];
            $dados_retornar['dados'][$count]['vendedor_id'] = $dado['Romaneio']['vendedor_id'];
            $dados_retornar['dados'][$count]['frigorifico'] = $dado['Pessoa']['nome_fantasia'];
            $dados_retornar['dados'][$count]['total_cabecas'] = (float)$dado['Romaneio']['total_cabecas'];
            $dados_retornar['dados'][$count]['valor_liquido'] = (float)$dado['Romaneio']['valor_liquido'];
            $dados_retornar['dados'][$count]['comissao_comprador_valor'] = (float)$dado['Romaneio']['comissao_comprador_valor'];
            $total_quantidade += $dado['Romaneio']['total_cabecas'];
            $total_valor_venda += $dado['Romaneio']['valor_liquido'];
            $total_comissao_comprador += $dado['Romaneio']['comissao_comprador_valor'];
            $count++;
        }

        $dados_retornar['totais'] = [
            '',
            number_format($total_quantidade,0,',','.'),
            'R$ '.number_format($total_comissao_comprador,2,',','.'),
            '',
            'R$ '.number_format($total_valor_venda,2,',','.'),
            '',
        ];


        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', "romaneios_gordo" => $dados_retornar))));
    }

    public function imprimir() {
        $this->layout = 'pdf';

        $dados = $this->Session->read('gordo_filtro');
        if (!isset($dados)) {
            echo "Por favor, realize o filtro na tela anterior e tente novamente.";
            die();
        }

        unset($dados['offset']);
        unset($dados['limit']);
        unset($dados['order']);

        $this->loadModel('Romaneio');

        $registros = $this->Romaneio->find('all', array_merge($dados, [
            'order' => ['Pessoa.nome_fantasia', 'Romaneio.data_emissao', 'Romaneio.numero']
        ]));

        foreach ($registros as $key => $val) {
        $this->Romaneio->RomaneioItem->virtualFields['_total_cabecas'] = 'SUM(RomaneioItem.cabecas)';

                $total_cab = $this->Romaneio->RomaneioItem->find('first', [
                    'fields' => ['RomaneioItem._total_cabecas'],
                    'conditions' => [
                        'RomaneioItem.romaneio_id' => $val['Romaneio']['id']
                    ]
                ]);

                $registros[$key]['Romaneio']['_cabecas'] = $total_cab['RomaneioItem']['_total_cabecas'];
        }


        $itens = array();
        foreach ($registros as $key => $val) {
            $itens[$val['Pessoa']['nome_fantasia']] = [
                'registros' => [],
                'total_cab' => 0,
                'total_fat' => 0,
                'total_com' => 0
            ];
        }
 foreach ($registros as $key => $val) {
            $itens[$val['Pessoa']['nome_fantasia']]['registros'][] = $val;
        }

        foreach ($itens as $frig => $val) {
            foreach ($val['registros'] as $re) {
                $itens[$frig]['total_cab'] += $re['Romaneio']['_cabecas'];
                $itens[$frig]['total_fat'] += $re['Romaneio']['valor_liquido'];
                $itens[$frig]['total_com'] += $re['Romaneio']['comissao_comprador_valor'];
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

    public function excluir($id) {
        $this->loadModel('Romaneio');
        $this->loadModel('RomaneioItem');
        $this->loadModel('Log');

        if ($id == '') {
            $this->Session->setFlash('Erro ao excluir romaneio.', 'flash_error');
            return $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        }
        
        $usuario_id = $this->Auth->user('id');
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
            "PessoaVendedor.nome_fantasia",
            'Romaneio.valor_liquido',
            'Romaneio.comissao_comprador_valor'
        );

        $conditions = array("Romaneio.tipo" => 0);
        

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
                'Romaneio.tipo' => 0
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

        $this->Session->write('gordo_filtro', $query_busca);

        $dados = $this->Romaneio->find('all',$query_busca);
        // debug($this->Romaneio->getDataSource()->getLog(false, false));die();

        $this->Romaneio->virtualFields['_total_vendido'] = 'SUM(Romaneio.valor_liquido)';
        $this->Romaneio->virtualFields['_total_comissoes'] = 'SUM(Romaneio.comissao_comprador_valor)';
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

        $iRecordsFiltered = $registrosFiltrados;
        $sEcho = intval($this->request->data['draw']);
        $records = array();
        $records["data"] = array();
        if ( count($dados) > 0 ) {
            foreach ( $dados as $dado ) {


                $total_cab = $this->Romaneio->RomaneioItem->find('first', [
                    'fields' => ['RomaneioItem._total_cabecas'],
                    'conditions' => [
                        'RomaneioItem.romaneio_id' => $dado['Romaneio']['id']
                    ]
                ]);
                if (!$total_cab) {
                    $total_cab = 0;
                } else {
                    $total_cab = $total_cab['RomaneioItem']['_total_cabecas'];
                }

                $radio = '<input type="checkbox" name="id[]" value="'.$dado['Romaneio']['id'].'">';

                $data_emissao = $this->dateEnBr($dado['Romaneio']['data_emissao']);

                $nromaneio = $dado['Romaneio']['numero'];

                $comprador = $dado['Pessoa']['nome_fantasia'];

                $vendedor = $dado['PessoaVendedor']['nome_fantasia'];

                $valor_total = 'R$ ' . number_format($dado['Romaneio']['valor_liquido'], 2, ',', '.');
                $comissao = 'R$ ' . number_format($dado['Romaneio']['comissao_comprador_valor'], 2, ',', '.');

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
                    $vendedor,
                    $valor_total,
                    $comissao,
                    $total_cab,
                    $actions
                );
            
            }
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iRecordsFiltered;
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
        $this->set('title_for_layout', 'Adicionar Romaneio Gordo');
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
        unset($dados_request['aux']);

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

        $dados_salvar = $dados_request;

        unset($dados_salvar['RomaneioGordo']['totais_cabecas'], $dados_salvar['RomaneioGordo']['totais_kg_carcaca'], $dados_salvar['RomaneioGordo']['totais_valor_total']);

        unset($dados_salvar['RomaneioGordo']['media_fazenda'], $dados_salvar['RomaneioGordo']['media_frigorifico'], $dados_salvar['RomaneioGordo']['media_carcaca'], $dados_salvar['RomaneioGordo']['media_cabeca']);
        
		unset($dados_salvar['RomaneioGordo']['rendimento_frigorifico'], $dados_salvar['RomaneioGordo']['rendimento_fazenda'], $dados_salvar['RomaneioGordo']['rendimento_quebra']);

        $this->loadModel('RomaneioGordo');
        $this->RomaneioGordo->set($dados_salvar);
        if ( !$this->RomaneioGordo->validates() ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->RomaneioGordo->validationErrors[key($this->RomaneioGordo->validationErrors)] ) ) ) );
        }

        if ($dados_request['RomaneioGordo']['especie_id'] == '') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Espécie é obrigatório!' ))));
        }

        if ( (isset($dados_salvar['RomaneioGordo']['tipoa_cabecas']) && isset($dados_salvar['RomaneioGordo']['tipoa_kg_carcaca']) && isset($dados_salvar['RomaneioGordo']['tipoa_valor_unitario'])) && 
        (!empty($dados_salvar['RomaneioGordo']['tipoa_cabecas']) && !empty($dados_salvar['RomaneioGordo']['tipoa_kg_carcaca']) && !empty($dados_salvar['RomaneioGordo']['tipoa_valor_unitario'])) ) {
            $dados_salvar['RomaneioItem'][0]['especie_id'] = $dados_salvar['RomaneioGordo']['especie_id'];
            $dados_salvar['RomaneioItem'][0]['peso'] = $dados_salvar['RomaneioGordo']['tipoa_kg_carcaca'];
            $dados_salvar['RomaneioItem'][0]['cabecas'] = $dados_salvar['RomaneioGordo']['tipoa_cabecas'];
            $dados_salvar['RomaneioItem'][0]['valor_unitario'] = $dados_salvar['RomaneioGordo']['tipoa_valor_unitario'];
            $dados_salvar['RomaneioItem'][0]['valor_total'] = $dados_salvar['RomaneioGordo']['tipoa_valor_total'];
            
            if ( (isset($dados_salvar['RomaneioGordo']['tipob_cabecas']) && isset($dados_salvar['RomaneioGordo']['tipob_kg_carcaca']) && isset($dados_salvar['RomaneioGordo']['tipob_valor_unitario'])) && 
            (!empty($dados_salvar['RomaneioGordo']['tipob_cabecas']) && !empty($dados_salvar['RomaneioGordo']['tipob_kg_carcaca']) && !empty($dados_salvar['RomaneioGordo']['tipob_valor_unitario'])) ) {
                $dados_salvar['RomaneioItem'][1]['especie_id'] = $dados_salvar['RomaneioGordo']['especie_id'];
                $dados_salvar['RomaneioItem'][1]['peso'] = $dados_salvar['RomaneioGordo']['tipob_kg_carcaca'];
                $dados_salvar['RomaneioItem'][1]['cabecas'] = $dados_salvar['RomaneioGordo']['tipob_cabecas'];
                $dados_salvar['RomaneioItem'][1]['valor_unitario'] = $dados_salvar['RomaneioGordo']['tipob_valor_unitario'];
                $dados_salvar['RomaneioItem'][1]['valor_total'] = $dados_salvar['RomaneioGordo']['tipob_valor_total'];
                
                if ( (isset($dados_salvar['RomaneioGordo']['tipoc_cabecas']) && isset($dados_salvar['RomaneioGordo']['tipoc_kg_carcaca']) && isset($dados_salvar['RomaneioGordo']['tipoc_valor_unitario'])) && 
                (!empty($dados_salvar['RomaneioGordo']['tipoc_cabecas']) && !empty($dados_salvar['RomaneioGordo']['tipoc_kg_carcaca']) && !empty($dados_salvar['RomaneioGordo']['tipoc_valor_unitario'])) ) {
                    $dados_salvar['RomaneioItem'][2]['especie_id'] = $dados_salvar['RomaneioGordo']['especie_id'];
                    $dados_salvar['RomaneioItem'][2]['peso'] = $dados_salvar['RomaneioGordo']['tipoc_kg_carcaca'];
                    $dados_salvar['RomaneioItem'][2]['cabecas'] = $dados_salvar['RomaneioGordo']['tipoc_cabecas'];
                    $dados_salvar['RomaneioItem'][2]['valor_unitario'] = $dados_salvar['RomaneioGordo']['tipoc_valor_unitario'];
                    $dados_salvar['RomaneioItem'][2]['valor_total'] = $dados_salvar['RomaneioGordo']['tipoc_valor_total'];
                }
            }
            unset($dados_salvar['RomaneioGordo']['tipoa_kg_carcaca'], $dados_salvar['RomaneioGordo']['tipoa_cabecas'], $dados_salvar['RomaneioGordo']['tipoa_valor_unitario'], $dados_salvar['RomaneioGordo']['tipoa_valor_total']);
            unset($dados_salvar['RomaneioGordo']['tipob_kg_carcaca'], $dados_salvar['RomaneioGordo']['tipob_cabecas'], $dados_salvar['RomaneioGordo']['tipob_valor_unitario'], $dados_salvar['RomaneioGordo']['tipob_valor_total']);
            unset($dados_salvar['RomaneioGordo']['tipoc_kg_carcaca'], $dados_salvar['RomaneioGordo']['tipoc_cabecas'], $dados_salvar['RomaneioGordo']['tipoc_valor_unitario'], $dados_salvar['RomaneioGordo']['tipoc_valor_total']);
            unset($dados_salvar['RomaneioGordo']['especie_id']);
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Caso seja apenas um Tipo o mesmo deve ser informado nos campos do Tipo A.' ))));
        }

        if ($dados_request['RomaneioGordo']['valor_liquido'] == '' || $dados_request['RomaneioGordo']['valor_liquido'] == '0,00') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Valor Total Líquido é obrigatório!' ))));
        }

        if ($dados_request['RomaneioGordo']['comissao_comprador_porcentual'] == '' || $dados_request['RomaneioGordo']['comissao_comprador_porcentual'] == 'NaN') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Comprador Perc. Comissão é obrigatório!' ))));
        }
        if ($dados_request['RomaneioGordo']['comissao_comprador_valor'] == '' || $dados_request['RomaneioGordo']['comissao_comprador_valor'] == 'NaN') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Valor Comissão é obrigatório!' ))));
        }
        if ($dados_request['RomaneioGordo']['comissao_comprador_data_pgto'] == '') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Data Pagamento é obrigatório!' ))));
        }

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
        $this->RomaneioGordo->create();
        if ( $this->RomaneioGordo->saveAssociated($dados_salvar) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Cadastro realizado com sucesso!" ))));
        } else {
            // debug($this->RomaneioGordo->getDataSource()->getLog(false, false));
            // debug($this->RomaneioGordo->validationErrors);
            // debug($this->RomaneioGordo->invalidFields());
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar o Cadastro. Por favor, tente novamente em alguns instantes." ))));
        }
    }

    public function alterar($id = null) {
        $this->set('title_for_layout', 'Alterar Romaneio Gordo');
        if ( !empty($this->request->data) ) {
            if ( $this->request->data['RomaneioGordo']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Romaneio a ser alterado não informado."))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        if ($id == null) {
            $this->redirect(array('action' => 'index'));
            die();
        }

        $this->loadModel('RomaneioGordo');
        $dados = $this->RomaneioGordo->findById($id);
        
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

        $vencimentos = $this->RomaneioGordo->RomaneioVencimento->find('all', [
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

        // die(debug($dados));

        $dados['RomaneioGordo']['tipoa_kg_carcaca'] = $dados['RomaneioGordo']['tipoa_cabecas'] = $dados['RomaneioGordo']['tipoa_valor_unitario'] = $dados['RomaneioGordo']['tipoa_valor_total'] = null;
        $dados['RomaneioGordo']['tipob_kg_carcaca'] = $dados['RomaneioGordo']['tipob_cabecas'] = $dados['RomaneioGordo']['tipob_valor_unitario'] = $dados['RomaneioGordo']['tipob_valor_total'] = null;
        $dados['RomaneioGordo']['tipoc_kg_carcaca'] = $dados['RomaneioGordo']['tipoc_cabecas'] = $dados['RomaneioGordo']['tipoc_valor_unitario'] = $dados['RomaneioGordo']['tipoc_valor_total'] = null;
        for ($x = 0; $x < count($itens); $x++) {
            if (!empty($itens[$x]['RomaneioItem']) && $x==0) { // TIPO A
                $dados['RomaneioGordo']['especie_id']           = $itens[$x]['RomaneioItem']['especie_id'];
                $dados['RomaneioGordo']['tipoa_kg_carcaca']     = $itens[$x]['RomaneioItem']['peso'];
                $dados['RomaneioGordo']['tipoa_cabecas']        = $itens[$x]['RomaneioItem']['cabecas'];
                $dados['RomaneioGordo']['tipoa_valor_unitario'] = $itens[$x]['RomaneioItem']['valor_unitario'];
                $dados['RomaneioGordo']['tipoa_valor_total']    = $itens[$x]['RomaneioItem']['valor_total'];
            }
            if (!empty($itens[$x]['RomaneioItem']) && $x==1) { // TIPO B
                $dados['RomaneioGordo']['especie_id']           = $itens[$x]['RomaneioItem']['especie_id'];
                $dados['RomaneioGordo']['tipob_kg_carcaca']     = $itens[$x]['RomaneioItem']['peso'];
                $dados['RomaneioGordo']['tipob_cabecas']        = $itens[$x]['RomaneioItem']['cabecas'];
                $dados['RomaneioGordo']['tipob_valor_unitario'] = $itens[$x]['RomaneioItem']['valor_unitario'];
                $dados['RomaneioGordo']['tipob_valor_total']    = $itens[$x]['RomaneioItem']['valor_total'];
            }
            if (!empty($itens[$x]['RomaneioItem']) && $x==2) { // TIPO C
                $dados['RomaneioGordo']['especie_id']           = $itens[$x]['RomaneioItem']['especie_id'];
                $dados['RomaneioGordo']['tipoc_kg_carcaca']     = $itens[$x]['RomaneioItem']['peso'];
                $dados['RomaneioGordo']['tipoc_cabecas']        = $itens[$x]['RomaneioItem']['cabecas'];
                $dados['RomaneioGordo']['tipoc_valor_unitario'] = $itens[$x]['RomaneioItem']['valor_unitario'];
                $dados['RomaneioGordo']['tipoc_valor_total']    = $itens[$x]['RomaneioItem']['valor_total'];
            }
        }

        $dados['RomaneioGordo']['totais_cabecas'] = 0.0;
        if (!is_null($dados['RomaneioGordo']['tipoa_cabecas'])) $dados['RomaneioGordo']['totais_cabecas'] += $dados['RomaneioGordo']['tipoa_cabecas'];
        if (!is_null($dados['RomaneioGordo']['tipob_cabecas'])) $dados['RomaneioGordo']['totais_cabecas'] += $dados['RomaneioGordo']['tipob_cabecas'];
        if (!is_null($dados['RomaneioGordo']['tipoc_cabecas'])) $dados['RomaneioGordo']['totais_cabecas'] += $dados['RomaneioGordo']['tipoc_cabecas'];

        $dados['RomaneioGordo']['totais_kg_carcaca'] = 0.0;
        if (!is_null($dados['RomaneioGordo']['tipoa_kg_carcaca'])) $dados['RomaneioGordo']['totais_kg_carcaca'] += $dados['RomaneioGordo']['tipoa_kg_carcaca'];
        if (!is_null($dados['RomaneioGordo']['tipob_kg_carcaca'])) $dados['RomaneioGordo']['totais_kg_carcaca'] += $dados['RomaneioGordo']['tipob_kg_carcaca'];
        if (!is_null($dados['RomaneioGordo']['tipoc_kg_carcaca'])) $dados['RomaneioGordo']['totais_kg_carcaca'] += $dados['RomaneioGordo']['tipoc_kg_carcaca'];

        $dados['RomaneioGordo']['totais_valor_total'] = 0.0;
        if (!is_null($dados['RomaneioGordo']['tipoa_valor_total'])) $dados['RomaneioGordo']['totais_valor_total'] += $dados['RomaneioGordo']['tipoa_valor_total'];
        if (!is_null($dados['RomaneioGordo']['tipob_valor_total'])) $dados['RomaneioGordo']['totais_valor_total'] += $dados['RomaneioGordo']['tipob_valor_total'];
        if (!is_null($dados['RomaneioGordo']['tipoc_valor_total'])) $dados['RomaneioGordo']['totais_valor_total'] += $dados['RomaneioGordo']['tipoc_valor_total'];

        $dados['RomaneioGordo']['media_fazenda'] = $dados['RomaneioGordo']['peso_fazenda_total'] / $this->validZeroToDivision($dados['RomaneioGordo']['totais_cabecas']);
        $dados['RomaneioGordo']['media_frigorifico'] = $dados['RomaneioGordo']['peso_frigorifico'] / $this->validZeroToDivision($dados['RomaneioGordo']['totais_cabecas']);
        $dados['RomaneioGordo']['media_carcaca'] = $dados['RomaneioGordo']['totais_kg_carcaca'] / $this->validZeroToDivision($dados['RomaneioGordo']['totais_cabecas']);
        $dados['RomaneioGordo']['media_cabeca'] = $dados['RomaneioGordo']['tipoa_valor_unitario'];

        $dados['RomaneioGordo']['rendimento_frigorifico'] = ($dados['RomaneioGordo']['totais_kg_carcaca'] / $this->validZeroToDivision($dados['RomaneioGordo']['peso_frigorifico'])) * 100;
        $dados['RomaneioGordo']['rendimento_fazenda'] = ($dados['RomaneioGordo']['totais_kg_carcaca'] / $this->validZeroToDivision($dados['RomaneioGordo']['peso_fazenda_total'])) * 100;
        $dados['RomaneioGordo']['rendimento_quebra'] = 100 - (($dados['RomaneioGordo']['peso_frigorifico'] * 100) / $this->validZeroToDivision($dados['RomaneioGordo']['peso_fazenda_total']));

        // die(debug($dados));

        $this->loadModel('Pessoa');
        $listaProdutores = $listaFrigorificos = $this->Pessoa->findListAllPessoas();

        if (!is_null($dados['RomaneioGordo']['vendedor_localidade_id'])) {
            $this->loadModel('PessoaLocalidade');
            $localidade = $this->PessoaLocalidade->findById($dados['RomaneioGordo']['vendedor_localidade_id']);
            $dados = array_merge($dados, $localidade);
        }

        $this->loadModel('RomaneioEspecie');
        $listaEspecies = $this->RomaneioEspecie->listaRomaneioEspecie();

        $this->loadModel('RomaneioArquivo');
        $arquivos = $this->RomaneioArquivo->arquivosByRomaneioId($id);

        $this->set(compact('dados', 'listaFrigorificos', 'listaProdutores', 'listaEspecies', 'arquivos', 'vencimentos'));

    }

    private function update() {
        $dados_request = $this->request->data;
        unset($dados_request['aux']);
        
        if ( !isset($dados_request['RomaneioGordo']['id']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Romaneio não informado."))));
        }
        
        $this->loadModel('RomaneioGordo');
        $dados = $this->RomaneioGordo->findById($dados_request['RomaneioGordo']['id']);
        
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

        $dados_salvar = $dados_request;

        unset($dados_salvar['RomaneioGordo']['totais_cabecas'], $dados_salvar['RomaneioGordo']['totais_kg_carcaca'], $dados_salvar['RomaneioGordo']['totais_valor_total']);

        unset($dados_salvar['RomaneioGordo']['media_fazenda'], $dados_salvar['RomaneioGordo']['media_frigorifico'], $dados_salvar['RomaneioGordo']['media_carcaca'], $dados_salvar['RomaneioGordo']['media_cabeca']);
        
		unset($dados_salvar['RomaneioGordo']['rendimento_frigorifico'], $dados_salvar['RomaneioGordo']['rendimento_fazenda'], $dados_salvar['RomaneioGordo']['rendimento_quebra']);

        $this->loadModel('RomaneioGordo');

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

            $this->RomaneioGordo->RomaneioVencimento->deleteAll(['RomaneioVencimento.romaneio_id' => $dados_salvar['RomaneioGordo']['id']]);
        }

        $this->RomaneioGordo->set($dados_salvar);
        if ( !$this->RomaneioGordo->validates() ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->RomaneioGordo->validationErrors[key($this->RomaneioGordo->validationErrors)] ) ) ) );
        }

        if ($dados_request['RomaneioGordo']['especie_id'] == '') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Espécie é obrigatório!' ))));
        }

        if ( (isset($dados_salvar['RomaneioGordo']['tipoa_cabecas']) && isset($dados_salvar['RomaneioGordo']['tipoa_kg_carcaca']) && isset($dados_salvar['RomaneioGordo']['tipoa_valor_unitario'])) && 
        (!empty($dados_salvar['RomaneioGordo']['tipoa_cabecas']) && !empty($dados_salvar['RomaneioGordo']['tipoa_kg_carcaca']) && !empty($dados_salvar['RomaneioGordo']['tipoa_valor_unitario'])) ) {
            $dados_salvar['RomaneioItem'][0]['especie_id'] = $dados_salvar['RomaneioGordo']['especie_id'];
            $dados_salvar['RomaneioItem'][0]['peso'] = $dados_salvar['RomaneioGordo']['tipoa_kg_carcaca'];
            $dados_salvar['RomaneioItem'][0]['cabecas'] = $dados_salvar['RomaneioGordo']['tipoa_cabecas'];
            $dados_salvar['RomaneioItem'][0]['valor_unitario'] = $dados_salvar['RomaneioGordo']['tipoa_valor_unitario'];
            $dados_salvar['RomaneioItem'][0]['valor_total'] = $dados_salvar['RomaneioGordo']['tipoa_valor_total'];
            
            if ( (isset($dados_salvar['RomaneioGordo']['tipob_cabecas']) && isset($dados_salvar['RomaneioGordo']['tipob_kg_carcaca']) && isset($dados_salvar['RomaneioGordo']['tipob_valor_unitario'])) && 
            (!empty($dados_salvar['RomaneioGordo']['tipob_cabecas']) && !empty($dados_salvar['RomaneioGordo']['tipob_kg_carcaca']) && !empty($dados_salvar['RomaneioGordo']['tipob_valor_unitario'])) ) {
                $dados_salvar['RomaneioItem'][1]['especie_id'] = $dados_salvar['RomaneioGordo']['especie_id'];
                $dados_salvar['RomaneioItem'][1]['peso'] = $dados_salvar['RomaneioGordo']['tipob_kg_carcaca'];
                $dados_salvar['RomaneioItem'][1]['cabecas'] = $dados_salvar['RomaneioGordo']['tipob_cabecas'];
                $dados_salvar['RomaneioItem'][1]['valor_unitario'] = $dados_salvar['RomaneioGordo']['tipob_valor_unitario'];
                $dados_salvar['RomaneioItem'][1]['valor_total'] = $dados_salvar['RomaneioGordo']['tipob_valor_total'];
                
                if ( (isset($dados_salvar['RomaneioGordo']['tipoc_cabecas']) && isset($dados_salvar['RomaneioGordo']['tipoc_kg_carcaca']) && isset($dados_salvar['RomaneioGordo']['tipoc_valor_unitario'])) && 
                (!empty($dados_salvar['RomaneioGordo']['tipoc_cabecas']) && !empty($dados_salvar['RomaneioGordo']['tipoc_kg_carcaca']) && !empty($dados_salvar['RomaneioGordo']['tipoc_valor_unitario'])) ) {
                    $dados_salvar['RomaneioItem'][2]['especie_id'] = $dados_salvar['RomaneioGordo']['especie_id'];
                    $dados_salvar['RomaneioItem'][2]['peso'] = $dados_salvar['RomaneioGordo']['tipoc_kg_carcaca'];
                    $dados_salvar['RomaneioItem'][2]['cabecas'] = $dados_salvar['RomaneioGordo']['tipoc_cabecas'];
                    $dados_salvar['RomaneioItem'][2]['valor_unitario'] = $dados_salvar['RomaneioGordo']['tipoc_valor_unitario'];
                    $dados_salvar['RomaneioItem'][2]['valor_total'] = $dados_salvar['RomaneioGordo']['tipoc_valor_total'];
                }
            }
            unset($dados_salvar['RomaneioGordo']['tipoa_kg_carcaca'], $dados_salvar['RomaneioGordo']['tipoa_cabecas'], $dados_salvar['RomaneioGordo']['tipoa_valor_unitario'], $dados_salvar['RomaneioGordo']['tipoa_valor_total']);
            unset($dados_salvar['RomaneioGordo']['tipob_kg_carcaca'], $dados_salvar['RomaneioGordo']['tipob_cabecas'], $dados_salvar['RomaneioGordo']['tipob_valor_unitario'], $dados_salvar['RomaneioGordo']['tipob_valor_total']);
            unset($dados_salvar['RomaneioGordo']['tipoc_kg_carcaca'], $dados_salvar['RomaneioGordo']['tipoc_cabecas'], $dados_salvar['RomaneioGordo']['tipoc_valor_unitario'], $dados_salvar['RomaneioGordo']['tipoc_valor_total']);
            unset($dados_salvar['RomaneioGordo']['especie_id']);
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Caso seja apenas um Tipo deve o mesmo ser informado nos campos do Tipo A.' ))));
        }

        if ($dados_request['RomaneioGordo']['valor_liquido'] == '' || $dados_request['RomaneioGordo']['valor_liquido'] == '0,00') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Valor Total Líquido é obrigatório!' ))));
        }

        if ($dados_request['RomaneioGordo']['comissao_comprador_porcentual'] == '' || $dados_request['RomaneioGordo']['comissao_comprador_porcentual'] == 'NaN') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Comprador Perc. Comissão é obrigatório!' ))));
        }
        if ($dados_request['RomaneioGordo']['comissao_comprador_valor'] == '' || $dados_request['RomaneioGordo']['comissao_comprador_valor'] == 'NaN') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Valor Comissão é obrigatório!' ))));
        }
        if ($dados_request['RomaneioGordo']['comissao_comprador_data_pgto'] == '') {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'O campo Data Pagamento é obrigatório!' ))));
        }

        $this->loadModel('RomaneioItem');

        //die(debug($dados_salvar));
        if ($this->RomaneioItem->deleteAll(array('RomaneioItem.romaneio_id' => $dados_salvar['RomaneioGordo']['id']), false)) {
            if ( $this->RomaneioGordo->saveAssociated($dados_salvar) ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Alteração realizada com sucesso!" ))));
            } else {
                // debug($this->RomaneioGordo->getDataSource()->getLog(false, false));
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar realizar a Alteração. Por favor, tente novamente em alguns instantes." ))));
            }
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "0correu um erro inesperado ao tentar realizar a Alteração. Por favor, tente novamente em alguns instantes." ))));
        }
    }

}

?>