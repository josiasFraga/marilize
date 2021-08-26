<?php
class Pessoa extends AppModel {

	public $useTable = 'pessoas';

    public $name = 'Pessoa';

	public $hasMany = array(
		'PessoaLocalidade' => array(
            'foreignKey' => 'pessoa_id'
		),
		'PessoaBanco' => array(
            'foreignKey' => 'pessoa_id'
		),
        'Romaneio' => array(
            'foreignKey' => 'comprador_id'
		),
		'PagamentoData' => array(
			'foreignKey' => 'fornecedor_id'
		),
		'Adiantamento' => array(
			'foreignKey' => 'pessoa_id'
		)
	);

	public $belongsTo = array(
        'PessoaTipo' => array(
            'foreignKey' => 'tipo_pessoa_id'
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
		// ),
		// 'email' => array(
		// 	'unique' => array(
		// 		'rule' => 'isUnique',
		// 		'required' => 'create',
		// 		'message' => 'Já existe um usuário com este email.'
		// 	),
		// 	'rule1' => array(
		// 		'required' => true,
		// 		'rule' => 'notBlank',
		// 		'on' => 'create',
		// 		'message' => 'O campo email é obrigatório!'
		// 	),
		// )
	);

	public function beforeSave($options = array()) {
		$this->data['Pessoa']['cad_usuario_id'] = AuthComponent::user('id');
		
		if ( isset($this->data['Pessoa']['razao_social']) && !empty($this->data['Pessoa']['razao_social']) ) {
			$this->data['Pessoa']['razao_social'] = mb_strtoupper($this->data['Pessoa']['razao_social']);
		}
		if ( isset($this->data['Pessoa']['nome_fantasia']) && !empty($this->data['Pessoa']['nome_fantasia']) ) {
			$this->data['Pessoa']['nome_fantasia'] = mb_strtoupper($this->data['Pessoa']['nome_fantasia']);
		}
		if ( isset($this->data['Pessoa']['cidade']) && !empty($this->data['Pessoa']['cidade']) ) {
			$this->data['Pessoa']['cidade'] = mb_strtoupper($this->data['Pessoa']['cidade']);
		}
		if ( isset($this->data['Pessoa']['estado']) && !empty($this->data['Pessoa']['estado']) ) {
			$this->data['Pessoa']['estado'] = mb_strtoupper($this->data['Pessoa']['estado']);
		}
		if ( isset($this->data['Pessoa']['bairro']) && !empty($this->data['Pessoa']['bairro']) ) {
			$this->data['Pessoa']['bairro'] = mb_strtoupper($this->data['Pessoa']['bairro']);
		}
		if ( isset($this->data['Pessoa']['endereco']) && !empty($this->data['Pessoa']['endereco']) ) {
			$this->data['Pessoa']['endereco'] = mb_strtoupper($this->data['Pessoa']['endereco']);
		}
		if ( isset($this->data['Pessoa']['complemento']) && !empty($this->data['Pessoa']['complemento']) ) {
			$this->data['Pessoa']['complemento'] = mb_strtoupper($this->data['Pessoa']['complemento']);
		}
		if ( isset($this->data['Pessoa']['observacoes']) && !empty($this->data['Pessoa']['observacoes']) ) {
			$this->data['Pessoa']['observacoes'] = mb_strtoupper($this->data['Pessoa']['observacoes']);
		}

		return true;
	}

	public function findRazaoSocialById($id = null) {
		if (is_null($id) && !is_numeric($id)) return false;
        $query = $this->find('first', array(
            'conditions' => array(
                'Pessoa.id' => $id
            ),
            'fields' => array(
                'Pessoa.razao_social'
            )
		));
		return $query['Pessoa']['razao_social'];
	}

	public function findNomeFantasiaById($id = null) {
		if (is_null($id) && !is_numeric($id)) return false;
        $query = $this->find('first', array(
            'conditions' => array(
                'Pessoa.id' => $id
            ),
            'fields' => array(
                'Pessoa.nome_fantasia'
            )
		));
		return $query['Pessoa']['nome_fantasia'];
	}

	public function findListAllPessoas($tipo = null) {
		$conditions = [
			'Pessoa.nome_fantasia <>' => '',
			'Pessoa.ativo' => 1
		];
		if (!is_null($tipo)) {
			$conditions['Pessoa.tipo_pessoa_id'] = $tipo;
		}
		return $this->find('list', [
            'conditions' => $conditions,
            'fields' => [
                'Pessoa.id', 'Pessoa.nome_fantasia'
			],
            'order' => [
                'Pessoa.nome_fantasia ASC'
			]
		]);
	}

}