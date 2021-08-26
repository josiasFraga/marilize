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
            <th colspan="9"  class="text-center">Romaneios</th>
        </tr>
        <tr>
            <th class="text-center">Data</th>
            <th class="text-center">Romaneio</th>
            <th class="text-center">Qtd.</th>
            <th class="text-center">Vencto / Parcelas em aberto</th>
            <th class="text-center">Valor</th>
            <th class="text-center">Comprador</th>

            <th class="text-center">Comissão</th>
            <th class="text-center">Vendedor</th>
            <th class="text-center">Comissão</th>


        </tr>
    </thead>
    <tbody>

        <?php
$total_cab = 0;
$total_fat = 0;
$total_com = 0;
?>

    <?php foreach ($itens as $romaneio): ?>
 
        <tr>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['data_emissao'])) ?></td>
            <td class="text-center"><?php echo $romaneio['Romaneio']['numero'] ?></td>
            <td class="text-center"><?php echo $romaneio['Romaneio']['_cabecas'] ?></td>
            <td class="text-center"><?php echo $romaneio['Romaneio']['_pgto'] ?></td>
            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['valor_liquido'],2,',','.'); ?></td>
            <td class="text-center"><?php echo $romaneio['Pessoa']['nome_fantasia'] ?></td>


            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['comissao_comprador_valor'],2,',','.'); ?></td>
            <td class="text-center"><?php echo $romaneio['PessoaVendedor']['nome_fantasia'] ?></td>
            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['comissao_vendedor_valor'],2,',','.'); ?></td>

        </tr>

        <?php 
        $total_cab += $romaneio['Romaneio']['_cabecas'];
        $total_fat += $romaneio['Romaneio']['valor_liquido'];
        $total_com += $romaneio['Romaneio']['comissao_comprador_valor'] + $romaneio['Romaneio']['comissao_vendedor_valor']; ?>
    <?php endforeach; ?>
      
<tr>
    <td colspan="9">Total cabeças: <strong><?php echo $total_cab ?></strong> | Total vendido: <strong>R$ <?php echo number_format($total_fat, 2, ',', '.') ?></strong> | Total comissão: <strong>R$ <?php echo number_format($total_com, 2, ',', '.') ?></strong>
    </tr>

    </tbody>
</table>

<hr>