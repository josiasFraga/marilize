<!DOCTYPE html>
<!-- Metronic 4.5.1 -->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Orelhano | Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo $this->webroot ?>metronic/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?php echo $this->webroot ?>metronic/assets/pages/css/login-2.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .login {
            background-color: #fff !important;
        }

        input {
            background-color: #f1f1f1 !important;
            border-color: #000 !important;
            color: #000 !important;
        }

        input::-webkit-input-placeholder {
            color: #000 !important;
        }

        button[type=submit] {
            background-color: #626437 !important;
            border-color: #626437 !important;
        }

        .login .form-subtitle, .login .form-title, .login .copyright {
            color: #000 !important;
        }
    </style>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="<?=$this->webroot.$favicon;?>" />
</head>
<!-- END HEAD -->

<body class="login">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="#">
            <img src="<?=$this->webroot.$logo;?>?v=1.0" style="height: 100px;" alt="" /> </a>
    </div>
    <!-- END LOGO -->

    <div class="content">

        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="" method="post">
            <div class="form-title">
                <span class="form-title">Seja bem-vindo.</span>
                <span class="form-subtitle">Efetue o login.</span>
            </div>
            <?php echo $this->Session->flash(); ?>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Informe um usuário e uma senha. </span>
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Usuário</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Usuário" name="data[Usuario][email]" autofocus/> </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Senha</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Senha" name="data[Usuario][senha]" /> </div>
            <div class="form-actions">
                <button type="submit" class="btn red btn-block uppercase">Entrar</button>
            </div>
            <!-- <div class="login-options">
                <h4 class="pull-left">Or login with</h4>
                <ul class="social-icons pull-right">
                    <li>
                        <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                    </li>
                    <li>
                        <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                    </li>
                    <li>
                        <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                    </li>
                    <li>
                        <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                    </li>
                </ul>
            </div>
            <div class="create-account">
                <p>
                    <a href="javascript:;" class="btn-primary btn" id="register-btn">Create an account</a>
                </p>
            </div> -->
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        <form class="forget-form" action="" method="post">
            <div class="form-title">
                <span class="form-title">Esqueceu a Senha?</span>
                <span class="form-subtitle">Digite o seu e-mail para recuperá-la.</span>
            </div>
            <div class="form-group">
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn btn-default">Voltar</button>
                <button type="submit" class="btn btn-primary uppercase pull-right">Enviar</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
        <!-- BEGIN REGISTRATION FORM -->
        
        <!-- END REGISTRATION FORM -->

    </div>

    <div class="copyright"> Desenvolvido por ZAPSHOP - <?php echo date('Y') ?>. </div>

    <script type="text/javascript"> window.baseUrl = '<?php echo $this->webroot ?>';</script>

    <!--[if lt IE 9]>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/respond.min.js"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="<?php echo $this->webroot ?>metronic/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo $this->webroot ?>metronic/assets/pages/scripts/login.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot;?>js/Login/login.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->
</body>
</html>