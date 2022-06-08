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
        <label for="inventarioNegativo">Inventario negativo:</label>
        <select id="inventarioNegativo" data-nombre="Inventario negativo" <?= !$editar ? 'disabled' : '' ?> name="inventarioNegativo" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
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
