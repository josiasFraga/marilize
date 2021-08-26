<div>
    <div class="top-left">
        <p class="rel_esc">            
           Relatório de Contas
        </p>
    </div>
    <div class="top-right text-right">
        <img src="http://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="9"  class="text-center">Contas</th>
        </tr>
        <tr>
            <th class="text-center">Vencimento em</th>
            <th class="text-center">Pagamento em</th>
            <th class="text-center">Empresa</th>
            <th class="text-center">Fornecedor</th>
            <th class="text-center">Categoria</th>
            <th class="text-center">Parcela</th>
            <th class="text-center">Valor</th>
            <th class="text-center">Obs.</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>

    <?php $total = 0; ?>
    <?php foreach ($registros as $item): ?>
 
        <tr>
            <td class="text-center"><?= date('d/m/Y',strtotime($item['PagamentoData']['data_venc'])) ?></td>
            <td class="text-center"><?= is_null($item['PagamentoData']['data_pago']) ? '' : date('d/m/Y',strtotime($item['PagamentoData']['data_pago'])) ?></td>
            <td class="text-center"><?= $item['Empresa']['nome'] ?></td>
            <td class="text-center"><?= $item['Pessoa']['nome_fantasia'] ?></td>
            <td class="text-center"><?= $item['PagamentoCategoria']['categoria'] ?></td>
            <td class="text-center"><?= $item['PagamentoData']['nparcela'] ?>/<?= $item['PagamentoData']['_total_parcelas'] ?></td>
            <td class="text-center">R$ <?= number_format($item['PagamentoData']['valor'],2,',','.'); ?></td>
            <td class="text-center"><?= $item['PagamentoData']['observacoes'] ?></td>
            <td class="text-center"><?= $item['PagamentoStatus']['status'] ?></td>


        </tr>

        <?php $total += $item['PagamentoData']['valor']; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="9">Total: <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
    </tr>

    </tbody>
</table>

<hr>