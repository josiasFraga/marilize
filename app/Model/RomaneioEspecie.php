<?php
class RomaneioEspecie extends AppModel {

	public $useTable = 'romaneio_especies';

    public $name = 'RomaneioEspecie';

	public $hasMany = array(
        'RomaneioItem' => array(
            'foreignKey' => 'especie_id'
        )
    );

	// public $belongsTo = array();

	public $validate = array(
        'especie' => array(
			'rule1' => array(
				'required' => true,
				'rule' => 'notBlank',
				'message' => 'O campo Espécie é obrigatório!'
			),
		),
    );

	public function beforeSave($options = array()) {
        if ( isset($this->data[$this->alias]['especie']) && !is_null($this->data[$this->alias]['especie']) && !empty($this->data[$this->alias]['especie'])) {
            $this->data[$this->alias]['especie'] = mb_strtoupper($this->data[$this->alias]['especie']);
        }
    }
    
    public function listaRomaneioEspecie() {
        return $this->find('list', array(
            'fields' => array(
                'RomaneioEspecie.id',
                'RomaneioEspecie.especie'
            )
        ));
    }

}