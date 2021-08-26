<div class="row">
    <div class="col-md-12">
        <h4 style="text-align: center;">Pagamento efetuado dia <h4>
        <h4 style="text-align: center;"><?php echo implode("/",array_reverse(explode("-", $dados['PagamentoData']['data_pago']))); ?></h4>
        <hr>
        <h4 style="text-align: center;">Forma de Pagamento<h4>
        <h4 style="text-align: center;"><?=$dados['PagamentoForma']['forma']?></h4>
    </div>
</div>