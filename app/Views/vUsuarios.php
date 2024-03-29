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
      <?php if (validPermissions([11], true)) { ?>
        <div class="col-4 col-md-3 text-right">
          <button type="button" class="btn btn-primary" id="btnCrearUsuario"><i class="fa-solid fa-user-plus"></i> Crear</button>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
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
        <form id="formUsuario" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="editFoto" id="editFoto" value="0">
          <div class="form-row">
            <div class="col-6">
              <button type="button" style="z-index: 30" id="tomarFoto" class="btn btn-info btn-sm col-10 mb-1"><i class="fas fa-camera"></i> Tomar Foto</button>
              <div id="content-upload">
                <div class="content-img rounded d-flex align-items-center justify-content-center">
                  <div class="text-center position-absolute w-90">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span> Selecciona o arrastre su imagen</span>
                  </div>
                  <input id="foto" name="foto" class="input-file-img inputVer" accept=".png, .jpg, .jpeg" type="file">
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
                <input placeholder="Usuario" class="form-control soloLetras inputVer" id="usuario" name="usuario" type="text" minlength="3" maxlength="255" required autocomplete="off">
              </div>
              <div class="form-group form-valid">
                <label class="mb-0" for="perfil">Perfil <span class="text-danger">*</span></label>
                <select id="perfil" required name="perfil" class="custom-select select2 inputVer" data-placeholder="Seleccione..." data-allow-clear="1">
                  <option></option>
                  <option value="0">Perfil libre</option>
                  <?php foreach ($perfiles as $perfil) : ?>
                    <option value="<?=  $perfil->id?>"><?= $perfil->nombre ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group form-valid">
                <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control soloLetrasEspacio inputVer" minlength="1" maxlength="300" required placeholder="Nombre" autocomplete="off">
              </div>
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="pass">Contraseña <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" required id="pass" placeholder="******" minlength="1" maxlength="255" name="pass" class="form-control soloLetras" autocomplete="off">
                <div class="input-group-append">
                  <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="RePass">Confirmar Contraseña <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" required id="RePass" placeholder="******" minlength="1" maxlength="255" name="RePass" class="form-control soloLetras" autocomplete="off">
                <div class="input-group-append">
                  <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaLog">Ultimo login</label>
              <input class="form-control" id="fechaLog" disabled>
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
        <button type="submit" class="btn btn-success" form="formUsuario"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cambios Password-->
<div class="modal fade modalFormulario" id="cambioPassModal"  data-backdrop="static" data-keyboard="false" aria-labelledby="cambioPassModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cambioPassModalLabel">Cambiar contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPass">
          <input type="hidden" name="id">
          <div class="form-group form-valid">
            <label class="mb-0" for="formPassPass">Contraseña <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" required id="formPassPass" placeholder="******" minlength="1" maxlength="255" name="pass" class="form-control soloLetras">
              <div class="input-group-append">
                <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
              </div>
            </div>
          </div>
          <div class="form-group form-valid">
            <label class="mb-0" for="formPassRePass">Confirmar Contraseña <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" required id="formPassRePass" placeholder="******" minlength="1" maxlength="255" name="RePass" class="form-control">
              <div class="input-group-append">
                <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formPass"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal permisos -->
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
        <div class="row">
          <div class="col-6 my-1">
            <button class="btn btn-primary w-100" id="checkAllPermisos"><i class="fa-regular fa-square-check"></i> Marcar Todo</button>
          </div>
          <div class="col-6 my-1">
            <button class="btn btn-danger w-100" id="unCheckAllPermisos"><i class="fa-regular fa-square"></i> Desmarcar Todo</button>
          </div>
          <div class="col-6 my-1">
            <button class="btn btn-success w-100" id="exapandAllPermisos"><i class="fa-solid fa-expand"></i> Expandir Todo</button>
          </div>
          <div class="col-6 my-1">
            <button class="btn btn-info w-100" id="collapseAllPermisos"><i class="fa-solid fa-compress"></i> Colapsar Todo</button>
          </div>
        </div>
        <hr class="my-3">
        <div id="tree"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-id="0" id="btnGuardarPermisos"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalEditarImage" data-backdrop="static" data-keyboard="false" aria-labelledby="modalEditarImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarImageLabel">Editar Imagen</h5>
        <button type="button" class="close btnCancelarImg" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="image" width="100%" src="" alt="">

        <img id="imageTemp" style="display: none;" width="100%" src="assets/img/nofoto.png" alt="">

        <video muted="muted" width="100%" style="display: none;" id="video"></video>
	      <canvas id="canvas" style="display: none;"></canvas>

      </div>
      <div class="modal-footer d-flex justify-content-between footer-modal">
        <div class="btnsync">
          <button type="button" onclick="cambiarCamara()" class="btn btn-secondary btnsyncaction"><i class="fas fa-sync"></i></button>  
          <button type="button" onclick="reintentarFoto()" class="btn btn-danger reloadFoto"><i class="fas fa-redo"></i></button>  
        </div>
        <div class="btnactions">
          <button type="button" onclick="guardarImage()" class="btn btn-success btnGuadarFoto"><i class="fas fa-save"></i> Confirmar</button>
          <button type="button" class="btn btn-secondary btnCancelarImg"><i class="fas fa-times"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $PERMISOS = <?= json_encode($permisos) ?>;
</script>