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
		if ( isset($this->data['PessoaLocalidade']['descricao']) && !empty($this->data['PessoaLocalidade']['descricao']) ) {
			$this->data['PessoaLocalidade']['descricao'] = mb_strtoupper($this->data['PessoaLocalidade']['descricao']);
		}
		if ( isset($this->data['PessoaLocalidade']['cidade']) && !empty($this->data['PessoaLocalidade']['cidade']) ) {
			$this->data['PessoaLocalidade']['cidade'] = mb_strtoupper($this->data['PessoaLocalidade']['cidade']);
		}
		if ( isset($this->data['PessoaLocalidade']['estado']) && !empty($this->data['PessoaLocalidade']['estado']) ) {
			$this->data['PessoaLocalidade']['estado'] = mb_strtoupper($this->data['PessoaLocalidade']['estado']);
		}
		if ( isset($this->data['PessoaLocalidade']['localidade']) && !empty($this->data['PessoaLocalidade']['localidade']) ) {
			$this->data['PessoaLocalidade']['localidade'] = mb_strtoupper($this->data['PessoaLocalidade']['localidade']);
		}
		
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