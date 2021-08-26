<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Dashboard</a><i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Usuarios', 'action' => 'index')) ?>">Usuários</a><i class="fa fa-circle"></i>
	</li>
	<li class="active">
		Novo Usuário
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-user font-dark"></i>
					<span class="caption-subject font-dark bold uppercase">Novo Usuário</span>
					<span class="caption-helper"></span>
				</div>
				<div class="actions">
					<a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Usuarios', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-default display-hide" id="outro_cadastro"><i class="fa fa-plus"></i> Incluir Outro Usuário</a>
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<form class="" action="#" method="post" enctype="multipart/form-data" id="novo-usuario" autocomplete="off">
					<input type="hidden" name="data[Usuario][role]" value="usuario">
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
							<div class="col-md-6">
		
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Nome: <span class="required">*</span></label>
											<div class="input-icon left">
												<i class="fa"></i>
												<input type="text" class="form-control" name="data[Usuario][nome]" maxlength="150" />
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
												<input type="email" class="form-control" name="data[Usuario][email]" maxlength="250" />
											</div>
										</div>
									</div>
								</div><!-- ./row -->

								<div class="row">							
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Status: <span class="required">*</span></label>
											<div class="radio-list">
												<label class="radio-inline">
													<input type="radio" name="data[Usuario][ativo]" value="Y" checked> Ativo </label>
												<label class="radio-inline">
													<input type="radio" name="data[Usuario][ativo]" value="N"> Inativo </label>
											</div>
										</div>
									</div>
								</div><!-- ./row -->
				
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Senha: <span class="required">*</span></label>
											<div class="input-icon right">
												<i class="fa"></i>
												<input type="password" class="form-control password-field" name="data[Usuario][senha]" maxlength="150" minlength="6"/>
												<i toggle=".password-field" class="fa fa-fw fa-eye field-icon toggle-password" title="Visualizar Senha"></i>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Repetir Senha: <span class="required">*</span></label>
											<div class="input-icon right">
												<i class="fa"></i>
												<input type="password" class="form-control password-field" name="data[Usuario][rsenha]" maxlength="150" minlength="6"/>
											</div>
										</div>
									</div>
								</div><!-- ./row -->

							</div><!-- ./col -->
							<div class="col-md-6">

								<div class="form-group">
									<label class="control-label bold">Permissões: </label>
									<div class="input-group">
										<div class="icheck-list">
											<div class="row">
												<!-- <div class="col-md-6">
													<label class="checkl" data-check="check0">
														<input type="checkbox" name="data[UsuarioSistemaPermissao][][sistema_permissao_id]" value="0" class="icheck"> TODAS PERMISSÕES </label>
												</div> -->
											<?php foreach( $permissoes as $id => $permissao ){ ?>
												<div class="col-md-12">
													<label class="checkl" data-check="check<?=$id?>">
														<input type="checkbox" name="data[UsuarioSistemaPermissao][][sistema_permissao_id]" value="<?=$id?>" class="icheck"> <?=$permissao?> </label>
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
		
					</div><!-- ./form-body -->
		
					<div class="form-actions">
						<div class="row">
							<div class="text-right">
								<button class="btn default" type="reset">Cancelar</button>
								<button class="btn green" type="submit">Adicionar</button>
							</div>
						</div>
					</div>
		
				</form>
				<!-- END FORM-->
			</div>
		</div>
	</div>
</div>

<?php
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/layouts/layout4/css/custom', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/icheck/skins/all', array('block' => 'cssPage'));

/*-- BEGIN PAGE LEVEL PLUGINS --*/
$this->Html->script('/metronic/assets/global/plugins/jquery.form.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery.metadata', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/select2/js/select2.full.min.js?v=1', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/icheck/icheck.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/pages/scripts/components-select2.min', array('block' => 'scriptBottom'));
//$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Usuarios/adicionar.js?v=1.0.1', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>