let rutaBase = base_url() + "Pedidos/";
let limiteRotulo = 1000;
let estadoFiltro = '-1';
let btnActualDetallePedido = null;

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": estadoFiltro })
    }
  },
  order: [
    [5, "desc"],
    [0, "desc"]
  ],
  scrollX: true,
  columns: [
    {
      data: 'pedido',
      render: function (meta, type, data, meta) {
        return (data.idFactura && data.idFactura > 0 && validPermissions(6)) ? `<a target="_blank" title="${data.factura}" href="${base_url()}Ventas/Editar/${data.idFactura}">${data.pedido} | ${data.factura}</a>` : data.pedido;
      }
    },
    { data: 'NombreCliente' },
    { data: 'NombreSucursal' },
    { data: 'direccion' },
    { data: 'Ciudad' },
    {
      data: 'NombreEstado',
      className: 'text-center align-middle',
      render: function (meta, type, data, meta) {
        let color = "success";
        let facturado = (data.idFactura && data.idFactura > 0);
        if (!facturado) {
          if (data.estado == 'PE') {
            color = "primary";
          } else if (data.estado == 'EP') {
            color = "secondary";
          } else if (data.estado == 'EM') {
            color = "info";
          } else if (data.estado == 'DE') {
            color = "warning";
          }
        }
        return `<button class="btn btn-${color}">${data.NombreEstado}</button>`;
      }
    },
    {
      data: 'total',
      className: 'text-right',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.total);
      }
    },
    {
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
        /* Validamos si no maneja empaque y sea estado inicial y se factura directo */
        if ($MANEJAEMPAQUE != '1' && data.estado == 'PE') {
          data.estado = 'EM';
        }

        let estado = 'Facturar';
        let color = 'success';
        if (data.estado == 'PE') {
          estado = 'Enviar Alistamiento';
          color = 'warning';
        }
        let botones = '';
        let facturado = (data.idFactura && data.idFactura > 0);

        /* Si es para alistamiento o si no tiene factura y ya esta despachado */
        if ((data.estado == 'PE' && validPermissions(104)) || (!facturado && data.estado == 'DE' && validPermissions(105))) {
          botones += `<button type="button" class="btn btn-${color} btnConfirmarPedido" title="${estado} Pedido">
            <i class="fa-solid ${data.estado == 'PE' ? 'fa-boxes-stacked' : 'fa-receipt'}"></i>
          </button>`;
        }

        /* Si es para despachar ya esta empacado */
        if (data.estado == 'EM' && validPermissions(110)) {
          botones += `<button type="button" class="btn btn-primary btnDespacharPedido" title="Despachar Pedido">
            <i class="fa-solid fa-dolly"></i>
          </button>`;
        }

        /* Tiene permiso de imprimir */
        if (validPermissions(106)) {
          botones += `<a href="${base_url()}Reportes/Pedido/${data.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Pedido">
            <i class="fa-solid fa-print"></i>
          </a>`;
          /* Con permiso y tenga factura */
          if (facturado) {
            botones += `<a href="${base_url()}Reportes/Factura/${data.idFactura}" target="_blank" type="button" class="btn btn-success" title="Imprimir Factura">
              <i class="fa-solid fa-receipt"></i>
            </a>`;
          }
        }

        /* Si esta facturado */
        if (facturado) {
          botones += `<button type="button" class="btn btn-secondary btnEditar" title="Ver">
            <i class="fa-solid fa-eye"></i>
          </button>`;
        } else {
          /* Si no esta facturado y tiene permiso de editar */
          if (validPermissions(102)) {
            botones += `<button type="button" class="btn btn-secondary btnEditar" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>`;
          } else {
            /* Solo puede ver el pedido */
            botones += `<button type="button" class="btn btn-secondary btnEditar" title="Ver">
              <i class="fa-solid fa-eye"></i>
            </button>`;
          }
        }

        /* Si no esta facturado y tiene permiso de eliminar */
        if (!facturado && validPermissions(103)) {
          botones += `<button type="button" class="btn btn-danger btnEliminar" title="Eliminar">
            <i class="fa-regular fa-trash-can"></i>
          </button>`;
        }

        /* Si esta empacado o facturado */
        if (['EM', 'FA', 'DE'].includes(data.estado)) {
          /* Si tiene permiso para imprimir el rotulo */
          if (validPermissions(107)) {
            botones += `<button type="button" class="btn btn-dark btnImprimirRotulo" title="Imprimir rotulo">
              <i class="fa-solid fa-tags"></i>
            </button>`;
          }

          /* Si tiene permiso para imprimir manifiestos */
          if (data.TotalCajas > 0 && validPermissions(108)) {
            botones += `<button type="button" class="btn btn-warning btnVerManifiesto" title="Ver Manifiestos Cajas">
              <i class="fa-solid fa-file"></i>
            </button>`;
          }

          /* Se valida si tiene permiso para imprimir la orden de envio */
          if (validPermissions(109)) {
            botones += `<button type="button" class="btn btn-primary btnOrdenEnvio" title="Imprimir Orden de envio">
              <i class="fa-solid fa-paper-plane"></i>
            </button>`;
          }
        }

        /* Si esta facturado y tiene permiso de imprimir QR */
        /* if (facturado && validPermissions(110)) {
          botones += `<button type="button" class="btn btn-info btnImprimirQR" title="Código QR">
            <i class="fa-solid fa-qrcode"></i>
          </button>`;
        } */

        /* Se valida permiso para detalle del pedido */
        if (validPermissions(111) && ['EM', 'FA', 'DE', 'EP'].includes(data.estado)) {
          botones += `<button type="button" class="btn btn-info btnDetallePedido" title="Detalle Pedido">
            <i class="fa-solid fa-file-invoice"></i>
          </button>`;
        }

        if (validPermissions(112) && ['EM', 'FA', 'DE'].includes(data.estado) && data.TotalProductosReportados) {
          botones += `<button type="button" class="btn btn-dark btnProductosReportados" title="Producto Reportado">
            <i class="fa-solid fa-exclamation-triangle"></i>
          </button>`;
        }

        return `<div class="btn-group btn-group-sm" role="group">${botones}</div>`;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnEliminar").click(function (e) {
      e.preventDefault();
      eliminar(data);
    });

    $(row).find(".btnEditar").click(function (e) {
      e.preventDefault();
      window.location.href = base_url() + 'Pedidos/Editar/' + data.id.trim();
    });

    $(row).find(".btnConfirmarPedido").click(function (e) {
      e.preventDefault();
      alistarPedido(data);
    });

    $(row).find('.btnImprimirRotulo').click(function () {
      let context = this;
      let nroCajas = 1;
      let observacion = "";
      let campoFoco = 'input[name="nroCajas"]';

      if (!data.TotalCajas || $MANEJAEMPAQUE == '0') {
        $("#formDivRotuloNroCajas").removeClass("d-none");
      } else {
        $("#formDivRotuloNroCajas").addClass("d-none");
        campoFoco = 'textarea[name="observacion"]';
      }

      alertify.imprimirRotulo(function () {
        if (!data.TotalCajas || $MANEJAEMPAQUE == '0') {
          nroCajas = $('#formRotulo input[name="nroCajas"]').val();
          if (nroCajas > 0) {
            if (nroCajas > limiteRotulo) {
              alertify.warning('El limite permitido es ' + limiteRotulo);
              setTimeout(() => {
                $(context).click();
              }, 0);
              return;
            }
          } else {
            alertify.warning('Ingrese una cantidad valida');
            setTimeout(() => {
              $(context).click();
            }, 0);
            return;
          }
        } else {
          nroCajas = +data.TotalCajas
        }
        observacion = $('#formRotulo textarea[name="observacion"]').val();

        if (observacion != '') {
          observacion = observacion.split(' ').join('_');
          window.open(`${base_url()}Reportes/Rotulo/${data.id.trim()}/${nroCajas}?observacion=${observacion}`, '_blank');
        } else {
          window.open(`${base_url()}Reportes/Rotulo/${data.id.trim()}/${nroCajas}`, '_blank');
        }
        $('#formRotulo')[0].reset();

      },
        function () {
          $('#formRotulo')[0].reset();
        }).set('selector', campoFoco);
    });

    $(row).find(".btnVerManifiesto").click(function (e) {
      e.preventDefault();
      buscarManifiestos(data);
    });

    $(row).find(".btnOrdenEnvio").click(function (e) {
      e.preventDefault();
      let context = this;
      alertify.prompt('Envío', 'Valor del envio?', '1', function (evt, value) {
        if (value > 0) {
          value = value.split(' ').join('_');
          value = value.split('.').join('');
          window.open(`${base_url()}Reportes/Envio/${data.id.trim()}/${value}`, '_blank');
        } else {
          alertify.warning('Ingrese una cantidad valida');
          setTimeout(() => {
            $(context).click();
          }, 0);
        }
      }, function () { }).setting({
        'type': 'number'
      });
    });

    $(row).find(".btnImprimirQR").click(function (e) {
      e.preventDefault();
      $.ajax({
        type: "GET",
        url: `${rutaBase}GenerarQR/${data.idFactura}`,
        dataType: 'json',
        success: function (resp) {
          if (resp.success) {
            $("#imgqr").attr("src", resp.qr);
            $("#modalGQR").modal('show');
            $("#btnDescargarQR").attr('download', resp.name + '.png').attr('href', resp.qr);
          }
        }
      });
    });

    $(row).find(".btnDespacharPedido").click(function (e) {
      e.preventDefault();
      despacharPedido(data);
    });

    $(row).find(".btnDetallePedido").click(function (e) {
      btnActualDetallePedido = this;

      $("#btnSincronizarDetallePedido").addClass('d-none');
      if (data.estado == 'EP') {
        $("#btnSincronizarDetallePedido").removeClass('d-none');
      }

      $.ajax({
        type: "GET",
        url: `${rutaBase}DetallePedido/${data.id}`,
        dataType: 'json',
        success: function (pedido) {
          $("#modalDetallePedidoLabel").html(`Detalle Pedido ${pedido.pedido}`)

          $("#listacajasDetalle").html(`<div class="font-weight-bold text-center p-2 col-12">No se encontraron cajas</div>`);
          if (pedido.cajas.length) {
            let estructura = '';
            pedido.cajas.forEach((it, pos) => {
              estructura += `<div class="col-8 col-lg-3">
                <div class="card mb-2 item-caja" data-pos="${pos}" style="border-width: 3px !important;">
                  <div class="card-body" style="cursor: pointer;">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="card-title">
                        <i class="fa-solid fa-box mr-1"></i> ${it.numero_caja}
                      </h5>
                      <button class="btn btn-info btn-sm btn-info-caja" data-pos="${pos}">
                        <i class="fas fa-info"></i>
                      </button>
                    </div>
                    <p class="card-text">${it.nombreEmpacador}</p>
                  </div>
                </div>
              </div>`;
            });
            $("#listacajasDetalle").html(estructura);

            $("#inicioEmpaque").html(moment(pedido.inicio_empaque).format('DD/MM/YYYY hh:mm:ss A'))
            if (pedido.fin_empaque) {
              $("#finEmpaque").html(moment(pedido.fin_empaque).format('DD/MM/YYYY hh:mm:ss A'));
            } else {
              $("#finEmpaque").html('No hay datos');
            }
            if (pedido.fin_empaque) {
              $("#tiempoEmpaque").html(pedido.TiempoEmpaque);
            } else {
              $("#tiempoEmpaque").html('No hay datos');
            }

            $(".item-caja").on('click', function (e) {
              $(".item-caja").removeClass(['selected', 'border', 'border-info']);
              let caja = pedido.cajas[$(this).data('pos')];
              $(this).addClass('selected border border-info');

              $("#inicioEmpaqueCaja").html(moment(caja.inicio_empaque).format('DD/MM/YYYY hh:mm:ss A'));
              if (caja.fin_empaque) {
                $("#finEmpaqueCaja").html(moment(caja.fin_empaque).format('DD/MM/YYYY hh:mm:ss A'));
              } else {
                $("#finEmpaqueCaja").html('No hay datos');
              }
              if (caja.TiempoEmpaque) {
                $("#tiempoEmpaqueCaja").html(caja.TiempoEmpaque);
              } else {
                $("#tiempoEmpaqueCaja").html('No hay datos');
              }
              if (caja.infoCaja) {
                $("#totalReferenciasCaja").html(caja.infoCaja.TotalRef);
                $("#totalProductos").html(caja.infoCaja.Total);
              } else {
                $("#totalReferenciasCaja, #totalProductos").html('No hay datos')
              }
            });

            $(".btn-info-caja").on('click', function () {
              let caja = pedido.cajas[$(this).data('pos')];

              $.ajax({
                type: "GET",
                url: `${rutaBase}DetallePedidoCaja/${caja.id_pedido}/${caja.infoCaja.id_caja}`,
                dataType: 'json',
                success: function (productos) {
                  if (productos.length) {
                    let structureHtmlProds = '';
                    productos.forEach(prod => {
                      structureHtmlProds += `
                        <li role="button" class="list-group-item item-list-search pb-0" data-title="${prod.descripcion} ${prod.item} ${prod.referencia}">
                          <div class="d-flex justify-content-between">
                            <h5 class="mb-1">${prod.descripcion}</h5>
                            <small>${prod.item}</small>
                          </div>
                          <p class="mb-1">Ref: ${prod.referencia}</p>
                        </li>
                      `;
                    });
                    $("#boxProdsHtml").html(structureHtmlProds);
                  } else {
                    $("#boxProdsHtml").html(`<li id="no-hay-search" class="list-group-item text-center">No se encontraron productos</li>`);
                  }
                  $("#modalBoxProductsLabel").html(`<i class="fa fa-box mr-2"></i> ${caja.numero_caja}`);
                  $("#modalDetallePedido").modal('hide');
                  $("#modalBoxProducts").modal('show');

                  $("#modalBoxProducts").on('hidden.bs.modal', function () {
                    $("#modalDetallePedido").modal('show');
                  })
                }
              });

            });

            $(".item-caja:first").click()
          } else {
            $("#inicioEmpaque, #inicioEmpaqueCaja, #finEmpaqueCaja, #tiempoEmpaqueCaja, #totalReferenciasCaja, #totalProductos, #finEmpaque, #tiempoEmpaque").html('No hay datos')
          }
          $("#modalDetallePedido").modal('show');
        }
      });

      $("#btnImprimirDetallePedido").off('click').on('click', function () {
        window.open(base_url() + "Reportes/Empaque/" + data.id + "/0");
      });
    });

    $(row).find('.btnProductosReportados').on('click', function () {
      let dataModulo = {
        modulo: 'pedido',
        idRegistro: data.id
      }
      iniciarProductosReportados(dataModulo);
    });
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    estadoFiltro = $("#selectEstado").val();
    $(".btn-filtro-pedido").removeClass(['btn-lg', 'active']);
    $(`.btn-filtro-pedido[data-valor=${estadoFiltro}]`).addClass('btn-lg active');
    DT.ajax.reload();
  });

  $(".btn-filtro-pedido").on('click', function () {
    $(".btn-filtro-pedido").removeClass(['btn-lg', 'active']);
    $(this).addClass('btn-lg active');
    estadoFiltro = $(this).data('valor');
    $("#selectEstado").val(estadoFiltro)
    DT.ajax.reload();
  });

  $("#modalDetallePedido").on('hidden.bs.modal', function () {
    $("#listacajasPadre").css("height", ``);
  })

  $("#btnSincronizarDetallePedido").on('click', function () {
    $(btnActualDetallePedido).click();
  });
});

function alistarPedido(data) {
  let msj = (data.estado == 'PE' ? 'iniciar alistamiento para' : 'facturar');
  alertify.confirm('Advertencia', `¿Esta seguro de ${msj} el pedido <b>${data.pedido}</b>?`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + (data.estado == 'PE' ? "EstadoPedido" : "FacturarPedido"),
        dataType: 'json',
        data: {
          id: data.id,
          estado: (data.estado == 'PE' ? 'EP' : 'FA')
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DT.ajax.reload();
            if (data.estado == 'PE') {
              window.open(base_url() + "Reportes/Pedido/" + data.id + "/0");
            } else {
              window.open(base_url() + "Reportes/Factura/" + resp.id_factura);
            }
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    }, function () { });
}

function eliminar(data) {
  alertify.confirm('Advertencia', `Esta seguro de eliminar el pedido Nro <b>${data.pedido}</b>`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          id: data.id,
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
    }, function () { });
}

function buscarManifiestos(info) {
  $.ajax({
    type: "GET",
    url: rutaBase + "CajasManifiestos/" + info.id,
    dataType: 'json',
    success: function (resp) {
      if (resp.success) {
        let estructura = '';
        let { datos } = resp;

        if (datos.length > 5) {
          $("#listacajas").css("overflow-x", "scroll");
        } else {
          $("#listacajas").css("overflow-x", "unset");
        }

        datos.forEach((it, x) => {

          let ids = it.manifiestos.map((op, p) => op.id);
          let cajaManifiestos = 'C' + it.numeroCaja + '=' + ids.join('_')

          estructura += `<div class="list-group-item list-group-item-action lgicaja p-2">
              <div class="d-flex justify-content-between align-items-center h6-click" data-pos="${x}">
                <h6 class="mb-0 text-truncate w-75" style="cursor: pointer">
                  Caja ${it.numeroCaja}
                </h6>
                ${validPermissions(1082) ? `<input class="manifiestos-caja mr-3" id="verImg" type="checkbox" data-manifiestoscaja="${cajaManifiestos}">` : ''}
                ${validPermissions(1081) ? `<a href="${base_url()}Reportes/Manifiestos/${cajaManifiestos}" target="_blank" type="button" class="btn btn-info" title="Imprimir Manifiestos">
                  <i class="fa-solid fa-print"></i>
                </a>` : ''}
              </div>
            </div>
          `;
        });
        $('#listacajas').html(estructura);

        $(".lgicaja .h6-click").on('click', function () {
          let pos = $(this).data('pos');
          let info = '';
          datos[pos].manifiestos.forEach((op, p) => {
            info += `<div class="list-group-item list-group-item-action p-2">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-0 text-truncate h6-click w-75">
                    ${op.nombre}
                  </h6>
                </div>
              </div>
            `;
          });
          $(".lgicaja").removeClass("active");
          $('#listamanifiestos').html(info);
          $(this).parents(".lgicaja").addClass("active");
        });

        $("input.manifiestos-caja").on('change', function () {
          if ($("input.manifiestos-caja:checked").length) {
            $("#btn-imprimir-multiple-manifiesto").removeClass('d-none')
          } else {
            $("#btn-imprimir-multiple-manifiesto").addClass('d-none')
          }
        });

        $(".lgicaja .h6-click").first().click();

        $("#btn-imprimir-multiple-manifiesto").on('click', function () {
          if ($("input.manifiestos-caja:checked").length) {
            let cajasManifiestos = $.map($("input.manifiestos-caja:checked"), function (item) {
              return $(item).data('manifiestoscaja')
            });
            window.open(`${base_url()}Reportes/Manifiestos/${cajasManifiestos.join("*")}`, "_blank");
          } else {
            alertify.warning("No se han seleccionado cajas");
          }
        });

        $("#btn-imprimir-manifiesto-sin-repetir").off('click').on('click', function () {
          window.open(`${base_url()}Reportes/ManifiestosSinRepetir/${info.id}`, "_blank");
        });

        $("#modalManifiestos").modal('show');
      } else {
        alertify.error(resp.msj);
      }
    }
  });
}

alertify.imprimirRotulo || alertify.dialog('imprimirRotulo', function () {
  return {
    main: function (onok, oncancel) {
      this.set('title', "Imprimir rotulo");
      this.setContent($('#formRotulo')[0]);
      this.set('onok', onok);
      this.set('oncancel', oncancel);
    },
    setup: function () {
      return {
        buttons: [
          {
            text: alertify.defaults.glossary.ok,
            key: 13,
            className: alertify.defaults.theme.ok,
          },
          {
            text: alertify.defaults.glossary.cancel,
            key: 27,
            invokeOnClose: true,
            className: alertify.defaults.theme.cancel,
          }
        ],
        //focus: { element:0 },
        focus: {
          element: function () {
            return this.elements.body.querySelector(this.get('selector'));
          },
          select: true
        },
        options: {
          maximizable: false,
          resizable: false,
        }
      };
    },
    settings: {
      selector: undefined,
      onok: null,
      oncancel: null
    },
    callback: function (closeEvent) {
      var returnValue;
      switch (closeEvent.index) {
        case 0:
          if (typeof this.get('onok') === 'function') {
            returnValue = this.get('onok').call(this, closeEvent);
            if (typeof returnValue !== 'undefined') {
              closeEvent.cancel = !returnValue;
            }
          }
          break;
        case 1:
          if (typeof this.get('oncancel') === 'function') {
            returnValue = this.get('oncancel').call(this, closeEvent);
            if (typeof returnValue !== 'undefined') {
              closeEvent.cancel = !returnValue;
            }
          }
          break;
      }
    },
  };
});

function despacharPedido(data) {
  alertify.confirm('Advertencia', `¿Esta seguro de despachar el pedido <b>${data.pedido}</b>?`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "EstadoPedido",
        dataType: 'json',
        data: {
          id: data.id,
          estado: 'DE'
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
    }, function () { });
}