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
        beforeSend: function () {
          $('#formLogin :input').attr("disabled", true);
          //Desabilitamos el botón
          $('#btn-inciar').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Iniciando...`);
          $("#btn-inciar").attr("disabled", true);
        },
        success: function (data) {
          if (data.success) {
            window.location.reload;
          } else {
            alertify.warning(data.msj);
          }
        },
        error: () => alertify.error("Error al inicar sesion."),
        complete: function () {
          //Habilitamos el botón
          $('#formLogin :input').attr("disabled", false);
          $('#btn-inciar').html(`Ingresar <i class="fas fa-sign-in-alt"></i>`);
          $("#btn-inciar").attr("disabled", false);
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
});