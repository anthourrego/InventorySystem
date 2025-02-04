<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('Foto/(:any)', 'Home::foto/$1');
$routes->get('productosAPP', 'cProductos::productosAPP');
$routes->get('fotoProductosAPP/(:num)/(:any)', 'cProductos::foto/$1/$2');
$routes->post('iniciarSesion', 'Home::iniciarSesion', ['filter' => 'ajax']);
$routes->post('cerrarSesion', 'Home::cerrarSesion', ['filter' => ['authGuard', 'ajax']]);
$routes->post('sidebar', 'Home::sidebar', ['filter' => ['authGuard', 'ajax']]);

/* Ruta para la lectura de QR */
//$routes->get('FacturaQR/(:num)/(:num)', 'cPedidos::facturaQR/$1/$2');
$routes->get('FotoEmpresa', 'Home::fotoEmpresa');


//Usuarios
$routes->group('Usuarios', ['filter' => 'authGuard:1'], function ($routes) {
	$routes->get('/', 'cUsuarios::index');
	$routes->post('DT', 'cUsuarios::listaDT');
	$routes->get('Foto', 'cUsuarios::foto');
	$routes->get('Foto/(:any)', 'cUsuarios::foto/$1');
	$routes->post('Crear', 'cUsuarios::crearEditar', ['filter' => ['authGuard:11', 'ajax']]);
	$routes->post('Editar', 'cUsuarios::crearEditar', ['filter' => ['authGuard:12', 'ajax']]);
	$routes->post('CambiarPass', 'cUsuarios::cambiarPass', ['filter' => ['authGuard:13', 'ajax']]);
	$routes->post('Eliminar', 'cUsuarios::eliminar', ['filter' => ['authGuard:14', 'ajax']]);
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
	$routes->get('fotoEditada/(:num)/(:any)', 'cProductos::convertirFoto/$1/$2', ['filter' => ['authGuard:55']]);
	$routes->get('descargarFoto/(:num)', 'cProductos::descargarFoto/$1', ['filter' => ['authGuard:55']]);
	$routes->get('descargarFoto/(:num)/(:num)', 'cProductos::descargarFoto/$1/$2', ['filter' => ['authGuard:55']]);
	$routes->get('descargarFoto/(:num)/(:num)/(:num)', 'cProductos::descargarFoto/$1/$2/$3', ['filter' => ['authGuard:55']]);
	$routes->get('descargarFoto/(:num)/(:num)/(:num)/(:any)', 'cProductos::descargarFoto/$1/$2/$3/$4', ['filter' => ['authGuard:55']]);
	$routes->get('Sincronizar', 'cProductos::sincronizar', ['filter' => ['authGuard:56']]);
	$routes->get('ExportarExcel', 'cProductos::downloadExcelProducts');
	$routes->post('EditarUbicacion', 'cProductos::editarUbicacion', ['filter' => ['authGuard:59', 'ajax']]);
	$routes->get('TotalInventario/(:num)', 'cProductos::totalInventario/$1', ['filter' => ['authGuard:54,57', 'ajax']]);
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
	$routes->post('Vendedores', 'cUsuarios::getVendedores', ['filter' => 'ajax']);
	$routes->post('Clientes', 'cClientes::getClientes', ['filter' => 'ajax']);
	$routes->post('Sucursales', 'cSucursales::getSucursales', ['filter' => 'ajax']);
	$routes->post('SucursalesClientes', 'cSucursales::getSucursalesClientes', ['filter' => 'ajax']);
	$routes->post('Proveedores', 'cProveedores::getProveedores', ['filter' => 'ajax']);
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
	$routes->get('Tab/(:any)', 'cConfiguracion::index/$1', ['filter' => 'authGuard:7']);
	$routes->get('Datos', 'cConfiguracion::datos', ['filter' => ['ajax']]);
	$routes->post('Actualizar', 'cConfiguracion::actualizar', ['filter' => ['authGuard:71', 'ajax']]);
	$routes->get('Foto', 'cConfiguracion::foto');
	$routes->get('Foto/(:any)', 'cConfiguracion::foto/$1');
	$routes->post('Eliminar', 'cConfiguracion::eliminar');
});

//Modificar Reportes
$routes->group('ModificarReporte', ['filter' => 'authGuard:7'], function ($routes) {
	$routes->get('Reporte/(:any)', 'cModificarReporte::reporte/$1');
	$routes->post('Guardar', 'cModificarReporte::guardar');
	$routes->post('Plantilla', 'cModificarReporte::plantilla');
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
	$routes->post('ActualizarConfig', 'cMiPerfil::actualizar', ['filter' => ['authGuard', 'ajax']]);
});

//Reportes
$routes->group('Reportes', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('Factura/(:num)', 'cReportes::factura/$1');
	$routes->get('Factura/(:num)/(:num)', 'cReportes::factura/$1/$2');
	$routes->get('Pedido/(:num)/(:num)', 'cReportes::pedido/$1/$2');
	$routes->get('Rotulo/(:num)/(:num)', 'cReportes::rotulo/$1/$2');
	$routes->get('Manifiestos/(:any)', 'cReportes::manifiestos/$1');
	$routes->get('Envio/(:num)/(:any)', 'cReportes::envio/$1/$2');
	$routes->get('Empaque/(:num)/(:num)', 'cReportes::empaque/$1/$2');
	$routes->get('Compra/(:num)/(:num)', 'cReportes::compra/$1/$2');
	$routes->get('IngresoMercancia/(:num)/(:num)', 'cReportes::ingresoMercancia/$1/$2');
	$routes->get('StickerCompra/(:num)/(:num)', 'cReportes::stickerCompra/$1/$2');
	$routes->get('ManifiestosSinRepetir/(:num)', 'cReportes::manifiestoSinRepetir/$1');
	$routes->get('CuentaCobrar/(:num)/(:num)', 'cReportes::cuentaCobrar/$1/$2');
	$routes->get('ReciboCaja/(:num)/(:num)', 'cReportes::reciboCaja/$1/$2');
});

//ReportesQR
/*$routes->group('ReportesQR', ['filter' => 'qrFactura'], function ($routes) {
	$routes->get('Pedido/(:num)/(:num)', 'cReportes::pedido/$1/$2');
	$routes->get('Factura/(:num)/(:num)/(:num)', 'cReportes::factura/$1/$2/$3');
	$routes->get('FacturaFoto/(:num)/(:num)/(:num)/(:num)', 'cReportes::factura/$1/$2/$3/$4');
	$routes->get('PedidoFoto/(:num)/(:num)/(:num)', 'cReportes::pedido/$1/$2/$3');
});*/

//Almacenes
$routes->group('Almacen', ['filter' => 'authGuard'], function ($routes) {
	$routes->get('/', 'cAlmacen::index');
	$routes->post('DT', 'cAlmacen::listaDT');
	$routes->post('Crear', 'cAlmacen::crearEditar', ['filter' => ['authGuard', 'ajax']]);
	$routes->post('Editar', 'cAlmacen::crearEditar', ['filter' => ['authGuard', 'ajax']]);
	$routes->post('Eliminar', 'cAlmacen::eliminar', ['filter' => ['authGuard', 'ajax']]);
});

//Sucursales
$routes->group('Sucursales', ['filter' => 'authGuard'], function ($routes) {
	$routes->post('DT', 'cSucursales::listaDT');
	$routes->post('Crear', 'cSucursales::crearEditar', ['filter' => ['authGuard', 'ajax']]);
	$routes->post('Editar', 'cSucursales::crearEditar', ['filter' => ['authGuard', 'ajax']]);
	$routes->post('Eliminar', 'cSucursales::eliminar', ['filter' => ['authGuard', 'ajax']]);
});

//Paises
$routes->group('Ubicacion/Paises', ['filter' => 'authGuard:91', 'namespace' => 'App\Controllers\Ubicacion'], function ($routes) {
	$routes->get('/', 'cPaises::index');
	$routes->post('DT', 'cPaises::listaDT');
	$routes->post('Crear', 'cPaises::crearEditar', ['filter' => ['authGuard:911', 'ajax']]);
	$routes->post('Editar', 'cPaises::crearEditar', ['filter' => ['authGuard:912', 'ajax']]);
	$routes->post('Eliminar', 'cPaises::eliminar', ['filter' => ['authGuard:913', 'ajax']]);
	$routes->get('Obtener', 'cPaises::getPaises');
});

//Departamentos
$routes->group('Ubicacion/Departamentos', ['filter' => 'authGuard:92', 'namespace' => 'App\Controllers\Ubicacion'], function ($routes) {
	$routes->get('/', 'cDepartamentos::index');
	$routes->post('DT', 'cDepartamentos::listaDT');
	$routes->post('Crear', 'cDepartamentos::crearEditar', ['filter' => ['authGuard:921', 'ajax']]);
	$routes->post('Editar', 'cDepartamentos::crearEditar', ['filter' => ['authGuard:922', 'ajax']]);
	$routes->post('Eliminar', 'cDepartamentos::eliminar', ['filter' => ['authGuard:923', 'ajax']]);
	$routes->get('ValidaDepto/(:any)/(:any)/(:num)', 'cDepartamentos::validarDepto/$1/$2/$3', ['filter' => ['authGuard:921,922', 'ajax']]);
	$routes->get('Obtener/(:num)', 'cDepartamentos::getDeptos/$1');
});

//Ciudades
$routes->group('Ubicacion/Ciudades', ['filter' => 'authGuard:93', 'namespace' => 'App\Controllers\Ubicacion'], function ($routes) {
	$routes->get('/', 'cCiudades::index');
	$routes->post('DT', 'cCiudades::listaDT');
	$routes->post('Crear', 'cCiudades::crearEditar', ['filter' => ['authGuard:931', 'ajax']]);
	$routes->post('Editar', 'cCiudades::crearEditar', ['filter' => ['authGuard:932', 'ajax']]);
	$routes->post('Eliminar', 'cCiudades::eliminar', ['filter' => ['authGuard:933', 'ajax']]);
	$routes->get('Obtener/(:num)', 'cCiudades::getCiudades/$1');
});

//Pedidos
$routes->group('Pedidos', ['filter' => 'authGuard:10'], function ($routes) {
	$routes->get('Administrar', 'cPedidos::index');
	$routes->post('DT', 'cPedidos::listaDT');
	$routes->post('DTProductos', 'cProductos::listaDT');
	$routes->get('Crear', 'cPedidos::crear');
	$routes->get('Editar/(:num)', 'cPedidos::editar/$1');
	$routes->post('Eliminar', 'cPedidos::eliminar', ['filter' => 'ajax']);
	$routes->post('EstadoPedido', 'cPedidos::estadoPedido', ['filter' => 'ajax']);
	$routes->post('FacturarPedido', 'cPedidos::facturarPedido', ['filter' => 'ajax']);
	$routes->post('Crear', 'cPedidos::crearEditar', ['filter' => 'ajax']);
	$routes->post('Editar', 'cPedidos::guardarEditar', ['filter' => 'ajax']);
	$routes->get('Cargar/(:num)', 'cPedidos::cargarPedido/$1', ['filter' => 'ajax']);
	$routes->get('CajasManifiestos/(:num)', 'cPedidos::cajasManifiestos/$1', ['filter' => 'ajax']);
	$routes->get('GenerarQR/(:num)', 'cPedidos::generarQR/$1');
	$routes->get('DetallePedido/(:num)', 'cPedidos::detallePedido/$1');
	$routes->get('DetallePedidoCaja/(:num)/(:num)', 'cPedidos::DetallePedidoCaja/$1/$2');
	$routes->post('ImportarExcel', 'cPedidos::ImportarExcel');
	$routes->get('DownloadExcel', 'cPedidos::downloadExcel');
});

//Empaque
$routes->group('Empaque', ['filter' => 'authGuard:30'], function ($routes) {
	$routes->get('/', 'cEmpaque::index');
	$routes->post('DT', 'cEmpaque::listaDT');
	$routes->post('IniciarEmpaque', 'cEmpaque::iniciarEmpaque');
	$routes->get('ProductosPedido/(:num)', 'cEmpaque::obtenerProductosPedido/$1');
	$routes->post('AgregarCaja', 'cEmpaque::agregarCaja');
	$routes->get('ObtenerProductosaCaja/(:num)', 'cEmpaque::obtenerProductosCaja/$1');
	$routes->post('EliminarCaja', 'cEmpaque::eliminarCaja');
	$routes->post('AgregarProductoCaja', 'cEmpaque::agregarProductoCaja');
	$routes->post('FinalizarEmpaque', 'cEmpaque::finalizarEmpaque');
	$routes->post('ReabrirCaja', 'cEmpaque::reabrirCaja');
	$routes->post('ReabrirEmpaque', 'cEmpaque::reabrirEmpaque');
	$routes->post('ObservacionProductos', 'cEmpaque::observacionProductos');
	$routes->post('Reordenarcajas', 'cEmpaque::reordenarCajas');
});

//Compras
$routes->group('Compras', ['filter' => 'authGuard:40'], function ($routes) {
	$routes->get('/', 'cCompras::index');
	$routes->post('DT', 'cCompras::listaDT');
	$routes->post('Crear', 'cCompras::crear', ['filter' => ['authGuard:401', 'ajax']]);
	$routes->post('Editar', 'cCompras::guardarEditar', ['filter' => ['authGuard:402', 'ajax']]);
	$routes->post('Confirmar', 'cCompras::confirmBuy', ['filter' => ['authGuard:403', 'ajax']]);
	$routes->post('Anular', 'cCompras::anular', ['filter' => ['authGuard:404', 'ajax']]);
	$routes->post('Clonar', 'cCompras::clonar', ['filter' => ['authGuard:405', 'ajax']]);
	$routes->get('ValidaProducto/(:any)/(:any)', 'cCompras::validarProducto/$1/$2', ['filter' => ['authGuard:401,402', 'ajax']]);
	$routes->get('CurrentBuy', 'cCompras::getCurrentBuy');
	$routes->get('ObtenerCompra/(:any)', 'cCompras::getBuy/$1');
});

// Proveedores
$routes->group('Proveedores', ['filter' => 'authGuard:50'], function ($routes) {
	$routes->get('/', 'cProveedores::index');
	$routes->post('DT', 'cProveedores::listaDT');
	$routes->post('Crear', 'cProveedores::crearEditar', ['filter' => ['authGuard:501', 'ajax']]);
	$routes->post('Editar', 'cProveedores::crearEditar', ['filter' => ['authGuard:502', 'ajax']]);
	$routes->post('Eliminar', 'cProveedores::eliminar', ['filter' => ['authGuard:503', 'ajax']]);
	$routes->get('Validar/(:any)/(:num)', 'cProveedores::validaProveedor/$1/$2', ['filter' => ['authGuard:501,502', 'ajax']]);
});

// Proveedores
$routes->group('ProductosReportados', ['filter' => 'authGuard:60', 'namespace' => 'App\Controllers\ProductosReportados'], function ($routes) {
	$routes->get('/', 'cProductosReportadosMenu::index');
	$routes->get('home/(:any)/(:num)', 'cProductosReportados::index/$1/$2');
	$routes->post('DT', 'cProductosReportados::listaDT');
	$routes->post('Confirmar', 'cProductosReportados::confirmar');
});

// Mobile app
$routes->group('Mobile', function ($routes) {
	$routes->post('Login', 'cClientes::inicioAppCliente');
});

//Ingreso Mercancia
$routes->group('IngresoMercancia', ['filter' => 'authGuard:80'], function ($routes) {
	$routes->get('/', 'cIngresoMercancia::index');
	$routes->get('Obtener/(:any)', 'cIngresoMercancia::getEntry/$1');
	$routes->get('ValidaProducto/(:any)/(:any)', 'cIngresoMercancia::validarProducto/$1/$2', ['filter' => ['authGuard:801,802', 'ajax']]);
	$routes->get('CurrentEntry', 'cIngresoMercancia::getCurrentEntry');
	$routes->post('DT', 'cIngresoMercancia::listaDT');
	$routes->post('Crear', 'cIngresoMercancia::crear', ['filter' => ['authGuard:801', 'ajax']]);
	$routes->post('Editar', 'cIngresoMercancia::guardarEditar', ['filter' => ['authGuard:802', 'ajax']]);
	$routes->post('Anular', 'cIngresoMercancia::anular', ['filter' => ['authGuard:804', 'ajax']]);
});

$routes->group('ReporteInventario', ['filter' => 'authGuard:90'], function ($routes) {
	$routes->get('/', 'cReporteInventario::index');
	$routes->post('DT', 'cReporteInventario::listaDT');
});

//Showroom
$routes->group('Showroom', ['filter' => 'authGuard:70'], function ($routes) {
	$routes->get('/', 'Showroom::index');
	$routes->post('DT', 'Showroom::listaDT');
	$routes->post('Crear', 'Showroom::crear', ['filter' => ['authGuard:7001', 'ajax']]);
	$routes->post('validShowroom', 'Showroom::validCurrentShowroom', ['filter' => ['authGuard:7001', 'ajax']]);
	$routes->post('changeStatusShowroom', 'Showroom::changeStatusShowroom', ['filter' => ['authGuard:7001', 'ajax']]);
});

// Abonos ventas
$routes->group('CuentasCobrar', ['filter' => 'authGuard:100'], function ($routes) {
	$routes->get('/', 'cCuentasCobrar::index');
	$routes->post('DT', 'cCuentasCobrar::listaDT');
	$routes->post('Crear', 'cCuentasCobrar::crear', ['filter' => ['authGuard:1001', 'ajax']]);
	$routes->post('Anular', 'cCuentasCobrar::anular', ['filter' => ['authGuard:1002', 'ajax']]);
	$routes->post('AsignarFechaVencimiento', 'cCuentasCobrar::AsignarFechaVencimiento', ['filter' => ['authGuard:1007', 'ajax']]);
	$routes->get('CurrentBuy', 'cCuentasCobrar::getCurrentBuy');
	$routes->get('ObtenerCuentaCobrar/(:any)', 'cCuentasCobrar::getAccounts/$1');
	$routes->post('ObtenerTotales', 'cCuentasCobrar::getTotalBalance');
});
