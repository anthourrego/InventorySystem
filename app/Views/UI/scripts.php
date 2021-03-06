</body>

<div class="modal fade" id="modalMiPerfil" data-backdrop="static" data-keyboard="false" aria-labelledby="modalMiPerfilLabel" aria-hidden="true"></div>

<script>
  function base_url(){
    return "<?= base_url(); ?>/";
  }

  function validPermissions($permiso = 0){
    let listaPermisos = <?= json_encode(session()->get("permisos")) ?>

    return listaPermisos.some(item => item == $permiso);
  }
</script>
  <?php 
    if(isset($js)){
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
    }
  ?>
</html>