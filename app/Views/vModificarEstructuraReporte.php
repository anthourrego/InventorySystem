<?php if (isset($datReporte["url"])) { ?>
  <div class="row">
    <div class="col-4">
      <div class="card">
        <div class="card-body">   
          <!-- <div class="alert alert-warning" role="alert">
            <?php
              foreach ($instrucciones as $value) {
                echo "<span>" . $value . "</span></br>";
              }
            ?>
          </div> -->

          <h4 class="text-center">Variables</h4>

          <ul>
            <?php
              foreach ($variables as $key => $value) {
                echo "<li>{" . $key . "} - " . $value['descripcion'] . "</li>";
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-8">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-12 text-right">
              <button type="button" class="btn btn-primary" id="btnGuardar"><i class="fa-solid fa-edit"></i> Guardar Reporte</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <textarea name="editReporte" id="editReporte"><?= $contenidoEditor ?></textarea>
        </div>
      </div>
    </div>
  </div>

  <script>
      let dataEditor = `<?= $contenidoEditor; ?>`;
      let reporte = "<?= $reporte; ?>";
  </script>
<?php } else { ?>
  <div class="alert alert-warning text-center" role="alert" style="font-size: 20px">
    El reporte especificado no fue posible encontrarlo
  </div>
<?php } ?>