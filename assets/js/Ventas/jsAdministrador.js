let rutaBase = base_url() + "Ventas/";

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
  },
  order: [[0, "desc"]],
  scrollX: true,
  columns: [
    { data: 'codigo' },
    { data: 'NombreCliente' },
    { data: 'NombreSucursal' },
    { data: 'Ciudad' },
    { data: 'metodo_pago' },
    {
      data: 'neto',
      className: 'text-right',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.neto);
      }
    },
    {
      data: 'total',
      className: 'text-right',
      render: function (meta, type, data, meta) {
        return formatoPesos.format(data.total);
      }
    },
    { data: 'NombreVendedor' },
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
          <a href="${base_url()}Reportes/Factura/${data.id}/1" target="_blank" type="button" class="btn btn-info" title="Imprimir factura"><i class="fa-solid fa-print"></i></a>
          ${data.id_pedido != null ?
            `<a href="${base_url()}Reportes/Pedido/${data.id_pedido}/0" target="_blank" type="button" class="btn btn-success" title="Imprimir pedido"><i class="fa-solid fa-check-to-slot"></i></a>` : ``
          }
          <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
          ${data.id_pedido == null ?
            `<button type="button" class="btn btn-danger btnEliminar" title="Eliminar"><i class="fa-regular fa-trash-can"></i></button>` : ``
          }
          <button type="button" class="btn btn-info btnImprimirQR" title="Código QR">
            <i class="fa-solid fa-qrcode"></i>
          </button>
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
      window.location.href = base_url() + 'Ventas/Editar/' + data.id.trim();
    });

    $(row).find(".btnImprimirQR").click(function (e) {
      e.preventDefault();
      $.ajax({
        type: "GET",
        url: `${base_url()}Pedidos/GenerarQR/${data.id}`,
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
  }
});

function eliminar(data) {
  alertify.confirm('Advertencia', `Esta seguro de eliminar la venta Nro <b>${data.codigo}</b>`,
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