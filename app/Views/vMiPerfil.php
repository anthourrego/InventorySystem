<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalMiPerfilLabel"><?= $title ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <!-- <button class="btn btn-primary" id="checkAllPermisos"><i class="fa-regular fa-square-check"></i> Marcar Todo</button>
      <button class="btn btn-danger" id="unCheckAllPermisos"><i class="fa-regular fa-square"></i> Desmarcar Todo</button>
      <hr>
      <div id="tree"></div> -->
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-success" data-id="0" id="btnGuardarPermisos"><i class="fas fa-save"></i> Guardar</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
    </div>
  </div>
</div>

<?php 
  /* if(isset($js)){
    foreach ($js as $js1) {
      if(is_array($js1)) {
        foreach ($js1 as $js2) {
          printf('<script src="%s"></script>', base_url(esc($js2)));
        }
      } else {
        printf('<script src="%s"></script>', base_url(esc($js1)));
      }
    }
  }

  if(isset($js_add)){
    foreach ($js_add as $js_add1) {
      if(is_array($js_add1)) {
        foreach ($js_add1 as $js_add2) {
          printf('<script src="%s"></script>', base_url("assets/js/" . esc($js_add2) . "?" . rand()));
        }
      } else {
        printf('<script src="%s"></script>', base_url("assets/js/" . esc($js_add1) . "?". rand() ));
      }
    }
  } */
?>