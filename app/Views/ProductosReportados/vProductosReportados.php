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
        <th>Item</th>
        <th>Referencia</th>
        <th>Descripción</th>
        <th>Pedido</th>
        <th>Cantidad En Pedido</th>
        <th>Cantidad Reportada</th>
        <th>Fecha</th>
        <th>Observación</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<script>
  $MODULOPRODUCTOSREPORTADOS = "<?= $modulo ?>";
  $IDREGISTROPRODUCTOSREPORTADOS ="<?= $idRegistro ?>";
  $DATAMAINPRODUCTOSREPORTADOS = JSON.parse('<?= json_encode($datosContent) ?>');
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