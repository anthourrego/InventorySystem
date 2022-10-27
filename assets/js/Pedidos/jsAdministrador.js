let rutaBase = base_url() + "Pedidos/";
let limiteRotulo = 1000;

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
      className: 'text-center align-middle',
      render: function (meta, type, data, meta) {
        let color = "success";
        let facturado = (data.idFactura && data.idFactura > 0);
        if (!facturado) {
          if (data.estado == 0) {
            color = "primary";
          } else if (data.estado == 1) {
            color = "secondary";
          } else if (data.estado == 2) {
            color = "info";
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
        let estado = 'Facturar';
        let color = 'success';
        if (data.estado == 0) {
          estado = 'Enviar Alistamiento';
          color = 'warning';
        }
        let botones = '';
        let facturado = (data.idFactura && data.idFactura > 0);

        /* Si es para alistamiento o si no tiene factura y ya esta empacado */
        if ((data.estado == 0 && validPermissions(104)) || (!facturado && data.estado == 2 && validPermissions(105))) {
          botones += `<button type="button" class="btn btn-${color} btnConfirmarPedido" title="${estado} Pedido">
            <i class="fa-solid ${data.estado == 0 ? 'fa-boxes-stacked' : 'fa-receipt'}"></i>
          </button>`;
        }

        /* Tiene permiso de imprimir */
        if (validPermissions(106)) {
          botones += `<a href="${base_url()}Reportes/Pedido/${data.id}" target="_blank" type="button" class="btn btn-info" title="Imprimir Pedido">
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

        /* Si esta empacado o facturado y si tiene permiso de imprimir el rotulo */
        if (data.estado >= 2 && validPermissions(107)) {
          botones += `<button type="button" class="btn btn-dark btnImprimirRotulo" title="Imprimir rotulo">
            <i class="fa-solid fa-tags"></i>
          </button>`;
        }

        return `<div class="btn-group btn-group-sm" role="group">${botones}</div>`;
      }
    },
  ],
  createdRow: function (row, data, dataIndex) {
    console.log(data);
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
      if (!data.TotalCajas) {
        alertify.prompt('Impresión', 'Número de cajas disponibles?', '1', function (evt, value) {
          if (value > 0) {
            if (value <= limiteRotulo) {
              setTimeout(() => {
                observacionRotulo(value, data);
              }, 0);
            } else {
              alertify.warning('El limite permitido es ' + limiteRotulo);
              setTimeout(() => {
                $(context).click();
              }, 0);
            }
          } else {
            alertify.warning('Ingrese una cantidad valida');
            setTimeout(() => {
              $(context).click();
            }, 0);
          }
        }, function () { }).setting({
          'type': 'number'
        });
      } else {
        observacionRotulo(+data.TotalCajas, data);
      }
    });
  }
});

function observacionRotulo(value, data) {
  alertify.prompt('Impresión', 'Observación', '', function (evt, observa) {
    if (observa != '') {
      observa = observa.split(' ').join('_');
      window.open(`${base_url()}Reportes/Rotulo/${data.id.trim()}/${value}?observacion=${observa}`, '_blank');
    } else {
      window.open(`${base_url()}Reportes/Rotulo/${data.id.trim()}/${value}`, '_blank');
    }
  }, function () { }).setting({
    'type': 'text'
  });
}

function alistarPedido(data) {
  let msj = (data.estado == 0 ? 'iniciar alistamiento para' : 'facturar');
  alertify.confirm('Advertencia', `¿Esta seguro de ${msj} el pedido <b>${data.pedido}</b>?`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + (data.estado == 0 ? "EstadoPedido" : "FacturarPedido"),
        dataType: 'json',
        data: {
          id: data.id,
          estado: (data.estado == 0 ? 1 : 3)
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
            DT.ajax.reload();
            if (data.estado == 0) {
              window.open(base_url() + "Reportes/Pedido/" + data.id);
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