const rutaBase = `${base_url()}CuentasCobrar/`;
let optionBillSelected = {};
let sucursales = [];
const btnAssignDates = document.getElementById("assign-dates");
const inputOutstandingBalance = document.getElementById("outstandingBalance");
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
			render: function (data, type, row, meta) {
				let bill = data;
				if (row.id_pedido > 0) {
					bill = `<div class="d-flex align-items-center"><i class="fa-solid fa-tag text-info mr-2" title='Nro Pedido: ${row.NroPedido}' style="transform: rotate(90deg);"></i>${bill}</div>`;
				}
				return bill;
			}
		},
		{ data: 'NombreCliente' },
		{ data: 'Sucursal' },
		{ data: 'Ciudad' },
		{
			data: 'descuento',
			className: "text-right",
			render: (data, type, row, meta) => {
				return formatoPesos.format(data);
			}
		}, {
			data: 'total',
			className: "text-right",
			render: (data, type, row, meta) => {
				return formatoPesos.format(data);
			}
		}, {
			data: 'AbonosVenta',
			className: "text-right",
			render: (data, type, row, meta) => {
				return formatoPesos.format(data);
			}
		}, {
			data: 'ValorPendiente',
			className: "text-right",
			render: (data, type, row, meta) => {
				return formatoPesos.format(data);
			}
		},
		{
			data: 'FechaVencimiento',
			render: (data, type, row, meta) => {
				return moment(data, "YYYY-MM-DD").format("DD/MM/YYYY");
			}
		},
		{
			data: 'created_at',
			render: (data, type, row, meta) => {
				return moment(data, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
			}
		},
		{
			data: 'observacion',
			width: "20%",
			render: (data, type, row, meta) => {
				return `<span title="${data}" class="text-descripcion">${data}</span>`;
			}
		},
		{
			orderable: false,
			searchable: false,
			defaultContent: '',
			className: 'text-center noExport',
			render: (data, type, row, meta) => {
				let botones = ``;

				if (row.FechaVencimiento != null) {
					botones += validPermissions(1001) ? `<button type="button" class="btn btn-primary btnAgregar" title="Ver"><i class="fa-solid fa-plus"></i></button>` : '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

					botones += validPermissions(1004) ? `<a href="${base_url()}Reportes/CuentaCobrar/${row.id}/0" target="_blank" type="button" class="btn btn-info" title="Imprimir Abonos">
						<i class="fa-solid fa-print"></i>
					</a>` : '';

					botones += validPermissions(1006) ? `<a href="${base_url()}Reportes/ReciboCaja/${row.id}/0" target="_blank" type="button" class="btn btn-secondary" title="Imprimir Recibos Caja">
						<i class="fa-solid fa-money-check"></i>
					</a>` : '';
				} else {
					botones += validPermissions(1007) && FACTURASINFECHA > 0 ? `<button type="button" class="btn btn-secondary btn-assign-dates" title="Asignar Fecha"><i class="fa-regular fa-calendar-plus"></i></button>` : '';
				}

				return `<div class="btn-group btn-group-sm" role="group">${botones}</div>`;
			}
		}
	],
	createdRow: function (row, data, dataIndex) {
		$(row).css({ 'background-color': getColorBill(+data.ValorPendiente, data.FechaVencimiento, data.AbonosVenta) })

		//Editar
		$(row).find(".btnVer, .btnAgregar").click(function (e) {
			e.preventDefault();

			const $btn = $(this);

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

					$("#clienteFactura").html(venta.NombreCliente + `(${venta.NombreSucursal})`);
					$("#vendedorFactura").html(venta.NombreVendedor);
					$("#metodoPagoFactura").html((venta.metodo_pago == '2' ? 'Credito' : 'Contado'));
					$("#fechaCreacionFactura").html(moment(venta.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
					$("#fechaVencimientoFactura").html(moment(venta.FechaVencimiento, "YYYY-MM-DD").format("DD/MM/YYYY"));
					$("#descuentoFactura").html(formatoPesos.format(venta.descuento));
					$("#totalFactura").html(formatoPesos.format(venta.total));
					$("#totalAbonosFactura").html(formatoPesos.format(venta.AbonosVenta));
					$("#valorPendienteFactura").html(formatoPesos.format(+venta.ValorPendiente - (+venta.descuento ?? 0)));

					$("#modalAgregarAbono").modal('show');
				}
			});
		});

		$(row).find(".btn-assign-dates").click(function (e) {
			e.preventDefault();
			let fechaVen = moment(data.created_at, "YYYY-MM-DD").format("DD/MM/YYYY");
			$("#idFactura").val(data.id);
			$("#fechaFactura").val(fechaVen);
			$("#fechaVencimiento").val(moment().format("DD/MM/YYYY"));
			$('#fechaVencimientoDate').datetimepicker('minDate', fechaVen);
			$("#modalAssignDate").modal('show');
		});
	},
	drawCallback: function (settings) {
		getTotalBalance();
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
			return `<button class="btn btn-sm btn-${color}">${data.Descripcion_Estado}</button>`;
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

							$("#valorPendienteFactura").html(formatoPesos.format(+info.venta.ValorPendiente - (+info.venta.ValorPendiente ?? 0)));

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

const getTotalBalance = () => {
	$.ajax({
		type: "POST",
		url: rutaBase + "ObtenerTotales",
		data: filtrosConfig,
		dataType: 'json',
		success: function ({ total }) {
			$("#thFooterTotal").html(formatoPesos.format(total.total));
			$("#thFooterTotalAbonos").html(formatoPesos.format(total.AbonosVenta));
			$("#thFooterSaldoPendiente").html(formatoPesos.format(total.ValorPendiente));
		}
	});
}

$(function () {

	inputOutstandingBalance.value = formatoPesos.format($outstandingBalance);

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

			if (+dataProd.valor > (+optionBillSelected.ValorPendiente - (+optionBillSelected.descuento ?? 0))) {
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
						$("#valorPendienteFactura").html(formatoPesos.format(+info.venta.ValorPendiente - (+info.venta.ValorPendiente ?? 0)));

						optionBillSelected.ValorPendiente = info.venta.ValorPendiente;

						console.log(optionBillSelected.ValorPendiente);

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

	document.getElementById("filterMobile").addEventListener("change", function () {
		const newFilter = this.value;
		filtrosConfig.type = newFilter.toString();
		resetFilter(true);
	});

	$("#tipoAbono").on("change", function (e) {
		e.preventDefault();
		const tipoAbono = $(this).val();
		if (tipoAbono == "5") {
			$("#valor").val(optionBillSelected.ValorPendiente);
		} else {
			$("#valor").val(0);
		}
	});

	if (btnAssignDates && FACTURASINFECHA > 0) {
		btnAssignDates.addEventListener("click", function () {
			filtrosConfig.type = "5";
			resetFilter(true);
		});
	}

	$('#modalFilter').on('show.bs.modal', function (event) {
		resetFilter(false);
	});

	$("#reiniciarFiltros").on("click", function () {
		filtrosConfig = {
			type: "-1",
			branches: "",
			branchesName: ""
		}
		resetFilter(true);
	});

	// Inicializar el datetimepicker
	$('#fechaVencimientoDate').datetimepicker({
		format: 'DD/MM/YYYY',
		defaultDate: moment(),
	});

	$("#fechaVencimientoDate").on("change.datetimepicker", function (e) {
		let fechaFactura = $("#fechaFactura").val();
		let fechaVencimiento = $("#fechaVencimiento").val();

		if (!moment(fechaFactura, "DD/MM/YYYY").isSameOrBefore(moment(fechaVencimiento, "DD/MM/YYYY"))) {
			alertify.error('La fecha de vencimiento no puede ser menor que la fecha original.');
			$("#fechaVencimiento").val(fechaFactura);
			return;
		}
	});

	document.addEventListener("focusin", function (event) {
		if (event.target.classList.contains("datetimepicker-focus")) {
			event.target.nextElementSibling.click();
		}
	});

	$('#formAssignDate').submit(function (e) {
		e.preventDefault();

		if (!validPermissions(1007)) {
			alertify.error("No tiene permisos para realizar esta acción.");
			return;
		}

		if ($(this).valid()) {
			let fechaVencimiento = $("#fechaVencimiento").val();
			let fechaOriginal = $("#fechaFactura").val();

			// Convertir las fechas al formato ISO para evitar advertencias de deprecación
			fechaOriginal = moment(fechaOriginal, "DD/MM/YYYY").format("YYYY-MM-DD");
			fechaVencimiento = moment(fechaVencimiento, "DD/MM/YYYY").format("YYYY-MM-DD");

			// Verificar si la fecha de vencimiento es menor que la fecha original
			if (moment(fechaVencimiento).isBefore(moment(fechaOriginal))) {
				alertify.error('La fecha de vencimiento no puede ser menor que la fecha original.');
				return;
			}

			$.ajax({
				type: "POST",
				url: rutaBase + "AsignarFechaVencimiento",
				dataType: 'json',
				processData: false,
				contentType: false,
				cache: false,
				data: new FormData(this),
				success: ({ success, msj }) => {
					if (success) {
						alertify.success(msj);
						$("#idFactura").val('');
						$("#fechaVencimiento, #fechaFactura").val(moment().format("DD/MM/YYYY"));
						$("#modalAssignDate").modal('hide');
						DTCuentasCobrar.ajax.reload();
					} else {
						alertify.error(msj);
					}
				}
			});
		}
	});
});