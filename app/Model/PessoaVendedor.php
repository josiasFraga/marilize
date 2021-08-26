<?php
class PessoaVendedor extends AppModel {

	public $useTable = 'pessoas';

    public $name = 'PessoaVendedor';

	public $hasMany = array(
        'Romaneio' => array(
            'foreignKey' => 'vendedor_id'
        )		
	);

	public $belongsTo = array();

}