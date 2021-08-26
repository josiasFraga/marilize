<?php
class RomaneioItem extends AppModel {

	public $useTable = 'romaneio_itens';

    public $name = 'RomaneioItem';

	// public $hasMany = array();

	public $belongsTo = array(
        'Romaneio' => array(
            'foreignKey' => 'romaneio_id'
        ),
        'RomaneioEspecie' => array(
            'foreignKey' => 'especie_id'
        )
    );

	public $validate = array(
        'especie_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'on' => 'create',
				'message' => 'O campo Espécie é obrigatório!'
			),
        ),
        'peso' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'on' => 'create',
				'message' => 'O campo Peso Fazenda é obrigatório!'
			),
        ),
        'cabecas' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'on' => 'create',
				'message' => 'O campo Cabeças é obrigatório!'
			),
        ),
        'valor_unitario' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'on' => 'create',
				'message' => 'O campo Valor Unitário é obrigatório!'
			),
        ),
        'valor_total' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'on' => 'create',
				'message' => 'O campo Valor Total é obrigatório!'
			),
		),
    );

	public function beforeSave($options = array()) {
		if ( isset($this->data[$this->alias]['peso']) ) {
            $this->data[$this->alias]['peso'] = $this->currencyToFloat($this->data[$this->alias]['peso']);
        }
        if ( isset($this->data[$this->alias]['valor_unitario']) ) {
            $this->data[$this->alias]['valor_unitario'] = $this->currencyToFloat($this->data[$this->alias]['valor_unitario']);
        }
        if ( isset($this->data[$this->alias]['valor_total']) ) {
            $this->data[$this->alias]['valor_total'] = $this->currencyToFloat($this->data[$this->alias]['valor_total']);
        }
    }

}