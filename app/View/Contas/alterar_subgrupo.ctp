<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'contas', 'action' => 'subgrupos')) ?>">Subgrupos</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Alterar Subgrupo
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-plus font-red-sunglo"></i>
			<span class="caption-subject font-red-sunglo bold uppercase">Alterar Subgrupo</span>
			<span class="caption-helper"></span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form class="" action="#" method="post" enctype="multipart/form-data" id="alterar-subgrupo" autocomplete="off">
        
            <input type="hidden" class="form-control numeric required" name="data[ContaSubgrupo][id]" value="<?= $dados['ContaSubgrupo']['id'] ?>" />
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
                    <label class="control-label">Grupo: <span class="required">*</span></label>
                    <div class="">
                        <!--<i class="fa"></i>-->
                        <select class="form-control select2 required" name="data[ContaSubgrupo][grupo_id]" id="grupo_id">
                            <option value="">Selecione ...</option>
                            <?php foreach ($grupos as $key => $grupo) { ?>
                                <option value="<?=$key?>" <?= $key == $dados['ContaSubgrupo']['grupo_id'] ? 'selected="selected"' : '' ?>><?=$grupo?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
				
				<div class="form-group">
					<label class="control-label ">Nome: <span class="required">*</span>
					</label>
					<div class="">
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control required" name="data[ContaSubgrupo][nome]" placeholder="Digite o nome da propriedade" value="<?= $dados['ContaSubgrupo']['nome'] ?>"/>
						</div>
					</div>
				</div>
				
			</div>
			<div class="form-actions">
				<div class="row">
					<div class="text-right">
						<button class="btn green" type="submit">Salvar Alterações</button>
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
$this->Html->script('/js/Contas/alterar_subgrupo', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>