let rutaBase = base_url() + "Ubicacion/Ciudades/";

let DTCiudades = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val() })
    }
  },
  columns: [
    { data: 'nombre' },
    { data: 'Estadito', },
    { data: 'Departamento', },
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
        btnEditar = validPermissions(932) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarEstado = validPermissions(933) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';

        return `<div class="btn-group btn-group-sm" role="group">
                  ${btnEditar}
                  ${btnCambiarEstado}
                </div>`;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnCambiarEstado").click(function (e) {
      e.preventDefault();
      eliminar(data);
    });

    $(row).find(".btnEditar, .btnVer").click(function (e) {
      e.preventDefault();

      if ($(this).hasClass("btnVer")) {
        $("#modalCiudadesLabel").html(`<i class="fa-solid fa-eye"></i> Ver ciudad`);
        $(".inputVer").addClass("disabled").prop("disabled", true);
        $("button[form='formCiudad']").addClass("d-none");
      } else {
        $("#modalCiudadesLabel").html(`<i class="fa-solid fa-edit"></i> Editar ciudad`);
        $(".inputVer").removeClass("disabled").prop("disabled", false);
        $("button[form='formCiudad']").removeClass("d-none");
      }
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#codigo").val(data.codigo);
      $("#id_depto").val(data.id_depto).change();
      $("#descripcion").val(data.descripcion);
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#modalCiudades").modal("show");
    });
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    DTCiudades.ajax.reload();
  });

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false);
    $("button[form='formCiudad']").removeClass("d-none");
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalCiudadesLabel").html(`<i class="fa-solid fa-plus"></i> Crear Ciudades`)
    $("#modalCiudades").modal("show");
  });

  $('#modalCiudades').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#codigo").trigger('focus');
    }
  });

  $("#formCiudad").submit(function (e) {
    e.preventDefault();
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
            DTCiudades.ajax.reload();
            $("#modalCiudades").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });
});

function eliminar(data) {
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado de la ciudad <b>${data.nombre}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`,
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
            DTCiudades.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    }, function () { });
}