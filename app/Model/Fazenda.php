<?php
class Fazenda extends AppModel {
	public $useTable = 'fazendas';
	public $hasMany = array(
        'PagamentoData' => array(
            'foreignKey' => 'fazenda_id'
        ),
        'FazendaBanco' => array(
            'foreignKey' => 'fazenda_id'
        ),
    );

	public $validate = array(
		'nome' => array(
		 	'rule1' => array(
		 		'required' => true,
		 		'rule' => 'notBlank',
	 		'on' => 'create',
		 		'message' => 'O campo nome é obrigatório!'
		 	),
		),
        'nome' => array(
            'rule' => 'isUnique',
            'message' => 'Já existe uma fazenda com esse nome!'
        )
	);

    public function listaFazendas() {
        return $this->find('list', array(
            'fields' => array(
                'Fazenda.id',
                'Fazenda.nome'
            ),
            'conditons' => [
                'Fazenda.ativa' => 'Y',
            ],
            'order' => array(
                'Fazenda.nome'
            )
        ));
    }
}