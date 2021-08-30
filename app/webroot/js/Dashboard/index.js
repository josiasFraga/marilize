var Index = function () {

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

	
	var handleValidationAlterarPagar = function() {
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
					url: baseUrl+'ContasReceber/edit_data_pago',
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
                        // form.reset();
						document.location.reload(true);
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
					$("form#alterar-pagar .alert-danger span.message").html("Ocorreu um erro ao alterar a conta à receber. ("+textStatus+" - "+errorThrown+")")
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
			$('#viewDataPago').load(baseUrl + 'ContasReceber/view_data_pago/' + recipient, function () {});
		}
	});

	$('#modalAddPagamento').on('shown.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var recipient = button.data('whatever'); // Extract info from data-* attributes
		if ((recipient != "") && (recipient !== 'undefined')) {
			$('#addDataPago').html('<input type="hidden" name="data[PagamentoData][id]" value="'+recipient+'" />');
		}
	});

	return {
		//main function to initiate the module
		init: function () {
			
			initPickers();
			handleValidationAlterarPagar();
			// initPago();
			// handleSample();
		}
	};
	
}();

$(document).ready(function() {
	Index.init();
	// $('[data-toggle="popover"]').popover();
});