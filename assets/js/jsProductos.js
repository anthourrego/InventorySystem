let rutaBase = base_url() + "Productos/";
let srcOriginal = '';
let stream = null;
let $video = null;
let cameraActive = 'environment';
let dataFiltros = {
  estado: 1
};
let DTProductos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { ...dataFiltros, imagenProd: $imagenProd })
    }
  },
  order: [[2, "asc"]],
  search: {
    return: false,
  },
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

    if (dataIndex % 2 == 0) $(row).css('background-color', '#00000030');

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
    alertify.alert("¡Advertencia!", "No hay ninguna categoria creada y/o habilitada. Por favor cree una.");
  }

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

  $("#formCrearEditar").submit(function (e) {
    e.preventDefault();
    let id = $("#id").val().trim();
    let stock = $("#stock").val();

    if ($INVENTARIONEGATIVO == '0' && stock < 0) {
      alertify.alert("¡Advertencia!", "El stock no puede estar en negativo.", function () {
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
            alertify.alert('¡Advertencia!', resp.msj);
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


  $("#modalFotos").on('show.bs.modal', function (event) {
    $("#cantFiltroPaquete").val($CAMPOSPRODUCTO.pacDescarga);
    $("#nroPaquetes").addClass("d-none");
    $("#listaPaquetes").empty();
  });

  $("#cantFiltroPaquete").on("keydown", function (e) {
		if(e.which == 13) {
      $("#btnFiltrarPaquetes").trigger("click");
    }
	});

  $("#btnFiltrarPaquetes").on("click", function(e){
    e.preventDefault();
    let TotalFotos = 0;
    let pac = $("#cantFiltroPaquete").val();

    $.ajax({
      url: rutaBase + "descargarFoto/" + pac,
      type: "GET",
      dataType: "json",
      async: false,
      success: (resp) => {
        TotalFotos = resp; 
      }
    });

    $("#nroPaquetes").removeClass("d-none").find("span").text(TotalFotos.totalPaginas);
    $("#listaPaquetes").empty();

    for (let i = 0; i < TotalFotos.totalPaginas; i++) {
      let offset = i * pac;
      let final = (i+1) * pac; 

      if (final > TotalFotos.totalRegistros){
        final = TotalFotos.totalRegistros;
      }

      $("#listaPaquetes").append(`<a href="#" id="pac${(i+1)}" data-cant="${pac}" data-offset="${offset}" data-final="${final}" class="descargarPaquete list-group-item list-group-item-action d-flex justify-content-between align-items-center">Paquete ${(i+1)} | ${(offset+1)}-${final} <i class="fa-solid fa-download"></i></a>`);
    }
  });

  $(document).on("click", ".descargarPaquete", function(e){
    e.preventDefault();
    let cantidad = $(this).data("cant");
    let offset = $(this).data("offset");
    let final = $(this).data("final");
    $(this).removeClass("list-group-item-success list-group-item-danger");
    $(this).find("i").removeClass("fa-download fa-times").addClass("fa-rotate rotacionEfecto");

    $.ajax({
      url: rutaBase + `descargarFoto/${cantidad}/${offset}`,
      xhrFields: {
        responseType: 'blob'
      },
      success: (resp) => {
        try {
          var a = document.createElement('a');
          var url = window.URL.createObjectURL(resp);
          a.href = url;
          a.download = `${(offset+1)}-${final}.zip`;
          a.click();
          window.URL.revokeObjectURL(url);
          $(this).find("i").removeClass("fa-rotate rotacionEfecto").addClass("fa-check");
          $(this).addClass("list-group-item-success");
        } catch (error) {
          $(this).find("i").removeClass("fa-rotate rotacionEfecto").addClass("fa-times");
          $(this).addClass("list-group-item-danger");
        }
      }
    });

  })

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
    $("#modalCrearEditar").show();
  });

  $("#tomarFoto").click(function () {
    if (!tieneSoporteUserMedia()) {
      alertify.warning("Su navegador no soporta tomar fotos.");
      return
    }
    cameraActive = 'environment';
    $(".btnsync").show();
    $(".footer-modal").addClass('justify-content-between');
    $('#image, .reloadFoto').hide();
    $("#modalCrearEditar").hide();
    $("#modalEditarImage").modal('show');
    iniciarCamara();
  });

  $("#btnFiltros").on('click', function () {
    $("#modalFiltros").modal('show');
    dataFiltros
  });

  $("#formFiltros").submit(function (e) {
    e.preventDefault();

    if (+$("#cantIni").val() && +$("#cantFin").val() && +$("#cantIni").val() > +$("#cantFin").val()) {
      return alertify.warning("La cantidad inicial es mayor a la cantidad final");
    }

    if (+$("#preciIni").val() && +$("#preciFin").val() && +$("#preciIni").val() > +$("#preciFin").val()) {
      return alertify.warning("El precio inicial es mayor al precio final");
    }

    dataFiltros.estado = $("#selectEstado").val();
    dataFiltros.categoria = $("#cateFiltro").val();
    dataFiltros.cantIni = $("#cantIni").val() == "" ? -1 : +$("#cantIni").val();
    dataFiltros.cantFin = $("#cantFin").val() == "" ? -1 : +$("#cantFin").val();
    dataFiltros.preciFin = $("#preciFin").val() == "" ? -1 : +$("#preciFin").val();
    dataFiltros.preciIni = $("#preciIni").val() == "" ? -1 : +$("#preciIni").val();

    $("#modalFiltros").modal('hide');
    DTProductos.ajax.reload();
  });

  $("#reiniciarFiltros").on('click', function () {
    dataFiltros = { estado: 1 };
    $("#selectEstado").val(1);
    $("#cantIni, #cantFin, #preciFin, #preciIni").val('');
    $("#cateFiltro").val('').change();
    $("#modalFiltros").modal('hide');
    DTProductos.ajax.reload();
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