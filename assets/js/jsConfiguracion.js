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
          input.val(it.valor);
          if (input.hasClass("select2")) {
            input.change();
          }
        });
      }
    }
  });

  $(".configAct").on("change", function (e) {
    e.preventDefault();
    let campo = $(this).attr("name");
    let valor = $(this).val();
    let nombre = $(this).data("nombre");

    $.ajax({
      url: rutaBase + "Actualizar",
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

  $(".focusInput").on("focusout", function (e) {
    e.preventDefault();
    let campo = $(this).attr("name");
    let valor = $(this).val();
    let nombre = $(this).data("nombre");

    if (campo == "inventarioBajo" && valor > +$("#inventarioMedio").val()) {
      return alertify.warning("El valor no puede superior al rango medio");
    }

    $.ajax({
      url: rutaBase + "Actualizar",
      type: "POST",
      dataType: "json",
      data: { campo, valor, nombre },
      success: function (resp) {
        if (resp.success) {
          alertify.success(resp.msj);
          if (campo == "inventarioMedio") {
            $("#inventarioAlto").val(valor).focusout();
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