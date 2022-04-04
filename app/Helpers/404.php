<?php
if (! function_exists('show_404')) {

    function show_404() {
      echo view('errors/html/error_404');
    }
}
