<div class="wrapper">
		<!-- navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: .5rem .3rem">
			<li class="nav-item" style="list-style-type: none;">
				<a class="nav-link text-dark" data-widget="pushmenu" href="#" role="button">
					<i class="fas fa-bars"></i>
				</a>
			</li>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-navy elevation-4">
			<!-- Brand Logo -->
			<a href="#" class="brand-link">
				<img src="<?= base_url("assets/img/icono-blanco.png") ?>" alt="Inventory System" class="brand-image">
				<span class="brand-text font-weight-light">Inventory System</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul id="opciones" class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class
					with font-awesome or any other icon font library -->
						<li class="nav-item has-treeview user-panel mt-2 pb-2 mb-2">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-user-circle"></i>
								<p>
									<?= substr($session->get('nombre'), 0, 18) . '...'; ?>
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a id="cerrarSesion" href="#" class="nav-link">
										<i class="fas fa-sign-out-alt nav-icon"></i>
										<p>Cerrar Sesión</p>
									</a>
								</li>
							</ul>
						</li>
            <li class="nav-item">
              <a href="pages/widgets.html" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuarios</p>
              </a>
            </li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>
