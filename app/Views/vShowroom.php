<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-8 col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectStatus">Estado</label>
          </div>
          <select class="custom-select" id="selectStatus">
            <option selected value="-1">Todos</option>
            <?php foreach ($statusDescription as $key => $status) : ?>
              <option value="<?= $key ?>"><?= $status ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <?php if (validPermissions([7001], true)) { ?>
        <div class="col-4 col-md-3 text-right">
          <button type="button" class="btn btn-primary" id="btnCrear"><i class="fa-solid fa-plus"></i> Crear</button>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <table id="table" class="table table-sm table-striped table-hover table-bordered w-100"
      aria-describedby="Tabla de Pedidos">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Fecha Inicio</th>
          <th>Leer QR</th>
          <th>Muestra Valor</th>
          <th>Inventario Negativo</th>
          <th>Fecha Creación</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalShowroom" data-backdrop="static" data-keyboard="false" aria-labelledby="modalShowroomLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalShowroomLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formShowroom" class="formValid">
          <input type="hidden" class="inputVer" name="id" id="id">
          <div class="form-row">
            <div class="col-12 form-group form-valid">
              <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
              <input placeholder="Nombre" class="form-control soloLetrasEspacio inputVer" id="nombre" name="nombre" type="text" minlength="1" maxlength="255" required autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid">
              <label class="mb-0" for="descripcion">Descripción</label>
              <textarea class="form-control inputVer" id="descripcion" name="descripcion" minlength="1" maxlength="500" placeholder="Descripción" rows="3" autocomplete="off"></textarea>
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label class="mb-0" for="leerQR">Leer QR</label>
              <select class="custom-select" name="leerQR" id="leerQR">
                <option value="1">Si</option>
                <option value="0" selected>No</option>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label class="mb-0" for="muestraValor">Mostrar Valor</label>
              <select class="custom-select" name="muestraValor" id="muestraValor">
                <option value="1" selected>Si</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label class="mb-0" for="inventarioNegativo">Inventario Negativo</label>
              <select class="custom-select" name="inventarioNegativo" id="inventarioNegativo">
                <option value="1">Si</option>
                <option value="0" selected>No</option>
              </select>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="estado">Estado</label>
              <input class="form-control" id="estado" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaMod">Fecha modificación</label>
              <input class="form-control" id="fechaMod" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaCre">Fecha creación</label>
              <input class="form-control" id="fechaCre" disabled>
            </div>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formShowroom"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  const $statusDescription = <?= json_encode($statusDescription) ?>;
  const $currentShowroom = <?= json_encode($currentShowroom) ?>;
</script>