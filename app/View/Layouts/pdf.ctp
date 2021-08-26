<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Orelhano | <?php echo $title_for_layout ?></title>

    <style type="text/css">
    *{ margin:0; padding: 0; }
    table.table{ width: 100%; border-spacing: 0; border-collapse: collapse; font-family: Calibri, monospace; font-size: 12px; }
    table.table thead tr th{ background-color: #e4e4e4; text-transform:uppercase; }
    table.table tbody tr td{ padding: 5px; border-bottom:1px solid #f7f7f7;  }
    table.table tbody tr.subtitle td{ font-weight: bold; font-size: 9px; text-transform:uppercase; padding-top: 10px; background-color: #f7f7f7; }
    .text-center{ text-align: center !important; }
    .text-right{ text-align: right !important; }
    .text-left{ text-align: left !important; }

    #totais{ padding-top: 15px; font-weight: bold; font-size: 12px; }
    .totais_left{ position: relative; float: right; width: 50% !important; padding-right: 7px; }
    .totais_right{ position: relative; float: right; width: 30% !important; }
    .rel_esc{ font-size: 12px; }
    .cliente-logo{ width: 80px;  }
    .top-left{ position: relative; float: left; width: 65%; }
    .top-right{ position: relative; float: right;  width: 30%; padding-bottom: 7px; }
    </style>
   	<!-- favicons================================================== -->
    <link rel="shortcut icon" href="<?php echo $this->webroot ?>img/fav_icon.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo $this->webroot ?>img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo $this->webroot ?>img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo $this->webroot ?>img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo $this->webroot ?>img/apple-touch-icon-144x144-precomposed.png">
	
</head>
<body>
<?php echo $this->fetch('content'); ?>
</body>
</html>