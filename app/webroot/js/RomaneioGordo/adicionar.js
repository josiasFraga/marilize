var Adicionar = function () {

    // validation using icons
    var handleValidation = function() {
        $("form#adicionar-romaneio button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#adicionar-romaneio').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#adicionar-romaneio');
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
                $("form#adicionar-romaneio button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
                var confirma = true;
                if ($('#comissao_comprador_valor').val() == '0,00' && $('#comissao_comprador_porcentual').val() == '0,00'){
                    confirma = confirm("Deseja salvar com valores de comiss\u00e3o igual \u00e0 R$ 0,00?");
                }
                if (confirma) {
                    $.ajax({
                        type: "POST",
                        data: formdata,
                        url: baseUrl+'RomaneioGordo/adicionar',
                        async: true,
                        cache: false,
                        processData: false,
                        contentType: false
                    }).done(function(data){
                        if (data.status == "ok"){
                            $("form#adicionar-romaneio .alert-success span.message").html(data.msg);
                            success.show();
                            error.hide();
                            warning.hide();
                            $("form#adicionar-romaneio button[type=submit]").html('<i class="fa fa-check"></i> Salvo');
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                            // $('#outro_cadastro').show();
                        }else if(data.status == "warning"){
                            $("form#adicionar-romaneio .alert-warning span.message").html(data.msg);
                            warning.show();
                            success.hide();
                            error.hide();
                            $("form#adicionar-romaneio button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                        }else if(data.status == "erro"){
                            $("form#adicionar-romaneio .alert-danger span.message").html(data.msg);
                            warning.hide();
                            success.hide();
                            error.show();
                            $("form#adicionar-romaneio button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                        }
                        App.scrollTo($("form#adicionar-romaneio"), -200);
                    }).fail(function(jqXHR, textStatus, errorThrown){
                        success.hide();
                        warning.hide();
                        $("form#adicionar-romaneio .alert-danger span.message").html("Ocorreu um erro ao adicionar o romaneio. ("+textStatus+" - "+errorThrown+")")
                        error.show();
                        $("form#adicionar-romaneio button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                        App.scrollTo(error, -200);
                    });
                } else {
                    $("form#adicionar-romaneio button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                }
            }
        });

    }

    var initMisc = function () {
		$("select.select2").select2();
    }

    var initPickers = function(){ // init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            clearBtn: true,
            autoclose: true,
			format: 'dd/mm/yyyy',
            language: 'pt-BR',
            todayHighlight: true,
            forceParse: false, // para não deixar ser apagado pelo tab,
            // showOnFocus: false, // para evitar abrir quando focado
            allowInputToggle: true, // para quando clicar no input abrir calendario
        });
    }

    $("#rgarquivos").change(function() {
        var names = "";
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            names+= "<li>"+$(this).get(0).files[i].name+"</li>";
        }
        $("#rgarquivoshelp").html("<ul>"+names+"</ul>");
    });

    function valTotal(kg_carcaca, val_unitario) {
        // var formato = { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' };
        var formato = { minimumFractionDigits: 2 };
        var kg = parseFloat(kg_carcaca.replace(/\./g,"").replace(',', '.'));
        var un = parseFloat(val_unitario.replace(/\./g,"").replace(',', '.'));
        var total = kg * un;
        var val = parseFloat(total.toFixed(2));
        if (isNaN(val)) {
            return '0,00';
        } else {
            valorLiquido();
            return val.toLocaleString('pt-BR', formato);
        }
    }

    $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_valor_unitario]"]').on('change', function() {
        $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_valor_total]"]').val(valTotal(
            $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_kg_carcaca]"]').val(),
            $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_valor_unitario]"]').val()
        ));
        $('#media_cabeca').val($(this).val());
        valorLiquido();
        mediasRendimentos();
    });
    
    $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_valor_unitario]"]').on('change', function() {
        $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_valor_total]"]').val(valTotal(
            $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_kg_carcaca]"]').val(),
            $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_valor_unitario]"]').val()
        ));
        valorLiquido();
        mediasRendimentos();
    });

    $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_valor_unitario]"]').on('change', function() {
        $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_valor_total]"]').val(valTotal(
            $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_kg_carcaca]"]').val(),
            $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_valor_unitario]"]').val()
        ));
        valorLiquido();
        mediasRendimentos();
    });

    $('form#adicionar-romaneio .tipo_cabecas').on('change', function() {
        var a = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_cabecas]"]').val();
        var b = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_cabecas]"]').val();
        var c = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_cabecas]"]').val();
        var tot = 0;
        if (a != '') tot+= parseInt(a);
        if (b != '') tot+= parseInt(b);
        if (c != '') tot+= parseInt(c);
        $('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_cabecas]"]').val(tot);
        valorLiquido();
        mediasRendimentos();
    });

    $('form#adicionar-romaneio .tipo_kg_carcaca').on('change', function() {
        var formato = { minimumFractionDigits: 2 };
        var a = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_kg_carcaca]"]').val();
        var b = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_kg_carcaca]"]').val();
        var c = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_kg_carcaca]"]').val();
        var tot = 0;
        if (a != '') tot+= parseFloat(a.replace(/\./g,"").replace(',', '.'));
        if (b != '') tot+= parseFloat(b.replace(/\./g,"").replace(',', '.'));
        if (c != '') tot+= parseFloat(c.replace(/\./g,"").replace(',', '.'));
        var val = parseFloat(tot.toFixed(2));
        $('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_kg_carcaca]"]').val(val.toLocaleString('pt-BR', formato));
        valorLiquido();
        mediasRendimentos();
    });

    $('form#adicionar-romaneio .tipo_valor_total').on('change', function() {
        var formato = { minimumFractionDigits: 2 };
        var a = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoa_valor_total]"]').val();
        var b = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipob_valor_total]"]').val();
        var c = $('form#adicionar-romaneio input[name="data[RomaneioGordo][tipoc_valor_total]"]').val();
        var tot = 0;
        if (a != '') tot+= parseFloat(a.replace(/\./g,"").replace(',', '.'));
        if (b != '') tot+= parseFloat(b.replace(/\./g,"").replace(',', '.'));
        if (c != '') tot+= parseFloat(c.replace(/\./g,"").replace(',', '.'));
        var val = parseFloat(tot.toFixed(2));
        $('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_valor_total]"]').val(val.toLocaleString('pt-BR', formato));
        valorLiquido();
        mediasRendimentos();
    });

    $('#produtor_pessoa_id').on('change', function() {
        var escolhido = $(this).val();
        var html = '<option value="">Selecione ...</option>';
        if (escolhido != '' && escolhido !== undefined) {
            $.ajax({
				url: baseUrl + 'PessoasLocalidades/selectLocalidadeByPessoaId/' + escolhido,
				type: "POST",
				dataType: "html"
			}).done(function (resposta) {
                $('#produtor_localidade_id').html(resposta);
                $('#produtor_localidade_id').removeAttr('disabled');
			}).fail(function (jqXHR, textStatus) {
				console.log("Request failed: " + textStatus);
			}); //.always(function () { console.log("always"); });
        } else {
            $('#produtor_localidade_id').html(html);
            $('#produtor_localidade_id').attr('disabled', true);
        }
    });

    function valorLiquido() {
        var formato = { minimumFractionDigits: 2 };
        var totais = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_valor_total]"]').val().replace(/\./g,"").replace(',', '.'));
        var valr = parseFloat($('#desconto-funrural-val').val().replace(/\./g,"").replace(',', '.'));
        var vald = parseFloat($('#desconto-fundesa-val').val().replace(/\./g,"").replace(',', '.'));
        var diminuir = 0.0;
        if (!isNaN(valr)) {
            diminuir+= valr;
        }
        if (!isNaN(vald)) {
            diminuir+= vald;
        }
        var liquido = totais - diminuir;
        var retorno = parseFloat(liquido.toFixed(2));
        if (!isNaN(retorno)) {
            $('#valor-total-liquido').val(retorno.toLocaleString('pt-BR', formato));
        }
        $('#comissao_comprador_valor').val(porcentagem($('#comissao_comprador_porcentual').val(), null));
        $('#comissao_comprador_porcentual').val(porcentagem(null, $('#comissao_comprador_valor').val()));
    }

    function porcentagem(pper, pval) {
        var retorno = 0.0;
        var totais = $('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_valor_total]"]').val();
        var tot = parseFloat(totais.replace(/\./g,"").replace(',', '.'));
        var total = 0.0;
        var retorno = 0.0;
        if (pper) {
            var per = parseFloat(pper.replace(/\./g,"").replace(',', '.'));
            total = (tot * per) / 100;
            retorno = parseFloat(total.toFixed(2));
            if (!isNaN(retorno)) {
                return retorno.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            }
        }
        if (pval) {
            var val = parseFloat(pval.replace(/\./g,"").replace(',', '.'));
            total = (val * 100) / tot;
            retorno = parseFloat(total.toFixed(2));
            if (!isNaN(retorno)) {
                return retorno.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            }
        }
        return '0,00';
    }

    $('#desconto-funrural-per').on('change', function() {
        $('#desconto-funrural-val').val(porcentagem($(this).val(), null));
        valorLiquido();
        mediasRendimentos();
    });
    $('#desconto-funrural-val').on('change', function() {
        $('#desconto-funrural-per').val(porcentagem(null, $(this).val()));
        valorLiquido();
        mediasRendimentos();
    });

    $('#desconto-fundesa-per').on('change', function() {
        $('#desconto-fundesa-val').val(porcentagem($(this).val(), null));
        valorLiquido();
        mediasRendimentos();
    });
    $('#desconto-fundesa-val').on('change', function() {
        $('#desconto-fundesa-per').val(porcentagem(null, $(this).val()));
        valorLiquido();
        mediasRendimentos();
    });

    function mediasRendimentos() {
        var formato = { minimumFractionDigits: 2 };
        var totais_kg_carcaca = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_kg_carcaca]"]').val().replace(/\./g,"").replace(',', '.'));
        var peso_fazenda_total = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][peso_fazenda_total]"]').val().replace(/\./g,"").replace(',', '.'));
        var peso_frigorifico = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][peso_frigorifico]"]').val().replace(/\./g,"").replace(',', '.'));
        var totais_cabecas = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][totais_cabecas]"]').val().replace(/\./g,"").replace(',', '.'));
        
        var res1 = totais_kg_carcaca / totais_cabecas;
        var ret1 = parseFloat(res1.toFixed(2));
        if (!isNaN(ret1)) $('#media_carcaca').val(ret1.toLocaleString('pt-BR', formato));

        var res2 = peso_fazenda_total / totais_cabecas;
        var ret2 = parseFloat(res2.toFixed(2));
        if (!isNaN(ret2)) $('#media_fazenda').val(ret2.toLocaleString('pt-BR', formato));

        var res3 = peso_frigorifico / totais_cabecas;
        var ret3 = parseFloat(res3.toFixed(2));
        if (!isNaN(ret3)) $('#media_frigorifico').val(ret3.toLocaleString('pt-BR', formato));

        var res4 = (totais_kg_carcaca / peso_frigorifico) * 100;
        var ret4 = parseFloat(res4.toFixed(2));
        if (!isNaN(ret4)) $('#rendimento_frigorifico').val(ret4.toLocaleString('pt-BR', formato));

        var res5 = (totais_kg_carcaca / peso_fazenda_total) * 100;
        var ret5 = parseFloat(res5.toFixed(2));
        if (!isNaN(ret5)) $('#rendimento_fazenda').val(ret5.toLocaleString('pt-BR', formato));
        
        var res6 = 100 - ((peso_frigorifico * 100) / peso_fazenda_total);
        var ret6 = parseFloat(res6.toFixed(2));
        if (!isNaN(ret6)) $('#rendimento_quebra').val(ret6.toLocaleString('pt-BR', formato));
    }

    $('form#adicionar-romaneio input[name="data[RomaneioGordo][peso_fazenda_total]"]').on('change', function () {
        mediasRendimentos();
    });
    $('form#adicionar-romaneio input[name="data[RomaneioGordo][peso_frigorifico]"]').on('change', function () {
        mediasRendimentos();
    });

    function comissaoValor() {
        var formato = { minimumFractionDigits: 2 };
        var valor_total_liquido = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][valor_liquido]"]').val().replace(/\./g,"").replace(',', '.'));
        var comissao = parseFloat($('form#adicionar-romaneio input[name="data[RomaneioGordo][comissao_comprador_porcentual]"]').val().replace(/\./g,"").replace(',', '.'));
        var receber = (valor_total_liquido * comissao) / 100;
        var retorno = parseFloat(receber.toFixed(2));
        if (!isNaN(retorno)) $('#comissao_comprador_valor').val(retorno.toLocaleString('pt-BR', formato));
    }

    $('form#adicionar-romaneio input[name="data[RomaneioGordo][comissao_comprador_porcentual]"]').on('change', function () {
        $('#comissao_comprador_valor').val(porcentagem($(this).val(), null));
    });
    $('form#adicionar-romaneio input[name="data[RomaneioGordo][comissao_comprador_valor]"]').on('change', function () {
        $('#comissao_comprador_porcentual').val(porcentagem(null, $(this).val()));
    });

    $('#data_emissao').on('change', function () {
        adicionarDiasData();
        $('#comissao_comprador_data_pgto').val(adicionarDiasData());
    });

    function adicionarDiasData() {
        var dias = parseInt($('#prazo_pgto_dias').val());
        var data = $('#data_emissao').val().split('/');

        var hoje = new Date();
        if (data != undefined && data != '') {
            hoje = new Date(data[2], (data[1]-1), data[0]);
        }

        var dataVenc = new Date(hoje.getTime());
        if (dias != undefined && dias > 0 && dias != '') {
            dataVenc = new Date(hoje.getTime() + (dias * 24 * 60 * 60 * 1000));
        }

        var retorno = '';
        if ((dataVenc.getDate()) > 9) {
            retorno = dataVenc.getDate();
        } else {
            retorno = "0" + dataVenc.getDate();
        }
        if ((dataVenc.getMonth() + 1) > 9) {
            retorno = retorno + "/" + (dataVenc.getMonth() + 1);
        } else {
            retorno = retorno + "/0" + (dataVenc.getMonth() + 1);
        }
        return retorno = retorno + "/" + dataVenc.getFullYear();
    }

    $('#comissao_comprador_data_pgto').on('change', function (e) {
        e.preventDefault();
        $('#prazo_pgto_dias').val('');
    });

    $('#prazo_pgto_dias').on('change', function () {
        $('#comissao_comprador_data_pgto').val(adicionarDiasData());
    });

    var inputs = $("input,select");
    $('.selectnext').on('change', function () {
        var escolhido = $(this).val();
        if (escolhido != '' && escolhido !== undefined) {
            var pos = $(inputs).index(this) + 1;
            var next = $(inputs).eq(pos);
            next.focus();
            if (next.siblings(".select2").length) {
                setTimeout( function() { next.select2("focus"); }, 300);
            } else {
                setTimeout( function() { next.select(); }, 300);
            }
        }
    });

    return { // main function to initiate the module
        init: function () {
            handleValidation();
            initMisc();
            initPickers();
            
            /*Dropzone.options.myDropzone = {
                dictDefaultMessage: "",
                init: function() {
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remover</a>");
                        
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                }            
            }*/
        }

    };
    
}();

$(document).ready(function(){
    Adicionar.init();
});