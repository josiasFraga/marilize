<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
<!-- BEGIN PAGE TITLE -->
<div class="page-title">
	<h1>Usuários <small>administrar Usuários</small></h1>
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
	<a href="#">Usuários</a>
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
				<span class="caption-subject font-dark bold uppercase">Usuários</span>
			</div>
			<div class="actions">
				<a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Usuarios', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-default">
					<i class="fa fa-plus"></i> Incluir Usuário </a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="">
				<table class="table table-striped table-bordered table-hover table-checkable" id="table-usuarios">
					<thead>
						<tr>
							<th class="table-checkbox" width="20px">
								<input type="checkbox" class="group-checkable" data-set="#table-usuarios .checkboxes"/>
							</th>
							<th>Nome</th>
							<th>Email</th>
							<th>Ativo</th>
							<th width="150px">Ações</th>
						</tr>
						<tr role="row" class="filter">
							<td></td>
							<td><input type="text" class="form-control form-filter input-sm" name="nome"></td>
							<td><input type="text" class="form-control form-filter input-sm" name="email"></td>
							<td>
								<select type="text" class="form-control form-filter input-sm" name="ativo">
									<option value="">Selecione ...</option>
									<option value="Y">Sim</option>
									<option value="N">Não</option>
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
<?php //$this->Html->css('/metronic/assets/global/plugins/select2/select2', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap', array('block' => 'cssPage')); ?>

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
<?php $this->Html->script('/js/Usuarios/index', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->