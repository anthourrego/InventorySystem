baseRutaMiPerfil = base_url() + "Perfil/";
editFoto = 0;
srcOriginalPerfil = '';
streamPerfil = null;
$videoPerfil = null;
cameraActivePerfil = 'environment';

function instanciarEditorImagenPerfil(image, tamanoMax) {
  $("#image-perfil").rcrop("destroy");
  $("#image-perfil").attr('src', image);
  setTimeout(() => {
    $('#image-perfil').rcrop({
      full: true,
      minSize: [100, 100],
      maxSize: [tamanoMax, tamanoMax],
      preserveAspectRatio: true,
      inputs: true,
      inputsPrefix: '',
      grid: true
    });
    $('#image-perfil').show();
  }, 200);

  $('#image-perfil').on('rcrop-changed', function () {
    srcOriginalPerfil = $(this).rcrop('getDataURL');
  });

  $('#image-perfil').on('rcrop-ready', function () {
    $(this).rcrop('resize', tamanoMax, tamanoMax);
    srcOriginalPerfil = $(this).rcrop('getDataURL');
  });
}

function tieneSoporteUserMediaPerfil() {
  return !!(
    navigator.getUserMedia
    || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia)
    || navigator.webkitGetUserMedia
    || navigator.msGetUserMedia
  );
}

function cambiarCamaraPerfil() {
  cameraActivePerfil = (cameraActivePerfil == 'environment' ? 'user' : 'environment');
  srcOriginalPerfil = '';
  $('#image-perfil').rcrop('destroy');
  $("#video-perfil").hide();
  iniciarCamaraPerfil();
}

async function baseToFilePerfil(url, filename, mimeType) {
  const res = await fetch(url);
  const buf = await res.arrayBuffer();
  return new File([buf], filename, { type: mimeType });
}

function tieneSoporteUserMedia() {
  return !!(
    navigator.getUserMedia
    || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia)
    || navigator.webkitGetUserMedia
    || navigator.msGetUserMedia
  );
}

async function iniciarCamaraPerfil() {
  $("#imageTemp-perfil").show();
  $(".btnGuadarFoto-perfil").prop('disabled', true);
  $videoPerfil = document.querySelector("#video-perfil");
  capturePerfil(cameraActivePerfil);
}

function reintentarFotoPerfil() {
  srcOriginalPerfil = '';
  $('#image-perfil').rcrop('destroy');
  $("#video-perfil, .reloadFoto-perfil, #image-perfil").hide();
  iniciarCamaraPerfil();
}

function recortarImagenPerfil() {
  $('.reloadFoto-perfil').show();

  //Obtener contexto del canvas y dibujar sobre él
  let $canvas = document.querySelector("#canvas-perfil");
  $canvas.width = $videoPerfil.videoWidth;
  $canvas.height = $videoPerfil.videoHeight;
  $canvas.getContext("2d").drawImage($videoPerfil, 0, 0, $canvas.width, $canvas.height);

  var image = new Image();
  image.src = $canvas.toDataURL();

  image.onload = function () {
    var height = this.height;
    var width = this.width;
    let tamanoMax = height <= width ? height : width;
    if (streamPerfil) {
      const tracks = streamPerfil.getTracks();
      tracks.forEach(track => track.stop());
    }
    $("#video-perfil, .btnsyncaction-perfil").hide();
    instanciarEditorImagenPerfil($canvas.toDataURL(), tamanoMax);
    streamPerfil = null;
  };
}

async function guardarImagePerfil() {
  if (streamPerfil != null) {
    recortarImagenPerfil();
  } else {
    const file = await baseToFilePerfil(srcOriginalPerfil, 'temp', 'image/png');
    var dt = new DataTransfer();
    dt.items.add(file);
    $("#foto-perfil").prop('files', dt.files);
    $('#imgFoto-perfil').attr('src', srcOriginalPerfil);
    $("#contenidoFotoPerfil").hide();
    $("#contenidoPerfil").show();
    $('#image-perfil').rcrop('destroy');
    $("#content-preview-perfil").removeClass("d-none");
    $("#content-upload-perfil").addClass("d-none");
    editFoto = 0;
  }
}

capturePerfil = async facingMode => {
  const options = {
    audio: false,
    video: {
      facingMode,
    },
  };
  try {
    if (streamPerfil) {
      const tracks = streamPerfil.getTracks();
      tracks.forEach(track => track.stop());
    }
    streamPerfil = await navigator.mediaDevices.getUserMedia(options);
  } catch (e) {
    alert(e);
    return;
  }
  $videoPerfil.srcObject = null;
  $videoPerfil.srcObject = streamPerfil;
  $videoPerfil.play();
  $("#imageTemp-perfil").hide();
  $(".btnGuadarFoto-perfil").prop('disabled', false);
  $("#video-perfil, .btnsyncaction-perfil").show();
}

$(function () {

  $("#foto-perfil").on("change", function (event) {
    const file = this.files[0];
    if (file) {

      let reader = new FileReader();
      reader.onload = function (event) {
        var image = new Image();
        image.src = event.target.result;

        image.onload = function () {
          var height = this.height;
          var width = this.width;
          let tamanoMax = height <= width ? height : width;
          $('#image-perfil').show();
          $(".btnsync-perfil").hide();
          $(".footer-modal-perfil").removeClass('justify-content-between');
          instanciarEditorImagenPerfil(image.src, tamanoMax);
          $("#contenidoPerfil").hide();
          $("#contenidoFotoPerfil").show();
        };
      }
      reader.readAsDataURL(file);
    } else {
      $("#foto-perfil").val('');
      $('#imgFoto-perfil').attr('src', base_url() + "Usuarios/Foto");
      $("#content-preview-perfil").addClass("d-none");
      $("#content-upload-perfil").removeClass("d-none");
    }
  });

  $(".btn-eliminar-foto-perfil").on("click", function (e) {
    e.preventDefault();
    $("#foto-perfil").val('');
    $('#imgFoto-perfil').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview-perfil").addClass("d-none");
    $("#content-upload-perfil").removeClass("d-none");
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

  $("#tomarFoto-perfil").click(function () {
    if (!tieneSoporteUserMediaPerfil()) {
      alertify.warning("Su navegador no soporta tomar fotos.");
      return
    }
    cameraActivePerfil = 'environment';
    $(".btnsync-perfil").show();
    $(".footer-modal-perfil").addClass('justify-content-between');
    $("#contenidoPerfil, #image-perfil, .reloadFoto-perfil").hide();
    $("#contenidoFotoPerfil").show();
    iniciarCamaraPerfil();
  });

  $(".btnCancelarImg-perfil").click(function () {
    srcOriginalPerfil = '';
    $('#image-perfil').rcrop('destroy');
    $("#video-perfil").hide();
    if (streamPerfil) {
      const tracks = streamPerfil.getTracks();
      tracks.forEach(track => track.stop());
    }
    streamPerfil = null;
    $("#contenidoFotoPerfil").hide();
    $("#contenidoPerfil").show();
  });

  $('#modalMiPerfil').on('hidden.bs.modal', function (event) {
    srcOriginalPerfil = '';
    $('#image-perfil').rcrop('destroy');
    $("#video-perfil").hide();
    if (streamPerfil) {
      const tracks = streamPerfil.getTracks();
      tracks.forEach(track => track.stop());
    }
    streamPerfil = null;
  })
});