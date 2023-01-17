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
              printf('<link href="%s" rel="stylesheet"/>', base_url(esc($css2)));
            }
          } else {
            printf('<link href="%s" rel="stylesheet"/>', base_url(esc($css1)));
          }
        }
      }
    ?>
  </head>

  <body>
    <div class="container-fluid p-3 d-none" id="validaClave">

      <?php if (!is_null($factura)) { ?>

        <div class="d-flex justify-content-around align-items-center mb-3">
          <img src="<?= base_url() ?>/FotoEmpresa" width="130px" height="100px">
          <h3 class="text-center">Factura <br> <?= $factura->codigo ?></h3>
        </div>

        <div class="container my-2">
          <div class="row">
            <div class="col-3">
              <div class="font-weight-bold">Cliente:</div>
            </div>
            <div class="col-9">
              <div class="text-weight"><?= $factura->Cliente ?></div>
            </div>
            <div class="col-3">
              <div class="font-weight-bold">Fecha:</div>
            </div>
            <div class="col-9">
              <div class="text-weight"><?= $factura->Fecha ?></div>
            </div>
            <div class="col-3">
              <div class="font-weight-bold">Dirección:</div>
            </div>
            <div class="col-9">
              <div class="text-weight"><?= $factura->Direccion ?></div>
            </div>
            <div class="col-3">
              <div class="font-weight-bold">Teléfono:</div>
            </div>
            <div class="col-9">
              <div class="text-weight"><?= $factura->Telefono ?></div>
            </div>
            <div class="col-3">
              <div class="font-weight-bold">Ciudad:</div>
            </div>
            <div class="col-9">
              <div class="text-weight"><?= $factura->Ciudad ?>, <?= $factura->Depto ?></div>
            </div>
            <div class="col-3">
              <div class="font-weight-bold">Vendedor:</div>
            </div>
            <div class="col-9">
              <div class="text-weight"><?= $factura->Vendedor ?></div>
            </div>
          </div>
        </div>

        <div class="container botones-acciones">
          
          <a type='button' class='btn btn-primary w-100 mb-2' id='btnDescargar' href='<?= base_url() ?>/ReportesQR/Factura/<?= $factura->id ?>/1/0' target='_blank'>
            <i class='fas fa-download'></i> Descargar
          </a>

          <!-- <a type='button' class='btn btn-secondary w-100 mb-2' id='btnDescargar' href='<?= base_url() ?>/ReportesQR/FacturaFoto/<?= $factura->id ?>/1/0/1' target='_blank'>
            <i class='fas fa-camera'></i> Descargar Con Foto
          </a> -->
    
          <button type="button" class="btn btn-info w-100 mb-2" onclick="verEnlinea()">
            <i class="fas fa-eye"></i> Ver En Linea
          </button>
        </div>

        <div class="container lista-cajas-en-linea d-none">
          <button type="button" class="btn btn-info w-100 mb-2" onclick="regresarEnlinea()">
            <i class="fas fa-chevron-left"></i> Regresar
          </button>
          <?php
            if (count($cajas) > 0) {
              foreach ($cajas as $key => $value) {
                $lisProd = "";
                foreach ($value->productos as $llave => $prod) {
                  $lisProd .= "
                    <li class='list-group-item'>
                      <div class='row'>
                        <div class='col-3'>
                          <img src='" . base_url() . "/fotoProductosAPP/$prod->id/$prod->imagen' alt='' class='img-thumbnail'>
                        </div>
                        <div class='col-9'>
                          <div class='d-flex justify-content-between align-items-center'>
                            $prod->item - $prod->referencia
                            <span class='badge badge-primary badge-pill'>Cant: $prod->cantidad</span>
                          </div>
                          <small>$ $prod->valor</small>
                        </div>
                      </div>
                    </li>
                  ";
                }
                echo "
                  <div class='card'>
                    <h5 class='card-header'>
                      <i class='fa-solid fa-box mr-1'></i> Caja $value->numeroCaja
                    </h5>
                    <ul class='list-group list-group-flush'>$lisProd</ul>
                  </div>
                ";
              }
            } else {
              echo "<div class='font-weight-bold text-center p-2 col-12'>No se encontraron cajas</div>";
            }
          ?>
        </div>

      <?php } else { ?>

        <div class="alert alert-warning text-center">
          No se encontro factura relacionada o no esta disponible
        </div>

      <?php } ?>

    </div>

    <div class="container-fluid p-3" id="nitNoValido">
      <?php if ($nitEmpresa == '') { ?>
          <div class="alert alert-warning text-center d-none">
            Los datos de la empresa no son validos o no estan registrados
          </div>
      <?php } else { ?>
        <button type="button" class="btn btn-info w-100 mb-2 d-none" onclick="validarClave()">
          <i class="fas fa-refresh"></i> Reintentar Acceso
        </button>
      <?php } ?>
    </div>

  </body>

  <?php 
    if(isset($js)){
      foreach ($js as $js1) {
        if(is_array($js1)) {
          foreach ($js1 as $js2) {
            printf('<script src="%s"></script>', base_url(esc($js2)));
          }
        } else {
          printf('<script src="%s"></script>', base_url(esc($js1)));
        }
      }
    }
  ?>

  <script>

    let $nit = <?= $nitEmpresa ?>;

    document.addEventListener('DOMContentLoaded', function (e) {
      alertify.defaults.theme.ok = "btn btn-primary";
      alertify.defaults.theme.cancel = "btn btn-danger";
      alertify.defaults.theme.input = "form-control";
      alertify.defaults.glossary.ok = '<i class="fas fa-check"></i> Aceptar';
      alertify.defaults.glossary.cancel = '<i class="fas fa-times"></i> Cancelar';
      
      if ($nit == '') {
        $("#nitNoValido").find('div').removeClass('d-none');
      } else {
        $("#nitNoValido").find('button').removeClass('d-none');
        validarClave();
      }
    });

    function regresarEnlinea() {
      $('.lista-cajas-en-linea').addClass('d-none');
      $('.botones-acciones').removeClass('d-none');
    }

    function verEnlinea() {
      $('.lista-cajas-en-linea').removeClass('d-none');
      $('.botones-acciones').addClass('d-none');
    }

    function validarClave() {
      alertify.prompt('Advertencia', 'Digite el nit de la empresa', '', function (evt, value) {
        if (value != '') {

          if ($nit == value) {

            $("#nitNoValido").addClass('d-none');
            $("#validaClave").removeClass('d-none');

          } else {
            alertify.warning('El nit no es valido');
            setTimeout(() => {
              validarClave();
            }, 0);
          }
        } else {
          alertify.warning('Ingrese un valor valido');
          setTimeout(() => {
            validarClave();
          }, 0);
        }
      }, function () { });

      // validaClave
    }
  </script>

</html>