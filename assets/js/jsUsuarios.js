let rutaBase = base_url() + "Usuarios/";
let srcOriginal = '';
let stream = null;
let $video = null;
let cameraActive = 'environment';
var arbolPermisos = $('#tree').tree({
  primaryKey: 'id',
  uiLibrary: 'bootstrap4',
  checkboxes: true,
  select: false,
  cascadeCheck: false,
  dataSource: $PERMISOS
});

let DTUsuarios = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val() })
    }
  },
  order: [[2, "asc"]],
  columns: [
    {
      orderable: false,
      defaultContent: '',
      className: "text-center",
      render: function (meta, type, data, meta) {
        return `<a href="${base_url()}Usuarios/Foto/${data.foto}" data-fancybox="images${data.id}" data-caption="${data.nombre}">
                  <img class="img-thumbnail" src="${base_url()}Usuarios/Foto/${data.foto}" alt="" />
                </a>`;
      }
    },
    { data: 'nombre' },
    { data: 'usuario' },
    { data: 'perfil' },
    { data: 'Estadito' },
    {
      data: 'ultimo_login',
      render: function (meta, type, data, meta) {
        return moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {
      data: 'created_at',
      render: function (meta, type, data, meta) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {

        btnEditar = validPermissions(12) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-user-pen"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarPass = validPermissions(13) ? '<button type="button" class="btn btn-warning btnCambiarPass" title="Cambiar Contraseña"><i class="fa-solid fa-user-lock"></i></button>' : '';

        btnPermisos = (data.perfilId == null && validPermissions(15)) ? '<button type="button" class="btn btn-info btnPermisos" title="Permisos"><i class="fa-solid fa-user-shield"></i></button>' : '';

        btnCambiarEstado = validPermissions(14) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-user-${data.estado == "1" ? "large-slash" : "check"}"></i></button>` : '';

        return `<div class="btn-group btn-group-sm" role="group">
                  ${btnEditar}
                  ${btnCambiarPass}
                  ${btnPermisos}
                  ${btnCambiarEstado}
                </div>`;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
    //Cambio de estado
    $(row).find(".btnCambiarEstado").on("click", function () {
      eliminar(data);
    });

    //Editar usuario
    $(row).find(".btnEditar, .btnVer").click(function (e) {
      e.preventDefault();
      if ($(this).hasClass("btnVer")) {
        $("#modalUsuarioLabel").html(`<i class="fa-solid fa-eye"></i> Ver usuario`);
        $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
        $(".btn-eliminar-foto, button[form='formUsuario']").addClass("d-none");
      } else {
        $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-pen"></i> Editar usuario`);
        $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
        $(".btn-eliminar-foto, button[form='formUsuario']").removeClass("d-none");
      }

      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#usuario").val(data.usuario);
      $("#perfil").val((data.perfilId == null ? 0 : data.perfilId)).change();
      $("#fechaLog").val(moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $("#editFoto").val(0);
      $("#foto").val('');
      if (data.foto != null) {
        $('#imgFoto').attr('src', base_url() + "Usuarios/Foto/" + data.foto);
        $("#content-preview").removeClass("d-none");
        $("#content-upload").addClass("d-none");
      } else {
        $("#content-preview").addClass("d-none");
        $("#content-upload").removeClass("d-none");
      }
      $("#pass, #RePass").closest(".form-group").addClass("d-none");
      $(".form-group-edit").removeClass("d-none");
      $("#modalUsuario").modal("show");
    });

    //Cambio de contraseña
    $(row).find(".btnCambiarPass").click(function (e) {
      $("#formPass input[name='id'").val(data.id);

      $("#cambioPassModal").modal("show");
    });

    //Permisos
    $(row).find(".btnPermisos").click(function (e) {
      e.preventDefault();
      $("#modalPermisosLabel").html("<i class='fa-solid fa-user-shield'></i> " + data.nombre + " | Permisos");
      $("#btnGuardarPermisos").data("id", data.id);
      $.ajax({
        url: base_url() + "Permisos/Usuarios/" + data.id,
        type: "GET",
        dataType: "json",
        success: function (data) {
          data.forEach(it => {
            let node = arbolPermisos.getNodeById(it.permiso);
            arbolPermisos.check(node).expand(node);
          });
          $("#modalPermisos").modal("show");
        }
      });
    });
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    DTUsuarios.ajax.reload();
  });

  $("#foto").on("change", function (event) {
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
          $('#image').show();
          $(".btnsync").hide();
          $(".footer-modal").removeClass('justify-content-between');
          instanciarEditorImagen(image.src, tamanoMax);
          $("#modalUsuario").hide();
          $("#modalEditarImage").modal('show');
        };
      }
      reader.readAsDataURL(file);
    } else {
      $("#foto").val('');
      $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
      $("#content-preview").addClass("d-none");
      $("#content-upload").removeClass("d-none");
    }
  });

  $(".btn-eliminar-foto").on("click", function (e) {
    e.preventDefault();
    $("#foto").val('');
    $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload").removeClass("d-none");

    if ($("#id").val().length > 0) {
      $("#editFoto").val(1);
    }
  });

  $("#btnCrearUsuario").on("click", function () {
    $(".inputVer").val("").removeClass("disabled").prop("disabled", false).trigger('change');
    $("#editFoto").val(0);
    $("#foto").val('').removeClass("disabled").prop("disabled", false);
    $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload, .btn-eliminar-foto, button[form='formUsuario']").removeClass("d-none");
    $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-plus"></i> Crear usuario`);
    $(".form-group-edit").addClass("d-none");
    $("#pass, #RePass").closest(".form-group").removeClass("d-none");
    $("#modalUsuario").modal("show");
  });

  $('#modalUsuario').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#usuario").trigger('focus');
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

  //Las condiciones del formulario
  $("#formUsuario").validate({
    rules: {
      pass: "required",
      RePass: {
        equalTo: "#pass"
      }
    }
  });

  $("#usuario").on("focusout", function () {
    let usuario = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if (usuario.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaUsuario/" + usuario + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if (resp > 0) {
            alertify.warning("El usuario <b>" + usuario + "</b>, ya se encuentra creado, intente con otro nombre.");
            $("#usuario").trigger("focus");
          }
        }
      });
    }
  });

  //Formulario de usuario
  $("#formUsuario").on("submit", function (e) {
    e.preventDefault();
    let id = $("#id").val().trim();
    let pass = $("#pass").val().trim();
    let RePass = $("#RePass").val().trim();

    if ($(this).valid()) {
      if (pass == RePass) {
        $.ajax({
          url: rutaBase + (id.length > 0 ? "Editar" : "Crear"),
          type: 'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: new FormData(this),
          success: function (resp) {
            if (resp.success) {
              DTUsuarios.ajax.reload();
              $("#modalUsuario").modal("hide");
              $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
              $("#content-preview").addClass("d-none");
              $("#content-upload").removeClass("d-none");
              alertify.success(resp.msj);
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.warning("La contraseñas no coinciden, intentelo de nuevo");
        $("#pass").trigger("focus");
      }
    }
  });

  //Las condiciones del formulario password
  $("#formPass").validate({
    rules: {
      pass: "required",
      RePass: {
        equalTo: "#formPassPass"
      }
    }
  })

  $("#formPass").submit(function (e) {
    e.preventDefault();
    let pass = $(this).find("input[name='pass']").val().trim();
    let RePass = $(this).find("input[name='RePass']").val().trim();

    if ($(this).valid()) {
      if (pass == RePass) {
        $.ajax({
          url: rutaBase + "CambiarPass",
          type: 'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: new FormData(this),
          success: function (resp) {
            if (resp.success) {
              DTUsuarios.ajax.reload();
              $("#cambioPassModal").modal("hide");
              alertify.success(resp.msj);
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.warning("La contraseñas no coinciden, intentelo de nuevo");
        $(this).find("input[name='pass']").trigger("focus");
      }
    }
  });

  $("#modalPermisos").on('hidden.bs.modal', function (event) {
    arbolPermisos.reload();
    $("#btnGuardarPermisos").data("id", 0);
  });

  $("#checkAllPermisos").click(function (e) {
    e.preventDefault();
    arbolPermisos.checkAll().expandAll();
  });

  $("#unCheckAllPermisos").click(function (e) {
    e.preventDefault();
    arbolPermisos.uncheckAll().collapseAll();
  });

  $("#exapandAllPermisos").click(function (e) {
    e.preventDefault();
    arbolPermisos.expandAll();
  });

  $("#collapseAllPermisos").click(function (e) {
    e.preventDefault();
    arbolPermisos.collapseAll();
  });

  $("#btnGuardarPermisos").click(function (e) {
    e.preventDefault();
    let id = $(this).data("id");

    if (id != 0) {
      var checked = arbolPermisos.getCheckedNodes();
      $.ajax({
        url: base_url() + "Permisos/Guardar",
        type: "POST",
        dataType: "json",
        data: { id, checked, tipo: 2 },
        success: function (resp) {
          if (resp.success) {
            $("#modalPermisos").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    } else {
      alertify.alert("No se ha seleccionado el perfil para guardar.");
    }
  });

  $(".btnCancelarImg").click(function () {
    srcOriginal = '';
    $('#image').rcrop('destroy');
    $("#video").hide();
    if (stream) {
      const tracks = stream.getTracks();
      tracks.forEach(track => track.stop());
    }
    stream = null;
    $("#modalEditarImage").modal('hide');
    $("#modalUsuario").show();
  });

  $("#tomarFoto").click(function () {
    if (!tieneSoporteUserMedia()) {
      alertify.warning("Su navegador no soporta tomar fotos.");
      return
    }
    cameraActive = 'environment';
    $(".btnsync").show();
    $(".footer-modal").addClass('justify-content-between');
    $("#modalUsuario, #image, .reloadFoto").hide();
    $("#modalEditarImage").modal('show');
    iniciarCamara();
  });
});

function eliminar(data) {
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del usuario ${data.usuario} ("${data.nombre}") a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          idUsuario: data.id,
          estado: (data.estado == "1" ? 0 : 1)
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DTUsuarios.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    }, function () { });
}

function instanciarEditorImagen(image, tamanoMax) {
  $("#image").rcrop("destroy");
  $("#image").attr('src', image);
  setTimeout(() => {
    $('#image').rcrop({
      full: true,
      minSize: [100, 100],
      maxSize: [tamanoMax, tamanoMax],
      preserveAspectRatio: true,
      inputs: true,
      inputsPrefix: '',
      grid: true
    });
    $('#image').show();
  }, 200);

  $('#image').on('rcrop-changed', function () {
    srcOriginal = $(this).rcrop('getDataURL');
  });

  $('#image').on('rcrop-ready', function () {
    $(this).rcrop('resize', tamanoMax, tamanoMax);
    srcOriginal = $(this).rcrop('getDataURL');
  });
}

async function guardarImage() {
  if (stream != null) {
    recortarImagen();
  } else {
    const file = await baseToFile(srcOriginal, 'temp', 'image/png');
    var dt = new DataTransfer();
    dt.items.add(file);
    $("#foto").prop('files', dt.files);
    $('#imgFoto').attr('src', srcOriginal);
    $("#modalEditarImage").modal('hide');
    $("#modalUsuario").show();
    $('#image').rcrop('destroy');
    $("#content-preview").removeClass("d-none");
    $("#content-upload").addClass("d-none");
    if ($("#id").val().length > 0) {
      $("#editFoto").val(0);
    }
  }
}

async function baseToFile(url, filename, mimeType) {
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

function cambiarCamara() {
  cameraActive = (cameraActive == 'environment' ? 'user' : 'environment');
  srcOriginal = '';
  $('#image').rcrop('destroy');
  $("#video").hide();
  iniciarCamara();
}

async function iniciarCamara() {
  $("#imageTemp").show();
  $(".btnGuadarFoto").prop('disabled', true);
  $video = document.querySelector("#video");
  capture(cameraActive);
}

const capture = async facingMode => {
  const options = {
    audio: false,
    video: {
      facingMode,
    },
  };
  try {
    if (stream) {
      const tracks = stream.getTracks();
      tracks.forEach(track => track.stop());
    }
    stream = await navigator.mediaDevices.getUserMedia(options);
  } catch (e) {
    alert(e);
    return;
  }
  $video.srcObject = null;
  $video.srcObject = stream;
  $video.play();
  $("#imageTemp").hide();
  $(".btnGuadarFoto").prop('disabled', false);
  $("#video, .btnsyncaction").show();
}

function recortarImagen() {
  $('.reloadFoto').show();

  //Obtener contexto del canvas y dibujar sobre él
  let $canvas = document.querySelector("#canvas");
  $canvas.width = $video.videoWidth;
  $canvas.height = $video.videoHeight;
  $canvas.getContext("2d").drawImage($video, 0, 0, $canvas.width, $canvas.height);

  var image = new Image();
  image.src = $canvas.toDataURL();

  image.onload = function () {
    var height = this.height;
    var width = this.width;
    let tamanoMax = height <= width ? height : width;
    if (stream) {
      const tracks = stream.getTracks();
      tracks.forEach(track => track.stop());
    }
    $("#video, .btnsyncaction").hide();
    instanciarEditorImagen($canvas.toDataURL(), tamanoMax);
    stream = null;
  };
}

function reintentarFoto() {
  srcOriginal = '';
  $('#image').rcrop('destroy');
  $("#video, .reloadFoto, #image").hide();
  iniciarCamara();
}