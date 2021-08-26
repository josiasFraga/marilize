<?php
class RomaneioVencimento extends AppModel {

	public $useTable = 'romaneio_vencimentos';

    public $belongsTo = array(
        'Romaneio' => array(
            'foreignKey' => 'romaneio_id'
        )
    );
}