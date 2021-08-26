<?php
class Tomador extends AppModel {

	public $useTable = 'pessoas';

    public $name = 'Tomador';

	public $hasMany = array(
		'Adiantamento' => array(
			'foreignKey' => 'tomador_id'
		)
	);

	public $belongsTo = array(
        'PessoaTipo' => array(
            'foreignKey' => 'tipo_pessoa_id'
        )
    );

	public $validate = array(

	);

	public function listTomadores($tipo = [1,2]) {
		$conditions = [
			'Tomador.nome_fantasia <>' => '',
			'Tomador.ativo' => 1
		];
		if (!is_null($tipo)) {
			//$conditions['Tomador.tipo_pessoa_id'] = $tipo;
		}
		return $this->find('list', [
            'conditions' => $conditions,
            'fields' => [
                'Tomador.id', 'Tomador.nome_fantasia'
			],
            'order' => [
                'Tomador.nome_fantasia ASC'
			]
		]);
	}

}