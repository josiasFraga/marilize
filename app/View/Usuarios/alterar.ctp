<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Usuarios', 'action' => 'index')) ?>">Usuários</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Alterar Usuário
	</li>
</ul>

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-user font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"> Alterar Usuário </span>
                </div>
                <div class="actions"></div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="" action="#" method="post" enctype="multipart/form-data" id="meus-dados" autocomplete="off">
                    <div class="form-body" id="alterarBody">
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
                            <input type="hidden" name="data[Usuario][id]" value="<?=$dados['Usuario']['id']?>" />
                            <input type="hidden" name="data[permissao]" value="<?=$dados['Usuario']['id']?>" />

                            <div class="row">
							    <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Nome: <span class="required">*</span></label>
                                                <div class="input-icon left">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control" name="data[Usuario][nome]" maxlength="150" value="<?=$dados['Usuario']['nome']?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- ./row -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Email: <span class="required">*</span></label>
                                                <div class="input-icon left">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control" name="data[Usuario][email]" maxlength="250" value="<?=$dados['Usuario']['email']?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- ./row -->
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Status: <span class="required">*</span></label>
                                                <div class="radio-list">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="data[Usuario][ativo]" value="Y" <?=($dados['Usuario']['ativo'] == 'Y')? 'checked': '';?>> Ativo </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="data[Usuario][ativo]" value="N" <?=($dados['Usuario']['ativo'] == 'N')? 'checked': '';?>> Inativo </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="icheck-list">
                                                        <label class="control-label">&nbsp;</label>
                                                        <label>
                                                            <input type="checkbox" class="" name="alterar_senha" id="alterar_senha">Alterar Senha</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- ./row -->

                                    <div class="row" id="campo_senha">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Nova Senha: <span class="required">*</span></label>
                                                <div class="input-icon left">
                                                    <i class="fa"></i>
                                                    <input type="password" class="form-control" name="data[Usuario][senha]" maxlength="250" minlength="6" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Repita a Senha: <span class="required">*</span></label>
                                                <div class="input-icon left">
                                                    <i class="fa"></i>
                                                    <input type="password" class="form-control" name="data[Usuario][rsenha]" maxlength="250" minlength="6" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <span class="message">Após a senha ser alterada, você será deslogado do sistema, para assim, logar novamente no sistema com a nova senha.</span>
                                            </div>
                                        </div> -->
                                    </div><!-- ./row -->

                            </div><!-- ./col -->
							<div class="col-md-6">

								<div class="form-group">
									<label class="control-label bold">Permissões: </label>
									<div class="input-group">
										<div class="icheck-list">
											<div class="row">
											<?php foreach( $permissoes as $id => $permissao ){ ?>
												<div class="col-md-12">
													<label>
														<input type="checkbox" name="data[UsuarioSistemaPermissao][][sistema_permissao_id]" value="<?=$id?>" class="icheck" <?=(in_array($id, $userpermissoes))? 'checked': '';?>> <?=$permissao?> </label>
												</div>
											<?php } ?>
											</div><!-- ./row -->
										</div>
									</div>
								</div>

							</div><!-- ./col -->
						</div><!-- ./row -->

							<div class="row">
								<div class="col-md-12"><br></div>
							</div><!-- ./row -->

                        </div><!-- end form-body -->

                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn default" type="reset">Cancelar</button>
                                <button class="btn green" type="submit">Alterar</button>
                            </div>
                        </div>
                    </div>

                </form>
                <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
<!-- END PAGE BASE CONTENT -->

<?php
$this->Html->css('/metronic/assets/global/plugins/icheck/skins/all', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/layouts/layout4/css/custom', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage'));

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

$this->Html->script('/metronic/assets/global/plugins/icheck/icheck.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/pages/scripts/form-icheck.min', array('block' => 'scriptBottom'));

//$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Usuarios/alterar', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>