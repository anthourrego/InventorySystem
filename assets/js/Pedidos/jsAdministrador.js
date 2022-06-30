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
    { data: 'NombreEstado' },
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
            <!-- <a href="${base_url()}Reportes/Factura/${data.id}" target="_blank" type="button" class="btn btn-info" title="Imprmir factura">
              <i class="fa-solid fa-print"></i>
            </a> -->
            ${data.estado == 0
            ? `<button type="button" class="btn btn-success btnConfirmarPedido" title="Alistar Pedido">
                <i class="fa-solid fa-check"></i>
              </button>`
            : `<a href="${base_url()}Reportes/Pedido/${data.id}" target="_blank" type="button" class="btn btn-info" title="Imprmir pedido">
                <i class="fa-solid fa-check-to-slot"></i>
              </a>`}
            <button type="button" class="btn btn-secondary btnEditar" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button type="button" class="btn btn-danger btnEliminar" title="Eliminar">
              <i class="fa-regular fa-trash-can"></i>
            </button>
          </div>
        `;
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
  }
});

function alistarPedido(data) {
  alertify.confirm('Advertencia', `Esta seguro de iniciar alistamiento para el pedido <b>${data.pedido}</b>`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "EstadoPedido",
        dataType: 'json',
        data: {
          id: data.id,
          estado: 1
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