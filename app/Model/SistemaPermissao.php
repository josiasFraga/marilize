<?php
class SistemaPermissao extends AppModel {

    public $useTable = 'sistema_permissoes';
    
    public $name = 'SistemaPermissao';

	public $hasMany = array(
		'UsuarioSistemaPermissao' => array(
			'foreignKey' => 'sistema_permissao_id'
		)
	);

	// public $belongsTo = array();

	// public $validate = array();

    // public function beforeSave($options = array()) {}
    
    public function listaSistemaPermissao() {
        return $this->find('list', array(
            'conditions' => array(
                'SistemaPermissao.visivel' => 'Y'
            ),
            'fields' => array(
                'SistemaPermissao.id',
                'SistemaPermissao.permissao'
            ),
            'order' => array(
                'SistemaPermissao.permissao ASC'
            )
        ));
    }

    public function listaSistemaPermissaoFiltroActionIndex() {
        return $this->find('list', array(
            'conditions' => array(
                'SistemaPermissao.visivel' => 'Y',
                'SistemaPermissao.action' => 'index'
            ),
            'fields' => array(
                'SistemaPermissao.id',
                'SistemaPermissao.permissao'
            ),
            'order' => array(
                'SistemaPermissao.permissao ASC'
            )
        ));
    }

    public function sistemaPermissaoByControllerAndAction($ctrl = null, $act = null) {
        if (is_null($ctrl) || is_null($act)) return false;
        $dados =  $this->find('first', array(
            'conditions' => array(
                'SistemaPermissao.controller' => $ctrl,
                'SistemaPermissao.action' => $act,
                // 'SistemaPermissao.visivel' => 'Y'
            ),
            'fields' => array(
                'SistemaPermissao.id'
            )
        ));
        return $dados['SistemaPermissao']['id'];
    }

    public function sistemaPermissaoByControllerIndexId($ctrl = null) {
        if (is_null($ctrl)) return false;
        $busca =  $this->findById($ctrl);
        $dados =  $this->find('all', array(
            'conditions' => array(
                'SistemaPermissao.controller' => $busca['SistemaPermissao']['controller'],
                // 'SistemaPermissao.visivel' => 'Y'
            ),
            'fields' => array(
                'SistemaPermissao.id'
            )
        ));
        $retorno = array();
        foreach ($dados as $dado) {
            $retorno[] = $dado['SistemaPermissao']['id'];
        }
        return $retorno;
    }

}