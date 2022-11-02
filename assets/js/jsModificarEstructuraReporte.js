let baseUrl = base_url() + "ModificarReporte";

$(function () {

  let editor = CKEDITOR.replace('editReporte', {
    customConfig: base_url() + 'assets/Libraries/CKEditor/config.js'
  });

  CKEDITOR.config.customConfig = base_url() + 'assets/Libraries/CKEditor/config.js';

  editor.on('change', function (evt) {
    dataEditor = evt.editor.getData();
  });

  $("#btnGuardar").on('click', function () {
    if (dataEditor.length) {
      $.ajax({
        url: baseUrl + "/Guardar",
        type: 'POST',
        dataType: 'json',
        data: { contenido: dataEditor, reporte },
        success: function (resp) {
          if (resp.success) {
            alertify.alert('¡Advertencia!', resp.msj, function () {
              location.href = base_url() + "Configuracion/Tab/Reportes";
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