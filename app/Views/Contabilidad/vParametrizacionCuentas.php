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
          <h6 class="mb-1 col-12 text-muted">Configura las cuentas contables de ingresos por defecto para el registro de documentos.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaIngresos">Ingresos:</label>
            <select id="cuentaIngresos" data-nombre="Cuenta de ingresos" <?= !$editar ? 'disabled' : '' ?> name="cuentaIngresos" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'SALES', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Pedidos:</h5>
          <h6 class="mb-1 col-12 text-muted">Configura las cuentas contables de pedidos por defecto para el registro de documentos.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaPedidos">Ingresos:</label>
            <select id="cuentaPedidos" data-nombre="Cuenta de pedidos" <?= !$editar ? 'disabled' : '' ?> name="cuentaPedidos" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'ORDERS', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Compras:</h5>
          <h6 class="mb-1 col-12 text-muted">Configura las cuentas contables de compras por defecto para el registro de documentos.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaCompras">Ingresos:</label>
            <select id="cuentaCompras" data-nombre="Cuenta de compras" <?= !$editar ? 'disabled' : '' ?> name="cuentaCompras" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'BUYS', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Inventario:</h5>
          <h6 class="mb-1 col-12 text-muted">Selecciona la cuenta que se va a utilizar para el registro de entradas, salidas y ajustes de inventario.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaInventario">Inventario:</label>
            <select id="cuentaInventario" data-nombre="Cuenta de inventario" <?= !$editar ? 'disabled' : '' ?> name="cuentaInventario" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'INVENTORY', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Clientes:</h5>
          <h6 class="mb-1 col-12 text-muted">Selecciona la cuenta que recibirá el movimiento de tus transacciones con clientes.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaPorCobrarClientes">Cuenta por cobrar clientes:</label>
            <select id="cuentaPorCobrarClientes" data-nombre="Cuenta por cobrar clientes" <?= !$editar ? 'disabled' : '' ?> name="cuentaPorCobrarClientes" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'RECEIVABLE_ACCOUNTS', $cuenta);
              }
              ?>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaDescuentoCliente">Descuentos ventas:</label>
            <select id="cuentaDescuentoCliente" data-nombre="Descuentos clientes" <?= !$editar ? 'disabled' : '' ?> name="cuentaDescuentoCliente" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'FINANCIAL_DISCOUNT', $cuenta);
              }
              ?>
            </select>
            </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Patrimonio:</h5>
          <h6 class="mb-1 col-12 text-muted">Configura la cuenta en la que se van a registrar los resultados de la empresa y los ajustes por saldos iniciales.</h6>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaGananciasAcumuladas">Ganancias acumuladas:</label>
            <select id="cuentaGananciasAcumuladas" data-nombre="Cuenta de ganancias acumuladas" <?= !$editar ? 'disabled' : '' ?> name="cuentaGananciasAcumuladas" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, '', $cuenta, 0, 5129);
              }
              ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  let $CUENTAS = <?= json_encode($cuentas) ?>;
</script>
