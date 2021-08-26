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
		Adicionar
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
					<span class="caption-subject font-dark bold uppercase">Adicionar Romaneio Gordo</span>
				</div>
				<div class="actions">
					<a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'RomaneioGordo', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-default display-hide" id="outro_cadastro"><i class="fa fa-plus"></i> Incluir Outro Romaneio </a>
				</div>
			</div>
			<div class="portlet-body">
				<!-- BEGIN FORM-->
				<form class="" action="" method="post" enctype="multipart/form-data" id="adicionar-romaneio" autocomplete="off">
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
										<option value="<?=$key?>"><?=$value?></option>
										<?php } // end foreach?>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Data de Emissão: <span class="required">*</span></label>
									<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
										<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioGordo][data_emissao]" placeholder="" id="data_emissao">
										<span class="input-group-btn"><button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button></span>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Nº Romaneio: <span class="required">*</span></label>
									<div class="input-icon left">
										<!--<i class="fa"></i>-->
										<input type="text" class="form-control" name="data[RomaneioGordo][numero]" maxlength="250" />
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
										<option value="<?=$key?>"><?=$value?></option>
										<?php } // end foreach?>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Obra/Localidade: <span class="required">*</span></label>
									<select class="form-control select2 selectnext" name="data[RomaneioGordo][vendedor_localidade_id]" disabled="disabled" id="produtor_localidade_id">
										<option value="">Selecione ...</option>
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
													<select class="form-control select2 selectnext" name="data[RomaneioGordo][especie_id]" id="select2_especie">
														<option value="">Selecione ...</option>
														<?php foreach ($listaEspecies as $key => $value) { ?>
														<option value="<?=$key?>"><?=$value?></option>
														<?php } // end foreach?>
													</select>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Peso Fazenda: <span class="required">*</span></label>
													<div class="input-icon left">
														<!--<i class="fa"></i>-->
														<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][peso_fazenda_total]" maxlength="14" minlength="3" />
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Peso Frigorífico: <span class="required">*</span></label>
													<div class="input-icon left">
														<!--<i class="fa"></i>-->
														<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][peso_frigorifico]" maxlength="14" minlength="3" />
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Data Abate: <span class="required">*</span></label>
													<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
														<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioGordo][data_abate]" placeholder="">
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
																		<input type="text" class="form-control numero tipo_cabecas" name="data[RomaneioGordo][tipoa_cabecas]" maxlength="14" minlength="1"/>
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control duasdecimal tipo_kg_carcaca" name="data[RomaneioGordo][tipoa_kg_carcaca]" maxlength="14" minlength="3" />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control duasdecimal tipo_valor_total" name="data[RomaneioGordo][tipoa_valor_unitario]" maxlength="14" minlength="3" />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control moeda" name="data[RomaneioGordo][tipoa_valor_total]" maxlength="14" minlength="3" readonly />
																	</div>
																</td>
															</tr>
															<tr>
																<td> Tipo B </td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control numero tipo_cabecas" name="data[RomaneioGordo][tipob_cabecas]" maxlength="14" minlength="1"/>
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control duasdecimal tipo_kg_carcaca" name="data[RomaneioGordo][tipob_kg_carcaca]" maxlength="14" minlength="3" />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control duasdecimal tipo_valor_total" name="data[RomaneioGordo][tipob_valor_unitario]" maxlength="14" minlength="3" />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control moeda" name="data[RomaneioGordo][tipob_valor_total]" maxlength="14" minlength="3" readonly />
																	</div>
																</td>
															</tr>
															<tr>
																<td> Tipo C </td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control numero tipo_cabecas" name="data[RomaneioGordo][tipoc_cabecas]" maxlength="14" minlength="1"/>
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control duasdecimal tipo_kg_carcaca" name="data[RomaneioGordo][tipoc_kg_carcaca]" maxlength="14" minlength="3" />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control duasdecimal tipo_valor_total" name="data[RomaneioGordo][tipoc_valor_unitario]" maxlength="14" minlength="3" />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control moeda" name="data[RomaneioGordo][tipoc_valor_total]" maxlength="14" minlength="3" readonly />
																	</div>
																</td>
															</tr>
															<tr>
																<td> Totais </td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control numero" name="data[RomaneioGordo][totais_cabecas]" maxlength="14" minlength="1" readonly />
																	</div>
																</td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control moeda" name="data[RomaneioGordo][totais_kg_carcaca]" maxlength="14" minlength="3" readonly />
																	</div>
																</td>
																<td></td>
																<td>
																	<div class="input-icon left">
																		<input type="text" class="form-control moeda" name="data[RomaneioGordo][totais_valor_total]" maxlength="14" minlength="3" readonly />
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
																		<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_funral_porcentual]" maxlength="14" minlength="3" placeholder="%" id="desconto-funrural-per" />
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="input-icon left">
																		<!--<i class="fa"></i>-->
																		<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_funral_valor]" maxlength="14" minlength="3" placeholder="R$" id="desconto-funrural-val" />
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
																		<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_fundesa_porcentual]" maxlength="14" minlength="3" placeholder="%" id="desconto-fundesa-per" />
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="input-icon left">
																		<!--<i class="fa"></i>-->
																		<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][desconto_fundesa_valor]" maxlength="14" minlength="3" placeholder="R$" id="desconto-fundesa-val" />
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
																<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][valor_liquido]" maxlength="14" minlength="3" id="valor-total-liquido" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][media_fazenda]" readonly id="media_fazenda" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][media_frigorifico]" readonly id="media_frigorifico" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][media_carcaca]" readonly id="media_carcaca" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][media_cabeca]" readonly id="media_cabeca" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][rendimento_frigorifico]" readonly id="rendimento_frigorifico" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][rendimento_fazenda]" readonly id="rendimento_fazenda" />
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
																<input type="text" class="form-control moeda" name="data[RomaneioGordo][rendimento_quebra]" readonly id="rendimento_quebra" />
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
																<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][comissao_comprador_porcentual]" maxlength="14" minlength="3" placeholder="%" id="comissao_comprador_porcentual" />
															</div>
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">Valor Comissão: <span class="required">*</span></label>
															<div class="input-icon left">
																<!--<i class="fa"></i>-->
																<input type="text" class="form-control duasdecimal" name="data[RomaneioGordo][comissao_comprador_valor]" maxlength="14" minlength="3" placeholder="R$" id="comissao_comprador_valor"/>
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
																<input type="text" class="form-control numero" name="data[RomaneioGordo][prazo_pgto_dias]" maxlength="5" minlength="1" id="prazo_pgto_dias" value="0"/>
															</div>
														</div>
													</div>

													<div class="col-md-4">
													   <div class="form-group">
															<label class="control-label">Data Pagamento: <span class="required">*</span></label>
															<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
																<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioGordo][comissao_comprador_data_pgto]" placeholder="" id="comissao_comprador_data_pgto">
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
																			<input type="text" class="form-control form-filter input-sm" readonly name="data[RomaneioVencimento][<?php echo $i ?>][vencimento_em]">
																			<span class="input-group-btn">
																				<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
																			</span>
																		</div>
																	</td>
																	<td>
																		<input type="text" class="form-control duasdecimal" name="data[RomaneioVencimento][<?php echo $i ?>][valor]" value="0,00" maxlength="14" minlength="3" placeholder="R$"/>
																	</td>
																	<td>
																		<input type="checkbox" class="form-control" name="data[RomaneioVencimento][<?php echo $i ?>][pago]">
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
									<textarea class="form-control" rows="3" name="data[RomaneioGordo][observacoes]"></textarea>
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
$this->Html->script('/js/RomaneioGordo/adicionar.js?v=1.1.8', array('block' => 'scriptBottom'));
/*-- END PAGE LEVEL SCRYPTS --*/
?>
