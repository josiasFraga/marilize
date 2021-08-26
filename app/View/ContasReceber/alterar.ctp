<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'ContasReceber', 'action' => 'index')) ?>">Contas à Receber</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Alterar
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-plus font-dark"></i>
			<span class="caption-subject font-dark bold uppercase">Dados Conta à Receber</span>
			<span class="caption-helper"></span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
        <form class="" action="#" method="post" enctype="multipart/form-data" id="alterar-contar" autocomplete="off">
            <input type="hidden" name="data[PagamentoData][id]" value="<?php echo $dados['PagamentoData']['id'] ?>">
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
                    <div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Valor R$: <span class="required">*</span></label>
							<div class="input-icon right">
								<!--<i class="fa"></i>-->
								<input type="text" class="form-control moeda" name="data[PagamentoData][valor]" maxlength="12" value="<?php echo number_format($dados['PagamentoData']['valor'], '2', ',', '.'); ?>" />
							</div>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Data de Vencimento: <span class="required">*</span></label>
							<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
								<input type="text" class="form-control form-filter input-sm" readonly name="data[PagamentoData][data_venc]" placeholder="Vencimento em" value="<?php echo date('d/m/Y', strtotime($dados['PagamentoData']['data_venc'])); ?>">
								<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Status Pagamento: <span class="required">*</span></label>
							<div class="input-icon right">
								<!--<i class="fa"></i>-->
								<select class="form-control" name="data[PagamentoData][status_id]" id="status_pagto">
									<option value="">Selecione ...</option>
									<option value="1" <?php echo ($dados['PagamentoData']['status_id'] == '1')? 'selected': ''; ?>>Aguardando Pagamento</option>
									<!-- <option value="7">Cancelada</option> -->
									<option value="3" <?php echo ($dados['PagamentoData']['status_id'] == '3')? 'selected': ''; ?>>Pago</option>
								</select>
							</div>
						</div>
					</div>
				</div>

                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Categoria Pagamento: <span class="required">*</span></label>
							<div class="input-icon right">
								<!--<i class="fa"></i>-->
								<select class="form-control" name="data[PagamentoData][categoria_id]">
									<!-- <option value="">Selecione ...</option> -->
								<?php foreach ($categorias as $key => $categoria) { ?>
									<?php if ($dados['PagamentoData']['categoria_id'] == $key) { ?>
                                    <option value="<?=$key?>" selected><?=$categoria?></option>
                                	<?php } ?>
                                <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6 <?php echo ($dados['PagamentoData']['status_id'] == '3')? '': 'hide'; ?>" id="data_pagto">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Data do Pagamento: <span class="required">*</span></label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[PagamentoData][data_pago]" placeholder="Pago em" value="<?php echo (!empty($dados['PagamentoData']['data_pago']) && !is_null($dados['PagamentoData']['data_pago']))? date('d/m/Y', strtotime($dados['PagamentoData']['data_pago'])) : ''; ?>">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
								</div>
							</div><!-- ./col -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Forma: <span class="required">*</span></label>
									<div class="input-icon right">
										<!--<i class="fa"></i>-->
										<select class="form-control" name="data[PagamentoData][forma_id]">
											<option value="">Selecione ...</option>
										<?php foreach ($listformas as $key => $forma) { ?>
											<?php if ($dados['PagamentoData']['forma_id'] == $key) { ?>
                                    		<option value="<?=$key?>" selected><?=$forma?></option>
                                			<?php } else { ?>
											<option value="<?=$key?>"><?=$forma?></option>
                                			<?php } ?>
										<?php } ?>
										</select>
									</div>
								</div>
							</div><!-- ./col -->
						</div>
					</div>                   
				</div>

                <div class="form-group">
                    <!-- <label class="control-label">Obs.: <span class="required">*</span></label> -->
                    <label class="control-label">Observações: </label>
					<div class="input-icon left">
						<!--<i class="fa"></i>-->
                        <textarea class="form-control" rows="3" name="data[PagamentoData][observacoes]" placeholder=""><?php echo $dados['PagamentoData']['observacoes']; ?></textarea>
					</div>
                </div>

			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-8 ">
						<button class="btn green" type="submit">Salvar Alterações</button>
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
$this->Html->script('/js/ContasReceber/alterar', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>