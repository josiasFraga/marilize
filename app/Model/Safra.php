<?php
class Safra extends AppModel {

	public $useTable = 'safras';

    public $name = 'Safra';

	public $belongsTo = array(
		/*'Usuario' => array(
			'foreignKey' => 'usuario_id'
		)*/
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
            'rule' => 'isUnique',
            'message' => 'Já existe uma safra com esse nome!'
        )
	);

	public function beforeSave($options = array()) {

		if( isset($this->data['Safra']['inicio_fim']) && !empty($this->data['Safra']['inicio_fim']) ) {
			list($inicio,$fim) = explode(" até ",$this->data['Safra']['inicio_fim']);
			$this->data['Safra']['inicio'] = $this->dateBrEn($inicio);
			$this->data['Safra']['fim'] = $this->dateBrEn($fim);
			unset($this->data['Safra']['inicio_fim']);
		}
    }

    public function listaSafras() {
        return $this->find('list', array(
            'fields' => array(
                'Safra.id',
                'Safra.nome'
            ),
            'conditons' => [
                'Safra.ativa' => 'Y',
            ],
            'order' => array(
                'Safra.nome'
            )
        ));
    }

	public function buscaSafraAtual(){
		return $this->find('first',[
			'conditions' => [
				'Safra.inicio <=' => date('Y-m-d'),
				'Safra.fim >=' => date('Y-m-d'),
				'Safra.ativa' => 'Y'
			],
			'link' => []
		]);
	}

}