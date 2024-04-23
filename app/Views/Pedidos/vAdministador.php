<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-8 col-md-3 d-sm-block d-md-none">
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
      <div class="col-8 col-md-9 d-none d-md-block">
        <button type="button" class="btn-filtro-pedido btn btn-outline-primary btn-lg active"
          data-valor="-1">Todos</button>
        <button type="button" class="btn-filtro-pedido btn btn-outline-warning" data-valor="PE">Pendiente</button>
        <button type="button" class="btn-filtro-pedido btn btn-outline-secondary" data-valor="EP">En Proceso</button>
        <button type="button" class="btn-filtro-pedido btn btn-outline-info" data-valor="EM">Empacado</button>
        <button type="button" class="btn-filtro-pedido btn btn-outline-warning" data-valor="DE">Despachado</button>
        <button type="button" class="btn-filtro-pedido btn btn-outline-success" data-valor="FA">Facturado</button>
        <button type="button" class="btn-filtro-pedido btn btn-outline-success" data-valor="FQ">Facturado QR</button>
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

<div class="modal fade" id="modalManifiestos" data-backdrop="static" data-keyboard="false"
  aria-labelledby="modalManifiestosLabel" aria-hidden="true">
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
        <?php if (validPermissions([1083], true)) { ?>
          <button type="button" class="btn btn-warning" id="btn-imprimir-manifiesto-sin-repetir">
            <i class="fas fa-print"></i> Manifiestos Sin Repetir
          </button>
        <?php } ?>
        <?php if (validPermissions([1082], true)) { ?>
          <button type="button" class="btn btn-secondary d-none" id="btn-imprimir-multiple-manifiesto">
            <i class="fas fa-print"></i> Múltiple Manifiestos
          </button>
        <?php } ?>
        <button type="button" data-dismiss="modal" aria-label="Close"
          class="btn btn-success" id="btn-finalizar-empaque">
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

<div class="modal fade" id="modalGQR" data-backdrop="static" data-keyboard="false"
  aria-labelledby="modalGQRLabel" aria-hidden="true">
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

<div class="modal fade" id="modalDetallePedido" data-backdrop="static"
  data-keyboard="false" aria-labelledby="modalDetallePedidoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" style="min-height: 92vh;">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetallePedidoLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row mb-3" id="btnSincronizarDetallePedido">
          <div class="col-12 col-md-4 d-flex">
            <button class="btn btn-info">
              <i class="fas fa-sync"></i> Sincronizar Datos
            </button>
          </div>
        </div>
  
        <div class="row">
          <div class="col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Inicio Empaque:</p>&nbsp
            <p class="font-weight-normal mb-0" id="inicioEmpaque"></p>
          </div>
          <div class="col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Fin Empaque: </p>&nbsp
            <p class="font-weight-normal mb-0" id="finEmpaque"></p>
          </div>
          <div class="col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Tiempo Empaque: </p>&nbsp
            <p class="font-weight-normal mb-0" id="tiempoEmpaque"></p>
          </div>
        </div>

        <hr class="my-2">

        <div class="row">
          <div class="col-8">
            <h4 class="text-center">Cajas</h4>
            <!-- Lista de cajas del pedido -->
            <div id="listacajasPadre">
              <div class="d-flex flex-wrap" id="listacajasDetalle"></div>
            </div>
          </div>
          <div class="col-4 bg-light p-3 lista-detalle-caja">
            <h6 class="text-center">Detalle Caja</h6>
            <div class="col-12 d-flex">
              <p class="font-weight-bold mb-0">Inicio Empaque:</p>&nbsp
              <p class="font-weight-normal mb-0" id="inicioEmpaqueCaja"></p>
            </div>
            <div class="col-12 d-flex">
              <p class="font-weight-bold mb-0">Fin Empaque: </p>&nbsp
              <p class="font-weight-normal mb-0" id="finEmpaqueCaja"></p>
            </div>
            <div class="col-12 d-flex">
              <p class="font-weight-bold mb-0">Tiempo Empaque: </p>&nbsp
              <p class="font-weight-normal mb-0" id="tiempoEmpaqueCaja"></p>
            </div>
            <div class="col-12 d-flex">
              <p class="font-weight-bold mb-0">Total Referencias: </p>&nbsp
              <p class="font-weight-normal mb-0" id="totalReferenciasCaja"></p>
            </div>
            <div class="col-12 d-flex">
              <p class="font-weight-bold mb-0">Total Productos: </p>&nbsp
              <p class="font-weight-normal mb-0" id="totalProductos"></p>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
        <button type="button" id="btnImprimirDetallePedido" class="btn btn-primary">
          <i class="fas fa-print"></i> Imprimir
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalBoxProducts" data-backdrop="static"
  data-keyboard="false" aria-labelledby="modalBoxProductsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBoxProductsLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="boxProdsHtml"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
	$MANEJAEMPAQUE = "<?= $manejaEmpaque ?>";
  $USUARIOID = <?= $usuario ?>;
</script>
