let rutaBase = base_url() + "Configuracion/";

$(function () {
  $("#tipoCEnvioEmpresa").on('change', function () {
    let smtp = $(this).find('option:selected').data('smtp');
    $("#hostEnvioEmpresa").val(smtp).prop('disabled', (smtp == 'N/A' ? false : true)).change();
  });

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
          if (it.campo.includes('logo') && it.valor != '') {
            input.val('');
            $('#imgFoto' + it.campo).attr('src', base_url() + "Configuracion/Foto/" + it.valor.replace(' ', '.'));
            $("#content-preview-" + it.campo).removeClass("d-none");
            $("#content-upload-" + it.campo).addClass("d-none");
          } else {
            input.val(it.valor);
            if (input.hasClass("select2")) {
              input.change();
            }
          }
        });

        //Validamos si los productos por capas estan inactivo para deshabilitar el campo de venta o actualizarlo
        if ($("#pacaProducto").val() == '0') {
          if ($("#ventaXPaca").val() == '1') {
            $("#ventaXPaca").val(0).change();
          }
          $("#ventaXPaca").attr("disabled", true);
        }
      }
    }
  });

  $("#pacaProducto").on("change", function (e) {
    e.preventDefault();
    const ventaXPaca = $("#ventaXPaca");

    if ($(this).val() == 1) {
      ventaXPaca.attr("disabled", false);
    } else {
      if (ventaXPaca.val() == '1') {
        ventaXPaca.val(0).change();
      }

      ventaXPaca.attr("disabled", true);
    }
  });

  $(".configAct").on("change", function (e) {
    e.preventDefault();
    let input = $(this);
    let campo = $(this).attr("name");
    let valor = $(this).val();
    let nombre = $(this).data("nombre");

    if (["consecutivoPed", "consecutivoFact", "consecutivoCompra", "consecutivoCuentaCobrar"].includes(campo)) {
      let digitos = $(`#${input.data('namedigitos')}`).val();
      valor = valor.substr(Array.from(valor).findIndex(it => +it > 0)).padStart(digitos, '0');
      $(this).val(valor);
    }

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

          if (["digitosPed", "digitosFact", "digitosCompra", "digitosCuentaCobrar"].includes(campo)) {
            $(`#${input.data('nameconsecutivo')}`).change();
          }
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

  $(".infobtn").on('click', function () {
    $(".alert.alert-info").html(`El color rojo ira hasta el ${$("#inventarioBajo").val()}, el color amarillo desde el ${+$("#inventarioBajo").val() + 1} hasta el  ${$("#inventarioMedio").val()} y el color verde a partir de una cantidad mayor a ${$("#inventarioAlto").val()}`);
    $(".alert-info-data").toggle();
  });

  $('[data-toggle="tooltip"]').tooltip()
});

function eliminarImagen(file, nombre) {
  $.ajax({
    url: rutaBase + "Eliminar",
    type: "POST",
    dataType: "json",
    data: { file, nombre },
    success: function (resp) {
      if (resp.success) {
        $('#' + file).val('');
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