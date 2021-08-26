<?php if ($tipo == 'fornecedores'): ?>
<div>
    <div class="top-left">
        <p class="rel_esc">            
           Listagem de Fornecedores
        </p>
    </div>
    <div class="top-right text-right">
        <img src="https://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="9"  class="text-center">Fornecedores</th>
        </tr>
        <tr>
            <th class="text-center">Nome Fantasia</th>
            <th class="text-center">Observações</th>
            <th class="text-center">Banco</th>
            <th class="text-center">Titular</th>
            <th class="text-center">Agência</th>
            <th class="text-center">Nº Conta</th>
            <th class="text-center">CPF / CNPJ Conta</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pessoas as $pessoa): ?>
 
        <tr>
            
            <td class="text-center"><?php echo $pessoa['Pessoa']['nome_fantasia'] ?></td>
            <td class="text-center"><?php echo $pessoa['Pessoa']['observacoes'] ?></td>
            <td class="text-center"><?php echo $pessoa['PessoaBanco']['banco'] ?></td>
            <td class="text-center"><?php echo $pessoa['PessoaBanco']['titular'] ?></td>
            <td class="text-center"><?php echo $pessoa['PessoaBanco']['agencia'] ?></td>
            <td class="text-center"><?php echo $pessoa['PessoaBanco']['conta'] ?></td>
            <td class="text-center"><?php echo $pessoa['PessoaBanco']['cpf'] . ' / ' . $pessoa['PessoaBanco']['cnpj'] ?></td>
        </tr>     
    <?php endforeach; ?>
    </tbody>
</table>

<hr>
<?php else: ?>
    <div>
    <div class="top-left">
        <p class="rel_esc">            
           Listagem de Clientes
        </p>
    </div>
    <div class="top-right text-right">
        <img src="https://orelhano.com.br/img/logo.png" class="cliente-logo">
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th colspan="4"  class="text-center">Clientes</th>
        </tr>
        <tr>
            <th class="text-center">Nome Fantasia</th>
            <th class="text-center">CPF / CNPJ</th>
            <th class="text-center">Telefone 1</th>
            <th class="text-center">Telefone 2</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pessoas as $pessoa): ?>
 
        <tr>
            
            <td class="text-center"><?= $pessoa['Pessoa']['nome_fantasia'] ?></td>
        <?php if (!is_null($pessoa['Pessoa']['cpf']) && !empty($pessoa['Pessoa']['cpf']) && !is_null($pessoa['Pessoa']['cnpj']) && !empty($pessoa['Pessoa']['cnpj'])): ?>
            <td class="text-center"><?= $pessoa['Pessoa']['cpf'] ?> / <?= $pessoa['Pessoa']['cnpj'] ?></td>
        <?php elseif (!is_null($pessoa['Pessoa']['cpf']) && !empty($pessoa['Pessoa']['cpf'])): ?>
            <td class="text-center"><?= $pessoa['Pessoa']['cpf'] ?></td>
        <?php elseif (!is_null($pessoa['Pessoa']['cnpj']) && !empty($pessoa['Pessoa']['cnpj'])): ?>
            <td class="text-center"><?= $pessoa['Pessoa']['cnpj'] ?></td>
        <?php else: ?>
            <td class="text-center"></td>
        <?php endif; ?>


            <td class="text-center"><?= $pessoa['Pessoa']['telefone1'] ?></td>
            <td class="text-center"><?= $pessoa['Pessoa']['telefone2'] ?></td>
        </tr>
        <tr colspan="4">
            <td>
            <strong>LOCALIDADES:</strong>
            <br/><br/>
        <?php foreach ($pessoa['_localidades'] as $localidade): ?>
        <p>
            <strong>Descrição:</strong> <?= $localidade['PessoaLocalidade']['descricao'] ?>
            <strong>IES.:</strong> <?= $localidade['PessoaLocalidade']['inscricao_estadual'] ?>
            <strong>Cidade:</strong> <?= $localidade['PessoaLocalidade']['cidade'] ?> / <?= $localidade['PessoaLocalidade']['estado'] ?>
            <strong>Localidade:</strong> <?= $localidade['PessoaLocalidade']['localidade'] ?>
        </p>
            <br/>
        <?php endforeach; ?>
            </td>
        </tr>  
        <tr colspan="4">
            <td><strong>CONTAS BANCÁRIAS:</strong><br/><br/>
            <?php foreach ($pessoa['_contas'] as $conta): ?>
        <p>
            <strong>Banco:</strong> <?= $conta['PessoaBanco']['banco'] ?>
            <strong>Titular:</strong> <?= $conta['PessoaBanco']['titular'] ?>
            <strong>Conta:</strong> <?= $conta['PessoaBanco']['conta'] ?>
            <strong>Ag.:</strong> <?= $conta['PessoaBanco']['agencia'] ?>
            <strong>CPF/CNPJ:</strong> <?= $conta['PessoaBanco']['cpf'] ?> / <?= $conta['PessoaBanco']['cnpj'] ?>
        </p>
            <br/>
        <?php endforeach; ?>
            
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<hr>
<?php endif; ?>