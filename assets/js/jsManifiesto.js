let rutaBase = base_url() + "Manifiesto/";
let manifiestoActual = null;
let seleccionoTodo = 0;
let selecciones = [];
let totalRegistros = 0;
let DTVerProductos = null;
let DTProductos = null;

let DTManifiestos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val() })
    }
  },
  select: {
    style: 'multi',
    selector: '.checkManifiesto'
  },
  order: [[2, "asc"]],
  columns: [
    {
      visible: false,
      orderable: false,
      select: true,
      data: 'eliminar',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        return `<div class="custom-control custom-checkbox text-center">
          <input type="checkbox" class="custom-control-input checkManifiesto" value="1" id="check${data.id}">
          <label class="custom-control-label" for="check${data.id}"></label>
        </div>`;
      }
    },
    { data: 'nombre' },
    { data: 'Nombre_Estado' },
    {
      data: 'created_at',
      render: function (meta, type, data, meta) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    { data: 'Asignacion' },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {

        btnEditar = validPermissions(82) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-edit"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarEstado = validPermissions(83) ? `<button type="button" class="btn btn-danger btnCambiarEstado" title="Eliminar"><i class="fa-solid fa-trash"></i></button>` : '';

        btnAsignarProductos = validPermissions(86) ? `<button type="button" class="btn btn-info btnAsignarProductos" title="Asignar Productos"><i class="fa-solid fa-circle-plus"></i></button>` : '';

        btnVerArchivo = validPermissions(84) ? `<a href="${rutaBase}Ver/${data.id}" target="_blank" type="button" class="btn btn-light btnVerArchivo" title="Ver Archivo"><i class="fa-solid fa-file-circle-check"></i></a>` : '';

        btnDescargarArhivo = validPermissions(85) ? `<a href="${rutaBase}Descargar/${data.id}" type="button" class="btn btn-dark btnDescargarArhivo" title="Descargar Archivo"><i class="fa-solid fa-download"></i></a>` : '';

        btnVerProdsManif = validPermissions(88) ? `<button type="button" class="btn btn-primary btnVerProdsManif" title="Ver Productos"><i class="fa-solid fa-eye"></i></button>` : '';

        return `<div class="btn-group btn-group-sm group-actions" role="group">
          ${btnEditar}
          ${btnCambiarEstado}
          ${btnAsignarProductos}
          ${btnVerArchivo}
          ${btnDescargarArhivo}
          ${btnVerProdsManif}
        </div>`;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {

    if (!data.Total_Prods_Manifiesto) $(row).addClass('bg-delete-tb');

    if (
      (seleccionoTodo == 1 && selecciones.findIndex(p => p.id == data.id) == -1)
      || (seleccionoTodo == 0 && selecciones.findIndex(p => p.id == data.id) != -1)
    ) {
      DTManifiestos.row(dataIndex).select();
      $(row).find('.checkManifiesto').prop("checked", true);
    }

    if (seleccionoTodo || (!seleccionoTodo && selecciones.length)) {
      $(row).find(".group-actions button").prop('disabled', true);
    } else {
      $(row).find(".group-actions button").prop('disabled', false);
    }

    //Cambio de estado
    $(row).find(".btnCambiarEstado").on("click", function () {
      eliminar(data);
    });

    //Editar Manifiesto
    $(row).find(".btnEditar, .btnVer").click(function (e) {
      e.preventDefault();

      if ($(this).hasClass("btnVer")) {
        $("#modalManifiestoLabel").html(`<i class="fa-solid fa-eye"></i> Ver Manifiesto`);
        $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
      } else {
        $("#modalManifiestoLabel").html(`<i class="fa-solid fa-user-pen"></i> Editar Manifiesto`);
        $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
      }

      $("#labelInputFile").text(data.ruta_archivo);
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#fechaLog").val(moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Nombre_Estado);
      $(".form-group-edit").removeClass("d-none");
      $("#modalManifiesto").modal("show");
    });

    $(row).find(".btnAsignarProductos").on("click", function () {
      $("#cardManifiestos").removeClass('col-md-12').addClass('col-md-6');
      $("#cardProds").show();
      $('.bg-selected-tb').removeClass('bg-selected-tb');
      $(row).addClass('bg-selected-tb');
      manifiestoActual = data.id;
      if (!DTProductos) {
        DTProductos = $("#tableProds").DataTable(DTProductosStruc)
      } else {
        DTProductos.ajax.reload();
      }
    });

    $(row).find(".btnVerProdsManif").on("click", function () {
      manifiestoActual = data.id;
      if (!DTVerProductos) {
        DTVerProductos = $("#tableProdsManif").DataTable(DTVerProductosStruc);
      } else {
        DTVerProductos.ajax.reload();
      }
      $("#modalVerProdsManifiestoLabel").html(`<i class="fa-solid fa-eye"></i> Productos de ${data.nombre}`);
      $("#modalProdsManifiesto").modal('show');
    });
  },
  drawCallback: function (settings) {
    totalRegistros = settings.json.recordsTotal;

    if (totalRegistros < 1) {
      $("#checkAll").prop("disabled", true);
    } else {
      $("#checkAll").prop("disabled", false);
    }
  }
}).on('select', function (e, dt, type, indexes) {

  let dataRow = dt.rows(indexes).data().toArray()[0];
  if (!seleccionoTodo) {
    agregarManifiesto(dataRow);
    if (totalRegistros == selecciones.length) {
      seleccionoTodo = 1;
      $("#checkAll").prop("indeterminate", false).prop("checked", true);
      selecciones = [];
    } else if (selecciones.length > 0) {
      $("#checkAll").prop("indeterminate", true);
    }
  } else {
    eliminarManifiesto(dataRow);
    if (!selecciones.length) {
      $("#checkAll").prop("indeterminate", false).prop("checked", true);
    }
  }

  if (seleccionoTodo || (!seleccionoTodo && selecciones.length)) {
    $(".group-actions button, #btnCrearManifiesto").prop('disabled', true);
  } else {
    $(".group-actions button, #btnCrearManifiesto").prop('disabled', false);
  }

}).on('deselect', function (e, dt, type, indexes) {

  let dataRow = dt.rows(indexes).data().toArray()[0];
  if (!seleccionoTodo) {
    eliminarManifiesto(dataRow);
    if (selecciones.length <= 0) {
      $("#checkAll").prop("indeterminate", false).prop("checked", false);
    }
  } else {
    agregarManifiesto(dataRow);
    $("#checkAll").prop("indeterminate", true);
    if (totalRegistros == selecciones.length) {
      seleccionoTodo = 0;
      $("#checkAll").prop("indeterminate", false).prop("checked", false);
      selecciones = [];
    }
  }

  if (seleccionoTodo || (!seleccionoTodo && selecciones.length)) {
    $(".group-actions button, #btnCrearManifiesto").prop('disabled', true);
  } else {
    $(".group-actions button, #btnCrearManifiesto").prop('disabled', false);
  }

});

let DTProductosStruc = {
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function (d) {
      return $.extend(d, { manifiesto: manifiestoActual })
    }
  },
  dom: domBftrip,
  buttons: [
    'pageLength'
  ],
  order: [[1, "asc"]],
  columns: [{
    orderable: false,
    searchable: false,
    visible: $imagenProd,
    defaultContent: '',
    className: "text-center imgProdTb",
    render: function (meta, type, data, meta) {
      return $imagenProd || $("#verImg1").is(':checked') ? `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
        <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
      </a>` : '';
    }
  },
  { data: 'referencia' },
  { data: 'item', visible: ($CAMPOSPRODUCTO.item == '1' ? true : false) },
  {
    data: 'descripcion',
    width: "30%",
    render: function (meta, type, data, meta) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  },
  {
    orderable: false,
    searchable: false,
    defaultContent: '',
    className: 'text-center noExport',
    render: function (meta, type, data, meta) {
      if (data.id_manifiesto == manifiestoActual) {
        return `<div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-danger btnRemove" title="Agregar a manifiesto"><i class="fa-solid fa-circle-minus"></i></button>
          </div>`;
      } else {
        return `<div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-success btnAdd" title="Eliminar de manifiesto"><i class="fa-solid fa-plus"></i></button>
          </div>`;
      }
    }
  }],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnAdd, .btnRemove").on("click", function () {

      let idManifiesto = $(this).hasClass('btnRemove') ? '-1' : manifiestoActual;

      $.ajax({
        type: "POST",
        url: rutaBase + "AgregarProducto",
        dataType: 'json',
        data: {
          idProd: data.id, idManifiesto
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
    });
  }
};

let DTVerProductosStruc = {
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function (d) {
      return $.extend(d, { manifiesto: manifiestoActual, ver: true })
    }
  },
  dom: domBftrip,
  buttons: [
    'pageLength'
  ],
  order: [],
  columns: [{
    orderable: false,
    searchable: false,
    defaultContent: '',
    visible: $imagenProd,
    className: "text-center imgProdTb",
    render: function (meta, type, data, meta) {
      return $imagenProd || $("#verImg2").is(':checked') ? `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
          <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
        </a>` : '';
    }
  },
  { data: 'referencia' },
  { data: 'item', visible: ($CAMPOSPRODUCTO.item == '1' ? true : false) },
  {
    data: 'descripcion',
    width: "30%",
    render: function (meta, type, data, meta) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  }]
};

$(function () {
  $("#selectEstado").on("change", function () {
    DTManifiestos.ajax.reload();
    if ($permisoEliminarMultiple) {
      selecciones = [];
      $("#checkAll").prop("indeterminate", false).prop("checked", false);
      DTManifiestos.column(0).visible(false);
      $("#btnEliminarMultiple").hide();
      if ($(this).val() == 0) {
        $("#btnEliminarMultiple").show();
        DTManifiestos.column(0).visible(true);

        $("#btnEliminarMultiple").unbind('click').on('click', function () {

          if (!seleccionoTodo && !selecciones.length) {
            return alertify.warning("Debe seleccionar al menos un producto para eliminar");
          }

          let info = {
            id: '',
            estado: 0,
            archivo: ''
          }
          eliminar(info, 1);

        });

      }
    }
  });

  $("#btnCrearManifiesto").on("click", function () {
    $(".inputVer").val("").removeClass("disabled").prop("disabled", false).trigger('change');
    $("#modalManifiestoLabel").html(`<i class="fa-solid fa-user-plus"></i> Crear Manifiesto`);
    $(".form-group-edit").addClass("d-none");
    $("#id").val("");
    $("#editFile").val(0);
    $("#labelInputFile").text('Seleccionar archivo...');
    $("#modalManifiesto").modal("show");
  });

  $('#modalManifiesto').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#nombre").trigger('focus');
    }
  });

  //Formulario de Manifiesto
  $("#formManifiesto").on("submit", function (e) {
    e.preventDefault();

    let id = $("#id").val().trim();

    if (!id.length && !$("#fileUpload").prop('files').length) {
      return alertify.warning("No tiene archivo seleccionado");
    }

    const file = $("#fileUpload").prop('files')[0];
    if (!id.length && file.size >= 10000000) {
      return alertify.error("El archivo es superior a 10Mb");
    }

    let valido = true;
    if (!id.length) {
      valido = $(this).valid();
    } else {
      if (!$("#nombre").valid()) {
        valido = $("#nombre").valid();
      }
    }

    if (valido) {
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
            $("#btnFinalizarAgregarProds").click();
            $("#modalManifiesto").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });

  //Las condiciones del formulario
  $("#formManifiesto").validate({
    rules: {
      fileUpload: {
        required: true,
        accept: "image/*,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword"
      }
    },
    messages: {
      fileUpload: {
        accept: "Seleccione un archivo valido"
      }
    }
  });

  $("#fileUpload").on('change', function () {
    const file = this.files[0];
    if (!file || (file && file.size >= 10000000)) {
      if (file && file.size >= 10000000) alertify.error("El archivo es superior a 10Mb");
      $("#fileUpload").val('');
      $("#labelInputFile").text('Seleccionar archivo...');
    } else {
      $("#labelInputFile").text($(this).val());
      if ($("#id").val().length > 0) {
        $("#editFile").val(1);
      }
    }
  });

  $("#btnFinalizarAgregarProds").on('click', function () {
    $("#cardManifiestos").addClass('col-md-12').removeClass('col-md-6');
    DTManifiestos.ajax.reload();
    $("#cardProds").hide();
  });

  $(document).on('change', '#checkAll', function () {
    $("#checkAll").prop("indeterminate", false);
    selecciones = [];
    if ($(this).is(":checked")) {
      seleccionoTodo = 1;
      $(".checkManifiesto").prop("checked", true);
      DTManifiestos.rows().select();
    } else {
      seleccionoTodo = 0;
      $(".checkManifiesto").prop("checked", false);
      DTManifiestos.rows().deselect();
    }
  });

  $("#modalProdsManifiesto").on('hidden.bs.modal', function () {
    $("#modalProdsManifiesto").modal('hide');
    DTManifiestos.ajax.reload();
  });

  $(".verImg").change(function () {
    if ($(this).is(':checked')) {
      $imagenProd = 1;
    } else {
      $imagenProd = 0;
    }
    if ($(this).data('tipo') == '1') {
      DTProductos.column('.imgProdTb').column().visible($imagenProd);
      DTProductos.ajax.reload();
    }
    if ($(this).data('tipo') == '2') {
      DTVerProductos.column('.imgProdTb').column().visible($imagenProd);
      DTVerProductos.ajax.reload();
    }
  });

});

function eliminar(data, varios = 0) {
  alertify.confirm('Cambiar estado', `¿Esta seguro de eliminar ${varios ? 'los manifiestos' : `el Manifiesto ${data.nombre}`}?`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          idManifiesto: data.id,
          estado: (data.estado == "1" ? 0 : 1),
          archivo: data.ruta_archivo,
          muchos: varios + '',
          todo: seleccionoTodo + '',
          selecciones: selecciones
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DTManifiestos.ajax.reload();
            $("#checkAll").prop("indeterminate", false).prop("checked", false);
            selecciones = [];
            seleccionoTodo = 0;
            $("#btnCrearManifiesto").prop('disabled', false);
          } else {
            if (resp.alert) {
              alertify.alert('¡Advertencia!', resp.msj);
            } else {
              alertify.error(resp.msj);
            }
          }
        }
      });
    }, function () { });
}

function agregarManifiesto(data) {
  if (!selecciones.some(it => it.id == data.id)) {
    selecciones.push({
      id: data.id,
      archivo: data.ruta_archivo,
      nombre: data.nombre
    });
  }
}

function eliminarManifiesto(data) {
  let index = selecciones.findIndex(ele => ele.id == data.id);
  if (index != -1) selecciones.splice(index, 1);
}