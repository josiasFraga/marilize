<?php

App::uses('Romaneio', 'Model');

class RomaneioInvernar extends Romaneio {

    public $name = 'RomaneioInvernar';

	public $validate = array(
        'comprador_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Comprador é obrigatório!'
			),
        ),
		'comprador_localidade_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Comprador Obra/Localidade é obrigatório!'
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
			// 	'message' => 'Já existe este Nº de Romaneio.'
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
				'message' => 'O campo Vendedor é obrigatório!'
			),
		),
		'vendedor_localidade_id' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Vendedor Obra/Localidade é obrigatório!'
			),
		),
		'data_embarque' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Data de Embarque é obrigatório!'
			),
		),
		'valor_liquido' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Valor Total Líquido é obrigatório!'
			),
		),
		'comissao_comprador_porcentual' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Comprador Perc. Comissão é obrigatório!'
			),
		),
		'comissao_comprador_valor' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Comprador Valor Comissão é obrigatório!'
			),
		),
		'comissao_comprador_data_pgto' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Comprador Data Pagamento é obrigatório!'
			),
		),
		'comissao_vendedor_porcentual' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Vendedor Perc. Comissão é obrigatório!'
			),
		),
		'comissao_vendedor_valor' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Vendedor Valor Comissão é obrigatório!'
			),
		),
		'comissao_vendedor_data_pgto' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Vendedor Data Pagamento é obrigatório!'
			),
        ),
    );

	// public function beforeSave($options = array()) {
	// 	return true;
    // }

}