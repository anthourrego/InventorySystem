<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="tabConfiguracion" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="producto-tab" data-toggle="tab" href="#productoTab" role="tab" aria-controls="productoTab" aria-selected="true">Cuentas</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="contentTab">
      <div class="tab-pane fade show active" id="productoTab" role="tabpanel" aria-labelledby="producto-tab">
        <div class="form-row">
          <h5 class="mb-1 col-12">Ventas:</h5>
          <h6 class="mb-1 col-12 text-muted">Configura las cuentas contables de ingresos por defecto para el registro de documentos de venta y devoluciones de tus clientes.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="costoProducto">Ingresos:</label>
            <select id="costoProducto" data-nombre="Costo de producto" <?= !$editar ? 'disabled' : '' ?> name="costoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Inventario:</h5>
          <h6 class="mb-1 col-12 text-muted">Selecciona la cuenta que se va a utilizar para el registro de entradas, salidas y ajustes de inventario.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="itemProducto">Inventario:</label>
            <select id="itemProducto" data-nombre="Item Producto" <?= !$editar ? 'disabled' : '' ?> name="itemProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Clientes:</h5>
          <h6 class="mb-1 col-12 text-muted">Selecciona la cuenta que recibirá el movimiento de tus transacciones con clientes y proveedores.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="manifiestoProducto">Cuenta por cobrar clientes:</label>
            <select id="manifiestoProducto" data-nombre="Manifiesto Producto" <?= !$editar ? 'disabled' : '' ?> name="manifiestoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Patrimonio:</h5>
          <h6 class="mb-1 col-12 text-muted">Configura la cuenta en la que se van a registrar los resultados de la empresa y los ajustes por saldos iniciales.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="pacDescarga">Ganancias acumuladas:</label>
            <input type="number" id="pacDescarga" data-nombre="Paquete descarga" name="pacDescarga" min="1" max="100" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>