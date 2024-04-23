let rutaBase = `${base_url()}Compras/`;
let dataProdsAdd = [];
let dataProdSearchAproximate = [];
let idBuyEdit = -1;
let idProductoCompraEditar = '';
let isOpenModalProducto = false;
let DTCompras = $("#table").DataTable({
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
      data: 'Total_Productos',
      className: 'text-center'
    }, {
      data: 'observacion',
      render: function (meta, type, data, meta) {
        return `<span title="${data.observacion}" class="text-descripcion">${data.observacion}</span>`;
      }
    }, {
      data: 'Proveedor'
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

        let botones = ``;

        botones += validPermissions(406) ? `<a href="${base_url()}Reportes/Compra/${data.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Compra">
          <i class="fa-solid fa-print"></i>
        </a>` : '';

        botones += validPermissions(407) && ['CO'].includes(data.Estado) ? `<a href="${base_url()}Reportes/StickerCompra/${data.id}/0" target="_blank" type="button" class="btn btn-primary" title="Imprimir Sticker">
          <i class="fa-solid fa-note-sticky"></i>
        </a>` : '';

        botones += validPermissions(402) && !['AN', 'CO'].includes(data.Estado) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        botones += validPermissions(403) && !['AN', 'CO'].includes(data.Estado) ? '<button type="button" class="btn btn-success btnConfirmar" title="Confirmar Compra"><i class="fa-solid fa-check"></i></button>' : '';

        botones += validPermissions(404) && !['AN'].includes(data.Estado) ? '<button type="button" class="btn btn-danger btnEliminar" title="Anular Compra"><i class="fa-solid fa-ban"></i></button>' : '';

        botones += validPermissions(405) ? '<button type="button" class="btn btn-warning btnClonar" title="Clonar Compra"><i class="fa-solid fa-copy"></i></button>' : '';

        return `<div class="btn-group btn-group-sm" role="group">${botones}</div>`;
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

          let showColumnActions = false;
          if ($btnClick.hasClass("btnVer")) {
            $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-eye"></i> Ver compra ${compra.codigo}`);
            $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
            $("#btn-save-buy, #accordionProdAddBuy").addClass("d-none");
          } else {
            $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-edit"></i> Editar compra ${compra.codigo}`);
            $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
            $("#btn-save-buy, #accordionProdAddBuy").removeClass("d-none");
            showColumnActions = true;
          }
          $("#precioVent, #costo").attr('required', false);

          DTDataProdsAdd.column('.actions-product-buy').visible(showColumnActions);

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

          $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');

          $("#btn-save-buy").addClass('d-none');
          $("#btn-confirm-buy, #accordionProdAddBuy").removeClass('d-none');
          DTDataProdsAdd.column('.actions-product-buy').visible(true);

          $("#modalCrearEditarCompra").modal('show');

          $("#btn-confirm-buy").off('click').on('click', function () {

            let prodsWithoutPrice = verifyProductWithoutPrice();
            if (prodsWithoutPrice != '') {
              alertify.alert("Advertencia", `No se puede confirmar la compra, los siguientes productos no poseen costo o precio de venta: <ul class='pl-4 mt-3'>${prodsWithoutPrice}</ul>`, function () { });
              return
            }

            let prodValueNegative = dataProdsAdd.filter(
              product => validateColorRow(product) == 'bg-rojo'
            ).map(
              (productFilter) => `<li class='mt-2'>
                <b>${productFilter.referenciaItem}:</b>
                <div class='row'>
                  <div class='col-6'>
                    <b>Precio actual:</b> ${formatoPesos.format(productFilter.valorOriginal)}
                  </div>
                  <div class='col-6'>
                    <b>Precio nuevo:</b> ${formatoPesos.format(productFilter.precioVenta)}
                  </div>
                </div>
              </li>`
            ).join('');

            if (prodValueNegative != '') {

              alertify.confirm("Advertencia", `Los siguientes productos tendran un valor de venta <b>menor</b> al actual: <ul class='pl-4 mt-3'>${prodValueNegative}</ul>`, function () {
                saveConfirmBuy();
              }, function () { });

            } else {
              saveConfirmBuy();
            }
          });

          $("#precioVent, #costo").attr('required', true);
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
  },{
    data: 'item'
  }, {
    data: 'descripcion',
    width: "30%",
    render: function (meta, type, data, meta) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  }, {
    data: 'categoriaNombre'
  }, {
    data: 'ubicacion'
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
    data: 'ganancia',
    className: 'ganancia'
  }, {
    data: 'Acciones',
    orderable: false,
    searchable: false,
    visible: validPermissions(402),
    defaultContent: '',
    className: 'text-center actions-product-buy noExport',
    render: function (meta, type, data, meta) {
      let buttons = `
        <button type="button" class="btn btn-danger btnDelete" title="Eliminar">
          <i class="fa-solid fa-trash"></i>
        </button>
        ${$("#btn-confirm-buy").hasClass('d-none') ? `<button type="button" class="btn btn-secondary btnEditarProductoCompra" title="Editar producto">
          <i class="fa-solid fa-edit"></i>
        </button>` : ''}
      `;

      if (+data.precioVenta != +data.valorOriginal) {
        buttons += `<button type="button" class="btn btn-info btnValorOriginal" title="Valor original">
          <i class="fa-solid fa-refresh"></i>
        </button>`;
      }

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
      calculateDataProds();
    });

    $(row).find(".btnValorOriginal").click(function (e) {
      e.preventDefault();

      let currentPage = DTDataProdsAdd.page();

      let indexProd = dataProdsAdd.findIndex(product => product.id == data.id)
      dataProdsAdd[indexProd].precioVenta = dataProdsAdd[indexProd].valorOriginal;

      DTDataProdsAdd.clear().rows.add(dataProdsAdd).page(currentPage).draw();
      calculateDataProds();
    });

    $(row).find('.btnEditarProductoCompra').click(function (e) {
      e.preventDefault();

      $("#modalCrearEditarCompra").modal('hide');
      setTimeout(() => {
        isOpenModalProducto = true;
        $("#modalProdCuenta").modal('show');

        $("#referencia").val(data.referencia);
        $("#item").val(data.item);
        $("#descripcion").val(data.descripcion);
        $("#cateFiltro").val(data.idCategoria).change();
        $("#ubicacion").val(data.ubicacion);
        $("#manifiesto").val(data.idCategoria).change();
        $("#paca").val(data.pacaX);
        $("#stock").val(data.stock);
        $("#precioVent").val(data.precioVenta);
        $("#costo").val(data.costo);

        $("#idProducto").val(data.idProducto ? data.idProducto : 0);
        $("#precioVent").data('valororiginal', data.valorOriginal);
        $("#idCompraProd").val(data.idCompraProd);
        idProductoCompraEditar = data.id;

        $("[form=formCrearEditar]").html('<i class="fas fa-edit"></i> Modificar')
      }, 500);
    });

    let porcentajeGanancia = calculateBenefit(+data.precioVenta, +data.costo);
    $(row).find('.ganancia').html(porcentajeGanancia + ' %');

    let clase = validateColorRow(data);
    $(row).addClass(clase);
  }
});

$(function () {

  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');

    clearValuesBuy('show');
    idBuyEdit = -1;
    DTDataProdsAdd.column('.actions-product-buy').visible(true);
    $("#btn-save-buy, #accordionProdAddBuy").removeClass('d-none');
    $("#btn-confirm-buy").addClass('d-none');
    $("#precioVent, #costo").attr('required', false);

    $.ajax({
      type: "GET",
      url: rutaBase + "CurrentBuy/",
      dataType: 'json',
      success: function ({ codigo }) {
        $("#modalCrearEditarCompraLabel").html(`<i class="fa-solid fa-plus"></i> Crear compra ${codigo}`);
      }
    });
  });

  $("#btnCancelarProdCompra").on('click', function () {
    $("#descripcion, #paca, #stock, #precioVent, #costo, #referencia, #item, #ubicacion").val('');
    $("#cateFiltro, #manifiesto").val('').change();
    $("#idProducto").val(0);
    $("#precioVent").data('valororiginal', 0);
    dataProdSearchAproximate = [];
    idProductoCompraEditar = '';
    $("[form=formCrearEditar]").html('<i class="fas fa-check"></i> Agregar');

    if (isOpenModalProducto) {
      setTimeout(() => {
        $("#modalProdCuenta").modal('hide');
        isOpenModalProducto = false;
        $("#modalCrearEditarCompra").modal('show');
      }, 300);
    }
  });

  $(".validaCampo").on("focusout", function () {
    $('.input-search').removeClass('input-group');
    $('.input-search').find('.input-group-append').addClass('d-none');
    $("#item, #descripcion, #paca, #ubicacion").val("");
    $("#cateFiltro, #manifiesto").val('').change();
    $("#idProducto").val(0);
    $("#precioVent").data('valororiginal', 0);
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
            $("#paca").val(infoProd.cantPaca);
            $("#idProducto").val(infoProd.id);
            $("#precioVent").data('valororiginal', infoProd.precio_venta);

            $("#cateFiltro").val(infoProd.id_categoria).change();
            $("#manifiesto").val(infoProd.id_manifiesto).change();
            // $("#ubicacion").val(infoProd.ubicacion);
          } else {
            dataProdSearchAproximate = dataProds;
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

    let precioVentaProducto = $("#precioVent").val().replace("$", '');
    let costoProducto = $("#costo").val().replace("$", '');

    if ($(this).valid()) {
      let dataProd = {
        referenciaItem: `${$("#referencia").val()} | ${$("#item").val()}`,
        descripcion: $("#descripcion").val(),
        pacaX: $("#paca").val(),
        stock: $("#stock").val(),
        precioVenta: (precioVentaProducto.split(",").join('') || 0),
        costo: (costoProducto.split(",").join('') || 0),
        referencia: $("#referencia").val(),
        item: $("#item").val(),
        id: $("#referencia").val().split(' ').join('') + dataProdsAdd.length,
        costoCompra: (costoProducto || 0),
        idProducto: $("#idProducto").val(),
        idCompraProd: ($("#idCompraProd").val() > 0 ? $("#idCompraProd").val() : null),
        valorOriginal: +$("#idProducto").val() > 0 ? $("#precioVent").data('valororiginal') : (precioVentaProducto.split(' ').join('') || 0),
        creadoCompra: +$("#idProducto").val() > 0 ? 0 : 1,
        idManifiesto: ($("#manifiesto").val() || null),
        idCategoria: ($("#cateFiltro").val() || null),
        categoriaNombre: ($("#cateFiltro option:selected").text() || null),
        ubicacion: $("#ubicacion").val(),
        ganancia: 0
      }

      if (idProductoCompraEditar != '') {

        let indexProduct = dataProdsAdd.findIndex(product => product.id == idProductoCompraEditar);
        dataProdsAdd[indexProduct] = dataProd;

      } else {
        dataProdsAdd.push(dataProd);
      }

      DTDataProdsAdd.clear().rows.add(dataProdsAdd).draw();

      calculateDataProds();

      if (+dataProd.idProducto > 0 && +dataProd.valorOriginal > +dataProd.precioVenta) {
        alertify.error(`El precio ingresado del producto ${dataProd.descripcion} es <b>menor</b> al precio de venta actual`);
      }

      if (idProductoCompraEditar == '') {
        DTDataProdsAdd.page('last').draw('page')
      }

      $("#btnCancelarProdCompra").click();
    }
  });

  $('#modalCrearEditarCompra').on('hidden.bs.modal', function (event) {
    $("#btnCancelarProdCompra").click();
  });

  $('#modalCrearEditarCompra').on('show.bs.modal', function (event) {

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
              <small>${prod.item}</small>
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

  $("#btn-save-buy").on('click', function () {

    let formDataBuy = new FormData();
    formDataBuy.set('dataProdsBuy', JSON.stringify(dataProdsAdd));
    formDataBuy.set('observacion', $('#observacion-compra').val());
    if ($("#proveedor").val() != '') {
      formDataBuy.set('id_proveedor', $("#proveedor").val());
    }
    formDataBuy.set('idCompra', idBuyEdit);
    formDataBuy.set('canConfirmBuy', 0);

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

  $("#btnAgregarProductoCompra").on('click', function () {
    $("#modalCrearEditarCompra").modal('hide');
    setTimeout(() => {
      isOpenModalProducto = true;
      $("#modalProdCuenta").modal('show');
    }, 500);
  });

  $('#modalProdCuenta').on('hidden.bs.modal', function (event) {
    if (!$("#modalSearchProd").hasClass('show')) {
      $("#btnCancelarProdCompra").click();
    }
  });

  $("#proveedor").select2({
    ajax: {
      url: base_url() + "Busqueda/Proveedores",
      type: "POST",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var query = {
          search: params.term,
          page: params.page || 1,
          _type: "query_append",
        }
        return query;
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data.data,
          pagination: {
            more: (params.page * 10) < data.total_count
          }
        };
      },
      async: false,
      cache: true
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $('#modalSearchProd').on('hidden.bs.modal', function (event) {
    $("#modalProdCuenta").modal('show');
    $('.input-search').find('.input-group-append').addClass('d-none');
  });
});

function calculateDataProds() {
  let totalCompra = 0, totalCosto = 0;

  dataProdsAdd.forEach(product => {
    totalCompra += (+product.stock * (+product.precioVenta));
    totalCosto += (+product.stock * (+product.costo));
  });
  $(".valor-compra").text(formatoPesos.format(totalCompra));
  $(".valor-costo").text(formatoPesos.format(totalCosto));
}

function setValuesBuy(compra, productos) {
  idBuyEdit = compra.id;
  $('#observacion-compra').val(compra.observacion);

  var vendedorOption = new Option(compra.textSelectCompra, (compra.id_proveedor || ''), true, true);
  $('#proveedor').append(vendedorOption).trigger('change');

  dataProdsAdd = productos;
  DTDataProdsAdd.clear().rows.add(dataProdsAdd);
  calculateDataProds();
  setTimeout(() => {
    DTDataProdsAdd.draw();
  }, 200);
}

function clearValuesBuy(actionModal) {
  dataProdsAdd = [];
  DTDataProdsAdd.clear().draw();
  $('#observacion-compra').val('');
  $("#proveedor").val('').trigger('change');
  $(".valor-compra, .valor-costo").text('');
  $("#modalCrearEditarCompra").modal(actionModal);
}

function saveConfirmBuy() {
  let formDataBuy = new FormData();
  formDataBuy.set('dataProdsBuy', JSON.stringify(dataProdsAdd));
  formDataBuy.set('observacion', $('#observacion-compra').val());
  if ($("#proveedor").val() != '') {
    formDataBuy.set('id_proveedor', $("#proveedor").val());
  }
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
}

function validateColorRow(data) {
  if (data.creadoCompra == 0) {
    if (+data.valorOriginal > +data.precioVenta) {
      return 'bg-rojo'
    }
    return 'bg-azul';
  }
  return 'bg-verde';
}

function verifyProductWithoutPrice() {
  let prodsWithoutPrice = dataProdsAdd.filter(
    product => (MANEJACOSTO && (!product.costo || product.costo == 0)) || (!product.precioVenta || product.precioVenta == 0)
  ).map(
    (productFilter) => `<li class='mt-2'>
      <b>${productFilter.referenciaItem}:</b>
    </li>`
  ).join('');
  return prodsWithoutPrice;
}

function calculateBenefit(precioVenta, costo) {
  if (precioVenta > 0 || costo > 0) {

    let porcentajeGanancia = (precioVenta - costo);

    if (porcentajeGanancia > 0) {
      porcentajeGanancia = (porcentajeGanancia / precioVenta) * 100;
    } else {
      porcentajeGanancia = - ((costo - precioVenta) / costo) * 100;
    }

    return (porcentajeGanancia % 1 != 0 ? porcentajeGanancia.toFixed(2) : porcentajeGanancia);
  }
  return 0;
}