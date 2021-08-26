<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="#">Relatório Contas</a>
	</li>
</ul>

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="" href="<?php echo $this->Html->url(array('controller' => 'RelatorioPagamentos', 'action' => 'saldo_entrada', 'p'));?>" target="_blank">
		<div class="dashboard-stat2 bordered">
			<div class="display">
				<div class="number">
					<h3 class="font-green-sharp">
						<small class="font-green-sharp">R$</small>
						<span data-counter="counterup" data-value="<?php echo number_format($stats['ent_p'], 2, ',', '.'); ?>">0</span>
					</h3>
					<small>Mês Entradas</small>
				</div>
				<div class="icon">
					<i class="fa fa-money"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo ceil($stats['progress_ep']);?>%;" class="progress-bar progress-bar-success green-sharp">
						<span class="sr-only"><?php echo ceil($stats['progress_ep']);?>% </span>
					</span>
				</div>
				<div class="status">
					<div class="status-title"> </div>
					<div class="status-number"> <?php echo ceil($stats['progress_ep']);?>% </div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="" href="<?php echo $this->Html->url(array('controller' => 'RelatorioPagamentos', 'action' => 'saldo_saida', 'p'));?>" target="_blank">
		<div class="dashboard-stat2 bordered">
			<div class="display">
				<div class="number">
					<h3 class="font-red-haze">
						<small class="font-red-haze">R$</small>
						<span data-counter="counterup" data-value="<?php echo number_format($stats['sai_p'], 2, ',', '.'); ?>">0</span>
					</h3>
					<small>Mês Saídas</small>
				</div>
				<div class="icon">
					<i class="fa fa-money"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo ceil($stats['progress_sp']);?>%;" class="progress-bar progress-bar-success red-haze">
						<span class="sr-only"><?php echo ceil($stats['progress_sp']);?>% </span>
					</span>
				</div>
				<div class="status">
					<div class="status-title"> </div>
					<div class="status-number"> <?php echo ceil($stats['progress_sp']);?>% </div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="" href="<?php echo $this->Html->url(array('controller' => 'RelatorioPagamentos', 'action' => 'saldo_entrada'));?>" target="_blank">
		<div class="dashboard-stat2 bordered">
			<div class="display">
				<div class="number">
					<h3 class="font-green-sharp">
						<small class="font-green-sharp">R$</small>
						<span data-counter="counterup" data-value="<?php echo number_format($stats['ent_a'], 2, ',', '.'); ?>">0</span>
					</h3>
					<small>Saldo Mês Entradas</small>
				</div>
				<div class="icon">
					<i class="fa fa-money"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo floor($stats['progress_ea']);?>%;" class="progress-bar progress-bar-success green-sharp">
						<span class="sr-only"><?php echo floor($stats['progress_ea']);?>% </span>
					</span>
				</div>
				<div class="status">
					<div class="status-title"> </div>
					<div class="status-number"> <?php echo floor($stats['progress_ea']);?>% </div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="" href="<?php echo $this->Html->url(array('controller' => 'RelatorioPagamentos', 'action' => 'saldo_saida'));?>" target="_blank">
		<div class="dashboard-stat2 bordered">
			<div class="display">
				<div class="number">
					<h3 class="font-red-haze">
						<small class="font-red-haze">R$</small>
						<span data-counter="counterup" data-value="<?php echo number_format($stats['sai_a'], 2, ',', '.'); ?>">0</span>
					</h3>
					<small>Saldo Mês Saídas</small>
				</div>
				<div class="icon">
					<i class="fa fa-money"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo floor($stats['progress_sa']);?>%;" class="progress-bar progress-bar-success red-haze">
						<span class="sr-only"><?php echo floor($stats['progress_sa']);?>% </span>
					</span>
				</div>
				<div class="status">
					<div class="status-title"> </div>
					<div class="status-number"> <?php echo floor($stats['progress_sa']);?>% </div>
				</div>
			</div>
		</div>
		</a>
	</div>
</div>

<!-- END PAGE BREADCRUMB -->
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-blue fa fa-bar-chart"></i>
					<span class="caption-subject font-blue bold uppercase">Entradas / Saídas</span>
				</div>
				<div class="actions">
					<!-- <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
						<i class="icon-cloud-upload"></i>
					</a>
					<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
						<i class="icon-wrench"></i>
					</a>
					<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
						<i class="icon-trash"></i>
					</a> -->
				</div>
			</div>
			<div class="portlet-body">
				<div id="morris_chart_3" style="height:380px;"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-blue fa fa-file-pdf-o"></i>
					<span class="caption-subject font-blue bold uppercase">Gerar Relatório</span>
					<span class="caption-helper"></span>
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<form class="" action="#" method="post" enctype="multipart/form-data" id="gerar" autocomplete="off">
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
									<label class="control-label">Período: <span class="required">*</span></label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[de]" placeholder="DE">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[ate]" placeholder="ATÉ">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">							
								<div class="form-group">
									<label class="control-label">Tipo: <span class="required">*</span></label>
									<div class="input-icon right">
										<i class="fa"></i>
										<input type="radio" class="form-control" name="data[tipo]" id="tipo1" value="E" checked=""><label for="tipo1">Entrada</label>
										<input type="radio" class="form-control" name="data[tipo]" id="tipo2" value="S"><label for="tipo2">Saída</label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">							
								<div class="form-group">
									<label class="control-label">Status: </label>
									<div class="input-icon right">
										<i class="fa"></i>
										<input type="radio" class="form-control" name="data[status]" id="tipo3" value="1"><label for="tipo3">Aguardando</label>
										<input type="radio" class="form-control" name="data[status]" id="tipo4" value="3"><label for="tipo4">Pago</label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Categoria Pagamento: </label>
									<div class="input-icon right">
										<i class="fa"></i>
										<select class="form-control" name="data[categoria]">
											<option value="">Selecione ...</option>
										<?php foreach ($categorias as $key => $categoria) { ?>
											<option value="<?=$key?>"><?=$categoria?></option>
										<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="form-actions" style="padding: 13px 10px !important;">
						<div class="row">
							<div class="col-md-offset-1 ">
								<button class="btn green" type="submit">Gerar</button>
								<button class="btn default" type="reset">Limpar Campos</button>
							</div>
						</div>
					</div>
				</form>
				<!-- END FORM-->
			</div>
		</div>
	</div>
</div>

<script>
	var dados = <?php echo $dados; ?>;
</script>

<?php
// $this->Html->css('/metronic/assets/global/plugins/morris/morris', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
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
// $this->Html->script('/metronic/assets/global/plugins/morris/morris.min', array('block' => 'scriptBottom'));
// $this->Html->script('/metronic/assets/global/plugins/morris/raphael-min', array('block' => 'scriptBottom'));
// $this->Html->script('/metronic/assets/pages/scripts/charts-morris.min', array('block' => 'scriptBottom'));

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/general/js/RelatorioPagamentos/index', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>