<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'safras', 'action' => 'index')) ?>">Safras</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Nova Safra
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-user font-red-sunglo"></i>
			<span class="caption-subject font-red-sunglo bold uppercase">Nova Safra</span>
			<span class="caption-helper"></span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form class="" action="#" method="post" enctype="multipart/form-data" id="nova-safra" autocomplete="off">
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
				
				<div class="form-group">
					<label class="control-label ">Nome: <span class="required">*</span>
					</label>
					<div class="">
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control required" name="data[Safra][nome]" placeholder="Digite o nome do safra" />
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label ">Período: <span class="required">*</span>
					</label>
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control required rangepicker" name="data[Safra][inicio_fim]" placeholder="Selecione o período da safra" />
						</div>
				</div>
                
			</div>

			<div class="form-actions">
				<div class="row">
					<div class="text-right">
						<button class="btn green" type="submit">Cadastrar</button>
						<button class="btn default" type="reset">Limpar Campos</button>
					</div>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>

<?php
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/layouts/layout4/css/custom', array('block' => 'cssPage'));
//$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage'));
//$this->Html->css('/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3', array('block' => 'cssPage'));
//$this->Html->css('/metronic/assets/global/plugins/dependent-dropdown-master/css/dependent-dropdown.min', array('block' => 'cssPage'));

/*-- BEGIN PAGE LEVEL PLUGINS --*/
$this->Html->script('/metronic/assets/global/plugins/jquery.form.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery.metadata', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min', array('block' => 'scriptBottom'));
//$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Safras/adicionar', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>