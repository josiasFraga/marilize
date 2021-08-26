<?php
class PessoaTipo extends AppModel {

	public $useTable = 'pessoa_tipos';

    public $name = 'PessoaTipo';

	public $hasMany = array(
        'Pessoa' => array(
            'foreignKey' => 'tipo_pessoa_id'
        ),
        'Tomador' => array(
            'foreignKey' => 'tipo_pessoa_id'
        ),
        'Credor' => array(
            'foreignKey' => 'tipo_pessoa_id'
        )
    );

	// public $belongsTo = array();

	// public $validate = array();

	public function beforeSave($options = array()) {
		// if ( isset($this->data['Usuario']['senha']) && $this->data['Usuario']['senha'] != "" ){
		// 	$this->data['Usuario']['senha'] = AuthComponent::password($this->data['Usuario']['senha']);
		// }
    }
    
    public function listaPessoaTipo() {
        return $this->find('list', array(
            'fields' => array(
                'PessoaTipo.id',
                'PessoaTipo.tipo_pessoa'
            )
        ));
    }

}