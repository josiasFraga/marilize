<?php
class Credor extends AppModel {

	public $useTable = 'pessoas';

    public $name = 'Credor';

	public $hasMany = array(
		'Adiantamento' => array(
			'foreignKey' => 'credor_id'
		)
	);

	public $belongsTo = array(
        'PessoaTipo' => array(
            'foreignKey' => 'tipo_pessoa_id'
        )
    );

	public $validate = array(

	);

	public function listCredores($tipo = [0,1,2]) {
		$conditions = [
			'Credor.nome_fantasia <>' => '',
			'Credor.ativo' => 1
		];
		if (!is_null($tipo)) {
			$conditions['Credor.tipo_pessoa_id'] = $tipo;
		}
		return $this->find('list', [
            'conditions' => $conditions,
            'fields' => [
                'Credor.id', 'Credor.nome_fantasia'
			],
            'order' => [
                'Credor.nome_fantasia ASC'
			]
		]);
	}

}