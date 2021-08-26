var Index = function () {

	var grid = new Datatable();

	var initDelete = function () {
		$('#table-pagarpagamentos').on('click', 'a.btn-remove', function(ev){
			ev.preventDefault();
			param1 = $(this).data("id");
			bootbox.confirm({
				title: "Confirmação",
				message: "Você tem certeza desta exclusão?",
				buttons: {
					'confirm': {
						label: 'Sim',
						className: 'btn-primary'
					},
					'cancel': {
						label: 'Não',
						className: 'btn-default'
					}
				},
				callback: function(result) {
					if (result) {
						App.blockUI({
							target: '#table-pagarpagamentos',
							boxed: true,
							message: 'Excluindo, aguarde...'
						});
						$.post(baseUrl +"ContasPagar/excluir/"+param1,function(data){
							if (data.status == "ok")
								$("#table-pagarpagamentos").DataTable().ajax.reload();
							else if(data.status == "erro"){
								App.alert({
									container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
									place: "prepend", // append or prepent in container
									type: "danger", // alert's type
									message: data.msg, // alert's message
									close: true, // make alert closable
									reset: true, // close all previouse alerts first
									focus: true, // auto scroll to the alert after shown
									closeInSeconds: 10, // auto close after defined seconds
									icon: "warning" // put icon before the message
								});
							}
							else if(data.status == "warning"){
								App.alert({
									container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
									place: "prepend", // append or prepent in container
									type: "warning", // alert's type
									message: data.msg, // alert's message
									close: true, // make alert closable
									reset: true, // close all previouse alerts first
									focus: true, // auto scroll to the alert after shown
									closeInSeconds: 10, // auto close after defined seconds
									icon: "warning" // put icon before the message
								});
							}
							App.unblockUI('#table-pagarpagamentos');
						}).fail(function(jqXHR, textStatus, errorThrown){
							App.alert({
								container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
								place: "prepend", // append or prepent in container
								type: "danger", // alert's type
								message: "Ocorreu um erro ao fazer a exclusão da conta à pagar. "+errorThrown, // alert's message
								close: true, // make alert closable
								reset: true, // close all previouse alerts first
								focus: true, // auto scroll to the alert after shown
								closeInSeconds: 10, // auto close after defined seconds
								icon: "warning" // put icon before the message
							});
							App.unblockUI('#table-pagarpagamentos');
						});
					}
				}
			})
		})
	}

	var handleRecords = function () {

		grid.init({
			src: $("#table-pagarpagamentos"),
			onSuccess: function (grid) {
				// execute some code after table records loaded
				initMasks();
			},
			onError: function (grid) {
				// execute some code on network or other general error
			},
			loadingMessage: 'Carregando...',
			dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

				// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
				// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
				// So when dropdowns used the scrollable div should be removed.
				//"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
				
				"language": { // language settings
					// App spesific
					"AppGroupActions": "_TOTAL_ registros selecionados: ",
					"AppAjaxRequestGeneralError": "Não foi possível completar a requisição. Por favor, cheque sua conexão com a internet.",

					// data tables spesific
					"lengthMenu": "<span class='seperator'>|</span>Vendo _MENU_ registros",
					"info": "<span class='seperator'>|</span>Encontrados um total de _TOTAL_ registros",
					"infoEmpty": "Sem registros para mostrar",
					"emptyTable": "Nenhum dado disponível na tabela",
					"zeroRecords": "Nenhum registro encontrado",
					"paginate": {
						"previous": "Anterior",
						"next": "Próximo",
						"last": "Último",
						"first": "Primeiro",
						"page": "Página",
						"pageOf": "de"
					}
				},

			"aoColumns": [
				{ 'bSortable' : false, "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ 'bSortable' : false, "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ 'bSortable' : false, "sClass": "text-center" },
				{ "sClass": "text-center" },
				{ 'bSortable' : false, "sClass": "text-center" },

				
			],

				"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
				"sDom": "t<'row'<'col-md-8 col-sm-12'pi><'col-md-4 col-sm-12'>>",

				"lengthMenu": [
					[10, 20, 50, 100, 150, -1],
					[10, 20, 50, 100, 150, "All"] // change per page values here
				],
				"pageLength": 10, // default record count per page
				"ajax": {
					"url": baseUrl +"ContasPagar/index", // ajax source
				},
				"order": [
					[2, "asc"]
				] // set first column as a default sort by asc
			}
		});

		// handle group actionsubmit button click
		$("a.tool-action").click(function(ev) {
			ev.preventDefault();
			var action = $(this).data('action');
			if ( action == 4 ) { //excluir
				if ( grid.getSelectedRowsCount() == 0 ) {
					App.alert({
						type: 'danger',
						icon: 'warning',
						message: 'Marque pelo menos 1 registro.',
						container: grid.getTableWrapper(),
						place: 'prepend',
						closeInSeconds: 10
					});
				} else {
					var url_ids = '';
					$.each(grid.getSelectedRows(), function(index, el){
						url_ids += "id[]="+el+"&";
					});
					$.post(baseUrl+"ContasPagar/excluirVarious/?"+url_ids,function(data){
						if (data.status == "ok") {
							App.alert({
								container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
								place: "prepend", // append or prepent in container
								type: "success", // alert's type
								message: data.msg, // alert's message
								close: true, // make alert closable
								reset: true, // close all previouse alerts first
								focus: true, // auto scroll to the alert after shown
								closeInSeconds: 3, // auto close after defined seconds
								icon: "warning" // put icon before the message
							});
							$("#table-pagarpagamentos").DataTable().ajax.reload();
						} else if(data.status == "erro") {
							App.alert({
								container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
								place: "prepend", // append or prepent in container
								type: "danger", // alert's type
								message: data.msg, // alert's message
								close: true, // make alert closable
								reset: true, // close all previouse alerts first
								focus: true, // auto scroll to the alert after shown
								closeInSeconds: 10, // auto close after defined seconds
								icon: "warning" // put icon before the message
							});
						} else if(data.status == "warning") {
							App.alert({
								container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
								place: "prepend", // append or prepent in container
								type: "warning", // alert's type
								message: data.msg, // alert's message
								close: true, // make alert closable
								reset: true, // close all previouse alerts first
								focus: true, // auto scroll to the alert after shown
								closeInSeconds: 10, // auto close after defined seconds
								icon: "warning" // put icon before the message
							});
						}
						App.unblockUI('#table-pagarpagamentos');
					}).fail(function(jqXHR, textStatus, errorThrown){
						App.alert({
							container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
							place: "prepend", // append or prepent in container
							type: "danger", // alert's type
							message: "Ocorreu um erro ao fazer a exclusão dos pagamentos. "+errorThrown, // alert's message
							close: true, // make alert closable
							reset: true, // close all previouse alerts first
							focus: true, // auto scroll to the alert after shown
							closeInSeconds: 10, // auto close after defined seconds
							icon: "warning" // put icon before the message
						});
						App.unblockUI('#table-pagarpagamentos');
					});
				}
			} else if ( action == 5 ) { //reload
				grid.getDataTable().ajax.reload();
			} else if ( action == 6 ) { //pagar
				if ( grid.getSelectedRowsCount() == 0 ) {
					App.alert({
						type: 'danger',
						icon: 'warning',
						message: 'Marque pelo menos 1 registro.',
						container: grid.getTableWrapper(),
						place: 'prepend',
						closeInSeconds: 10
					});
				} else {
					$('#modalPagarVarious').modal('show');
					$('#alert-pagar').empty();
					$("form#pagarvarious #adicionar").click(function(e) {
						e.preventDefault();
						var data_pago = $('#data_pago').val();
						var forma_pago = $('#forma_pago').val();
						if (data_pago == "" || forma_pago == "") {
							App.alert({
								type: 'danger',
								icon: 'warning',
								message: 'Os campos devem ser informados para realizar o pagamento.',
								container: "#alert-pagar",
								place: 'prepend',
								closeInSeconds: 5,
								reset: true,
							});
						} else {
							var url_ids = "data_pago="+data_pago+"&forma_pago="+forma_pago+"&";
							$.each(grid.getSelectedRows(), function(index, el){
								url_ids += "id[]="+el+"&";
							});
							$.post(baseUrl+"ContasPagar/pagarVarious/?"+url_ids,function(data){
								if (data.status == "ok") {
									App.alert({
										container: "#alert-pagar", // alerts parent container(by default placed after the page breadcrumbs)
										place: "prepend", // append or prepent in container
										type: "success", // alert's type
										message: data.msg, // alert's message
										close: true, // make alert closable
										reset: true, // close all previouse alerts first
										focus: true, // auto scroll to the alert after shown
										closeInSeconds: 5, // auto close after defined seconds
										icon: "warning" // put icon before the message
									});
									$("form#pagarvarious #adicionar").unbind();
									$("#table-pagarpagamentos").DataTable().ajax.reload();
									setTimeout(function() { $('#modalPagarVarious').modal('hide'); }, 3000);
								} else if(data.status == "erro") {
									App.alert({
										container: "#alert-pagar", // alerts parent container(by default placed after the page breadcrumbs)
										place: "prepend", // append or prepent in container
										type: "danger", // alert's type
										message: data.msg, // alert's message
										close: true, // make alert closable
										reset: true, // close all previouse alerts first
										focus: true, // auto scroll to the alert after shown
										closeInSeconds: 5, // auto close after defined seconds
										icon: "warning" // put icon before the message
									});
								} else if(data.status == "warning") {
									App.alert({
										container: "#alert-pagar", // alerts parent container(by default placed after the page breadcrumbs)
										place: "prepend", // append or prepent in container
										type: "warning", // alert's type
										message: data.msg, // alert's message
										close: true, // make alert closable
										reset: true, // close all previouse alerts first
										focus: true, // auto scroll to the alert after shown
										closeInSeconds: 5, // auto close after defined seconds
										icon: "warning" // put icon before the message
									});
								}
								App.unblockUI('#table-pagarpagamentos');
							}).fail(function(jqXHR, textStatus, errorThrown){
								App.alert({
									container: "#alert-pagar", // alerts parent container(by default placed after the page breadcrumbs)
									place: "prepend", // append or prepent in container
									type: "danger", // alert's type
									message: "Ocorreu um erro ao fazer a adição dos pagamentos. "+errorThrown, // alert's message
									close: true, // make alert closable
									reset: true, // close all previouse alerts first
									focus: true, // auto scroll to the alert after shown
									closeInSeconds: 5, // auto close after defined seconds
									icon: "warning" // put icon before the message
								});
								App.unblockUI('#table-pagarpagamentos');
							});
						}
					});
				}
			}
		});

		// handle group actionsubmit button click
		grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
			e.preventDefault();
			var action = $(".table-group-action-input", grid.getTableWrapper());
			if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
				grid.setAjaxParam("customActionType", "group_action");
				grid.setAjaxParam("customActionName", action.val());
				grid.setAjaxParam("id", grid.getSelectedRows());
				grid.getDataTable().ajax.reload();
				grid.clearAjaxParams();
			} else if (action.val() == "") {
				App.alert({
					type: 'danger',
					icon: 'warning',
					message: 'Por favor, selecione uma ação.',
					container: grid.getTableWrapper(),
					place: 'prepend'
				});
			} else if (grid.getSelectedRowsCount() === 0) {
				App.alert({
					type: 'danger',
					icon: 'warning',
					message: 'Nenhum registro selecionado.',
					container: grid.getTableWrapper(),
					place: 'prepend'
				});
			}
		});
	}

	var initPickers = function(){
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true,
			format: 'dd/mm/yyyy',
			language: 'pt-BR',
            todayHighlight: true
        });
	}

	var initPago = function () {
		$('#table-pagarpagamentos').on('click', 'a.btn-pagar', function (ev) {
			ev.preventDefault();
			param1 = $(this).data("id");
			bootbox.confirm({
				title: "Confirmação",
				message: "Você tem certeza em confirmar este pagamento?",
				buttons: {
					'confirm': {
						label: 'Sim',
						className: 'btn-primary'
					},
					'cancel': {
						label: 'Não',
						className: 'btn-default'
					}
				},
				callback: function (result) {
					if (result) {
						App.blockUI({
							target: '#table-pagarpagamentos',
							boxed: true,
							message: 'Executando, aguarde...'
						});
						$.post(baseUrl + "ContasPagar/pagamento/" + param1, function (data) {
							if (data.status == "ok") {
								// $("#table-pagarpagamentos .alert-success span.message").html(data.msg);
								console.log(data.msg);
								$("#table-pagarpagamentos").DataTable().ajax.reload();
							} else if (data.status == "erro") {
								App.alert({
									container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
									place: "prepend", // append or prepent in container
									type: "danger", // alert's type
									message: data.msg, // alert's message
									close: true, // make alert closable
									reset: true, // close all previouse alerts first
									focus: true, // auto scroll to the alert after shown
									closeInSeconds: 10, // auto close after defined seconds
									icon: "warning" // put icon before the message
								});
							}
							else if (data.status == "warning") {
								App.alert({
									container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
									place: "prepend", // append or prepent in container
									type: "warning", // alert's type
									message: data.msg, // alert's message
									close: true, // make alert closable
									reset: true, // close all previouse alerts first
									focus: true, // auto scroll to the alert after shown
									closeInSeconds: 10, // auto close after defined seconds
									icon: "warning" // put icon before the message
								});
							}
							App.unblockUI('#table-pagarpagamentos');
						}).fail(function (jqXHR, textStatus, errorThrown) {
							App.alert({
								container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
								place: "prepend", // append or prepent in container
								type: "danger", // alert's type
								message: "Ocorreu um erro ao confirmar o pagamento. " + errorThrown, // alert's message
								close: true, // make alert closable
								reset: true, // close all previouse alerts first
								focus: true, // auto scroll to the alert after shown
								closeInSeconds: 10, // auto close after defined seconds
								icon: "warning" // put icon before the message
							});
							App.unblockUI('#table-pagarpagamentos');
						});
					}
				}
			})
		})
	}

	var initMasks = function () {
		$("input.cep").keyup(function () { mascara(this, mcep) });
		$("input.cpf").keyup(function () { mascara(this, mcpf) });
		$("input.cnpj").keyup(function () { mascara(this, cnpj) });
		$("input.phone").keyup(function () { mascara(this, mtel) });
		$("input.databr").keyup(function () { mascara(this, mdata) });
		$("input.moeda").keyup(function () { mascara(this, mvalor) });

		$(".select2").select2({
			placeholder: "Selecione..",
			width: 'element',
			allowClear: true
		});
	}

	var handleSample = function () {
		$('#table-pagarpagamentos').on('click', 'a.btn-popup', function(ev) {
			ev.preventDefault();
            alert('You canceled action #2');
		})
	}
	
	var handleValidationAlterar = function() {
		$("form#alterar-pagar button[type=submit]").click(function(e){
            e.preventDefault();
			$('form#alterar-pagar').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

		var form = $('form#alterar-pagar');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var warning = $('.alert-warning', form);

        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            invalidHandler: function (event, validator) { //display error alert on form submit
                success.hide();
                error.show();
                App.scrollTo(error, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },

            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                tab_name = $(element).closest('.tab-pane').attr('id');
                $("a[href=#"+tab_name+"]").tab('show');
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass("has-error").addClass('has-success'); // remove error class to the control group
            },

            success: function (label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function (form) {
                
                var formdata = new FormData(form);
				$("form#alterar-pagar button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
					url: baseUrl+'ContasPagar/edit_data_pago',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
						$("form#alterar-pagar .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        // window.location.reload();
						$("#table-pagarpagamentos").DataTable().ajax.reload();
						setTimeout( function () {
							$('#modalAddPagamento').modal('hide');
							form.reset();
							$('#addDataPago').html('');
							success.hide();
							error.hide();
                        	warning.hide();
						}, 2000);
                    }else if(data.status == "warning"){
						$("form#alterar-pagar .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    }else if(data.status == "erro"){
						$("form#alterar-pagar .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
					}
					$('#modalAddPagamento').on('hidden.bs.modal', function (e) {
						// do something...
						success.hide();
						error.hide();
						warning.hide();
					});
					$("form#alterar-pagar button[type=submit]").html('<i class="fa fa-check"></i> Adicionar').removeAttr('disabled');
					App.scrollTo($("form#alterar-pagar"), -200);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
					$("form#alterar-pagar .alert-danger span.message").html("Ocorreu um erro ao alterar a conta à pagar. ("+textStatus+" - "+errorThrown+")")
                    error.show();
					$("form#alterar-pagar button[type=submit]").html('<i class="fa fa-check"></i> Adicionar').removeAttr('disabled');
                    App.scrollTo(error, -200);
                });
            }
        });

	}

	$('#modalDataPago').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var recipient = button.data('whatever'); // Extract info from data-* attributes
		if ((recipient != "") && (recipient !== 'undefined')) {
			$('#viewDataPago').html('carregando...');
			$('#viewDataPago').load(baseUrl + 'ContasPagar/view_data_pago/' + recipient, function () {});
		}
	});

	$('#modalAddPagamento').on('shown.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var recipient = button.data('whatever'); // Extract info from data-* attributes
		if ((recipient != "") && (typeof recipient !== 'undefined')) {
			$('#addDataPago').html('<input type="hidden" name="data[PagamentoData][id]" value="'+recipient+'" />');
		}
	});
	
	return {
		//main function to initiate the module
		init: function () {
			if (!jQuery().dataTable) { return; }
			handleRecords();
			initDelete();
			initPickers();
			initMasks();
			handleValidationAlterar();
			// initPago();
			// handleSample();
		}
	};
	
}();

$(document).ready(function() {
	Index.init();
	// $('[data-toggle="popover"]').popover();
});