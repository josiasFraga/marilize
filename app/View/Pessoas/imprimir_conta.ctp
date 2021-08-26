<div>
    <div class="top-left">
        <p class="rel_esc">            
        Conta Bancária Fornecedor
        </p>
    </div>
    <div class="top-right text-right">
        <img src="https://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="5"  class="text-center">Conta Bancária</th>
        </tr>
        <tr>
            <th class="text-center">Banco</th>
            <th class="text-center">Titular</th>
            <th class="text-center">Agência</th>
            <th class="text-center">Nº Conta</th>
            <th class="text-center">CPF / CNPJ Conta</th>
        </tr>
    </thead>
    <tbody>
 
        <tr>
            
            <td class="text-center"><?php echo $conta['PessoaBanco']['banco'] ?></td>
            <td class="text-center"><?php echo $conta['PessoaBanco']['titular'] ?></td>
            <td class="text-center"><?php echo $conta['PessoaBanco']['agencia'] ?></td>
            <td class="text-center"><?php echo $conta['PessoaBanco']['conta'] ?></td>
            <td class="text-center"><?php echo $conta['PessoaBanco']['cpf'] . ' / ' . $conta['PessoaBanco']['cnpj'] ?></td>
        </tr>     
    </tbody>
</table>

<hr>