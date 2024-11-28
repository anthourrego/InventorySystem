<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-12 d-md-none">
      <div class="form-group mb-0">
        <label class="mb-0" for="filterMobile">Filtros</label>
        <select class="form-control" id="filterMobile">
          <option value="-1" selected>Todos</option>
          <option value="2">Pago Completo</option>
          <option value="1">Con Abonos</option>
          <option value="0">Sin Abonos</option>
          <option value="3">Vencidos</option>
          <option value="4">Vencidos Con Abono</option>
        </select>
      </div>
      </div>
      <div class="col-12 col-md-9 d-none d-md-block">
        <button type="button" class="btn btn-outline-primary btn-lg active btn-fast-filter" data-filter="-1">Todos</button>
        <button type="button" class="btn btn-fullpay btn-fast-filter" data-filter="2">Pago Completo</button>
        <button type="button" class="btn btn-partialpay btn-fast-filter" data-filter="1">Con Abonos</button>
        <button type="button" class="btn btn-ligth btn-fast-filter" data-filter="0">Sin Abonos</button>
        <button type="button" class="btn btn-expired btn-fast-filter" data-filter="3">Vencidos</button>
        <button type="button" class="btn btn-expiredwithoutpayment btn-fast-filter" data-filter="4">Vencidos Con Abono</button>
      </div>
      <?php if (validPermissions([1007], true) && $facturaSinFecha > 0) { ?>
      <div class="col-12 col-md-3 mt-3 mt-md-0">
        <button type="button" class="btn btn-primary float-right w-100 w-md-50" id="assign-dates">
          <i class="fa-regular fa-calendar-plus"></i> Asignar Fechas
        </button>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100"
        aria-describedby="Tabla de Compras">
        <thead>
          <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Sucursal</th>
            <th>Ciudad</th>
            <th>Descuento</th>
            <th>Total</th>
            <th>Total Abonos</th>
            <th>Saldo Pendiente</th>
            <th>Fecha Vence</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalAgregarAbono" data-backdrop="static"
  data-keyboard="false" aria-labelledby="modalCrearEditarAbonosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="modalCrearEditarAbonosLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="h5 font-weight-bold">Datos básicos</p>
        <div class="row mx-0">
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Cliente:</p>&nbsp
            <p class="font-weight-normal mb-0" id="clienteFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Vendedor: </p>&nbsp
            <p class="font-weight-normal mb-0" id="vendedorFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Método de pago: </p>&nbsp
            <p class="font-weight-normal mb-0" id="metodoPagoFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Fecha de creación: </p>&nbsp
            <p class="font-weight-normal mb-0" id="fechaCreacionFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Fecha de vencimiento: </p>&nbsp
            <p class="font-weight-normal mb-0" id="fechaVencimientoFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Descuento factura: </p>&nbsp
            <p class="font-weight-normal mb-0" id="descuentoFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Total factura: </p>&nbsp
            <p class="font-weight-normal mb-0" id="totalFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Total abonos factura: </p>&nbsp
            <p class="font-weight-normal mb-0" id="totalAbonosFactura"></p>
          </div>
          <div class="border col-12 col-md-4 d-flex">
            <p class="font-weight-bold mb-0">Valor pendiente factura: </p>&nbsp
            <p class="font-weight-normal mb-0" id="valorPendienteFactura"></p>
          </div>
        </div>

        <hr/>

        <p class="h5 font-weight-bold">Agrega movimiento</p>
        <form id="formAddAbono" class="formValid">
          <div class="form-row">
            <div class="col-12 col-md-2">
              <label for="tipoAbono" class="mb-0">Tipo de movimiento:</label>
              <select id="tipoAbono" data-nombre="Tipo documento" name="tipoAbono" data-placeholder="Seleccione una opción" class="custom-select select2 inputVer">
                <?php foreach (TIPOSABONO as $key => $value) {
                  echo '<option value="' . $value['valor'] . '">' . $value['titulo'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-12 col-md-2">
              <div class="form-group form-valid">
                <label class="mb-0" for="valor">
                  Valor <span class="text-danger">*</span>
                </label>
                <input class="form-control inputPesos inputVer" data-valororiginal="0" id="valor"
                  name="valor" required type="tel" placeholder="Ingrese valor del abono" autocomplete="off"
                  autocomplete="off">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="observacion" class="mb-0">Observación</label>
                <textarea class="form-control" placeholder="Observación..."
                  name="observacion" id="observacion" cols="30" rows="1"></textarea>
              </div>
            </div>
            <div class="col-12 col-md-2 d-flex justify-content-end align-items-center">
              <button type="submit" form="formAddAbono" id="btnAgregarProductoCompra" class="btn btn-primary">
                <i class="fas fa-check"></i> Agregar
              </button>
            </div>
          </div>
        </form>
        <div class="table-responsive mt-3">
          <table id="tblAbonos" class="table table-sm table-striped table-hover table-bordered w-100"
          aria-describedby="Tabla de Productos">
            <thead>
              <tr>
                <th>Código</th>
                <th>Tipo abono</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Observación</th>
                <th>Fecha Creación</th>
                <th>Usuario</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFilter" data-backdrop="static" data-keyboard="false" aria-labelledby="modalFilterLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFilterLabel"><i class="fa-solid fa-filter"></i> Filtros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-12 col-md-6 form-group mb-1">
            <label class="mb-0" for="selectTipoFacturas">Tipo</label>
            <select class="custom-select" id="selectTipoFacturas">
              <option selected value="-1">Todos</option>
              <option value="2">Pago completo</option>
              <option value="1">Con abonos</option>
              <option value="0">Sin abonos</option>
              <option value="3">Vencidas</option>
            </select>
          </div>
          <div class="col-12 col-md-6 form-group">
            <label class="mb-0" for="sucursal">Sucursales</label>
            <select id="sucursal" required name="sucursal" class="custom-select custom-select-sm" data-placeholder="Seleccione un sucursal..." data-allow-clear="1">
              <option></option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnFilter"><i class="fas fa-filter"></i> Filtrar</button>
        <button type="button" class="btn btn-warning" id="reiniciarFiltros"><i class="fas fa-refresh"></i> Reiniciar Filtros</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  const TIPOSABONO = <?= json_encode(TIPOSABONO); ?>;
  const FACTURASINFECHA = <?= $facturaSinFecha ?>;
</script>
