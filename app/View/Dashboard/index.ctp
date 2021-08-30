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


<div class="modal fade bs-modal-sm" id="modalAddPagamento" role="basic" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Adicionar Data de Pagamento</h4>
			</div>
			<form role="form" id="alterar-pagar" method="post" enctype="multipart/form-data" action="" autocomplete="off">
				<input type="hidden" name="data[PagamentoData][status_id]" value="3">
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					<span class="message">Por favor, revise os campos em vermelho.</span>
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					<span class="message"></span>
				</div>
				<div class="alert alert-warning display-hide">
					<button class="close" data-close="alert"></button>
					<span class="message"></span>
				</div>
				<div class="form-body">
					<div class="modal-body">
						<!-- <ul class="nav nav-tabs">
							<li class="active"> <a href="#tab_dados" data-toggle="tab"> Dados </a> </li>
						</ul> -->
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab_dados">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control form-filter input-sm" readonly name="data[PagamentoData][data_pago]" placeholder="Pago em">
													<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">Forma: <span class="required">*</span></label>
												<div class="input-icon right">
													<i class="fa"></i>
													<select class="form-control" name="data[PagamentoData][forma_id]">
														<option value="">Selecione ...</option>
													<?php foreach ($listformas as $key => $forma) { ?>
														<option value="<?=$key?>"><?=$forma?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success">Adicionar</button>
					</div>
					<div id="addDataPago"></div>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
								<?= '<button title="Vence em '.date('d/m/Y', strtotime($value['PagamentoData']['data_venc'])).'" type="button" class="btn btn-icon-only yellow-lemon" data-toggle="modal" data-target="#modalAddPagamento" data-whatever="'.$value['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>' ?>
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
								<?= '<button title="Vence em '.date('d/m/Y', strtotime($value['PagamentoData']['data_venc'])).'" type="button" class="btn btn-icon-only yellow-lemon" data-toggle="modal" data-target="#modalAddPagamento" data-whatever="'.$value['PagamentoData']['id'].'"><i class="fa fa-money"></i></button>' ?>
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

<!-- BEGIN PAGE LEVEL STYLES -->
<?php $this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage')); ?>


<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', array('block' => 'cssPage')); ?>

<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php $this->Html->script('/metronic/assets/global/plugins/select2/js/select2.full.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/select2/js/i18n/pt-BR', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootbox/bootbox.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php // $this->Html->script('/metronic/assets/pages/scripts/ui-confirmations.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/js/Dashboard/index.js?v=1.0.4', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->
