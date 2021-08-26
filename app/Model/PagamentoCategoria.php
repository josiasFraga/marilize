<?php

class PagamentoCategoria extends AppModel {

    public $useTable = 'pagamento_categorias';

    public $hasMany = array(
        'PagamentoData' => array(
			'foreignKey' => 'categoria_id'
        )
    );

    public function listaPagamentoCategoria() {
        return $this->find('list', array(
            'conditions' => array(
                'PagamentoCategoria.ativo' => 'Y'
            ),
            'fields' => array(
                'PagamentoCategoria.id',
                'PagamentoCategoria.categoria'
            ),
            'order' => array(
                'PagamentoCategoria.categoria'
            )
        ));
    }

}

?>