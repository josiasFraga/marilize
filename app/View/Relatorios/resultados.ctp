<div class="scroll">


<table cellspacing="0" cellpadding="0">
    <tr>
        <th colspan="8" class="invernar">INVERNAR</th>
        <th colspan="7" class="gordo">GORDO</th>
        <th colspan="3" class="geral">GERAL</th>
    </tr>
    <tr>
        <th class="mes">Mês</th>
        <th class="quant color1">Quantidade</th>
        <th class="comissao color1">Comissão</th>
        <th class="comissao color1">% Cab.</th>
        <th class="comissao color1">% Vlrs.</th>
        <th class="comissao color1">Com. p/ Cab.</th>
        <th class="comissao color1">p/ Cab.</th>
        <th class="valor color1">Valor de Vendas</th>

        <th class="quant color2">Quantidade</th>
        <th class="comissao color2">Comissão</th>
        <th class="comissao color2">% Cab.</th>
        <th class="comissao color2">% Vlrs.</th>
        <th class="comissao color2">Com. p/ Cab.</th>
        <th class="comissao color2">p/ Cab.</th>
        <th class="valor color2">Valor de Vendas</th>

        <th class="quant color3">Quantidade</th>
        <th class="comissao color3">Comissão</th>
        <th class="valor color3">Valor de Vendas</th>
    </tr>
<?php foreach ($dados as $dado): ?>
    <tr>
        <td class="title"><?php echo $dado['mes'] ?></td>

         <td><?php echo number_format($dado['invernar_quantidade'], 0, '', '.') ?></td>
        <td><?php echo number_format($dado['invernar_comissao'], 2, ',', '.') ?></td>
        <td><?php echo number_format($dado['invernar_porcent_cabecas'], 2, ',', '.') ?>%</td>
        <td><?php echo number_format($dado['invernar_porcent_valores'], 2, ',', '.') ?>%</td>
        <td><?php echo number_format($dado['invernar_comissao_cabeca'], 2, ',', '.') ?></td>
        <td><?php echo number_format($dado['invernar_valor_cabeca'], 2, ',', '.') ?></td>

        <td><?php echo number_format($dado['invernar_valor_vendas'], 2, ',', '.') ?></td>

        <td><?php echo number_format($dado['gordo_quantidade'], 0, '', '.') ?></td>
        <td><?php echo number_format($dado['gordo_comissao'], 2, ',', '.') ?></td>
        <td><?php echo number_format($dado['gordo_porcent_cabecas'], 2, ',', '.') ?>%</td>
        <td><?php echo number_format($dado['gordo_porcent_valores'], 2, ',', '.') ?>%</td>
        <td><?php echo number_format($dado['gordo_comissao_cabeca'], 2, ',', '.') ?></td>
        <td><?php echo number_format($dado['gordo_valor_cabeca'], 2, ',', '.') ?></td>

        <td><?php echo number_format($dado['gordo_valor_vendas'], 2, ',', '.') ?></td>


         <td><?php echo number_format($dado['geral_quantidade'], 0, '', '.') ?></td>
        <td><?php echo number_format($dado['geral_comissao'], 2, ',', '.') ?></td>
        <td><?php echo number_format($dado['geral_valor_vendas'], 2, ',', '.') ?></td>

    </tr>
<?php endforeach; ?>
    


    <tr>
        <td class="title">&nbsp;</td>
       
        <td class="color1"><?php echo number_format($totais['invernar_quantidade'], 0, '', '.'); ?></td>
        <td class="color1"><?php echo number_format($totais['invernar_comissao'], 2, ',', '.') ?></td>
        <td class="color1"><?php echo number_format($medias_se['invernar_porcent_cabecas'], 2, ',', '.') ?>%</td>
        <td class="color1"><?php echo number_format($medias_se['invernar_porcent_valores'], 2, ',', '.') ?>%</td>
        <td class="color1"><?php echo number_format($medias_se['invernar_comissao_cabeca'], 2, ',', '.') ?></td>
        <td class="color1"><?php echo number_format($medias_se['invernar_valor_cabeca'], 2, ',', '.') ?></td>
        <td class="color1"><?php echo number_format($totais['invernar_valor_vendas'], 2, ',', '.') ?></td>

        <td class="color2"><?php echo number_format($totais['gordo_quantidade'], 0, '', '.'); ?></td>
        <td class="color2"><?php echo number_format($totais['gordo_comissao'], 2, ',', '.') ?></td>
        <td class="color2"><?php echo number_format($medias_se['gordo_porcent_cabecas'], 2, ',', '.') ?>%</td>
        <td class="color2"><?php echo number_format($medias_se['gordo_porcent_valores'], 2, ',', '.') ?>%</td>
        <td class="color2"><?php echo number_format($medias_se['gordo_comissao_cabeca'], 2, ',', '.') ?></td>
        <td class="color2"><?php echo number_format($medias_se['gordo_valor_cabeca'], 2, ',', '.') ?></td>
        <td class="color2"><?php echo number_format($totais['gordo_valor_vendas'], 2, ',', '.') ?></td>

        <td class="color3"><?php echo number_format($totais['geral_quantidade'], 0, '', '.'); ?></td>
        <td class="color3"><?php echo number_format($totais['geral_comissao'], 2, ',', '.') ?></td>
        <td class="color3"><?php echo number_format($totais['geral_valor_vendas'], 2, ',', '.') ?></td>
    </tr>

    <tr>
        <td class="title">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="title strong">MÉDIA</td>

        <td class="mcolor1"><?php echo number_format($medias_se['invernar_quantidade'], 0, '', '.'); ?></td>
        <td class="mcolor1"><?php echo number_format($medias_se['invernar_comissao'], 2, ',', '.') ?></td>
        <td class="mcolor1">&nbsp;</td>
        <td class="mcolor1">&nbsp;</td>
        <td class="mcolor1">&nbsp;</td>
        <td class="mcolor1">&nbsp;</td>
        <td class="mcolor1"><?php echo number_format($medias_se['invernar_valor_vendas'], 2, ',', '.') ?></td>


        <td class="mcolor2"><?php echo number_format($medias_se['gordo_quantidade'], 0, '', '.'); ?></td>
        <td class="mcolor2"><?php echo number_format($medias_se['gordo_comissao'], 2, ',', '.') ?></td>
        <td class="mcolor2">&nbsp;</td>
        <td class="mcolor2">&nbsp;</td>
        <td class="mcolor2">&nbsp;</td>
        <td class="mcolor2">&nbsp;</td>
        <td class="mcolor2"><?php echo number_format($medias_se['gordo_valor_vendas'], 2, ',', '.') ?></td>

        <td class="mcolor3"><?php echo number_format($medias_se['geral_quantidade'], 0, '', '.'); ?></td>
        <td class="mcolor3"><?php echo number_format($medias_se['geral_comissao'], 2, ',', '.') ?></td>
        <td class="mcolor3"><?php echo number_format($medias_se['geral_valor_vendas'], 2, ',', '.') ?></td>
    </tr>
</table>
</div>