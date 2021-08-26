var Adicionar = function () {
    var handleParcelas = function() {
        //$('#parcelas').modal('toggle');
        $('#alterar_parcelas').click(function() {
            $('#parcelas').modal('toggle');
        });

        var possuiParcelas = function() {
            parcelas = $('input[name="data[nparcelas]"]').val();
            if (parcelas == '' || parcelas == '1') {
                return false;
            }
            
            return true;
        }
        
        $('.date-picker-vencimento').datepicker({
            rtl: App.isRTL(),
            autoclose: true,
			format: 'dd/mm/yyyy',
            language: 'pt-BR',
            todayHighlight: true
        }).on('changeDate', function() {
            if (possuiParcelas()) {
                mostrarParcelas();
                alert("As parcelas foram geradas novamente!");
            }
        });

        $('input[name="data[nparcelas]"]').change(function() {
            parcelas = $(this).val();
            $('#parcelas .modal-body').html("");

            if (!possuiParcelas()) {
                $('#alterar_parcelas').attr('disabled', 'disabled');
            } else {
                var data_vencimento = $('input[name="data[PagamentoData][data_venc]"]').val();
                var valor_total = $('input[name="data[PagamentoData][valor]"]').val();
                if (data_vencimento == '' || valor_total == '') {
                    $(this).val("1");
                    alert("Digite a data de vencimento e o valor!");
                    return false;
                }

                $('#alterar_parcelas').removeAttr('disabled');
                mostrarParcelas();
            }
        });

        $('input[name="data[PagamentoData][valor]"]').change(function() {
            if (possuiParcelas()) {
                mostrarParcelas();
                alert("As parcelas foram geradas novamente!");
            }
        });

        $('#parcelas .modal-body').on('click', '.gerar-proximas-parcelas', function() {
            // esta função pega a data da linha do botão que foi clicado
            // e todas próximas datas são geradas a partir dela.

            var primeira_data = $(this).closest('div.parcela-dados').find('input.data-parcela').val();

            $.each($(this).closest('div.parcela-dados').nextAll('div.parcela-dados'), function(key, val) {
                var data_parcela = moment(primeira_data, "DD/MM/YYYY").add((key+1), 'M').format("DD/MM/YYYY");

                $(val).find('input.data-parcela').val(data_parcela);

            });
        });
        
        var mostrarParcelas = function() {
            var nparcelas = parseInt($('input[name="data[nparcelas]"]').val());
            var parcelas = [];
            // @todo; salvar
            // @todo; não permitir salvar se valor das parcelas não fechar com valor total
            // @todo; modal p/ revisar antes de salvar
            var data_venc = $('input[name="data[PagamentoData][data_venc]"]').val();

            var valor_total = stringToFloat($('input[name="data[PagamentoData][valor]"]').val());
            var valor_parcela = (Math.floor((valor_total / nparcelas) * 100) / 100);

            var diferenca_parcela_total = valor_total - (valor_parcela * nparcelas);
            if (diferenca_parcela_total > 0) {
                valor_primeira_parcela = valor_parcela + diferenca_parcela_total;
            } else {
                valor_primeira_parcela = valor_parcela;
            }

            for (i = 0; i < nparcelas; i++) {
                var data_parcela = moment(data_venc, "DD/MM/YYYY").add(i, 'M').format("DD/MM/YYYY");

                if (i == 0) {
                    parcelas.push({data: data_parcela,valor: number_format(valor_primeira_parcela, 2, ',', '.')})
                } else {
                    parcelas.push({data: data_parcela,valor: number_format(valor_parcela, 2, ',', '.')})

                }
            }
            $('#parcelas .modal-body').html("");

            $.each(parcelas, function(key, val) {
                if (key > 0) {
                    var structure_parcela = [
                        '<div class="parcela-dados">',
                            '<div class="form-group col-md-5">',
                                '<label class="control-label">['+(key+1)+'] Data: <span class="required">*</span></label>',
                                '<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">',
                                    '<input type="text" class="form-control data-parcela" name="data[parcelas]['+key+'][data]" value="'+val.data+'" readonly />',
                                    '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>',
                                '</div>',
                            '</div>',
                            '<div class="form-group col-md-5">',
                                '<label class="control-label">Valor: <span class="required">*</span></label>',
                                '<input class="form-control moeda valor-parcela" name="data[parcelas]['+key+'][valor]" value="'+val.valor+'" />',
                            '</div>',
                            '<div class="col-md-2" style="padding-left: 0px">',
                                '<button type="button" class="btn green gerar-proximas-parcelas" title="Gerar próximas parcelas a partir desta data" style="margin-top: 25px"><i class="fa fa-refresh"></i></button>',
                            '</div>',
                            '<div class="clearfix"></div>',
                        '</div>',
                    ];
                } else {
                    var structure_parcela = [
                        '<div class="parcela-dados">',
                            '<div class="form-group col-md-5">',
                                '<label class="control-label">['+(key+1)+'] Data: <span class="required">*</span></label>',
                                '<input type="text" class="form-control" readonly name="data[parcelas]['+key+'][data]" value="'+val.data+'" />',
                            '</div>',
                            '<div class="form-group col-md-5">',
                                '<label class="control-label">Valor: <span class="required">*</span></label>',
                                '<input class="form-control moeda valor-parcela" name="data[parcelas]['+key+'][valor]" value="'+val.valor+'" />',
                            '</div>',
                            '<div class="col-md-2" style="padding-left: 0px">',
                                '<button type="button" class="btn green gerar-proximas-parcelas" title="Gerar próximas parcelas a partir desta data" style="margin-top: 25px"><i class="fa fa-refresh"></i></button>',
                            '</div>',
                            '<div class="clearfix"></div>',
                        '</div>',
                    ];
                }
                
                $(structure_parcela.join('')).appendTo($('#parcelas .modal-body'));
                initPickers();
                initMasks();
            });
        }
    }

    // validation using icons
    var handleValidation = function() {
        $("form#adicionar-contap button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#adicionar-contap').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#adicionar-contap');
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
                var nparcelas = $('input[name="data[nparcelas]"]').val();
                var valor_total = stringToFloat($('input[name="data[PagamentoData][valor]"]').val());

                if (nparcelas != '' && nparcelas > 1) {
                    var total_parcelas = 0;
                    $.each($('#parcelas .modal-body').find('.valor-parcela'), function(key, val) {
                        total_parcelas += stringToFloat($(val).val());
                    });

                    if (total_parcelas.toFixed(2) !== valor_total.toFixed(2)) {
                        alert("Os valores das parcelas não são iguais ao valor total!");
                        return;
                    }
                }
                var formdata = new FormData(form);
                $("form#adicionar-contap button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl +'ContasPagar/adicionar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
                        $("form#adicionar-contap .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        location.reload();
                        $('#outra_conta').show();
                        $('#status_pagto').val("");
                        // form.reset();
                    }else if(data.status == "warning"){
                        
                        $("form#adicionar-contap .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    }else if(data.status == "erro"){
                        $("form#adicionar-contap .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }

                    $("form#adicionar-contap button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                    App.scrollTo($("form#adicionar-contap"), -200);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#adicionar-contap .alert-danger span.message").html("Ocorreu um erro ao adicionar o conta à pagar. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#adicionar-contap button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                    App.scrollTo(error, -200);
                });
            }
        });

    }
    
    var initMisc = function () {
        $('.select2').select2();
    }

    var initMasks = function(){
        $("input.cep").keyup(function(){mascara( this, mcep )});
        $("input.cpf").keyup(function(){mascara( this, mcpf )});
        $("input.cnpj").keyup(function(){mascara( this, cnpj )});
        $("input.phone").keyup(function () { mascara(this, mtel) });
        $("input.databr").keyup(function () { mascara(this, mdata )});
        $("input.moeda").keyup(function () { mascara(this, mvalor) });
        $("input.numero").keyup(function () { mascara(this, mnum) });
    }

    var stringToFloat = function(value) {
        return parseFloat(value.replace(".", "").replace(",", "."));
    }

    var number_format = function (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
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
            handleParcelas();
        }

    };
    
}();

$(document).ready(function(){
    Adicionar.init();
});