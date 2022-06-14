<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalMiPerfilLabel"><?= $title ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link tab-mi-perfil active" id="data-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" data-form="formMiperfil" aria-selected="true">Datos Basicos</a>
          <a class="nav-link tab-mi-perfil" id="segur-tab" data-form="formPassword" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Seguridad</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane p-2 fade show active" id="nav-home" role="tabpanel" aria-labelledby="data-tab">
          <form id="formMiperfil" enctype="multipart/form-data">
            <div class="form-row justify-content-center">
              <div class="col-7">
                <div id="content-upload" class="<?= is_null($usuario->foto) || $usuario->foto == '' ? '' : 'd-none' ?>">
                  <div class="content-img rounded d-flex align-items-center justify-content-center">
                    <div class="text-center position-absolute w-80">
                      <i class="fas fa-cloud-upload-alt"></i>
                      <span> Selecciona o arrastre su imagen</span>
                    </div>
                    <input id="foto" name="foto" class="input-file-img inputVer" accept=".png, .jpg, .jpeg" type="file">
                  </div>
                </div>
                <div id="content-preview" class="text-center <?= !is_null($usuario->foto) && $usuario->foto != '' ? '' : 'd-none' ?>">
                  <img id="imgFoto" src="<?= base_url("Usuarios/Foto/" . $usuario->foto) ?>" class="img-thumbnail h-100">
                  <button type="button" class="btn btn-danger btn-sm btn-eliminar-foto" style="right: 20px;"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group form-valid">
                  <label class="mb-0" for="usuario">Usuario <span class="text-danger">*</span></label>
                  <input placeholder="Usuario" value="<?= $usuario->usuario ?>" class="form-control soloLetras inputVer" id="usuario" name="usuario" type="text" minlength="3" maxlength="255" required autocomplete="off">
                </div>
                <div class="form-group form-valid">
                  <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
                  <input value="<?= $usuario->nombre ?>" type="text" id="nombre" name="nombre" class="form-control soloLetrasEspacio inputVer" minlength="1" maxlength="300" required placeholder="Nombre" autocomplete="off">
                </div>
              </div>
              <div class="col-12 form-group form-group-edit">
                <label class="mb-0" for="fechaLog">Ultimo login</label>
                <input value="<?= $usuario->ultimo_login ?>" class="form-control" id="fechaLog" disabled>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane p-2 fade" id="nav-profile" role="tabpanel" aria-labelledby="segur-tab">
          <form id="formPassword" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-12 form-group form-valid">
                <label class="mb-0" for="pass">Contraseña Actual<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" required id="passActual" placeholder="******" minlength="1" maxlength="255" name="passActual" class="form-control soloLetras" autocomplete="off">
                  <div class="input-group-append">
                    <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group form-valid">
                <label class="mb-0" for="passMi">Contraseña <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" required id="passMi" placeholder="******" minlength="1" maxlength="255" name="passMi" class="form-control soloLetras" autocomplete="off">
                  <div class="input-group-append">
                    <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group form-valid">
                <label class="mb-0" for="RePassMi">Confirmar Contraseña <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" required id="RePassMi" placeholder="******" minlength="1" maxlength="255" name="RePassMi" class="form-control soloLetras" autocomplete="off">
                  <div class="input-group-append">
                    <button class="btn btn-secondary btn-pass" type="button"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-success" id="btn-guardar" form="formMiperfil"><i class="fas fa-save"></i> Guardar</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
    </div>
  </div>
</div>

<?php 
    if(isset($jsMiP)){
      foreach ($jsMiP as $jsMiP1) {
        if(is_array($jsMiP1)) {
          foreach ($jsMiP1 as $jsMiP2) {
            printf('<script src="%s"></script>', base_url(esc($jsMiP2)));
          }
        } else {
          printf('<script src="%s"></script>', base_url(esc($jsMiP1)));
        }
      }
    }

    if(isset($js_addMiP)){
      foreach ($js_addMiP as $js_addMiP1) {
        if(is_array($js_addMiP1)) {
          foreach ($js_addMiP1 as $js_addMiP2) {
            printf('<script src="%s"></script>', base_url("assets/js/" . esc($js_addMiP2) . "?" . rand()));
          }
        } else {
          printf('<script src="%s"></script>', base_url("assets/js/" . esc($js_addMiP1) . "?". rand() ));
        }
      }
    }
  ?>

<script>
  $USUARIOID = <?= $usuarioId ?>;
</script>