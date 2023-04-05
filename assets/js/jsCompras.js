let rutaBase = `${base_url()}Compras/`;
let dataProdsAdd = [];
let dataProdSearchAproximate = [];
let idBuyEdit = -1;
let DTCompras = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, {})
    }
  },
  scrollX: true,
  order: [[2, "asc"]],
  search: {
    return: false,
  },
  columns: [
    {
      data: 'Codigo'
    }, {
      data: 'Nombre_Usuario'
    }, {
      data: 'Descripcion_Estado',
      render: function (meta, type, data, meta) {
        let color = "warning";
        if (data.Estado == 'AN') {
          color = "danger";
        } else if (data.Estado == 'CO') {
          color = "success";
        }
        return `<button class="btn btn-${color}">${data.Descripcion_Estado}</button>`;
      }
    }, {
      data: 'Total_Productos'
    }, {
      data: 'observacion',
      width: "25%",
      render: function (meta, type, data, meta) {
        return `<span title="${data.observacion}" class="text-descripcion">${data.observacion}</span>`;
      }
    }, {
      data: 'Neto',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.Neto);
      }
    }, {
      data: 'Total',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.Total);
      }
    }, {
      data: 'Fecha_Creacion',
      render: function (meta, type, data, meta) {
        return moment(data.Fecha_Creacion, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    }, {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {

        btnImprimirCompra = validPermissions(406) ? `<a href="${base_url()}Reportes/Compra/${data.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Compra">
          <i class="fa-solid fa-print"></i>
        </a>` : '';

        btnEditar = validPermissions(402) && !['AN', 'CO'].includes(data.Estado) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnConfirmarCompra = validPermissions(403) && !['AN', 'CO'].includes(data.Estado) ? '<button type="button" class="btn btn-success btnConfirmar" title="Confirmar Compra"><i class="fa-solid fa-check"></i></button>' : '';

        btnAnularCompra = validPermissions(404) && !['AN'].includes(data.Estado) ? '<button type="button" class="btn btn-danger btnEliminar" title="Anular Compra"><i class="fa-solid fa-ban"></i></button>' : '';

        btnClonarCompra = validPermissions(405) ? '<button type="button" class="btn btn-warning btnClonar" title="Clonar Compra"><i class="fa-solid fa-copy"></i></button>' : '';

        return `<div class="btn-group btn-group-sm" role="group">
                    ${btnImprimirCompra}
                    ${btnEditar}
                    ${btnConfirmarCompra}
                    ${btnAnularCompra}
                    ${btnClonarCompra}
                  </div>`;
      }
    }
  ],
  createdRow: function (row, data, dataIndex) {
    //Editar
    $(row).find(".btnEditar, .btnVer").click(function (e) {
      e.preventDefault();

      $btnClick = $(this);

      $.ajax({
        type: "GET",
        url: rutaBase + "ObtenerCompra/" + data.id,
        dataType: 'json',
        success: function ({ compra, productos }) {
          setValuesBuy(compra, productos);

          $("#btn-confirm-buy").addClass('d-none');

          if ($btnClick.hasClass("btnVer")) {
            $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-eye"></i> Ver compra ${compra.codigo}`);
            $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
            $("#btn-save-buy, #formCrearEditar").addClass("d-none");
          } else {
            $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-edit"></i> Editar compra ${compra.codigo}`);
            $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
            $("#btn-save-buy, #formCrearEditar").removeClass("d-none");
          }

          $("#modalCrearEditarCompra").modal('show');
        }
      });
    });

    $(row).find(".btnEliminar").click(function (e) {
      e.preventDefault();

      alertify.confirm('Anular compra', `Esta seguro de anular la compra <b>${data.Codigo}</b>?`, function () {
        $.ajax({
          type: "POST",
          url: rutaBase + "Anular",
          dataType: 'json',
          data: {
            idCompra: data.id
          },
          success: function (resp) {
            console.log('respp -> ', resp);
            if (resp.success) {
              alertify.success(resp.msj);
              DTCompras.ajax.reload();
            } else {
              alertify.error(resp.msj);
            }
          }
        });
      }, function () { });
    });

    $(row).find(".btnClonar").click(function (e) {
      e.preventDefault();

      alertify.confirm('Clonar compra', `Esta seguro de clonar la compra <b>${data.Codigo}</b>?`, function () {
        $.ajax({
          type: "POST",
          url: rutaBase + "Clonar",
          dataType: 'json',
          data: {
            idBuy: data.id
          },
          success: function (resp) {
            if (resp.success) {
              alertify.alert(
                `Compra clonada correctamente`
                , `Nro de compra: <b>${resp.msj.codigo}</b>, por valor de <b>${formatoPesos.format(resp.msj.total)}</b>`
                , function () {
                  DTCompras.ajax.reload();
                }
              );
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
        url: rutaBase + "ObtenerCompra/" + data.id,
        dataType: 'json',
        success: function ({ compra, productos }) {

          setValuesBuy(compra, productos);

          $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-check"></i> Confirmar compra ${compra.codigo}`);

          $("#btn-save-buy").addClass('d-none');
          $("#btn-confirm-buy").removeClass('d-none');

          $("#modalCrearEditarCompra").modal('show');

          $("#btn-confirm-buy").off('click').on('click', function () {

            let formDataBuy = new FormData();
            formDataBuy.set('dataProdsBuy', JSON.stringify(dataProdsAdd));
            formDataBuy.set('observacion', $('#observacion-compra').val());
            formDataBuy.set('idCompra', idBuyEdit);
            formDataBuy.set('canConfirmBuy', 1);

            $.ajax({
              type: "POST",
              url: rutaBase + "Editar",
              processData: false,
              contentType: false,
              cache: false,
              dataType: 'json',
              data: formDataBuy,
              success: function (resp) {
                if (resp.success) {
                  clearValuesBuy('hide');
                  idBuyEdit = -1;

                  alertify.alert(
                    `Compra confirmada correctamente`
                    , `Nro de compra: <b>${resp.msj.codigo}</b>, por valor de <b>${formatoPesos.format(resp.msj.total)}</b>`
                    , function () {
                      DTCompras.ajax.reload();
                    }
                  );

                } else {
                  alertify.error(resp.msj);
                }
              }
            });
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
  pageLength: 3,
  processing: false,
  serverSide: false,
  search: {
    return: false,
  },
  columns: [{
    data: 'referenciaItem'
  }, {
    data: 'descripcion',
    width: "30%",
    render: function (meta, type, data, meta) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  }, {
    data: 'pacaX'
  }, {
    data: 'stock'
  }, {
    data: 'precioVenta',
    render: function (meta, type, data, meta) {
      return formatoPesos.format(data.precioVenta);
    }
  }, {
    data: 'costo',
    render: function (meta, type, data, meta) {
      return formatoPesos.format(data.costo);
    }
  }, {
    data: 'Acciones',
    orderable: false,
    searchable: false,
    visible: validPermissions(402),
    defaultContent: '',
    className: 'text-center noExport',
    render: function (meta, type, data, meta) {
      let btnDelete = `<button type="button" class="btn btn-danger btnDelete" title="Eliminar">
        <i class="fa-solid fa-trash"></i>
      </button>`;

      return `<div class="btn-group btn-group-sm" role="group">${btnDelete}</div>`;
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
      calculateDataProds();
    });
  }
});

$(function () {

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');

    clearValuesBuy('show');
    idBuyEdit = -1;
    $("#btn-save-buy").removeClass('d-none');
    $("#btn-confirm-buy").addClass('d-none');

    $.ajax({
      type: "GET",
      url: rutaBase + "CurrentBuy/",
      dataType: 'json',
      success: function ({ codigo }) {
        $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-plus"></i> Crear compra ${codigo}`);
      }
    });
  });

  $(".validaCampo").on("focusout", function () {
    $('.input-search').removeClass('input-group');
    $('.input-search').find('.input-group-append').addClass('d-none');
    $("#item, #descripcion, #paca").val("");
    $("#idProducto").val(0);
    let campo = $(this).data("campo");
    let valor = $(this).val();
    if (valor.length > 0) {
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaProducto/" + campo + "/" + valor,
        dataType: 'json',
        success: function (resp) {
          if (resp.infoProd) {
            $("#item").val(resp.infoProd.item);
            $("#referencia").val(resp.infoProd.referencia);
            $("#descripcion").val(resp.infoProd.descripcion);
            $("#paca").val(resp.infoProd.cantPaca);
            $("#idProducto").val(resp.infoProd.id);
          } else {
            dataProdSearchAproximate = resp.dataProds;
            if (dataProdSearchAproximate.length) {
              $('.input-search').addClass('input-group');
              $('.input-search').find('.input-group-append').removeClass('d-none');
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
        pacaX: $("#paca").val(),
        stock: $("#stock").val(),
        precioVenta: $("#precioVent").val().replace("$", '').split(",").join(''),
        costo: $("#costo").val().replace("$", '').split(",").join(''),
        referencia: $("#referencia").val(),
        item: $("#item").val(),
        id: $("#referencia").val().split(' ').join('') + dataProdsAdd.length,
        valorCompra: $("#precioVent").val().replace("$", ''),
        costoCompra: $("#costo").val().replace("$", ''),
        idProducto: $("#idProducto").val(),
        idCompraProd: null
      }
      dataProdsAdd.push(dataProd);
      DTDataProdsAdd.clear().rows.add(dataProdsAdd).draw();

      $("#descripcion, #paca, #stock, #precioVent, #costo, #referencia, #item").val('');
      $("#idProducto").val(0);
      dataProdSearchAproximate = [];

      calculateDataProds();
    }
  });

  $('#modalCrearEditarCompra').on('show.bs.modal', function (event) {

    $('.input-search').find('.input-group-append').addClass('d-none');

    setTimeout(() => {
      DTDataProdsAdd.draw();
    }, 300);

    $("#btnSearchReferecnia").off('click').on('click', function () {

      let structureHtmlProds = '';

      dataProdSearchAproximate.forEach(prod => {
        structureHtmlProds += `
          <li role="button" class="list-group-item item-list-search pb-0" data-title="${prod.descripcion} ${prod.item} ${prod.referencia}" data-referencia="${prod.referencia}">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">${prod.descripcion}</h5>
              <small>${prod.item}</small>
            </div>
            <p class="mb-1">${prod.referencia}</p>
          </li>
        `;
      });

      $("#listProdsHtml").html(structureHtmlProds);

      $("#modalCrearEditarCompra").modal('hide');
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
      $("#modalCrearEditarCompra").modal('show');
    });

  });

  $("#btn-save-buy").on('click', function () {

    let formDataBuy = new FormData();
    formDataBuy.set('dataProdsBuy', JSON.stringify(dataProdsAdd));
    formDataBuy.set('observacion', $('#observacion-compra').val());
    formDataBuy.set('idCompra', idBuyEdit);

    $.ajax({
      type: "POST",
      url: rutaBase + (idBuyEdit > 0 ? "Editar" : "Crear"),
      processData: false,
      contentType: false,
      cache: false,
      dataType: 'json',
      data: formDataBuy,
      success: function (resp) {
        if (resp.success) {
          clearValuesBuy('hide');

          alertify.alert(
            `Compra ${idBuyEdit == -1 ? 'creada' : 'modificada'} correctamente`
            , `Nro de compra: <b>${resp.msj.codigo}</b>, por valor de <b>${formatoPesos.format(resp.msj.total)}</b>`
            , function () {
              idBuyEdit = -1;
              DTCompras.ajax.reload();
            }
          );

        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

});

function calculateDataProds() {
  let totalCompra = 0, totalCosto = 0;

  dataProdsAdd.forEach(product => {
    totalCompra += (+product.stock * (+product.valorCompra.split(',').join('')));
    totalCosto += (+product.stock * (+product.costoCompra.split(',').join('')));
  });
  $(".valor-compra").text(formatoPesos.format(totalCompra));
  $(".valor-costo").text(formatoPesos.format(totalCosto));
}

function setValuesBuy(compra, productos) {
  idBuyEdit = compra.id;
  $('#observacion-compra').val(compra.observacion);
  dataProdsAdd = productos;
  DTDataProdsAdd.clear().rows.add(dataProdsAdd).draw();
  calculateDataProds();
}

function clearValuesBuy(actionModal) {
  dataProdsAdd = [];
  DTDataProdsAdd.clear().draw();
  $('#observacion-compra').val('');
  $(".valor-compra, .valor-costo").text('');
  $("#modalCrearEditarCompra").modal(actionModal);
}