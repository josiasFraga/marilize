<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Romaneio Invernar <small>administrar Romaneios</small></h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD -->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>">Início</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Romaneio Invernar</a>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-dark fa fa-file-o"></i>
                    <span class="caption-subject font-dark bold uppercase">Romaneios Invernar</span>
                </div>
                <div class="actions">
                    <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'RomaneioInvernar', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-success">
                        <i class="fa fa-plus"></i> Incluir Romaneio </a>
                     <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'RomaneioInvernar', 'action' => 'imprimir')) ?>" class="btn btn-circle btn-default">
                        <i class="fa fa-print"></i> Imprimir </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="">
                    <h4>Total vendido: <span class="label label-default total-vendido">carregando..</span></h4>
                    <h4>Quant. de cabeças: <span class="label label-default total-cabecas">carregando..</span></h4>
                    <h4>Total de comissões: <span class="label label-default total-comissoes">carregando..</span></h4>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-romaneios">
                        <thead>
                            <tr>
                                <th class="table-checkbox" width="20px">
                                    <input type="checkbox" class="group-checkable" data-set="#table-romaneios .checkboxes"/>
                                </th>
                                <th>Data Emissão</th>
                                <th>Nº Romaneio</th>
                                <th>Comprador</th>
                                <th width="10%">Comprador Comissão</th>
                                <th>Vendedor</th>
                                <th width="10%">Vendedor Comissão</th>
                                <th width="10%">Valor Total</th>
                                <th>Ações</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td>
                                    <div class="margin-bottom-5">
                                        <select class="form-control form-filter input-sm" name="data_mes">
                                            <option value="">[mês..]</option>
                                            <option value="1" <?php echo date('m') == 1 ? 'selected' : '' ?>>Janeiro</option>
                                            <option value="2" <?php echo date('m') == 2 ? 'selected' : '' ?>>Fevereiro</option>
                                            <option value="3" <?php echo date('m') == 3 ? 'selected' : '' ?>>Março</option>
                                            <option value="4" <?php echo date('m') == 4 ? 'selected' : '' ?>>Abril</option>
                                            <option value="5" <?php echo date('m') == 5 ? 'selected' : '' ?>>Maio</option>
                                            <option value="6" <?php echo date('m') == 6 ? 'selected' : '' ?>>Junho</option>
                                            <option value="7" <?php echo date('m') == 7 ? 'selected' : '' ?>>Julho</option>
                                            <option value="8" <?php echo date('m') == 8 ? 'selected' : '' ?>>Agosto</option>
                                            <option value="9" <?php echo date('m') == 9 ? 'selected' : '' ?>>Setembro</option>
                                            <option value="10" <?php echo date('m') == 10 ? 'selected' : '' ?>>Outubro</option>
                                            <option value="11" <?php echo date('m') == 11 ? 'selected' : '' ?>>Novembro</option>
                                            <option value="12" <?php echo date('m') == 12 ? 'selected' : '' ?>>Dezembro</option>
                                        </select>
                                    </div>
                                
                                    <select class="form-control form-filter input-sm" name="data_ano">
                                        <option value="">[ano..]</option>
                                    <?php for ($ano = 2016; $ano <= date('Y'); $ano++): ?>
                                        <option value="<?php echo $ano ?>" <?php echo $ano == date('Y') ? 'selected' : '' ?>><?php echo $ano ?></option>
                                    <?php endfor; ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-filter input-sm" name="nromaneio"></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="comprador"></td>
                                <td></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="vendedor"></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="margin-bottom-5">
                                        <button class="btn btn-sm yellow filter-submit margin-bottom btn-block">
                                            <i class="fa fa-search"></i> Procurar
                                        </button>
                                    </div>
                                    <button class="btn btn-sm red filter-cancel btn-block">
                                        <i class="fa fa-times"></i> Limpar
                                    </button>
                                </td>
                            </tr>
                        </thead>
                        <tbody><?php ##JAVASCRIPT TRAZ AS INFORMACOES PARA ESTA TABELA COM aoColumns; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>

<!-- BEGIN PAGE LEVEL STYLES -->
<?php //$this->Html->css('/metronic/assets/global/plugins/select2/select2', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap', array('block' => 'cssPage')); ?>

<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', array('block' => 'cssPage')); ?>
<?php $this->Html->css('/metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', array('block' => 'cssPage')); ?>

<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php //$this->Html->script('/metronic/assets/global/plugins/select2/select2.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/datatables/datatables.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap', array('block' => 'scriptBottom')); ?>

<?php $this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/additional-methods.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/jquery-validation/js/localization/messages_pt_BR.min', array('block' => 'scriptBottom')); ?>

<?php $this->Html->script('/metronic/assets/global/plugins/maskcaras_er', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootbox/bootbox.min', array('block' => 'scriptBottom')); ?>

<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/metronic/assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR', array('block' => 'scriptBottom')); ?>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php $this->Html->script('/metronic/assets/global/scripts/datatable', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/js/RomaneioInvernar/index.js?v=1.0.3', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->