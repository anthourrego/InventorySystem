<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-8 col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectEstado">Estado</label>
          </div>
          <select class="custom-select" id="selectEstado">
            <option selected value="1">Activo</option>
            <option value="0">Inactivo</option>
            <option value="-1">Todos</option>
          </select>
        </div>
      </div>
      <?php if (validPermissions([21], true)) { ?>
        <div class="col-5 col-md-3 text-right">
          <button type="button" class="btn btn-primary" id="btnCrear"><i class="fa-solid fa-plus"></i> Crear</button>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
        <thead> 
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalPefiles" data-backdrop="static" data-keyboard="false" aria-labelledby="modalPefilesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPefilesLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPefiles" class="formValid">
          <input type="hidden" name="id" id="id" class="inputVer">
          <div class="form-row">
            <div class="col-12 form-group form-valid">
              <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
              <input placeholder="Nombre" class="form-control soloLetrasEspacio inputVer" id="nombre" name="nombre" type="text" minlength="1" maxlength="255" required autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid">
              <label class="mb-0" for="descripcion">Descripción</label>
              <textarea class="form-control inputVer" id="descripcion" name="descripcion" minlength="1" maxlength="500" placeholder="Descripción" rows="3" autocomplete="off"></textarea>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaMod">Fecha modificación</label>
              <input class="form-control" id="fechaMod" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaCre">Fecha creación</label>
              <input class="form-control" id="fechaCre" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="estado">Estado</label>
              <input class="form-control" id="estado" disabled>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formPefiles"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPermisos" data-backdrop="static" data-keyboard="false" aria-labelledby="modalPermisosLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPermisosLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button class="btn btn-primary" id="checkAllPermisos"><i class="fa-regular fa-square-check"></i> Marcar Todo</button>
        <button class="btn btn-danger" id="unCheckAllPermisos"><i class="fa-regular fa-square"></i> Desmarcar Todo</button>
        <hr>
        <div id="tree"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-id="0" id="btnGuardarPermisos"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $PERMISOS = <?= json_encode($permisos) ?>;
</script>