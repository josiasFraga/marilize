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
                var confirma = true;
                if (($('#comissao_comprador_valor').val() == '0,00' && $('#comissao_comprador_porcentual').val() == '0,00') || 
                    ($('#comissao_vendedor_valor').val() == '0,00' && $('#comissao_vendedor_porcentual').val() == '0,00')) {
                    confirma = confirm("Deseja salvar com valores de comiss\u00e3o igual \u00e0 R$ 0,00?");
                }
                if (confirma) {
                    $.ajax({
                        type: "POST",
                        data: formdata,
                        url: baseUrl+'RomaneioInvernar/adicionar',
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
            clearBtn: true,
            rtl: App.isRTL(),
            autoclose: true,
			format: 'dd/mm/yyyy',
            language: 'pt-BR',
            todayHighlight: true,
            forceParse: false, // para não deixar ser apagado pelo tab
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

    $('#comprador_pessoa_id').on('change', function() {
        var escolhido = $(this).val();
        var html = '<option value="">Selecione ...</option>';
        if (escolhido != '' && escolhido !== undefined) {
            $.ajax({
				url: baseUrl + 'PessoasLocalidades/selectLocalidadeByPessoaId/' + escolhido,
				type: "POST",
				dataType: "html"
			}).done(function (resposta) {
                $('#comprador_localidade_id').html(resposta);
                $('#comprador_localidade_id').removeAttr('disabled');
			}).fail(function (jqXHR, textStatus) {
				console.log("Request failed: " + textStatus);
			}); //.always(function () { console.log("always"); });
        } else {
            $('#comprador_localidade_id').html(html);
            $('#comprador_localidade_id').attr('disabled', true);
        }
    });

    $('#vendedor_pessoa_id').on('change', function() {
        var escolhido = $(this).val();
        var html = '<option value="">Selecione ...</option>';
        if (escolhido != '' && escolhido !== undefined) {
            $.ajax({
				url: baseUrl + 'PessoasLocalidades/selectLocalidadeByPessoaId/' + escolhido,
				type: "POST",
				dataType: "html"
			}).done(function (resposta) {
                $('#vendedor_localidade_id').html(resposta);
                $('#vendedor_localidade_id').removeAttr('disabled');
			}).fail(function (jqXHR, textStatus) {
				console.log("Request failed: " + textStatus);
			}); //.always(function () { console.log("always"); });
        } else {
            $('#vendedor_localidade_id').html(html);
            $('#vendedor_localidade_id').attr('disabled', true);
        }
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
            return val.toLocaleString('pt-BR', formato);
        }
    }

    $('div#form-especies input[name="data[aux][RomaneioInvernar_peso_fazenda]"]').on('change', function() {
        $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_total]"]').val(valTotal(
            $('div#form-especies input[name="data[aux][RomaneioInvernar_peso_fazenda]"]').val(),
            $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_unitario]"]').val()
        ));
    });

    $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_unitario]"]').on('change', function() {
        $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_total]"]').val(valTotal(
            $('div#form-especies input[name="data[aux][RomaneioInvernar_peso_fazenda]"]').val(),
            $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_unitario]"]').val()
        ));
    });

    function calculos() {
        var totais_kg_carcaca = 0.0;
        $('.dados-peso').each(function() {
            var peso_fazenda = parseFloat($(this).val().replace(/\./g,"").replace(',', '.'));
            totais_kg_carcaca+= peso_fazenda;
        });

        var totais_cabecas = 0.0;
        $('.dados-cabecas').each(function() {
            var cabecas = parseFloat($(this).val().replace(/\./g,"").replace(',', '.'));
            totais_cabecas+= cabecas;
        });

        var index = 0;
        var totais_valor_unitario = 0.0;
        $('.dados-valor_unitario').each(function() {
            var valor_unitario = parseFloat($(this).val().replace(/\./g,"").replace(',', '.'));
            totais_valor_unitario+= valor_unitario;
            index++;
        });

        var totais_valor = 0.0;
        $('.dados-valor_total').each(function() {
            var valor_total = parseFloat($(this).val().replace(/\./g,"").replace(',', '.'));
            totais_valor+= valor_total;
        });

        var res1 = totais_kg_carcaca / totais_cabecas;
        var ret1 = parseFloat(res1.toFixed(2));
        if (!isNaN(ret1)) {
            $('#media_carcaca').val(ret1.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
        } else {
            $('#media_carcaca').val('');
        }

        var res2 = totais_valor_unitario / index;
        var ret2 = parseFloat(res2.toFixed(2));
        if (!isNaN(ret2)) {
            $('#media_cabeca').val(ret2.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
        } else {
            $('#media_cabeca').val('');
        }

        var peso = parseFloat(totais_kg_carcaca.toFixed(2));
        if (!isNaN(peso)) {
            $('#peso_fazenda_total').val(peso.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
        } else {
            $('#peso_fazenda_total').val('0,00');
        }

        var valor_liquido = parseFloat(totais_valor.toFixed(2));
        if (!isNaN(valor_liquido)) {
            $('#valor_liquido').val(valor_liquido.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
        } else {
            $('#valor_liquido').val('0,00');
        }

        $('#comissao_comprador_valor').val(porcentagem($('#comissao_comprador_porcentual').val(), null));
        $('#comissao_comprador_porcentual').val(porcentagem(null, $('#comissao_comprador_valor').val()));
        $('#comissao_vendedor_valor').val(porcentagem($('#comissao_vendedor_porcentual').val(), null));
        $('#comissao_vendedor_porcentual').val(porcentagem(null, $('#comissao_vendedor_valor').val()));
    }

    var complementoEspecies = function() {
        var index = 0;
        $('#btn-add-especie').click(function (event) {
			event.preventDefault();

			var RomaneioInvernar_especie_id_val = $('#RomaneioInvernar_especie_id option:selected').val();
			var RomaneioInvernar_especie_id_text = $('#RomaneioInvernar_especie_id option:selected').text();
			var RomaneioInvernar_peso_fazenda = $('div#form-especies input[name="data[aux][RomaneioInvernar_peso_fazenda]"]').val();
			var RomaneioInvernar_cabecas = $('div#form-especies input[name="data[aux][RomaneioInvernar_cabecas]"]').val();
			var RomaneioInvernar_valor_unitario = $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_unitario]"]').val();
            var RomaneioInvernar_valor_total = $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_total]"]').val();     
            
            var html = "";

			if (RomaneioInvernar_especie_id_val == "" || RomaneioInvernar_peso_fazenda == "" || RomaneioInvernar_cabecas == "" || RomaneioInvernar_valor_unitario == "" || RomaneioInvernar_valor_total == "") {
				alert("Os campos devem ser preenchidos para adicionar a esp\u00e9cie!");
            } else {
                html+= "<tr>";
                html+= "<input type='hidden' class='dados-especie_id' name='data[RomaneioItem]["+index+"][especie_id]' value='"+RomaneioInvernar_especie_id_val+"'>";
                html+= "<input type='hidden' class='dados-peso' name='data[RomaneioItem]["+index+"][peso]' value='"+RomaneioInvernar_peso_fazenda+"'>";
                html+= "<input type='hidden' class='dados-cabecas' name='data[RomaneioItem]["+index+"][cabecas]' value='"+RomaneioInvernar_cabecas+"'>";
                html+= "<input type='hidden' class='dados-valor_unitario' name='data[RomaneioItem]["+index+"][valor_unitario]' value='"+RomaneioInvernar_valor_unitario+"'>";
                html+= "<input type='hidden' class='dados-valor_total' name='data[RomaneioItem]["+index+"][valor_total]' value='"+RomaneioInvernar_valor_total+"'>";

                html+= "<td>"+RomaneioInvernar_especie_id_text+"</td>";
                html+= "<td>"+RomaneioInvernar_peso_fazenda+"</td>";
                html+= "<td>"+RomaneioInvernar_cabecas+"</td>";
                html+= "<td>"+RomaneioInvernar_valor_unitario+"</td>";
                html+= "<td>"+RomaneioInvernar_valor_total+"</td>";
                html+= "<td><button type='button' class='btn btn-danger btn-icon-only' id='btn-del-especie'><i class='fa fa-trash'></i></button></td>";
                html+= "</tr>";
                $('table#table-especies').append(html);

                $('#RomaneioInvernar_especie_id').val('').trigger('change');
                $('div#form-especies input[name="data[aux][RomaneioInvernar_peso_fazenda]"]').val('');
			    $('div#form-especies input[name="data[aux][RomaneioInvernar_cabecas]"]').val('');
			    $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_unitario]"]').val('');
			    $('div#form-especies input[name="data[aux][RomaneioInvernar_valor_total]"]').val('');
                index++;

                calculos();
            }

        });
        
        $('table#table-especies').on('click', '#btn-del-especie', function (e) {
			e.preventDefault();
            $(this).closest('tr').remove();
            calculos();
		});

    }

    $('#data_emissao').on('change', function () {
        datasComissoes();
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
    $('#comissao_vendedor_data_pgto').on('change', function (e) {
        e.preventDefault();
        $('#prazo_pgto_dias').val('');
    });

    function datasComissoes() {
        $('#comissao_comprador_data_pgto').val(adicionarDiasData());
        $('#comissao_vendedor_data_pgto').val(adicionarDiasData());
    }

    $('#prazo_pgto_dias').on('change', function () {
        datasComissoes();
    });

    function porcentagem(pper, pval) {
        var retorno = 0.0;
        var totais = $('#valor_liquido').val();
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
    
    $('#comissao_comprador_porcentual').on('change', function () {
        $('#comissao_comprador_valor').val(porcentagem($(this).val(), null));
    });
    $('#comissao_comprador_valor').on('change', function () {
        $('#comissao_comprador_porcentual').val(porcentagem(null, $(this).val()));
    });

    $('#comissao_vendedor_porcentual').on('change', function () {
        $('#comissao_vendedor_valor').val(porcentagem($(this).val(), null));
    });
    $('#comissao_vendedor_valor').on('change', function () {
        $('#comissao_vendedor_porcentual').val(porcentagem(null, $(this).val()));
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
            complementoEspecies();

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