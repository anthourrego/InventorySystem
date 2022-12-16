baseRutaMiPerfil = base_url() + "Perfil/";
editFoto = 0;

$(function () {

  $("#foto").on("change", function (event) {
    const file = this.files[0];
    if (file) {
      if (file.size <= 2000000) {
        let reader = new FileReader();
        reader.onload = function (event) {
          $('#imgFoto').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
        $("#content-preview").removeClass("d-none");
        $("#content-upload").addClass("d-none");
        editFoto = 1;
      } else {
        alertify.error("La imagen es superior a 2mb");
        $("#foto").val('');
        $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
        $("#content-preview").addClass("d-none");
        $("#content-upload").removeClass("d-none");
      }
    } else {
      $("#foto").val('');
      $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
      $("#content-preview").addClass("d-none");
      $("#content-upload").removeClass("d-none");
    }
  });

  $(".btn-eliminar-foto").on("click", function (e) {
    e.preventDefault();
    $("#foto").val('');
    $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload").removeClass("d-none");
    editFoto = 1;
  });

  //Las condiciones del formulario
  $("#formMiperfil").validate({
    usuario: "required",
    nombre: "required"
  });

  //Formulario de usuario
  $("#formMiperfil").on("submit", function (e) {
    e.preventDefault();
    if ($(this).valid()) {
      let form = new FormData(this);
      form.set('id', $USUARIOID);
      form.set('editFoto', editFoto);
      form.set('nombre', $("#nombreUser").val());
      $.ajax({
        url: baseRutaMiPerfil + "Editar",
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: form,
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });

  $("#formPassword").validate({
    rules: {
      passActual: "required",
      pass: "required",
      RePass: "required",
    }
  });

  //Formulario de usuario
  $("#formPassword").on("submit", function (e) {
    e.preventDefault();
    if ($(this).valid()) {
      let pass = $("#passMi").val().trim();
      let RePass = $("#RePassMi").val().trim();
      if (pass == RePass) {
        let form = new FormData(this);
        form.set('id', $USUARIOID);
        $.ajax({
          url: baseRutaMiPerfil + "Password",
          type: 'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: form,
          success: function (resp) {
            if (resp.success) {
              $("#passMi, #RePassMi, #passActual").val('');
              alertify.success(resp.msj);
            } else {
              alertify.error(resp.msj);
            }
          }
        });
      } else {
        alertify.warning("La contraseñas no coinciden, intentelo de nuevo");
        $(this).find("input[name='pass']").trigger("focus");
      }
    }
  });

  $(".configPerfil").on("change", function (e) {
    e.preventDefault();
    let campo = $(this).attr("name");
    let valor = $(this).val();
    let nombre = $(this).data("nombre");
    $.ajax({
      url: baseRutaMiPerfil + "ActualizarConfig",
      type: "POST",
      dataType: "json",
      data: { campo, valor, nombre },
      success: function (resp) {
        if (resp.success) {
          alertify.success(resp.msj);
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

  $('.tab-mi-perfil').on('shown.bs.tab', function (event) {
    $(".buttons-modal").show();
    if ($(this).attr('id') == 'config-tab') {
      $(".buttons-modal").hide();
    } else {
      $("#btn-guardar").attr('form', $(this).data('form'));
    }
  });
});