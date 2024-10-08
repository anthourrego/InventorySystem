let rutaBase = base_url() + "Clientes/";
let rutaBaseSucursal = base_url() + "Sucursales/";
let rutaBaseUbicacion = base_url() + "Ubicacion/";
let DTSucursales = null;
let crearSucursal = false;
let permisoSucursales = validPermissions(44);
let dataSucursal = {};
let datosFiltro = {
  estado: $("#selectEstado").val(),
  departamentoSucursal: -1,
  ciudadSucursal: -1
};

let DTClientes = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, datosFiltro)
    }
  },
  columns: [
    { data: 'documento' },
    { data: 'nombre' },
    { data: 'direccion' },
    { data: 'telefono' },
    { data: 'compras' },
    {
      data: 'ultima_compra',
      render: function (meta, type, data, meta2) {
        return data.ultima_compra ? moment(data.ultima_compra, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A") : '';
      }
    },
    { data: 'sucursales' },
    {
      data: 'created_at',
      render: function (meta, type, data, meta2) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta2) {
        let btnEditar = validPermissions(42) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        let btnCambiarEstado = validPermissions(43) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';

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
        $("#modalClientesLabel").html(`<i class="fa-solid fa-eye"></i> Ver cliente`);
        $(".inputVer").addClass("disabled").prop("disabled", true);
        $("button[form='formClientes']").addClass("d-none");

      } else {
        $("#modalClientesLabel").html(`<i class="fa-solid fa-edit"></i> Editar cliente`);
        $(".inputVer").removeClass("disabled").prop("disabled", false);
        $("button[form='formClientes']").removeClass("d-none");
      }

      $("#id").val(data.id);
      $("#documento").val(data.documento);
      $("#nombre").val(data.nombre);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#administrador").val(data.administrador);
      $("#cartera").val(data.cartera);
      $("#telefonoCart").val(data.telefonocart);
      $("#cantCompras").val(data.compras);
      $("#fechaCompra").val((data.ultima_compra ? moment(data.ultima_compra, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A") : ''));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#sucursales-tab").removeClass("disabled");
      $("#cliente-tab").click();
      $("#modalClientes").modal("show");
    });
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    datosFiltro["estado"] = $("#selectEstado").val();
    DTClientes.ajax.reload();
  });

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false);
    $("button[form='formClientes']").removeClass("d-none");
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalClientesLabel").html(`<i class="fa-solid fa-plus"></i> Crear cliente`);
    $("#cliente-tab").click();
    $("#sucursales-tab").addClass('disabled');
    $("#modalClientes").modal("show");
  });

  $("#btnFiltros").on("click", function () {
    $("#modalFiltros").modal("show");
  });

  $("#reiniciarFiltros").on("click", function () {
    datosFiltro.departamentoSucursal = -1;
    datosFiltro.ciudadSucursal = -1;
    $("#modalFiltros").modal("hide");
    DTClientes.ajax.reload();
  });

  $('#modalFiltros').on('shown.bs.modal	', function (event) {
    if (datosFiltro.departamentoSucursal == -1) {
      obtenerUbicacion('Departamentos/Obtener/0', "#id_deptoFiltro");
    }
  });

  $('#modalClientes').on('shown.bs.modal	', function (event) {
    if ($("#id").val().length <= 0) {
      $("#documento").trigger('focus');
    }
    obtenerUbicacion('Departamentos/Obtener/0', "#id_deptoSucursal");
  });

  $("#formClientes").submit(function (e) {
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
            DTClientes.ajax.reload();
            $("#sucursales-tab").removeClass('disabled');
            if (permisoSucursales && (!id.length || crearSucursal)) {
              crearSucursal = false;
              $("#id").val(resp.id);
              $("#sucursales-tab").click();
            } else {
              $("#modalClientes").modal("hide");
              alertify.success(resp.msj);
            }
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
      datosFiltro["departamentoSucursal"] = $("#id_deptoFiltro").val();
      datosFiltro["ciudadSucursal"] = $("#id_ciudadFiltro").val();
      $("#modalFiltros").modal("hide");
      DTClientes.ajax.reload();
    }
  });

  //Validamos el clientes
  $("#documento").on("focusout", function () {
    let documento = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if (documento.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "Validar/" + documento + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if (resp > 0) {
            alertify.warning("El número de documento <b>" + documento + "</b>, ya se encuentra creado, intente con otro número.");
            $("#documento").trigger("focus");
          }
        }
      });
    }
  });

  $("#formSucursal").submit(function (e) {
    e.preventDefault();
    let id = $("#idSucursal").val().trim();
    if ($(this).valid()) {
      let idCli = $("#id").val().trim();
      if (idCli.length) {
        let form = new FormData(this);
        form.append('id_cliente', idCli);
        $.ajax({
          url: rutaBaseSucursal + (id.length > 0 ? "Editar" : "Crear"),
          type: 'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: form,
          success: function (resp) {
            if (resp.success) {
              DTSucursales.ajax.reload();
              $("#idSucursal, #nombreSucursal, #direccionSucursal, #administradorSucursal, #carteraSucursal, #telefonoCartSucursal, #telefonoSucursal, #barrioSucursal, #diasVencimientoVenta").val('');
              $("#id_ciudadSucursal, #id_deptoSucursal").val(0).change();
              $('#collapseDatosBasicos').collapse('hide');
              alertify.success(resp.msj);
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        crearSucursal = true;
        alertify.warning("No se encontro cliente registrado");
        $("#cliente-tab").addClass('active');
        $("#sucursales-tab").removeClass('active');
        $("#sucursalesTab").removeClass('show').removeClass('active');
        $("#clienteTab").addClass('show active');
        $("[form=formClientes]").click();
      }
    }
  });

  $('#sucursales-tab').on('shown.bs.tab', function (event) {
    $('#collapseDatosBasicos').collapse('hide');
    tablaSucursales();
    $(".modal-width").removeClass('modal-lg').addClass('modal-xl');
  });

  $('#sucursales-tab').on('hidden.bs.tab', function (event) {
    $(".modal-width").removeClass('modal-xl').addClass('modal-lg');
  });

  $('#collapseDatosBasicos').on('shown.bs.collapse', function () {
    $(".icono-collapse").removeClass('fa-arrow-down').addClass('fa-arrow-up');
  });

  $('#collapseDatosBasicos').on('hidden.bs.collapse', function () {
    $(".icono-collapse").removeClass('fa-arrow-up').addClass('fa-arrow-down');
  });

  $("#id_deptoSucursal, #id_deptoFiltro").change(function () {
    if ($(this).val() && $(this).val() != -1) {
      let cod = $("#" + $(this).attr('id') + " :selected").data('codigo');
      obtenerUbicacion('Ciudades/Obtener/' + cod, "#" + $(this).data('ciudad'));
    } else {
      if ($(this).data('ciudad') == 'id_ciudadFiltro') {
        $("#" + $(this).data('ciudad')).html('').change();
      }
    }
  });

  $("#btnLimpiar").click(function () {
    $("button[form='formSucursal']").attr("disabled", false);
    $(".inputVer").removeClass("disabled").prop("disabled", false);
    $("#idSucursal, #nombreSucursal, #direccionSucursal, #administradorSucursal, #carteraSucursal, #telefonoCartSucursal, #telefonoSucursal, #barrioSucursal").val('');
    $("#id_ciudadSucursal, #id_deptoSucursal").val(0).change();
    $(this).hide();
  });
});

function eliminar(data, sucursal = false) {
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado ${sucursal ? 'de la sucursal' : 'del cliente'} <b>${data.nombre}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`,
    function () {
      $.ajax({
        type: "POST",
        url: (sucursal ? rutaBaseSucursal : rutaBase) + "Eliminar",
        dataType: 'json',
        data: {
          id: data.id,
          estado: (data.estado == "1" ? 0 : 1)
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            if (sucursal) {
              tablaSucursales();
            } else {
              DTClientes.ajax.reload();
            }
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    }, function () { });
}

function tablaSucursales() {
  if (DTSucursales) {
    DTSucursales.ajax.reload();
  } else {
    DTSucursales = $("#tblSucursal").DataTable({
      ajax: {
        url: rutaBaseSucursal + "DT",
        type: "POST",
        data: function (d) {
          return $.extend(d, { cliente: $("#id").val().trim(), estado: -1 })
        }
      },
      pageLength: 10,
      columns: [
        { data: 'nombre' },
        { data: 'ciudad' },
        { data: 'direccion' },
        { data: 'telefono' },
        { data: 'administrador' },
        { data: 'cartera' },
        { data: 'telefonocart' },
        { data: 'barrio' },
        { data: 'diasVencimientoVenta' },
        {
          orderable: false,
          searchable: false,
          defaultContent: '',
          className: 'text-center noExport',
          render: function (meta, type, data, meta2) {
            let btnEditar = validPermissions(442) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

            let btnCambiarEstado = validPermissions(443) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';

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
          eliminar(data, true);
        });

        $(row).find(".btnEditar, .btnVer").click(function (e) {
          e.preventDefault();

          if ($(this).hasClass("btnVer")) {
            $(".inputVer").addClass("disabled").prop("disabled", true);
            $("button[form='formSucursal']").attr("disabled", true);
            $("#btnLimpiar").show();
          } else {
            $(".inputVer").removeClass("disabled").prop("disabled", false);
            $("button[form='formSucursal']").attr("disabled", false);
            $("#btnLimpiar").hide();
          }

          $("#idSucursal").val(data.id);
          $("#id_deptoSucursal").val(data.id_depto).change();
          $("#nombreSucursal").val(data.nombre);
          $("#direccionSucursal").val(data.direccion);
          $("#administradorSucursal").val(data.administrador);
          $("#carteraSucursal").val(data.cartera);
          $("#telefonoCartSucursal").val(data.telefonocart);
          $("#telefonoSucursal").val(data.telefono);
          $("#barrioSucursal").val(data.barrio);
          $("#diasVencimientoVenta").val(data.diasVencimientoVenta);
          dataSucursal = data;
          $('#collapseDatosBasicos').collapse('show');
        });
      }
    });
    DTSucursales.draw();
  }
}

function obtenerUbicacion(extraUrl, input) {
  $.ajax({
    url: rutaBaseUbicacion + extraUrl,
    type: 'GET',
    dataType: 'json',
    processData: false,
    contentType: false,
    cache: false,
    success: function (resp) {
      if (resp.success) {
        let estructura = '';
        if (input == '#id_ciudadFiltro' || input == "#id_deptoFiltro") {
          estructura += `<option value="-1" data-codigo="-1">Todos</option>`;
        }
        resp.data.forEach(it => {
          estructura += `<option value="${it.id}" data-codigo="${(it.codigo || '')}">${it.nombre}</option>`;
        });
        $(input).html(estructura).change();
        let id = $("#idSucursal").val().trim();
        if (id.length && dataSucursal.id_ciudad > 0) {
          $(input).val(dataSucursal.id_ciudad).change();
        }
      }
    }
  });
}