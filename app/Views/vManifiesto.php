<div class="row">
  <div class="col-12 col-md-12" id="cardManifiestos">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12 col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Estado</label>
              </div>
              <select class="custom-select" id="selectEstado">
                <option selected value="1">Todos</option>
                <option value="2">Asignados</option>
                <option value="0">Sin Asignar</option>
              </select>
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Sin Asignar</label>
              </div>
              <input type="color" disabled readonly class="form-control form-control-color" value="#ffa9b1" title="Sin Asignar">
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Asignado</label>
              </div>
              <input type="color" disabled  readonly class="form-control form-control-color" value="#CECECE" title="Asignado">
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Seleccionado</label>
              </div>
              <input type="color" disabled  readonly class="form-control form-control-color" value="#a9ecff" title="Seleccionado">
            </div>
          </div>
          <div class="col-6 col-md-3 text-right">
            <?php if (validPermissions([81], true)) { ?>
              <button type="button" class="btn btn-primary" id="btnCrearManifiesto"><i class="fa-solid fa-plus"></i> Crear</button>
            <?php } ?>
            <?php if (validPermissions([87], true)) { ?>
              <button style="display: none;" type="button" class="btn btn-danger" id="btnEliminarMultiple"><i class="fa-solid fa-trash"></i> Eliminar Todos</button>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
            <thead> 
              <tr>
                <th>
                  <div class="custom-control custom-checkbox text-center">
                    <input type="checkbox" class="custom-control-input" value="1" id="checkAll">
                    <label class="custom-control-label" for="checkAll"></label>
                  </div>
                </th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Fecha Creación</th>
                <th>Asignación</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div style="display: none;" class="col-12 col-md-6" id="cardProds">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12 col-md-5">
            <div class="input-group ml-2">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input class="verImg" id="verImg1" data-tipo="1" type="checkbox" <?= $imagenProd == 1 ? 'checked' : '' ?>>
                </div>
              </div>
              <label for="verImg1" class="form-control">¿Ver Imagenes?</label>
            </div>
          </div>
          <div class="col-12 col-md-7 text-right">
            <button type="button" class="btn btn-primary" id="btnFinalizarAgregarProds"><i class="fa-solid fa-check"></i> Finalizar</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="tableProds" class="table table-sm table-striped table-hover table-bordered w-100">
            <thead> 
              <tr>
                <th>Imagen</th>
                <th>Referencia</th>
                <th>Item</th>
                <th>Descripción</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalManifiesto" data-backdrop="static" data-keyboard="false" aria-labelledby="modalManifiestoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalManifiestoLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formManifiesto" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="editFile" id="editFile" value="0">
          <div class="form-row">
            <div class="col-12">
              <div class="form-group form-valid">
                <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control soloLetrasEspacio inputVer" minlength="3" maxlength="255" required placeholder="Nombre" autocomplete="off">
              </div>
            </div>
            <div class="col-12">
              <div class="input-group form-valid">
                <div class="custom-file">
                  <input type="file" name="fileUpload" class="custom-file-input inputVer" id="fileUpload" accept="image/*,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword">
                  <label class="custom-file-label" id="labelInputFile" for="fileUpload">Seleccionar archivo...</label>
                </div>
              </div>
            </div>
            <div class="col-12 form-group form-group-edit">
              <label class="mb-0" for="fechaMod">Fecha modificación</label>
              <input class="form-control" id="fechaMod" disabled>
            </div>
            <div class="col-12 form-group form-group-edit">
              <label class="mb-0" for="fechaCre">Fecha creación</label>
              <input class="form-control" id="fechaCre" disabled>
            </div>
            <div class="col-12 form-group form-group-edit">
              <label class="mb-0" for="estado">Estado</label>
              <input class="form-control" id="estado" disabled>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formManifiesto"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalProdsManifiesto" data-backdrop="static" data-keyboard="false" aria-labelledby="modalVerProdsManifiestoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerProdsManifiestoLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-md-5">
            <div class="input-group ml-2">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input class="verImg" id="verImg2" data-tipo="2" type="checkbox" <?= $imagenProd == 1 ? 'checked' : '' ?>>
                </div>
              </div>
              <label for="verImg2" class="form-control">¿Ver Imagenes?</label>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table id="tableProdsManif" class="table table-sm table-striped table-hover table-bordered w-100">
            <thead> 
              <tr>
                <th>Imagen</th>
                <th>Referencia</th>
                <th>Item</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-success btnAceptarVistaProds"><i class="fas fa-save"></i> Aceptar</button>
      </div>
    </div>
  </div>
</div>

<script>
  let $permisoEliminarMultiple = <?= validPermissions([87], true) ? 'true' : 'false' ?>;
  let $imagenProd = <?= $imagenProd ?>;
  $CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
</script>