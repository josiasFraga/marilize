<?php
class Adiantamento extends AppModel {

	public $useTable = 'adiantamentos';

    public $name = 'Adiantamento';

	public $hasMany = array(
	);

	public $belongsTo = array(
        'Credor' => array(
            'foreignKey' => 'credor_id'
        ),
        'Tomador' => array(
            'foreignKey' => 'tomador_id'
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
    
    public function reacalculaSaldos($credor_id = null, $tomador_id = null) {
        if ( $credor_id == null ) {
            return false;
        }
        if ( $tomador_id == null ) {
            return false;
        }

        $dados = $this->find('all',[
            'conditions' => [
                'Adiantamento.credor_id' => $credor_id,
                'Adiantamento.tomador_id' => $tomador_id
            ],
            'order' => [
                'Adiantamento.emissao'
            ]
        ]);

        if ( count($dados) == 0 ) {
            return true;
        }

        $dados_salvar = [];
        $count = 0;
        $saldo = 0;
        foreach($dados as $key => $dado) {
            $saldo = $saldo + $dado['Adiantamento']['entrada'] - $dado['Adiantamento']['saida'];
            $dados_salvar[$count] = $dado;
            $dados_salvar[$count]['Adiantamento']['saldo'] = $saldo;
            $count++;
        }

        return $this->saveAll($dados_salvar);
    }

	public function beforeSave($options = array()) {
        if ( isset( $this->data[$this->alias]['entrada'] ) ) {
            $this->data[$this->alias]['entrada'] = $this->currencyToFloat($this->data[$this->alias]['entrada']);
        }
        if ( isset( $this->data[$this->alias]['saida'] ) ) {
            $this->data[$this->alias]['saida'] = $this->currencyToFloat($this->data[$this->alias]['saida']);
        }
        if ( isset($this->data[$this->alias]['emissao'])  && !is_null($this->data[$this->alias]['emissao']) && strpos($this->data[$this->alias]['emissao'], '/') !== false ) {
			$this->data[$this->alias]['emissao'] = $this->dateBrEn($this->data[$this->alias]['emissao']);
        }

		return true;
	}



}