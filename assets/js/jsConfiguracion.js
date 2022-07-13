let rutaBase = base_url() + "Configuracion/";

$(function () {
  //Traemos los datos
  $.ajax({
    url: rutaBase + "Datos",
    type: "GET",
    dataType: "json",
    async: false,
    success: function (resp) {
      if (resp.msj.length > 0) {
        let datos = resp.msj;
        datos.forEach(it => {
          input = $("#" + it.campo);
          if (input.hasClass("select2")) {
            input.val(it.valor);
            input.change();
          } else {
            if (it.campo == 'logoEmpresa' && it.valor != '') {
              input.val('');
              $('#imgFoto' + it.campo).attr('src', base_url() + "Configuracion/Foto/" + it.valor.replace(' ', '.'));
              $("#content-preview-" + it.campo).removeClass("d-none");
              $("#content-upload-" + it.campo).addClass("d-none");
            }
          }
        });
      }
    }
  });

  $(".configAct").on("change", function (e) {
    e.preventDefault();
    let input = $(this);
    let campo = $(this).attr("name");
    let valor = $(this).val();
    let nombre = $(this).data("nombre");

    let formDataSave = new FormData();
    formDataSave.set('campo', campo);
    formDataSave.set('valor', valor);
    formDataSave.set('nombre', nombre);

    if (campo == "inventarioBajo" && valor > +$("#inventarioMedio").val()) {
      $(this).val(lastFocusValue);
      return alertify.warning("El valor no puede superior al rango medio");
    }
    if (campo == "inventarioMedio" && valor < +$("#inventarioBajo").val()) {
      $(this).val(lastFocusValue);
      return alertify.warning("El valor no puede inferior al rango bajo");
    }

    if ($(this).prop('type') == 'file') {
      const file = this.files[0];
      if (file) {
        if (file.size <= 2000000) {
          formDataSave.set(campo, file, campo);
        } else {
          return alertify.error("La imagen es superior a 2mb");
        }
      } else {
        formDataSave.set('logoEmpresa', '', 'logoEmpresa');
      }
    }

    $.ajax({
      url: rutaBase + "Actualizar",
      type: "POST",
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      data: formDataSave,
      success: function (resp) {
        if (resp.success) {
          alertify.success(resp.msj);
          if (campo == "inventarioMedio") {
            $("#inventarioAlto").val(valor).change();
          }
          if (input.prop('type') == 'file') {
            $('#imgFoto' + campo).attr('src', base_url() + "Configuracion/Foto/" + resp.file);
            $("#content-preview-" + campo).removeClass("d-none");
            $("#content-upload-" + campo).addClass("d-none");
          }
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

  $(".infobtn").on('click', function () {
    $(".alert.alert-info").html(`El color rojo ira hasta el ${$("#inventarioBajo").val()}, el color amarillo desde el ${+$("#inventarioBajo").val() + 1} hasta el  ${$("#inventarioMedio").val()} y el color verde apartir de una cantidad mayor a ${$("#inventarioAlto").val()}`);
    $(".alert-info-data").toggle();
  });
});

function eliminarImagen(file, nombre) {
  $.ajax({
    url: rutaBase + "Eliminar",
    type: "POST",
    dataType: "json",
    data: { file, nombre },
    success: function (resp) {
      if (resp.success) {
        $('#imgFoto' + file).attr('src', base_url() + "Configuracion/Foto");
        $("#content-preview-" + file).addClass("d-none");
        $("#content-upload-" + file).removeClass("d-none");
        alertify.success(resp.msj);
      } else {
        alertify.error(resp.msj);
      }
    }
  });
}