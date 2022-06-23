let rutaBase = base_url() + "Pedidos/";
let productosPedido = [];
let columnsProd = [
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
      let resultado = productosPedido.find((it) => it.id == data.id);

      if (resultado) {
        btn = false;
      }

      return `<div class="btn-group btn-group-sm" role="group">
                <button id="p${data.id}" type="button" class="btn btn-primary btnAdd ${(btn == true ? '' : 'disabled')}" ${(btn == true ? '' : 'disabled')} title="Agregar"><i class="fa-solid fa-plus"></i></button>
              </div>`;
    }
  },
];

if ($IMAGENPROD) {
  columnsProd.unshift({
    orderable: false,
    searchable: false,
    defaultContent: '',
    className: "text-center",
    render: function (meta, type, data, meta) {
      return `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
                <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
              </a>`;
    }
  });
}

let DTProductos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": 1, "ventas": 1 })
    }
  },
  dom: domBftrip,
  order: [[2, "asc"]],
  columns: columnsProd,
  buttons: [
    'pageLength'
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnAdd").on("click", function () {
      let result = productosPedido.find((it) => it.id == data.id);
      if (result) {
        alertify.error("Este producto ya se encuentra agregado");
      } else {
        $("#p" + data.id).addClass("disabled").prop("disabled", true);
        data.cantidad = 1;
        data.valorUnitario = data.precio_venta;
        data.valorTotal = data.precio_venta;
        productosPedido.push(data);
        DTProductosPedido.clear().rows.add(productosPedido).draw();
      }
      calcularTotal();
    });
  }
});

let DTProductosPedido = $("#tblProductos").DataTable({
  data: productosPedido,
  dom: domSearch1,
  processing: false,
  serverSide: false,
  order: [[1, "asc"]],
  scrollY: screen.height - 750,
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
      data: 'item',
      width: "30%",
      render: function (meta, type, data, meta) {
        return `<span title="${data.item} - ${data.descripcion}" class="text-descripcion">${data.item} - ${data.descripcion}</span>`;
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
      let resultado = productosPedido.find((it) => it.id == data.id);

      //Validamos si puede asignar inventario negativo
      if (($INVENTARIONEGATIVO == "1") || ($INVENTARIONEGATIVO == "0" && cant <= Number(data.stock))) {
        resultado.cantidad = cant;
        resultado.valorUnitario = valorUnitario;
        resultado.valorTotal = resultado.cantidad * resultado.valorUnitario;

        $(row).find(".valorTotal").text(formatoPesos.format(resultado.valorTotal));
      } else {
        alertify.alert("Advertencia", `Ha superado la cantidad maxima, solo hay <b>${data.stock}</b> disponibles`);
        resultado.cantidad = 1;
        resultado.valorTotal = resultado.valorUnitario;
        $(this).val(1);
        $(row).find(".valorTotal").text(formatoPesos.format(data.valorUnitario));
      }

      data = resultado;

      calcularTotal();
    });

    $(row).find(".btnBorrar").click(function (e) {
      e.preventDefault();
      productosPedido = productosPedido.filter(it => it.id != data.id);
      DTProductosPedido.clear().rows.add(productosPedido).draw();
      $("#p" + data.id).removeClass("disabled").prop("disabled", false);
      calcularTotal();
    });
  },
  drawCallback: function (settings) {
    inputPesos();
  }
});

$(function () {
  if ($CANTIDADVENDEDORES == 0 || $CANTIDADCLIENTES == 0) {
    if ($CANTIDADVENDEDORES == 0 && $CANTIDADCLIENTES == 0) {
      $msj = "vendedore y clientes";
    } else {
      $msj = $CANTIDADVENDEDORES == 0 ? "vendedores" : "clientes";
    }

    alertify.alert('¡Advertencia!', `No hay ${$msj} disponibles.`);
  }

  $("#formPedido").submit(function (e) {
    e.preventDefault();
    if ($(this).valid()) {
      if (productosPedido.length > 0) {
        form = new FormData(this);
        form.append("idCliente", $("#cliente").val());
        form.append("idSucursal", $("#sucursal").val());
        form.append("idUsuario", $("#vendedor").val());
        form.append("observacion", $("#observacion").val());
        form.append("productos", JSON.stringify(productosPedido));

        $.ajax({
          url: rutaBase + ($DATOSPEDIDO == '' ? "Crear" : 'Editar'),
          type: 'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: form,
          success: function (resp) {
            if (resp.success) {
              if ($DATOSPEDIDO == '') {
                alertify.confirm("Pedido creado correctamente", `Nro de pedido: <b>${resp.msj.pedido}</b>, por valor de <b>${formatoPesos.format(resp.msj.total)}</b><br><br>Desea crear un nuevo pedido?`,
                  function () {
                    productosPedido = [];
                    $("#nroPedido").val(resp.msj.pedido + 1);
                    $("#cliente, #vendedor").data("id", "").closest(".input-group").find(".input-group-text").text("");
                    $("#observacion").val("");
                    $("#total").val(0)
                    DTProductos.ajax.reload();
                    DTProductosPedido.clear().rows.add(productosPedido).draw();
                    resetForm("#formPedido");
                  },
                  function () {
                    window.location.href = base_url() + 'Pedidos/Administrar';
                  }).set('labels', {ok: `<i class="fas fa-check"></i> Si`, cancel: `<i class="fas fa-times"></i> No`});
              } else {
                alertify.alert('¡Advertencia!', "Pedido editado correctamente", function () { window.location.href = base_url() + 'Pedidos/Administrar'; });
              }
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.alert("Advertencia", "Debe de elegiar minimo un producto para guardar el pedido.");
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
      cache: true
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $("#cliente").select2({
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
      cache: true
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $("#sucursal").select2({
    ajax: {
      url: base_url() + "Busqueda/Sucursales",
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
        return {
          results: data.data,
          pagination: {
            more: (params.page * 10) < data.total_count
          }
        };
      },
      cache: true
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });
});

function calcularTotal() {
  sumTotal = 0;
  productosPedido.forEach((it) => {
    sumTotal += Number(it.valorTotal);
  });

  $("#total").val(sumTotal);
}

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }
  return repo.full_name || repo.text;
}

function formatRepoSelection (repo) {
  return repo.full_name || repo.text;
}