<div class="modal fade" id="addEspecie" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Adicionar Espécie</h4>
			</div>
			<!-- BEGIN FORM-->
			<form class="" action="#" method="post" enctype="multipart/form-data" id="adicionar-especies" autocomplete="off">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
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
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Espécie: <span class="required">*</span></label>
											<div class="input-icon left">
												<!-- <i class="fa"></i> -->
												<input type="text" class="form-control" name="data[RomaneioEspecie][especie]" />
											</div>
										</div>
									</div>
								</div>
							</div><!-- end form-body -->

						</div><!-- ./col-md-12 -->
					</div><!-- ./row -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancelar</button>
					<button class="btn green" type="submit">Adicionar</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="editEspecie" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Alterar Espécie</h4>
			</div>
			<!-- BEGIN FORM-->
			<form class="" action="#" method="post" enctype="multipart/form-data" id="alterar-especies" autocomplete="off">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="data[RomaneioEspecie][id]" value=""/>
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
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Espécie: <span class="required">*</span></label>
											<div class="input-icon left">
												<!-- <i class="fa"></i> -->
												<input type="text" class="form-control" name="data[RomaneioEspecie][especie]" value="" />
											</div>
										</div>
									</div>
								</div>
							</div><!-- end form-body -->

						</div><!-- ./col-md-12 -->
					</div><!-- ./row -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancelar</button>
					<button class="btn green" type="submit">Alterar</button>
				</div>
			</form>
			<!-- END FORM-->
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
	<h1>Espécies <small>administrar Espécies</small></h1>
</div>
<!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD -->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
<li>
	<a href="<?php echo $this->Html->url(array('controller' => 'dashboard', 'action' => 'index')) ?>">Início</a>
	<i class="fa fa-circle"></i>
</li>
<li>
	<a href="#">Espécies</a>
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
				<span class="caption-subject font-dark bold uppercase">Espécies</span>
			</div>
			<div class="actions">
				<a role="button" data-toggle="modal" href="#addEspecie" class="btn btn-circle btn-default">
					<i class="fa fa-plus"></i> Incluir Espécie </a>
			</div>
		</div>

		<div class="portlet-body">
			<div class="table-scrollable">
				<table class="table table-striped table-bordered table-hover table-checkable" id="table-especies">
					<thead>
						<tr>
							<th class="table-checkbox" width="20px">
								<input type="checkbox" class="group-checkable" data-set="#table-especies .checkboxes"/>
							</th>
							<th>Espécie</th>
							<!-- <th>Status</th> -->
							<th width="150px">Ações</th>
						</tr>
						<tr role="row" class="filter">
							<td></td>
							<td><input type="text" class="form-control form-filter input-sm" name="especie"></td>
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
<?php //$this->Html->css('/metronic/assets/global/plugins/select2/select2', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage')); ?>

<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', array('block' => 'cssPage')); ?>

<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php //$this->Html->script('/metronic/assets/global/plugins/select2/select2.min', array('block' => 'scriptBottom')); ?>
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

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php $this->Html->script('/metronic/assets/global/scripts/datatable', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/js/Especies/index.js?v=1.0.0', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->