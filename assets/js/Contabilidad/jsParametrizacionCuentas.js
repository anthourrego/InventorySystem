let rutaBase = base_url() + "Contabilidad/Parametrizacion/";

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
          let input = $("#" + it.campo);
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

    let formDataSave = new FormData();
    formDataSave.set('campo', campo);
    formDataSave.set('valor', valor);
    formDataSave.set('nombre', nombre);

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
        } else {
          alertify.error(resp.msj);
        }

        deshabilitarCuentas();
      }
    });
  });

  $('#cuentaGananciasAcumuladas').on('select2:open', function (e) {
    deshabilitarCuentas();
  });

});

function deshabilitarCuentas() {
  setTimeout(() => {
    $('[id*="cuentaGananciasAcumuladas"] [aria-disabled="true"]').each(function () {
      $(this).attr("style", "opacity: 0.5;");
    });
  }, 300);
}
