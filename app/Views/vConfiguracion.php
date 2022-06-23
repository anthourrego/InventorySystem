<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="tabConfiguracion" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="producto-tab" data-toggle="tab" href="#productoTab" role="tab" aria-controls="productoTab" aria-selected="true">Productos</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="inventario-tab" data-toggle="tab" href="#inventarioTab" role="tab" aria-controls="inventarioTab" aria-selected="false">Inventario</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="consecutivo-tab" data-toggle="tab" href="#consecutivoTab" role="tab" aria-controls="consecutivoTab" aria-selected="false">Consecutivo</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="contentTab">
      <div class="tab-pane fade show active" id="productoTab" role="tabpanel" aria-labelledby="producto-tab">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-3">
            <label for="costoProducto">Costo:</label>
            <select id="costoProducto" data-nombre="Costo de producto" <?= !$editar ? 'disabled' : '' ?> name="costoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="imageProd">Imagen:</label>
            <select id="imageProd" data-nombre="Imagen Producto" <?= !$editar ? 'disabled' : '' ?> name="imageProd" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="itemProducto">Item:</label>
            <select id="itemProducto" data-nombre="Item Producto" <?= !$editar ? 'disabled' : '' ?> name="itemProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="ubicacionProducto">Ubicación:</label>
            <select id="ubicacionProducto" data-nombre="Ubicación Producto" <?= !$editar ? 'disabled' : '' ?> name="ubicacionProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="manifiestoProducto">Manifiesto:</label>
            <select id="manifiestoProducto" data-nombre="Manifiesto Producto" <?= !$editar ? 'disabled' : '' ?> name="manifiestoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="pacaProducto">Paca X:</label>
            <select id="pacaProducto" data-nombre="Paca X Producto" <?= !$editar ? 'disabled' : '' ?> name="pacaProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="inventarioTab" role="tabpanel" aria-labelledby="inventario-tab">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-3">
            <label for="inventarioNegativo">Inventario negativo:</label>
            <select id="inventarioNegativo" data-nombre="Inventario negativo" <?= !$editar ? 'disabled' : '' ?> name="inventarioNegativo" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <hr class="col-12">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="row">
              <div class="col-12">
                <div class="row mb-3">
                  <label class="col-11 text-left">Rangos Inventario:</label>
                  <div class="col-1 text-right">
                    <button class="btn btn-secondary btn-sm infobtn">
                      <i class="fas fa-info"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-11 col-md-3 input-group mb-3">
                <input data-nombre="Rango Bajo" value="0" id="inventarioBajo" name="inventarioBajo" <?= !$editar ? 'disabled' : '' ?> type="text" class="configAct form-control bg-danger text-center inputFocusSelect lastFocus">
              </div>
              <div class="col-1 input-group mb-3">
                <input readonly disabled value="<" type="text" class="form-control text-center">
              </div>
              <div class="col-12 col-md-4 input-group mb-3">
                <input data-nombre="Rango Medio" value="25" id="inventarioMedio" name="inventarioMedio" <?= !$editar ? 'disabled' : '' ?> type="text" class="configAct form-control bg-warning text-center inputFocusSelect lastFocus">
              </div>
              <div class="col-1 input-group mb-3">
                <input readonly disabled value=">" type="text" class="form-control text-center">
              </div>
              <div class="col-11 col-md-3 input-group mb-3">
                <input disabled type="text" data-nombre="Rango Alto" id="inventarioAlto" name="inventarioAlto" value="25" class="configAct form-control bg-success text-center inputFocusSelect">
              </div>
              <div class="col-12 alert-info-data" style="display: none;">
                <div class="alert alert-info text-center" role="alert"></div>
              </div>
            </div>
          </div>
          <hr class="col-12">
        </div>
      </div>
      <div class="tab-pane fade" id="consecutivoTab" role="tabpanel" aria-labelledby="consecutivo-tab">
        <div class="form-row">
          <h5 class="mb-1 col-12">Factura:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="prefijoFact">Prefijo:</label>
            <input type="text" id="prefijoFact" data-nombre="Prefijo Factura" name="prefijoFact" <?= !$editar ? 'disabled' : '' ?> class="soloLetras form-control configAct" required autocomplete="off"placeholder="Ingrese el Prefijo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cosecutivoFact">Consecutivo:</label>
            <input type="number" id="cosecutivoFact"  data-nombre="Consecutivo Factura" name="cosecutivoFact" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese el consecutivo">
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Pedidos:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="prefijoPed">Prefijo:</label>
            <input type="text" id="prefijoPed" data-nombre="Prefijo Factura" name="prefijoPed" <?= !$editar ? 'disabled' : '' ?> class="soloLetras form-control configAct" required autocomplete="off"placeholder="Ingrese el Prefijo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="cosecutivoPed">Consecutivo:</label>
            <input type="number" id="cosecutivoPed"  data-nombre="Consecutivo Factura" name="cosecutivoPed" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese el consecutivo">
          </div>
          <hr class="col-12 my-2">
        </div>
      </div>
    </div>
  </div>
</div>