<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <style>
        th.invernar { width: 475px; background-color:#f0ffc8; }
        th.gordo { width: 402px; background-color:#ffeeb0;   }
        th.geral { width: 402px; background-color:#cfeeff;  }

        table { font-family: 'Tahoma', sans-serif; background-color:#fff; }

        table, table tr, table td, table th {  border: 1px solid #000; border-collapse: collapse; }

        tr th { padding: 12px; font-size: 15px; text-transform: uppercase; }
        tr th.mes { background-color:#badc58; text-align: center; color:#000; }
        
        tr th.quant { background-color:#c7e379; color:#2d3436; text-align: left; width: 120px; text-align: center;}
        tr th.quant.color2 { background-color:#f9ca24; }
        tr th.quant.color3 { background-color:#00a8ff; }

        tr th.comissao { background-color:#c7e379; color:#2d3436; text-align: center; width: 120px; }
        tr th.comissao.color1 { }
        tr th.comissao.color2 { background-color:#f9ca24; }
        tr th.comissao.color3 { background-color:#00a8ff; }

        tr th.valor { background-color:#c7e379; color:#2d3436; text-align: center; width: 120px; }
        tr th.valor.color1 { }
        tr th.valor.color2 { background-color:#f9ca24; }
        tr th.valor.color3 { background-color:#00a8ff; }

        tr td { font-size: 18px; padding: 6px 5px; text-align: center;}
        tr td.title { background-color:#badc58;  font-size: 14px; text-transform: uppercase;}
        tr td.title.strong { background-color:#badc58;  text-transform: uppercase; font-weight: bold; }

        tr td.color1 { background-color:#f0ffc8; }
        tr td.color2 { background-color:#ffeeb0; }
        tr td.color3 { background-color:#cfeeff; }

        tr td.mcolor1 { background-color:#badc58; }
        tr td.mcolor2 { background-color:#f9ca24; }
        tr td.mcolor3 { background-color:#00a8ff; }

    </style>
</head>
<body>
    <?php echo $this->fetch('content'); ?>
</body>
</html>