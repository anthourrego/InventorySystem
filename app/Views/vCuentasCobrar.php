<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-6 col-md-2">
        <div class="input-group option-color" data-type="pago-completo" title="La factura ha sido pagada en su totalidad">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectEstado">Pago completo</label>
          </div>
          <input type="color" disabled readonly class="form-control form-control-color cu-pointer"
            value="#8ae287" title="Pago completo">
        </div>
      </div>
      <div class="col-6 col-md-2">
        <div class="input-group option-color" data-type="con-abonos" title="La factura cuenta con abonos">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectEstado">Con abonos</label>
          </div>
          <input type="color" disabled readonly class="form-control form-control-color cu-pointer"
          value="#98c0f6" title="Con abonos">
        </div>
      </div>
      <div class="col-6 col-md-2">
        <div class="input-group option-color" data-type="sin-abonos" title="La factura no cuenta con abonos">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectEstado">Sin abonos</label>
          </div>
          <input type="color" disabled readonly class="form-control form-control-color cu-pointer"
            value="#ffffff" title="Sin abonos">
        </div>
      </div>
      <div class="col-8 col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectTipoFacturas">Tipo</label>
          </div>
          <select class="custom-select" id="selectTipoFacturas">
            <option selected value="-1">Todos</option>
            <option value="2">Pago completo</option>
            <option value="1">Con abonos</option>
            <option value="0">Sin abonos</option>
            <option value="3">Vencidas</option>
          </select>
        </div>
      </div>
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
            <th>Vendedor</th>
            <th>Descuento</th>
            <th>Total</th>
            <th>Total Abonos</th>
            <th>Saldo Pendiente</th>
            <th>Fecha Creación</th>
            <th>Fecha Vence</th>
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

<script>
  let TIPOSABONO = <?= json_encode(TIPOSABONO); ?>
</script>
