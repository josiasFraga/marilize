<!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Pessoas <small>administrar Pessoas</small></h1>
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
    		<a href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'index')) ?>">Pessoas</a><i class="fa fa-circle"></i>
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
                    <i class="icon-user font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"> Adicionar Pessoa </span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab" id="btn-dadg"> Dados Gerais </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab" id="btn-loc"> Localidades 
                        <!-- <span class="badge badge-success">4</span> --></a>
                    </li>
                    <li>
                        <a href="#tab_3" data-toggle="tab" id="btn-bank"> Bancos </a>
                    </li>
                </ul>
                <div class="actions">
			        <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-default display-hide" id="outro_cadastro"><i class="fa fa-plus"></i> Incluir Outra Pessoa </a>
		        </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="" action="#" method="post" enctype="multipart/form-data" id="adicionar-pessoa" autocomplete="off">
                    <div class="tab-content">
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
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet-body form">
                                        <div class="form-body">                                            

                                            <div class="row">
                                                <div class="col-md-2">
                                                  <div class="form-group">
                                                        <label class="control-label">Tipo Pessoa: <span class="required">*</span></label>
                                                        <select class="form-control select2" name="data[Pessoa][tipo_pessoa_id]">
                                                            <option value="">Selecione ...</option>
                                                            <?php foreach ($listaPessoaTipo as $key => $value) { ?>
                                                            <option value="<?=$key?>"><?=$value?></option>
                                                            <?php } // end foreach?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="control-label">Razão Social: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][razao_social]" maxlength="250" placeholder=""/>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="control-label">Nome Fantasia: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][nome_fantasia]" maxlength="250" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">CNPJ: <span class="required">*</span></label>
                                                        <input type="text" class="form-control cnpj" name="data[Pessoa][cnpj]" maxlength="18" placeholder="" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">CPF: <span class="required">*</span></label>
                                                        <input type="text" class="form-control cpf" name="data[Pessoa][cpf]" maxlength="14" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-md-12"><hr></div></div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">CEP: <span class="required">*</span></label>
                                                        <input type="text" class="form-control cep" name="data[Pessoa][cep]" id="cep" maxlength="9" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Cidade: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][cidade]" id="cidade" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Estado (UF): <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][estado]" id="uf" maxlength="2" minlength="2" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Endereço: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][endereco]" maxlength="250" id="logradouro" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Número: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][numero]" maxlength="20" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Complemento: </label>
                                                        <input type="text" class="form-control" name="data[Pessoa][complemento]" maxlength="250" id="complemento" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Bairro: </label>
                                                        <input type="text" class="form-control" name="data[Pessoa][bairro]" id="bairro" maxlength="250" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-md-12"><hr></div></div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Telefone [1]: <span class="required">*</span></label>
                                                        <input type="text" class="form-control phone" name="data[Pessoa][telefone1]" maxlength="15" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Telefone [2]:</label>
                                                        <input type="text" class="form-control phone" name="data[Pessoa][telefone2]" maxlength="15" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Telefone [3]:</label>
                                                        <input type="text" class="form-control phone" name="data[Pessoa][telefone3]" maxlength="15" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Telefone [4]:</label>
                                                        <input type="text" class="form-control phone" name="data[Pessoa][telefone4]" maxlength="15" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[Pessoa][email]" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Observações: </label>
                                                        <textarea class="form-control" name="data[Pessoa][observacoes]" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="text-center">
                                                        <button class="btn green" type="button" id="btn-prox-loc">Próximo</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet-body form">
                                        <div class="form-body" id="form-loc">                                           

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Descrição: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaLocalidade_descricao]" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Inscrição Estadual: <span class="required">*</span></label>
                                                        <input type="text" class="form-control numero" name="data[aux][PessoaLocalidade_inscricao_estadual]" maxlength="50" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Estado (UF): <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaLocalidade_estado]" maxlength="2" minlength="2" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Cidade: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaLocalidade_cidade]" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="control-label">Localidade: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaLocalidade_localidade]" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 45px;"></label>
                                                        <button type="button" class="btn btn-success" title="Adicionar Localidade" id="btn-add-loc"><i class="fa fa-plus"></i> Adicionar Localidade</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-md-12"><hr></div></div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-striped table-bordered table-hover" id="table-localidades">
                                                        <thead>
                                                            <tr>
                                                                <th> Descrição </th>
                                                                <th> Inscrição Estadual </th>
                                                                <th> Estado (UF) </th>
                                                                <th> Cidade </th>
                                                                <th> Localidade </th>
                                                                <th> Ações </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="text-center">
                                                        <button class="btn default" type="button" id="btn-ant-dadg">Anterior</button>
                                                        <button class="btn green" type="button" id="btn-prox-bank">Próximo</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet-body form">
                                        <div class="form-body" id="form-banco">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Nome Banco: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaBanco_banco]" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="control-label">Titular: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaBanco_titular]" maxlength="250" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">CPF: </label>
                                                        <input type="text" class="form-control cpf" name="data[aux][PessoaBanco_cpf]" maxlength="14" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Conta: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaBanco_conta]" maxlength="50" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Agência: <span class="required">*</span></label>
                                                        <input type="text" class="form-control" name="data[aux][PessoaBanco_agencia]" maxlength="50" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">CNPJ: </label>
                                                        <input type="text" class="form-control cnpj" name="data[aux][PessoaBanco_cnpj]" maxlength="18" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 45px;"></label>
                                                        <button type="button" class="btn btn-success" title="Adicionar Banco" id="btn-add-banco"><i class="fa fa-plus"></i> Adicionar Banco</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row"><div class="col-md-12"><hr></div></div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-striped table-bordered table-hover" id="table-bancos">
                                                        <thead>
                                                            <tr>
                                                                <th> Nome Banco </th>
                                                                <th> Titular </th>
                                                                <th> Conta </th>
                                                                <th> Agência </th>
                                                                <th> CPF/CNPJ </th>
                                                                <th> Ações </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="text-center">
                                                        <button class="btn default" type="button" id="btn-ant-loc">Anterior</button>
                                                        <button class="btn green" type="submit">Salvar</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-8 ">
                                <button class="btn green" type="submit">Salvar</button>
                                <button class="btn default" type="reset">Limpar Campos</button>
                            </div>
                        </div>
                    </div> -->
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
//$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/Pessoas/adicionar.js?v=1.0', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>