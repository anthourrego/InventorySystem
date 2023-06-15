let rutaBase = base_url() + "Proveedores/";
let rutaBaseUbicacion = base_url() + "Ubicacion/";
let datosFiltro = {
  estado: $("#selectEstado").val(),
  paisProveedor: -1,
  departamentoProveedor: -1,
  ciudadProveedor: -1
};
let dataProveedor = {};

let DTProveedores = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, datosFiltro)
    }
  },
  columns: [
    { data: 'nit' },
    { data: 'nombre' },
    {
      data: 'estado',
      className: 'text-center',
      render: function (meta, type, data, meta) {
        let color = "success";
        if (data.estado == 0) {
          color = "danger";
        }
        return `<button class="btn btn-${color}">${data.NombreEstado}</button>`;
      }
    },
    { data: 'telefono' },
    { data: 'direccion' },
    { data: 'contacto' },
    { data: 'telefonoContacto' },
    { data: 'pais' },
    { data: 'depto' },
    { data: 'ciudad' },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        btnEditar = validPermissions(502) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarEstado = validPermissions(503) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';

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
        $("#modalProveedoresLabel").html(`<i class="fa-solid fa-eye"></i> Ver proveedor`);
        $(".inputVer").addClass("disabled").prop("disabled", true);
        $("button[form='formProveedor']").addClass("d-none");

      } else {
        $("#modalProveedoresLabel").html(`<i class="fa-solid fa-edit"></i> Editar proveedor`);
        $(".inputVer").removeClass("disabled").prop("disabled", false);
        $("button[form='formProveedor']").removeClass("d-none");
      }

      $("#id").val(data.id);
      $("#nit").val(data.nit);
      $("#nombre").val(data.nombre);
      $("#telefono").val(data.telefono);
      $("#direccion").val(data.direccion);
      $("#contacto").val(data.contacto);
      $("#telefonocontacto").val(data.telefonoContacto);
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.NombreEstado);
      dataProveedor = { ...data };
      $(".form-group-edit").removeClass("d-none");
      $("#modalProveedores").modal("show");
    });
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    datosFiltro["estado"] = $("#selectEstado").val();
    DTProveedores.ajax.reload();
  });

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false);
    $("button[form='formProveedor']").removeClass("d-none");
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalProveedoresLabel").html(`<i class="fa-solid fa-plus"></i> Crear proveedor`);
    $("#modalProveedores").modal("show");
  });

  $("#btnFiltros").on("click", function () {
    $("#modalFiltros").modal("show");
  });

  $("#reiniciarFiltros").on("click", function () {
    datosFiltro.paisProveedor = -1;
    datosFiltro.departamentoProveedor = -1;
    datosFiltro.ciudadProveedor = -1;
    $("#modalFiltros").modal("hide");
    DTProveedores.ajax.reload();
  });

  $('#modalFiltros').on('shown.bs.modal	', function (event) {
    if (datosFiltro.paisProveedor == -1) {
      obtenerUbicacion('Paises/Obtener', "#id_paisFiltro");
    }
  });

  $('#modalProveedores').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#nit").trigger('focus');
    }
    obtenerUbicacion('Paises/Obtener', "#id_pais");
  });

  $("#formProveedor").submit(function (e) {
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
            DTProveedores.ajax.reload();
            $("#modalProveedores").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });

  $("#formFiltros").submit(function (e) {
    e.preventDefault();
    if ($(this).valid()) {
      datosFiltro.paisProveedor = $("#id_paisFiltro").val();
      datosFiltro.departamentoProveedor = $("#id_deptoFiltro").val();
      datosFiltro.ciudadProveedor = ($("#id_ciudadFiltro").val() || -1);
      $("#modalFiltros").modal("hide");
      DTProveedores.ajax.reload();
    }
  });

  //Validamos el proveedor
  $("#nit").on("focusout", function () {
    let nit = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if (nit.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "Validar/" + nit + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if (resp > 0) {
            alertify.warning("El nit <b>" + nit + "</b>, ya se encuentra creado, intente con otro nit.");
            $("#nit").trigger("focus");
          }
        }
      });
    }
  });

  $("#id_deptoFiltro, #id_depto").change(function () {
    if ($(this).val() && $(this).val() != -1) {
      let cod = $("#" + $(this).attr('id') + " :selected").data('codigo');
      obtenerUbicacion('Ciudades/Obtener/' + cod, "#" + $(this).data('ciudad'));
    } else {
      if ($(this).data('ciudad') == 'id_ciudadFiltro') {
        $("#" + $(this).data('ciudad')).html('').change();
      }
    }
  });

  $("#id_pais, #id_paisFiltro").change(function () {
    if ($(this).val() && $(this).val() != -1) {
      obtenerUbicacion('Departamentos/Obtener/' + $(this).val(), "#" + $(this).data('depto'));
    } else {
      $("#" + $(this).data('depto')).html('').change();
    }
  });
});

function eliminar(data) {
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del proveedor <b>${data.nombre}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`,
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
            DTProveedores.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    }, function () { });
}

function obtenerUbicacion(extraUrl, input) {
  $.ajax({
    url: rutaBaseUbicacion + extraUrl,
    type: 'GET',
    dataType: 'json',
    cache: false,
    success: function (resp) {
      if (resp.success) {
        let estructura = '';
        if (input == '#id_ciudadFiltro' || input == "#id_deptoFiltro" || input == "#id_paisFiltro") {
          estructura += `<option value="-1" data-codigo="-1">Todos</option>`;
        }
        resp.data.forEach(it => {
          estructura += `<option value="${it.id}" data-codigo="${(it.codigo || '')}">${it.nombre}</option>`;
        });
        $(input).html(estructura);
        let id = $("#id").val().trim();
        if (id.length) {
          let keyData = input.replace('#', '');
          $(input).val(dataProveedor[keyData]).change();
        } else {
          $(input).change();
        }
      }
    }
  });
}