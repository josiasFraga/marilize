var Adicionar = function () {

    // validation using icons
    var handleValidation = function() {
        $("form#adicionar-adiantamento button[type=submit]").click(function(e){
            e.preventDefault();
            $('form#adicionar-adiantamento').submit();
        });
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form = $('form#adicionar-adiantamento');
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
                $("form#adicionar-adiantamento button[type=submit]").html('<i class="fa fa-spinner fa-spin"></i> Cadastrando, aguarde...').attr('disabled',true);

                $.ajax({
                    type: "POST",
                    data: formdata,
                    url: baseUrl+'Adiantamentos/adicionar',
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.status == "ok"){
                        $("form#adicionar-adiantamento .alert-success span.message").html(data.msg);
                        success.show();
                        error.hide();
                        warning.hide();
                        $("form#adicionar-adiantamento button[type=submit]").html('<i class="fa fa-check"></i> Salvo');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                        // $('#outro_cadastro').show();
                    }else if(data.status == "warning"){
                        $("form#adicionar-adiantamento .alert-warning span.message").html(data.msg);
                        warning.show();
                        success.hide();
                        error.hide();
                        $("form#adicionar-adiantamento button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                    }else if(data.status == "erro"){
                        $("form#adicionar-adiantamento .alert-danger span.message").html(data.msg);
                        warning.hide();
                        success.hide();
                        error.show();
                        $("form#adicionar-adiantamento button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                    }
                    App.scrollTo($("form#adicionar-adiantamento"), -200);
                }).fail(function(jqXHR, textStatus, errorThrown){
                    success.hide();
                    warning.hide();
                    $("form#adicionar-adiantamento .alert-danger span.message").html("Ocorreu um erro ao adicionar o romaneio. ("+textStatus+" - "+errorThrown+")")
                    error.show();
                    $("form#adicionar-adiantamento button[type=submit]").html('<i class="fa fa-check"></i> Salvar').removeAttr('disabled');
                    App.scrollTo(error, -200);
                });
  
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