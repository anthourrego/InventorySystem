<?php if (isset($datosContent->id)) { ?>

  <div class="row mb-2">
    <?php if ($modulo == "producto") { ?>
      <div class="col-12 col-md-3">
        <span class="text-bold">Referencia: </span> <?= $datosContent->referencia ?>
      </div>
      <div class="col-12 col-md-3">
        <span class="text-bold">Item: </span> <?= $datosContent->item ?>
      </div>
      <div class="col-12 col-md-4">
        <span class="text-bold">Descripción: </span> <?= $datosContent->descripcion ?>
      </div>
    <?php } ?>

    <?php if ($modulo == "factura") { ?>
      <div class="col-12 col-md-4">
        <span class="text-bold">Código: </span> <?= $datosContent->codigo ?>
      </div>
      <div class="col-12 col-md-4">
        <span class="text-bold">Cliente: </span> <?= $datosContent->NombreCliente ?>
      </div>
      <div class="col-12 col-md-4">
        <span class="text-bold">Vendedor: </span> <?= $datosContent->NombreVendedor ?>
      </div>
    <?php } ?>

    <?php if ($modulo == "pedido") { ?>
      <div class="col-12 col-md-4">
        <span class="text-bold">Código: </span> <?= $datosContent->pedido ?>
      </div>
      <div class="col-12 col-md-4">
        <span class="text-bold">Cliente: </span> <?= $datosContent->NombreCliente ?>
      </div>
      <div class="col-12 col-md-4">
        <span class="text-bold">Vendedor: </span> <?= $datosContent->NombreVendedor ?>
      </div>
    <?php } ?>
  </div>
<?php } ?>

<div class="table-responsive">
  <table id="tableProdsReported" class="table table-sm table-striped table-hover table-bordered w-100">
    <thead> 
      <tr>
        <th>Referencia | Item</th>
        <th>Descripción</th>
        <th>Pedido</th>
        <th>Cantidad Reportada</th>
        <th>Fecha</th>
        <th>Motivo</th>
        <th>Observación</th>
        <th>Fecha Confirmado</th>
        <th>Cantidad Perdida</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<div class="modal fade modalFormulario" id="modalConfrontarProductoReportado" data-backdrop="static" data-keyboard="false" aria-labelledby="modalConfrontarProductoReportadoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confrontar Producto</h5>
        <button type="button" class="close btnCloseModalProdReported" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formProdReportedConfirm" class="formValid">
          <div class="form-row">
            <div class="col-12 col-md-4 form-group form-valid">
              <label class="mb-0" for="referProdReported">Referencia | Item </label>
              <input readonly class="form-control" id="referProdReported" type="text" autocomplete="off">
            </div>
            <div class="col-12 col-md-8 form-group form-valid">
              <label class="mb-0" for="descripProdReported">Descripción Producto </label>
              <input readonly class="form-control" id="descripProdReported" type="text" autocomplete="off">
            </div>
            <div class="col-12 col-md-3 form-group form-valid" id="fieldModalOrderProdReported">
              <label class="mb-0" for="orderProdReported">Pedido </label>
              <input readonly class="form-control" id="orderProdReported" type="text" autocomplete="off">
            </div>
            <div class="col-12 col-md-3 form-group form-valid">
              <label class="mb-0" for="motiveProdReported">Motivo </label>
              <input readonly class="form-control" id="motiveProdReported" type="text" autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label class="mb-0" for="descriptionProdReported">Descripción Reporte </label>
              <input readonly class="form-control" id="descriptionProdReported" type="text" autocomplete="off">
            </div>
            <div class="offset-4 col-4 form-group form-valid">
              <label class="mb-0" for="quantityProdReported">Cantidad Productos Perdidos </label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button type="button" class="btn btn-primary" onclick="quantityProdReportedModule(0)">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <input placeholder="Nombre" class="form-control text-center soloNumeros" id="quantityProdReported" name="quantityProdReported" type="text" required autocomplete="off">
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" onclick="quantityProdReportedModule(1)">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formProdReportedConfirm"><i class="fas fa-save"></i> Confirmar</button>
        <button type="button" class="btn btn-secondary btnCloseModalProdReported"><i class="fas fa-times"></i> Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $MODULOPRODUCTOSREPORTADOS = "<?= $modulo ?>";
  $IDREGISTROPRODUCTOSREPORTADOS ="<?= $idRegistro ?>";
  $DATAMAINPRODUCTOSREPORTADOS = JSON.parse('<?= json_encode($datosContent) ?>');
  $DATAMOTIVOSMODULEPRODUSREPORTED = JSON.parse('<?= json_encode(MOTIVOSDEVOLUCION) ?>');
</script>

<?php
if(isset($js_add_file)) {
  foreach ($js_add_file as $js_file) {
    if(is_array($js_file)) {
      foreach ($js_file as $js_add_file_two) {
        printf('<script src="%s"></script>', base_url("assets/js/" . esc($js_add_file_two) . "?" . rand()));
      }
    } else {
      printf('<script src="%s"></script>', base_url("assets/js/" . esc($js_file) . "?". rand() ));
    }
  }
}
?>