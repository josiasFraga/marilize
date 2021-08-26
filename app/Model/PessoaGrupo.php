<?php
class PessoaGrupo extends AppModel {

	public $useTable = 'pessoa_grupos';

    public $name = 'PessoaGrupo';

	public $hasMany = array(
        'Pessoa' => array(
            'foreignKey' => 'tipo_pessoa_id'
        ),
    );

	// public $belongsTo = array();

	// public $validate = array();

	public function beforeSave($options = array()) {
		// if ( isset($this->data['Usuario']['senha']) && $this->data['Usuario']['senha'] != "" ){
		// 	$this->data['Usuario']['senha'] = AuthComponent::password($this->data['Usuario']['senha']);
		// }
    }
    
    public function listaPessoaGrupo() {
        return $this->find('list', array(
            'fields' => array(
                'PessoaGrupo.id',
                'PessoaGrupo.nome'
            )
        ));
    }

}