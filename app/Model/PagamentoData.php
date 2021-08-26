<?php
class PagamentoData extends AppModel {
    public $useTable = 'pagamentos';

    public $name = 'PagamentoData';

    public $belongsTo = [
        'PagamentoCategoria' => [
            'foreignKey' => 'categoria_id'
        ],
        'PagamentoStatus' => [
            'foreignKey' => 'status_id'
        ],
        'PagamentoForma' => [
            'foreignKey' => 'forma_id'
        ],
        'Empresa' => [
            'foreignKey' => 'empresa_id'
        ],
        'Pessoa' => [
            'foreignKey' => 'fornecedor_id'
        ]
    ];

    public $validate = array(
        'valor' => array(
            'rule1' => array(
                'required' => true,
				'rule' => 'notBlank',
                'message' => 'O campo Valor é obrigatório!'
			),
        ),
        'data_venc' => array(
            'rule1' => array(
                'required' => true,
				'rule' => 'notBlank',
                'message' => 'O campo Data de Vencimento é obrigatório!'
			),
        ),
        'categoria_id' => array(
            'rule1' => array(
                'required' => true,
				'rule' => 'notBlank',
                'message' => 'O campo Categoria Pagamento é obrigatório!'
			),
        ),
        'status_id' => array(
            'rule1' => array(
                'required' => true,
				'rule' => 'notBlank',
                'message' => 'O campo Status Pagamento é obrigatório!'
			),
        ),
    );

    public function beforeSave($options = array()) {
        if ( isset( $this->data[$this->alias]['valor'] ) ) {
            $this->data[$this->alias]['valor'] = $this->currencyToFloat($this->data[$this->alias]['valor']);
        }
        if ( isset($this->data[$this->alias]['data_venc'])  && !is_null($this->data[$this->alias]['data_venc']) ) {
			$this->data[$this->alias]['data_venc'] = $this->dateBrEn($this->data[$this->alias]['data_venc']);
        }
        if ( isset($this->data[$this->alias]['data_pago']) && !is_null($this->data[$this->alias]['data_pago']) ) {
			$this->data[$this->alias]['data_pago'] = $this->dateBrEn($this->data[$this->alias]['data_pago']);
		}
    }

    public function findTotal($tipo = null, $periodo_ini = null, $periodo_fim = null, $status = null, $user = false) {
        $retorno = array();
        $conditions = array();
        $conditions = array_merge($conditions, array('PagamentoData.ativo' => 'Y'));

        if ( !is_null($periodo_ini) && $this->validateDate($periodo_ini, 'Y-m-d') ) {
            $conditions = array_merge($conditions, array('PagamentoData.data_venc >=' => $periodo_ini));
        }

        if ( !is_null($periodo_fim) && $this->validateDate($periodo_fim, 'Y-m-d') ) {
            $conditions = array_merge($conditions, array('PagamentoData.data_venc <=' => $periodo_fim));
        }

        if ( !is_null($status) && is_numeric($status) ) {
            $conditions = array_merge($conditions, array('PagamentoData.status_id' => $status));
        }

        if ( !is_null($tipo) && $tipo != '') {
            $conditions = array_merge($conditions, array('PagamentoData.tipo' => $tipo));
        }

        if ( $user ) {
            // $conditions = array_merge($conditions, array('Aluno.ativo' => 'Y'));
        }
        
        $this->virtualFields['total'] = 'SUM(PagamentoData.valor)';
        $retorno = $this->find('first', array(
            'conditions' => array( $conditions ),
            'fields' => array( 'PagamentoData.total' ),
            'link' => array()
        ));
        unset($this->virtualFields['total']);

        return $retorno;
    }

    public function findSaldos($tipo = null, $periodo_ini = null, $periodo_fim = null, $status = null, $categoria = null, $user = false) {
        $retorno = array();
        $conditions = array();
        $conditions = array_merge($conditions, array('PagamentoData.ativo' => 'Y'));

        if ( !is_null($periodo_ini) && $this->validateDate($periodo_ini, 'Y-m-d') ) {
            $conditions = array_merge($conditions, array('PagamentoData.data_venc >=' => $periodo_ini));
        }

        if ( !is_null($periodo_fim) && $this->validateDate($periodo_fim, 'Y-m-d') ) {
            $conditions = array_merge($conditions, array('PagamentoData.data_venc <=' => $periodo_fim));
        }

        if ( !is_null($status) && is_numeric($status) ) {
            $conditions = array_merge($conditions, array('PagamentoData.status_id' => $status));
        }
        
        if ( !is_null($tipo) && $tipo != '') {
            $conditions = array_merge($conditions, array('PagamentoData.tipo' => $tipo));
        }

        if ( !is_null($categoria) && is_numeric($categoria) ) {
            $conditions = array_merge($conditions, array('PagamentoData.categoria_id' => $categoria));
        }

        if ( $user ) {
            // $conditions = array_merge($conditions, array('Aluno.ativo' => 'Y'));
        }

        $retorno = $this->find('all', array(
            'fields' => array(
                'PagamentoData.*',
                'PagamentoCategoria.nome',
                'PagamentoForma.forma'
            ),
            'conditions' => array( $conditions ),
            'link' => array(
                'PagamentoCategoria',
                'PagamentoForma'
            ),
            'order' => array(
                'PagamentoCategoria.id',
                'PagamentoData.data_venc'
            )
        ));
    
        return $retorno;
    }

    public function ultimoPagamentoGerado($id = null) {
        if (is_null($id)) return null;

        $upg = $this->find('first', array(
            'conditions' => array(
                'PagamentoData.pagamento_id' => $id
            ),
            'fields' => array(
                'PagamentoData.data_venc'
            ),
            'order' => array(
                'PagamentoData.id DESC'
            )
        ));

        if (!empty($upg)) {
            return date('Y-m', strtotime($upg['PagamentoData']['data_venc']));
        } else {
            return null;
        }
    }
}