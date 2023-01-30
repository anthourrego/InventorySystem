<div class="card">

  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-8 col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectEstado">Estado</label>
          </div>
          <select class="custom-select" id="selectEstado">
            <option selected value="-1">Todos</option>
            <option value="PE">Pendiente</option>
            <option value="EP">En Proceso</option>
            <option value="EM">Empacado</option>
            <option value="DE">Despachado</option>
            <option value="FA">Facturado</option>
            <option value="FQ">Facturado QR</option>
          </select>
        </div>
      </div>
      <?php if (validPermissions([101], true)) { ?>
        <div class="col-4 col-md-3 text-right">
          <a href="<?= base_url("Pedidos/Crear") ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Crear</a>
        </div>
      <?php } ?>
    </div>
  </div>
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
            <div class="list-group" id="listacajas" style="max-height: 276px; overflow-y: scroll;"></div>
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

<!-- the form to be viewed as dialog-->
<div class="d-none">
  <form id="formRotulo">
    <div class="form-group" id="formDivRotuloNroCajas">
      <label for="formRotuloNroCajas" class="mb-0">Número de cajas disponibles</label>
      <input type="number" name="nroCajas" class="form-control" value="1" min="1" max="1000" id="formRotuloNroCajas">
    </div>
    <div class="form-group">
      <label for="formRotuloObservacion" class="mb-0">Observación</label>
      <textarea name="observacion" class="form-control" id="formRotuloObservacion" rows="3"></textarea>
    </div>
  </form>
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

<script>
	$MANEJAEMPAQUE = "<?= $manejaEmpaque ?>";
</script>