let rutaBase = `${base_url()}IngresoMercancia/`;
let dataProdsAdd = [];
let dataProdSearchAproximate = [];
let idEntryEdit = -1;
let idProductoIngresoMercanciaEditar = '';
let isOpenModalProducto = false;
let DTIngresoMercancia = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": Math.random() })
    }
  },
  order: [[0, "desc"]],
  scrollX: true,
  columns: [
    {
      data: 'Codigo'
    }, {
      data: 'Nombre_Usuario'
    }, {
      className: 'text-center',
      data: 'Descripcion_Estado',
      render: function (meta, type, data, meta2) {
        let color = "warning";
        if (data.Estado == 'AN') {
          color = "danger";
        } else if (data.Estado == 'CO') {
          color = "success";
        }
        return `<button class="btn btn-${color}">${data.Descripcion_Estado}</button>`;
      }
    }, {
      data: 'Total_Productos',
      className: 'text-center'
    }, {
      data: 'observacion',
      render: function (meta, type, data, meta2) {
        return `<span title="${data.observacion}" class="text-descripcion">${data.observacion}</span>`;
      }
    }, {
      data: 'Fecha_Creacion',
      render: function (meta, type, data, meta2) {
        return moment(data.Fecha_Creacion, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    }, {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta2) {

        let botones = ``;

        botones += validPermissions(805) ? `<a href="${base_url()}Reportes/IngresoMercancia/${data.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Ingreso">
          <i class="fa-solid fa-print"></i>
        </a>` : '';

        botones += validPermissions(802) && !['AN', 'CO'].includes(data.Estado) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        botones += validPermissions(803) && !['AN', 'CO'].includes(data.Estado) ? '<button type="button" class="btn btn-success btnConfirmar" title="Confirmar Ingreso"><i class="fa-solid fa-check"></i></button>' : '';

        botones += validPermissions(804) && !['AN'].includes(data.Estado) ? '<button type="button" class="btn btn-danger btnEliminar" title="Anular Ingreso"><i class="fa-solid fa-ban"></i></button>' : '';

        return `<div class="btn-group btn-group-sm" role="group">${botones}</div>`;
      }
    }
  ],
  createdRow: function (row, data, dataIndex) {
    //Editar
    $(row).find(".btnEditar, .btnVer").click(function (e) {
      e.preventDefault();
      let $btnClick = $(this);
      $.ajax({
        type: "GET",
        url: rutaBase + "Obtener/" + data.id,
        dataType: 'json',
        success: function ({ ingreso, productos }) {
          setValuesEntry(ingreso, productos);

          $("#btn-confirm-entry").addClass('d-none');

          let showColumnActions = false;
          if ($btnClick.hasClass("btnVer")) {
            $("#modalCrearEditarIngresoLabel").html(`<i class="fa-solid fa-eye"></i> Ver ingreso ${ingreso.codigo}`);
            $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
            $("#btn-save-entry").addClass("d-none");
          } else {
            $("#modalCrearEditarIngresoLabel").html(`<i class="fa-solid fa-edit"></i> Editar ingreso ${ingreso.codigo}`);
            $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
            $("#btn-save-entry").removeClass("d-none");
            showColumnActions = true;
          }
          DTDataProdsAdd.columns(['.actions-product-entry', '.stock-total-product-entry']).visible(showColumnActions);

          $("#modalCrearEditarIngreso").modal('show');
        }
      });
    });

    $(row).find(".btnEliminar").click(function (e) {
      e.preventDefault();

      alertify.confirm('Anular Ingreso', `Esta seguro de anular el ingreso <b>${data.Codigo}</b>?`, function () {
        $.ajax({
          type: "POST",
          url: rutaBase + "Anular",
          dataType: 'json',
          data: {
            idIngresoMercancia: data.id
          },
          success: function (resp) {
            if (resp.success) {
              alertify.success(resp.msj);
              DTIngresoMercancia.ajax.reload();
            } else {
              alertify.error(resp.msj);
            }
          }
        });
      }, function () { });
    });

    $(row).find(".btnConfirmar").click(function (e) {
      e.preventDefault();

      $.ajax({
        type: "GET",
        url: rutaBase + "Obtener/" + data.id,
        dataType: 'json',
        success: function ({ ingreso, productos }) {

          setValuesEntry(ingreso, productos);

          $("#modalCrearEditarIngresoLabel").html(`<i class="fa-solid fa-check"></i> Confirmar ingreso ${ingreso.codigo}`);

          $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');

          $("#btn-save-entry").addClass('d-none');
          $("#btn-confirm-entry").removeClass('d-none');
          DTDataProdsAdd.columns(['.actions-product-entry', '.stock-total-product-entry']).visible(true);

          $("#modalCrearEditarIngreso").modal('show');

          $("#btn-confirm-entry").off('click').on('click', function () {
            saveEntry(1);
          });
        }
      });
    });
  }
});

let DTDataProdsAdd = $("#tblProducts").DataTable({
  scrollX: true,
  data: dataProdsAdd,
  order: [],
  pageLength: 5,
  processing: false,
  serverSide: false,
  search: {
    return: false,
  },
  columns: [{
    data: 'referencia'
  }, {
    visible: MANEJAITEM,
    data: 'item'
  }, {
    data: 'descripcion',
    width: "30%",
    render: function (meta, type, data, meta2) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  }, {
    data: 'stock'
  }, {
    data: 'cantidad'
  }, {
    data: 'cantidadTotal',
    className: 'stock-total-product-entry',
    render: function (meta, type, data, meta2) {
      return `<span class="text-descripcion">${+data.stock + (+data.cantidad)}</span>`;
    }
  }, {
    data: 'Acciones',
    orderable: false,
    searchable: false,
    visible: validPermissions(802),
    defaultContent: '',
    className: 'text-center actions-product-entry noExport',
    render: function (meta, type, data, meta2) {
      let buttons = `
        <button type="button" class="btn btn-danger btnDelete" title="Eliminar">
          <i class="fa-solid fa-trash"></i>
        </button>
        ${$("#btn-confirm-entry").hasClass('d-none') ? `<button type="button" class="btn btn-secondary btnEditarProductoIngreso" title="Editar producto">
          <i class="fa-solid fa-edit"></i>
        </button>` : ''}
      `;

      return `<div class="btn-group btn-group-sm" role="group">${buttons}</div>`;
    }
  }],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnDelete").click(function (e) {
      e.preventDefault();
      let indexProd = dataProdsAdd.findIndex(product => product.id == data.id)
      if (indexProd > -1) {
        dataProdsAdd.splice(indexProd, 1);
      }
      DTDataProdsAdd.clear().rows.add(dataProdsAdd).draw();
    });

    $(row).find('.btnEditarProductoIngreso').click(function (e) {
      e.preventDefault();

      $("#modalCrearEditarIngreso").modal('hide');
      setTimeout(() => {
        isOpenModalProducto = true;
        $("#modalProdCuenta").modal('show');

        $("#referencia").val(data.referencia);
        $("#item").val(data.item);
        $("#descripcion").val(data.descripcion);
        $("#stock").val(data.stock);
        $("#cantidad").val(data.cantidad);

        $("#idProducto").val(data.idProducto ? data.idProducto : 0);
        $("#idIngresoMercanciaProd").val(data.idIngresoMercanciaProd);
        idProductoIngresoMercanciaEditar = data.id;

        $("[form=formCrearEditar]").html('<i class="fas fa-edit"></i> Modificar')
      }, 500);
    });
  }
});

$(function () {

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');

    clearValuesEntry('show');
    idEntryEdit = -1;
    DTDataProdsAdd.column('.actions-product-entry').visible(true);
    $("#btn-save-entry").removeClass('d-none');
    $("#btn-confirm-entry").addClass('d-none');

    $.ajax({
      type: "GET",
      url: rutaBase + "CurrentEntry",
      dataType: 'json',
      success: function ({ codigo }) {
        $("#modalCrearEditarIngresoLabel").html(`<i class="fa-solid fa-plus"></i> Crear ingreso ${codigo}`);
      }
    });
  });

  $("#btnCancelarProdIngresoInventario").on('click', function () {
    $("#descripcion, #stock, #referencia, #item").val('');
    $("#idProducto").val(0);
    dataProdSearchAproximate = [];
    idProductoIngresoMercanciaEditar = '';
    $("[form=formCrearEditar]").html('<i class="fas fa-check"></i> Agregar');

    if (isOpenModalProducto) {
      setTimeout(() => {
        $("#modalProdCuenta").modal('hide');
        isOpenModalProducto = false;
        $("#modalCrearEditarIngreso").modal('show');
      }, 300);
    }
  });

  $(".validaCampo").on("focusout", function () {
    $('.input-search').removeClass('input-group');
    $('.input-search').find('.input-group-append').addClass('d-none');
    $("#item, #descripcion").val("");
    $("#idProducto").val(0);
    let campo = $(this).data("campo");
    let valor = $(this).val();
    if (valor.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaProducto/" + campo + "/" + valor,
        dataType: 'json',
        success: function ({ infoProd, dataProds }) {
          if (infoProd) {
            $("#item").val(infoProd.item);
            $("#referencia").val(infoProd.referencia);
            $("#descripcion").val(infoProd.descripcion);
            $("#idProducto").val(infoProd.id);
            $("#stock").val(infoProd.stock);
          } else {
            dataProdSearchAproximate = dataProds;
            if (dataProdSearchAproximate.length) {
              $('.input-search').addClass('input-group');
              $('.input-search').find('.input-group-append').removeClass('d-none');
            } else {
              alertify.warning(`No se encontraron productos`);
            }
          }
        }
      });
    }
  });

  $("#formCrearEditar").submit(function (e) {
    e.preventDefault();
    if ($(this).valid()) {
      let dataProd = {
        referenciaItem: `${$("#referencia").val()} | ${$("#item").val()}`,
        descripcion: $("#descripcion").val(),
        stock: $("#stock").val(),
        referencia: $("#referencia").val(),
        item: $("#item").val(),
        id: $("#referencia").val().split(' ').join('') + dataProdsAdd.length,
        idProducto: $("#idProducto").val(),
        idIngresoMercanciaProd: ($("#idIngresoMercanciaProd").val() > 0 ? $("#idIngresoMercanciaProd").val() : null),
        cantidad: $("#cantidad").val()
      }

      if (idProductoIngresoMercanciaEditar != '') {
        let indexProduct = dataProdsAdd.findIndex(product => product.id == idProductoIngresoMercanciaEditar);
        dataProdsAdd[indexProduct] = dataProd;
      } else {
        let indexProduct = dataProdsAdd.findIndex(product => product.idProducto == dataProd.idProducto);
        if (indexProduct > -1) {
          dataProdsAdd[indexProduct].cantidad = +dataProdsAdd[indexProduct].cantidad + (+dataProd.cantidad);
        } else {
          dataProdsAdd.push(dataProd);
        }
      }

      DTDataProdsAdd.clear().rows.add(dataProdsAdd).draw();

      if (idProductoIngresoMercanciaEditar == '') {
        DTDataProdsAdd.page('last').draw('page')
      }

      $("#btnCancelarProdIngresoInventario").click();
    }
  });

  $('#modalCrearEditarIngreso').on('hidden.bs.modal', function (event) {
    $("#btnCancelarProdIngresoInventario").click();
  });

  $('#modalCrearEditarIngreso').on('show.bs.modal', function (event) {

    $('.input-search').find('.input-group-append').addClass('d-none');

    setTimeout(() => {
      DTDataProdsAdd.draw();
    }, 300);

    $("#btnSearchReferencia").off('click').on('click', function () {

      let structureHtmlProds = '';

      dataProdSearchAproximate.forEach(prod => {
        structureHtmlProds += `
          <li role="button" class="list-group-item item-list-search pb-0" data-title="${prod.descripcion} ${prod.item} ${prod.referencia}" data-referencia="${prod.referencia}">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">${prod.descripcion}</h5>
              <small>${(prod.item || "")}</small>
            </div>
            <p class="mb-1">${prod.referencia}</p>
          </li>
        `;
      });

      $("#listProdsHtml").html(structureHtmlProds);

      $("#modalProdCuenta").modal('hide');
      $("#modalSearchProd").modal('show');
    });
  });

  $('#modalSearchProd').on('show.bs.modal', function (event) {

    $("#formSearch").submit(function (e) {
      e.preventDefault();

      $("#no-hay-search").remove();
      let valueSearch = $("#buscar").val().toLowerCase();

      $(".item-list-search").removeClass('d-none');

      $.each($(".item-list-search"), function () {
        if (!$(this).data('title').toLowerCase().includes(valueSearch)) {
          $(this).addClass('d-none');
        }
      });

      if (!$('.item-list-search:not(".d-none")').length) {
        $("#listProdsHtml").append(`<li id="no-hay-search" class="list-group-item text-center">No se encontraron resultados</li>`);
      }
    });

    $(".item-list-search").on('click', function () {
      let referenciaProd = $(this).data('referencia');
      $("#referencia").val(referenciaProd).focusout();

      $("#modalSearchProd").modal('hide');
      $("#modalProdCuenta").modal('show');
    });

  });

  $("#btn-save-entry").on('click', function () {
    saveEntry(0);
  });

  $("#btnAgregarProductoIngreso").on('click', function () {
    $("#modalCrearEditarIngreso").modal('hide');
    setTimeout(() => {
      isOpenModalProducto = true;
      $("#modalProdCuenta").modal('show');
    }, 500);
  });

  $('#modalProdCuenta').on('hidden.bs.modal', function (event) {
    if (!$("#modalSearchProd").hasClass('show')) {
      $("#btnCancelarProdIngresoInventario").click();
    }
  });

  $('#modalSearchProd').on('hidden.bs.modal', function (event) {
    $("#modalProdCuenta").modal('show');
    $('.input-search').find('.input-group-append').addClass('d-none');
  });
});

function setValuesEntry(ingreso, productos) {
  idEntryEdit = ingreso.id;
  $('#observacion-ingreso-mercancia').val(ingreso.observacion);
  dataProdsAdd = productos;
  DTDataProdsAdd.clear().rows.add(dataProdsAdd);
  setTimeout(() => {
    DTDataProdsAdd.draw();
  }, 200);
}

function clearValuesEntry(actionModal) {
  dataProdsAdd = [];
  DTDataProdsAdd.clear().draw();
  $('#observacion-ingreso-mercancia').val('');
  $("#modalCrearEditarIngreso").modal(actionModal);
}

function saveEntry(confirmEntry) {
  let formDataEntry = new FormData();
  formDataEntry.set('dataProdsEntry', JSON.stringify(dataProdsAdd));
  formDataEntry.set('observacion', $('#observacion-ingreso-mercancia').val());
  formDataEntry.set('idIngresoMercancia', idEntryEdit);
  formDataEntry.set('canConfirmEntry', confirmEntry);

  $.ajax({
    type: "POST",
    url: rutaBase + (idEntryEdit > 0 || confirmEntry == 1 ? "Editar" : "Crear"),
    processData: false,
    contentType: false,
    cache: false,
    dataType: 'json',
    data: formDataEntry,
    success: function (resp) {
      if (resp.success) {
        clearValuesEntry('hide');
        idEntryEdit = -1;
        let messageAlert = `Nro de ingreso de mercancia: <b>${resp.msj.codigo}</b>`;
        let titleAlert = '';
        if (confirmEntry) {
          titleAlert = `Ingreso confirmado correctamente`;
        } else {
          titleAlert = `Ingreso de mercancia ${idEntryEdit == -1 ? 'creado' : 'modificado'} correctamente`;
        }
        alertify.alert(titleAlert, messageAlert, function () {
          DTIngresoMercancia.ajax.reload();
        });
      } else {
        alertify.error(resp.msj);
      }
    }
  });
}
