<?php

App::uses('Romaneio', 'Model');

class RomaneioGordo extends Romaneio {

    public $name = 'RomaneioGordo';

	public $validate = array(
        'comprador_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Frigorífico é obrigatório!'
			),
		),
		'data_emissao' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Data de Emissão é obrigatório!'
			),
        ),
		'numero' => array(
			// 'unique' => array(
			// 	'rule' => 'isUnique',
			// 	'required' => 'create',
			// 	'message' => 'Nº de Romaneio já existente!'
			// ),
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'on' => 'create',
				'message' => 'O campo Nº Romaneio é obrigatório!'
			),
		),
        'vendedor_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Produtor é obrigatório!'
			),
		),
		'vendedor_localidade_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Obra/Localidade é obrigatório!'
			),
		),
		'peso_fazenda_total' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Peso Fazenda é obrigatório!'
			),
		),
		'peso_frigorifico' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Peso Frigorífico é obrigatório!'
			),
		),
		'data_abate' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Data Abate é obrigatório!'
			),
        ),
    );

	// public function beforeSave($options = array()) {
	// 	return true;
    // }

}