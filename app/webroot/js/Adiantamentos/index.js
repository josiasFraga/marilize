var Index = function () {

	var grid = new Datatable();

	var initDelete = function () {
		$('#table-adiantamentos').on('click', 'a.btn-remove', function(ev){
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
							target: '#table-adiantamentos',
							boxed: true,
							message: 'Excluindo, aguarde...'
						});
						$.post(baseUrl +"Adiantamentos/excluir/"+param1,function(data){
							if (data.status == "ok")
								$("#table-adiantamentos").DataTable().ajax.reload();
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
							App.unblockUI('#table-adiantamentos');
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
							App.unblockUI('#table-adiantamentos');
						});
					}
				}
			})
		})
	}

	var initPrint = function () {
		$('a#imprimir').unbind();
		$('a#imprimir').on('click', function(ev){
			ev.preventDefault();
			var dados = [];
			$.each($('input.form-filter'),function(index,el){
				let input_name = $(el).prop('name');
				dados[input_name] =  $(el).val();
			});

			dados = Object.assign({}, dados);
			dados_params = $.param(dados);
			let url = baseUrl+"Adiantamentos/imprimir/?" + dados_params;
			window.open(url, '_blank');
			
			/*$(document).on('click', 'a', function(e){ 
				e.preventDefault(); 
				window.open(url, '_blank');
			});*/
		})
	}

	var handleRecords = function () {

	
			grid.init({
				src: $("#table-adiantamentos"),
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
					{ 'bSortable' : false, "sClass": "text-center" },
					{ },
					{ },
					{ "sClass": "text-center" },
					{ },
					{ },
					{  },
					{ 'bSortable' : false},
					{ 'bSortable' : false, "sClass": "text-center" },
				],
	
					"bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
					"sDom": "t<'row'<'col-md-8 col-sm-12'pi><'col-md-4 col-sm-12'>>",
	
					"lengthMenu": [
						[10, 20, 50, 100, 150, -1],
						[10, 20, 50, 100, 150, "All"] // change per page values here
					],
					"pageLength": 10, // default record count per page
					"ajax": {
						"url": baseUrl+"Adiantamentos/index", // ajax source
					},
					"order": [
						[1, "desc"]
					] // set first column as a default sort by asc
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

	var initMasks = function () {
		$("input.cep").keyup(function () { mascara(this, mcep) });
		$("input.cpf").keyup(function () { mascara(this, mcpf) });
		$("input.cnpj").keyup(function () { mascara(this, cnpj) });
		$("input.phone").keyup(function () { mascara(this, mtel) });
		$("input.databr").keyup(function () { mascara(this, mdata) });
		$("input.moeda").keyup(function () { mascara(this, mvalor) });

		/*$(".select2").select2({
			placeholder: "Selecione..",
			width: 'element',
			allowClear: true
		});*/
	}

	return {
		//main function to initiate the module
		init: function () {
			if (!jQuery().dataTable) { return; }
			handleRecords();
			initDelete();
			initPickers();
			initMasks();
			initPrint();
			//handleValidationAlterar();
			// initPago();
			// handleSample();
		}
	};
	
}();

$(document).ready(function() {
	Index.init();
	// $('[data-toggle="popover"]').popover();
});