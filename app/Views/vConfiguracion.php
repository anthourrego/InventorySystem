<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link border-bottom active" id="producto-tab" data-toggle="tab" href="#productoTab" role="tab" aria-controls="productoTab" aria-selected="true">Productos</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link border-bottom" id="inventario-tab" data-toggle="tab" href="#inventarioTab" role="tab" aria-controls="inventarioTab" aria-selected="false">Inventario</a>
  </li>
</ul>
<div class="tab-content" id="contentTab">
  <div class="tab-pane fade show active" id="productoTab" role="tabpanel" aria-labelledby="producto-tab">
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-3">
            <label for="costoProducto">Costo de producto:</label>
            <select id="costoProducto" data-nombre="Costo de producto" <?= !$editar ? 'disabled' : '' ?> name="costoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="imagenProducto">Imagen Productos:</label>
            <select id="imagenProducto" data-nombre="Imagen Producto" <?= !$editar ? 'disabled' : '' ?> name="imagenProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="inventarioTab" role="tabpanel" aria-labelledby="inventario-tab">
    <div class="card">
      <div class="card-body">
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
              <label class="col-11 text-center">Rangos Inventario:</label>
              <div class="col-1 text-right"><i class="fas fa-info text-center p-2 bg-secondary w-25 infobtn"></i></div>
              <div class="col-11 col-md-3 input-group mb-3">
                <input data-nombre="Rango Bajo" value="0" id="inventarioBajo" name="inventarioBajo" <?= !$editar ? 'disabled' : '' ?> type="text" class="focusInput form-control bg-danger text-center">
              </div>
              <div class="col-1 input-group mb-3">
                <input readonly disabled value="<" type="text" class="form-control text-center">
              </div>
              <div class="col-12 col-md-4 input-group mb-3">
                <input data-nombre="Rango Medio" value="25" id="inventarioMedio" name="inventarioMedio" <?= !$editar ? 'disabled' : '' ?> type="text" class="focusInput form-control bg-warning text-center">
              </div>
              <div class="col-1 input-group mb-3">
                <input readonly disabled value=">" type="text" class="form-control text-center">
              </div>
              <div class="col-11 col-md-3 input-group mb-3">
                <input disabled type="text" data-nombre="Rango Alto" id="inventarioAlto" name="inventarioAlto" value="25" class="focusInput form-control bg-success text-center">
              </div>
              <div class="col-12 alert-info-data" style="display: none;">
                <div class="alert alert-info text-center" role="alert"></div>
              </div>
            </div>
          </div>
          <hr class="col-12">
        </div>
      </div>
    </div>
  </div>
</div>

