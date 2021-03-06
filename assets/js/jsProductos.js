let rutaBase = base_url() + "Productos/";
let srcOriginal = '';
let stream = null;
let $video = null;
let DTProductos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val(), imagenProd: $imagenProd })
    }
  },
  order: [[2, "asc"]],
  columns: [{
    orderable: false,
    searchable: false,
    visible: $imagenProd,
    defaultContent: '',
    className: "text-center imgProdTb",
    render: function (meta, type, data, meta) {
      return $imagenProd ? `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
                  <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
                </a>` : '';
    }
  },
  { data: 'referencia' },
  {
    data: 'item',
    visible: ($CAMPOSPRODUCTO.item == '1' ? true : false)
  },
  {
    data: 'descripcion',
    width: "30%",
    render: function (meta, type, data, meta) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  },
  { data: 'nombreCategoria' },
  {
    data: 'stock',
    className: 'text-center align-middle',
    render: function (meta, type, data, meta) {
      return `<button class="btn btn-${data.ColorStock}">${data.stock}</button>`;
    }
  },
  {
    data: 'cantPaca',
    className: 'text-center',
    visible: ($CAMPOSPRODUCTO.paca == '1' ? true : false),
  },
  {
    data: 'costo',
    className: 'text-right',
    visible: ($CAMPOSPRODUCTO.costo == '1' ? true : false),
    render: function (meta, type, data, meta) {
      return formatoPesos.format(data.costo);
    }
  },
  {
    data: 'precio_venta',
    className: 'text-right',
    render: function (meta, type, data, meta) {
      return formatoPesos.format(data.precio_venta);
    }
  },
  { data: 'ubicacion', visible: ($CAMPOSPRODUCTO.ubicacion == '1' ? true : false) },
  { data: 'nombreManifiesto', visible: ($CAMPOSPRODUCTO.manifiesto == '1' ? true : false) },
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
      btnEditar = validPermissions(52) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';
      btnCambiarEstado = validPermissions(53) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';
      convertirFoto = (validPermissions(55) && data.imagen != null) ? `<a href="${base_url()}Productos/fotoEditada/${data.id}/${data.imagen}" download class="btn btn-info" title="Convertir foto"><i class="fa-solid fa-download"></i></a>` : '';

      return `<div class="btn-group btn-group-sm" role="group">
                  ${btnEditar}
                  ${convertirFoto}
                  ${btnCambiarEstado}
                </div>`;
    }
  }],
  createdRow: function (row, data, dataIndex) {

    if (!data.manifiesto) $(row).addClass('bg-delete-tb');

    $(row).find(".btnCambiarEstado").click(function (e) {
      e.preventDefault();
      eliminar(data);
    });

    //Editar
    $(row).find(".btnEditar, .btnVer").click(function (e) {
      e.preventDefault();

      if ($(this).hasClass("btnVer")) {
        $("#modalCrearEditarLabel").html(`<i class="fa-solid fa-eye"></i> Ver producto`);
        $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
        $(".btn-eliminar-foto, button[form='formCrearEditar']").addClass("d-none");
      } else {
        $("#modalCrearEditarLabel").html(`<i class="fa-solid fa-edit"></i> Editar producto`);
        $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
        $(".btn-eliminar-foto, button[form='formCrearEditar']").removeClass("d-none");
      }

      $("#id").val(data.id);
      $("#categoria").val(data.id_categoria).trigger('change');
      $("#referencia").val(data.referencia);
      $("#item").val(data.item);
      $("#stock").val(data.stock);
      $("#precioVent").val(data.precio_venta);
      $("#costo").val(data.costo);
      $("#ubicacion").val(data.ubicacion);
      $("#manifiesto").val(data.manifiesto).trigger('change');
      $("#descripcion").val(data.descripcion);
      $("#ventas").val(data.ventas);
      $("#paca").val(data.cantPaca);
      $("#fechaLog").val(moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);

      $("#editFoto").val(0);
      $("#foto").val('');
      if (data.imagen != null) {
        $('#imgFoto').attr('src', base_url() + "Productos/Foto/" + data.id + "/" + data.imagen);
        $("#content-preview").removeClass("d-none");
        $("#content-upload").addClass("d-none");
      } else {
        $("#content-preview").addClass("d-none");
        $("#content-upload").removeClass("d-none");
      }
      $(".form-group-edit").removeClass("d-none");
      $("#modalCrearEditar").modal("show");
    });
  }
});

$(function () {
  //Enviamos el valor del inventario
  $("#valorInventarioActual").val(formatoPesos.format($valorInventarioActual))

  //Se genera alerta informando que no hay ninguna categoria creada o habilitada
  if ($CATEGORIAS <= 0) {
    S
    alertify.alert("??Advertencia!", "No hay ninguna categoria creada y/o habilitada. Por favor cree una.");
  }

  $("#foto").on("change", function (event) {
    const file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        console.log(event.target);
        var image = new Image();
        image.src = event.target.result;

        image.onload = function () {
          var height = this.height;
          var width = this.width;
          let tamanoMax = height <= width ? height : width;
          $('#image').show();
          instanciarEditorImagen(image.src, tamanoMax);
          $("#modalCrearEditar").hide();
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
    $('#imgFoto').attr('src', base_url() + "Productos/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload").removeClass("d-none");

    if ($("#id").val().length > 0) {
      $("#editFoto").val(1);
    }
  });

  $("#selectEstado").on("change", function () {
    DTProductos.ajax.reload();
  });

  $(".validaCampo").on("focusout", function () {
    let selfi = $(this);
    let campo = $(this).data("campo");
    let valor = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if (valor.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaProducto/" + campo + "/" + valor + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if (resp > 0) {
            inicio = campo == "item" ? "El item" : "La referencia ";
            alertify.warning(inicio + " <b>" + valor + "</b>, ya se encuentra creado, intente con otro nombre.");
            selfi.trigger("focus");
          }
        }
      });
    }
  });

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
    $(".btn-eliminar-foto, button[form='formCrearEditar']").removeClass("d-none");
    $("#id").val("");
    $("#editFoto").val(0);
    $("#foto").val('');
    $('#imgFoto').attr('src', base_url() + "Productos/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload").removeClass("d-none");
    $(".form-group-edit").addClass("d-none");
    $("#modalCrearEditarLabel").html(`<i class="fa-solid fa-plus"></i> Crear producto`)
    $("#modalCrearEditar").modal("show");
  });

  /* $('#modalCrearEditar').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#categoria").select2('open');
    }
  }); */

  $("#formCrearEditar").submit(function (e) {
    e.preventDefault();
    let id = $("#id").val().trim();
    let stock = $("#stock").val();

    if ($INVENTARIONEGATIVO == '0' && stock < 0) {
      alertify.alert("??Advertencia!", "El stock no puede estar en negativo.", function () {
        setTimeout(() => {
          $("#stock").trigger("focus").select();
        }, 10);
      });
      return;
    }

    if ($(this).valid()) {
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
            DTProductos.ajax.reload();
            $("#modalCrearEditar").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('??Advertencia!', resp.msj);
          }
        }
      });
    }
  });

  $("#verImg").change(function () {
    if ($(this).is(':checked')) {
      $imagenProd = 1;
    } else {
      $imagenProd = 0;
    }
    DTProductos.column('.imgProdTb').column().visible($imagenProd)
    DTProductos.ajax.reload();
  });

  $("#btnFotos").on("click", function () {
    $("#modalFiltroFoto").modal("show");
  });

  $("#formFiltroFoto").submit(function (e) {
    e.preventDefault();
    if (validPermissions(55)) {
      let minimo = $("#filtroMinimo").val().length > 0 ? $("#filtroMinimo").val().trim().replaceAll(",", "").replaceAll("$ ", "") : 0;
      let maximo = $("#filtroMaximo").val().length > 0 ? $("#filtroMaximo").val().trim().replaceAll(",", "").replaceAll("$ ", "") : 0;

      window.open(rutaBase + `descargarFoto/${minimo}/${maximo}`);
    } else {
      alertify.alert("Advertencia", "No posees permisos para realizar esta acci??n")
    }
  });

  $(".btnCancelarImg").click(function () {
    srcOriginal = '';
    $('#image').rcrop('destroy');
    $("#video").hide();
    $("#modalEditarImage").modal('hide');
    $("#modalCrearEditar").show();
  });

  $("#tomarFoto").click(function () {
    if (!tieneSoporteUserMedia()) {
      alertify.warning("Su navegador no soporta tomar fotos.");
    }
    $('#image').hide();
    iniciarCamara();
  });
});

function eliminar(data) {
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del producto <b>${data.referencia} ("${data.item}")</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          id: data.id,
          estado: (data.estado == "1" ? 0 : 1)
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DTProductos.ajax.reload();
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
  }, 200);

  $('#image').on('rcrop-changed', function () {
    srcOriginal = $(this).rcrop('getDataURL');
    console.log("Funca ", srcOriginal)
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
    $("#modalCrearEditar").show();
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

function _getUserMedia() {
  return (
    navigator.getUserMedia
    || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia)
    || navigator.webkitGetUserMedia || navigator.msGetUserMedia
  ).apply(navigator, arguments);
}

function iniciarCamara() {
  $("#modalCrearEditar").hide();
  $("#modalEditarImage").modal('show');
  $("#video").show();

  // Comenzamos pidiendo los dispositivos
  navigator.mediaDevices.enumerateDevices().then(function (dispositivos) {
    // Vamos a filtrarlos y guardar aqu?? los de v??deo
    const dispositivosDeVideo = [];

    // Recorrer y filtrar
    dispositivos.forEach(function (dispositivo) {
      const tipo = dispositivo.kind;
      if (tipo === "videoinput") {
        dispositivosDeVideo.push(dispositivo);
      }
    });

    // Vemos si encontramos alg??n dispositivo, y en caso de que si, entonces llamamos a la funci??n
    // y le pasamos el id de dispositivo
    if (dispositivosDeVideo.length > 0) {
      // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
      mostrarStream(dispositivosDeVideo[0].deviceId);
    }
  });
}

function mostrarStream(idDeDispositivo) {
  _getUserMedia({
    video: {
      // Justo aqu?? indicamos cu??l dispositivo usar
      deviceId: idDeDispositivo,
    }
  }, function (streamObtenido) {
    // Simple asignaci??n
    stream = streamObtenido;

    $video = document.querySelector("#video");
    // Mandamos el stream de la c??mara al elemento de v??deo
    $video.srcObject = stream;
    $video.play();
  }, function (error) {
    console.log("Permiso denegado o error: ", error);
    $estado.innerHTML = "No se puede acceder a la c??mara, o no diste permiso.";
  });
}

function recortarImagen() {
  $('#image').show();
  //Pausar reproducci??n
  $video.pause();

  //Obtener contexto del canvas y dibujar sobre ??l
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
    $("#video").hide();
    instanciarEditorImagen($canvas.toDataURL(), tamanoMax);
    stream = null;
  };
  /* $("#content-preview").removeClass("d-none");
  $("#content-upload").addClass("d-none"); */
}