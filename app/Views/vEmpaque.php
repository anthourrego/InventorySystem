<div class="card">
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

<div class="modal fade" id="modalEmpaque" data-backdrop="static" data-keyboard="false" aria-labelledby="modalEmpaqueLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo-modal-pedido" id="modalEmpaqueLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body position-relative">
        <div class="btn-group btn-group-toggle position-fixed" style="z-index:5;">
          <!-- Agregar caja para empezar a empacar -->
          <button type="button" id="btnAgregarCaja" class="btn btn-secondary">
            <i class="fas fa-plus"></i> Agregar Caja
          </button>
          <!-- Sincronizar pedido -->
          <button type="button" id="btnSincronizar" class="btn btn-primary">
            <i class="fas fa-sync"></i> Sincronizar
          </button>
          <!-- Botón finalizar caja abierta -->
          <button type="button" id="btnFinalizarCaja" class="btn btn-info">
            <i class="fas fa-check"></i> Finalizar Caja
          </button>
        </div>

        <div class="row mt-5">
          <div class="col-12 col-md-4">
            <div class="row mb-2">
              <div class="col-2">
                <button class="btn btn-dark btn-sm" type="button" id="btnSortBoxes" title="Ordenar cajas ascendente o descendente por número">
                  <i class="fa-solid fa-arrow-up-wide-short"></i>
                </button>
              </div>
              <div class="col-10">
                <h5 class="text-center">Cajas</h5>
              </div>
            </div>
            <!-- Lista de cajas del pedido -->
            <div class="row row-cols-2 row-cols-md-1" id="listacajas"></div>
          </div>
          <div class="col-12 col-md-8">
            
            <div class="input-group mb-3">
              <input type="text" class="form-control form-control-sm" id="inputBuscarProd" placeholder="Ingrese referencia producto" aria-describedby="btnBuscar">
              <div class="input-group-append">
                <button class="btn btn-secondary btn-sm" type="button" id="btnBuscar">
                  <i class="fas fa-search"></i>
                  Buscar
                </button>
              </div>
            </div>

            <ul class="nav nav-tabs" id="tabsEmpaqueProds" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="productos-empacar-tab" data-toggle="tab" href="#productosEmpacarTab" role="tab" aria-controls="productosEmpacarTab" aria-selected="true">Por Empacar</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="productos-proceso-tab" data-toggle="tab" href="#productosProcesoTab" role="tab" aria-controls="productosProcesoTab" aria-selected="true">En Proceso</a>
              </li>
            </ul>
            <div class="tab-content" id="contentTab">
              <div class="tab-pane fade show active" id="productosEmpacarTab" role="tabpanel" aria-labelledby="productos-empacar-tab">
                <div class="row" id="listaproductospedidoempacar"></div>
              </div>
              <div class="tab-pane fade" id="productosProcesoTab" role="tabpanel" aria-labelledby="productos-proceso-tab">
                <!-- Lista de los productos pendientes por empacar -->
                <div class="row" id="listaproductospedido"></div>

                <div class="list-group d-none" id="listaproductospedidonohay">
                  <div class="font-weight-bold text-center p-2">No se encontraron productos</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <div>
          <button type="button" title="Organizar número de cajas repetidas" class="btn btn-secondary" id="reorder-numbers-boxes">
            <i class="fa-solid fa-arrow-down-1-9"></i>
          </button>
        </div>
        <div class="btn-content">
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
          </button>
          <?php if (validPermissions([301], true)) { ?>
            <button type="button" class="btn btn-success" id="btn-finalizar-empaque">
              <i class="fas fa-check"></i> Finalizar
            </button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalObsProd" data-backdrop="static" data-keyboard="false" aria-labelledby="modalObsProdLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titulo-modal-obs" id="modalObsProdLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formObs" class="formValid">
          <div class="row">
            <div class="col">
              <h5 class="text-center">Productos Faltantes Por Empacar</h5>
              <!-- Lista de los productos pendientes por empacar -->
              <div class="list-group" id="listaproductosobser"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-cancelar-empaque-obs">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="submit" form="formObs" class="btn btn-success" id="btn-finalizar-empaque-obs">
          <i class="fas fa-check"></i> Finalizar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  $USUARIOID = <?= $usuario ?>;
  $DATAMOTIVOS = JSON.parse('<?= json_encode(MOTIVOSDEVOLUCION) ?>');
  $IMPRIMEMANIFIESTOAUTO = <?= $imprimeManifiestoAuto ?>;
  $IMPRIMEROTULOAUTO = <?= $imprimeRotuloAuto ?>;
</script>