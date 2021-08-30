<?php

App::uses('ContasController', 'Controller');

class ContasPagarController extends ContasController {

	public function index() {

        $this->set('title_for_layout', 'Contas');

        if ( $this->request->is('post') ){
            $this->layout = "ajax";
            return $this->dataTable('S');
        }

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
    
        $this->loadModel('Safra');
        $safras = $this->Safra->listaSafras();

        $safra_atual = $this->Safra->buscaSafraAtual();


        $this->set(compact('status', 'categorias', 'listformas', 'fazendas', 'fornecedores', 'safras', 'safra_atual'));
    }

    public function adicionar() {

        $this->set('title_for_layout', 'Adicionar Contas à Pagar');

		if ( !empty($this->request->data) ) {
			$this->layout = "ajax";
			return $this->save();
        }

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
    
    public function alterar($id = null) {

        $this->set('title_for_layout', 'Alterar Contas à Pagar');

        if ( !empty($this->request->data) ) {
            if ( $this->request->data['PagamentoData']['id'] == null ){
                return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( "status" => "erro", "msg" => "Despesa, a ser alterada não informada." ))));
            }
            $this->layout = "ajax";
            return $this->update();
        }

        if ($id == null) {
            $this->redirect(array('action' => 'index'));
            die();
        }

        $this->loadModel('PagamentoData');
        $dados = $this->PagamentoData->findById($id);

        if (count($dados) <= 0) {
            $this->Session->setFlash('Despesa Incorreta!!!', 'flash_error');
            return $this->routing();
        }

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

        if ( $dados['PagamentoData']['grupo_id'] != '' ) {
            $this->loadModel('ContaSubgrupo');
            $subgrupos = $this->ContaSubgrupo->listaSubgrupos($dados['PagamentoData']['grupo_id']);

        }
    
        $this->loadModel('Safra');
        $safras = $this->Safra->listaSafras();

        $safra_atual = $this->Safra->buscaSafraAtual();

        $this->set(compact('dados', 'categorias', 'listformas', 'fazendas', 'fornecedores', 'safras', 'safra_atual', 'grupos', 'subgrupos'));
    }

    public function subgrupos_dependents($grupo_id = null) {
        if($grupo_id == null) {
            return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'dados' => []))));
        }

        $this->loadModel('ContaSubgrupo');
        $dados = $this->ContaSubgrupo->listaSubgrupos($grupo_id);
        return new CakeResponse(array('type' => 'json', 'body' => json_encode(array('status' => 'ok', 'dados' => $dados))));
    }

}