<?php
class Romaneio extends AppModel {

	public $useTable = 'romaneios';

    public $name = 'Romaneio';

	public $hasMany = array(
        'RomaneioArquivo' => array(
            'foreignKey' => 'romaneio_id'
        ),
        'RomaneioItem' => array(
            'foreignKey' => 'romaneio_id'
        ),
        'RomaneioVencimento' => array(
            'foreignKey' => 'romaneio_id'
        ),
    );

    public $belongsTo = array(
        'Pessoa' => array(
            'foreignKey' => 'comprador_id'
		),
        'PessoaVendedor' => array(
            'foreignKey' => 'vendedor_id'
		)
    );

	// public $validate = array();
    public function relatorios($ano) {
        if (is_null($ano))
            $ano = date('Y');


        $dados = [];
        $meses = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];
        foreach ($meses as $mes) {
            $dados[] = [
                'mes' => $mes,
                'gordo_quantidade' => 0,
                'gordo_comissao' => 0,
                'gordo_valor_vendas' => 0,
                'gordo_porcent_cabecas' => 0,
                'gordo_porcent_valores' => 0,
                'gordo_comissao_cabeca' => 0,
                'gordo_valor_cabeca' => 0,
                'invernar_quantidade' => 0,
                'invernar_comissao' => 0,
                'invernar_porcent_cabecas' => 0,
                'invernar_porcent_valores' => 0,
                'invernar_comissao_cabeca' => 0,
                'invernar_valor_cabeca' => 0,
                'invernar_valor_vendas' => 0,
                'geral_quantidade' => 0,
                'geral_comissao' => 0,
                'geral_valor_vendas' => 0,
            ];
        }

        $this->virtualFields['_total_comissao'] = 'SUM(IFNULL(Romaneio.comissao_vendedor_valor, 0) + IFNULL(Romaneio.comissao_comprador_valor, 0))';
        $this->virtualFields['_total_vendas'] = 'SUM(Romaneio.valor_liquido)';
        $this->virtualFields['_mes'] = 'MONTH(Romaneio.data_emissao)';

        $totais_gordo = $this->find('all', [
            'fields' => [
                'Romaneio._mes',
                'Romaneio._total_comissao',
                'Romaneio._total_vendas',
            ],
            'conditions' => [
                'YEAR(Romaneio.data_emissao)' => $ano,
                'Romaneio.tipo' => 0,
            ],
            'group' => ['Romaneio._mes'],
            'order' => ['MONTH(Romaneio.data_emissao)']
        ]);
        foreach ($totais_gordo as $key => $gordo) {
            $this->RomaneioItem->virtualFields['_total_cabecas'] = 'SUM(RomaneioItem.cabecas)';
            $total_cabecas_gordo = $this->RomaneioItem->find('first', [
                'fields' => [
                    'RomaneioItem._total_cabecas'
                ],
                'conditions' => [
                    'YEAR(Romaneio.data_emissao)' => $ano,
                    'MONTH(Romaneio.data_emissao)' => $gordo['Romaneio']['_mes'],
                    'Romaneio.tipo' => 0,
                ],
                'link' => 'Romaneio'
            ]);
            $totais_gordo[$key]['Romaneio']['_total_cabecas'] = $total_cabecas_gordo['RomaneioItem']['_total_cabecas'];
        }

        $totais_invernar = $this->find('all', [
            'fields' => [
                'Romaneio._mes',
                'Romaneio._total_comissao',
                'Romaneio._total_vendas',
            ],
            'conditions' => [
                'YEAR(Romaneio.data_emissao)' => $ano,
                'Romaneio.tipo' => 1,
            ],
            'group' => ['Romaneio._mes'],
            'order' => ['MONTH(Romaneio.data_emissao)']
        ]);
        foreach ($totais_invernar as $key => $invernar) {
            $this->RomaneioItem->virtualFields['_total_cabecas'] = 'SUM(RomaneioItem.cabecas)';
            $total_cabecas_invernar = $this->RomaneioItem->find('first', [
                'fields' => [
                    'RomaneioItem._total_cabecas'
                ],
                'conditions' => [
                    'YEAR(Romaneio.data_emissao)' => $ano,
                    'MONTH(Romaneio.data_emissao)' => $invernar['Romaneio']['_mes'],
                    'Romaneio.tipo' => 1,
                ],
                'link' => 'Romaneio'
            ]);
            $totais_invernar[$key]['Romaneio']['_total_cabecas'] = $total_cabecas_invernar['RomaneioItem']['_total_cabecas'];
        }


        foreach ($dados as $key => $dado) {
            if (isset($totais_gordo[$key])) {
                $dados[$key]['gordo_quantidade'] = $totais_gordo[$key]['Romaneio']['_total_cabecas'];
                $dados[$key]['gordo_comissao'] = $totais_gordo[$key]['Romaneio']['_total_comissao'];
                $dados[$key]['gordo_valor_vendas'] = $totais_gordo[$key]['Romaneio']['_total_vendas'];
            }

            if (isset($totais_invernar[$key])) {
                $dados[$key]['invernar_quantidade'] = $totais_invernar[$key]['Romaneio']['_total_cabecas'];
                $dados[$key]['invernar_comissao'] = $totais_invernar[$key]['Romaneio']['_total_comissao'];
                $dados[$key]['invernar_valor_vendas'] = $totais_invernar[$key]['Romaneio']['_total_vendas'];
            }

            $dados[$key]['geral_quantidade'] = $dados[$key]['gordo_quantidade'] + $dados[$key]['invernar_quantidade'];
            $dados[$key]['geral_comissao'] = $dados[$key]['gordo_comissao'] + $dados[$key]['invernar_comissao'];
            $dados[$key]['geral_valor_vendas'] = $dados[$key]['gordo_valor_vendas'] + $dados[$key]['invernar_valor_vendas'];

            if (isset($totais_gordo[$key])) {
                $dados[$key]['gordo_porcent_cabecas'] = ($totais_gordo[$key]['Romaneio']['_total_cabecas'] / $dados[$key]['geral_quantidade']) * 100;
                $dados[$key]['gordo_porcent_valores'] = ($totais_gordo[$key]['Romaneio']['_total_comissao'] / $dados[$key]['geral_comissao']) * 100;
                $dados[$key]['gordo_comissao_cabeca'] = $totais_gordo[$key]['Romaneio']['_total_comissao'] / $totais_gordo[$key]['Romaneio']['_total_cabecas'];
                $dados[$key]['gordo_valor_cabeca'] = $totais_gordo[$key]['Romaneio']['_total_vendas'] / $totais_gordo[$key]['Romaneio']['_total_cabecas'];

            }
            if (isset($totais_invernar[$key])) {
                $dados[$key]['invernar_porcent_cabecas'] = ($totais_invernar[$key]['Romaneio']['_total_cabecas'] / $dados[$key]['geral_quantidade']) * 100;
                $dados[$key]['invernar_porcent_valores'] = ($totais_invernar[$key]['Romaneio']['_total_comissao'] / $dados[$key]['geral_comissao']) * 100;
                $dados[$key]['invernar_comissao_cabeca'] = $totais_invernar[$key]['Romaneio']['_total_comissao'] / $totais_invernar[$key]['Romaneio']['_total_cabecas'];
                $dados[$key]['invernar_valor_cabeca'] = $totais_invernar[$key]['Romaneio']['_total_vendas'] / $totais_invernar[$key]['Romaneio']['_total_cabecas'];
            }
        }

        $totais = [
            'gordo_quantidade' => array_sum(array_column($dados, 'gordo_quantidade')),
            'gordo_comissao' => array_sum(array_column($dados, 'gordo_comissao')),
            'gordo_valor_vendas' => array_sum(array_column($dados, 'gordo_valor_vendas')),
            'invernar_quantidade' => array_sum(array_column($dados, 'invernar_quantidade')),
            'invernar_comissao' => array_sum(array_column($dados, 'invernar_comissao')),
            'invernar_valor_vendas' => array_sum(array_column($dados, 'invernar_valor_vendas')),
            'geral_quantidade' => array_sum(array_column($dados, 'geral_quantidade')),
            'geral_comissao' => array_sum(array_column($dados, 'geral_comissao')),
            'geral_valor_vendas' => array_sum(array_column($dados, 'geral_valor_vendas')),
        ];

        if ($ano < date('Y')) {
            $qtd_meses_lancados = 12;
        } else {
            $qtd_meses_lancados = (int) date('m');
        }
        $medias_se = [
            'gordo_quantidade' => ceil($totais['gordo_quantidade'] / $qtd_meses_lancados),
            'gordo_comissao' => $totais['gordo_comissao'] / $qtd_meses_lancados,
            'gordo_porcent_cabecas' => ($totais['gordo_quantidade'] / $totais['geral_quantidade']) * 100,
            'gordo_porcent_valores' => ($totais['gordo_comissao'] / $totais['geral_comissao']) * 100,
            'gordo_valor_vendas' => $totais['gordo_valor_vendas'] / $qtd_meses_lancados,
            'gordo_comissao_cabeca' => $totais['gordo_comissao'] / $totais['gordo_quantidade'],
            'gordo_valor_cabeca' => $totais['gordo_valor_vendas'] / $totais['gordo_quantidade'],
            'invernar_quantidade' => ceil($totais['invernar_quantidade'] / $qtd_meses_lancados),
            'invernar_comissao' => $totais['invernar_comissao'] / $qtd_meses_lancados,
            'invernar_valor_vendas' => $totais['invernar_valor_vendas'] / $qtd_meses_lancados,
            'invernar_porcent_cabecas' => ($totais['invernar_quantidade'] / $totais['geral_quantidade']) * 100,
            'invernar_porcent_valores' => ($totais['invernar_comissao'] / $totais['geral_comissao']) * 100,
            'invernar_comissao_cabeca' => $totais['invernar_comissao'] / $totais['invernar_quantidade'],
            'invernar_valor_cabeca' => $totais['invernar_valor_vendas'] / $totais['invernar_quantidade'],
            'geral_quantidade' => ceil($totais['geral_quantidade'] / $qtd_meses_lancados),
            'geral_comissao' => $totais['geral_comissao'] / $qtd_meses_lancados,
            'geral_valor_vendas' => $totais['geral_valor_vendas'] / $qtd_meses_lancados,
        ];


        $medias = [
            'gordo_quantidade' => ceil($totais['gordo_quantidade'] / 12),
            'gordo_comissao' => $totais['gordo_comissao'] / 12,
            'gordo_valor_vendas' => $totais['gordo_valor_vendas'] / 12,
            'invernar_quantidade' => ceil($totais['invernar_quantidade'] / 12),
            'invernar_comissao' => $totais['invernar_comissao'] / 12,
            'invernar_valor_vendas' => $totais['invernar_valor_vendas'] / 12,
            'geral_quantidade' => ceil($totais['geral_quantidade'] / 12),
            'geral_comissao' => $totais['geral_comissao'] / 12,
            'geral_valor_vendas' => $totais['geral_valor_vendas'] / 12,
        ];

        return compact('dados', 'totais', 'medias_se', 'medias');
    }

	public function beforeSave($options = array()) {
		// $this->data[$this->alias]['cad_usuario_id'] = AuthComponent::user('id');

        if ( isset($this->data[$this->alias]['data_emissao']) && !is_null($this->data[$this->alias]['data_emissao']) ) {
            $this->data[$this->alias]['data_emissao'] = $this->dateBrEn($this->data[$this->alias]['data_emissao']);
        }
        if ( isset($this->data[$this->alias]['data_abate']) && !is_null($this->data[$this->alias]['data_abate']) ) {
            $this->data[$this->alias]['data_abate'] = $this->dateBrEn($this->data[$this->alias]['data_abate']);
        }
        if ( isset($this->data[$this->alias]['data_embarque']) && !is_null($this->data[$this->alias]['data_embarque']) ) {
            $this->data[$this->alias]['data_embarque'] = $this->dateBrEn($this->data[$this->alias]['data_embarque']);
        }

        if ( isset($this->data[$this->alias]['peso_fazenda_total']) ) {
            $this->data[$this->alias]['peso_fazenda_total'] = $this->currencyToFloat($this->data[$this->alias]['peso_fazenda_total']);
        } else {
            $this->data[$this->alias]['peso_fazenda_total'] = 0.0;
        }
        if ( isset($this->data[$this->alias]['peso_frigorifico']) ) {
            $this->data[$this->alias]['peso_frigorifico'] = $this->currencyToFloat($this->data[$this->alias]['peso_frigorifico']);
        } else {
            $this->data[$this->alias]['peso_frigorifico'] = null;
        }

        if ( isset($this->data[$this->alias]['desconto_funral_porcentual']) ) {
            $this->data[$this->alias]['desconto_funral_porcentual'] = $this->currencyToFloat($this->data[$this->alias]['desconto_funral_porcentual']);
        } else {
            $this->data[$this->alias]['desconto_funral_porcentual'] = null;
        }
        if ( isset($this->data[$this->alias]['desconto_funral_valor']) ) {
            $this->data[$this->alias]['desconto_funral_valor'] = $this->currencyToFloat($this->data[$this->alias]['desconto_funral_valor']);
        } else {
            $this->data[$this->alias]['desconto_funral_valor'] = null;
        }

        if ( isset($this->data[$this->alias]['desconto_fundesa_porcentual']) ) {
            $this->data[$this->alias]['desconto_fundesa_porcentual'] = $this->currencyToFloat($this->data[$this->alias]['desconto_fundesa_porcentual']);
        } else {
            $this->data[$this->alias]['desconto_fundesa_porcentual'] = null;
        }
        if ( isset($this->data[$this->alias]['desconto_fundesa_valor']) ) {
            $this->data[$this->alias]['desconto_fundesa_valor'] = $this->currencyToFloat($this->data[$this->alias]['desconto_fundesa_valor']);
        } else {
            $this->data[$this->alias]['desconto_fundesa_valor'] = null;
        }

        if ( isset($this->data[$this->alias]['valor_liquido']) ) {
            $this->data[$this->alias]['valor_liquido'] = $this->currencyToFloat($this->data[$this->alias]['valor_liquido']);
            //debug($this->data[$this->alias]['valor_liquido']); die();
        }

        if ( isset($this->data[$this->alias]['comissao_comprador_porcentual']) ) {
            $this->data[$this->alias]['comissao_comprador_porcentual'] = $this->currencyToFloat($this->data[$this->alias]['comissao_comprador_porcentual']);
        } else {
            $this->data[$this->alias]['comissao_comprador_porcentual'] = null;
        }
        if ( isset($this->data[$this->alias]['comissao_comprador_valor']) ) {
            $this->data[$this->alias]['comissao_comprador_valor'] = $this->currencyToFloat($this->data[$this->alias]['comissao_comprador_valor']);
        } else {
            $this->data[$this->alias]['comissao_comprador_valor'] = 0.0;
        }
        if ( isset($this->data[$this->alias]['comissao_comprador_data_pgto']) && !is_null($this->data[$this->alias]['comissao_comprador_data_pgto']) ) {
            $this->data[$this->alias]['comissao_comprador_data_pgto'] = $this->dateBrEn($this->data[$this->alias]['comissao_comprador_data_pgto']);
        }

        if ( isset($this->data[$this->alias]['comissao_vendedor_porcentual']) ) {
            $this->data[$this->alias]['comissao_vendedor_porcentual'] = $this->currencyToFloat($this->data[$this->alias]['comissao_vendedor_porcentual']);
        } else {
            $this->data[$this->alias]['comissao_vendedor_porcentual'] = null;
        }
        if ( isset($this->data[$this->alias]['comissao_vendedor_valor']) ) {
            $this->data[$this->alias]['comissao_vendedor_valor'] = $this->currencyToFloat($this->data[$this->alias]['comissao_vendedor_valor']);
        } else {
            $this->data[$this->alias]['comissao_vendedor_valor'] = null;
        }
        if ( isset($this->data[$this->alias]['comissao_vendedor_data_pgto']) && !is_null($this->data[$this->alias]['comissao_vendedor_data_pgto']) ) {
            $this->data[$this->alias]['comissao_vendedor_data_pgto'] = $this->dateBrEn($this->data[$this->alias]['comissao_vendedor_data_pgto']);
        }

        if ( !isset($this->data[$this->alias]['comissao_vendedor_pago']) ) {
            $this->data[$this->alias]['comissao_vendedor_pago'] = null;
        }
        if ( !isset($this->data[$this->alias]['comissao_comprador_pago']) ) {
            $this->data[$this->alias]['comissao_comprador_pago'] = 0;
        }

        if ( !isset($this->data[$this->alias]['prazo_pgto_dias']) || empty($this->data[$this->alias]['prazo_pgto_dias'])) {
            $this->data[$this->alias]['prazo_pgto_dias'] = null;
        }

		return true;
    }

}