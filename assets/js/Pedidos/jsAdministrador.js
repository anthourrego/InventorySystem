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
        return `<div class="btn-group btn-group-sm" role="group">
                  <a href="${base_url()}Reportes/Factura/${data.id}" target="_blank" type="button" class="btn btn-info" title="Imprmir factura"><i class="fa-solid fa-print"></i></a>
                  <a href="${base_url()}Reportes/Pedido/${data.id}" target="_blank" type="button" class="btn btn-success" title="Imprmir pedido"><i class="fa-solid fa-check-to-slot"></i></a>
                  <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button type="button" class="btn btn-danger btnEliminar" title="Eliminar"><i class="fa-regular fa-trash-can"></i></button>
                </div>`;
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
  }
});

function eliminar(data) {
  alertify.confirm('Advertencia', `Esta seguro de eliminar el pedido Nro <b>${data.codigo}</b>`,
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