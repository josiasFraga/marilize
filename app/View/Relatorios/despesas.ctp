<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'ContasPagar', 'action' => 'index')) ?>">Despesas</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Relatório de Despesas
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-plus font-dark"></i>
			<span class="caption-subject font-dark bold uppercase">Relaório de Despesas</span>
			<span class="caption-helper"></span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
        <form class="" action="#" method="post" enctype="multipart/form-data" id="relatorio-despesas" autocomplete="off">

						
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
							<label class="control-label">Safra: <span class="required">*</span></label>
							<div class="">
								<!--<i class="fa"></i>-->
								<select class="form-control select2 required" name="data[Relatorio][safra_id]">
									<option value="">Selecione ...</option>
								<?php foreach ($safras as $key => $safra) { ?>
                                    <option value="<?=$key?>" <?php echo $key == $safra_atual['Safra']['id'] ? 'selected=""' : ''; ?>><?=$safra?></option>
                                <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
				
                        <div class="form-group">
                            <label class="control-label ">Período: <span class="required">*</span></label>
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" class="form-control required rangepicker" name="data[Relatorio][inicio_fim]" placeholder="Selecione o período da safra" />
                            </div>
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Fazenda: <span class="required">*</span></label>
							<div class="">
								<!--<i class="fa"></i>-->
								<select class="form-control select2 required" name="data[Relatorio][fazenda_id]">
									<option value="">Selecione ...</option>
								<?php foreach ($fazendas as $key => $fazenda) { ?>
                                    <option value="<?=$key?>" <?php echo $key == 17 ? 'selected=""' : ''; ?>><?=$fazenda?></option>
                                <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Fornecedor: </label>
							<div class="">
								<!--<i class="fa"></i>-->
								<select class="form-control select2" name="data[Relatorio][fornecedor_id]">
									<option value="">Selecione ...</option>
                                    <?php foreach ($fornecedores as $key => $fornecedor) { ?>
                                        <option value="<?=$key?>"><?=$fornecedor?></option>
                                    <?php } ?>
								</select>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Categoria: <span class="required">*</span></label>
							<div class="">
								<!--<i class="fa"></i>-->
								<select class="form-control select2 required" name="data[Relatorio][categoria_id]">
									<option value="">Selecione ...</option>
                                    <?php foreach ($categorias as $key => $categoria) { ?>
                                        <option value="<?=$key?>"><?=$categoria?></option>
                                    <?php } ?>
								</select>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Grupo: </label>
							<div class="">
								<!--<i class="fa"></i>-->
								<select class="form-control select2" name="data[Relatorio][grupo_id]" id="grupo_id">
									<option value="">Selecione ...</option>
									<?php foreach ($grupos as $key => $grupo) { ?>
										<option value="<?=$key?>"><?=$grupo?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Status Pagamento: </label>
							<div class="">
								<!--<i class="fa"></i>-->
								<select class="form-control" name="data[Relatorio][status_id]" id="status_pagto">
									<option value="">Selecione ...</option>
									<option value="1">Aguardando Pagamento</option>
									<!-- <option value="7">Cancelada</option> -->
									<option value="3">Pago</option>
								</select>
							</div>
						</div>
					</div>
                    

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Forma de pagamento: </label>
                            <div class="">
                                <!--<i class="fa"></i>-->
                                <select class="form-control" name="data[Relatorio][forma_id]">
                                    <option value="">Selecione ...</option>
                                <?php foreach ($listformas as $key => $forma) { ?>
                                    <option value="<?=$key?>"><?=$forma?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div><!-- ./col -->
				</div>
			<div class="form-actions">
				<div class="row">
					<div class="text-right ">
						<button type="submit" class="btn green">Gerar</button>
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
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/dependent-dropdown-master/css/dependent-dropdown.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/icheck/skins/all', array('block' => 'cssPage'));
//$this->Html->css('/metronic/assets/global/plugins/dependent-dropdown-master/css/dependent-dropdown.min', array('block' => 'cssPage'));

$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', array('block' => 'cssPage'));

/*-- BEGIN PAGE LEVEL PLUGINS --*/
$this->Html->script('https://code.highcharts.com/highcharts.js', array('block' => 'scriptBottom'));
$this->Html->script('https://www.ajaxproxy.com/js/ajaxproxy.js', array('block' => 'scriptBottom'));
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
$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/select2/js/select2.full.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/select2/js/i18n/pt-BR', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/icheck/icheck.min', array('block' => 'scriptBottom'));
//$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Relatorios/despesas.js?v=1.4', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>