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
            <th>Sucursal</th>
            <th>Ciudad</th>
            <th>Forma de pago</th>
            <th>Neto</th>
            <th>Total</th>
            <th>Vendedor</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modalGQR" data-backdrop="static" data-keyboard="false" aria-labelledby="modalGQRLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGQRLabel">Código QR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-12">
            <img width="100%" id="imgqr" alt="Codigo QR">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a type="button" download="" href="" class="btn btn-success" id="btnDescargarQR">
          <i class="fas fa-download"></i> Descargar
        </a>
        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary">
          <i class="fas fa-check"></i> Aceptar
        </button>
      </div>
    </div>
  </div>
</div>