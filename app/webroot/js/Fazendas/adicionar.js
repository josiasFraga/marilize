var Adicionar = function () {

	// validation using icons
	var handleValidation = function() {
		$("form#nova-fazenda button[type=submit]").click(function(e){
			e.preventDefault();
			$('form#nova-fazenda').submit();
		})

		var form = $('form#nova-fazenda');
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
				$("form#nova-fazenda button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
				$.ajax({
					type: "POST",
					data: formdata,
					url: baseUrl+'Fazendas/adicionar',
					async: true,
					cache: false,
					processData: false,
					contentType: false
				}).done(function(data){
					if (data.status == "ok"){
						$("form#nova-fazenda .alert-success span.message").html(data.msg);
						success.show();
						error.hide();
						warning.hide();
						form.reset();
					}else if(data.status == "warning"){
						$("form#nova-fazenda .alert-warning span.message").html(data.msg);
						warning.show();
						success.hide();
						error.hide();
					}else if(data.status == "erro"){
						$("form#nova-fazenda .alert-danger span.message").html(data.msg);
						warning.hide();
						success.hide();
						error.show();
					}
					$("form#nova-fazenda button[type=submit]").html('Cadastrar').removeAttr('disabled');
					App.scrollTo(error, -200);

				}).fail(function(jqXHR, textStatus, errorThrown){
					success.hide();
					warning.hide();
					$("form#nova-fazenda .alert-danger span.message").html("Ocorreu um erro ao cadastrar a propriedade. ("+textStatus+" - "+errorThrown+")")
					error.show();
					$("foApprm#nova-fazenda button[type=submit]").html('Cadastrar').removeAttr('disabled');
					App.scrollTo(error, -200);
				});
			}
		});


	}


	return {

		//main function to initiate the module
		init: function () {
            handleValidation();
		}

	};

}();

$(document).ready(function(){
	Adicionar.init();
});