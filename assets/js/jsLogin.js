$(function() {
  alertify.defaults.theme.ok = "btn btn-primary";
  alertify.defaults.theme.cancel = "btn btn-danger";
  alertify.defaults.theme.input = "form-control";

  $("#formLogin").submit(function (event) {
    event.preventDefault();
    if ($(this).valid()) {
      $.ajax({
        type: "POST",
        url: base_url() + "iniciarSesion",
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        data: new FormData(this),
        success: function (data) {
          if (data.success) {
            window.location.reload();
          } else {
            alertify.error(data.msj);
          }
        }
      });
    }
  });

  $(".btn-pass").on("click", function () {
    if ($(this).find('i').hasClass('fa-eye')) {
      $(this).closest('.input-group').find('input').attr('type', 'text');
      $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
      $(this).closest('.input-group').find('input').attr('type', 'password');
      $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    }
  });

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
});