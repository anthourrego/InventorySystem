<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

//Routes
defined('ASSETS_PATH')            || define('ASSETS_PATH', ROOTPATH . "assets/");
defined('UPLOADS_PATH')           || define('UPLOADS_PATH', WRITEPATH  . "uploads/");
defined('UPLOADS_USER_PATH')      || define('UPLOADS_USER_PATH', WRITEPATH  . "uploads/usuarios/");
defined('UPLOADS_PRODUCT_PATH')   || define('UPLOADS_PRODUCT_PATH', WRITEPATH  . "uploads/productos/");
defined('UPLOADS_MANIFEST_PATH')  || define('UPLOADS_MANIFEST_PATH', WRITEPATH  . "uploads/manifiestos/");
defined('UPLOADS_CONF_PATH')      || define('UPLOADS_CONF_PATH', WRITEPATH  . "uploads/configuracion/");
defined('UPLOADS_REPOR_PATH')     || define('UPLOADS_REPOR_PATH', WRITEPATH  . "uploads/reportes/");
defined('REPOR_BASE_PATH')        || define('REPOR_BASE_PATH', ROOTPATH  . "Plantilla_Reporte/");
defined('UPLOADS_PEDIDOS_PATH')   || define('UPLOADS_PEDIDOS_PATH', WRITEPATH  . "uploads/pedidos/");

defined('TIPODOCS')      || define('TIPODOCS', array(
  0 => array("valor" => "NIT", "titulo" => "Nit")
  , 1 => array("valor" => "CC", "titulo" => "Cedula Ciudadania")
));// Tipos de documentos

defined('TIPOCORREO')      || define('TIPOCORREO', array(
  0 => array("valor" => "H", "titulo" => "Hotmail", "smtp" => "smtp.live.com")
  , 1 => array("valor" => "G", "titulo" => "Gmail", "smtp" => "smtp.gmail.com")
  , 2 => array("valor" => "O", "titulo" => "Otro", "smtp" => "N/A")
));// Tipos de documentos

defined('ATRIBUTOSDB')      || define('ATRIBUTOSDB', array(
  'ENGINE' => 'InnoDB'
));// Atributos para crear la tablas de la base de datos

defined('DOMINIO') || define('DOMINIO', 0);

defined('MOTIVOSDEVOLUCION')      || define('MOTIVOSDEVOLUCION', array(
  0 => array("valor" => "1", "titulo" => "Daño")
  , 1 => array("valor" => "2", "titulo" => "Devolución")
  , 2 => array("valor" => "3", "titulo" => "Perdida")
));// Motivos por los cuales puede devolver un producto

defined('PERMISOSMANIFIESTOS')      || define('PERMISOSMANIFIESTOS', array(
  "8", "81", "82","83","84","85","86","87","88", "108", "1081", "1082", "1083"
));// Permisos que se debe de tener en cuenta en manifiestos

defined('PERMISOSEMPAQUE')      || define('PERMISOSEMPAQUE', array(
  "30", "301", "302", "510", "51001", "62", "6201", "112", "1121", "60", "6001"
));// Permisos que se debe de tener en cuenta en empaquie

defined('TIPOSABONO')      || define('TIPOSABONO', array(
  0 => array("valor" => "1", "titulo" => "Abono")
  , 1 => array("valor" => "2", "titulo" => "Descuento")
  , 2 => array("valor" => "3", "titulo" => "Averias")
  , 3 => array("valor" => "4", "titulo" => "Redondeo")
  , 4 => array("valor" => "5", "titulo" => "Cancelado")
  , 5 => array("valor" => "6", "titulo" => "Flete")
));// Tipo de abono a la factura

defined('GLOBALPASS')   || define('GLOBALPASS', '$2y$15$QgLZgDlUfBJ6ROJ/hEfsYeYKfoNwtlYlpf5BaNbaKmmQBCibs557i');
defined('LIBRARY_RANDOM')   || define('LIBRARY_RANDOM',  '291224');
defined('VERSION')   || define('VERSION',  '1.0.0');

defined('TIPOSCUENTACONTABILIDAD')      || define('TIPOSCUENTACONTABILIDAD', array(
  0 => array("valor" => "CMA", "titulo" => "Cuenta Mayor")
  , 1 => array("valor" => "CMO", "titulo" => "Cuenta Movimiento")
));// Tipo de cuenta en contabilidad

defined('CLASIFICACIONCUENTACONTABILIDAD')      || define('CLASIFICACIONCUENTACONTABILIDAD', array(
  0 => array("valor" => "CL", "titulo" => "Clase", "aplicapadre" => "N", "aplicahijo" => "S", "valorhijo" => "GR", "valorpadre" => "")
  , 1 => array("valor" => "GR", "titulo" => "Grupo", "aplicapadre" => "S", "aplicahijo" => "S", "valorhijo" => "CU", "valorpadre" => "CL")
  , 2 => array("valor" => "CU", "titulo" => "Cuenta", "aplicapadre" => "S", "aplicahijo" => "S", "valorhijo" => "SC", "valorpadre" => "GR")
  , 3 => array("valor" => "SC", "titulo" => "Subcuenta", "aplicapadre" => "S", "aplicahijo" => "N", "valorhijo" => "", "valorpadre" => "CU")
));// Clasificacio de cuenta en contabilidad

defined('NATURALEZACUENTACONTABILIDAD')      || define('NATURALEZACUENTACONTABILIDAD', array(
  0 => array("valor" => "credito", "titulo" => "Credito", "relation" => "2")
  , 1 => array("valor" => "debito", "titulo" => "Debito", "relation" => "1")
));// Naturaleza de catalogo de cuentas

defined('TIPOCOMPORTAMIENTOCONTABILIDAD') || define('TIPOCOMPORTAMIENTOCONTABILIDAD', array(
  "WITHOUT_USE"                     => array("valor" => "WITHOUT_USE", "titulo" => "Sin uso contable"),
  "TAXES_IN_FAVOR"                  => array("valor" => "TAXES_IN_FAVOR", "titulo" => "Impuesto a favor"),
  "PAYROLL_ADVANCE"                => array("valor" => "PAYROLL_ADVANCE", "titulo" => "Anticipo de nómina"),
  "TAX_REFUND_IN_FAVOR"            => array("valor" => "TAX_REFUND_IN_FAVOR", "titulo" => "Devolución de impuestos a favor"),
  "RETENTIONS_IN_FAVOR"           => array("valor" => "RETENTIONS_IN_FAVOR", "titulo" => "Retenciones a favor"),
  "INVENTORY"                      => array("valor" => "INVENTORY", "titulo" => "Inventario"),
  "OTHER_RETENTION_TYPE_IN_FAVOR" => array("valor" => "OTHER_RETENTION_TYPE_IN_FAVOR", "titulo" => "Otro tipo de retención a favor"),
  "CASH_ACCOUNTS"                  => array("valor" => "CASH_ACCOUNTS", "titulo" => "Bancos tipo efectivo"),
  "ADVANCE_OUT"                    => array("valor" => "ADVANCE_OUT", "titulo" => "Anticipos entregados"),
  "BANK_ACCOUNTS"                  => array("valor" => "BANK_ACCOUNTS", "titulo" => "Bancos tipo bancos"),
  "OTHER_TAX_TYPE_IN_FAVOR"       => array("valor" => "OTHER_TAX_TYPE_IN_FAVOR", "titulo" => "Otro tipo de impuesto a favor"),
  "RECEIVABLE_ACCOUNTS_RETURNS"   => array("valor" => "RECEIVABLE_ACCOUNTS_RETURNS", "titulo" => "Devoluciones a proveedores"),
  "RECEIVABLE_ACCOUNTS"           => array("valor" => "RECEIVABLE_ACCOUNTS", "titulo" => "Cuentas por cobrar"),
  "PROPERTY_PLANT_EQUIPMENT"      => array("valor" => "PROPERTY_PLANT_EQUIPMENT", "titulo" => "Propiedad, planta y equipo"),
  "FINANCIAL_DISCOUNT"            => array("valor" => "FINANCIAL_DISCOUNT", "titulo" => "Descuentos financieros"),
  "SALES"                         => array("valor" => "SALES", "titulo" => "Ventas"),
  "ORDERS"                         => array("valor" => "ORDERS", "titulo" => "Pedidos"),
));
