let rutaBase = base_url() + "Pedidos/";

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
  },
  columns: [
    { data: 'pedido' },
    { data: 'NombreCliente' },
    { data: 'NombreVendedor' },
    { data: 'NombreSucursal' },
    { data: 'direccion' },
    { 
      data: 'NombreEstado',
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
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        return `
          <div class="btn-group btn-group-sm" role="group">
            ${(data.estado == 0 && validPermissions(104)) || (data.estado == 1 && validPermissions(105))
            ? `<button type="button" class="btn btn-${data.estado == 0 ? 'warning' : 'success'} btnConfirmarPedido" title="${data.estado == 0 ? 'Alistar' : 'Facturar'} Pedido">
              <i class="fa-solid ${data.estado == 0 ? 'fa-boxes-stacked' : 'fa-receipt'}"></i>
              </button>`
            : ``}
            ${validPermissions(106) ? `<a href="${base_url()}Reportes/Pedido/${data.id}" target="_blank" type="button" class="btn btn-info" title="Imprimir pedido">
            <i class="fa-solid fa-print"></i>
          </a>` : ''}
            ${data.estado == 2
              ? `<button type="button" class="btn btn-secondary btnEditar" title="Ver">
                <i class="fa-solid fa-eye"></i>
              </button>`
              : (validPermissions(102) ? `<button type="button" class="btn btn-secondary btnEditar" title="Editar">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>` : `<button type="button" class="btn btn-secondary btnEditar" title="Ver">
              <i class="fa-solid fa-eye"></i>
            </button>`)}

            ${data.estado != 2 && validPermissions(103)
              ? `<button type="button" class="btn btn-danger btnEliminar" title="Eliminar">
              <i class="fa-regular fa-trash-can"></i>
            </button>` :
            ''
            }
            
          </div>
        `;
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
  }
});

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
          estado: (data.estado == 0 ? 1 : 2)
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
    }, function () {});
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