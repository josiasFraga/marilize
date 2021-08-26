<?php

class PagamentoForma extends AppModel {

    public $useTable = 'pagamento_formas';

    public $hasMany = array(
        'PagamentoData' => array(
			'foreignKey' => 'forma_id'
        )
    );

    public function listaPagamentoForma() {
        return $this->find('list', array(
            'conditions' => array(
                'PagamentoForma.ativo' => 'Y'
            ),
            'fields' => array(
                'PagamentoForma.id',
                'PagamentoForma.forma'
            ),
            'order' => array(
                'PagamentoForma.forma'
            )
        ));
    }

}

?>