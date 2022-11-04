<div class="card">
  <?php if (validPermissions([101], true)) { ?>
    <div class="card-header">
      <div class="row justify-content-between">
        <div class="offset-8 offset-md-9 col-5 col-md-3 text-right">
          <a href="<?= base_url("Pedidos/Crear") ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Crear</a>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
        <thead> 
          <tr>
            <th>Nro Pedido</th>
            <th>Cliente</th>
            <th>Sucursal</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Total</th>
            <th>Fecha Creación</th>
            <th>Vendedor</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modalManifiestos" data-backdrop="static" data-keyboard="false" aria-labelledby="modalManifiestosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalManifiestosLabel">Impresión de Manifiestos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-5">
            <h5 class="text-center">Cajas</h5>
            <!-- Lista de cajas del pedido -->
            <div class="d-flex" id="listacajas"></div>
          </div>
          <div class="col-7">
            <h5 class="text-center">Manifiestos</h5>

            <!-- Lista de los productos pendientes por empacar -->
            <div class="list-group" id="listamanifiestos"></div>

            <div class="list-group d-none" id="listaproductospedidonohay">
              <div class="font-weight-bold text-center p-2">No se encontraron manifiestos</div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-success" id="btn-finalizar-empaque">
          <i class="fas fa-check"></i> Aceptar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
	$MANEJAEMPAQUE = "<?= $manejaEmpaque ?>";
</script>