var Adicionar = function () {

    // validation using icons
    var handleValidation = function() {
        $("form#alterar-pessoa button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#alterar-pessoa').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#alterar-pessoa');
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
                $("form#alterar-pessoa button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'Pessoas/alterar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
                        $("form#alterar-pessoa .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }else if(data.status == "warning"){
                        $("form#alterar-pessoa .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    }else if(data.status == "erro"){
                        $("form#alterar-pessoa .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    $("form#alterar-pessoa button[type=submit]").html('<i class="fa fa-check"></i> Alterado').removeAttr('disabled');
                    App.scrollTo($("form#alterar-pessoa"), -200);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#alterar-pessoa .alert-danger span.message").html("Ocorreu um erro ao alterar a pessoa. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#alterar-pessoa button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
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
    
    $('#btn-ant-loc').click(function(event) { event.preventDefault(); $('#btn-loc').click(); });
    $('#btn-prox-loc').click(function(event) { event.preventDefault(); $('#btn-loc').click(); });
    $('#btn-ant-dadg').click(function(event) { event.preventDefault(); $('#btn-dadg').click(); });
    $('#btn-prox-bank').click(function(event) { event.preventDefault(); $('#btn-bank').click(); });

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

    var initDeleteLocalidade = function () {
		$('#table-localidades').on('click', 'a.btn-remove', function(ev){
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
							target: '#table-localidades',
							boxed: true,
							message: 'Excluindo, aguarde...'
						});
						$.post(baseUrl+"PessoasLocalidades/excluir/"+param1,function(data){
							if (data.status == "ok") {
                                este.closest('tr').remove();
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
							App.unblockUI('#table-localidades');
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
							App.unblockUI('#table-localidades');
						});
					}
				}
			})
		})
    }
    
    var initDeleteBanco = function () {
		$('#table-bancos').on('click', 'a.btn-remove', function(ev){
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
							target: '#table-bancos',
							boxed: true,
							message: 'Excluindo, aguarde...'
						});
						$.post(baseUrl+"PessoasBancos/excluir/"+param1,function(data){
							if (data.status == "ok") {
                                este.closest('tr').remove();
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
							App.unblockUI('#table-bancos');
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
							App.unblockUI('#table-bancos');
						});
					}
				}
			})
		})
    }
    
    var preencherLocalidade = function () {
        $('#table-localidades').on('click', 'a.btn-alterar', function(event){
            event.preventDefault();
            var locId = $(this).data("id");
            var locInfo = JSON.parse($('#l'+locId).val());

			$('form#alterar-localidade').find('input[name="data[PessoaLocalidade][id]"]').val(locId);
			$('form#alterar-localidade').find('input[name="data[PessoaLocalidade][descricao]"]').val(locInfo.descricao);
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][inscricao_estadual]"]').val(locInfo.inscricao_estadual);
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][estado]"]').val(locInfo.estado);
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][cidade]"]').val(locInfo.cidade);
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][localidade]"]').val(locInfo.localidade);
        });
        $('#modalEditLocalidade').on('hidden.bs.modal', function () {
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][id]"]').val("");
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][descricao]"]').val("");
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][inscricao_estadual]"]').val("");
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][estado]"]').val("");
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][cidade]"]').val("");
            $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][localidade]"]').val("");
        });
    }

    var preencherBanco = function () {
        $('#table-bancos').on('click', 'a.btn-alterar', function(event){
            event.preventDefault();
            var locId = $(this).data("id");
            var locInfo = JSON.parse($('#b'+locId).val());

			$('form#alterar-banco').find('input[name="data[PessoaBanco][id]"]').val(locId);
            $('form#alterar-banco').find('input[name="data[PessoaBanco][banco]"]').val(locInfo.banco);
            $('form#alterar-banco').find('input[name="data[PessoaBanco][titular]"]').val(locInfo.titular);
            $('form#alterar-banco').find('input[name="data[PessoaBanco][cpf]"]').val(locInfo.cpf);
            $('form#alterar-banco').find('input[name="data[PessoaBanco][conta]"]').val(locInfo.conta);
            $('form#alterar-banco').find('input[name="data[PessoaBanco][agencia]"]').val(locInfo.agencia);
            $('form#alterar-banco').find('input[name="data[PessoaBanco][cnpj]"]').val(locInfo.cnpj);
        });
        $('#modalEditBanco').on('hidden.bs.modal', function () {
            $('form#alterar-banco').find('input[name="data[PessoaBanco][id]"]').val("");
            $('form#alterar-banco').find('input[name="data[PessoaBanco][banco]"]').val("");
            $('form#alterar-banco').find('input[name="data[PessoaBanco][titular]"]').val("");
            $('form#alterar-banco').find('input[name="data[PessoaBanco][cpf]"]').val("");
            $('form#alterar-banco').find('input[name="data[PessoaBanco][conta]"]').val("");
            $('form#alterar-banco').find('input[name="data[PessoaBanco][agencia]"]').val("");
            $('form#alterar-banco').find('input[name="data[PessoaBanco][cnpj]"]').val("");
        });
    }

    var handleValidationLocalidade = function() {
        $("form#alterar-localidade button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#alterar-localidade').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#alterar-localidade');
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
                $("form#alterar-localidade button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Alterando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'PessoasLocalidades/alterar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok") {
                        $("form#alterar-localidade .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        setTimeout(function () {
                            delAddLocalidade();
                            $('#modalEditLocalidade').modal('hide');
                        }, 1500);
                    } else if (data.status == "warning") {
                        $("form#alterar-localidade .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    } else if (data.status == "erro") {
                        $("form#alterar-localidade .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    $("form#alterar-localidade button[type=submit]").html('<i class="fa fa-check"></i> Alterado');
                    setTimeout(function () {
                        $("form#alterar-localidade button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
                        warning.hide();
                        success.hide();
                        error.hide();
                    }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#alterar-localidade .alert-danger span.message").html("Ocorreu um erro ao alterar a Localidade. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#alterar-localidade button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
                });
            }
        });
    }

    function delAddLocalidade () {
        var plid        = $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][id]"]').val();
        var pldescricao = $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][descricao]"]').val();
        var plie        = $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][inscricao_estadual]"]').val();
        var plestado    = $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][estado]"]').val();
        var plcidade    = $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][cidade]"]').val();
        var plloc       = $('form#alterar-localidade').find('input[name="data[PessoaLocalidade][localidade]"]').val();
        var value = '{"descricao":"'+pldescricao+'", "inscricao_estadual":"'+plie+'", "estado":"'+plestado+'", "cidade":"'+plcidade+'", "localidade":"'+plloc+'"}';
        var html = "<tr>";
        html+= "<input type='hidden' id='l"+plid+"' value='"+value+"' />";
        html+= "<td>"+pldescricao+"</td>";
        html+= "<td>"+plie+"</td>";
        html+= "<td>"+plestado+"</td>";
        html+= "<td>"+plcidade+"</td>";
        html+= "<td>"+plloc+"</td>";
        html+= "<td><a href='#' class='btn btn-icon-only red btn-remove' data-id='"+plid+"' title='Excluir Localidade'><i class='fa fa-trash'></i></a> <a class='btn btn-info btn-icon-only btn-alterar' data-id='"+plid+"' data-toggle='modal' href='#modalEditLocalidade' title='Alterar Localidade'><i class='fa fa-edit'></i></a></td>";
        html+= "</tr>";
        $('#l'+plid).closest('tr').remove();
        $('table#table-localidades').append(html);
    }

    var handleValidationBanco = function() {
        $("form#alterar-banco button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#alterar-banco').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#alterar-banco');
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
                $("form#alterar-banco button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Alterando, aguarde...').attr('disabled',true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'PessoasBancos/alterar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok") {
                        $("form#alterar-banco .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        setTimeout(function () {
                            delAddBanco();
                            $('#modalEditBanco').modal('hide');
                        }, 1500);
                    } else if (data.status == "warning") {
                        $("form#alterar-banco .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    } else if (data.status == "erro") {
                        $("form#alterar-banco .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    $("form#alterar-banco button[type=submit]").html('<i class="fa fa-check"></i> Alterado');
                    setTimeout(function () {
                        $("form#alterar-banco button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
                        warning.hide();
                        success.hide();
                        error.hide();
                    }, 2000);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#alterar-banco .alert-danger span.message").html("Ocorreu um erro ao alterar a Localidade. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#alterar-banco button[type=submit]").html('<i class="fa fa-check"></i> Alterar').removeAttr('disabled');
                });
            }
        });
    }

    function delAddBanco () {
        var pbid        = $('form#alterar-banco').find('input[name="data[PessoaBanco][id]"]').val();
        var pbbanco = $('form#alterar-banco').find('input[name="data[PessoaBanco][banco]"]').val();
        var pbtitular        = $('form#alterar-banco').find('input[name="data[PessoaBanco][titular]"]').val();
        var pbconta    = $('form#alterar-banco').find('input[name="data[PessoaBanco][conta]"]').val();
        var pbagencia    = $('form#alterar-banco').find('input[name="data[PessoaBanco][agencia]"]').val();
        var pbcpf       = $('form#alterar-banco').find('input[name="data[PessoaBanco][cpf]"]').val();
        var pbcnpj       = $('form#alterar-banco').find('input[name="data[PessoaBanco][cnpj]"]').val();
        var value = '{"banco":"'+pbbanco+'", "titular":"'+pbtitular+'", "conta":"'+pbconta+'", "agencia":"'+pbagencia+'", "cpf":"'+pbcpf+'", "cnpj":"'+pbcnpj+'"}';
        var html = "<tr>";
        html+= "<input type='hidden' id='b"+pbid+"' value='"+value+"' />";
        html+= "<td>"+pbbanco+"</td>";
        html+= "<td>"+pbtitular+"</td>";
        html+= "<td>"+pbconta+"</td>";
        html+= "<td>"+pbagencia+"</td>";
        if (pbcpf == "" && pbcnpj != "") {
            html+= "<td>"+pbcnpj+"</td>";
        } else if (pbcpf != "" && pbcnpj == "") {
            html+= "<td>"+pbcpf+"</td>";
        } else {
            html+= "<td>CPF: "+pbcpf+" / CNPJ: "+pbcnpj+"</td>";
        }

        html+= "<td><a href='#' class='btn btn-icon-only red btn-remove' data-id='"+pbid+"' title='Excluir Banco'><i class='fa fa-trash'></i></a> <a class='btn btn-info btn-icon-only btn-alterar' data-id='"+pbid+"' data-toggle='modal' href='#modalEditBanco' title='Alterar Banco'><i class='fa fa-edit'></i></a></td>";
        html+= "</tr>";
        $('#b'+pbid).closest('tr').remove();
        $('table#table-bancos').append(html);
    }

    return {

        //main function to initiate the module
        init: function () {
            handleValidation();
            initMasks();
            initMisc();
            complementoLocalidade();
            complementoBanco();
            initDeleteLocalidade();
            initDeleteBanco();
            preencherLocalidade();
            preencherBanco();
            handleValidationLocalidade();
            handleValidationBanco();
        }

    };
    
}();

$(document).ready(function(){
    Adicionar.init();
});