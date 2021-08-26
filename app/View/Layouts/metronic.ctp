<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		<meta charset="utf-8" />
		<title>Orelhano | <?php echo $title_for_layout ?></title>
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
		<link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
		<?php echo $this->fetch('cssPage'); ?>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL STYLES -->
		<link href="<?php echo $this->webroot ?>metronic/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="<?php echo $this->webroot ?>metronic/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
		<link href="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />

		<!-- END THEME LAYOUT STYLES -->
		<link rel="shortcut icon" href="<?php echo $this->webroot.$favicon?>" />

		<!--Start of Zendesk Chat Script-->
		<!--End of Zendesk Chat Script-->

		<style type="text/css">
			.page-header.navbar {
				background: #fff !important;
			}

			.page-header.navbar .top-menu .navbar-nav>li.dropdown-language>.dropdown-toggle>.langname, .page-header.navbar .top-menu .navbar-nav>li.dropdown-user>.dropdown-toggle>.username, .page-header.navbar .top-menu .navbar-nav>li.dropdown-user>.dropdown-toggle>i {
				color: #000 !important;
			}
		</style>
		</head>
	<!-- END HEAD -->

	<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo <?= (strtolower($this->params['controller']) == 'contaspagar') ? 'page-sidebar-closed' : '' ?>">
		<!-- BEGIN HEADER -->
		<div class="page-header navbar navbar-fixed-top">
			<!-- BEGIN HEADER INNER -->
			<div class="page-header-inner ">
				<!-- BEGIN LOGO -->
				<div class="page-logo">
					<a href="#">
						<img src="<?php echo $this->webroot.$logo;?>" style="width: 150px; margin: 1px 0px 0" alt="logo" class="logo-default" /> </a>
					<div class="menu-toggler sidebar-toggler">
						<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
					</div>
				</div>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" style="filter: invert(95%) !important" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN PAGE ACTIONS -->
				<!-- DOC: Remove "hide" class to enable the page header actions -->

				<!-- END PAGE ACTIONS -->
				<!-- BEGIN PAGE TOP -->
				<div class="page-top">
					<!-- BEGIN TOP NAVIGATION MENU -->
					<div class="top-menu">
						<ul class="nav navbar-nav pull-right">
							<li class="separator hide"> </li>
							<!-- BEGIN NOTIFICATION DROPDOWN -->
							<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
							
							<!-- END INBOX DROPDOWN -->
							<!-- BEGIN TODO DROPDOWN -->
							<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
							<!-- END TODO DROPDOWN -->
							<!-- BEGIN USER LOGIN DROPDOWN -->
							<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
							<li class="dropdown dropdown-user">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<span class="username"> <?php echo AuthComponent::user('nome') ?> </span>
									<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
									<img alt="" class="img-circle" src="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/img/<?php echo $usuario_foto ?>" /> </a>
								<ul class="dropdown-menu dropdown-menu-default">
									<li>
										<a href="<?php echo $this->Html->url(array('controller' => 'Usuarios', 'action' => 'meusdados')) ?>">
											<i class="icon-user"></i> Meus Dados </a>
									</li>
									<li>
										<a href="<?php echo $this->Html->url(array('controller' => 'login', 'action' => 'deslogar')) ?>">
											<i class="icon-key"></i> Sair </a>
									</li>
								</ul>
							</li>
							<!-- END USER LOGIN DROPDOWN -->
						</ul>
					</div>
					<!-- END TOP NAVIGATION MENU -->
				</div>
				<!-- END PAGE TOP -->
			</div>
			<!-- END HEADER INNER -->
		</div>
		<!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
			<?php echo $this->element('sidebar'); ?>
			<!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="page-footer">
			<div class="page-footer-inner"> <?php echo date('Y') ?> &copy; ZapShop.
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
		<!-- END FOOTER -->
		<!--[if lt IE 9]>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/respond.min.js"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/excanvas.min.js"></script> 
		<![endif]-->
		<!-- BEGIN CORE PLUGINS -->
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

		<script type="text/javascript">
			window.baseUrl = '<?php echo $this->webroot ?>';
		</script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

		<script src="<?php echo $this->webroot ?>js/plugins/numeric/jquery.numeric.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>js/plugins/maskmoney/jquery.maskMoney.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>js/plugins/masks.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>js/plugins/numeral.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.currency').maskMoney({
					prefix: "R$ ",
					thousands: ".",
					decimal: ","
				});

				$('.percentage').maskMoney({
					prefix: "",
					thousands: "",
					decimal: ","
				});

				$('.duasdecimal').maskMoney({
					prefix: "",
					thousands: ".",
					decimal: ",",
					allowZero: true,
					// allowNegative: true
				});

				$(".integer").numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });

				$("input.cep").keyup(function(){mascara( this, mcep )});
				$("input.cpf").keyup(function(){mascara( this, mcpf )});
				$("input.cnpj").keyup(function(){mascara( this, cnpj )});
				$("input.phone").keyup(function(){mascara( this, mtel )});
				$("input.moeda").keyup(function () { mascara(this, mvalor) });
				$("input.numero").keyup(function () { mascara(this, mnum) });
				$("input.numerotres").keyup(function () { mascara(this, mnumvir) });
				$("input.databr").keyup(function () { mascara(this, mdata )});
				$("input.numeroquatro").keyup(function () { mascara(this, mnumqua) });

			});
		</script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="<?php echo $this->webroot ?>metronic/assets/global/scripts/app.js?v=1" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<?php echo $this->fetch('scriptBottom') ?>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
		<!-- END THEME LAYOUT SCRIPTS -->
	</body>
</html>