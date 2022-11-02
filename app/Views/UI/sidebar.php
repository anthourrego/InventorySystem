<div class="wrapper">
		<!-- navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: .5rem .3rem">
			<li class="nav-item" style="list-style-type: none;">
				<a class="nav-link text-dark" data-widget="pushmenu" href="#" role="button">
					<i class="fas fa-bars"></i>
				</a>
			</li>
			<li class="nav-item d-none border-left <?= (isset($title) ? 'd-sm-inline-block' : '') ?>">
				<h4 class="nav-link mb-0"><?= (isset($title) ? $title : '') ?></h4>
			</li>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-warning elevation-4">
			<!-- Brand Logo -->
			<a href="<?= base_url() ?>" class="brand-link">
				<img src="<?= base_url("assets/img/icono-blanco.png") ?>" alt="Inventory System" class="brand-image">
				<span class="brand-text font-weight-light">Inventory System</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul id="opciones" class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class
					with font-awesome or any other icon font library -->
						<li class="nav-item has-treeview user-panel mt-2 pb-2 mb-2">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-user-circle"></i>
								<p>
									<?= substr(session()->get('nombre'), 0, 18) . '...'; ?>
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a id="miPerfil" href="#" class="nav-link">
										<i class="fa-solid fa-user nav-icon"></i>
										<p>Mi Perfil</p>
									</a>
								</li>
								<li class="nav-item">
									<a id="sincronizarPermisos" href="#" class="nav-link">
										<i class="fa-solid fa-rotate nav-icon"></i>
										<p>Sincronizar</p>
									</a>
								</li>
								<li class="nav-item">
									<a id="cerrarSesion" href="#" class="nav-link">
										<i class="fas fa-sign-out-alt nav-icon"></i>
										<p>Cerrar Sesión</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
              <a href="<?= base_url() ?>" class="nav-link <?= current_url(true)->getSegment(3) == '' ? 'active' : '' ?>">
                <i class="nav-icon fa-solid fa-house"></i>
                <p>Inicio</p>
              </a>
            </li>
						<?php if (validPermissions([1], true)) { ?> 
            <li class="nav-item">
              <a href="<?= base_url("Usuarios") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Usuarios' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuarios</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([2], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Perfiles") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Perfiles' ? 'active' : '' ?>">
                <i class="nav-icon fa-solid fa-address-book"></i>
                <p>Perfiles</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([3], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Categorias") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Categorias' ? 'active' : '' ?>">
								<i class="nav-icon fa-brands fa-buffer"></i>
                <p>Categorias</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([4], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Clientes") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Clientes' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-user-tie"></i>
                <p>Clientes</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([5], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Productos") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Productos' ? 'active' : '' ?>">
								<i class="nav-icon fa-brands fa-product-hunt"></i>
                <p>Productos</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([6], true)) { ?> 
						<li class="nav-item <?= (current_url(true)->getSegment(3) == 'Ventas' && (current_url(true)->getSegment(4) == 'Crear' || current_url(true)->getSegment(4) == 'Administrar')) ? 'menu-is-opening menu-open' : '' ?>">
              <a href="#" class="nav-link <?= current_url(true)->getSegment(3) == 'Ventas' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-store"></i>
                <p>
									Ventas
									<i class="fas fa-angle-left right"></i>
								</p>
              </a>
							<ul class="nav nav-treeview">
								<li	li class="nav-item">
									<a href="<?= base_url("Ventas/Crear") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Ventas' && current_url(true)->getSegment(4) == 'Crear') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Crear venta</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url("Ventas/Administrar") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Ventas' && current_url(true)->getSegment(4) == 'Administrar') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Administrar ventas</p>
									</a>
								</li>
							</ul>
            </li>
						<?php } ?>
						<?php if (validPermissions([8], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Manifiesto") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Manifiesto' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-file"></i>
                <p>Manifiesto</p>
              </a>
            </li>
						<?php } ?>
						<?php if ((ENVIRONMENT !== 'production')) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Almacen") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Almacen' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-swatchbook"></i>
                <p>Almacenes</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([9], true)) { ?> 
						<li class="nav-item <?= (current_url(true)->getSegment(3) == 'Ubicacion' && (current_url(true)->getSegment(4) == 'Paises' || current_url(true)->getSegment(4) == 'Departamentos' || current_url(true)->getSegment(4) == 'Ciudades')) ? 'menu-is-opening menu-open' : '' ?>">
              <a href="#" class="nav-link <?= current_url(true)->getSegment(3) == 'Ubicacion' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-map"></i>
                <p>
									Ubicación
									<i class="fas fa-angle-left right"></i>
								</p>
              </a>
							<ul class="nav nav-treeview">
								<?php if (validPermissions([91], true)) { ?> 
								<li	li class="nav-item">
									<a href="<?= base_url("Ubicacion/Paises") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Ubicacion' && current_url(true)->getSegment(4) == 'Paises') ? 'active' : '' ?>">
										<i class="fa-solid fa-flag nav-icon"></i>
										<p>Paises</p>
									</a>
								</li>
								<?php } ?>
								<?php if (validPermissions([92], true)) { ?> 
								<li	li class="nav-item">
									<a href="<?= base_url("Ubicacion/Departamentos") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Ubicacion' && current_url(true)->getSegment(4) == 'Departamentos') ? 'active' : '' ?>">
									<i class="fa-solid fa-earth-africa nav-icon"></i>
										<p>Departamentos</p>
									</a>
								</li>
								<?php } ?>
								<?php if (validPermissions([93], true)) { ?> 
								<li	li class="nav-item">
									<a href="<?= base_url("Ubicacion/Ciudades") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Ubicacion' && current_url(true)->getSegment(4) == 'Ciudades') ? 'active' : '' ?>">
									<i class="fa-solid fa-city nav-icon"></i>
										<p>Ciudades</p>
									</a>
								</li>
								<?php } ?>
							</ul>
            </li>
						<?php } ?>
						<?php if (validPermissions([10], true)) { ?> 
						<li class="nav-item <?= (current_url(true)->getSegment(3) == 'Pedidos' && (current_url(true)->getSegment(4) == 'Crear' || current_url(true)->getSegment(4) == 'Administrar')) ? 'menu-is-opening menu-open' : '' ?>">
              <a href="#" class="nav-link <?= current_url(true)->getSegment(3) == 'Pedidos' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-boxes-stacked"></i>
                <p>
									Pedidos
									<i class="fas fa-angle-left right"></i>
								</p>
              </a>
							<ul class="nav nav-treeview">
								<li	li class="nav-item">
									<a href="<?= base_url("Pedidos/Crear") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Pedidos' && current_url(true)->getSegment(4) == 'Crear') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Crear Pedido</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url("Pedidos/Administrar") ?>" class="nav-link <?= (current_url(true)->getSegment(3) == 'Pedidos' && current_url(true)->getSegment(4) == 'Administrar') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Administrar Pedidos</p>
									</a>
								</li>
							</ul>
            </li>
						<?php } ?>
						<?php if (validPermissions([7], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Configuracion") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Configuracion' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-gear"></i>
                <p>Configuración</p>
              </a>
            </li>
						<?php } ?>
						<?php if (validPermissions([20], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("ModificarReporte") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'ModificarReporte' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-file-pen"></i>
                <p>Modificar Reporte</p>
              </a>
            </li>
						<?php } ?>
						<?php if ((!session()->has("manejaEmpaque") || session()->get("manejaEmpaque") == "1") && validPermissions([30], true)) { ?> 
						<li class="nav-item">
              <a href="<?= base_url("Empaque") ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'Empaque' ? 'active' : '' ?>">
								<i class="nav-icon fa-solid fa-box-open"></i>
                <p>Empaque</p>
              </a>
            </li>
						<?php } ?>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>
