var Login = function() {

    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Informe um usuário."
                },
                password: {
                    required: "Informe uma senha."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });

        jQuery('.login-form').show();
        jQuery('.forget-form').hide();
        jQuery('.verificacao-form').hide();
        jQuery('.new-pw-form').hide();

    }

    // validation using icons
    var handleValidationRecovery = function() {
        $("form#forgotpw button[type=submit]").click(function(e) {
            e.preventDefault();
            $('form#forgotpw').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        var form = $('form#forgotpw');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var warning = $('.alert-warning', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            invalidHandler: function(event, validator) { //display error alert on form submit
                success.hide();
                error.show();
            },
            errorPlacement: function(error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({
                    'container': 'body'
                });
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                tab_name = $(element).closest('.tab-pane').attr('id');
                $("a[href=#" + tab_name + "]").tab('show');
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass("has-error").addClass('has-success'); // remove error class to the control group
            },
            success: function(label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },
            submitHandler: function(form) {
                var formdata = new FormData(form);
                $("form#forgotpw button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Enviando, aguarde...').attr('disabled', true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl + 'Login/sendcode',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data) {
                    if (data.status == "ok") {
                        $("form#forgotpw .alert-success span.message").html(data.msg);
                        $("input#email_recover").val(data.email);
                        success.show();
                        jQuery('.forget-form').hide();
                        jQuery('.new-pw-form').show();
                        error.hide();
                        warning.hide();
                        form.reset();
                    } else if (data.status == "warning") {
                        $("form#forgotpw .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    } else if (data.status == "erro") {
                        $("form#forgotpw .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    $("form#forgotpw button[type=submit]").html('<i class="fa fa-check"></i> Enviar').removeAttr('disabled');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    success.hide();
                    warning.hide();
                    $("form#forgotpw .alert-danger span.message").html("Ocorreu um erro ao enviar requisiÃ§Ã£o. (" + textStatus + " - " + errorThrown + ")")
                    error.show();
                    $("form#forgotpw button[type=submit]").html('<i class="fa fa-check"></i> Enviar').removeAttr('disabled');
                });
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
            jQuery('.verificacao-form').hide();
            jQuery('.new-pw-form').hide();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
            jQuery('.verificacao-form').hide();
            jQuery('.new-pw-form').hide();
        });

    }

    /*var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }*/

    /*var handleRegister = function() {

        function format(state) {
            if (!state.id) { return state.text; }
            var $state = $(
             '<span><img src="../assets/global/img/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
            );
            
            return $state;
        }

        if (jQuery().select2 && $('#country_list').size() > 0) {
            $("#country_list").select2({
                placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
                templateResult: format,
                templateSelection: format,
                width: 'auto', 
                escapeMarkup: function(m) {
                    return m;
                }
            });


            $('#country_list').change(function() {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
        }

        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                fullname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },

                username: {
                    required: true
                },
                password: {
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },

                tnc: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                tnc: {
                    required: "Please accept TNC first."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.register-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    $('.register-form').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }*/

    /*
    var handleVerificacao = function(){
        $("form#verificacao button[type=submit]").click(function(e) {
            e.preventDefault();
            $('form#verificacao').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        var form = $('form#verificacao');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var warning = $('.alert-warning', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            invalidHandler: function(event, validator) { //display error alert on form submit
                success.hide();
                error.show();
            },
            errorPlacement: function(error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({
                    'container': 'body'
                });
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                tab_name = $(element).closest('.tab-pane').attr('id');
                $("a[href=#" + tab_name + "]").tab('show');
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass("has-error").addClass('has-success'); // remove error class to the control group
            },
            success: function(label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },
            submitHandler: function(form) {
                var formdata = new FormData(form);
                $("form#verificacao button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Enviando, aguarde...').attr('disabled', true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl + 'Login/verifycode',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data) {
                    if (data.status == "ok") {
                        $("form#verificacao .alert-success span.message").html(data.msg);
                        success.show();
                        jQuery('.verificacao-form').hide();
                        jQuery('.new-pw-form').show();
                        error.hide();
                        warning.hide();
                        form.reset();
                    } else if (data.status == "warning") {
                        $("form#verificacao .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    } else if (data.status == "erro") {
                        $("form#verificacao .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                    }
                    $("form#verificacao button[type=submit]").html('<i class="fa fa-check"></i> Enviar').removeAttr('disabled');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    success.hide();
                    warning.hide();
                    $("form#verificacao .alert-danger span.message").html("Ocorreu um erro ao salvar requisiÃ§Ã£o. (" + textStatus + " - " + errorThrown + ")")
                    error.show();
                    $("form#verificacao button[type=submit]").html('<i class="fa fa-check"></i> Enviar').removeAttr('disabled');
                });
            }
        });

        jQuery('#verificacao-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').hide();
            jQuery('.verificacao-form').show();
            jQuery('.new-pw-form').hide();
        });

        jQuery('#verificacao-back-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
            jQuery('.verificacao-form').hide();
            jQuery('.new-pw-form').hide();
        });
    }
    */

    var handleNewPW = function(){
        $("form#newpw button[type=submit]").click(function(e) {
            e.preventDefault();
            $('form#newpw').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        var form = $('form#newpw');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var warning = $('.alert-warning', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            invalidHandler: function(event, validator) { //display error alert on form submit
                success.hide();
                error.show();
            },
            errorPlacement: function(error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({
                    'container': 'body'
                });
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
                tab_name = $(element).closest('.tab-pane').attr('id');
                $("a[href=#" + tab_name + "]").tab('show');
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass("has-error").addClass('has-success'); // remove error class to the control group
            },
            success: function(label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },
            submitHandler: function(form) {
                var formdata = new FormData(form);
                $("form#newpw button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Salvando, aguarde...').attr('disabled', true);
                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl + 'Login/muda_senha',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data) {
                    if (data.status == "ok") {
                        $("form#newpw .alert-success span.message").html(data.msg);
                        success.show();
                        jQuery('#formulario').hide();
                        jQuery('#botao').show();
                        error.hide();
                        warning.hide();
                        //form.hide();
                    } else if (data.status == "warning") {
                        $("form#newpw .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                    } else if (data.status == "erro") {
                        $("form#newpw .alert-danger span.message").html(data.msg);
                        error.show();
                        warning.hide();
                        success.hide();
                    }
                    $("form#newpw button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    success.hide();
                    warning.hide();
                    $("form#newpw .alert-danger span.message").html("Ocorreu um erro ao salvar requisiÃ§Ã£o. (" + textStatus + " - " + errorThrown + ")")
                    error.show();
                    $("form#newpw button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                });
            }
        });

        jQuery('#newpw-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').hide();
            jQuery('.verificacao-form').hide();
            jQuery('.new-pw-form').show();
        });

        jQuery('#newpw-back-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
            jQuery('.verificacao-form').hide();
            jQuery('.new-pw-form').hide();
        });

        jQuery('#tela-login').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
            jQuery('.verificacao-form').hide();
            jQuery('.new-pw-form').hide();
        });

    }

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            // handleValidationRecovery();
            // handleVerificacao();
            // handleNewPW();

        }

    };

}();

jQuery(document).ready(function() {
    Login.init();
});