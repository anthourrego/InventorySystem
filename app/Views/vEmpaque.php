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
      <div class="modal-body">
        <div class="btn-group btn-group-toggle">
          <!-- Agregar caja para empezar a empacar -->
          <button type="button" id="btnAgregarCaja" class="btn btn-secondary">
            <i class="fas fa-plus"></i> Agregar Caja
          </button>
          <!-- Sincronizar pedido -->
          <button type="button" id="btnSincronizar" class="btn btn-info">
            <i class="fas fa-sync"></i> Sincronizar
          </button>
          <!-- Boton finalizar caja abierta -->
          <button type="button" id="btnFinalizarCaja" class="btn btn-primary">
            <i class="fas fa-check"></i> Finalizar Caja
          </button>
        </div>

        <div class="row">
          <div class="col-7">
            <h5 class="text-center">Cajas</h5>
            <!-- Lista de cajas del pedido -->
            <div class="d-flex" id="listacajas"></div>
            <hr class="my-2">
            <!-- Boton para abrir caja -->
            <button type="button" id="btnReabrirCaja" style="display: none;" class="btn btn-warning mb-2">
              <i class="fas fa-box-open"></i> Abrir Caja
            </button>
            <!-- Lista producto dentro de la caja -->
            <div class="list-group" id="listaproductoscaja"></div>
          </div>
          <div class="col-5">
            <h5 class="text-center">Productos Por Empacar</h5>

            <div class="input-group mb-3">
              <input type="text" class="form-control form-control-sm" id="inputBuscarProd" placeholder="Ingrese referencia producto" aria-describedby="btnBuscar">
              <div class="input-group-append">
                <button class="btn btn-secondary btn-sm" type="button" id="btnBuscar">
                  <i class="fas fa-search"></i>
                  Buscar
                </button>
              </div>
            </div>

            <!-- Lista de los productos pendientes por empacar -->
            <div class="list-group" id="listaproductospedido"></div>

            <div class="list-group d-none" id="listaproductospedidonohay">
              <div class="font-weight-bold text-center p-2">No se encontraron productos</div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
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

<script>
  $USUARIOID = <?= $usuario ?>;
</script>