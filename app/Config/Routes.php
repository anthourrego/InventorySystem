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
$routes->post('/iniciarSesion', 'Home::iniciarSesion');


//Usuarios
$routes->group('Usuarios', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'UsuariosController::index');
    $routes->post('DT', 'UsuariosController::listaDT');
    $routes->get('Foto', 'UsuariosController::foto');
    $routes->get('Foto/(:any)', 'UsuariosController::foto/$1');
    $routes->post('Eliminar', 'UsuariosController::eliminar');
    $routes->post('Crear', 'UsuariosController::crearEditar');
    $routes->post('Editar', 'UsuariosController::crearEditar');
    $routes->get('ValidaUsuario/(:any)/(:num)', 'UsuariosController::validaUsuario/$1/$2');
    $routes->post('CambiarPass', 'UsuariosController::cambiarPass');
});

//Pefiles
$routes->group('Perfiles', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'PerfilesController::index');
    $routes->post('DT', 'PerfilesController::listaDT');
    $routes->post('Eliminar', 'PerfilesController::eliminar');
    $routes->post('Crear', 'PerfilesController::crearEditar');
    $routes->post('Editar', 'PerfilesController::crearEditar');
});

//Categorias
$routes->group('Categorias', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'CategoriasController::index');
    $routes->post('DT', 'CategoriasController::listaDT');
    $routes->post('Crear', 'CategoriasController::crearEditar');
    $routes->post('Editar', 'CategoriasController::crearEditar');
    $routes->post('Eliminar', 'CategoriasController::eliminar');
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
    /* $routes->get('ValidaProducto/(:any)/(:any)/(:num)', 'VentasController::validarProducto/$1/$2/$3');
    $routes->post('Editar', 'VentasController::crearEditar');
    $routes->get('Foto', 'VentasController::foto');
    $routes->get('Foto/(:num)/(:any)', 'VentasController::foto/$1/$2'); */
});

//Ventas
$routes->group('Busqueda', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('DT', 'BusquedaController::dataTables');
    $routes->post('Vendedores', 'UsuariosController::listaDT');
    $routes->post('Vendedor', 'UsuariosController::getUsuario');
    $routes->post('Clientes', 'ClientesController::listaDT');
    $routes->post('Cliente', 'ClientesController::getCliente');
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
