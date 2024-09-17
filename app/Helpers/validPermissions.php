<?php
use CodeIgniter\HTTP\CLIRequest;

if (! function_exists('validPermissions')) {
  function validPermissions($permisos = [], $return = false, $ajax = false) {
    $configManifiesto = (int) (session()->has("manifiestoProducto") ? session()->get("manifiestoProducto") : '0');
    $cont = 0; 
    if (session()->has("permisos") === true) {
      foreach ($permisos as $it) {
        if (!in_array($it, session()->get("permisos"))) {
          $cont++;
        } else {
          //Validamos los permisos relacionado con los manifiestos
          if (in_array($it, PERMISOSMANIFIESTOS) && $configManifiesto == "0") {
            $cont++;  
          }
        }
      }
    }

    $validaPermiso = $cont >= count($permisos) ? true : false;

    if ($return == true) {
      return !$validaPermiso;
    } else {
      if ($validaPermiso) {
        if ($ajax) {
          echo view("UI/noPermissions");
          exit;
        } else {
          return redirect()->route('/');
        }
      }
    }
  }
}
