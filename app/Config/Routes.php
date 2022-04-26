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
    $routes->post('Crear', 'UsuariosController::crear');
    $routes->get('ValidaUsuario/(:any)/(:num)', 'UsuariosController::validaUsuario/$1/$2');
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
