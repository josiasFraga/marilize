<?php

class PagamentoStatus extends AppModel {

    public $useTable = 'pagamento_status';

    public $hasMany = array(
        'PagamentoData' => array(
			'foreignKey' => 'status_id'
        )
    );

    public function listaPagamentoStatus() {
        return $this->find('list', array(
            'conditions' => array(
                'PagamentoStatus.ativo' => 'Y'
            ),
            'fields' => array(
                'PagamentoStatus.id',
                'PagamentoStatus.status'
            ),
            'order' => array(
                'PagamentoStatus.status'
            )
        ));
    }

}

?>