let rutaBase = base_url() + "Empaque/";
let productosPedido = [];

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
        if (data.estado == 'PE') {
          color = "primary";
        } else if (data.estado == 'EP') {
          color = "warning";
        }
        return `<button class="btn btn-${color}">${data.NombreEstado}</button>`;
      }
    }, {
      data: 'total',
      className: 'text-right',
      visible: false,
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.total);
      }
    }, {
      data: 'created_at',
      visible: false,
      render: function (meta, type, data, meta) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    }, {
      data: 'NombreVendedor',
      visible: false,
    }, {
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
            ${validPermissions(106) ? `<a href="${base_url()}Reportes/Pedido/${data.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Pedido">
              <i class="fa-solid fa-print"></i>
            </a>` : ''}
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
            if (resp.recargar) {
              $("#modalEmpaque").modal('hide');
              DT.ajax.reload();
            }
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
            DT.ajax.reload();
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
            if (resp.obsProds) {
              alertify.confirm("Advertencia", resp.msj, function () {
                agregarObservaciones(data, resp.obsProds, true);
              }, function () { });
            } else {
              alertify.error(resp.msj);
            }
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
            if (resp.recargar) {
              $("#modalEmpaque").modal('hide');
              DT.ajax.reload();
            }
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

  if (!pedido || !pedido.id) {
    alertify.alert('¡Advertencia!', "El Pedido fue eliminado", function () {
      $("#modalEmpaque").modal('hide');
      DT.ajax.reload();
    });
    return
  }

  $("#listaproductospedido").html(`<div class="font-weight-bold text-center p-2">No se encontraron productos</div>`);
  $("#listaproductospedidoempacar").html(`<div class="font-weight-bold text-center p-2">No se encontraron productos</div>`);
  if (pedido.productos.length) {
    let estructura = '', estructuraProceso = '';
    pedido.productos.forEach((it, x) => {
      estructuraProceso += `<div class="item-prod-agregar col-12">
        <div class="card p-2">
          <div class="row">
            <div class="col-2 col-md-1">
              <a class="imgProd" href="${(it.FotoURLSmall || `${base_url()}Productos/Foto`)}" data-fancybox="images${it.id}" data-caption="${it.referencia} - ${(it.item || '')}" data-pos=${x}>
                <img class="img-thumbnail" src="" alt="Producto"/>
              </a>
            </div>
            <div class="col-10 col-md-11">
              <div class="d-flex align-items-center">
                <h6 class="mb-0" style="width: 65%" data-item="${it.referencia} - ${(it.item || '')}">${it.referencia} - ${(it.item || '')}</h6>
                <div class="input-group" style="width: 35%">
                  <input id="prod${it.id}" type="number" class="form-control form-control-sm cantAgregarProd soloNumeros p-1 font-weight-bold" min="1" value="${it.cantAgregar}" max="${it.CantTotalCajas}" aria-describedby="btnCantidad">
                  <div class="input-group-append">
                    <button class="btn btn-info btn-sm" type="button" id="btnCantidad">/${it.cantidad}</button>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between mt-1">
                <h6 class="mb-0" data-item="${it.referencia} - ${(it.item || '')}">${it.descripcion} - ${(it.ubicacionProd || '')}</h6>
                <button type="button" class="btn btn-sm btn-primary btn-agregar-prod d-none" data-input="#prod${it.id}" data-pos=${x}>
                  <i class="fas fa-plus"></i> Agregar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>`;

      estructura += `<div class="item-prod-agregar col-12">
        <div class="card p-2">
          <div class="row">
            <div class="col-2 col-md-1 text-center option-ref" data-pos=${x}>
              <button title="Ver Foto" type="button" class="btn btn-info btn-sm">
                <i class="fas fa-image"></i>
              </button>
              <a class="d-none" href="" data-fancybox="imagesEmpacar${it.id}" data-caption="${it.referencia} - ${(it.item || '')}">
                <img class="img-thumbnail" src="" alt="Producto"/>
              </a>
            </div>
            <div class="col-8 col-md-10">
              <div class="d-flex align-items-center">      
                <h6 class="mb-0" data-item="${it.referencia} - ${(it.item || '')}">${it.referencia} - ${(it.item || '')}</h6>
              </div>
              <div class="d-flex justify-content-between mt-1">
                <h6 class="mb-0" data-item="${it.referencia} - ${(it.item || '')}">${it.descripcion} - ${(it.ubicacionProd || '')}</h6>
              </div>
            </div>
            <div class="col-2 col-md-1 d-flex align-items-center justify-content-center">
              <h5>${+it.CantTotalCajas}/${it.cantidad}</h5>
            </div>
          </div>
        </div>
      </div>`;
    });
    $("#listaproductospedido").html(estructuraProceso);
    $("#listaproductospedidoempacar").html(estructura);

    $(".btn-agregar-prod").click(function () {

      let cajaId = $(".caja-actual[data-caja]").data('caja');

      if (!cajaId) return alertify.warning("No se ha encontrado caja en proceso");

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
            if (resp.recargar) {
              $("#modalEmpaque").modal('hide');
              DT.ajax.reload();
            }
          }
        }
      });
    });

    $(".option-ref").click(function () {
      let data = pedido.productos[$(this).data('pos')];
      let aElement = $(this).find('a');
      let buttonElement = $(this).find('button');
      if (aElement.hasClass('d-none')) {
        aElement.removeClass('d-none').attr('href', (data.FotoURLSmall || `${base_url()}Productos/Foto`));
        aElement.find('img').attr('src', (data.FotoURLSmall || `${base_url()}Productos/Foto`));
        buttonElement.addClass('d-none');
      }
      $(this).unbind('click');
    });

    buscarValores('');
  }

  productosPedido = pedido.productos;

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
        <div class="card mb-2 ${(!it.finEmpaque && $USUARIOID == it.empacador ? 'border border-info caja-actual' : '')}" ${(!it.finEmpaque && $USUARIOID == it.empacador ? `data-caja="${it.idCajaPedido}"` : '')} style="border-width: 3px !important;">
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
                      ${it.referencia} - ${it.cantidad} uni
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
                    if (resp.recargar) {
                      $("#modalEmpaque").modal('hide');
                      DT.ajax.reload();
                    }
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
          DT.ajax.reload();
        }
      }
    });
  });

  $(".titulo-modal-pedido").html(`Empaque | Pedido ${pedido.pedido} | ${pedido.NombreSucursal}`);
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
          if (resp.recargar) {
            $("#modalEmpaque").modal('hide');
            DT.ajax.reload();
          }
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
          if (resp.obsProds) {
            alertify.confirm("Advertencia", resp.msj, function () {
              agregarObservaciones(pedido, resp.obsProds);
            }, function () { });
          } else {
            alertify.error(resp.msj);
            if (resp.recargar) {
              $("#modalEmpaque").modal('hide');
              DT.ajax.reload();
            }
          }
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

  setTimeout(() => {
    document.getElementById("listacajas").scrollLeft = document.getElementById("listacajas").scrollWidth
  }, 500);
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
        if (resp.recargar) {
          $("#modalEmpaque").modal('hide');
          DT.ajax.reload();
        }
      }
    }
  });
}

function buscarValores(valor) {
  $(".item-prod-agregar").removeClass('d-none');
  $("#listaproductospedidonohay").addClass('d-none');

  if (!valor.length) {
    $("#listaproductospedido .item-prod-agregar").addClass('d-none');
    $("#listaproductospedidonohay").removeClass('d-none');
    return;
  }

  $.each($("#listaproductospedido .item-prod-agregar h6"), function () {
    let item = $(this).data("item");
    console.log($(this));
    if (item != undefined) {
      let itemAgregar = $(this).closest(".item-prod-agregar");
      if (!$(this).text().toLowerCase().includes(valor.toLowerCase()) && !(item + "").toLowerCase().includes(valor.toLowerCase())) {
        itemAgregar.addClass('d-none');
      } else {
        if (valor.length) {
          let imagen = itemAgregar.find('a.imgProd');
          let prodActual = productosPedido[imagen.data('pos')];
          itemAgregar.find('a.imgProd img').attr('src', (prodActual.FotoURLSmall || `${base_url()}Productos/Foto`));
          itemAgregar.find('button.btn-agregar-prod').removeClass('d-none');
        } else {
          itemAgregar.find('button.btn-agregar-prod').addClass('d-none');
        }
      }
    }
  });

  if (!$("#listaproductospedido .item-prod-agregar:not(.d-none)").length) {
    $("#listaproductospedidonohay").removeClass('d-none');
  }
}

function agregarObservaciones(pedido, productos, direct = false) {
  $("#btn-cancelar-empaque-obs").off('click').on('click', function () {
    if (direct) {
      $("#modalObsProd").modal('hide');
    } else {
      $("#modalEmpaque").modal('show');
      $("#btnSincronizar").click();
    }
  });

  let estructura = '';
  productos.forEach((it, x) => {
    estructura += `<div class="list-group-item list-group-item-action item-prod-add p-2">
        <div class="row align-items-center">
          <div class="mb-1 col-7 col-lg-3 align-self-center">
            <h6 class="mb-0 text-truncate text-bold">${it.referencia} - ${it.descripcion}</h6>
          </div>
          <div class="mb-1 col-5 col-lg-2">
            <button type="button" class="btn btn-secondary cantProd">
              Cantidad: <span class="badge badge-light">${it.cantAgregar}</span>
            </button>
          </div>
          <div class="mb-1 col-12 col-lg-3 form-group form-valid">
            <label for="motivo${it.id + 1}" class="mb-0">Motivo</label>
						<select class="form-control" name="motivo${it.id + 1}" id="motivo${it.id + 1}" required>
							<option value="1">Daño</option>
							<option value="2">Devolución</option>
							<option value="3">Perdida</option>
						</select>
					</div>
          <div class="mb-1 col-12 col-lg-4 form-group form-valid">
            <label for="textarea${it.id}" class="mb-0">Observación</label>
            <textarea rows="1" class="form-control" data-pediprod="${it.idPedidoProducto}" data-prod="${it.id}" id="textarea${it.id}" name="textarea${it.id}" placeholder="Observación" required></textarea>
          </div>
        </div>
      </div>  
    `;
  });
  $("#listaproductosobser").html(estructura);

  $("#formObs").off('submit').on('submit', function (e) {
    e.preventDefault();

    if ($(this).valid()) {
      let productos = [];
      $.each($('.item-prod-add'), function (pos) {
        let textarea = $(this).find('textarea');
        let motivo = $(this).find('select').val();
        let cantidad = $(this).find('button.cantProd span').text();
        let data = {
          observacion: textarea.val(),
          motivo: motivo,
          productoId: textarea.data('prod'),
          pedidoProd: textarea.data('pediprod'),
          cantidad: cantidad
        }
        productos.push(data);
      });

      $.ajax({
        type: "POST",
        url: rutaBase + "ObservacionProductos",
        dataType: 'json',
        data: {
          idPedido: pedido.id,
          productos: productos
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            $("#modalObsProd, #modalEmpaque").modal('hide');
            DT.ajax.reload();
          } else {
            alertify.error(resp.msj);
            if (resp.recargar) {
              $("#modalObsProd, #modalEmpaque").modal('hide');
              DT.ajax.reload();
            } else if (resp.empaque) {
              $("#btn-cancelar-empaque-obs").click();
            }
          }
        }
      });
    }
  });

  $(".titulo-modal-obs").html(`Observación Productos | Pedido ${pedido.pedido}`);
  $("#modalEmpaque").modal('hide');
  $("#modalObsProd").modal('show');
}