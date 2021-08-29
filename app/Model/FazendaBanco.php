<?php
class FazendaBanco extends AppModel {

	public $useTable = 'fazenda_bancos';

    public $name = 'FazendaBanco';

	// public $hasMany = array();

	public $belongsTo = array(
        'Fazenda' => array(
            'foreignKey' => 'fazenda_id'
        )
    );

	public $validate = array(
		// 'nome' => array(
		// 	'rule1' => array(
		// 		'required' => true,
		// 		'rule' => 'notBlank',
		// 		'on' => 'create',
		// 		'message' => 'O campo nome é obrigatório!'
		// 	),
		// )
	);

	public function beforeSave($options = array()) {

		return true;
	}

	public function findAllBancosByFazendaId($id = null) {
		if (is_null($id) && !is_numeric($id)) return false;
        return $this->find('all', array(
            'conditions' => array(
                'FazendaBanco.fazenda_id' => $id
            ),
            'fields' => array(
                'FazendaBanco.*',
            ),
            'order' => array(
                'FazendaBanco.id'
            )
        ));
    }

	
}