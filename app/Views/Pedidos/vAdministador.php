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
