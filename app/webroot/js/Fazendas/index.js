var Index = function () {

	var grid = new Datatable();
    
    var initDelete = function () {
		$('#table-fazendas').on('click', 'a.btn-remove', function(ev){
            ev.preventDefault();
            var este = $(this);
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
							target: '#table-fazendas',
							boxed: true,
							message: 'Excluindo, aguarde...'
						});
						$.post(baseUrl+"Fazendas/excluir/"+param1,function(data){
							if (data.status == "ok") {
                                $("#table-fazendas").DataTable().ajax.reload();
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
							App.unblockUI('#table-fazendas');
						}).fail(function(jqXHR, textStatus, errorThrown){
							App.alert({
								container: "div.portlet-body", // alerts parent container(by default placed after the page breadcrumbs)
								place: "prepend", // append or prepent in container
								type: "danger", // alert's type
								message: "Ocorreu um erro ao fazer a exclusão do cliente. "+errorThrown, // alert's message
								close: true, // make alert closable
								reset: true, // close all previouse alerts first
								focus: true, // auto scroll to the alert after shown
								closeInSeconds: 10, // auto close after defined seconds
								icon: "warning" // put icon before the message
							});
							App.unblockUI('#table-fazendas');
						});
					}
				}
			})
		})
    }

	var handleRecords = function () {

		grid.init({
			src: $("#table-fazendas"),
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
                {},
                {"sClass": "text-center"},
                {},
                {'bSortable' : false},
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
					"url": baseUrl+"Fazendas/index", // ajax source
				},
				"order": [
					[1, "asc"]
				] // set first column as a default sort by asc
			}
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
						$("#table-fazendas").DataTable().ajax.reload();
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

	return { // main function to initiate the module
		init: function () {
			if (!jQuery().dataTable) { return; }
			handleRecords();
			handleValidation();
            initDelete();
		}
	};

}();

$(document).ready(function() {
	Index.init();
});