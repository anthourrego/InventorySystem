let dataFiltro = {
    tipo: -1,
    cantidadInicial: '',
    cantidadFinal: '',
    fechaInicial: '',
    fechaFinal: ''
}

let DTMovimientos = $("#tblReporteInventario").DataTable({
    ajax: {
        url: base_url() + "ReporteInventario/DT",
        type: "POST",
        data: function (d) {
            return $.extend(d, { ...dataFiltro })
        }
    },
    order: [],
    scrollX: true,
    columns: [
        {
            data: 'referenciaItem',
        },
        {
            data: 'descripcion',
        },
        {
            data: 'cantidad',
        },
        {
            data: 'descripcionTipo',
            searchable: false,
            className: 'text-center align-middle',
            render: function (meta, type, data, meta2) {
                let color = "success";
                if (data.tipo == 'S') {
                    color = "warning";
                }
                return `<button class="btn btn-${color}">${data.descripcionTipo}</button>`;
            }
        },
        {
            data: 'observacion'
        },
        {
            data: 'Fecha_Creacion',
            render: function (meta, type, data, meta2) {
                return moment(data.Fecha_Creacion, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
            }
        },
        {
            data: 'Nombre_Usuario'
        },
        {
            orderable: false,
            searchable: false,
            defaultContent: '',
            className: 'text-center noExport',
            render: function (meta, type, data, meta2) {
                let buttons = '';
                if (data.id_venta && validPermissions(901)) {
                    buttons += `<a href="${base_url()}Reportes/Factura/${data.id_venta}/0" target="_blank" type="button" class="btn btn-primary" title="Imprimir Venta">
                        <i class="fa-solid fa-store"></i>
                    </a>`;
                }
                if (data.id_pedido && validPermissions(902)) {
                    buttons += `<a href="${base_url()}Reportes/Pedido/${data.id_pedido}/0" target="_blank" type="button" class="btn btn-secondary" title="Imprimir Pedido">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </a>`;
                }
                if (data.id_compra && validPermissions(903)) {
                    buttons += `<a href="${base_url()}Reportes/Compra/${data.id_compra}/0" target="_blank" type="button" class="btn btn-success" title="Imprimir Compra">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>`;
                }
                if (data.id_ingresomercancia && validPermissions(904)) {
                    buttons += `<a href="${base_url()}Reportes/IngresoMercancia/${data.id_ingresomercancia}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Ingreso Mercancia">
                        <i class="fa-solid fa-arrow-up-right-dots"></i>
                    </a>`;
                }
                return `<div class="btn-group btn-group-sm" role="group">${buttons}</div>`;
            }
        }
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).find("").on('click', function () {


        });
    }
});

$(function () {

    $("#fechaIni, #fechaFin").prop('max', moment().format('YYYY-MM-DD'))

    $("#btnFiltros").on('click', function () {
        $("#modalFiltros").modal('show');
    });

    $("#reiniciarFiltros").on('click', function () {
        $("#selectEstado").val('-1');
        $("#cantFin, #cantIni, #fechaFin, #fechaIni").val('');
        dataFiltro = {
            tipo: -1,
            cantidadInicial: '',
            cantidadFinal: '',
            fechaInicial: '',
            fechaFinal: ''
        }
    });

    $("#formFiltros").on('submit', function (e) {
        e.preventDefault();

        if (+$("#cantIni").val() && +$("#cantFin").val() && +$("#cantIni").val() > +$("#cantFin").val()) {
            return alertify.warning("La cantidad inicial es mayor a la cantidad final");
        }


        if (moment($("#fechaIni").val()).isAfter($("#fechaFin").val())) {
            return alertify.warning("La fecha inicial es mayor a la fecha final");
        }

        dataFiltro = {
            tipo: $("#selectEstado").val(),
            cantidadInicial: $("#cantIni").val(),
            cantidadFinal: $("#cantFin").val(),
            fechaInicial: $("#fechaIni").val(),
            fechaFinal: $("#fechaFin").val()
        }

        $("#modalFiltros").modal('hide');
        DTMovimientos.ajax.reload();
    });

})
