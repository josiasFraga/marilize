var Index = function () {

	var grid = new Datatable();

	var handleRecords = function () {

		grid.init({
			src: $("#table-especies"),
			onSuccess: function (grid) {
				// execute some code after table records loaded
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
				{'bSortable' : false, "sClass": "text-center"},
				{"sClass": "text-center"},
				{'bSortable' : false, "sClass": "text-center"}
			],

				"bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
				"sDom": "t<'row'<'col-md-8 col-sm-12'pi><'col-md-4 col-sm-12'>>",

				"lengthMenu": [
					[10, 20, 50, 100, 150, -1],
					[10, 20, 50, 100, 150, "All"] // change per page values here
				],
				"pageLength": 20, // default record count per page
				"ajax": {
					"url": baseUrl+"Especies/index", // ajax source
				},
				"order": [
					[1, "asc"]
				] // set first column as a default sort by asc
			}
		});

	/*
		$("a.tool-action").click(function(ev){
			ev.preventDefault();
			var action = $(this).data('action');
			if ( action == 0 ) {//imprimir
				if ( grid.getSelectedRowsCount() == 0 ) {
					var url_filtros = '';
					$("*.form-filter").each(function(index,el){
						if ( $(el).val() != "" ) {
							url_filtros += $(el).attr('name') + "="  + $(el).val();
							url_filtros += "&";
						};

					});

					var url = baseUrl + "Produtos/imprimir/?" + url_filtros;
					var win = window.open(url, '_blank');
					win.focus();
					return false;
				} else {
					var url_ids = '';
					$.each(grid.getSelectedRows(), function(index, el){

						url_ids += "id[]="  + el;
						url_ids += "&";

					});

					var url = baseUrl + "Produtos/imprimir/?" + url_ids;
					var win = window.open(url, '_blank');
					win.focus();
					return false;
				}
			}
			else if ( action == 3 ) {//exportar para CSV
				if ( grid.getSelectedRowsCount() == 0 ) {
					var url_filtros = '';
					$("*.form-filter").each(function(index,el){
						if ( $(el).val() != "" ) {
							url_filtros += $(el).attr('name') + "="  + $(el).val();
							url_filtros += "&";
						};

					});

					loadCSV(url_filtros);
					return false;
				} else {
					var url_ids = '';
					$.each(grid.getSelectedRows(), function(index, el){

						url_ids += "id[]="  + el;
						url_ids += "&";

					});

					loadCSV(url_ids);
					return false;
				}
			}
			else if ( action == 4 ) {//excluir
				if ( grid.getSelectedRowsCount() == 0 ) {
					App.alert({
						type: 'danger',
						icon: 'warning',
						message: 'Marque pelo menos 1 registro.',
						container: grid.getTableWrapper(),
						place: 'prepend'
					});
				} else {
					var url_ids = '';
					$.each(grid.getSelectedRows(), function(index, el){
						url_ids += "id[]="+el+"&";
					});
					$.post(baseUrl+"Agendamentos/excluiVarious/?"+url_ids,function(data){
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
							$("#table-especies").DataTable().ajax.reload();
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
						App.unblockUI('#table-especies');
					}).fail(function(jqXHR, textStatus, errorThrown){
						App.alert({
							container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
							place: "prepend", // append or prepent in container
							type: "danger", // alert's type
							message: "Ocorreu um erro ao fazer a exclusão dos agendamentos. "+errorThrown, // alert's message
							close: true, // make alert closable
							reset: true, // close all previouse alerts first
							focus: true, // auto scroll to the alert after shown
							closeInSeconds: 10, // auto close after defined seconds
							icon: "warning" // put icon before the message
						});
						App.unblockUI('#table-especies');
					});
				}
			} else if ( action == 5 ) {//reload
				grid.getDataTable().ajax.reload();
			}
		});
	*/
		
	}

	var initPickers = function(){ // init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true,
			format: 'dd/mm/yyyy',
			language: 'pt-BR'
        });
	}

	var handleValidation = function() {
		$("form#adicionar-especies button[type=submit]").click(function(e){
            e.preventDefault();
			$('form#adicionar-especies').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

		var form = $('form#adicionar-especies');
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

            // errorPlacement: function (error, element) { // render error placement for each input type
            //     var icon = $(element).parent('.input-icon').children('i');
            //     icon.removeClass('fa-check').addClass("fa-warning");
            //     icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            // },

            // highlight: function (element) { // hightlight error inputs
            //     $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
            //     tab_name = $(element).closest('.tab-pane').attr('id');
            //     $("a[href=#"+tab_name+"]").tab('show');
            // },

            // unhighlight: function (element) { // revert the change done by hightlight
            //     $(element).closest('.form-group').removeClass("has-error").addClass('has-success'); // remove error class to the control group
            // },

            // success: function (label, element) {
            //     var icon = $(element).parent('.input-icon').children('i');
            //     $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            //     icon.removeClass("fa-warning").addClass("fa-check");
            // },

            submitHandler: function (form) {
                
                var formdata = new FormData(form);
                $("form#adicionar-especies button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Adicionando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'Especies/adicionar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
                        $("form#adicionar-especies .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
						// form.reset();
                        // window.location.reload();
						$("#table-especies").DataTable().ajax.reload();
						setTimeout(function() {
							$('#addEspecie').modal('hide');
							success.hide();
						}, 2000);
                    }else if(data.status == "warning"){
                        $("form#adicionar-especies .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
						setTimeout(function() { warning.hide(); }, 2000);
                    }else if(data.status == "erro"){
                        $("form#adicionar-especies .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
						error.show();
						setTimeout(function() { error.hide(); }, 2000);
                    }
                    $("form#adicionar-especies button[type=submit]").html('<i class="fa fa-check"></i> Adicionar').removeAttr('disabled');
                    App.scrollTo($("form#adicionar-especies"), -200);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#adicionar-especies .alert-danger span.message").html("Ocorreu um erro ao adicionar a espécie. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#adicionar-especies button[type=submit]").html('<i class="fa fa-check"></i> Adicionar').removeAttr('disabled');
                    App.scrollTo(error, -200);
					setTimeout(function() { error.hide(); }, 2000);
                });
            }
        });

	}

	$('#addEspecie').on('hidden.bs.modal', function () {
		$('form#adicionar-especies').find('input[name="data[RomaneioEspecie][especie]"]').val("");
	});

	var handleValidationEdit = function() {
		$("form#alterar-especies button[type=submit]").click(function(e){
            e.preventDefault();
			$('form#alterar-especies').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

		var form = $('form#alterar-especies');
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

            // errorPlacement: function (error, element) { // render error placement for each input type
            //     var icon = $(element).parent('.input-icon').children('i');
            //     icon.removeClass('fa-check').addClass("fa-warning");
            //     icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            // },

            // highlight: function (element) { // hightlight error inputs
            //     $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
            //     tab_name = $(element).closest('.tab-pane').attr('id');
            //     $("a[href=#"+tab_name+"]").tab('show');
            // },

            // unhighlight: function (element) { // revert the change done by hightlight
            //     $(element).closest('.form-group').removeClass("has-error").addClass('has-success'); // remove error class to the control group
            // },

            // success: function (label, element) {
            //     var icon = $(element).parent('.input-icon').children('i');
            //     $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            //     icon.removeClass("fa-warning").addClass("fa-check");
            // },

            submitHandler: function (form) {
                
                var formdata = new FormData(form);
                $("form#alterar-especies button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Alterando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'Especies/alterar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
                        $("form#alterar-especies .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
						// form.reset();
                        // window.location.reload();
						$("#table-especies").DataTable().ajax.reload();
						setTimeout(function() {
							$('#editEspecie').modal('hide');
							success.hide();
						}, 2000);
                    }else if(data.status == "warning"){
                        $("form#alterar-especies .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
						setTimeout(function() { warning.hide(); }, 2000);
                    }else if(data.status == "erro"){
                        $("form#alterar-especies .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
						setTimeout(function() { error.hide(); }, 2000);
                    }
                    $("form#alterar-especies button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
                    App.scrollTo($("form#alterar-especies"), -200);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#alterar-especies .alert-danger span.message").html("Ocorreu um erro ao alterar a espécie. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#alterar-especies button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
                    App.scrollTo(error, -200);
					setTimeout(function() { error.hide(); }, 2000);
				});
            }
        });

	}

	$('#editEspecie').on('shown.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var e_id = button.data('esp-id'); // Extract info from data-* attributes
		var e_nm = button.data('esp-nm'); // Extract info from data-* attributes
		if (((e_id != "") && (e_id !== 'undefined')) && ((e_nm != "") && (e_nm !== 'undefined'))) {
			$('form#alterar-especies').find('input[name="data[RomaneioEspecie][id]"]').val(e_id);
			$('form#alterar-especies').find('input[name="data[RomaneioEspecie][especie]"]').val(e_nm);
		}
	});

	$('#editEspecie').on('hidden.bs.modal', function () {
		$('form#alterar-especies').find('input[name="data[RomaneioEspecie][id]"]').val("");
		$('form#alterar-especies').find('input[name="data[RomaneioEspecie][especie]"]').val("");
	});
	
	return { // main function to initiate the module
		init: function () {
			if (!jQuery().dataTable) { return; }
			handleRecords();
			initPickers();
			handleValidation();
			handleValidationEdit();
		}
	};

}();

$(document).ready(function() {
	Index.init();
});