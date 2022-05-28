let rutaBase = base_url() + "Manifiesto/";
let manifiestoActual = null;

let DTManifiestos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val() })
    }
  },
  select: true,
  order: [[2, "asc"]],
  columns: [
    {
      visible: false,
      orderable: false,
      select:true,
      data: 'eliminar',
      className: 'select-checkbox',
      /* render: function (meta, type, data, meta) {
        return `<div class="text-center">
          <input type="checkbox" aria-label="Checkbox for following text input">
        </div>`;
      } */
    },
    { data: 'nombre' },
    { data: 'Nombre_Estado' },
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
      className: 'text-center',
      render: function (meta, type, data, meta) {

        btnEditar = validPermissions(82) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-user-pen"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarEstado = validPermissions(83) ? `<button type="button" class="btn btn-danger btnCambiarEstado" title="Eliminar"><i class="fa-solid fa-trash"></i></button>` : '';

        btnAsignarProductos = validPermissions(86) ? `<button type="button" class="btn btn-info btnAsignarProductos" title="Asignar Productos"><i class="fa-solid fa-circle-plus"></i></button>` : '';

        btnVerArchivo = validPermissions(84) ? `<button type="button" class="btn btn-light btnVerArchivo" title="Ver Archivo"><i class="fa-solid fa-file-circle-check"></i></button>` : '';

        btnDescargarArhivo = validPermissions(85) ? `<button type="button" class="btn btn-dark btnDescargarArhivo" title="Descargar Archivo"><i class="fa-solid fa-download"></i></button>` : '';

        return `<div class="btn-group btn-group-sm" role="group">
          ${btnEditar}
          ${btnCambiarEstado}
          ${btnAsignarProductos}
          ${btnVerArchivo}
          ${btnDescargarArhivo}
        </div>`;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {

    if (!data.Total_Prods_Manifiesto) $(row).addClass('bg-delete-tb');

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
      manifiestoActual = data.id;
      DTProductos.ajax.reload();
    });
  }
});

let DTProductos = $("#tableProds").DataTable({
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function (d) {
      return $.extend(d, { manifiesto: manifiestoActual })
    }
  },
  dom: domlftrip,
  order: [[2, "asc"]],
  columns: [
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: "text-center",
      render: function (meta, type, data, meta) {
        return `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
          <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
        </a>`;
      }
    },
    { data: 'item' },
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
      className: 'text-center',
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
    },
  ],
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
});

$(function () {
  $("#selectEstado").on("change", function () {
    DTManifiestos.ajax.reload();
    /* DTManifiestos.column(0).visible(false);
    if ($(this).val() == 0) {
      DTManifiestos.column(0).visible(true);
    } */
  });

  $("#btnCrearManifiesto").on("click", function () {
    $(".inputVer").val("").removeClass("disabled").prop("disabled", false).trigger('change');
    $("#modalManifiestoLabel").html(`<i class="fa-solid fa-user-plus"></i> Crear Manifiesto`);
    $(".form-group-edit").addClass("d-none");
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

    if (!$("#fileUpload").prop('files').length) {
      return alertify.warning("No tiene archivo seleccionado");
    }

    const file = $("#fileUpload").prop('files')[0];
    if (file.size >= 10000000) {
      return alertify.error("El archivo es superior a 10Mb");
    }

    let id = $("#id").val().trim();

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
            DTManifiestos.ajax.reload();
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

});

function eliminar(data) {
  alertify.confirm('Cambiar estado', `¿Esta seguro de eliminar el Manifiesto ${data.nombre}?`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          idManifiesto: data.id,
          estado: (data.estado == "1" ? 0 : 1)
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DTManifiestos.ajax.reload();
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