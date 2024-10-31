let rutaBase = base_url() + "Ventas/";
let productosVentas = [];
let sucursales = [];
let DTProductos = {
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": 1, "ventas": 1 })
    }
  },
  scrollY: 'calc(100vh - 320px)',
  scroller: {
    loadingIndicator: true
  },
  dom: domBftri50,
  order: {
    name: 'stock',
    dir: 'desc'
  },
  columns: [{
    orderable: false,
    searchable: false,
    visible: $IMAGENPROD,
    defaultContent: '',
    className: "text-center imgProdTb",
    render: function (meta, type, data, meta2) {
      let extension = data.imagen == null ? null : "01-small." + data.imagen.split(".").pop();
      return $IMAGENPROD ? `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
                  <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${extension}" alt="" />
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
    render: function (meta, type, data, meta2) {
      return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
    }
  },
  {
    data: 'cantPaca',
    visible: ($CAMPOSPRODUCTO.paca == '1') ? true : false
  },
  {
    name: 'stock',
    data: 'stock',
    className: 'text-center align-middle',
    render: function (meta, type, data, meta2) {
      return `<button class="btn btn-${data.ColorStock}">${data.stock}</button>`;
    }
  },
  {
    orderable: false,
    searchable: false,
    defaultContent: '',
    className: 'text-center align-middle noExport',
    render: function (meta, type, data, meta2) {
      data.cantidadXPaca = Math.trunc(data.cantidadXPaca);
      let btn = true;
      let resultado = productosVentas.find((it) => it.id == data.id);

      if (resultado) {
        btn = false;
      }

      if (btn && ($INVENTARIONEGATIVO == "0" && Number(data.stock) <= 0)) {
        btn = false;
      }

      if (btn && ($INVENTARIONEGATIVO == "0" && $CAMPOSPRODUCTO.paca == "1" && $CAMPOSPRODUCTO.ventaPaca == "1" && Number(data.cantidadXPaca) < 1)) {
        btn = false;
      }

      return `<div class="btn-group btn-group-sm" role="group">
                  <button id="p${data.id}" type="button" class="btn btn-primary btnAdd ${(btn == true ? '' : 'disabled')}" ${(btn == true ? '' : 'disabled')} title="Agregar"><i class="fa-solid fa-plus"></i></button>
                </div>`;
    }
  }],
  buttons: [
    'pageLength'
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnAdd:not([disabled])").on("click", function () {
      let result = productosVentas.find((it) => it.id == data.id);
      if (result) {
        alertify.error("Este producto ya se encuentra agregado");
      } else {
        if (data.stock < 1) {
          alertify.error("La cantidad de no es sufienciente.");
          return;
        }
        data.cantidad = 1;
        data.cantidadPaca = 0;
        if ($CAMPOSPRODUCTO.paca == "1" && $CAMPOSPRODUCTO.ventaPaca == '1') {
          if (Number(data.cantidadXPaca) >= 1) {
            data.cantidadPaca = 1;
            data.cantidad = Number(data.cantPaca);
          } else {
            alertify.error("La cantidad de no es sufienciente para completar una paca");
            return;
          }
        }

        $("#p" + data.id).addClass("disabled").prop("disabled", true);
        data.valorUnitario = data.precio_venta;
        data.valorTotal = data.precio_venta * data.cantidad;
        productosVentas.unshift(data);
        DTProductosVenta.clear().rows.add(productosVentas).draw();
      }
      calcularTotal();
    });
  }
};

let DTProductosVenta = $("#tblProductos").DataTable({
  data: productosVentas,
  dom: domSearch1,
  processing: false,
  serverSide: false,
  order: [],
  scrollY: 'calc(100vh - 610px)',
  scroller: {
    loadingIndicator: true
  },
  columns: [
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta2) {
        return `<div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-danger btnBorrar" title="Borrar Producto"><i class="fa-solid fa-times"></i></button>
                </div>`;
      }
    },
    {
      data: 'referencia',
      width: "30%",
      render: function (meta, type, data, meta2) {
        return `<span title="${data.referencia}" class="text-descripcion">${data.referencia}</span>`;
      }
    },
    {
      data: 'descripcion',
      width: "30%",
      render: function (meta, type, data, meta2) {
        return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
      }
    },
    {
      orderable: false,
      searchable: false,
      visible: ($CAMPOSPRODUCTO.paca == '1' && $CAMPOSPRODUCTO.ventaPaca == '1') ? true : false,
      data: 'cantidadPaca',
      render: function (meta, type, data, meta2) {
        data.cantidadPaca = Math.trunc(data.cantidadPaca);
        return `<input type="number" class="form-control form-control-sm cantidadPacaProduct inputFocusSelect soloNumeros" min="1" value="${data.cantidadPaca}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'cantidad',
      render: function (meta, type, data, meta2) {
        return `<input type="number" class="form-control form-control-sm cantidadProduct inputFocusSelect soloNumeros" ${($CAMPOSPRODUCTO.paca == "1" && $CAMPOSPRODUCTO.ventaPaca == '1' ? 'readonly' : '')} min="1" value="${data.cantidad}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorUnitario',
      render: function (meta, type, data, meta2) {
        return `<input type="tel" class="form-control form-control-sm inputPesos text-right inputFocusSelect soloNumeros valorUnitario" min="0" value="${data.valorUnitario}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorTotal',
      className: 'text-right valorTotal',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.valorTotal);
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
    data.cantidadXPaca = Math.trunc(data.cantidadXPaca);

    if ($CAMPOSPRODUCTO.paca == "1" && $CAMPOSPRODUCTO.ventaPaca == "1") {
      $(row).find(".cantidadPacaProduct").on("change", function () {
        let cantPaca = Number($(this).val());

        if (cantPaca > data.cantidadXPaca) {
          alertify.alert("Advertencia", `Ha superado la cantidad maxima de pacas, solo hay <b>${data.cantidadXPaca}</b> disponibles pacas`);
          cantPaca = data.cantidadXPaca;
        }
        let cant = cantPaca * Number(data.cantPaca);
        $(this).val(cantPaca);
        $(row).find(".cantidadProduct").val(cant).change();
      });
    }

    $(row).find(".cantidadProduct, .valorUnitario").on("change", function () {
      let cant = Number($(row).find(".cantidadProduct").val().trim());
      let valorUnitario = $(row).find(".valorUnitario").val().trim().replaceAll(",", "").replaceAll("$ ", "");
      let resultado = productosVentas.find((it) => it.id == data.id);

      //Validamos si puede asignar inventario negativo
      if (($INVENTARIONEGATIVO == "1") || ($INVENTARIONEGATIVO == "0" && cant <= Number(data.stock))) {
        resultado.cantidad = cant;
        resultado.valorUnitario = valorUnitario;
        resultado.valorTotal = resultado.cantidad * resultado.valorUnitario;

      } else {
        alertify.alert("Advertencia", `Ha superado la cantidad maxima, solo hay <b>${data.stock}</b> disponibles`);
        resultado.cantidad = +data.stock;
        resultado.valorTotal = +data.stock * resultado.valorUnitario;
        $(this).val(+data.stock);
      }
      $(row).find(".valorTotal").text(formatoPesos.format(resultado.valorTotal));

      data = resultado;

      calcularTotal();
    });

    $(row).find(".btnBorrar").click(function (e) {
      e.preventDefault();
      productosVentas = productosVentas.filter(it => it.id != data.id);
      DTProductosVenta.clear().rows.add(productosVentas).draw();
      $("#p" + data.id).removeClass("disabled").prop("disabled", false);
      calcularTotal();
    });
  },
  drawCallback: function (settings) {
    inputPesos();
  }
});

$(function () {
  if ($CANTIDADVENDEDORES == 0 || $CANTIDADCLIENTES == 0 || $PREFIJOVALIDO == 'N') {
    if ($CANTIDADVENDEDORES == 0 && $CANTIDADCLIENTES == 0) {
      $msj = "vendedores y clientes";
    } else if ($PREFIJOVALIDO == 'N') {
      $msj = "prefijo de pedido disponible";
    } else {
      $msj = $CANTIDADVENDEDORES == 0 ? "vendedores" : "clientes";
    }

    alertify.alert('¡Advertencia!', `No hay ${$msj} disponibles.`);
  } else {
    DTProductos = $("#table").DataTable(DTProductos);
  }

  /* Modificamos la fecha a vencer factura con la cantidad de dias general si se crea venta */
  $("#fechaVencimiento").val(moment().add($DIASVENCIMIENTOFACTURAGENERAL, 'days').format('YYYY-MM-DD'));

  document.title = "Factura " + $("#nroVenta").val() + " | " + $NOMBREEMPRESA;

  $("#formVenta").submit(function (e) {
    e.preventDefault();
    if ($(this).valid()) {
      if (productosVentas.length > 0) {
        form = new FormData(this);

        let idCliente = null;
        if (sucursales.length) {
          idCliente = sucursales.find(x => x.id == $("#sucursal").val()).idCliente;
        } else {
          idCliente = $DATOSVENTA.id_cliente;
        }

        form.append("idCliente", idCliente);
        form.append("idUsuario", $("#vendedor").val());
        form.append("observacion", $("#observacion").val());
        form.append("codigoVenta", $("#nroVenta").val());
        form.append("fechaVencimiento", $("#fechaVencimiento").val());
        form.append("descuento", $("#descuentoAplicado").val().replace('$ ', '').split(',').join(''));
        form.append("productos", JSON.stringify(productosVentas));

        $('.deshabilitarboton').prop('disabled', true);

        $.ajax({
          url: rutaBase + ($DATOSVENTA == '' ? "Crear" : 'Editar'),
          type: 'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: form,
          success: function (resp) {
            if (resp.success) {
              if ($DATOSVENTA == '') {
                alertify.confirm("Venta creada correctamente", `Nro de venta: <b>${resp.msj.codigo}</b>, por valor de <b>${formatoPesos.format(resp.msj.total)}</b><br><br>Desea crear una nueva venta?`,
                  function () {
                    productosVentas = [];
                    $("#nroVenta").val(resp.msj.codigo + 1);
                    $("#sucursal, #vendedor").data("id", "").closest(".input-group").find(".input-group-text").text("");
                    $("#observacion").val("");
                    $("#total, #totalSinDescuento, #descuentoAplicado").val(0)
                    $("#aplicarDescuento").prop('checked', false).change();
                    DTProductos.ajax.reload();
                    DTProductosVenta.clear().rows.add(productosVentas).draw();
                    resetForm("#formVenta");
                  },
                  function () {
                    window.location.href = base_url() + 'Ventas/Administrar';
                  }).set('labels', { ok: `<i class="fas fa-check"></i> Si`, cancel: `<i class="fas fa-times"></i> No` });
              } else {
                alertify.alert('¡Advertencia!', "Venta editada correctamente", function () { window.location.href = base_url() + 'Ventas/Administrar'; });
              }
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          },
          complete: () => {
            $('.deshabilitarboton').prop('disabled', false);
          }
        });
      } else {
        alertify.alert("Advertencia", "Debe de elegir minimo un producto para guardar la venta.");
      }
    }
  });

  //Cargamos los vendedores
  $("#vendedor").select2({
    ajax: {
      url: base_url() + "Busqueda/Vendedores",
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

  $("#sucursal").select2({
    ajax: {
      url: base_url() + "Busqueda/SucursalesClientes",
      type: "POST",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var query = {
          cliente: $("#cliente").val(),
          search: params.term,
          page: params.page || 1,
          _type: "query_append",
        }
        return query;
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        sucursales = data.data;
        return {
          results: data.data,
          pagination: {
            more: (params.page * 10) < data.total_count
          }
        };
      },
      async: false,
      cache: true
    }
  });

  $("#sucursal").on('change', function () {
    let idCurrenteSucursal = $(this).val();
    /* Modificamos la fecha a vencer factura con la cantidad de dias de la sucursal */
    let currentSucursal = sucursales.find(sucursal => sucursal.id == idCurrenteSucursal);
    if (currentSucursal && currentSucursal.diasVencimientoVenta > 0) {
      $("#fechaVencimiento").val(moment().add(+currentSucursal.diasVencimientoVenta, 'days').format('YYYY-MM-DD'));
    } else {
      $("#fechaVencimiento").val(moment().add($DIASVENCIMIENTOFACTURAGENERAL, 'days').format('YYYY-MM-DD'));
    }
  })

  $("#verImg").change(function () {
    if ($(this).is(':checked')) {
      $IMAGENPROD = 1;
    } else {
      $IMAGENPROD = 0;
    }
    DTProductos.column('.imgProdTb').column().visible($IMAGENPROD)
    DTProductos.ajax.reload();
  });

  if ($DATOSVENTA == '') {
    $(".nav-item:not(.no-blocked-menu), .brand-link").addClass('pe-none');

    $("#btnCancelarCreacion").on('click', function () {
      alertify.confirm("Cancelar venta", `Esta seguro de cancelar la Factura ${$("#nroVenta").val()}?`, function () {
        window.location.href = base_url() + 'Ventas/Administrar';
      }, function () { });
    });
  }

  $("#aplicarDescuento").on('change', function () {
    if ($(this).is(':checked')) {
      $("#percentageDiscount").text(`${$PORCENTAJEDESCUENTOFACTURAGENERAL}%`);
      calculateDiscount('checkDiscount');
      $("#removeDiscount").off('click').on('click', function () {
        $("#aplicarDescuento").prop('checked', false).change();
      });

      $("#descuentoAplicado").off('change').on('change', function () {
        let valueDiscount = +$(this).val().replace('$ ', '').split(',').join('');
        let valueBill = getTotalProducts();
        if (valueDiscount > valueBill) {
          alertify.warning("El valor de descuento es superior al total de la factura");
          return
        }
        calculateDiscount('changeInputDiscount');
      });
    } else {
      $("#input-applied-discount").addClass('d-none');
      $("#input-check-discount").removeClass('d-none');
      $("#descuentoAplicado").val('0');
      calcularTotal();
    }
  });

  /* Actiamos el descuento por defecto al crear */
  if ($DATOSVENTA == '') {
    $("#aplicarDescuento").prop('checked', true).change();
  } else {
    if ($DATOSVENTA.descuento > 0) {
      $("#aplicarDescuento").prop('checked', true);
      $("#descuentoAplicado").val($DATOSVENTA.descuento);
      $("#input-applied-discount").removeClass('d-none');
      $("#input-check-discount").addClass('d-none');
      setTimeout(() => {
        calculateDiscount('changeInputDiscount');
      }, 100);
    }
  }

});

/* Calculamos el descuento de la factura */
function calculateDiscount(fromAction) {
  let percentageDiscount = $PORCENTAJEDESCUENTOFACTURAGENERAL;
  let percetnageText = +$("#percentageDiscount").text().replace('%', '');
  /* Se valida si es diferente para mantener el valor digitado en campo de descuento y nose altere */
  if (percetnageText > 0 && $PORCENTAJEDESCUENTOFACTURAGENERAL != percetnageText) {
    percentageDiscount = +$("#percentageDiscount").text().replace('%', '');
    fromAction = 'changeInputDiscount';
  }

  let valueBill = getTotalProducts();
  let totalDiscount = 0;
  if ($("#aplicarDescuento").is(':checked')) {
    $("#input-applied-discount").removeClass('d-none');
    $("#input-check-discount").addClass('d-none');

    if (percentageDiscount > 0) {
      /* Validamos si viene desde digitar manual el descuento de factura */
      if (fromAction == 'changeInputDiscount') {
        totalDiscount = +$("#descuentoAplicado").val().replace('$ ', '').split(',').join('');
        let percentageTotalDiscount = ((totalDiscount * 100) / valueBill).toFixed(0);
        $("#percentageDiscount").text(`${percentageTotalDiscount}%`);
      } else {
        // fromAction == ('checkDiscount' || 'calculateTotal')
        totalDiscount = (percentageDiscount * valueBill) / 100;
      }
    }
  }
  $("#descuentoAplicado").val(totalDiscount);
  $("#totalSinDescuento").val(valueBill);
  /* Agregamos de nuevo el total */
  $("#total").val(valueBill - totalDiscount);
}

function calcularTotal() {
  let sumTotal = getTotalProducts();

  $("#total").val(sumTotal);

  calculateDiscount('calculateTotal');
}

function getTotalProducts() {
  return productosVentas.reduce((suma, item) => suma + Number(item.valorTotal), 0)
}

function formatRepo(repo) {
  if (repo.loading) {
    return repo.text;
  }
  return repo.full_name || repo.text;
}

function formatRepoSelection(repo) {
  return repo.full_name || repo.text;
}