<!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Pessoas <small>administrar Pessoas</small></h1>
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
        <li class="active">
            Pessoas
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"> Pessoas </span>
                </div>
                <div class="actions">
                    <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'adicionar')) ?>" class="btn btn-circle btn-success">
                        <i class="fa fa-plus"></i> Incluir </a>
                        <?php if ($menu_pessoas == 'fornecedores'): ?>
                    <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'imprimir', $menu_pessoas)) ?>" class="btn btn-circle btn-default">
                        <i class="fa fa-print"></i> Imprimir Contas Bancárias</a>
                        <?php endif; ?>
                        <?php if ($menu_pessoas == 'clientes'): ?>
                    <a role="button" data-toggle="" href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'imprimir', $menu_pessoas)) ?>" class="btn btn-circle btn-default">
                        <i class="fa fa-print"></i> Imprimir Clientes</a>
                        <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-pessoas">
                        <thead>
                            <tr>
                                <th class="table-checkbox" width="20px">
                                    <input type="checkbox" class="group-checkable" data-set="#table-pessoas .checkboxes"/>
                                </th>
                                <th>Razão Social</th>
                                <th>Nome Fantasia</th>
                                <th>Telefone (1)</th>
                                <th>Telefone (2)</th>
                                <th width="150px">Ações</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="razao_social"></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="nome_fantasia"></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="telefone1"></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="telefone2"></td>
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
<!-- END PAGE BASE CONTENT -->

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

<script type="text/javascript">
    window.tipo_pessoa = "<?= $menu_pessoas ?>";
</script>

<?php $this->Html->script('/metronic/assets/global/scripts/datatable', array('block' => 'scriptBottom')); ?>
<?php $this->Html->script('/js/Pessoas/index.js?v=1.0', array('block' => 'scriptBottom')); ?>
<!-- END PAGE LEVEL SCRIPTS -->