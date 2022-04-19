<style>
  .content-img {
    width: 100%;
    height: 228px;
    border: 1px solid #ced4da !important;
    transition: background-color 0.5s ease;
  }

  .content-img:hover {
    background-color: rgb(13 110 253 / 25%);
    transition: background-color 0.5s ease;
  }
  .input-file-img {
    position: absolute;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    outline: none;
    opacity: 0;
    cursor: pointer;
  }
</style>

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

<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
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
              <div class="content-img rounded d-flex align-items-center justify-content-center">
                <div class="text-center position-absolute w-90">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <span> Selecciona o arrastre su imagen</span>
                </div>
                <input id="foto" name="foto" class="input-file-img" accept="image/*" type="file">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="mb-0" for="usuario">Usuario</label>
                <input placeholder="Username" class="form-control" id="usuario" name="usuario" type="text" minlength="1" maxlength="255" required>
              </div>
              <div class="form-group">
                <label class="mb-0" for="perfil">Perfil</label>
                <select id="perfil" name="perfil" class="form-control">
                  <option selected disabled>Seleccione...</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" form="formUsuario">Guardar</button>
      </div>
    </div>
  </div>
</div>