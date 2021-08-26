<div>
    <div class="top-left">
        <p class="rel_esc">            
           Relatório de Romaneios em Aberto
        </p>
    </div>
    <div class="top-right text-right">
        <img src="http://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="4"  class="text-center">Compradores</th>
        </tr>
        <tr>
            <th class="text-center">Nº Romaneio</th>
            <th class="text-center">Data</th>
            <th class="text-center">Vencimento</th>
            <th class="text-center">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $ultimo_cliente = '';
        $subtotal = 0;
        $total=0;
        foreach( $romanios_n_pagos_compradores as $key => $romaneio ){

            if ( $ultimo_cliente != '' && $ultimo_cliente !=  $romaneio['Pessoa']['razao_social'] ) {
                echo '<tr><td colspan="3" class="text-right">SUBTOTAL</td><td>R$ '.number_format($subtotal,2,',','.').'</td></tr>';
                $subtotal = 0;
            }

            if ( $ultimo_cliente !=  $romaneio['Pessoa']['razao_social'] ) {
                echo '<tr class="subtitle"><td colspan="4">'.$romaneio['Pessoa']['razao_social'].'</td></tr>';
                $ultimo_cliente = $romaneio['Pessoa']['razao_social'];
            }
        ?>
        <tr>
            <td class="text-center"><?php echo $romaneio['Romaneio']['numero'] ?></td>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['data_emissao'])) ?></td>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['comissao_comprador_data_pgto'])) ?></td>
            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['comissao_comprador_valor'],2,',','.'); ?></td>
        </tr>
        <?php
            $subtotal+=$romaneio['Romaneio']['comissao_comprador_valor'];
            $total+=$romaneio['Romaneio']['comissao_comprador_valor'];
        }
        ?>
    </tbody>
</table>

<hr>

<table class="table">
    <thead>
        <tr>
            <th colspan="4"  class="text-center">Vendedores</th>
        </tr>
        <tr>
            <th class="text-center">Nº Romaneio</th>
            <th class="text-center">Data</th>
            <th class="text-center">Vencimento</th>
            <th class="text-center">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $ultimo_cliente = '';
        $subtotal = 0;
        $total=0;
        foreach( $romanios_n_pagos_vendedores as $key => $romaneio ){

            if ( $ultimo_cliente != '' && $ultimo_cliente !=  $romaneio['Pessoa']['razao_social'] ) {
                echo '<tr><td colspan="3" class="text-right">SUBTOTAL</td><td>R$ '.number_format($subtotal,2,',','.').'</td></tr>';
                $subtotal = 0;
            }

            if ( $ultimo_cliente !=  $romaneio['Pessoa']['razao_social'] ) {
                echo '<tr class="subtitle"><td colspan="4">'.$romaneio['Pessoa']['razao_social'].'</td></tr>';
                $ultimo_cliente = $romaneio['Pessoa']['razao_social'];
            }
        ?>
        <tr>
            <td class="text-center"><?php echo $romaneio['Romaneio']['numero'] ?></td>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['data_emissao'])) ?></td>
            <td class="text-center"><?php echo date('d/m/Y',strtotime($romaneio['Romaneio']['comissao_vendedor_data_pgto'])) ?></td>
            <td class="text-center">R$ <?php echo number_format($romaneio['Romaneio']['comissao_vendedor_valor'],2,',','.'); ?></td>
        </tr>
        <?php
            $subtotal+=$romaneio['Romaneio']['comissao_vendedor_valor'];
            $total+=$romaneio['Romaneio']['comissao_vendedor_valor'];
        }
        ?>
    </tbody>
</table>

<div id="totais">
    <div class="totais_right text-left">
        <p>R$ <?php echo number_format($total,2,',','.') ?></p>
    </div>
    <div class="totais_left text-right">
        <p>Comissão Total: </p>
    </div>
</div>