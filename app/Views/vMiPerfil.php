<?php 
  if(isset($cssMiP)){
    foreach ($cssMiP as $cssP1) {
      if(is_array($cssP1)) {
        foreach ($cssP1 as $cssP2) {
          printf('<link href="%s" rel="stylesheet"/>', base_url(esc($cssP2)));
        }
      } else {
        printf('<link href="%s" rel="stylesheet"/>', base_url(esc($cssP1)));
      }
    }
  }

  if(isset($css_add_P)){
    foreach ($css_add_P as $css_addP1) {
      if(is_array($css_addP1)) {
        foreach ($css_addP1 as $css_addP2) {
          printf('<link href="%s" rel="stylesheet"/>', base_url("assets/css/" . $css_addP2 . "?" . rand()));
        }
      } else {
        printf('<link href="%s" rel="stylesheet"/>', base_url("assets/css/" . $css_addP1 . "?" . rand() ));
      }
    }
  }
?>

<div class="modal-dialog" id="contenidoPerfil">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalMiPerfilLabel"><i class="fa-solid fa-user"></i> <?= $title ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link tab-mi-perfil active" id="data-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" data-form="formMiperfil" aria-selected="true">Datos Basicos</a>
          <a class="nav-link tab-mi-perfil" id="segur-tab" data-form="formPassword" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Seguridad</a>
          <a class="nav-link tab-mi-perfil" id="config-tab" data-form="formPassword" data-toggle="tab" href="#config-user" role="tab" aria-controls="config-user" aria-selected="false">Configuración</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane p-2 fade show active" id="nav-home" role="tabpanel" aria-labelledby="data-tab">
          <form id="formMiperfil" enctype="multipart/form-data">
            <div class="form-row justify-content-center">
              <div class="col-6">
                <button type="button" style="z-index: 30" id="tomarFoto-perfil" class="btn btn-info btn-sm col-10 mb-1"><i class="fas fa-camera"></i> Tomar Foto</button>
                <div id="content-upload-perfil" class="<?= !is_null($usuario->foto) && $usuario->foto != '' ? 'd-none' : '' ?>">
                  <div class="content-img rounded d-flex align-items-center justify-content-center">
                    <div class="text-center position-absolute w-90">
                      <i class="fas fa-cloud-upload-alt"></i>
                      <span> Selecciona o arrastre su imagen</span>
                    </div>
                    <input id="foto-perfil" name="foto" class="input-file-img inputVer" accept=".png, .jpg, .jpeg" type="file">
                  </div>
                </div>
                <div id="content-preview-perfil" class="text-center <?= !is_null($usuario->foto) && $usuario->foto != '' ? '' : 'd-none' ?>">
                  <img id="imgFoto-perfil" src="<?= base_url("Usuarios/Foto/" . $usuario->foto) ?>" class="img-thumbnail h-100">
                  <button type="button" class="btn btn-danger btn-sm btn-eliminar-foto-perfil"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group form-valid">
                  <label class="mb-0" for="usuario">Usuario <span class="text-danger">*</span></label>
                  <input placeholder="Usuario" value="<?= $usuario->usuario ?>" class="form-control soloLetras inputVer" id="usuario" name="usuario" type="text" minlength="3" maxlength="255" required autocomplete="off">
                </div>
                <div class="form-group form-valid">
                  <label class="mb-0" for="nombreUser">Nombre <span class="text-danger">*</span></label>
                  <input value="<?= $usuario->nombre ?>" type="text" id="nombreUser" name="nombreUser" class="form-control soloLetrasEspacio inputVer" minlength="1" maxlength="300" required placeholder="Nombre" autocomplete="off">
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
        <div class="tab-pane p-2 fade" id="config-user" role="tabpanel" aria-labelledby="config-tab">
          <div class="form-row">
            <div class="col-12">
              <label for="imageProd">Imagen Producto:</label>
              <select id="imageProd" data-nombre="Imagen Producto" name="imageProd" data-placeholder="Seleccione una opción" class="custom-select select2 configPerfil">
                <option value="-1" <?= is_null($usuario->imageProd) ? 'selected' : '' ?>>Por Defecto</option>
                <option value="1" <?= !is_null($usuario->imageProd) && session()->get('imageProd') == 1 ? 'selected' : '' ?>>Si</option>
                <option value="0" <?= !is_null($usuario->imageProd) && session()->get('imageProd') == 0 ? 'selected' : '' ?>>No</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-success buttons-modal" id="btn-guardar" form="formMiperfil"><i class="fas fa-save"></i> Guardar</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
    </div>
  </div>
</div>

<div class="modal-dialog" id="contenidoFotoPerfil" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalEditarImageLabel">Editar Imagen</h5>
      <button type="button" class="close btnCancelarImg" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body text-center">
      <img id="image-perfil" width="100%" src="" alt="">

      <img id="imageTemp-perfil" style="display: none;" width="100%" src="assets/img/nofoto.png" alt="">

      <video muted="muted" width="100%" style="display: none;" id="video-perfil"></video>
      <canvas id="canvas-perfil" style="display: none;"></canvas>

    </div>
    <div class="modal-footer d-flex justify-content-between footer-modal-perfil">
      <div class="btnsync-perfil">
        <button type="button" onclick="cambiarCamaraPerfil()" class="btn btn-secondary btnsyncaction-perfil"><i class="fas fa-sync"></i></button>  
        <button type="button" onclick="reintentarFotoPerfil()" class="btn btn-danger reloadFoto-perfil"><i class="fas fa-redo"></i></button>  
      </div>
      <div class="btnactions-perfil">
        <button type="button" onclick="guardarImagePerfil()" class="btn btn-success btnGuadarFoto-perfil"><i class="fas fa-save"></i> Confirmar</button>
        <button type="button" class="btn btn-secondary btnCancelarImg-perfil"><i class="fas fa-times"></i> Cerrar</button>
      </div>
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