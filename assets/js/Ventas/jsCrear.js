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
  order: [[2, "asc"]],
  columns: [{
    orderable: false,
    searchable: false,
    visible: $IMAGENPROD,
    defaultContent: '',
    className: "text-center imgProdTb",
    render: function (meta, type, data, meta) {
      let extension = data.imagen == null ? null : "01-small." + data.imagen.split(".").pop();
      return $IMAGENPROD ? `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
                  <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${extension}" alt="" />
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
    data: 'cantPaca'
  },
  {
    data: 'stock',
    className: 'text-center align-middle',
    render: function (meta, type, data, meta) {
      return `<button class="btn btn-${data.ColorStock}">${data.stock}</button>`;
    }
  },
  {
    orderable: false,
    searchable: false,
    defaultContent: '',
    className: 'text-center align-middle noExport',
    render: function (meta, type, data, meta) {
      let btn = true;
      let resultado = productosVentas.find((it) => it.id == data.id);

      if (resultado) {
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
    $(row).find(".btnAdd").on("click", function () {
      let result = productosVentas.find((it) => it.id == data.id);
      if (result) {
        alertify.error("Este producto ya se encuentra agregado");
      } else {
        $("#p" + data.id).addClass("disabled").prop("disabled", true);
        data.cantidad = 1;
        data.valorUnitario = data.precio_venta;
        data.valorTotal = data.precio_venta;
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
  scrollY: '60vh',
  scroller: {
    loadingIndicator: true
  },
  columns: [
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        return `<div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-danger btnBorrar" title="Borrar Producto"><i class="fa-solid fa-times"></i></button>
                </div>`;
      }
    },
    {
      data: 'referencia',
      width: "30%",
      render: function (meta, type, data, meta) {
        return `<span title="${data.referencia}" class="text-descripcion">${data.referencia}</span>`;
      }
    },
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
      data: 'cantidad',
      render: function (meta, type, data, meta) {
        return `<input type="number" class="form-control form-control-sm cantidadProduct inputFocusSelect soloNumeros" min="1" value="${data.cantidad}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorUnitario',
      render: function (meta, type, data, meta) {
        return `<input type="tel" class="form-control form-control-sm inputPesos text-right inputFocusSelect soloNumeros valorUnitario" min="0" value="${data.valorUnitario}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorTotal',
      className: 'text-right valorTotal',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.valorTotal);
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
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
      $msj = "vendedore y clientes";
    } else if ($PREFIJOVALIDO == 'N') {
      $msj = "prefijo de pedido disponible";
    } else {
      $msj = $CANTIDADVENDEDORES == 0 ? "vendedores" : "clientes";
    }

    alertify.alert('¡Advertencia!', `No hay ${$msj} disponibles.`);
  } else {
    DTProductos = $("#table").DataTable(DTProductos);
  }

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
                    $("#total").val(0)
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
        alertify.alert("Advertencia", "Debe de elegiar minimo un producto para guardar la venta.");
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

  /* $("#cliente").select2({
    ajax: {
      url: base_url() + "Busqueda/Clientes",
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
  }).on("change", function () {
    $("#sucursal").val('').trigger('change.select2');
  }); */

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
});

function calcularTotal() {
  sumTotal = 0;
  productosVentas.forEach((it) => {
    sumTotal += Number(it.valorTotal);
  });

  $("#total").val(sumTotal);
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