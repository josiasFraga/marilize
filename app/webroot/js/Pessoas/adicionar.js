var Adicionar = function () {

    // validation using icons
    var handleValidation = function() {
        $("form#adicionar-pessoa button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#adicionar-pessoa').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#adicionar-pessoa');
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
                $("form#adicionar-pessoa button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'Pessoas/adicionar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
                        $("form#adicionar-pessoa .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        $('#outro_cadastro').show();
                    }else if(data.status == "warning"){
                        $("form#adicionar-pessoa .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    }else if(data.status == "erro"){
                        $("form#adicionar-pessoa .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    $("form#adicionar-pessoa button[type=submit]").html('<i class="fa fa-check"></i> Salvar Alterações').removeAttr('disabled');
                    App.scrollTo($("form#adicionar-pessoa"), -200);

                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#adicionar-pessoa .alert-danger span.message").html("Ocorreu um erro ao adicionar a pessoa. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#adicionar-pessoa button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                    App.scrollTo(error, -200);
                });
            }
        });

    }
    
    var limpaCampos =  function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#uf").val("");
        $("#cidade").val("");
        $("#bairro").val("");
        $("#logradouro").val("");
        $("#complemento").val("");
    }

     //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");
                $("#logradouro").val("...");
                $("#complemento").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                        $("#logradouro").val(dados.logradouro);
                        $("#complemento").val(dados.complemento);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpaCampos();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpaCampos();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpaCampos();
        }
    });

    var initMasks = function(){
        $("input.cep").keyup(function(){mascara( this, mcep )});
        $("input.cpf").keyup(function(){mascara( this, mcpf )});
        $("input.cnpj").keyup(function(){mascara( this, cnpj )});
        $("input.phone").keyup(function () { mascara(this, mtel) });
        $("input.databr").keyup(function () { mascara(this, mdata )});
        $("input.moeda").keyup(function () { mascara(this, mvalor) });
        $("input.numero").keyup(function () { mascara(this, mnum) });
    }

    var initMisc = function () {
		$("select.select2").select2();
    }
    
    $('#btn-prox-loc').click(function(event) { event.preventDefault(); $('#btn-loc').click(); });

    $('#btn-ant-dadg').click(function(event) { event.preventDefault(); $('#btn-dadg').click(); });

    $('#btn-prox-bank').click(function(event) { event.preventDefault(); $('#btn-bank').click(); });

    $('#btn-ant-loc').click(function(event) { event.preventDefault(); $('#btn-loc').click(); });

    var complementoLocalidade = function() {
        var indexLoc = 0;
        $('#btn-add-loc').click(function (event) {
			event.preventDefault();

			var PessoaLocalidade_descricao = $('div#form-loc input[name="data[aux][PessoaLocalidade_descricao]"]').val();
			var PessoaLocalidade_inscricao_estadual = $('div#form-loc input[name="data[aux][PessoaLocalidade_inscricao_estadual]"]').val();
			var PessoaLocalidade_estado = $('div#form-loc input[name="data[aux][PessoaLocalidade_estado]"]').val();
			var PessoaLocalidade_cidade = $('div#form-loc input[name="data[aux][PessoaLocalidade_cidade]"]').val();
			var PessoaLocalidade_localidade = $('div#form-loc input[name="data[aux][PessoaLocalidade_localidade]"]').val();
            
            var html = "";

			if (PessoaLocalidade_descricao == "" || PessoaLocalidade_inscricao_estadual == "" || PessoaLocalidade_estado == "" || PessoaLocalidade_cidade == "" || PessoaLocalidade_localidade == "") {
				alert("Os campos devem ser preenchidos para adicionar a Localidade!");
            } else {
                html+= "<tr>";
                html+= "<input type='hidden' name='data[PessoaLocalidade]["+indexLoc+"][descricao]' value='"+PessoaLocalidade_descricao+"'>";
                html+= "<input type='hidden' name='data[PessoaLocalidade]["+indexLoc+"][inscricao_estadual]' value='"+PessoaLocalidade_inscricao_estadual+"'>";
                html+= "<input type='hidden' name='data[PessoaLocalidade]["+indexLoc+"][estado]' value='"+PessoaLocalidade_estado+"'>";
                html+= "<input type='hidden' name='data[PessoaLocalidade]["+indexLoc+"][cidade]' value='"+PessoaLocalidade_cidade+"'>";
                html+= "<input type='hidden' name='data[PessoaLocalidade]["+indexLoc+"][localidade]' value='"+PessoaLocalidade_localidade+"'>";

                html+= "<td>"+PessoaLocalidade_descricao+"</td>";
                html+= "<td>"+PessoaLocalidade_inscricao_estadual+"</td>";
                html+= "<td>"+PessoaLocalidade_estado+"</td>";
                html+= "<td>"+PessoaLocalidade_cidade+"</td>";
                html+= "<td>"+PessoaLocalidade_localidade+"</td>";
                html+= "<td><button type='button' class='btn btn-danger btn-icon-only' id='btn-del-loc'><i class='fa fa-trash'></i></button></td>";
                html+= "</tr>";
                $('table#table-localidades').append(html);

                $('div#form-loc input[name="data[aux][PessoaLocalidade_descricao]"]').val('');
			    $('div#form-loc input[name="data[aux][PessoaLocalidade_inscricao_estadual]"]').val('');
			    $('div#form-loc input[name="data[aux][PessoaLocalidade_estado]"]').val('');
			    $('div#form-loc input[name="data[aux][PessoaLocalidade_cidade]"]').val('');
			    $('div#form-loc input[name="data[aux][PessoaLocalidade_localidade]"]').val('');
                indexLoc++;
			}
        });
        
        $('table#table-localidades').on('click', '#btn-del-loc', function (e) {
			e.preventDefault();
			$(this).closest('tr').remove();
		});

    }

    var complementoBanco = function() {
        var indexBanco = 0;
        $('#btn-add-banco').click(function (event) {
			event.preventDefault();

			var PessoaBanco_banco = $('div#form-banco input[name="data[aux][PessoaBanco_banco]"]').val();
			var PessoaBanco_titular = $('div#form-banco input[name="data[aux][PessoaBanco_titular]"]').val();
			var PessoaBanco_cpf = $('div#form-banco input[name="data[aux][PessoaBanco_cpf]"]').val();
			var PessoaBanco_conta = $('div#form-banco input[name="data[aux][PessoaBanco_conta]"]').val();
			var PessoaBanco_agencia = $('div#form-banco input[name="data[aux][PessoaBanco_agencia]"]').val();
            var PessoaBanco_cnpj = $('div#form-banco input[name="data[aux][PessoaBanco_cnpj]"]').val();
            
            var html = "";

			if (PessoaBanco_banco == "" || PessoaBanco_titular == "" || PessoaBanco_conta == "" || PessoaBanco_agencia == "") {
				alert("Os campos devem ser preenchidos para adicionar o Banco!");
			} else if (PessoaBanco_cpf == "" && PessoaBanco_cnpj == "") {
				alert("O campo cpf e/ou cnpj devem ser preenchidos para adicionar o Banco!");
            } else {
                html+= "<tr>";
                html+= "<input type='hidden' name='data[PessoaBanco]["+indexBanco+"][banco]' value='"+PessoaBanco_banco+"'>";
                html+= "<input type='hidden' name='data[PessoaBanco]["+indexBanco+"][titular]' value='"+PessoaBanco_titular+"'>";
                html+= "<input type='hidden' name='data[PessoaBanco]["+indexBanco+"][conta]' value='"+PessoaBanco_conta+"'>";
                html+= "<input type='hidden' name='data[PessoaBanco]["+indexBanco+"][agencia]' value='"+PessoaBanco_agencia+"'>";
                html+= "<input type='hidden' name='data[PessoaBanco]["+indexBanco+"][cpf]' value='"+PessoaBanco_cpf+"'>";
                html+= "<input type='hidden' name='data[PessoaBanco]["+indexBanco+"][cnpj]' value='"+PessoaBanco_cnpj+"'>";

                html+= "<td>"+PessoaBanco_banco+"</td>";
                html+= "<td>"+PessoaBanco_titular+"</td>";
                html+= "<td>"+PessoaBanco_conta+"</td>";
                html+= "<td>"+PessoaBanco_agencia+"</td>";
                if (PessoaBanco_cpf == "" && PessoaBanco_cnpj != "") {
                    html+= "<td>"+PessoaBanco_cnpj+"</td>";
                } else if (PessoaBanco_cpf != "" && PessoaBanco_cnpj == "") {
                    html+= "<td>"+PessoaBanco_cpf+"</td>";
                } else {
                    html+= "<td>CPF: "+PessoaBanco_cpf+" / CNPJ: "+PessoaBanco_cnpj+"</td>";
                }
                html+= "<td><button type='button' class='btn btn-danger btn-icon-only' id='btn-del-banco'><i class='fa fa-trash'></i></button></td>";
                html+= "</tr>";
                $('table#table-bancos').append(html);

                $('div#form-banco input[name="data[aux][PessoaBanco_banco]"]').val('');
			    $('div#form-banco input[name="data[aux][PessoaBanco_titular]"]').val('');
			    $('div#form-banco input[name="data[aux][PessoaBanco_cpf]"]').val('');
			    $('div#form-banco input[name="data[aux][PessoaBanco_conta]"]').val('');
			    $('div#form-banco input[name="data[aux][PessoaBanco_agencia]"]').val('');
                $('div#form-banco input[name="data[aux][PessoaBanco_cnpj]"]').val('');
                indexBanco++;
			}
        });
        
        $('table#table-bancos').on('click', '#btn-del-banco', function (e) {
			e.preventDefault();
			$(this).closest('tr').remove();
		});

    }

    return {

        //main function to initiate the module
        init: function () {
            handleValidation();
            initMasks();
            initMisc();
            complementoLocalidade();
            complementoBanco();
        }

    };
    
}();

$(document).ready(function(){
    Adicionar.init();
});