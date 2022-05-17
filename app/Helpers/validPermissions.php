<?php
use CodeIgniter\HTTP\CLIRequest;

if (! function_exists('validPermissions')) {
  function validPermissions($permisos = [], $return = false, $ajax = false) {
    $cont = 0; 
    foreach ($permisos as $it) {
      if (!in_array($it, session()->get("permisos"))) {
        $cont++;
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
