let rutaBase = base_url() + "Ventas/";

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
  },
  order: [[8, "desc"]],
  scrollX: true,
  columns: [
    { data: 'codigo' },
    { data: 'NombreCliente' },
    { data: 'NombreSucursal' },
    { data: 'Ciudad' },
    { data: 'metodo_pago' },
    {
      data: 'descuento',
      className: 'text-right',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.descuento);
      }
    },
    {
      data: 'total',
      className: 'text-right',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.total);
      }
    },
    {
      data: 'totalMenosDescuento',
      className: 'text-right',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(+data.total - (+data.descuento));
      }
    },
    { data: 'NombreVendedor' },
    {
      data: 'created_at',
      render: function (meta, type, data, meta2) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {
      data: 'FechaVencimiento',
      render: function (meta, type, data, meta2) {
        return moment(data.FechaVencimiento, "YYYY-MM-DD").format("DD/MM/YYYY");
      }
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta2) {
        return `<div class="btn-group btn-group-sm" role="group">
          <a href="${base_url()}Reportes/Factura/${data.id}/1" target="_blank" type="button" class="btn btn-info" title="Imprimir factura"><i class="fa-solid fa-print"></i></a>
          ${data.id_pedido != null ?
            `<a href="${base_url()}Reportes/Pedido/${data.id_pedido}/0" target="_blank" type="button" class="btn btn-success" title="Imprimir pedido"><i class="fa-solid fa-check-to-slot"></i></a>` : ``
          }
          <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
          ${data.id_pedido == null ?
            `<button type="button" class="btn btn-danger btnEliminar" title="Eliminar"><i class="fa-regular fa-trash-can"></i></button>` : ``
          }
          <button type="button" class="bt btn-inf btnImprimirQR d-none" title="Código QR">
            <i class="fa-solid fa-qrcode"></i>
          </button>

          ${validPermissions(62) && data.TotalProductosReportados > 0 ? `<button type="button" class="btn btn-dark btnProductosReportados" title="Producto Reportado">
            <i class="fa-solid fa-exclamation-triangle"></i>
          </button>` : ''}
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

    $(row).find('.btnProductosReportados').on('click', function () {
      let dataModulo = {
        modulo: 'factura',
        idRegistro: data.id
      }
      iniciarProductosReportados(dataModulo);
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
          codigo: data.codigo
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