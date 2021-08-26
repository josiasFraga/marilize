<?php
class ContasController extends AppController {
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

    
    protected function dataTable($tipo = null) {

        $this->layout = "ajax";

        if ( !$this->request->is('post') || empty($this->request->data) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Requisição inválida!' ))));
        }

        if ( isset($this->request->data['order']) ) $order = $this->request->data['order'];

        $arr_columns_order = array(
            "",
            "PagamentoData.data_venc",
            "PagamentoData.data_pago",
            "Empresa.nome",
            "Pessoa.nome_fantasia",
            "PagamentoCategoria.categoria",
            "",
            "PagamentoData.valor",
            "",
            "PagamentoStatus.status"
        );

        $conditions = array();

        if (!is_null($tipo)) {
            $conditions = array_merge($conditions, array("PagamentoData.tipo" => $tipo));
        }
        $conditions = array_merge($conditions, array("PagamentoData.ativo" => 'Y'));

        if (!isset($this->request->data['data_venc']) && !isset($this->request->data['data_venc_ate'])) {
            $conditions = array_merge($conditions, array("PagamentoData.data_venc BETWEEN ? AND ?" => [date('Y-m-01'), date('Y-m-t')]));
        } else {
            if (!empty($this->request->data['data_venc'])) {
                $conditions = array_merge($conditions, array("PagamentoData.data_venc >=" => $this->request->data["data_venc"]));
            }

            if (!empty($this->request->data['data_venc_ate'])) {
                $conditions = array_merge($conditions, array("PagamentoData.data_venc <=" => $this->request->data['data_venc_ate']));
            }

            /*if (empty($this->request->data['data_venc']) && empty($this->request->data['data_venc_ate'])) {
                $conditions = array_merge($conditions, array("PagamentoData.data_venc BETWEEN ? AND ?" => [date('Y-m-01'), date('Y-m-t')]));
            }*/
        }

        if (isset($this->request->data['data_pgto']) && !empty($this->request->data['data_pgto'])) {
            $conditions = array_merge($conditions, array("PagamentoData.data_pago >=" => $this->request->data["data_pgto"]));
        }

        if (isset($this->request->data['data_pgto_ate']) && !empty($this->request->data['data_pgto_ate'])) {
            $conditions = array_merge($conditions, array("PagamentoData.data_pago <=" => $this->request->data['data_pgto_ate']));
        }

        if ( $this->dataTable->check_filtro("empresa_id", "numeric") === true){
            $conditions = array_merge($conditions, array("PagamentoData.empresa_id" => $this->request->data["empresa_id"]));
        }

        if ( $this->dataTable->check_filtro("fornecedor_id", "numeric") === true){
            $conditions = array_merge($conditions, array("PagamentoData.fornecedor_id" => $this->request->data["fornecedor_id"]));
        }

        if ( $this->dataTable->check_filtro("categoria_id", "numeric") === true){
            $conditions = array_merge($conditions, array("PagamentoData.categoria_id" => $this->request->data["categoria_id"]));
        }
        
        if ( $this->dataTable->check_filtro("status_id", "numeric") === true){
            $conditions = array_merge($conditions, array("PagamentoData.status_id" => $this->request->data["status_id"]));
        }

        if ( isset($arr_columns_order[$order[0]['column']]) && isset($order[0]['dir']) && ($order[0]['dir'] == 'asc' || $order[0]['dir'] == 'desc')) {
            $order = $arr_columns_order[$order[0]['column']]." ".$order[0]['dir'];
        }

        $this->loadModel('PagamentoData');

        $iTotalRecords = $this->PagamentoData->find('count');

        $iDisplayLength = intval($this->request->data['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($this->request->data['start']);

        $filtro_dados = array(
            'conditions' => $conditions,
            'order' => $order,
            'fields' => array(
                'PagamentoData.*',
                'PagamentoCategoria.*',
                'PagamentoStatus.*',
                'PagamentoForma.*',
                'Empresa.nome',
                'Pessoa.nome_fantasia'
            ),
            'link' => array(
                'PagamentoCategoria',
                'PagamentoStatus',
                'PagamentoForma',
                'Empresa',
                'Pessoa'
            ),
            'offset' => $iDisplayStart,
            'limit' => $iDisplayLength
        );
        $dados = $this->PagamentoData->find('all', $filtro_dados);
        $this->Session->write('contas_filtro', $filtro_dados);

        $registrosFiltrados = $this->PagamentoData->find("count", array(
            'conditions' => $conditions,
            'link' => array(
                'PagamentoCategoria',
                'PagamentoStatus',
                'PagamentoForma'
            ),
        ));

        // debug($dados); die();

        $iRecordsFiltered = $registrosFiltrados;
        $sEcho = intval($this->request->data['draw']);
        $records = array();
        $records["data"] = array();

        $hoje = date('Y-m-d');

        if ( count($dados) > 0 ) {

            foreach ( $dados as $dado ) {

                $radio = '<input type="checkbox" name="id[]" value="'.$dado['PagamentoData']['id'].'">';

                $data_venc = date('d/m/Y', strtotime($dado['PagamentoData']['data_venc']));
                if (!is_null($dado['PagamentoData']['data_pago'])) {
                    $data_pgto = date('d/m/Y', strtotime($dado['PagamentoData']['data_pago']));
                } else {
                    $data_pgto = '';
                }

                $data_pago = date('d/m/Y', strtotime($dado['PagamentoData']['data_pago']));
                $nparcelas_total = $this->PagamentoData->find('count', [
                    'conditions' => [
                        'PagamentoData.conta_id' => $dado['PagamentoData']['conta_id']
                    ]
                ]);

                $data_venc_compara = date('Y-m-d', strtotime($dado['PagamentoData']['data_venc']));

                $valor = "R&#36; ".number_format($dado['PagamentoData']['valor'], 2, ',', '.');

                $obs = $dado['PagamentoData']['observacoes'];
                
                $actions = "";
 
                $categoria = $dado['PagamentoCategoria']['categoria'];

                $status = "";
                if ($dado['PagamentoStatus']['id'] == 1 && $data_venc_compara <= $hoje) {
                    // $status = '<span class="label label-sm label-danger">'.$dado['PagamentoStatus']['titulo'].'</span>';
                    
                    $status = '<button title="Vencido em '.$data_venc.'" type="button" class="btn btn-icon-only red" data-toggle="modal" data-target="#modalAddPagamento" data-whatever="'.$dado['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>';
                } else if ($dado['PagamentoStatus']['id'] == 3) {
                    // $status = '<span class="label label-sm label-success">'.$dado['PagamentoStatus']['titulo'].'</span>';

                    $status = '<button title="Pago em '.$data_pago.'" type="button" class="btn btn-icon-only green" data-toggle="modal" data-target="#modalDataPago" data-whatever="'.$dado['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>';
                } else {
                    // $status = '<span class="label label-sm label-warning">'.$dado['PagamentoStatus']['titulo'].'</span>';

                    $status = '<button title="Vence em '.$data_venc.'" type="button" class="btn btn-icon-only yellow-lemon" data-toggle="modal" data-target="#modalAddPagamento" data-whatever="'.$dado['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>';
                }

                $nparcela = $dado['PagamentoData']['nparcela'];

                $btn_alterar = '<a href="'.Router::url(array('controller' => $this->name, 'action' => 'alterar', $dado['PagamentoData']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>';

                $btn_excluir = '<a href="#" class="btn btn-icon-only red btn-remove" data-id="'.$dado['PagamentoData']['id'].'"><i class="fa fa-trash"></i></a>';

                $actions = $btn_alterar.' '.$btn_excluir;

                $records["data"][] = array(
                    $radio,
                    $data_venc,
                    $data_pgto,
                    $dado['Empresa']['nome'],
                    $dado['Pessoa']['nome_fantasia'],
                    $categoria,
                    $nparcela . '/' . $nparcelas_total,
                    $valor,
                    $obs,
                    $status,
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

    public function excluir( $id = null ) {
        $this->layout = 'ajax';

        if ( is_null($id) || !is_numeric($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "warning", "msg" => "Item não encontrado." ))));
        }

        $this->loadModel('PagamentoData');
        $dados = $this->PagamentoData->findById($id);

        if ( count($dados) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "A Conta que você está tentando excluir não existe."))));
        }

        if ( $this->PagamentoData->delete($id) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Conta excluída com sucesso." ))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir o Conta. Por favor, tente mais tarde."))));
        }

    }

    protected function save() {
        $dados_request = $this->request->data; 
        $nparcelas = $dados_request['nparcelas'];

        unset($dados_request['nparcelas']);

        $this->loadModel('PagamentoData');
        if (!empty($dados_request['PagamentoData']['data_venc'])) {
            $data_venc = $this->dateBrEn($dados_request['PagamentoData']['data_venc']);
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A data de vencimento deve ser informada!"))));
        }
        $data_pago = null;

        if (empty($dados_request['PagamentoData']['empresa_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A empresa não pode estar em branco!"))));
        }
        if (empty($dados_request['PagamentoData']['fornecedor_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "O fornecedor não pode estar em branco!"))));
        }

        if ($dados_request['PagamentoData']['status_id'] == 3) {
            if ($dados_request['PagamentoData']['data_pago'] != "" && $dados_request['PagamentoData']['data_pago'] != null) {
                $data_pago = $this->dateBrEn($dados_request['PagamentoData']['data_pago']);
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A data do pagamento não pode estar em branco!"))));
            }
            if ($dados_request['PagamentoData']['forma_id'] == "") {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A forma do pagamento deve ser informada!"))));
            }
        }

        $status_id = $dados_request['PagamentoData']['status_id'];
        $forma_id = (!empty($dados_request['PagamentoData']['forma_id']))? $dados_request['PagamentoData']['forma_id']: 1;
        $categoria_id = $dados_request['PagamentoData']['categoria_id'];
        $tipo = $dados_request['PagamentoData']['tipo'];
        $valor = $dados_request['PagamentoData']['valor'];
        $observacoes = $dados_request['PagamentoData']['observacoes'];
        $fornecedor_id = $dados_request['PagamentoData']['fornecedor_id'];
        $empresa_id = $dados_request['PagamentoData']['empresa_id'];
        $ndocumento = $dados_request['PagamentoData']['ndocumento'];
        $conta_id = md5(time().uniqid());
        
        $dados_salvar = array();

        if ($nparcelas != "" && $nparcelas > 1) {
            foreach ($dados_request['parcelas'] as $key => $parcela) {
                $dados_salvar[$key]['PagamentoData']['data_venc'] = implode("-",array_reverse(explode("/", $parcela['data'])));
                if ($key == 0) {
                    $dados_salvar[$key]['PagamentoData']['data_pago'] = $data_pago;
                } else {
                    $dados_salvar[$key]['PagamentoData']['data_pago'] = NULL;
                }
                $dados_salvar[$key]['PagamentoData']['nparcela'] = $key+1;
                if ($key == 0) {
                    $dados_salvar[$key]['PagamentoData']['status_id'] = $status_id;
                } else {
                    $dados_salvar[$key]['PagamentoData']['status_id'] = 1; // aguardando, pois não é a primeira parcela

                }
                $dados_salvar[$key]['PagamentoData']['forma_id'] = $forma_id;
                $dados_salvar[$key]['PagamentoData']['categoria_id'] = $categoria_id;
                $dados_salvar[$key]['PagamentoData']['valor'] = $parcela['valor'];
                $dados_salvar[$key]['PagamentoData']['tipo'] = $tipo;
                $dados_salvar[$key]['PagamentoData']['observacoes'] = $observacoes;
                $dados_salvar[$key]['PagamentoData']['conta_id'] = $conta_id;
                $dados_salvar[$key]['PagamentoData']['empresa_id'] = $empresa_id;
                $dados_salvar[$key]['PagamentoData']['fornecedor_id'] = $fornecedor_id;
                $dados_salvar[$key]['PagamentoData']['ndocumento'] = $ndocumento;
                $key++;
                
            }
        } else {
            $dados_salvar[0]['PagamentoData']['data_venc'] = implode("-",array_reverse(explode("/", $data_venc)));
            $dados_salvar[0]['PagamentoData']['data_pago'] = $data_pago;
            $dados_salvar[0]['PagamentoData']['nparcela'] = 1;
            $dados_salvar[0]['PagamentoData']['status_id'] = $status_id;
            $dados_salvar[0]['PagamentoData']['forma_id'] = $forma_id;
            $dados_salvar[0]['PagamentoData']['categoria_id'] = $categoria_id;
            $dados_salvar[0]['PagamentoData']['valor'] = $valor;
            $dados_salvar[0]['PagamentoData']['tipo'] = $tipo;
            $dados_salvar[0]['PagamentoData']['observacoes'] = $observacoes;
            $dados_salvar[0]['PagamentoData']['conta_id'] = $conta_id;
            $dados_salvar[0]['PagamentoData']['empresa_id'] = $empresa_id;
            $dados_salvar[0]['PagamentoData']['fornecedor_id'] = $fornecedor_id;
            $dados_salvar[0]['PagamentoData']['ndocumento'] = $ndocumento;
        }

        // die(debug($dados_salvar));
        $error = "";
        foreach ($dados_salvar as $dado) {
            $this->PagamentoData->set($dado);
            if (!$this->PagamentoData->validates()) {
                $error = $this->PagamentoData->validationErrors[key($this->PagamentoData->validationErrors)];
                break;
            }
        }
        if (!empty($error)) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $error))));
        }
        
        foreach ($dados_salvar as $dado) {

            $this->PagamentoData->create();
            if (!$this->PagamentoData->save($dado) ) {
                $this->PagamentoData->deleteAll(['PagamentoData.conta_id' => $dados_salvar[0]['PagamentoData']['conta_id']]);
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar cadastrar Conta. Por favor, tente novamente em alguns instantes." ))));
                // debug($this->PagamentoData->getDataSource()->getLog(false, false));
            }
        }
        return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Conta cadastrada com sucesso!" ))));


    }

    protected function update() {

        if ( !isset($this->request->data['PagamentoData']['id']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Conta não informada." ))));
        }

        $dados_request = $this->request->data;

        if (empty($dados_request['PagamentoData']['empresa_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A empresa não pode estar em branco!"))));
        }
        if (empty($dados_request['PagamentoData']['fornecedor_id'])) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "O fornecedor não pode estar em branco!"))));
        }

        $data_pago = null;
        if ($dados_request['PagamentoData']['status_id'] == 3) {
            if ($dados_request['PagamentoData']['data_pago'] != "" && $dados_request['PagamentoData']['data_pago'] != null) {
                $data_pago = $this->dateBrEn($dados_request['PagamentoData']['data_pago']);
                $dados_request['PagamentoData']['data_pago'] = $data_pago;
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A data do pagamento não pode estar em branco!"))));
            }
            if ($dados_request['PagamentoData']['forma_id'] == '') {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A forma do pagamento não pode estar em branco!"))));
            }
        } else {
            $dados_request['PagamentoData']['data_pago'] = null;
        }

        $this->loadModel('PagamentoData');
        $dados_pagamento_data = $this->PagamentoData->findById($dados_request['PagamentoData']['id']);
        if ( !$dados_pagamento_data || count($dados_pagamento_data) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Dados inexistentes.'))));
        }

        if ($dados_request['PagamentoData']['data_venc'] != "") {
            $dados_request['PagamentoData']['data_venc'] = date($this->dateBrEn($dados_request['PagamentoData']['data_venc']));
        }

        $this->PagamentoData->set($dados_request);
        if ( $this->PagamentoData->validates() ) {
            if ( $this->PagamentoData->save($dados_request) ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Conta alterada com sucesso!" ))));
            } else {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar conta. Por favor, tente novamente em alguns instantes."))));
                //debug($this->PagamentoData->getDataSource()->getLog(false, false));
            }
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => $this->PagamentoData->validationErrors[key($this->PagamentoData->validationErrors)] ))));
        }

    }

    public function view_data_pago($id = null) {

        if ($id == null || !is_numeric($id)) {
			$this->redirect(array('action' => 'index')); die();
		}
		
        $this->layout = "ajax";

        $this->loadModel('PagamentoData');
        $dados = $this->PagamentoData->find('first', array(
            'conditions' => array(
                'PagamentoData.id' => $id
            ),
            'fields' => array(
                'PagamentoData.*',
                'PagamentoForma.*'
            ),
            'link' => array(
                'PagamentoForma'
            )
        ));
		$this->set(compact('dados'));

    }

    public function edit_data_pago() {
        if ( !empty($this->request->data) ) {
            if ( $this->request->data['PagamentoData']['id'] == NULL ) {
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Conta a ser alterada não informada."))));
			}
            $this->layout = "ajax";
            return $this->update_data_pago();
        }
    }

    private function update_data_pago() {
        $this->layout = "ajax";
        if ( !isset($this->request->data['PagamentoData']['id']) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', "msg" => "Conta a ser alterada não informada." ))));
        }

        $dados_request = $this->request->data;

        if ( $dados_request['PagamentoData']['data_pago'] == "" || is_null($dados_request['PagamentoData']['data_pago']) ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Data de pagamento inválida!" ))));
        }

        if ( $dados_request['PagamentoData']['forma_id'] == "" ) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "A forma de pagamento deve ser informada!" ))));
        }

        $this->loadModel('PagamentoData');

        $dados_pagto = $this->PagamentoData->findById($this->request->data['PagamentoData']['id']);
        
        if ( !$dados_pagto || count($dados_pagto) == 0 ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => 'Conta a ser alterada inexistente!' ))));
        }

        $data_db = $this->dateBrEn($dados_request['PagamentoData']['data_pago']);
		$data_invalida = "1969-12-31";
		$data_pago = explode("-", $data_db);
		$data_nao_valida = ($data_db == $data_invalida)? 1: 0;
		$data_pago_ok = checkdate($data_pago[1], $data_pago[2], $data_pago[0]); // 0 == ano, 1 == mes, 2 == dia
		if (!$data_pago_ok || $data_nao_valida) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => 'Data de pagamento inválida!' ))));
        }

        $dados_request['PagamentoData']['data_pago'] = $data_db;
        
        $this->PagamentoData->set(array_merge($dados_request, $dados_pagto));
		if ( $this->PagamentoData->validates() ) {
			if ( $this->PagamentoData->save($dados_request) ) {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'msg' => "Pagamento efetuado com sucesso!" ))));
			} else {
				return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar a conta. Por favor, tente novamente em alguns instantes." )) ) );
				// debug($this->PagamentoData->getDataSource()->getLog(false, false));
			}
		} else {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'erro', 'msg' => "Ocorreu um erro inesperado ao tentar alterar a conta. Por favor, tente novamente em alguns instantes.", 'msgs' => $this->PagamentoData->validationErrors )) ) );

        }

    }

    public function excluirVarious() {
        $this->layout = 'ajax';
        
        if ( !isset($_GET['id']) || !is_array($_GET['id']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Requisição inválida!" ))));
        }

        if ( count($_GET['id']) <= 1) {
            $conditions = array("PagamentoData.id" => $_GET['id'][0]);
        } else {
            $conditions = array("PagamentoData.id in" => $_GET['id']);
        }

        $this->loadModel('PagamentoData');

        if ( $this->PagamentoData->deleteAll($conditions) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Pagamentos excluídos com sucesso." ))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao excluir os Pagamentos. Por favor, tente mais tarde." ))));
        }

    }

    public function pagarVarious() {
        $this->layout = 'ajax';
        
        if ( !isset($_GET['id']) || !is_array($_GET['id']) || !isset($_GET['data_pago']) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Requisição inválida!" ))));
        }

        $data_db = $this->dateBrEn($_GET['data_pago']);
		$data_invalida = "1969-12-31";
		$data_pago = explode("-", $data_db);
		$data_nao_valida = ($data_db == $data_invalida)? 1: 0;
		$data_pago_ok = checkdate($data_pago[1], $data_pago[2], $data_pago[0]); // 0 == ano, 1 == mes, 2 == dia
		if (!$data_pago_ok || $data_nao_valida) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "Data de pagamento inválida!" ))));
        }
        $data_pagar = "'".$data_db."'";

        if ( count($_GET['id']) <= 1) {
            $conditions = array("PagamentoData.id" => $_GET['id'][0]);
        } else {
            $conditions = array("PagamentoData.id in" => $_GET['id']);
        }

        if (!isset($_GET['forma_pago']) || !is_numeric($_GET['forma_pago'])) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "A forma de pagamento deve ser informada!" ))));
        }
        $forma_pago = $_GET['forma_pago'];

        $this->loadModel('PagamentoData');

        $dados = $this->PagamentoData->find('all', array(
            'conditions' => array_merge($conditions, array('PagamentoData.status_id' => 3))
        ));

        if (count($dados) > 0) {
			return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'warning', 'msg' => "Entre os itens selecionados há pagamento(s) já realizado(s)!" ))));
        }

        $novo = array('PagamentoData.data_pago' => $data_pagar, 'PagamentoData.status_id' => 3, 'PagamentoData.forma_id' => $forma_pago);

        if ( $this->PagamentoData->updateAll( $novo, $conditions) ) {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "ok", "msg" => "Pagamentos efetuados com sucesso." ))));
        } else {
            return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Ocorreu um erro ao efetuar os Pagamentos. Por favor, tente mais tarde." ))));
        }
    }

}