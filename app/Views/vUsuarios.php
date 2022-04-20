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
      <div class="col-5 col-md-3 text-right">
        <button type="button" class="btn btn-primary" id="btnCrearUsuario"><i class="fa-solid fa-user-plus"></i> Crear</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-striped table-hover table-bordered w-100">
        <thead> 
          <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Perfil</th>
            <th>Estado</th>
            <th>Ultimo Login</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalUsuario" data-backdrop="static" data-keyboard="false" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuarioLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUsuario">
          <div class="form-row">
            <div class="col-6">
              <div id="content-upload">
                <div class="content-img rounded d-flex align-items-center justify-content-center">
                  <div class="text-center position-absolute w-90">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span> Selecciona o arrastre su imagen</span>
                  </div>
                  <input id="foto" name="foto" class="input-file-img" accept=".png, .jpg, .jpeg" type="file">
                </div>
              </div>
              <div id="content-preview" class="d-none text-center">
                <img id="imgFoto" src="<?= base_url("Usuarios/Foto") ?>" class="img-thumbnail h-100">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-foto"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group form-valid">
                <label class="mb-0" for="usuario">Usuario <span class="text-danger">*</span></label>
                <input placeholder="Username" class="form-control" id="usuario" name="usuario" type="text" minlength="1" maxlength="255" required>
              </div>
              <div class="form-group form-valid">
                <label class="mb-0" for="perfil">Perfil <span class="text-danger">*</span></label>
                <select id="perfil" required name="perfil" class="custom-select select2" data-placeholder="Seleccione..." data-allow-clear="1">
                  <option></option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
              <div class="form-group form-valid">
                <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control" minlength="1" maxlength="300" required placeholder="Nombre">
              </div>
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="pass">Contraseña <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" required id="pass" placeholder="******" minlength="1" maxlength="255" name="pass" class="form-control">
                <div class="input-group-append">
                  <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="RePass">Confirmar Contraseña <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" required id="RePass" placeholder="******" minlength="1" maxlength="255" name="RePass" class="form-control">
                <div class="input-group-append">
                  <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formUsuario"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>