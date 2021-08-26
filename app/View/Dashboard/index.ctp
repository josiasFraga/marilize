<style type="text/css">
	table tbody tr td { border-color: #ccc !important; }
	@media print {
		a[href]:after {
			content: none !important;
		}
	}

</style>
<?php echo $this->Session->flash(); ?>

<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Sistema de Gestão Marilize
			<small>página inicial</small>
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-xs-12 col-sm-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject bold uppercase font-dark">GADO GORDO - VENCIMENTOS DE HOJE E ATRASADOS</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th width="15%">Romaneio Nº</th>
								<th width="15%">Emissão em</th>
								<th width="20%">Comprador</th>
								<th width="20%">Vendedor</th>
								<th width="15%">Vencimento original</th>
								<th width="15%">Valor</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($romaneios_gordo_vencimentos as $key => $value): ?>
							<tr class="<?php echo $value['RomaneioVencimento']['_atrasado'] ? 'danger' : '' ?>">
								<td>
									<a href="<?php echo $this->Html->url(['controller' => 'RomaneioGordo', 'action' => 'alterar', $value['Romaneio']['id']]) ?>" target="_BLANK"><?php echo $value['Romaneio']['numero'] ?></a>		
								</td>
								<td><?php echo date('d/m/Y', strtotime($value['Romaneio']['data_emissao'])) ?></td>
								<td><?php echo $value['Pessoa']['nome_fantasia'] ?></td>
								<td><?php echo $value['PessoaVendedor']['nome_fantasia'] ?></td>
								<td><?php echo date('d/m/Y', strtotime($value['RomaneioVencimento']['vencimento_em'])) ?></td>
								<td>R$ <?php echo number_format($value['RomaneioVencimento']['valor'], 2, ',', '.') ?></td>

							</tr>
						<?php endforeach ?>

						<?php if (!$romaneios_gordo_vencimentos): ?>
							<tr>
								<td colspan="6">Não há vencimentos de Gordo para hoje.</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-12 col-xs-12 col-sm-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject bold uppercase font-dark">GADO INVERNAR - VENCIMENTOS DE HOJE E ATRASADOS</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th width="15%">Romaneio Nº</th>
								<th width="15%">Emissão em</th>
								<th width="20%">Comprador</th>
								<th width="20%">Vendedor</th>
								<th width="15%">Vencimento original</th>
								<th width="15%">Valor</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($romaneios_invernar_vencimentos as $key => $value): ?>
							<tr style="border-color: #000 !important" class="<?php echo $value['RomaneioVencimento']['_atrasado'] ? 'danger' : '' ?>">
								<td>
									<a href="<?php echo $this->Html->url(['controller' => 'RomaneioInvernar', 'action' => 'alterar', $value['Romaneio']['id']]) ?>" target="_BLANK"><?php echo $value['Romaneio']['numero'] ?></a>		
								</td>
								<td><?php echo date('d/m/Y', strtotime($value['Romaneio']['data_emissao'])) ?></td>
								<td><?php echo $value['Pessoa']['nome_fantasia'] ?></td>
								<td><?php echo $value['PessoaVendedor']['nome_fantasia'] ?></td>
								<td><?php echo date('d/m/Y', strtotime($value['RomaneioVencimento']['vencimento_em'])) ?></td>
								<td>R$ <?php echo number_format($value['RomaneioVencimento']['valor'], 2, ',', '.') ?></td>

							</tr>
						<?php endforeach ?>

						<?php if (!$romaneios_invernar_vencimentos): ?>
							<tr>
								<td colspan="6">Não há vencimentos de Invernar para hoje.</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
