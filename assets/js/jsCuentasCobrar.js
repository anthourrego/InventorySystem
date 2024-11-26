let rutaBase = `${base_url()}CuentasCobrar/`;
let optionBillSelected = {};
let sucursales = [];
let filtrosConfig = {
  type: "-1",
  branches: "",
  branchesName: ""
};
let DTCuentasCobrar = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, filtrosConfig)
    }
  },
  order: [[0, "desc"]],
  scrollX: true,
  buttons: buttonsDT(["collection", "print", "pageLength"], [
    /* {
      text: '<i class="fa-solid fa-filter"></i>',
      className: 'btn-dark',
      attr: { title: "Filtrar", "data-toggle": "tooltip" },
      action: function (e, dt, node, config) {
        $("#modalFilter").modal("show");
      }
    } */
  ]),
  columns: [
    {
      data: 'codigo',
      render: function (meta, type, data, meta2) {
        if (data.id_pedido > 0) {
          return data.codigo;
        }
        return `<div class="d-flex align-items-center"><i class="fa-solid fa-tag text-info mr-2" style="transform: rotate(90deg);"></i>${data.codigo}</div>`;
      }
    }, 
    { data: 'NombreCliente'}, 
    { data: 'Sucursal'}, 
    { data: 'Ciudad'}, 
    {
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
      data: 'FechaVencimiento',
      render: function (meta, type, data, meta2) {
        return moment(data.FechaVencimiento, "YYYY-MM-DD").format("DD/MM/YYYY");
      }
    },
    {
      data: 'created_at',
      render: function (meta, type, data, meta2) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {
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
    $(row).css({ 'background-color': getColorBill(+data.ValorPendiente, data.FechaVencimiento, data.AbonosVenta) })

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
  },{
    data: 'tipo_abono',
    render: function (meta, type, data, meta2) {
      return TIPOSABONO.find(tipo => tipo.valor === data.tipo_abono)?.titulo;
    }
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

            optionBillSelected.ValorPendiente = info.venta.ValorPendiente;

            if (+info.venta.ValorPendiente <= 0) {
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

  $("#sucursal").select2({
    ajax: {
      url: base_url() + "Busqueda/SucursalesClientes",
      type: "POST",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var query = {
          cliente: $("#cliente").val(),
          search: params.term,
          page: params.page || 1,
          _type: "query_append",
        }
        return query;
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        sucursales = data.data;
        return {
          results: data.data,
          pagination: {
            more: (params.page * 10) < data.total_count
          }
        };
      },
      async: false,
      cache: true
    }
  });

  $("#btnFilter").on("click", (e) => {
    branchesName = filtrosConfig.branchesName;
    if ($("#sucursal").val() != filtrosConfig.branches) {
      branchesName = (sucursales.length ? sucursales.find(x => x.id == $("#sucursal").val()).text : "")
    }
    
    filtrosConfig = {
      type: $("#selectTipoFacturas").val(),
      branches: $("#sucursal").val(),
      branchesName
    };
    DTCuentasCobrar.ajax.reload();
    $("#modalFilter").modal("hide");
  });

  document.querySelectorAll(".btn-fast-filter").forEach(button => {
    button.addEventListener("click", function () {
      //Removemos la clase de todos los botones
      document.querySelectorAll(".btn-fast-filter").forEach(button => {
        button.classList.remove("btn-lg");
      });
      const newFilter = this.getAttribute("data-filter");
      this.classList.add("btn-lg");
      filtrosConfig.type = newFilter.toString();
      resetFilter(true);
    });
  });

  $('#modalFilter').on('show.bs.modal', function (event) {
    resetFilter(false);
  });

  $("#reiniciarFiltros").on("click", function() {
    filtrosConfig = {
      type: "-1",
      branches: "",
      branchesName: ""
    }
    resetFilter(true);
  });

});

function setValuesAccounts(accountsBill) {
  DTDataAccountsBill.clear().rows.add(accountsBill);
  setTimeout(() => {
    DTDataAccountsBill.draw();
  }, 200);
}

function getColorBill(valorPendiente, fechaVencimiento, abonosVenta) {
  if (moment(fechaVencimiento, "YYYY-MM-DD").isBefore(moment()) && abonosVenta > 0) {
    return "#f7b267";
  } else if (moment(fechaVencimiento, "YYYY-MM-DD").isBefore(moment())) {
    return "#f6a8a8";
  } else if (valorPendiente <= 0) {
    return "#8ae287";
  } else if (abonosVenta == 0) {
    return "#ffffff";
  } else if (abonosVenta > 0) {
    return "#98c0f6";
  }

  return "#f4f6f9";
}

const resetFilter = (reload = true) => {
  var sucursalOption = new Option(filtrosConfig.branchesName, filtrosConfig.branches, true, true);
  $('#sucursal').append(sucursalOption).trigger('change');
  $("#selectTipoFacturas").val(filtrosConfig.type);

  if (reload === true) {
    DTCuentasCobrar.ajax.reload();
    $("#modalFilter").modal("hide");
  }
}