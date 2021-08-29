<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Fazendas <small>administrar fazendas</small></h1>
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
		<a href="#">Fazendas</a>
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
					<i class="font-green"></i>
					<span class="caption-subject font-green bold uppercase">Visualizar todas as fazendas</span>
				</div>

				<div class="actions">
					<a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'fazendas', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-default">
						<i class="fa fa-plus"></i> Incluir Fazenda </a>
				</div>

			</div>
			<div class="portlet-body">
				<div class="table-responsive">

					<table class="table table-striped table-bordered table-hover table-checkable" id="table-fazendas">
						<thead>
							<tr>
								<th class="table-checkbox" width="20px">
									<input type="checkbox" class="group-checkable" data-set="#table-fazendas .checkboxes"/>
								</th>
								<th>
									Nome
								</th>
								<th class="text-center">
									IE
								</th>
								<th>
									Localização
								</th>
								<th>
									Obs
								</th>
								<th class="text-center">
									Ativa
								</th>
								<th width="100px">
									Ações
								</th>
							</tr>
							<tr role="row" class="filter">
								<td></td>
								<td>
									<input type="text" class="form-control form-filter input-sm" name="nome">
								</td>
								<td>
									<input type="text" class="form-control form-filter input-sm" name="ie">
								</td>
								<td>
									<input type="text" class="form-control form-filter input-sm" name="localizacao">
								</td>
								<td>
									<input type="text" class="form-control form-filter input-sm" name="obs">
								</td>
								<td>
									<select class="form-control form-filter" name="ativa">
                                        <option value="">[filtrar...]</option>
                                        <option value="Y">Ativa</option>
                                        <option value="N">Inativa</option>
                                    </select>
								</td>
								<td>
									<div class="margin-bottom-5">
										<button class="btn btn-sm yellow filter-submit margin-bottom btn-block"><i class="fa fa-search"></i> Procurar</button>
									</div>
									<button class="btn btn-sm red filter-cancel btn-block"><i class="fa fa-times"></i> Limpar</button>
								</td>
							</tr>
						</thead>
						<tbody>
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

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php $this->Html->script('/metronic/assets/global/scripts/datatable', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/js/Fazendas/index', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->