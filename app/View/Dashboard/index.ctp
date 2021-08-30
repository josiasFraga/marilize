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
	<div class="col-md-6">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject bold uppercase font-dark">Próximas Despesas</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th width="15%">Vencimento</th>
								<th width="25">Fazenda</th>
								<th width="30%">Fornecedor</th>
								<th width="15%">Valor</th>
								<th width="15%" class="text-center">Ações</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($despesas as $key => $value): ?>
							<tr class="<?php echo $value['PagamentoData']['_atrasado'] ? 'danger' : ($value['PagamentoData']['_hoje'] ? 'info' : '') ?>">
								<!--<td>
									<a href="<?php echo $this->Html->url(['controller' => 'RomaneioGordo', 'action' => 'alterar', $value['Romaneio']['id']]) ?>" target="_BLANK"><?php echo $value['Romaneio']['numero'] ?></a>		
								</td>-->
								<td><?php echo date('d/m/Y', strtotime($value['PagamentoData']['data_venc'])) ?></td>
								<td><?php echo $value['Fazenda']['nome'] ?></td>
								<td><?php echo $value['Pessoa']['nome_fantasia'] ?></td>
								<td>R$ <?php echo number_format($value['PagamentoData']['valor'], 2, ',', '.') ?></td>
								<td  class="text-center">
								<!--<?= '<button title="Vence em '.date('d/m/Y', strtotime($value['PagamentoData']['data_venc'])).'" type="button" class="btn btn-icon-only yellow-lemon" data-toggle="modal" data-target="#modalAddPagamento" data-whatever="'.$value['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>' ?>-->
								<?= '<a href="'.Router::url(array('controller' => 'ContasPagar', 'action' => 'alterar', $value['PagamentoData']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>'; ?>
								</td>
							</tr>
						<?php endforeach ?>

						<?php if (!$despesas || count($despesas) == 0): ?>
							<tr>
								<td colspan="5">Não há contas a vencer.</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject bold uppercase font-dark">Próximas Receitas</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th width="15%">Vencimento</th>
								<th width="25">Fazenda</th>
								<th width="30%">Fornecedor</th>
								<th width="15%">Valor</th>
								<th width="15%" class="text-center">Ações</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($receitas as $key => $value): ?>
							<tr class="<?php echo $value['PagamentoData']['_atrasado'] ? 'danger' : ($value['PagamentoData']['_hoje'] ? 'info' : '') ?>">
								<!--<td>
									<a href="<?php echo $this->Html->url(['controller' => 'RomaneioGordo', 'action' => 'alterar', $value['Romaneio']['id']]) ?>" target="_BLANK"><?php echo $value['Romaneio']['numero'] ?></a>		
								</td>-->
								<td><?php echo date('d/m/Y', strtotime($value['PagamentoData']['data_venc'])) ?></td>
								<td><?php echo $value['Fazenda']['nome'] ?></td>
								<td><?php echo $value['Pessoa']['nome_fantasia'] ?></td>
								<td>R$ <?php echo number_format($value['PagamentoData']['valor'], 2, ',', '.') ?></td>
								<td  class="text-center">
								<!--<?= '<button title="Vence em '.date('d/m/Y', strtotime($value['PagamentoData']['data_venc'])).'" type="button" class="btn btn-icon-only yellow-lemon" data-toggle="modal" data-target="#modalAddPagamento" data-whatever="'.$value['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>' ?>-->
								<?= '<a href="'.Router::url(array('controller' => 'ContasPagar', 'action' => 'alterar', $value['PagamentoData']['id'])).'" class="btn btn-icon-only green" data-toggle=""><i class="fa fa-pencil"></i></a>'; ?>
								</td>
							</tr>
						<?php endforeach ?>

						<?php if (!$receitas || count($receitas) == 0): ?>
							<tr>
								<td colspan="5">Não há contas a vencer.</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
