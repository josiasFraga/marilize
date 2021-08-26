<?php
class Empresa extends AppModel {
	public $useTable = 'empresas';
	public $hasMany = array(
        'PagamentoData' => array(
            'foreignKey' => 'empresa_id'
        ),
    );

    public function listaEmpresas() {
        return $this->find('list', array(
            'fields' => array(
                'Empresa.id',
                'Empresa.nome'
            ),
            'order' => array(
                'Empresa.nome'
            )
        ));
    }
}