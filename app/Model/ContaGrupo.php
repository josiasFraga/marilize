<?php
class ContaGrupo extends AppModel {

	public $useTable = 'pagamento_grupos';

    public $name = 'ContaGrupo';

	// public $hasMany = array();

	public $hasMany = array(
        'PagamentoData' => array(
            'foreignKey' => 'grupo_id'
        ),
        'ContaSubgrupo' => array(
            'foreignKey' => 'grupo_id'
        )
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
            'message' => 'Já existe um grupo com esse nome!'
        )
	);

	public function beforeSave($options = array()) {

		return true;
	}

    public function listaGrupos() {
        return $this->find('list', array(
            'fields' => array(
                'ContaGrupo.id',
                'ContaGrupo.nome'
            ),
            'conditons' => [
                'ContaGrupo.ativo' => 'Y',
            ],
            'order' => array(
                'ContaGrupo.nome'
            )
        ));
    }

	
}