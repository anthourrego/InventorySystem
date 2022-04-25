<?php
if (! function_exists('listErrors')) {
  function listErrors($errors) {
    $strValid = "";
    if(count($errors)) {
        $strValid = "<br><ul>";
        foreach ($errors as $valid) {
            $strValid .= "<li>{$valid}</li>";
        }
        $strValid .= "</ul>";
    }

    return $strValid;
  }
}
