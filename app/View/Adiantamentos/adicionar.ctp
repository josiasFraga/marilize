<!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Adiantamentos <small>adicionar adiantamento</small></h1>
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
    		<a href="<?php echo $this->Html->url(array('controller' => 'adiantamentos', 'action' => 'index')) ?>">Adiantamentos</a><i class="fa fa-circle"></i>
        </li>
        <li class="active">
            Adicionar
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-plus font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"> Adicionar Adiantamento </span>
                </div>
                <div class="actions">
			        <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-default display-hide" id="outro_cadastro"><i class="fa fa-plus"></i> Incluir Outra Pessoa </a>
		        </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
				<form class="" action="" method="post" enctype="multipart/form-data" id="adicionar-adiantamento" autocomplete="off">
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
							<div class="col-lg-6">
								<div class="form-group">
                                    <label class="control-label">Credor: <span class="required">*</span></label>
                                    <select class="form-control select2 selectnext required" name="data[Adiantamento][credor_id]">
                                        <option value="">Selecione ...</option>
                                        <?php foreach ($credores as $key => $value) { ?>
                                        <option value="<?=$key?>"><?=$value?></option>
                                        <?php } // end foreach?>
                                    </select>
								</div>
                            </div>
							<div class="col-lg-6">
								<div class="form-group">
                                    <label class="control-label">Tomador: <span class="required">*</span></label>
                                    <select class="form-control select2 selectnext required" name="data[Adiantamento][tomador_id]">
                                        <option value="">Selecione ...</option>
                                        <?php foreach ($tomadores as $key => $value) { ?>
                                        <option value="<?=$key?>"><?=$value?></option>
                                        <?php } // end foreach?>
                                    </select>
								</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
								<div class="form-group">
                                    <label class="control-label">Banco Credor: </label>
                                    <textarea class="form-control" rows="3" name="data[Adiantamento][banco_credor]"></textarea>
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group">
                                    <label class="control-label">Banco Tomador: </label>
                                    <textarea class="form-control" rows="3" name="data[Adiantamento][banco_tomador]"></textarea>
								</div>
							</div>
                        </div><!-- ./row -->
                        
						<div class="row">
                            
                            <!--<div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Banco: </label>
                                    <select class="form-control select2 selectnext required" name="data[Adiantamento][banco_id]">
                                        <option value="">Selecione ...</option>
                                        <?php foreach ($bancos as $key => $banco) { ?>
                                        <option value="<?=$banco['Banco']['id']?>"><?=$banco['Banco']['cod'].' - '.$banco['Banco']['nome']?></option>
                                        <?php } // end foreach?>
                                    </select>
                                </div>
                            </div>-->
                            
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Data de Emissão: <span class="required">*</span></label>
                                    <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                        <input type="text" class="form-control form-filter input-sm required" readonly name="data[Adiantamento][emissao]" placeholder="" id="data_emissao">
                                        <span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo: <span class="required">*</span></label>
									<div class="input-icon right">
										<i class="fa"></i>
										<input type="radio" class="form-control required" name="data[tipo]" id="tipo1" value="E" checked=""><label for="tipo1">Entrada</label>
										<input type="radio" class="form-control required" name="data[tipo]" id="tipo2" value="S"><label for="tipo2">Saída</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
								<div class="form-group">
									<label class="control-label">Nº Documento: </label>
									<div class="input-icon left">
										<!--<i class="fa"></i>-->
										<input type="text" class="form-control" name="data[Adiantamento][documento]" maxlength="100" />
									</div>
								</div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Valor: <span class="required">*</span></label>
                                    <div class="input-icon left">
                                        <!--<i class="fa"></i>-->
                                        <input type="text" class="form-control moeda required" name="data[Adiantamento][valor]" maxlength="100" />
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./row -->
                        
						<div class="row">
							<div class="col-md-12"><hr></div>
                        </div><!-- ./row -->
                        
                        <div class="row">
                            <div class="col-md-12">
								<div class="form-group">
                                    <label class="control-label">Observações: </label>
                                    <textarea class="form-control" rows="3" name="data[Adiantamento][obs]"></textarea>
								</div>
							</div>
                        </div><!-- ./row -->

                        <div class="row">
							<div class="col-md-12"><hr></div>
                        </div><!-- ./row -->
		
					</div><!-- ./form-body -->
		
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12 text-right">
								<button class="btn default" type="reset">Cancelar</button>
								<button class="btn green" type="submit">Salvar</button>
							</div>
						</div>
					</div>
		
				</form>
				<!-- END FORM-->
            </div>

        </div>
        <!-- End: life time stats -->
    </div>
</div>
<!-- END PAGE BASE CONTENT -->

<?php
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/layouts/layout4/css/custom', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage'));

/*-- BEGIN PAGE LEVEL PLUGINS --*/
$this->Html->script('/metronic/assets/global/plugins/jquery.form.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery.metadata', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/select2/js/select2.full.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min', array('block' => 'scriptBottom'));
//$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Adiantamentos/adicionar.js?v=1.0', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>