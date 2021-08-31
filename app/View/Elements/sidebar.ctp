<div class="page-sidebar-wrapper">
	<!-- BEGIN SIDEBAR -->
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
		<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
		<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
		<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<ul class="page-sidebar-menu  <?= (strtolower($this->params['controller']) == 'contaspagar' || strtolower($this->params['controller']) == 'contasreceber') ? 'page-sidebar-menu-closed' : '' ?>" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

			<li class="nav-item start <?php echo (strtolower($this->params['controller']) == 'dashboard') ? 'active open' : '' ?>">
				<a href="<?php echo $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index')) ?>" class="nav-link nav-toggle">
					<i class="icon-home"></i>
					<span class="title">Início</span>
					<span class="selected"></span>
					<!-- <span class="arrow"></span> -->
				</a>
			</li>

			<li class="<?php echo (in_array(strtolower($this->params['controller']), array('pessoas', 'fazendas', 'safras', 'filiais', 'centrocustos', 'documentos', 'Conta', 'contas'))) ? 'active open' : ''; ?>">

				<a href="javascript:;">
					<i class="fa fa-database"></i>
					<span class="title">Cadastros</span>
					<span class="arrow"></span>
				</a>

				<ul class="sub-menu">
					<li class="<?php echo ((strtolower($this->params['controller']) == "fazendas")) ? 'active' : ''; ?>">
						<a href="<?php echo $this->Html->url(array('controller' => 'Fazendas', 'action' => 'index')) ?>">
						Fazendas</a>
					</li>
					<li class="<?php echo ((strtolower($this->params['controller']) == "safras")) ? 'active' : ''; ?>">
						<a href="<?php echo $this->Html->url(array('controller' => 'Safras', 'action' => 'index')) ?>">
						Safras</a>
					</li>

					<li class="<?php echo ((strtolower($this->params['controller']) == "pessoas")) ? 'active' : ''; ?>">
						<a href="<?php echo $this->Html->url(array('controller' => 'Pessoas', 'action' => 'index')) ?>">
						Pessoas</a>
					</li>

					<li class="<?php echo ((strtolower($this->params['controller']) == "contas") && (strtolower($this->params['action']) == "grupos")) ? 'active' : ''; ?>">
						<a href="<?php echo $this->Html->url(array('controller' => 'Contas', 'action' => 'grupos')) ?>">
						Grupos de Despesas/Receitas</a>
					</li>

					<li class="<?php echo ((strtolower($this->params['controller']) == "contas") && (strtolower($this->params['action']) == "subgrupos")) ? 'active' : ''; ?>">
						<a href="<?php echo $this->Html->url(array('controller' => 'Contas', 'action' => 'subgrupos')) ?>">
						Subgrupos de Despesas/Receitas</a>
					</li>
				</ul>

			</li>

			<li class="nav-item start <?php echo (strtolower($this->params['controller']) == 'contaspagar') ? 'active open' : '' ?>">
				<a href="<?php echo $this->Html->url(array('controller' => 'ContasPagar', 'action' => 'index')) ?>" class="nav-link nav-toggle">
				<i class="fa fa-list"></i>
					<span class="title">Despesas</span>
					<span class="selected"></span>
					<!-- <span class="arrow"></span> -->
				</a>
			</li>

			<li class="nav-item start <?php echo (strtolower($this->params['controller']) == 'contasreceber') ? 'active open' : '' ?>">
				<a href="<?php echo $this->Html->url(array('controller' => 'ContasReceber', 'action' => 'index')) ?>" class="nav-link nav-toggle">
				<i class="fa fa-list"></i>
					<span class="title">Receitas</span>
					<span class="selected"></span>
					<!-- <span class="arrow"></span> -->
				</a>
			</li>


			<li class="<?php echo (in_array(strtolower($this->params['controller']), array('relatorios'))) ? 'active open' : ''; ?>">

				<a href="javascript:;">
					<i class="fa fa-file-pdf-o"></i>
					<span class="title">Relatórios</span>
					<span class="arrow"></span>
				</a>

				<ul class="sub-menu">
					<li class="<?php echo (strtolower($this->params['controller']) == "relatorios") ? 'active' : ''; ?>">
						<a href="<?php echo $this->Html->url(array('controller' => 'Relatorios', 'action' => 'despesas')) ?>">
						Despesas</a>
					</li>
				</ul>

			</li>

			<li class="nav-item start <?php echo (strtolower($this->params['controller']) == 'usuarios') ? 'active open' : '' ?>">
				<a href="<?php echo $this->Html->url(array('controller' => 'Usuarios', 'action' => 'index')) ?>" class="nav-link nav-toggle">
				<i class="icon-users"></i>
					<span class="title">Usuários</span>
					<span class="selected"></span>
					<!-- <span class="arrow"></span> -->
				</a>
			</li>
		
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
	<!-- END SIDEBAR -->
</div>