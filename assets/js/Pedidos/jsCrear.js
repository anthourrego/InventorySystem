let rutaBase = base_url() + "Pedidos/";
let productosPedido = [];
let productosEliminados = [];

let DTProductos = {
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": 1, "ventas": 1 })
    }
  },
  dom: domBftrip,
  order: [[2, "asc"]],
  columns: [
    {
      orderable: false,
      searchable: false,
      visible: $IMAGENPROD,
      defaultContent: '',
      className: "text-center imgProdTb",
      render: function (meta, type, data, meta) {
        return $IMAGENPROD ? `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
          <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
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
        let resultado = productosPedido.find((it) => it.id == data.id);

        if (resultado) {
          btn = false;
        }

        return `<div class="btn-group btn-group-sm" role="group">
                  <button id="p${data.id}" type="button" class="btn btn-primary btnAdd ${(btn == true ? '' : 'disabled')}" ${(btn == true ? '' : 'disabled')} title="Agregar"><i class="fa-solid fa-plus"></i></button>
                </div>`;
      }
    },
  ],
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
        data.nuevo = true;
        productosPedido.unshift(data);
        DTProductosPedido.clear().rows.add(productosPedido).draw();
      }
      calcularTotal();
    });
  }
};

let DTProductosPedido = $("#tblProductos").DataTable({
  data: productosPedido,
  dom: domSearch1,
  processing: false,
  serverSide: false,
  order: [],
  scrollY: screen.height - 750,
  scroller: {
    loadingIndicator: true
  },
  columns: [
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      visible: ($DATOSPEDIDO != '' && $DATOSPEDIDO.estado == '2' ? false : true),
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        let estadoPedido = $DATOSPEDIDO != '' ? $DATOSPEDIDO.estado : "0";
        return `
          ${(estadoPedido != 0 ? '<button type="button" class="btn btn-secondary btn-sm btnEditar" title="Editar Producto"><i class="fa-solid fa-pen-to-square"></i></button>' : '')}
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-danger btnBorrar ${(estadoPedido != 0 || $EDITARPEDIDO == 'N' ? 'd-none' : '')}" title="Borrar Producto"><i class="fa-solid fa-trash"></i></button>
            ${(estadoPedido != 0 ? '<button type="button" class="btn btn-success btnAceptarEdicion d-none" title="Guardar edicion"><i class="fa-solid fa-save"></i></button>' : '')}
          </div>
        `;
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
        let estadoPedido = $DATOSPEDIDO != '' ? $DATOSPEDIDO.estado : "0";
        return `<input type="number" ${(estadoPedido != 0 || $EDITARPEDIDO == 'N' ? 'disabled' : '')} class="form-control form-control-sm cantidadProduct inputFocusSelect soloNumeros" min="1" value="${data.cantidad}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorUnitario',
      render: function (meta, type, data, meta) {
        let estadoPedido = $DATOSPEDIDO != '' ? $DATOSPEDIDO.estado : "0";
        return `<input type="tel" ${(estadoPedido != 0 || $EDITARPEDIDO == 'N' ? 'disabled' : '')} class="form-control form-control-sm inputPesos text-right inputFocusSelect soloNumeros valorUnitario" min="0" value="${data.valorUnitario}">`;
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

    $(row).find(".cantidadProduct").on("keydown", function (e) {
      if (e.which == 9) {
        setTimeout(() => {
          let element = $(row).next();
          if (element.length) {
            $(element).find(".cantidadProduct").focus();
          }
        }, 0);
      }
    });

    $(row).find(".btnBorrar").click(function (e) {
      e.preventDefault();
      if ($DATOSPEDIDO.estado == 1) {
        let mensaje = `<li> ¿Por que esta eliminando el producto (${data.item} - ${data.descripcion})?</li>`;

        $(row).find('input').attr('disabled', true);
        $(row).find('.btnAceptarEdicion, .btnBorrar').addClass("d-none");
        $(row).find(".btnEditar").removeClass("d-none");

        $('#itemsModalObser').html(mensaje);
        $("#modalObservacion").modal('show');
        $("#observacionModal").val(data.observacionDiferencia);
        $("#btnConfirmObser").unbind().on('click', function () {
          data.motivoDiferencia = $("#motivoModal").val();
          data.observacionDiferencia = $("#observacionModal").val();
          data.eliminado = true;
          productosEliminados.push(data);
          $("#modalObservacion").modal('hide');
          productosPedido = productosPedido.filter(it => it.id != data.id);
          DTProductosPedido.clear().rows.add(productosPedido).draw();
          $("#p" + data.id).removeClass("disabled").prop("disabled", false);
          calcularTotal();
        });
      } else {
        productosPedido = productosPedido.filter(it => it.id != data.id);
        DTProductosPedido.clear().rows.add(productosPedido).draw();
        $("#p" + data.id).removeClass("disabled").prop("disabled", false);
        calcularTotal();
      }
    });

    if ($DATOSPEDIDO != '') {
      $(row).find(".btnEditar").click(function (e) {
        e.preventDefault();
        $(row).find('input').attr('disabled', false);

        $(row).find('.btnAceptarEdicion, .btnBorrar').removeClass("d-none");

        $(row).find(".btnEditar").addClass("d-none");
      });


      $(row).find(".btnAceptarEdicion").click(function (e) {
        e.preventDefault();

        if (!data.nuevo && $DATOSPEDIDO.estado == 1) {

          let observacion = false;
          let mensaje = '';

          if (+data.valorUnitarioOriginal != +data.valorUnitario) {
            observacion = true;
            mensaje += '<li> ¿Por que el valor es ' + (+data.valorUnitarioOriginal > +data.valorUnitario ? 'menor' : 'mayor') + ' al orignal del pedido?</li>';
          }

          /* Se agrega la segunda validacion para que solo salga con la cantidad cuando se disminuye */
          if (+data.cantidadOriginal != +data.cantidad && +data.cantidadOriginal > +data.cantidad) {
            observacion = true;
            mensaje += '<li> ¿Por que la cantidad es ' + (+data.cantidadOriginal > +data.cantidad ? 'menor' : 'mayor') + ' a la inicial?</li>';
          }

          $(row).find('input').attr('disabled', true);
          $(row).find('.btnAceptarEdicion, .btnBorrar').addClass("d-none");
          $(row).find(".btnEditar").removeClass("d-none");

          $('#itemsModalObser').html(mensaje);
          if (observacion) {
            $("#modalObservacion").modal('show');
            $("#observacionModal").val(data.observacionDiferencia);
            $("#btnConfirmObser").unbind().on('click', function () {
              let resultado = productosPedido.find((it) => it.id == data.id);
              resultado.motivoDiferencia = $("#motivoModal").val();
              resultado.observacionDiferencia = $("#observacionModal").val();
              $("#modalObservacion").modal('hide');
            });
          } else {
            let resultado = productosPedido.find((it) => it.id == data.id);
            resultado.observacionDiferencia = '';
          }
        } else {
          $(row).find('input').attr('disabled', true);
          $(row).find('.btnAceptarEdicion, .btnBorrar').addClass("d-none");
          $(row).find(".btnEditar").removeClass("d-none");
        }
      });
    }

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
      $msj = ($CANTIDADVENDEDORES == 0 ? "vendedores" : "clientes") + " disponibles";
    }
    alertify.alert('¡Advertencia!', `No hay ${$msj}.`);
  } else {
    DTProductos = $("#table").DataTable(DTProductos);
  }

  document.title = "Pedido " + $("#nroPedido").val() + " | " + $NOMBREEMPRESA;

  $("#formPedido").submit(function (e) {
    e.preventDefault();

    if ($PREFIJOVALIDO == 'N') {
      alertify.alert('¡Advertencia!', `No hay prefijo de pedido disponible.`);
      return;
    }

    if ($(this).valid()) {

      if ($DATOSPEDIDO != '' && $DATOSPEDIDO.estado == 1 && $('.btnAceptarEdicion:visible').length) {
        alertify.warning(`Aún tiene productos pendientes por confirmar.`);
        return
      }

      if (productosPedido.length > 0) {
        form = new FormData(this);
        if ($DATOSPEDIDO != '') {
          productosPedido = productosPedido.concat(productosEliminados);
        }
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
                    $("#cliente, #vendedor").data("id", "").closest(".input-group").find(".input-group-text").text("");
                    $("#observacion").val("");
                    $("#total").val(0)
                    DTProductos.ajax.reload();
                    DTProductosPedido.clear().rows.add(productosPedido).draw();
                    resetForm("#formPedido");
                    $("#nroPedido").val(resp.nroPedido);
                  },
                  function () {
                    window.location.href = base_url() + 'Pedidos/Administrar';
                  }).set('labels', { ok: `<i class="fas fa-check"></i> Si`, cancel: `<i class="fas fa-times"></i> No` });
              } else {
                alertify.alert('¡Advertencia!', "Pedido editado correctamente", function () { window.location.href = base_url() + 'Pedidos/Administrar'; });
              }
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.alert("Advertencia", "Debe de elegir minimo un producto para guardar el pedido.");
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
      async: false,
      cache: true
    }
  }).on("change", function () {
    $("#sucursal").val('').trigger('change.select2');
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
});

function calcularTotal() {
  sumTotal = 0;
  productosPedido.forEach((it) => {
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