btnConfirmProductosReportados = false;
if ($MODULOPRODUCTOSREPORTADOS == 'general' && validPermissions(6001)) btnConfirmProductosReportados = true;

if ($MODULOPRODUCTOSREPORTADOS == 'pedido' && validPermissions(1121)) btnConfirmProductosReportados = true;

if ($MODULOPRODUCTOSREPORTADOS == 'producto' && validPermissions(51001)) btnConfirmProductosReportados = true;

if ($MODULOPRODUCTOSREPORTADOS == 'factura' && validPermissions(6201)) btnConfirmProductosReportados = true;

$("body").append($("#modalConfrontarProductoReportado"));

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
      data: 'referenciaItem',
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
      data: 'cantidadReportada'
    },
    {
      data: 'createdAt'
    },
    {
      data: 'motivo',
      render: function (meta, type, data, meta) {
        return getMotiveProdReportedModule(data.motivo);
      }
    },
    {
      data: 'observacion'
    },
    {
      data: 'fechaConfirmado'
    },
    {
      data: 'cantidadConfirmada',
      render: function (meta, type, data, meta) {
        return data.fechaConfirmado ? data.cantidadConfirmada : '';
      }
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      visible: btnConfirmProductosReportados,
      className: 'text-center noExport',
      render: function (meta, type, data, meta) {
        return `<div class="btn-group btn-group-sm" role="group">
          ${btnConfirmProductosReportados && !data.fechaConfirmado ? '<button type="button" class="btn btn-secondary btnConfirmProductoReported" title="Confrontar"><i class="fa-solid fa-eye"></i></button>' : ''}
        </div>`;
      }
    }
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnConfirmProductoReported").on('click', function () {

      $("#referProdReported").val(data.referenciaItem);
      $("#descripProdReported").val(data.descripcion);
      $("#quantityProdReported").val(data.cantidadReportada);
      $("#motiveProdReported").val(getMotiveProdReportedModule(data.motivo));
      $("#descriptionProdReported").val(data.observacion);

      if (['general', 'producto', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)) {
        $("#fieldModalOrderProdReported").show();
        $("#orderProdReported").val(data.codigoPedido);
      } else {
        $("#fieldModalOrderProdReported").hide();
      }

      if (['producto', 'pedido', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)) {
        $("#modalProductosReportados").modal("hide");
        setTimeout(() => {
          $("#modalConfrontarProductoReportado").modal('show');
        }, 100);
      } else {
        $("#modalConfrontarProductoReportado").modal('show');
      }
      
      $('#modalConfrontarProductoReportado').off().on('shown.bs.modal', function (event) {

        $("#formProdReportedConfirm").off().submit(function (e) {
          e.preventDefault();

          let quantityProdReported = +$("#quantityProdReported").val();

          if (quantityProdReported < 0) {
            return alertify.error("No es valido un número negativo. Recuerda que se reportaron " + data.cantidadReportada + " productos");
          }

          if (quantityProdReported > +data.cantidadReportada) {
            return alertify.error("La cantidad ingresa es mayor a la cantidad reportada. Recuerda que se reportaron " + data.cantidadReportada + " productos");
          }

          let formDataProdReported = new FormData();
          formDataProdReported.set('cantidadConfirmada', data.cantidadReportada - quantityProdReported);
          formDataProdReported.set('cantidadReportada', quantityProdReported);
          formDataProdReported.set("idObservacionProducto", data.idObservacionProducto);
          formDataProdReported.set("idProducto", data.idProducto);

          $.ajax({
            url: base_url() + "ProductosReportados/Confirmar",
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            data: formDataProdReported,
            success: function (resp) {
              if (resp.success) {
                alertify.success(resp.msj);
                $(".btnCloseModalProdReported").click();
                setTimeout(() => {
                  $("#tableProdsReported").DataTable().ajax.reload();
                }, 200);
              } else {
                alertify.alert('¡Advertencia!', resp.msj);
              }
            }
          });
        });

      });

      $(".btnCloseModalProdReported").off().on('click', function () {
        if (['producto', 'pedido', 'factura'].includes($MODULOPRODUCTOSREPORTADOS)) {
          $("#modalConfrontarProductoReportado").modal('hide');
          setTimeout(() => {
            $("#modalProductosReportados").modal("show");
          }, 100);
        } else {
          $("#modalConfrontarProductoReportado").modal('hide');
        }
      });
    });
  }
});

function getMotiveProdReportedModule(motive) {
  return $DATAMOTIVOSMODULEPRODUSREPORTED.find(motivo => motivo.valor == motive).titulo;
}

function quantityProdReportedModule(add) {
  let value = +$("#quantityProdReported").val();
  value = (add ? (value + 1) : (value - 1));
  $("#quantityProdReported").val("" + value);
}