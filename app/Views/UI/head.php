<!doctype html>
<html lang="es">
  <meta charset="utf-8">
	<!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/icono-negro.ico') ?>">
  <title><?= (isset($title) ? "{$title} | " : '') . $Project_Name ?></title>
  <head>
    <?php 
      if(isset($css)){
        foreach ($css as $css1) {
          if(is_array($css1)) {
            foreach ($css1 as $css2) {
              echo(link_tag(esc($css2 . '?' . (ENVIRONMENT !== 'production' ? rand() : LIBRARY_RANDOM))));
            }
          } else {
            echo(link_tag(esc($css1 . '?' . (ENVIRONMENT !== 'production' ? rand() : LIBRARY_RANDOM))));
          }
        }
      }

      if(isset($css_add)){
        foreach ($css_add as $css_add1) {
          if(is_array($css_add1)) {
            foreach ($css_add1 as $css_add2) {
              echo(link_tag(esc("assets/css/{$css_add2}?" . (ENVIRONMENT !== 'production' ? rand() : LIBRARY_RANDOM))));
            }
          } else {
            echo(link_tag(esc("assets/css/{$css_add1}?" . (ENVIRONMENT !== 'production' ? rand() : LIBRARY_RANDOM))));
          }
        }
      }
    ?>
  </head>
  <body class="<?= session()->has("logged_in") && session()->get("logged_in") ? 'hold-transition sidebar-mini layout-fixed ' . (session()->has("sidebar") && session()->get("sidebar") == 'true' ? '' : 'sidebar-collapse') : ''?>">

    <div id="cargandoAjax" class="d-none"></div>
    <div id="cargando" class="d-none">
      <div class="box-loading">
        <div class="loader">
          <div class="loader-1">
            <div class="loader-2"></div>
          </div>
        </div>
      </div>
    </div>