let baseUrl = base_url() + "ModificarReporte";

$(function () {
  let editor = CKEDITOR.replace('editReporte');

  editor.on('change', function (evt) {
    dataEditor = evt.editor.getData();
  });

  $("#btnGuardar").on('click', function () {
    console.log("Funciona ", dataEditor);
    if (dataEditor.length) {
      $.ajax({
        url: baseUrl + "/Guardar",
        type: 'POST',
        dataType: 'json',
        data: { contenido: dataEditor, reporte },
        success: function (resp) {
          if (resp.success) {
            alertify.alert('¡Advertencia!', resp.msj, function () {
              location.href = baseUrl;
            });
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    } else {
      alertify.warning("El reporte no puede quedar vacio");
    }
  });
});