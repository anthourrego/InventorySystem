<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/iniciarSesion', 'Home::iniciarSesion', ['filter' => 'ajax']);
$routes->post('/cerrarSesion', 'Home::cerrarSesion', ['filter' => ['authGuard', 'ajax']]);
$routes->post('sidebar', 'Home::sidebar', ['filter' => ['authGuard', 'ajax']]);

//Usuarios
$routes->group('Usuarios', ['filter' => 'authGuard:1'], function ($routes) {
	$routes->get('/', 'cUsuarios::index');
	$routes->post('DT', 'cUsuarios::listaDT');
	$routes->get('Foto', 'cUsuarios::foto');
	$routes->get('Foto/(:any)', 'cUsuarios::foto/$1');
	$routes->post('Eliminar', 'cUsuarios::eliminar', ['filter' => ['authGuard:14', 'ajax']]);
	$routes->post('Crear', 'cUsuarios::crearEditar', ['filter' => ['authGuard:11', 'ajax']]);
	$routes->post('Editar', 'cUsuarios::crearEditar', ['filter' => ['authGuard:12', 'ajax']]);
	$routes->post('CambiarPass', 'cUsuarios::cambiarPass', ['filter' => ['authGuard:13', 'ajax']]);
	$routes->get('ValidaUsuario/(:any)/(:num)', 'cUsuarios::validaUsuario/$1/$2', ['filter' => ['authGuard:11,12', 'ajax']]);
});

//Pefiles
$routes->group('Perfiles', ['filter' => 'authGuard:2'], function ($routes) {
	$routes->get('/', 'cPerfiles::index');
	$routes->post('DT', 'cPerfiles::listaDT');
	$routes->post('Crear', 'cPerfiles::crearEditar', ['filter' => ['authGuard:21', 'ajax']]);
	$routes->post('Editar', 'cPerfiles::crearEditar', ['filter' => ['authGuard:22', 'ajax']]);
	$routes->post('Eliminar', 'cPerfiles::eliminar', ['filter' => ['authGuard:24', 'ajax']]);
});

//Categorias
$routes->group('Categorias', ['filter' => 'authGuard:3'], function ($routes) {
	$routes->get('/', 'cCategorias::index');
	$routes->post('DT', 'cCategorias::listaDT');
	$routes->post('Crear', 'cCategorias::crearEditar', ['filter' => ['authGuard:31', 'ajax']]);
	$routes->post('Editar', 'cCategorias::crearEditar', ['filter' => ['authGuard:32', 'ajax']]);
	$routes->post('Eliminar', 'cCategorias::eliminar', ['filter' => ['authGuard:33', 'ajax']]);
});

//Clientes
$routes->group('Clientes', ['filter' => 'authGuard:4'], function ($routes) {
	$routes->get('/', 'cClientes::index');
	$routes->post('DT', 'cClientes::listaDT');
	$routes->post('Crear', 'cClientes::crearEditar', ['filter' => ['authGuard:41', 'ajax']]);
	$routes->post('Editar', 'cClientes::crearEditar', ['filter' => ['authGuard:42', 'ajax']]);
	$routes->post('Eliminar', 'cClientes::eliminar', ['filter' => ['authGuard:43', 'ajax']]);
	$routes->get('Validar/(:any)/(:num)', 'cClientes::validaCliente/$1/$2', ['filter' => ['authGuard:41,42', 'ajax']]);
});

//Productos
$routes->group('Productos', ['filter' => 'authGuard:5'], function ($routes) {
	$routes->get('/', 'cProductos::index');
	$routes->post('DT', 'cProductos::listaDT');
	$routes->get('Foto', 'cProductos::foto');
	$routes->get('Foto/(:num)/(:any)', 'cProductos::foto/$1/$2');
	$routes->post('Crear', 'cProductos::crearEditar', ['filter' => ['authGuard:51', 'ajax']]);
	$routes->post('Editar', 'cProductos::crearEditar', ['filter' => ['authGuard:52', 'ajax']]);
	$routes->get('ValidaProducto/(:any)/(:any)/(:num)', 'cProductos::validarProducto/$1/$2/$3', ['filter' => ['authGuard:51,52', 'ajax']]);
	$routes->post('Eliminar', 'cProductos::eliminar', ['filter' => ['authGuard:53', 'ajax']]);
});

//Ventas
$routes->group('Ventas', ['filter' => 'authGuard:6'], function ($routes) {
	$routes->get('Administrar', 'cVentas::index');
	$routes->post('DT', 'cVentas::listaDT');
	$routes->post('DTProductos', 'cProductos::listaDT');
	$routes->get('Crear', 'cVentas::crear');
	$routes->get('Editar/(:num)', 'cVentas::editar/$1');
	$routes->post('Eliminar', 'cVentas::eliminar', ['filter' => 'ajax']);
	$routes->post('Crear', 'cVentas::crearEditar', ['filter' => 'ajax']);
	$routes->post('Editar', 'cVentas::guardarEditar', ['filter' => 'ajax']);
	$routes->get('Cargar/(:num)', 'cVentas::cargarVenta/$1', ['filter' => 'ajax']);
});

//Ventas
$routes->group('Busqueda', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('DT', 'cBusqueda::dataTables');
	$routes->post('Vendedores', 'cUsuarios::listaDT');
	$routes->post('Vendedor', 'cUsuarios::getUsuario', ['filter' => 'ajax']);
	$routes->post('Clientes', 'cClientes::listaDT');
	$routes->post('Cliente', 'cClientes::getCliente', ['filter' => 'ajax']);
});

//Permisos
$routes->group('Permisos', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('Perfil/(:num)', 'cPermisos::Permisos/$1/perfilId', ['filter' => ['authGuard:23', 'ajax']]);
	$routes->get('Usuarios/(:num)', 'cPermisos::Permisos/$1/usuarioId', ['filter' => ['authGuard:15', 'ajax']]);
	$routes->post('Guardar', 'cPermisos::Guardar', ['filter' => ['authGuard:15,23', 'ajax']]);
	$routes->post('Sincronizar', 'cPermisos::sincronizar', ['filter' => ['ajax']]);
});

//Configuración
$routes->group('Configuracion', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('/', 'cConfiguracion::index', ['filter' => 'authGuard:7']);
	$routes->get('Datos', 'cConfiguracion::datos', ['filter' => ['ajax']]);
	$routes->post('Actualizar', 'cConfiguracion::actualizar', ['filter' => ['authGuard:71', 'ajax']]);
});

//Manifiesto
$routes->group('Manifiesto', ['filter' => 'authGuard:8'], function ($routes) {
    $routes->get('/', 'cManifiesto::index');
    $routes->post('DT', 'cManifiesto::listaDT');
    $routes->get('Archivo/(:any)', 'cManifiesto::archivo/$1');
    $routes->post('DTProductos', 'cManifiesto::listaDTProds');
    $routes->post('AgregarProducto', 'cManifiesto::actualizarManifiesto');
    $routes->get('Descargar/(:any)', 'cManifiesto::descargarVerArchivo/$1/0');
    $routes->get('Ver/(:any)', 'cManifiesto::descargarVerArchivo/$1/1');
    $routes->post('Crear', 'cManifiesto::crearEditar', ['filter' => ['authGuard:81', 'ajax']]);
    $routes->post('Editar', 'cManifiesto::crearEditar', ['filter' => ['authGuard:82', 'ajax']]);
    $routes->post('Eliminar', 'cManifiesto::eliminar', ['filter' => ['authGuard:83', 'ajax']]);
});

$routes->group('Perfil', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'cMiPerfil::index');
		$routes->post('Editar', 'cMiPerfil::editar', ['filter' => ['authGuard', 'ajax']]);
		$routes->post('Password', 'cMiPerfil::password', ['filter' => ['authGuard', 'ajax']]);
});

//Reportes
$routes->group('Reportes', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('Factura/(:num)', 'cReportes::factura/$1');
	$routes->get('Pedido/(:num)', 'cReportes::pedido/$1');
	//$routes->get('DT', 'cManifiesto::listaDT');
});

//Almacenes
$routes->group('Almacen', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('/', 'cAlmacen::index');
	$routes->post('DT', 'cAlmacen::listaDT');
	$routes->post('Crear', 'cAlmacen::crearEditar', ['filter' => ['authGuard', 'ajax']]);
	$routes->post('Editar', 'cAlmacen::crearEditar', ['filter' => ['authGuard', 'ajax']]);
	$routes->post('Eliminar', 'cAlmacen::eliminar', ['filter' => ['authGuard', 'ajax']]);
});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
