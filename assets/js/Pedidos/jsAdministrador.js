let rutaBase = base_url() + "Pedidos/";
let limiteRotulo = 1000;

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": $("#selectEstado").val() })
    }
  },
  order: [[0, "desc"]],
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
          /* Conpermiso y tenga factura */
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
  }
});

$(function () {
  $("#selectEstado").on("change", function () {
    DT.ajax.reload();
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

          estructura += `<div class="list-group-item list-group-item-action lgicaja p-2">
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-truncate h6-click w-75" style="cursor: pointer" data-pos="${x}">
                  Caja ${it.numeroCaja}
                </h6>
                ${validPermissions(1081) ? `<a href="${base_url()}Reportes/Manifiestos/${ids.join('_')}" target="_blank" type="button" class="btn btn-info" title="Imprimir Manifiestos">
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
          $('#listamanifiestos').html(info);
        });

        $(".lgicaja .h6-click").first().click();

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