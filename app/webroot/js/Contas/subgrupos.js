var Subgrupos = function () {

	var grid = new Datatable();

	var initDelete = function () {
		$('#table-subgrupos').on('click', 'a.btn-remove', function(ev){
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
							target: '#table-subgrupos',
							boxed: true,
							message: 'Excluindo, aguarde...'
						});
						$.post(baseUrl +"Contas/excluir_subgrupo/"+param1,function(data){
							if (data.status == "ok")
								$("#table-subgrupos").DataTable().ajax.reload();
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
							App.unblockUI('#table-subgrupos');
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
							App.unblockUI('#table-subgrupos');
						});
					}
				}
			})
		})
	}

	var handleRecords = function () {

		grid.init({
			src: $("#table-subgrupos"),
			onSuccess: function (grid) {
				// execute some code after table records loaded
				//initMasks();
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
				{  },
				{  },
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
					"url": baseUrl +"Contas/subgrupos", // ajax source
				},
				"order": [
					[1, "asc"]
				] // set first column as a default sort by asc
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
		$('#table-subgrupos').on('click', 'a.btn-pagar', function (ev) {
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
							target: '#table-subgrupos',
							boxed: true,
							message: 'Executando, aguarde...'
						});
						$.post(baseUrl + "ContasPagar/pagamento/" + param1, function (data) {
							if (data.status == "ok") {
								// $("#table-subgrupos .alert-success span.message").html(data.msg);
								console.log(data.msg);
								$("#table-subgrupos").DataTable().ajax.reload();
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
							App.unblockUI('#table-subgrupos');
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
							App.unblockUI('#table-subgrupos');
						});
					}
				}
			})
		})
	}

	return {
		//main function to initiate the module
		init: function () {
			if (!jQuery().dataTable) { return; }
			handleRecords();
			initDelete();
			// initPago();
			// handleSample();
		}
	};
	
}();

$(document).ready(function() {
	Subgrupos.init();
	// $('[data-toggle="popover"]').popover();
});