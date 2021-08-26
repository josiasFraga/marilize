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
		),
        'PessoaGrupo' => array(
            'foreignKey' => 'grupo_id'
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