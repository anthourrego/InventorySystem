let rutaBase = base_url() + "Ubicacion/Departamentos/";

let DTDeptos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val() })
    }
  },
  columns: [
    { data: 'codigo' },
    { data: 'nombre' },
    { data: 'Estadito', },
    { data: 'Pais' },
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
        btnEditar = validPermissions(922) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarEstado = validPermissions(923) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';

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
        $("#modalDeptosLabel").html(`<i class="fa-solid fa-eye"></i> Ver departamento`);
        $(".inputVer").addClass("disabled").prop("disabled", true);
        $("button[form='formDepto']").addClass("d-none");
      } else {
        $("#modalDeptosLabel").html(`<i class="fa-solid fa-edit"></i> Editar departamento`);
        $(".inputVer").removeClass("disabled").prop("disabled", false);
        $("button[form='formDepto']").removeClass("d-none");
      }
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#codigo").val(data.codigo);
      $("#id_pais").val(data.id_pais).change();
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#modalDeptos").modal("show");
    });
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    DTDeptos.ajax.reload();
  });

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false);
    $("button[form='formDepto']").removeClass("d-none");
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalDeptosLabel").html(`<i class="fa-solid fa-plus"></i> Crear Departamentos`)
    $("#modalDeptos").modal("show");
  });

  $('#modalDeptos').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#codigo").trigger('focus');
    }
  });

  $("#formDepto").submit(function (e) {
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
            DTDeptos.ajax.reload();
            $("#modalDeptos").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });

  $(".validaCampo").on("focusout", function () {
    let selfi = $(this);
    let campo = $(this).attr("name");
    let valor = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if (valor.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaDepto/" + campo + "/" + valor + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if (resp > 0) {
            inicio = "El código";
            alertify.warning(inicio + " <b>" + valor + "</b>, ya se encuentra creado.");
            selfi.trigger("focus");
          }
        }
      });
    }
  });
});

function eliminar(data) {
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del departamento <b>${data.nombre}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`,
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
            DTDeptos.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    }, function () { });
}