document.addEventListener('DOMContentLoaded', function (e) {
  alertify.defaults.theme.ok = "btn btn-primary";
  alertify.defaults.theme.cancel = "btn btn-danger";
  alertify.defaults.theme.input = "form-control";
  alertify.defaults.glossary.ok = '<i class="fas fa-check"></i> Aceptar';
  alertify.defaults.glossary.cancel = '<i class="fas fa-times"></i> Cancelar';

  $(document).on({
    ajaxStart: function() {
      $("#cargando").removeClass('d-none');
    },
    ajaxStop: function() {
      $("#cargando").addClass('d-none');
    },
    ajaxError: function(funcion, request, settings){
      $("#cargando").removeClass('d-none');
      alertify.alert('Error', request.responseText, function(){
        this.destroy();
      });
      console.error(funcion);
      console.error(request);
      console.error(settings);
    }
  });

  window.onerror = function() {
    $("#cargando").addClass('d-none');
  };

  $("#cerrarSesion").click(function (e) {
    e.preventDefault();
    alertify.confirm('Cerrar sesión', '¿Está seguro de cerrar sesión?', function () {
      $.ajax({
        type: "POST",
        url: base_url() + "Home/cerrarSesion",
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        data: {},
        beforeSend: function () { },
        success: function (data) {
          if (data.success) {
            window.location.href = base_url();
          } else {
            alertify.warning(data.msj);
          }
        },
        error: () => alertify.error("Error al cerrar sesion."),
        complete: function () { }
      });
    }, function () { });
  });
});