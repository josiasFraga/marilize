<?php
class PessoaLocalidade extends AppModel {

	public $useTable = 'pessoa_localidades';

    public $name = 'PessoaLocalidade';

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

	public function findAllLocalidadesByPessoaId($id = null) {
		if (is_null($id) && !is_numeric($id)) return false;
        return $this->find('all', array(
            'conditions' => array(
                'PessoaLocalidade.pessoa_id' => $id
            ),
            'fields' => array(
                'PessoaLocalidade.*',
            ),
            'order' => array(
                'PessoaLocalidade.id'
            )
        ));
    }

}