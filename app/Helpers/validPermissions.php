<?php
if (! function_exists('validPermissions')) {
  function validPermissions($permisos = [], $return = false) {
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
        return redirect()->route('/');
      }
    }
  }
}
