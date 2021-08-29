<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'fazendas', 'action' => 'index')) ?>">Fazendas</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Nova Fazenda
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-plus font-red-sunglo"></i>
			<span class="caption-subject font-red-sunglo bold uppercase">Nova Fazenda</span>
			<span class="caption-helper"></span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form class="" action="#" method="post" enctype="multipart/form-data" id="nova-fazenda" autocomplete="off">
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
            
                <h4>Dados Básicos</h4>
				
				<div class="form-group">
					<label class="control-label ">Nome: <span class="required">*</span>
					</label>
					<div class="">
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control required" name="data[Fazenda][nome]" placeholder="Digite o nome da propriedade" />
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label ">Inscrição Estadual: 
					</label>
					<div class="">
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control" name="data[Fazenda][ie]" placeholder="Digite a IE da propriedade" />
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label ">Localização: 
					</label>
					<div class="">
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control" name="data[Fazenda][localizacao]" placeholder="Digite a localização da propriedade" />
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label ">Observações: 
					</label>
					<div class="">
						<div class="input-icon right">
							<i class="fa"></i>
                            <textarea  class="form-control" name="data[Fazenda][obs]" placeholder="Digite as observações da fazenda"></textarea>
						</div>
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
$this->Html->css('/metronic/assets/pages/css/propriedades', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/sweetalert/sweetalert', array('block' => 'cssPage'));

/*-- BEGIN PAGE LEVEL PLUGINS --*/
$this->Html->script('/metronic/assets/global/plugins/jquery.form.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery.metadata', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/sweetalert/sweetalert.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Fazendas/adicionar', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>