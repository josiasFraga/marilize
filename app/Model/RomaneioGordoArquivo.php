<?php
class RomaneioGordoArquivo extends AppModel {

	public $useTable = 'romaneio_gordo_arquivos';

    public $name = 'RomaneioGordoArquivo';

	// public $hasMany = array();

    public $belongsTo = array(
        'RomaneioGordo' => array(
            'foreignKey' => 'romaneio_gordo_id'
        )
    );

	public $validate = array(
		'arquivo' => array(
			'extension' => array(
				'rule' => array('extension', array('pdf', 'jpeg', 'jpg', 'png')),
				'message' => "Arquivo com extensão não válida!"
			),
			'uploadError' => array(
				'rule' => array('uploadError', true),
				'message' => "Erro ao anexar arquivo!"
			),
			'mimeType' => array(
				'rule' => array('mimeType', array('application/pdf', 'image/png', 'image/jpeg', 'image/jpeg')),
				'message' => "Tipo de arquivo não válido"
			),
			'fileSize' => array(
				'rule' => array('fileSize', '<=', '10MB'),
				'message' => "O tamanho do arquivo não pode deve ser maior que 10MB!"
			)
		)
    );

	// public function beforeSave($options = array()) {
	// 	return true;
    // }

    public $actsAs = array(
		'Upload.Upload' => array(
			'arquivo' => array(
				'path' => "{ROOT}{DS}webroot{DS}files{DS}romaneios_arquivos", // {ONDE ARQ ESTA}{ENTRA}webroot{ENTRA}img{ENTRA}lotes
				'pathMethod' => 'flat',
				'nameCallback' => 'rename'
			)
		)
	);

	public function rename($field, $currentName, array $data, array $options) {
		$ext = pathinfo($currentName, PATHINFO_EXTENSION);
		$name = md5(uniqid(rand())).'.'.mb_strtolower($ext);
		return $name;
	}

	public function arquivosByRomaneioId($id = null) {
		if (is_null($id) && !is_numeric($id)) return false;
		return $this->find('all', array(
            'conditions' => array(
                'RomaneioGordoArquivo.romaneio_gordo_id' => $id
			),
			'fields' => array(
				'RomaneioGordoArquivo.*'
			)
		));
	}

}