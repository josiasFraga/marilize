var Adicionar = function () {

	// validation using icons
	var handleValidation = function() {
		$("form#novo-usuario button[type=submit]").click(function(e){
			e.preventDefault();
			$('form#novo-usuario').submit();
		})
		// for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

			var form = $('form#novo-usuario');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			var warning = $('.alert-warning', form);

			form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block help-block-error', // default input error message class
				focusInvalid: true, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					// 'data[Usuario][senha]': {
					// 	required: true,
					// 	minlength: 6,
					// 	maxlength: 24
					// },
					// 'repetir_senha': {
					// 	required: true,
					// 	minlength: 6,
					// 	maxlength: 24,
					// },
				},

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
					$("form#novo-usuario button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);
					$.ajax({
						type: "POST",
						data: formdata,
						url: baseUrl+'Usuarios/adicionar',
						async: true,
						cache: false,
						processData: false,
						contentType: false
					}).done(function(data){
						if (data.status == "ok"){
							$("form#novo-usuario .alert-success span.message").html(data.msg);
							success.show();
							error.hide();
							warning.hide();
							$('#outro_cadastro').show();
						}else if(data.status == "warning"){
							$("form#novo-usuario .alert-warning span.message").html(data.msg);
							warning.show();
							success.hide();
							error.hide();
						}else if(data.status == "erro"){
							$("form#novo-usuario .alert-danger span.message").html(data.msg);
							warning.hide();
							success.hide();
							error.show();
						}
						$("form#novo-usuario button[type=submit]").html('<i class="fa fa-check"></i> Adicionado');
						App.scrollTo(error, -200);

					}).fail(function(jqXHR, textStatus, errorThrown){
						success.hide();
						warning.hide();
						$("form#novo-usuario .alert-danger span.message").html("Ocorreu um erro ao adicionar o usuário. ("+textStatus+" - "+errorThrown+")")
						error.show();
						$("foApprm#novo-usuario button[type=submit]").html('<i class="fa fa-check"></i> Adicionar').removeAttr('disabled');
						App.scrollTo(error, -200);
					});
				}
			});

	}

	var initMisc = function () {
		$("select.select2").select2();
	}

	$(".toggle-password").click(function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});

	$(".checkl").click(function(e) {
		e.preventDefault();
		if ($(this).data('check') == 'check0') {
			if (!$(this).children().hasClass('checked')) {
				console.log("Checkbox is checked.");
			} else {
				console.log("Checkbox is unchecked.");
			}
		}
	});

	return {

		//main function to initiate the module
		init: function () {
			handleValidation();
			initMisc();
		}

	};

}();

$(document).ready(function(){
	Adicionar.init();
});