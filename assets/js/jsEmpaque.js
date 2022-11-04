let rutaBase = base_url() + "Empaque/";

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
  },
  order: [[0, "desc"]],
  columns: [
    { data: 'pedido' },
    { data: 'NombreCliente' },
    { data: 'NombreSucursal' },
    { data: 'direccion' },
    { data: 'Ciudad' },
    {
      data: 'NombreEstado',
      visible: false,
      className: 'text-center align-middle',
      render: function (meta, type, data, meta) {
        let color = "success";
        if (data.estado == 0) {
          color = "primary";
        } else if (data.estado == 1) {
          color = "warning";
        }
        return `<button class="btn btn-${color}">${data.NombreEstado}</button>`;
      }
    }, {
      data: 'total',
      className: 'text-right',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.total);
      }
    }, {
      data: 'created_at',
      render: function (meta, type, data, meta) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    { data: 'NombreVendedor' },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        return `
          <div class="btn-group btn-group-sm" role="group">
            ${!data.inicio_empaque ? `<button type="button" class="btn btn-primary btnIniciarEmpaque" title="Iniciar Empaque Pedido">
              <i class="fa-solid fa-boxes-packing"></i>
            </button>` : ''}
            ${data.inicio_empaque && !data.fin_empaque ? `<button type="button" class="btn btn-secondary btnInfoEmpaque" title="Proceso Empaque Pedido">
              <i class="fa-solid fa-box-archive"></i>
            </button>` : ''}
            ${validPermissions(302) && data.fin_empaque ? `<button type="button" class="btn btn-warning btnReabrirEmpaque" title="Reabrir empaque pedido">
            <i class="fa-solid fa-box-open"></i>
            </button>` : ''}
            ${validPermissions(301) && data.inicio_empaque ? `<button type="button" class="btn btn-success btnFinEmpaque" title="Finalizar Empaque Pedido">
              <i class="fa-solid fa-check"></i>
            </button>` : ''}
          </div>
        `;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnIniciarEmpaque").click(function (e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: rutaBase + "IniciarEmpaque",
        dataType: 'json',
        data: {
          idPedido: data.id,
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            obtenerInfoPedido(resp.pedido);
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    });

    $(row).find(".btnInfoEmpaque").click(function (e) {
      e.preventDefault();
      $.ajax({
        type: "GET",
        url: rutaBase + "ProductosPedido/" + data.id,
        dataType: 'json',
        success: function (resp) {
          if (resp.success) {
            obtenerInfoPedido(resp.pedido);
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    });

    $(row).find(".btnFinEmpaque").click(function (e) {
      e.preventDefault();
      $.ajax({
        url: rutaBase + 'FinalizarEmpaque',
        type: 'POST',
        dataType: 'json',
        data: {
          idPedido: data.id,
          caja: 0
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DT.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    });

    $(row).find(".btnReabrirEmpaque").click(function (e) {
      e.preventDefault();
      $.ajax({
        url: rutaBase + 'ReabrirEmpaque',
        type: 'POST',
        dataType: 'json',
        data: {
          idPedido: data.id
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DT.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    });
  }
});

$(function () {
  $("#modalEmpaque").on('hidden.bs.modal', function () {
    DT.ajax.reload();
  });

  $("#inputBuscarProd").on('keyup', function () {
    buscarValores($(this).val());
  });

  $("#btnBuscar").on("click", function () {
    buscarValores($("#inputBuscarProd").val());
  });
})

/* Funcion para organizar info de pedido en caja */
function obtenerInfoPedido(pedido, sync = false) {
  console.log(pedido);
  $("#listaproductospedido").html(`<div class="font-weight-bold text-center p-2">No se encontraron productos</div>`);
  if (pedido.productos.length) {
    let estructura = '';
    pedido.productos.forEach((it, x) => {
      estructura += `<div class="list-group-item list-group-item-action item-prod-agregar p-2">
          <div class="row">
            <div class="col-7 col-lg-6 align-self-center">
              <h6 class="mb-0 text-truncate w-100">${it.referencia} - ${it.descripcion}</h6>
            </div>
            <div class="col-5 col-lg-3">
              <div class="input-group">
                <input id="prod${it.id}" type="number" class="form-control form-control-sm cantAgregarProd soloNumeros" min="1" value="${it.cantAgregar}" max="${it.CantTotalCajas}" aria-describedby="btnCantidad">
                <div class="input-group-append">
                  <button class="btn btn-outline-info btn-sm" type="button" id="btnCantidad">/${it.cantidad}</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3 text-right">
              <button type="button" class="btn btn-sm btn-primary btn-agregar-prod" data-input="#prod${it.id}" data-pos=${x}>
                <i class="fas fa-plus"></i> Agregar
              </button>
            </div>
          </div>
        </div>  
      `;
    });
    $("#listaproductospedido").html(estructura);

    $(".btn-agregar-prod").click(function () {

      let cajaId = $(".caja-actual[data-caja]").data('caja');

      if (!cajaId) return alertify.warning("No se ha encontrada caja en proceso");

      let producto = pedido.productos[$(this).data('pos')];
      let cantAgregar = $($(this).data('input')).val();

      $.ajax({
        url: rutaBase + 'AgregarProductoCaja',
        type: 'POST',
        dataType: 'json',
        data: {
          idPedido: pedido.id,
          cantidad: cantAgregar,
          idProducto: producto.id,
          idCaja: cajaId
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            obtenerInfoPedido(resp.pedido);
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    });
  }

  $("#listacajas").html(`<div class="font-weight-bold text-center p-2 col-12">No se encontraron cajas</div>`);
  $("#btnAgregarCaja").show();
  $("#btnFinalizarCaja").hide();
  if (pedido.cajas.length) {
    let estrcutura = '';
    pedido.cajas.forEach((it, pos) => {

      if (!it.finEmpaque && $USUARIOID == it.empacador) {
        $("#btnAgregarCaja").hide();
        $("#btnFinalizarCaja").show();
      }

      let estructu = `<div class="col-8 col-lg-4">
        <div class="card mb-2 ${(!it.finEmpaque && $USUARIOID == it.empacador ? 'border border-info caja-actual' : '')}" ${(!it.finEmpaque && $USUARIOID == it.empacador ? `data-caja="${it.idCajaPedido}"` : '')}>
          <div class="card-body">
            <div class="row">
              <div class="col-9 item-caja" data-pos="${pos}" style="cursor: pointer;">
                <h5 class="card-title">
                  <i class="fa-solid fa-box mr-1"></i> ${it.numeroCaja}
                </h5>
                <p class="card-text">${it.nombreEmpacador}</p>
              </div>
              ${$USUARIOID == it.empacador ? `
                <div class="col-3">
                  <button class="btn btn-sm btn-danger eliminar-caja" data-pos="${pos}" title="eliminar">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>` : ''}
            </div>
          </div>
        </div>
      </div>`;
      estrcutura += estructu;
    });
    $("#listacajas").html(estrcutura);

    if (pedido.cajas.length > 3 || ($(window).width() < 993 && pedido.cajas.length > 1)) {
      $("#listacajas").css("overflow-x", "scroll");
    } else {
      $("#listacajas").css("overflow-x", "unset");
    }

    $(".item-caja").on('click', function () {
      let infoCaja = pedido.cajas[$(this).data('pos')];
      $("#btnReabrirCaja").hide();
      $.ajax({
        url: rutaBase + 'ObtenerProductosaCaja/' + infoCaja.idCajaPedido,
        type: 'GET',
        dataType: 'json',
        success: function ({ productosCaja }) {
          let estructura = `<div class="font-weight-bold text-center p-2 col-12">No se encontraron productos en la caja</div>`;
          if (productosCaja.length) {
            estructura = '';
            productosCaja.forEach((it, x) => {
              estructura += `<div class="list-group-item list-group-item-action p-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-truncate w-75">
                      Ref: ${it.referencia} - Cantidad: ${it.cantidad}
                    </h6>
                    <button type="button" class="btn btn-sm btn-danger btn-eliminar-prod" data-pos=${x}>
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              `;
            });
            $("#listaproductoscaja").html(estructura);

            $(".btn-eliminar-prod").on('click', function () {
              let producto = productosCaja[$(this).data('pos')];

              alertify.confirm('Advertencia', `¿Esta seguro de retirar el producto con referencia ${producto.referencia} de la caja? `, function () {
                eliminarCaja(infoCaja.idCajaPedido, pedido.id, producto.idProductoCaja);
              }, function () { });

            });
          } else {
            $("#listaproductoscaja").html(estructura);
          }

          if (infoCaja.finEmpaque && $USUARIOID == infoCaja.empacador) {
            $("#btnReabrirCaja").show();

            $("#btnReabrirCaja").off('click').click(function () {
              $.ajax({
                url: rutaBase + 'ReabrirCaja',
                type: 'POST',
                dataType: 'json',
                data: {
                  idCaja: infoCaja.idCajaPedido,
                  idPedido: pedido.id
                },
                success: function (resp) {
                  if (resp.success) {
                    alertify.success(resp.msj);
                    obtenerInfoPedido(resp.pedido);
                  } else {
                    alertify.error(resp.msj);
                  }
                }
              });
            });
          }
        }
      });
    });

    $(".eliminar-caja").on('click', function () {
      let infoCaja = pedido.cajas[$(this).data('pos')];

      if (+infoCaja.numeroCaja < pedido.cajas.length) {
        let mensaje = `
          <h5>¿Esta seguro de eliminar la caja ${infoCaja.numeroCaja}?</h5>
          <br> 
          <b>Nota:</b> Las cajas posteriores a la Caja ${infoCaja.numeroCaja} bajaran la numeración en una unidad para ocupar el espacio
        `;
        alertify.confirm('Advertencia', mensaje, function () {
          eliminarCaja(infoCaja.idCajaPedido, pedido.id);
        }, function () { });
      } else {
        alertify.confirm('Advertencia', `¿Esta seguro de eliminar la caja ${infoCaja.numeroCaja}?`, function () {
          eliminarCaja(infoCaja.idCajaPedido, pedido.id);
        }, function () { });
      }
    });

    if (!sync) $(".card.caja-actual").find('.item-caja').click();
  } else {
    $("#listaproductoscaja").html('');
  }

  $("#btnSincronizar").off('click').on('click', function () {
    $.ajax({
      type: "GET",
      url: rutaBase + "ProductosPedido/" + pedido.id,
      dataType: 'json',
      success: function (resp) {
        if (resp.success) {
          obtenerInfoPedido(resp.pedido, true);
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

  $(".titulo-modal-pedido").html(`Empaque Productos | Pedido ${pedido.pedido}`);
  $("#modalEmpaque").modal('show');

  $("#btnAgregarCaja").off('click').on('click', function () {
    $.ajax({
      url: rutaBase + 'AgregarCaja',
      type: 'POST',
      dataType: 'json',
      data: {
        idPedido: pedido.id
      },
      success: function (resp) {
        if (resp.success) {
          alertify.success(resp.msj);
          obtenerInfoPedido(resp.pedido);
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

  $("#btn-finalizar-empaque").off('click').on('click', function () {
    $.ajax({
      url: rutaBase + 'FinalizarEmpaque',
      type: 'POST',
      dataType: 'json',
      data: {
        idPedido: pedido.id,
        caja: 0
      },
      success: function (resp) {
        if (resp.success) {
          alertify.success(resp.msj);
          $("#modalEmpaque").modal('hide');
          DT.ajax.reload();
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });

  $("#btnFinalizarCaja").off('click').on('click', function () {
    $.ajax({
      url: rutaBase + 'FinalizarEmpaque',
      type: 'POST',
      dataType: 'json',
      data: {
        idPedido: pedido.id,
        caja: 1
      },
      success: function (resp) {
        if (resp.success) {
          alertify.success(resp.msj);
          obtenerInfoPedido(resp.pedido);
        } else {
          alertify.error(resp.msj);
        }
      }
    });
  });
}

function eliminarCaja(idCaja, idPedido, idProdCaja = 0) {
  $.ajax({
    url: rutaBase + 'EliminarCaja',
    type: 'POST',
    data: { idCaja, idPedido, idProdCaja },
    dataType: 'json',
    success: function (resp) {
      if (resp.success) {
        alertify.success(resp.msj);
        if (idProdCaja == 0) {
          $("#listaproductoscaja").html('');
        }
        obtenerInfoPedido(resp.pedido);
      } else {
        alertify.error(resp.msj);
      }
    }
  });
}

function buscarValores(valor) {
  $(".item-prod-agregar").removeClass('d-none');
  $("#listaproductospedidonohay").addClass('d-none');

  $.each($(".item-prod-agregar h6"), function () {
    if (!$(this).text().toLowerCase().includes(valor.toLowerCase())) {
      $(this).closest(".item-prod-agregar").addClass('d-none');
    }
  });

  if ($(".item-prod-agregar:not(.d-none)").length) {
    $("#listaproductospedidonohay").addClass('d-none');
  }
}