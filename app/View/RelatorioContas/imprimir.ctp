<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>CTFF | <?php echo $title_for_layout ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo $this->webroot ?>metronic/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo $this->webroot ?>metronic/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php // echo $this->webroot ?>metronic/assets/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" /> -->
    <link href="<?php echo $this->webroot ?>metronic/assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />

    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="<?php echo $this->webroot ?>favicon.png" />
    <style rel="stylesheet" type="text/css" media="print">
        @media print {
            h1 { font-size: 16px !important; }
            table thead tr th { text-align: center; font-size: 11px !important; padding: 3px !important; }
            table tbody tr td { text-align: center; font-size: 10px !important; padding: 3px !important; }
            h4 { font-size: 12px !important; }
            h5 { font-size: 11px !important; }
        }
    </style>
</head>
<body>
    <h1 class="text-center">Relatório Contas | Período de <?php echo date('d/m/Y', strtotime($pri)).' à '.date('d/m/Y', strtotime($ult));?></h1>
    <div style="width: 95%" class="container">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th width="15%">Categoria</th>
                    <th width="19%">Aluno</th>
                    <th width="12%">Nº Parcela</th>
                    <th width="12%">Valor</th>
                    <th width="14%">Vencimento</th>
                    <th width="14%">Pago</th>
                    <th width="14%">Forma Pag.</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($dados as $dado): ?>
                <tr>
                    <td><?php echo $dado['categoria'];?></td>
                    <td><?php echo $dado['aluno'];?></td>
                    <td><?php echo $dado['nparcela'];?></td>
                    <td><?php echo $dado['valor'];?></td>
                    <td><?php echo $dado['data_venc'];?></td>
                    <td><?php echo $dado['data_pago'];?></td>
                    <td><?php echo $dado['forma_pago'];?></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="7" style="text-align: right; background-color: #34495e; color: #fff;">
                        <h5>Valor Total: R$ <strong><span><?php echo number_format($valor_total, 2, ',', '.'); ?></span></strong></h5>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <h5 class="text-center">Desenvolvido por ZapShop.</h5> -->
    </div>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->webroot ?>metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>