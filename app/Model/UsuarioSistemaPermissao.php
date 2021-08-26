<?php
class UsuarioSistemaPermissao extends AppModel {
    
    public $useTable = 'usuario_sistema_permissoes';
    
    public $name = 'UsuarioSistemaPermissao';

	// public $hasMany = array();

	public $belongsTo = array(
        'SistemaPermissao' => array(
			'foreignKey' => 'sistema_permissao_id'
		),
        'Usuario' => array(
            'foreignKey' => 'usuario_id'
        )
    );

	// public $validate = array();

    // public function beforeSave($options = array()) {}
    
    public function sistemaPermissoesByUsuarioId($id = null) {
        if (is_null($id) && !is_numeric($id)) return false;
        $dados = $this->find('all', array(
            'conditions' => array(
                'UsuarioSistemaPermissao.usuario_id' => $id
            ),
            'fields' => array(
                'UsuarioSistemaPermissao.sistema_permissao_id'
            ),
            'order' => array(
                'UsuarioSistemaPermissao.sistema_permissao_id ASC'
            )
        ));
        $retorno = array();
        foreach ($dados as $dado) {
            $retorno[] = $dado['UsuarioSistemaPermissao']['sistema_permissao_id'];
        }
        return $retorno;
    }

}