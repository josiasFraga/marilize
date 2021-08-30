<?php
class ContaSubgrupo extends AppModel {

	public $useTable = 'pagamento_subgrupos';

    public $name = 'ContaSubgrupo';

	// public $hasMany = array();

	public $hasMany = array(
        'PagamentoData' => array(
            'foreignKey' => 'subgrupo_id'
        ),
    );

	public $belongsTo = array(
        'ContaGrupo' => array(
            'foreignKey' => 'grupo_id'
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
            'rule' => array('isUnique', array('nome', 'grupo_id'), false),
            'message' => 'Já existe um subgrupo com este nome neste grupo.'
        )
	);

	public function beforeSave($options = array()) {

		return true;
	}

    public function listaSubgrupos($grupo_id = null) {

        if ( $grupo_id == null ) {
            return [];
        }

        return $this->find('list', array(
            'fields' => array(
                'ContaSubgrupo.id',
                'ContaSubgrupo.nome'
            ),
            'conditions' => [
                'ContaSubgrupo.ativo' => 'Y',
                'ContaSubgrupo.grupo_id' => $grupo_id,
            ],
            'order' => array(
                'ContaSubgrupo.nome'
            )
        ));
    }

	
}