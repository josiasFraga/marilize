<div>
    <div class="top-left">
        <p class="rel_esc">            
           Listagem de Adiantamentos
        </p>
    </div>
    <div class="top-right text-right">
        <img src="https://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="7"  class="text-center">Adiantamentos</th>
        </tr>
        <tr>
            <th class="text-center">Credor</th>
            <th class="text-center">Tomador</th>
            <th class="text-center">Emissão</th>
            <th class="text-center">Entrada</th>
            <th class="text-center">Saída</th>
            <th class="text-center">Saldo</th>
            <th class="text-center">Obs</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $total_entradas = 0;
    $total_saidas = 0;
    $total_saldo = 0;
    foreach ($dados as $dado):
        $total_entradas += $dado['Adiantamento']['entrada'];
        $total_saidas += $dado['Adiantamento']['saida'];
    ?>
 
        <tr>
            <td class="text-center"><?php echo $dado['Credor']['razao_social'] ?></td>
            <td class="text-center"><?php echo $dado['Tomador']['razao_social'] ?></td>
            <td class="text-center"><?php echo date('d/m/Y', strtotime($dado['Adiantamento']['emissao'])); ?></td>
            <td class="text-center"><?php echo "R&#36; ".number_format($dado['Adiantamento']['entrada'], 2, ',', '.') ?></td>
            <td class="text-center"><?php echo "R&#36; ".number_format($dado['Adiantamento']['saida'], 2, ',', '.') ?></td>
            <td class="text-center"><?php echo "R&#36; ".number_format($dado['Adiantamento']['saldo'], 2, ',', '.') ?></td>
            <td class="text-center"><?php echo $dado['Adiantamento']['obs'] ?></td>
        </tr>     
    <?php endforeach; ?>
    </tbody>
</table>

<div>
<br>
<br>
<br>
<br>
Total Entradas: <strong>R$ <?php echo number_format($total_entradas,2,',','.'); ?></strong><br>
Total Entradas: <strong>R$ <?php echo number_format($total_saidas,2,',','.'); ?></strong><br>
Saldo: <strong>R$ <?php echo number_format($total_entradas-$total_saidas,2,',','.'); ?></strong>
</div>