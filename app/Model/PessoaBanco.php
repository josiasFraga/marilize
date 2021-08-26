<?php
class PessoaBanco extends AppModel {

	public $useTable = 'pessoa_bancos';

    public $name = 'PessoaBanco';

	// public $hasMany = array();

	public $belongsTo = array(
        'Pessoa' => array(
            'foreignKey' => 'pessoa_id'
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

	public function findAllBancosByPessoaId($id = null) {
		if (is_null($id) && !is_numeric($id)) return false;
        return $this->find('all', array(
            'conditions' => array(
                'PessoaBanco.pessoa_id' => $id
            ),
            'fields' => array(
                'PessoaBanco.*',
            ),
            'order' => array(
                'PessoaBanco.id'
            )
        ));
    }

}