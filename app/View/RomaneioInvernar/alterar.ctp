<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Romaneio Invernar <small>administrar Romaneios</small></h1>
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
		<a href="<?php echo $this->Html->url(array('controller' => 'RomaneioInvernar', 'action' => 'index')) ?>">Romaneio Invernar</a><i class="fa fa-circle"></i>
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
				<i class="font-dark fa fa-file-o"></i>
					<span class="caption-subject font-dark bold uppercase">Alterar Romaneio Invernar</span>
				</div>
			</div>
			<div class="portlet-body">
				<!-- BEGIN FORM-->
				<form class="" action="" method="post" enctype="multipart/form-data" id="alterar-romaneio" autocomplete="off">
					<input type="hidden" name="data[RomaneioInvernar][id]" value="<?=$dados['RomaneioInvernar']['id']?>">
					<input type="hidden" name="data[RomaneioInvernar][tipo]" value="1">
					<input type="hidden" name="data[RomaneioInvernar][peso_fazenda_total]" id="peso_fazenda_total" value="<?=$dados['RomaneioInvernar']['peso_fazenda_total']?>">
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
							<div class="col-md-5">
								<div class="form-group">
									<label class="control-label">Comprador: <span class="required">*</span></label>
									<select class="form-control select2 selectnext" name="data[RomaneioInvernar][comprador_id]" id="comprador_pessoa_id">
										<option value="">Selecione ...</option>
										<?php foreach ($listaCompradores as $key => $value) { ?>
										<?php if ($dados['RomaneioInvernar']['comprador_id'] != $key) { ?>
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
									<label class="control-label">Obra/Localidade: <span class="required">*</span></label>
									<select class="form-control select2 selectnext" name="data[RomaneioInvernar][comprador_localidade_id]" id="comprador_localidade_id">
										<option value="">Selecione ...</option>
										<option value="<?=$dados['comprador_localidade_id']['id']?>" selected><?=$dados['comprador_localidade_id']['localidade']?></option>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Data de Emissão: <span class="required">*</span></label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioInvernar][data_emissao]" placeholder="" id="data_emissao" value="<?php echo (!is_null($dados['RomaneioInvernar']['data_emissao']))?date('d/m/Y', strtotime($dados['RomaneioInvernar']['data_emissao'])): ''?>">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Nº Romaneio: <span class="required">*</span></label>
									<div class="input-icon left">
										<!--<i class="fa"></i>-->
										<input type="text" class="form-control" name="data[RomaneioInvernar][numero]" maxlength="250" value="<?=$dados['RomaneioInvernar']['numero']?>" />
									</div>
								</div>
							</div>
						</div><!-- ./row -->
						
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label class="control-label">Vendedor: <span class="required">*</span></label>
									<select class="form-control select2 selectnext" name="data[RomaneioInvernar][vendedor_id]" id="vendedor_pessoa_id">
										<option value="">Selecione ...</option>
										<?php foreach ($listaVendedores as $key => $value) { ?>
										<?php if ($dados['RomaneioInvernar']['vendedor_id'] != $key) { ?>
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
									<label class="control-label">Obra/Localidade: <span class="required">*</span></label>
									<select class="form-control select2 selectnext" name="data[RomaneioInvernar][vendedor_localidade_id]" id="vendedor_localidade_id">
										<option value="">Selecione ...</option>
										<option value="<?=$dados['vendedor_localidade_id']['id']?>" selected><?=$dados['vendedor_localidade_id']['localidade']?></option>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Data de Embarque: <span class="required">*</span></label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioInvernar][data_embarque]" placeholder="" value="<?php echo (!is_null($dados['RomaneioInvernar']['data_embarque']))?date('d/m/Y', strtotime($dados['RomaneioInvernar']['data_embarque'])): ''?>">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
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
											<div class="col-md-12 col-sm-12">
												<div class="portlet-body form">
													<div class="form-body" id="form-especies">                                           

														<div class="row">
															<div class="col-md-2">
																<div class="form-group">
																	<label class="control-label">Espécie: <span class="required">*</span></label>
																	<select class="form-control select2 selectnext" name="data[aux][RomaneioInvernar_especie_id]" id="RomaneioInvernar_especie_id">
																		<option value="">Selecione ...</option>
																		<?php foreach ($listaEspecies as $key => $value) { ?>
																		<option value="<?=$key?>"><?=$value?></option>
																		<?php } // end foreach?>
																	</select>
																</div>
															</div>

															<div class="col-md-2">
																<div class="form-group">
																	<label class="control-label">Peso Fazenda: <span class="required">*</span></label>
																	<input type="text" class="form-control duasdecimal" name="data[aux][RomaneioInvernar_peso_fazenda]" maxlength="14" minlength="3" />
																</div>
															</div>

															<div class="col-md-2">
																<div class="form-group">
																	<label class="control-label">Cabeças: <span class="required">*</span></label>
																	<input type="text" class="form-control numero" name="data[aux][RomaneioInvernar_cabecas]" maxlength="14" minlength="1" />
																</div>
															</div>
														
															<div class="col-md-2">
																<div class="form-group">
																	<label class="control-label">Valor Unitário: <span class="required">*</span></label>
																	<input type="text" class="form-control duasdecimal" name="data[aux][RomaneioInvernar_valor_unitario]" maxlength="14" minlength="3" />
																</div>
															</div>

															<div class="col-md-2">
																<div class="form-group">
																	<label class="control-label">Valor Total: </label>
																	<input type="text" class="form-control moeda" name="data[aux][RomaneioInvernar_valor_total]" maxlength="14" minlength="3" readonly  />
																</div>
															</div>

															<div class="col-md-2">
																<div class="form-group">
																	<label style="margin-bottom: 21px;"></label>
																	<button type="button" class="btn btn-success" title="Adicionar Espécie" id="btn-add-especie"><i class="fa fa-plus"></i> Adicionar Espécie</button>
																</div>
															</div>
														</div>

														<div class="row"><div class="col-md-12"><hr></div></div>

														<div class="row">
															<div class="col-md-12">
																<table class="table table-striped table-bordered table-hover" id="table-especies">
																	<thead>
																		<tr>
																			<th width="200px"> Espécie </th>
																			<th> Peso Fazenda </th>
																			<th> Cabeças </th>
																			<th> Valor Unitário </th>
																			<th> Valor Total </th>
																			<th> Ações </th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php foreach ($dados['RomaneioItem'] as $item) { ?>
																		<tr>
																			<input type='hidden' class='dados-especie_id' value='<?=$item['especie_id']?>'>
																			<input type='hidden' class='dados-peso' value='<?=number_format($item['peso'], '2', ',', '.')?>'>
																			<input type='hidden' class='dados-cabecas' value='<?=$item['cabecas']?>'>
																			<input type='hidden' class='dados-valor_unitario' value='<?=number_format($item['valor_unitario'], '2', ',', '.')?>'>
																			<input type='hidden' class='dados-valor_total' value='<?=number_format($item['valor_total'], '2', ',', '.')?>'>

																			<td><?=$item['especie']?></td>
																			<td><?=number_format($item['peso'], '2', ',', '.')?></td>
																			<td><?=$item['cabecas']?></td>
																			<td><?=number_format($item['valor_unitario'], '2', ',', '.')?></td>
																			<td><?=number_format($item['valor_total'], '2', ',', '.')?></td>
																			<td><a href="#" class="btn btn-icon-only red btn-remove" data-id="<?=$item['id']?>" title="Excluir Espécie"><i class="fa fa-trash"></i></a></td>
																		</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</div>
														</div>

													</div>
												</div>
											</div>
										</div><!-- ./row -->

										<div class="row  text-right">
											<div class="form-group">
												<div class="col-md-6"></div>
												<div class="col-md-4">
													<label class="control-label">Valor Total Líquido: <span class="required">*</span></label>
												</div>
												<div class="col-md-2">
													<div class="input-icon left">
														<input type="text" class="form-control moeda" readonly name="data[RomaneioInvernar][valor_liquido]" maxlength="14" minlength="3" id="valor_liquido" value="<?=number_format($dados['RomaneioInvernar']['valor_liquido'], '2', ',', '.')?>" />
													</div>
												</div>
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
															<label class="control-label">Carcaça: </label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control moeda" readonly name="data[aux][RomaneioInvernar_media_carcaca]" maxlength="14" minlength="3" id="media_carcaca" value="<?=number_format($dados['aux']['RomaneioInvernar_media_carcaca'], '2', ',', '.')?>" />
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
																<input type="text" class="form-control moeda" readonly name="data[aux][RomaneioInvernar_media_cabeca]" maxlength="14" minlength="3" id="media_cabeca" value="<?=number_format($dados['aux']['RomaneioInvernar_media_cabeca'], '2', ',', '.')?>" />
															</div>
														</div>
													</div>
												</div><!-- ./row -->
											</div>

											<div class="col-md-2">
												<div class="row">
													<div class="col-md-12 text-center">
														<label class="bold">Pagamento</label>
													</div>
												</div><!-- ./row -->

												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Prazo (em dias): </label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control numero" name="data[RomaneioInvernar][prazo_pgto_dias]" maxlength="5" minlength="1" id="prazo_pgto_dias" value="<?=$dados['RomaneioInvernar']['prazo_pgto_dias']?>"/>
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
													<div class="col-md-3 text-right">
														<div style="margin-bottom: 28px"></div>
														<p class="text-right bold"> Comprador: </p>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Perc. Comissão: <span class="required">*</span></label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control duasdecimal" name="data[RomaneioInvernar][comissao_comprador_porcentual]" maxlength="14" minlength="3" placeholder="%" id="comissao_comprador_porcentual" value="<?=number_format($dados['RomaneioInvernar']['comissao_comprador_porcentual'], '2', ',', '.')?>"/>
															</div>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Valor Comissão: <span class="required">*</span></label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control duasdecimal" name="data[RomaneioInvernar][comissao_comprador_valor]" maxlength="14" minlength="3" placeholder="R$" id="comissao_comprador_valor" value="<?=number_format($dados['RomaneioInvernar']['comissao_comprador_valor'], '2', ',', '.')?>"/>
															</div>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Data Pagamento: <span class="required">*</span></label>
															<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
																<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioInvernar][comissao_comprador_data_pgto]" placeholder="" id="comissao_comprador_data_pgto" value="<?php echo (!is_null($dados['RomaneioInvernar']['comissao_comprador_data_pgto']))?date('d/m/Y', strtotime($dados['RomaneioInvernar']['comissao_comprador_data_pgto'])): ''?>">
																<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
															</div>
														</div>
													</div>
												</div><!-- ./row -->

												<div class="row">
													<div class="col-md-3 text-right">
														<div style="margin-bottom: 28px"></div>
														<p class="text-right bold"> Vendedor: </p>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Perc. Comissão: <span class="required">*</span></label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control duasdecimal" name="data[RomaneioInvernar][comissao_vendedor_porcentual]" maxlength="14" minlength="3" placeholder="%" id="comissao_vendedor_porcentual" value="<?=number_format($dados['RomaneioInvernar']['comissao_vendedor_porcentual'], '2', ',', '.')?>"/>
															</div>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Valor Comissão: <span class="required">*</span></label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control duasdecimal" name="data[RomaneioInvernar][comissao_vendedor_valor]" maxlength="14" minlength="3" placeholder="R$" id="comissao_vendedor_valor" value="<?=number_format($dados['RomaneioInvernar']['comissao_vendedor_valor'], '2', ',', '.')?>"/>
															</div>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Data Pagamento: <span class="required">*</span></label>
															<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
																<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioInvernar][comissao_vendedor_data_pgto]" placeholder="" id="comissao_vendedor_data_pgto" value="<?php echo (!is_null($dados['RomaneioInvernar']['comissao_vendedor_data_pgto']))?date('d/m/Y', strtotime($dados['RomaneioInvernar']['comissao_vendedor_data_pgto'])): ''?>">
																<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
															</div>
														</div>
													</div>
												</div><!-- ./row -->

											</div>

											<div class="col-md-4">&nbsp;</div>

											<div class="col-md-8">
												<div class="row">
													<div class="col-md-12 text-center">
														<label class="bold">Comissão vendedor/comprador</label>
													</div>
												</div><!-- ./row -->

												<div class="row">
													<div class="col-md-3">
													&nbsp;</div>
													 <div class="col-md-9">

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
									<textarea class="form-control" rows="3" name="data[RomaneioInvernar][observacoes]"><?=$dados['RomaneioInvernar']['observacoes']?></textarea>
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
$this->Html->script('/js/RomaneioInvernar/alterar.js?v=1.0.9', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>
