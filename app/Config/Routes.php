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
$routes->setAutoRoute(true);

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

//Usuarios
$routes->group('Usuarios', ['filter' => 'authGuard:1'], function ($routes) {
    $routes->get('/', 'Usuarios::index');
    $routes->post('DT', 'Usuarios::listaDT');
    $routes->get('Foto', 'Usuarios::foto');
    $routes->get('Foto/(:any)', 'Usuarios::foto/$1');
    $routes->post('Eliminar', 'Usuarios::eliminar', ['filter' => ['authGuard:14', 'ajax']]);
    $routes->post('Crear', 'Usuarios::crearEditar', ['filter' => ['authGuard:11', 'ajax']]);
    $routes->post('Editar', 'Usuarios::crearEditar', ['filter' => ['authGuard:12', 'ajax']]);
    $routes->post('CambiarPass', 'Usuarios::cambiarPass', ['filter' => ['authGuard:13', 'ajax']]);
    $routes->get('ValidaUsuario/(:any)/(:num)', 'Usuarios::validaUsuario/$1/$2', ['filter' => ['authGuard:11,12', 'ajax']]);
});

//Pefiles
$routes->group('Perfiles', ['filter' => 'authGuard:2'], function ($routes) {
    $routes->get('/', 'Perfiles::index');
    $routes->post('DT', 'Perfiles::listaDT');
    $routes->post('Crear', 'Perfiles::crearEditar', ['filter' => ['authGuard:21', 'ajax']]);
    $routes->post('Editar', 'Perfiles::crearEditar', ['filter' => ['authGuard:22', 'ajax']]);
    $routes->post('Eliminar', 'Perfiles::eliminar', ['filter' => ['authGuard:24', 'ajax']]);
});

//Categorias
$routes->group('Categorias', ['filter' => 'authGuard:3'], function ($routes) {
    $routes->get('/', 'Categorias::index');
    $routes->post('DT', 'Categorias::listaDT');
    $routes->post('Crear', 'Categorias::crearEditar', ['filter' => ['authGuard:31', 'ajax']]);
    $routes->post('Editar', 'Categorias::crearEditar', ['filter' => ['authGuard:32', 'ajax']]);
    $routes->post('Eliminar', 'Categorias::eliminar', ['filter' => ['authGuard:33', 'ajax']]);
});

//Clientes
$routes->group('Clientes', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'ClientesController::index');
    $routes->post('DT', 'ClientesController::listaDT');
    $routes->post('Eliminar', 'ClientesController::eliminar');
    $routes->post('Crear', 'ClientesController::crearEditar');
    $routes->post('Editar', 'ClientesController::crearEditar');
    $routes->get('Validar/(:any)/(:num)', 'ClientesController::validaCliente/$1/$2');
});

//Productos
$routes->group('Productos', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'ProductosController::index');
    $routes->post('DT', 'ProductosController::listaDT');
    $routes->get('ValidaProducto/(:any)/(:any)/(:num)', 'ProductosController::validarProducto/$1/$2/$3');
    $routes->post('Crear', 'ProductosController::crearEditar');
    $routes->post('Editar', 'ProductosController::crearEditar');
    $routes->get('Foto', 'ProductosController::foto');
    $routes->get('Foto/(:num)/(:any)', 'ProductosController::foto/$1/$2');
    $routes->post('Eliminar', 'ProductosController::eliminar');
});

//Ventas
$routes->group('Ventas', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('Administrar', 'VentasController::index');
    $routes->get('Crear', 'VentasController::crear');
    $routes->get('Editar/(:num)', 'VentasController::editar/$1');
    $routes->post('DT', 'VentasController::listaDT');
    $routes->post('Eliminar', 'VentasController::eliminar');
    $routes->post('DTProductos', 'ProductosController::listaDT');
    $routes->post('Crear', 'VentasController::crearEditar');
    $routes->post('Editar', 'VentasController::crearEditar');
});

//Ventas
$routes->group('Busqueda', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('DT', 'BusquedaController::dataTables');
    $routes->post('Vendedores', 'UsuariosController::listaDT');
    $routes->post('Vendedor', 'UsuariosController::getUsuario', ['filter' => 'ajax']);
    $routes->post('Clientes', 'ClientesController::listaDT');
    $routes->post('Cliente', 'ClientesController::getCliente');
});

//Permisos
$routes->group('Permisos', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('Perfil/(:num)', 'PermisosController::Permisos/$1/perfilId', ['filter' => 'authGuard:23']);
    $routes->get('Usuarios/(:num)', 'PermisosController::Permisos/$1/usuarioId', ['filter' => 'authGuard:15']);
    $routes->post('Guardar', 'PermisosController::Guardar', ['filter' => 'authGuard:15,23']);
    $routes->post('Sincronizar', 'PermisosController::sincronizar');
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
