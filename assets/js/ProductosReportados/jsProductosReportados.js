btnConfirmProductosReportados = false;
if ($MODULOPRODUCTOSREPORTADOS == 'general' && validPermissions(6001)) btnConfirmProductosReportados = true;

if ($MODULOPRODUCTOSREPORTADOS == 'pedido' && validPermissions(1121)) btnConfirmProductosReportados = true;

if ($MODULOPRODUCTOSREPORTADOS == 'producto' && validPermissions(51001)) btnConfirmProductosReportados = true;

if ($MODULOPRODUCTOSREPORTADOS == 'factura' && validPermissions(6201)) btnConfirmProductosReportados = true;

$("#tableProdsReported").DataTable({
  ajax: {
    url: base_url() + "ProductosReportados/DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, {
        filtro: {
          modulo: $MODULOPRODUCTOSREPORTADOS,
          valor: $IDREGISTROPRODUCTOSREPORTADOS
        }
      })
    }
  },
  order: [],
  scrollX: true,
  columns: [
    {
      data: 'item',
      visible: ['general', 'pedido', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)
    },
    {
      data: 'referencia',
      visible: ['general', 'pedido', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)
    },
    {
      data: 'descripcion',
      visible: ['general', 'pedido', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)
    },
    {
      data: 'codigoPedido',
      visible: ['general', 'producto', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)
    },
    {
      data: 'cantidadProductoPedido'
    },
    {
      data: 'cantidadReportada'
    },
    {
      data: 'createdAt'
    },
    {
      data: 'observacion'
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      visible: btnConfirmProductosReportados,
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        return `<div class="btn-group btn-group-sm" role="group">
          ${btnConfirmProductosReportados ? '<button type="button" class="btn btn-info btnConfirmProductoReported" title="Editar"><i class="fa-solid fa-check"></i></button>' : ''}
        </div>`;
      }
    }
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnConfirmProductoReported").on('click', function () {
      alertify.warning("Nos encontramos en proceso de construcción");
    });
  }
});