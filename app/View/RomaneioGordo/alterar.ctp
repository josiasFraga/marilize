<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Romaneio Gordo <small>administrar Romaneios</small></h1>
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
        <a href="<?php echo $this->Html->url(array('controller' => 'RomaneioGordo', 'action' => 'index')) ?>">Romaneio Gordo</a><i class="fa fa-circle"></i>
    </li>
    <li class="active">
        Alterar
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                <i class="font-dark fa fa-file"></i>
                    <span class="caption-subject font-dark bold uppercase">Alterar Romaneio Gordo</span>
                </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form class="" action="" method="post" enctype="multipart/form-data" id="alterar-romaneio" autocomplete="off">
                    <input type="hidden" name="data[RomaneioGordo][id]" value="<?=$dados['RomaneioGordo']['id']?>">
                    <input type="hidden" name="data[RomaneioGordo][tipo]" value="0">
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
								<div class="form-group">
                                    <label class="control-label">Frigorífico: <span class="required">*</span></label>
                                    <select class="form-control select2 selectnext" name="data[RomaneioGordo][comprador_id]">
                                        <option value="">Selecione ...</option>
                                        <?php foreach ($listaFrigorificos as $key => $value) { ?>
                                        <?php if ($dados['RomaneioGordo']['comprador_id'] != $key) { ?>
                                            <option value="<?=$key?>"><?=$value?></option>
                                        <?php } else { ?>
                                            <option value="<?=$key?>" selected><?=$value?></option>
                                        <?php } // end if?>
                                        <?php } // end foreach?>
                                    </select>
								</div>
                            </div>

                            <div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Data de Emissão: <span class="required">*</span></label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioGordo][data_emissao]" placeholder="" id="data_emissao" value="<?php echo (!is_null($dados['RomaneioGordo']['data_emissao']))?date('d/m/Y', strtotime($dados['RomaneioGordo']['data_emissao'])): ''?>">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
								</div>
                            </div>

                            <div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Nº Romaneio: <span class="required">*</span></label>
									<div class="input-icon left">
                                        <!--<i class="fa"></i>-->
										<input type="text" class="form-control" name="data[RomaneioGordo][numero]" maxlength="250" value="<?=$dados['RomaneioGordo']['numero']?>" />
									</div>
								</div>
							</div>
                        </div><!-- ./row -->
                        
                        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
                                    <label class="control-label">Produtor: <span class="required">*</span></label>
                                    <select class="form-control select2 selectnext" name="data[RomaneioGordo][vendedor_id]" id="produtor_pessoa_id">
                                        <option value="">Selecione ...</option>
                                        <?php foreach ($listaProdutores as $key => $value) { ?>
                                        <?php if ($dados['RomaneioGordo']['vendedor_id'] != $key) { ?>
                                            <option value="<?=$key?>"><?=$value?></option>
                                        <?php } else { ?>
                                            <option value="<?=$key?>" selected><?=$value?></option>
                                        <?php } // end if?>
                                        <?php } // end foreach?>
                                    </select>
								</div>
                            </div>

                            <div class="col-md-6">
								<div class="form-group">
                                    <label class="control-label">Obra/Localidade: <span class="required">*</span></label>
                                    <select class="form-control select2 selectnext" name="data[RomaneioGordo][vendedor_localidade_id]" id="produtor_localidade_id">
                                        <option value="">Selecione ...</option>
                                        <?php if (isset($dados['PessoaLocalidade']['id'])) { ?>
                                        <option value="<?=$dados['PessoaLocalidade']['id']?>" selected><?=$dados['PessoaLocalidade']['localidade']?></option>
                                        <?php } ?>
                                    </select>
								</div>
							</div>
                        </div><!-- ./row -->
                        
                        <div class="row">
							<div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Dados Bovinos </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab"> Médias, Rendimento e Financeiro </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab"> Arquivo Romaneio (PDF) </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab_1_1">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!-- <input type="hidden" name="data[aux][focus]" value=""> -->
                                                    <label class="control-label">Espécie: <span class="required">*</span></label>
                                                    <select class="form-control select2 selectnext" name="data[RomaneioGordo][especie_id]">
                                                        <option value="">Selecione ...</option>
                                                        <?php foreach ($listaEspecies as $key => $value) { ?>
                                                        <?php if ($dados['RomaneioGordo']['especie_id'] != $key) { ?>
                                                            <option value="<?=$key?>"><?=$value?></option>
                                                        <?php } else { ?>
                                                            <option value="<?=$key?>" selected><?=$value?></option>
                                                        <?php } // end if?>
                                                        <?php } // end foreach?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Peso Fazenda: <span class="required">*</span></label>
                                                    <div class="input-icon left">
                                                        <!--<i class="fa"></i>-->
                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][peso_fazenda_total]" maxlength="14" minlength="3" value="<?=number_format($dados['RomaneioGordo']['peso_fazenda_total'], '2', ',', '.')?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Peso Frigorífico: <span class="required">*</span></label>
                                                    <div class="input-icon left">
                                                        <!--<i class="fa"></i>-->
                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][peso_frigorifico]" maxlength="14" minlength="3" value="<?=number_format($dados['RomaneioGordo']['peso_frigorifico'], '2', ',', '.')?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Data Abate: <span class="required">*</span></label>
                                                    <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                                        <input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioGordo][data_abate]" placeholder="" value="<?php echo (!is_null($dados['RomaneioGordo']['data_abate']))?date('d/m/Y', strtotime($dados['RomaneioGordo']['data_abate'])): ''?>">
                                                        <span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- ./row -->

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="table-scrollable">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="100px"> # </th>
                                                                <th> Cabeças </th>
                                                                <th> KG Carcaças </th>
                                                                <th> Valor Unitário </th>
                                                                <th> Valor Total </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> Tipo A </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control numero tipo_cabecas" name="data[RomaneioGordo][tipoa_cabecas]" maxlength="14" minlength="1" value="<?=(!is_null($dados['RomaneioGordo']['tipoa_cabecas']))?$dados['RomaneioGordo']['tipoa_cabecas']:''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal tipo_kg_carcaca" name="data[RomaneioGordo][tipoa_kg_carcaca]" maxlength="14" minlength="3" value="<?=(!is_null($dados['RomaneioGordo']['tipoa_kg_carcaca']))?number_format($dados['RomaneioGordo']['tipoa_kg_carcaca'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal tipo_valor_total" name="data[RomaneioGordo][tipoa_valor_unitario]" maxlength="14" minlength="3" value="<?=(!is_null($dados['RomaneioGordo']['tipoa_valor_unitario']))?number_format($dados['RomaneioGordo']['tipoa_valor_unitario'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control moeda" name="data[RomaneioGordo][tipoa_valor_total]" maxlength="14" minlength="3" readonly value="<?=(!is_null($dados['RomaneioGordo']['tipoa_valor_total']))?number_format($dados['RomaneioGordo']['tipoa_valor_total'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Tipo B </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control numero tipo_cabecas" name="data[RomaneioGordo][tipob_cabecas]" maxlength="14" minlength="1" value="<?=(!is_null($dados['RomaneioGordo']['tipob_cabecas']))?$dados['RomaneioGordo']['tipob_cabecas']:''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal tipo_kg_carcaca" name="data[RomaneioGordo][tipob_kg_carcaca]" maxlength="14" minlength="3" value="<?=(!is_null($dados['RomaneioGordo']['tipob_kg_carcaca']))?number_format($dados['RomaneioGordo']['tipob_kg_carcaca'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal tipo_valor_total" name="data[RomaneioGordo][tipob_valor_unitario]" maxlength="14" minlength="3" value="<?=(!is_null($dados['RomaneioGordo']['tipob_valor_unitario']))?number_format($dados['RomaneioGordo']['tipob_valor_unitario'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control moeda" name="data[RomaneioGordo][tipob_valor_total]" maxlength="14" minlength="3" readonly value="<?=(!is_null($dados['RomaneioGordo']['tipob_valor_total']))?number_format($dados['RomaneioGordo']['tipob_valor_total'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Tipo C </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control numero tipo_cabecas" name="data[RomaneioGordo][tipoc_cabecas]" maxlength="14" minlength="1" value="<?=(!is_null($dados['RomaneioGordo']['tipoc_cabecas']))?$dados['RomaneioGordo']['tipoc_cabecas']:''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal tipo_kg_carcaca" name="data[RomaneioGordo][tipoc_kg_carcaca]" maxlength="14" minlength="3" value="<?=(!is_null($dados['RomaneioGordo']['tipoc_kg_carcaca']))?number_format($dados['RomaneioGordo']['tipoc_kg_carcaca'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal tipo_valor_total" name="data[RomaneioGordo][tipoc_valor_unitario]" maxlength="14" minlength="3" value="<?=(!is_null($dados['RomaneioGordo']['tipoc_valor_unitario']))?number_format($dados['RomaneioGordo']['tipoc_valor_unitario'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control moeda" name="data[RomaneioGordo][tipoc_valor_total]" maxlength="14" minlength="3" readonly value="<?=(!is_null($dados['RomaneioGordo']['tipoc_valor_total']))?number_format($dados['RomaneioGordo']['tipoc_valor_total'], '2', ',', '.'):''?>"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Totais </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control numero" name="data[RomaneioGordo][totais_cabecas]" maxlength="14" minlength="1" readonly value="<?=$dados['RomaneioGordo']['totais_cabecas']?>"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control moeda" name="data[RomaneioGordo][totais_kg_carcaca]" maxlength="14" minlength="3" readonly value="<?=number_format($dados['RomaneioGordo']['totais_kg_carcaca'], '2', ',', '.')?>"/>
                                                                    </div>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control moeda" name="data[RomaneioGordo][totais_valor_total]" maxlength="14" minlength="3" readonly value="<?=number_format($dados['RomaneioGordo']['totais_valor_total'], '2', ',', '.')?>"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Desconto FUNRURAL: </label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_funral_porcentual]" maxlength="14" minlength="3" placeholder="%" id="desconto-funrural-per" value="<?=number_format($dados['RomaneioGordo']['desconto_funral_porcentual'], '2', ',', '.')?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_funral_valor]" maxlength="14" minlength="3" placeholder="R$" id="desconto-funrural-val" value="<?=number_format($dados['RomaneioGordo']['desconto_funral_valor'], '2', ',', '.')?>"/>
                                                                    </div>
                                                                </div>
                                                            </div><!-- ./row -->
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Desconto FUNDESA: </label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_fundesa_porcentual]" maxlength="14" minlength="3" placeholder="%" id="desconto-fundesa-per" value="<?=number_format($dados['RomaneioGordo']['desconto_fundesa_porcentual'], '2', ',', '.')?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-icon left">
                                                                        <!--<i class="fa"></i>-->
                                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_fundesa_valor]" maxlength="14" minlength="3" placeholder="R$" id="desconto-fundesa-val" value="<?=number_format($dados['RomaneioGordo']['desconto_fundesa_valor'], '2', ',', '.')?>"/>
                                                                    </div>
                                                                </div>
                                                            </div><!-- ./row -->
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Valor Total Líquido: <span class="required">*</span></label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][valor_liquido]" maxlength="14" minlength="3" id="valor-total-liquido" value="<?=number_format($dados['RomaneioGordo']['valor_liquido'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->
                                            </div>
                                        </div><!-- ./row -->
                                    </div>
                                    <div class="tab-pane fade" id="tab_1_2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <label class="bold">Médias</label>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Fazenda: </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][media_fazenda]" readonly id="media_fazenda" value="<?=number_format($dados['RomaneioGordo']['media_fazenda'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Frigorífico (Vivo): </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][media_frigorifico]" readonly id="media_frigorifico" value="<?=number_format($dados['RomaneioGordo']['media_frigorifico'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Carcaça: </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][media_carcaca]" readonly id="media_carcaca" value="<?=number_format($dados['RomaneioGordo']['media_carcaca'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Cabeça: </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][media_cabeca]" readonly id="media_cabeca" value="<?=number_format($dados['RomaneioGordo']['media_cabeca'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->
                                            </div>

                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <label class="bold">Rendimentos</label>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Frigorífico: </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][rendimento_frigorifico]" readonly id="rendimento_frigorifico" value="<?=number_format($dados['RomaneioGordo']['rendimento_frigorifico'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Fazenda: </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][rendimento_fazenda]" readonly id="rendimento_fazenda" value="<?=number_format($dados['RomaneioGordo']['rendimento_fazenda'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Quebra: </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control moeda" name="data[RomaneioGordo][rendimento_quebra]" readonly id="rendimento_quebra" value="<?=number_format($dados['RomaneioGordo']['rendimento_quebra'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->
                                            </div>

                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <label class="bold">Comissão</label>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-4 text-right">
                                                        <div style="margin-bottom: 28px"></div>
                                                        <p class="text-right bold"> Frigorífico: </p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Perc. Comissão: <span class="required">*</span></label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][comissao_comprador_porcentual]" maxlength="14" minlength="3" placeholder="%" id="comissao_comprador_porcentual" value="<?=number_format($dados['RomaneioGordo']['comissao_comprador_porcentual'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Valor Comissão: <span class="required">*</span></label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][comissao_comprador_valor]" maxlength="14" minlength="3" placeholder="R$" id="comissao_comprador_valor" value="<?=number_format($dados['RomaneioGordo']['comissao_comprador_valor'], '2', ',', '.')?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Prazo (em dias): </label>
                                                            <div class="input-icon left">
                                                                <!--<i class="fa"></i>-->
                                                                <input type="text" class="form-control numero" name="data[RomaneioGordo][prazo_pgto_dias]" maxlength="5" minlength="1" id="prazo_pgto_dias" value="<?=$dados['RomaneioGordo']['prazo_pgto_dias']?>"/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                       <div class="form-group">
                                                            <label class="control-label">Data Pagamento: <span class="required">*</span></label>
                                                            <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                                                <input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioGordo][comissao_comprador_data_pgto]" placeholder="" id="comissao_comprador_data_pgto" value="<?php echo (!is_null($dados['RomaneioGordo']['comissao_comprador_data_pgto']))?date('d/m/Y', strtotime($dados['RomaneioGordo']['comissao_comprador_data_pgto'])): ''?>">
                                                                <span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- ./row -->
                                            </div>

                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <label class="bold">Comissão vendedor/comprador</label>
                                                    </div>
                                                </div><!-- ./row -->

                                                <div class="row">
                                                    <div class="col-md-4">&nbsp;
                                                    </div>
                                                     <div class="col-md-8">

                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Vencimento em</th>
                                                                    <th>Valor</th>
                                                                    <th>Pago</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php for ($i = 0; $i <= 5; $i++): ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                                                            <input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioVencimento][<?php echo $i ?>][vencimento_em]" value="<?php echo isset($vencimentos[$i]) ? $vencimentos[$i]['RomaneioVencimento']['vencimento_em'] : '' ?>">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control duasdecimal" name="data[RomaneioVencimento][<?php echo $i ?>][valor]" value="<?php echo isset($vencimentos[$i]) ? $vencimentos[$i]['RomaneioVencimento']['valor'] : '0,00' ?>" maxlength="14" minlength="3" placeholder="R$"/>
                                                                    </td>
                                                                    <td>
                                                                        <input type="checkbox" class="form-control" name="data[RomaneioVencimento][<?php echo $i ?>][pago]" <?php echo isset($vencimentos[$i]) && $vencimentos[$i]['RomaneioVencimento']['pago'] ? 'checked="checked"' : '' ?>>
                                                                    </td>
                                                                </tr>
                                                            <?php endfor; ?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- ./row -->
                                    </div>
                                    <div class="tab-pane fade" id="tab_1_3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile1">Anexar</label>
                                                    <input type="file" name="data[RomaneioArquivo][][arquivo]" id="rgarquivos" multiple>
                                                    <p class="help-block">São aceitos apenas arquivos JPEG, JPG, PDF, PNG.</p>
                                                    <p class="help-block" id="rgarquivoshelp"></p>
                                                    <hr>
                                                    <p class="help-block">
                                                        <ul id="list-arquivos">
                                                        <?php foreach ($arquivos as $arquivo) { ?>
                                                            <li>
                                                                <a href="<?=$this->webroot.'files/romaneios_arquivos/'.$arquivo['RomaneioArquivo']['arquivo']?>" class="btn btn-link" title="Visualizar Arquivo" target="blank"><?=$arquivo['RomaneioArquivo']['arquivo']?></a>
                                                                <a href="#" class="btn btn-link btn-remove" data-id="<?=$arquivo['RomaneioArquivo']['id']?>" title="Excluir Arquivo">Excluir</a>
                                                            </li>
                                                        <?php } ?>
                                                        </ul>
                                                    </p>
                                                </div>
                                            </div>
                                        </div><!-- ./row -->
                                    </div>
                                </div>
                                <!-- <div class="clearfix margin-bottom-20"> </div> -->
                            </div>
						</div><!-- ./row -->

						<div class="row">
							<div class="col-md-12"><hr></div>
                        </div><!-- ./row -->
                        
                        <div class="row">
                            <div class="col-md-12">
								<div class="form-group">
                                    <label class="control-label">Observações: </label>
                                    <textarea class="form-control" rows="3" name="data[RomaneioGordo][observacoes]"><?=$dados['RomaneioGordo']['observacoes']?></textarea>
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
    </div>
</div>
<!-- END PAGE BASE CONTENT -->

<?php
/*-- BEGIN PAGE LEVEL CSS --*/
$this->Html->css('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/layouts/layout4/css/custom', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/dependent-dropdown-master/css/dependent-dropdown.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/select2/css/select2-bootstrap.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/icheck/skins/all', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', array('block' => 'cssPage'));
$this->Html->css('/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', array('block' => 'cssPage'));
// $this->Html->css('/metronic/assets/global/plugins/dropzone/dropzone.min', array('block' => 'cssPage'));
// $this->Html->css('/metronic/assets/global/plugins/dropzone/basic.min', array('block' => 'cssPage'));
/*-- BEGIN PAGE LEVEL CSS --*/

/*-- BEGIN PAGE LEVEL PLUGINS --*/
$this->Html->script('/metronic/assets/global/plugins/jquery.form.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery.metadata', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootbox/bootbox.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/dependent-dropdown-master/js/dependent-dropdown.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/select2/js/select2.full.min', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/select2/js/i18n/pt-BR', array('block' => 'scriptBottom'));
$this->Html->script('/metronic/assets/global/plugins/icheck/icheck.min', array('block' => 'scriptBottom'));
// $this->Html->script('/metronic/assets/global/plugins/dropzone/dropzone.min', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL PLUGINS --*/

/*-- BEGIN PAGE LEVEL SCRYPTS --*/
$this->Html->script('/js/RomaneioGordo/alterar.js?v=1.1.2', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>
