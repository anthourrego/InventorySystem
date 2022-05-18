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
    $routes->get('/', 'Clientes::index');
    $routes->post('DT', 'Clientes::listaDT');
    $routes->post('Eliminar', 'Clientes::eliminar');
    $routes->post('Crear', 'Clientes::crearEditar');
    $routes->post('Editar', 'Clientes::crearEditar');
    $routes->get('Validar/(:any)/(:num)', 'Clientes::validaCliente/$1/$2');
});

//Productos
$routes->group('Productos', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'Productos::index');
    $routes->post('DT', 'Productos::listaDT');
    $routes->get('ValidaProducto/(:any)/(:any)/(:num)', 'Productos::validarProducto/$1/$2/$3');
    $routes->post('Crear', 'Productos::crearEditar');
    $routes->post('Editar', 'Productos::crearEditar');
    $routes->get('Foto', 'Productos::foto');
    $routes->get('Foto/(:num)/(:any)', 'Productos::foto/$1/$2');
    $routes->post('Eliminar', 'Productos::eliminar');
});

//Ventas
$routes->group('Ventas', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('Administrar', 'Ventas::index');
    $routes->get('Crear', 'Ventas::crear');
    $routes->get('Editar/(:num)', 'Ventas::editar/$1');
    $routes->post('DT', 'Ventas::listaDT');
    $routes->post('Eliminar', 'Ventas::eliminar');
    $routes->post('DTProductos', 'Productos::listaDT');
    $routes->post('Crear', 'Ventas::crearEditar');
    $routes->post('Editar', 'Ventas::crearEditar');
});

//Ventas
$routes->group('Busqueda', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('DT', 'Busqueda::dataTables');
    $routes->post('Vendedores', 'Usuarios::listaDT');
    $routes->post('Vendedor', 'Usuarios::getUsuario', ['filter' => 'ajax']);
    $routes->post('Clientes', 'Clientes::listaDT');
    $routes->post('Cliente', 'Clientes::getCliente');
});

//Permisos
$routes->group('Permisos', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('Perfil/(:num)', 'Permisos::Permisos/$1/perfilId', ['filter' => 'authGuard:23']);
    $routes->get('Usuarios/(:num)', 'Permisos::Permisos/$1/usuarioId', ['filter' => 'authGuard:15']);
    $routes->post('Guardar', 'Permisos::Guardar', ['filter' => 'authGuard:15,23']);
    $routes->post('Sincronizar', 'Permisos::sincronizar');
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
