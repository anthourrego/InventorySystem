<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="offset-8 offset-md-9 col-5 col-md-3 text-right">
        <a href="<?= base_url("Ventas/Crear") ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Crear</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
        <thead> 
          <tr>
            <th>Código factura</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Forma de pago</th>
            <th>Neto</th>
            <th>Total</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>
