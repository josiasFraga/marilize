<div class="modal fade bs-modal-sm" id="modalDataPago" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Contas à Pagar</h4>
			</div>
			<div class="modal-body">
				<div id="viewDataPago"></div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Fechar</button>
				<!-- <button type="button" class="btn green">Save changes</button> -->
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade bs-modal-sm" id="modalAddPagamento" role="basic" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Adicionar Data de Pagamento</h4>
			</div>
			<form role="form" id="alterar-pagar" method="post" enctype="multipart/form-data" action="">
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

<div class="modal fade bs-modal-sm" id="modalPagarVarious" role="basic" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Adicionar Data de Pagamento</h4>
			</div>
			<form role="form" id="pagarvarious" method="post" enctype="multipart/form-data" action="">
				<div class="" id="alert-pagar"></div>
				<div class="form-body">
					<div class="modal-body">
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab_dados">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control form-filter input-sm" readonly name="data[data_pago]" placeholder="Pago em" id="data_pago">
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
													<select class="form-control" name="data[forma_id]" id="forma_pago">
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
						<button type="button" class="btn btn-success" id="adicionar">Adicionar</button>
					</div>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
<!-- BEGIN PAGE TITLE -->
<div class="page-title">
	<h1>Contas à Pagar <small>administrar Contas</small></h1>
</div>
<!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD -->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
<li>
	<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Início</a>
	<i class="fa fa-circle"></i>
</li>
<li>
	<a href="#">Contas à Pagar</a>
</li>
</ul>

<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
<div class="col-md-12">
	<!-- BEGIN SAMPLE TABLE PORTLET-->
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="font-dark"></i>
				<span class="caption-subject font-dark bold uppercase">Contas à Pagar</span>
			</div>
			<div class="actions">
				<a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'ContasPagar', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-success">
					<i class="fa fa-plus"></i> Incluir Conta à Pagar</a>
				<a role="button" target="_BLANK" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'ContasPagar', 'action' => 'imprimir')) ?>" class="btn btn-circle btn-default">
					<i class="fa fa-print"></i> Imprimir</a>
				<div class="btn-group">
					<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
						<i class="fa fa-share"></i>
						<span class="hidden-xs"> Ações </span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-right" id="datatable_ajax_tools">
						<li>
							<a href="javascript:;" data-action="6" class="tool-action">
								<i class="fa fa-money"></i> Adicionar Pagamento</a>
						</li>
						<li>
							<a href="javascript:;" data-action="4" class="tool-action">
								<i class="fa fa-remove"></i> Excluir</a>
						</li>
						<li class="divider"> </li>
						<li>
							<a href="javascript:;" data-action="5" class="tool-action reload">
								<i class="icon-refresh"></i> Recarregar</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="portlet-body">
			<div class="table-scrollable">
				<table class="table table-striped table-bordered table-hover table-checkable" id="table-pagarpagamentos">
					<thead>
						<tr>
							<th class="table-checkbox" width="20px">
								<input type="checkbox" class="group-checkable" data-set="#table-pagarpagamentos .checkboxes"/>
							</th>
							<th>Vencimento em</th>
							<th>Pagamento em</th>
							<th width="15%">Empresa</th>
							<th width="15%">Fornecedor</th>
							<th width="10%">Categoria</th>
							<th>Nº Parcela</th>
							<th width="10%">Valor</th>
							<th>OBS</th>
							<th>Status</th>
							<th width="100px">Ações</th>
						</tr>
						<tr role="row" class="filter">
							<td></td>
							<td>
								<input type="date" class="form-control form-filter input-sm" name="data_venc" value="<?= date('Y-m-01') ?>" style="margin-bottom:4px">
								<input type="date" class="form-control form-filter input-sm" name="data_venc_ate" value="<?= date('Y-m-t') ?>">
							</td>
							<td>
								<input type="date" class="form-control form-filter input-sm" name="data_pgto" value="" style="margin-bottom:4px">
								<input type="date" class="form-control form-filter input-sm" name="data_pgto_ate" value="">
							</td>
							<td>
								<select class="form-control form-filter input-sm select2" name="empresa_id">
									<option value="">Selecione ...</option>
									<?php foreach ($empresas as $key => $nome) { ?>
										<option value="<?=$key?>"><?=$nome?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select class="form-control form-filter input-sm select2" name="fornecedor_id">
									<option value="">Selecione ...</option>
									<?php foreach ($fornecedores as $key => $nome) { ?>
										<option value="<?=$key?>"><?=$nome?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select class="form-control form-filter input-sm select2" name="categoria_id">
									<option value="">Selecione ...</option>
									<?php foreach ($categorias as $key => $categoria) { ?>
										<option value="<?=$key?>"><?=$categoria?></option>
									<?php } ?>
								</select>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<select class="form-control form-filter input-sm" name="status_id">
									<option value="">Selecione ...</option>
									<option value="1">Aguardando Pagamento</option>
									<!-- <option value="7">Cancelada</option> -->
									<option value="3">Pago</option>
								</select>
							</td>
							<td>
								<div class="margin-bottom-5">
									<button class="btn btn-sm yellow filter-submit margin-bottom btn-block">
                                        <i class="fa fa-search"></i> Procurar
                                    </button>
								</div>
								<button class="btn btn-sm red filter-cancel btn-block">
                                    <i class="fa fa-times"></i> Limpar
                                </button>
							</td>
						</tr>
					</thead>
					<tbody><?php ##JAVASCRIPT TRAZ AS INFORMACOES PARA ESTA TABELA COM aoColumns; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- END SAMPLE TABLE PORTLET-->
</div>
</div>

<!-- BEGIN PAGE LEVEL STYLES -->
<?php $this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage')); ?>

<?php $this->Html->css('/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap', array('block' => 'cssPage')); ?>

<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', array('block' => 'cssPage')); ?>

<?php // $this->Html->css('/metronic/assets/global/plugins/bootstrap/css/bootstrap.min', array('block' => 'scriptBottom')); ?>
<?php // $this->Html->css('/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php $this->Html->script('/metronic/assets/global/plugins/select2/js/select2.full.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/select2/js/i18n/pt-BR', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/datatables/datatables.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap', array('block' => 'scriptBottom')); ?>
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

<?php // $this->Html->script('/metronic/assets/global/plugins/bootstrap/js/bootstrap.min', array('block' => 'scriptBottom')); ?>
<?php // $this->Html->script('/metronic/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min', array('block' => 'scriptBottom')); ?>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php // $this->Html->script('/metronic/assets/pages/scripts/ui-confirmations.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/scripts/datatable', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/js/ContasPagar/index.js?v=1.0.4', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->