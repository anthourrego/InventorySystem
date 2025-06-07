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
          <h5 class="mb-1 col-12">Ingresos:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaIngresoCaja">Caja:</label>
            <select id="cuentaIngresoCaja" data-nombre="Cuenta de Caja" <?= !$editar ? 'disabled' : '' ?> name="cuentaIngresoCaja" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'CAJA_MENOR', $cuenta);
              }
              ?>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaIngresoTransferencia">Transferencias:</label>
            <select id="cuentaIngresoTransferencia" data-nombre="Cuenta de Transferencias" <?= !$editar ? 'disabled' : '' ?> name="cuentaIngresoTransferencia" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'TRANSFERENCIAS', $cuenta);
              }
              ?>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaIngresoCuentaPorCobrar">Cuentas por cobrar:</label>
            <select id="cuentaIngresoCuentaPorCobrar" data-nombre="Cuenta por cobrar" <?= !$editar ? 'disabled' : '' ?> name="cuentaIngresoCuentaPorCobrar" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'CUENTAS_COBRAR', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Activos:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaActivosInventario">Inventario:</label>
            <select id="cuentaActivosInventario" data-nombre="Cuenta Inventario" <?= !$editar ? 'disabled' : '' ?> name="cuentaActivosInventario" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'INVENTARIO', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Gastos:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaGastosCompras">Compras:</label>
            <select id="cuentaGastosCompras" data-nombre="Cuenta de inventario perdido" <?= !$editar ? 'disabled' : '' ?> name="cuentaGastosCompras" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'COMPRAS', $cuenta);
              }
              ?>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaGastosInventarioPerdido">Inventario Perdido:</label>
            <select id="cuentaGastosInventarioPerdido" data-nombre="Cuenta de inventario perdido" <?= !$editar ? 'disabled' : '' ?> name="cuentaGastosInventarioPerdido" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php 
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'INVENTARIO_PERDIDO', $cuenta);
              }
              ?>
            </select>
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Patrimonio:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cuentaPatrimonioGanancias">Ganancias:</label>
            <select id="cuentaPatrimonioGanancias" data-nombre="Cuenta de ganancias" <?= !$editar ? 'disabled' : '' ?> name="cuentaPatrimonioGanancias" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <?php
              foreach ($cuentas as $cuenta) {
                echo call_user_func($renderAccountOptions, 'GANANCIAS', $cuenta);
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
