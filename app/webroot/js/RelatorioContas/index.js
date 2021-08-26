var Alterar = function () {

    // validation using icons
    var handleValidation = function() {
        $("form#gerar button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#gerar').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#gerar');
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
                $("form#gerar button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Gerando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'RelatorioPagamentos/relatorio',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data) {
                    if (data.status == "ok") {
                        $("form#gerar .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        setTimeout( function () {
                            window.open(baseUrl+'RelatorioPagamentos/imprimir', "_blank");
                        }, 1500);
                    } else if(data.status == "warning") {
                        $("form#gerar .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    } else if(data.status == "erro") {
                        $("form#gerar .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    setTimeout( function () {
                        success.hide();
                        error.hide();
                        warning.hide();
                    }, 5000);
                    $("form#gerar button[type=submit]").html('Gerar').removeAttr('disabled');
                    App.scrollTo($("form#gerar"), -200);

                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#gerar .alert-danger span.message").html("Ocorreu um erro ao gerar. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#gerar button[type=submit]").html('Gerar').removeAttr('disabled');
                    App.scrollTo(error, -200);
                });
            }
        });

    }
    
    var initMisc = function () {
        $('.select').select2();
    }

    var initMasks = function(){
        $("input.cep").keyup(function(){mascara( this, mcep )});
        $("input.cpf").keyup(function(){mascara( this, mcpf )});
        $("input.cnpj").keyup(function(){mascara( this, cnpj )});
        $("input.phone").keyup(function(){mascara( this, mtel )});
        $("input.moeda").keyup(function () { mascara(this, mvalor) });
        $("input.numero").keyup(function () { mascara(this, mnum) });
        $("input.databr").keyup(function () { mascara(this, mdata )});
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
    
    $('#status_pagto').change(function(){
        let valor = $(this).val();  
        if (valor == 3) { // se pago, mostra input data para adicionar data pago
            $('#data_pagto').removeClass('hide');
        } else {
            $('#data_pagto').addClass('hide');
        }
    });

    return {

        //main function to initiate the module
        init: function () {
            handleValidation();
            initMisc();
            initMasks();
            initPickers();
        }

    };
    
}();

$(document).ready(function(){
    Alterar.init();
    // BAR CHART
    new Morris.Bar({
        element: 'morris_chart_3',
        data: dados,
        xkey: 'mes',
        ykeys: ['e', 's'],
        labels: ['Entrada', 'Saída'],
        barColors: ['#2ab4c0', '#f36a5a']
    });
});