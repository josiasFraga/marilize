var Gerar = function () {

	// validation using icons
	var handleValidation = function() {
		$("form#relatorio-despesas button[type=submit]").click(function(e){
			e.preventDefault();
			$('form#relatorio-despesas').submit();
		})
		// for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

			var form = $('form#relatorio-despesas');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			var warning = $('.alert-warning', form);

			form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block help-block-error', // default input error message class
				focusInvalid: true, // do not focus the last invalid input
				ignore: "",  // validate all fields including form hidden input

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
					$("form#relatorio-despesas button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Gerando, aguarde...').attr('disabled',true);
					$.ajax({
						type: "POST",
						data: formdata,
						url: baseUrl+'Relatorios/dados_despesas',
						async: true,
						cache: false,
						processData: false,
						contentType: false
					}).done(function(data){
						if (data.status == "ok"){
							$("form#relatorio-despesas .alert-success span.message").html(data.msg);
							//success.show();
							error.hide();
							warning.hide();
                            window.exportUrl = 'https://export.highcharts.com/';
                            var graficos = {};
                            $.each(data.dados, function (index, dado) {
                                    var optionsStr = JSON.stringify({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: dado.titulo
                                        },
                                        subtitle: {
                                            text: dado.subtitle
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        accessibility: {
                                            point: {
                                                valueSuffix: '%'
                                            }
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b> - {point.percentage:.1f} %'
                                                }
                                            }
                                        },
                                        series: [{
                                            name: 'Brands',
                                            colorByPoint: true,
                                            data: dado.data
                                        }],
                                    }), dataString = encodeURI('async=true&type=jpeg&width=1400&options=' + optionsStr);

                                    if (window.XDomainRequest) {
                                        var xdr = new XDomainRequest();
                                        xdr.open("post", window.exportUrl + '?' + dataString);
                                        xdr.onload = function () {
                                            graficos[index] = window.exporturl + xdr.responseText;
                                        };
                                        xdr.send();
                                    } else {
                                        $.ajax({
                                            type: 'POST',
                                            data: dataString,
                                            url: window.exportUrl,
                                            success: function (data) {
                                                console.log('get the file from relative url: ', data);
                                                graficos[index] = 'https://export.highcharts.com/' + data;
                                            },
                                            error: function (err) {
                                                console.log('error', err.statusText);
                                            }
                                        });
                                    }

                                });
                            setTimeout(() => {
                                
                                let params_str = new URLSearchParams(graficos).toString();
                                window.open(baseUrl + 'Relatorios/imprimir_pizzas/?' + params_str, '_blank').focus();
                            },3000);

                            console.log(graficos);
						}else if(data.status == "warning"){
							$("form#relatorio-despesas .alert-warning span.message").html(data.msg);
							warning.show();
							success.hide();
							error.hide();
						}else if(data.status == "erro"){
							$("form#relatorio-despesas .alert-danger span.message").html(data.msg);
							warning.hide();
							success.hide();
							error.show();
						}
						$("form#relatorio-despesas button[type=submit]").html('Gerar').removeAttr('disabled');
						App.scrollTo(error, -200);

					}).fail(function(jqXHR, textStatus, errorThrown){
						success.hide();
						warning.hide();
						$("form#relatorio-despesas .alert-danger span.message").html("Ocorreu um erro ao gerar o relatório. ("+textStatus+" - "+errorThrown+")")
						error.show();
						$("foApprm#relatorio-despesas button[type=submit]").html('Gerar').removeAttr('disabled');
						App.scrollTo(error, -200);
					});
				}
			});


	}

	var initMisc = function () {
		//$("select.select2").select2();
	}

	var initPickers = function () {
		$('input.rangepicker').daterangepicker(
        {
            format: 'DD/MM/YYYY',
            locale: {
                language: 'pt-BR',
            },
            startDate: '01/01/'+(new Date()).getFullYear(),
            endDate: '31/12/'+(new Date()).getFullYear(),
            separator: ' até ',
            locale: {
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'De',
                toLabel: 'Até',
                customRangeLabel: 'Período Customizado',
                daysOfWeek: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                firstDay: 0
            }
        });
        console.log( (new Date()).getFullYear()+'-01-01');
	}

	return {

		//main function to initiate the module
		init: function () {
			handleValidation();
            initMisc();
            initPickers();
		}

	};

}();

$(document).ready(function(){
	Gerar.init();
});