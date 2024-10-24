let rutaBase = `${base_url()}CuentasCobrar/`;
let optionBillSelected = {};
let filtroFacturas = {};
let DTCuentasCobrar = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "type": $("#selectTipoFacturas").val() })
    }
  },
  order: [[0, "desc"]],
  scrollX: true,
  columns: [
    {
      data: 'codigo',
      render: function (meta, type, data, meta2) {
        console.log('data', data)
        if (data.id_pedido > 0) {
          return data.codigo;
        }
        return `<div class="d-flex align-items-center"><i class="fa-solid fa-tag text-info mr-2" style="transform: rotate(90deg);"></i>${data.codigo}</div>`;
      }
    }, {
      data: 'NombreCliente',
      render: function (meta, type, data, meta2) {
        return `${data.NombreCliente} | ${data.NombreSucursal}`;
      }
    }, {
      data: 'NombreVendedor',
      className: 'text-center'
    }, {
      data: 'descuento',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.descuento);
      }
    }, {
      data: 'total',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.total);
      }
    }, {
      data: 'AbonosVenta',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.AbonosVenta);
      }
    }, {
      data: 'ValorPendiente',
      render: function (meta, type, data, meta2) {
        return formatoPesos.format(data.ValorPendiente);
      }
    },
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
    }, {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (meta, type, data, meta2) {

        let botones = ``;

        botones += validPermissions(1001) ? `<button type="button" class="btn btn-primary btnAgregar" title="Ver"><i class="fa-solid fa-plus"></i></button>` : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        botones += validPermissions(1004) ? `<a href="${base_url()}Reportes/CuentaCobrar/${data.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Abonos">
          <i class="fa-solid fa-print"></i>
        </a>` : '';

        botones += validPermissions(1006) ? `<a href="${base_url()}Reportes/ReciboCaja/${data.id}/0" target="_blank" type="button" class="btn btn-secondary" title="Imprimir Recibos Caja">
          <i class="fa-solid fa-money-check"></i>
        </a>` : '';

        return `<div class="btn-group btn-group-sm" role="group">${botones}</div>`;
      }
    }
  ],
  createdRow: function (row, data, dataIndex) {

    $(row).css({ 'background-color': getColorBill(+data.ValorPendiente, +data.total) })

    //Editar
    $(row).find(".btnVer, .btnAgregar").click(function (e) {
      e.preventDefault();

      let $btn = $(this);

      $.ajax({
        type: "GET",
        url: rutaBase + "ObtenerCuentaCobrar/" + data.id,
        dataType: 'json',
        success: function ({ venta, accountsBill }) {

          if ($btn.hasClass('btnVer')) {
            $("#modalCrearEditarAbonosLabel").html(`<i class="fa-solid fa-eye"></i> Factura ${venta.codigo}`);
            $("#formAddAbono").addClass('d-none');
          } else {
            $("#modalCrearEditarAbonosLabel").html(`<i class="fa-solid fa-edit"></i> Factura ${venta.codigo}`);
            $("#formAddAbono").removeClass('d-none');

            if (data.ValorPendiente <= 0) {
              $("#formAddAbono").addClass('d-none');
            }
          }
          optionBillSelected = data;
          setValuesAccounts(accountsBill);

          $("#clienteFactura").html(venta.NombreCliente);
          $("#vendedorFactura").html(venta.NombreVendedor);
          $("#metodoPagoFactura").html((venta.metodo_pago == '2' ? 'Credito' : 'Contado'));
          $("#fechaCreacionFactura").html(moment(venta.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
          $("#fechaVencimientoFactura").html(venta.FechaVencimiento);
          $("#descuentoFactura").html(formatoPesos.format(venta.descuento));
          $("#totalFactura").html(formatoPesos.format(venta.total));
          $("#totalAbonosFactura").html(formatoPesos.format(venta.AbonosVenta));
          $("#valorPendienteFactura").html(formatoPesos.format(venta.ValorPendiente));

          $("#modalAgregarAbono").modal('show');
        }
      });
    });
  }
});

let DTDataAccountsBill = $("#tblAbonos").DataTable({
  scrollX: true,
  data: [],
  order: [],
  pageLength: 5,
  processing: false,
  serverSide: false,
  search: {
    return: false,
  },
  columns: [{
    data: 'codigo'
  }, {
    data: 'valor',
    render: function (meta, type, data, meta2) {
      return formatoPesos.format(data.valor);
    }
  }, {
    data: 'estado',
    className: 'text-center',
    render: function (meta, type, data, meta2) {
      let color = "success";
      if (data.estado == 'AN') {
        color = "danger";
      }
      return `<button class="btn btn-${color}">${data.Descripcion_Estado}</button>`;
    }
  }, {
    data: 'observacion',
    width: "30%",
    render: function (meta, type, data, meta2) {
      return `<span title="${data.observacion}" class="text-descripcion">${data.observacion}</span>`;
    }
  },
  {
    data: 'created_at',
    render: function (meta, type, data, meta2) {
      return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
    }
  }, {
    data: 'NombreUsuario'
  }, {
    data: 'Acciones',
    orderable: false,
    searchable: false,
    defaultContent: '',
    className: 'text-center actions-product-buy noExport',
    render: function (meta, type, data, meta2) {
      let buttons = ``;

      buttons += validPermissions(1002) ? `<button type="button" class="btn btn-danger btnEliminar" title="Anular Abono"><i class="fa-solid fa-trash"></i></button>` : '';

      buttons += validPermissions(1003) ? `<a href="${base_url()}Reportes/CuentaCobrar/${optionBillSelected.id}/${data.id}" target="_blank" type="button" class="btn btn-info" title="Imprimir Abono">
        <i class="fa-solid fa-print"></i>
      </a>` : '';

      buttons += validPermissions(1005) ? `<a href="${base_url()}Reportes/ReciboCaja/${optionBillSelected.id}/${data.id}" target="_blank" type="button" class="btn btn-secondary" title="Imprimir Recibo Caja">
        <i class="fa-solid fa-money-check"></i>
      </a>` : '';

      return `<div class="btn-group btn-group-sm" role="group">${buttons}</div>`;
    }
  }],
  createdRow: function (row, data, dataIndex) {
    $(row).find(".btnEliminar").click(function (e) {
      e.preventDefault();

      alertify.confirm('Anular compra', `Esta seguro de anular el abono <b>${data.codigo}</b>?`, function () {
        $.ajax({
          type: "POST",
          url: rutaBase + "Anular",
          dataType: 'json',
          data: {
            idVenta: optionBillSelected.id,
            idAbonoVenta: data.id
          },
          success: function ({ success, msj, info }) {
            if (success) {
              alertify.success(msj);
              setValuesAccounts(info.accountsBill)
              
              $("#valorPendienteFactura").html(formatoPesos.format(info.venta.ValorPendiente));

              if (+info.venta.ValorPendiente > 0) {
                optionBillSelected.ValorPendiente = info.venta.ValorPendiente;
                $("#formAddAbono").removeClass('d-none');
              }
            } else {
              alertify.error(msj);
            }
          }
        });
      }, function () { });
    });
  }
});

$(function () {

  $("#formAddAbono").submit(function (e) {
    e.preventDefault();

    if ($(this).valid()) {
      let dataProd = {
        valor: $("#valor").val().replace("$ ", '').split(",").join(''),
        observacion: $("#observacion").val(),
        idVenta: optionBillSelected.id,
        tipoAbono: $("#tipoAbono").val()
      }

      if (+dataProd.valor <= 0) {
        alertify.warning("El valor ingresado no puede ser 0 o negativo");
        return
      }

      if (+optionBillSelected.ValorPendiente <= 0) {
        alertify.warning("El saldo pendiente esta en 0");
        return
      }

      if (+dataProd.valor > +optionBillSelected.ValorPendiente) {
        alertify.warning("El valor ingresado es superior al saldo pendiente");
        return
      }

      $.ajax({
        type: "POST",
        url: rutaBase + "Crear",
        dataType: 'json',
        data: dataProd,
        success: function ({ msj, success, info }) {
          if (success) {
            alertify.success(msj);
            setValuesAccounts(info.accountsBill)

            $("#valor, #observacion").val('')
            $("#valorPendienteFactura").html(formatoPesos.format(info.venta.ValorPendiente));

            if (+info.venta.ValorPendiente <= 0) {
              optionBillSelected.ValorPendiente = info.venta.ValorPendiente;
              $("#formAddAbono").addClass('d-none');
            }
          } else {
            alertify.error(msj);
          }
        }
      });
    }
  });

  $('#modalAgregarAbono').on('hidden.bs.modal', function (event) {
    DTCuentasCobrar.ajax.reload();
  });

  $("#selectTipoFacturas").on('change', function () {
    DTCuentasCobrar.ajax.reload();
  })
});

function setValuesAccounts(accountsBill) {
  DTDataAccountsBill.clear().rows.add(accountsBill);
  setTimeout(() => {
    DTDataAccountsBill.draw();
  }, 200);
}

function getColorBill(valorPendiente, valorTotal) {
  if (valorPendiente <= 0) {
    return "#8ae287";
  }
  if (valorTotal == valorPendiente) {
    return "#ffffff";
  }
  return "#98c0f6";
}
