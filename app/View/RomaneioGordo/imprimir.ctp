<div>
    <div class="top-left">
        <p class="rel_esc">            
           Relatório de Romaneios Gordo
        </p>
    </div>
    <div class="top-right text-right">
        <img src="http://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="7"  class="text-center">Romaneios</th>
        </tr>
        <tr>
            <th class="text-center">Data</th>
            <th class="text-center">Romaneio</th>
            <th class="text-center">Qtd.</th>
            <th class="text-center">Comissão</th>
            <th class="text-center">Vencto</th>
            <th class="text-center">Valor</th>

            <th class="text-center">Produtor</th>

        </tr>
    </thead>
    <tbody>

        <?php
$total_cab = 0;
$total_fat = 0;
$total_com = 0;
        foreach( $itens as $frig => $val ):
?>
<tr>
    <td colspan="7"><?php echo $frig ?>
    </td>
</tr>
    <?php foreach ($val['registros'] as $romaneio): ?>
 
        <tr>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['data_emissao'])) ?></td>
            <td class="text-center"><?php echo $romaneio['Romaneio']['numero'] ?></td>
            <td class="text-center"><?php echo $romaneio['Romaneio']['_cabecas'] ?></td>
            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['comissao_comprador_valor'],2,',','.'); ?></td>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['comissao_comprador_data_pgto'])) ?></td>
            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['valor_liquido'],2,',','.'); ?></td>
            <td class="text-center"><?php echo $romaneio['PessoaVendedor']['nome_fantasia'] ?></td>
        </tr>
    <?php endforeach; ?>
       <tr>
    <td colspan="7">Total cabeças: <strong><?php echo $val['total_cab'] ?></strong> | Total vendido: <strong>R$ <?php echo number_format($val['total_fat'], 2, ',', '.') ?></strong> | Total comissão: <strong>R$ <?php echo number_format($val['total_com'], 2, ',', '.') ?></strong>

        <?php
        $total_cab += $val['total_cab'];
        $total_fat += $val['total_fat'];
        $total_com += $val['total_com'];

        ?>
    </td>
    <?php endforeach; ?>
<tr>
    <td colspan="7">Total cabeças: <strong><?php echo $total_cab ?></strong> | Total vendido: <strong>R$ <?php echo number_format($total_fat, 2, ',', '.') ?></strong> | Total comissão: <strong>R$ <?php echo number_format($total_com, 2, ',', '.') ?></strong>
    </tr>

    </tbody>
</table>

<hr>