var language = {
	lengthMenu: "Mostrar _MENU_ registros por página.",
	zeroRecords: "No se ha encontrado ningún registro.",
	info: "Mostrando _START_ a _END_ de _TOTAL_ entradas.",
	infoEmpty: "Registros no disponibles.",
	search: "",
	searchPlaceholder: "Buscar",
	loadingRecords: "Cargando...",
	processing: "Procesando...",
	paginate: {
		first: "Primero",
		last: "Último",
		next: "Siguiente",
		previous: "Anterior"
	},
	buttons: {
		pageLength: {
			_: 'Mostrar %d registros'
			, '-1': "Mostrar todo"
		},
		colvis: 'Visibilidad Columnas'
		, copy: 'Copiar'
		, csv: 'CVS'
		, excel: 'Excel'
		, pdf: 'PDF'
		, print: 'Imprimir'
	},
	infoFiltered: "(_MAX_ Registros filtrados en total)"
};

var domBftrip = "<'row no-gutters pt-1 px-1'<'col-sm-12 col-md-8 mb-2 mb-md-0'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
var domBftri = "<'row no-gutters pt-1 px-1'<'col-sm-12 col-md-8 mb-2 mb-md-0'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-12'i>>";
var domlftrip = "<'row no-gutters pt-1 px-1'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
var domftrip = "<'row no-gutters pt-1 px-1'<'col-sm-12'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
var domftr = "<'row no-gutters pt-1 px-1'<'col-12'f>><'row'<'col-md-12't>><'row'<'col-md-6'><'col-md-6'>>r";
var domlftri = "<'row no-gutters pt-1 px-1'<'col-sm-12'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i>>";

function dataTable(config) {
	console.log(config.buttonsAdd);
	if(config.tblId) {
		$tblID = config.tblId;
	} else {
		console.error('No hay tabala definida');
		alertify.error('No hay tabla definida');
		return false;
	}

	var settings = {
		processing: true,
		serverSide: true,
		order: [],
		draw: 25,
		language,
		pageLength: 25,
		initComplete: function (settings, json) {
			var self = this;
			$(this).closest('.dataTables_wrapper').find('div.dataTables_filter input').unbind().keyup(function (e) {
				e.preventDefault();
				if (e.keyCode == 13) {
					table = $("body").find($tblID).dataTable();
					table.fnFilter(this.value);
					self.fnFilter(this.value);
				}
			});
			setTimeout(function () {
				$('div.dataTables_filter input').focus();
			}, 0);
		},
		lengthMenu: [
			[10, 25, 50, -1],
			['10', '25', '50', 'Todos']
		],
		dom: domBftrip,
		buttons: [
			{ extend: 'copy', className: 'copyButton btn-warning', text:'<i class="fa-solid fa-copy"></i>', attr: { title: "Copiar", "data-toggle":"tooltip" } },
			{ extend: 'csv', className: 'csvButton btn-light', text: '<i class="fa-solid fa-file-csv"></i>', attr: { title: "CSV", "data-toggle":"tooltip" } },
			{ extend: 'excel', className: "btn-success", action: newExportAction, text: '<i class="fa-solid fa-file-excel"></i>', attr: { title: "Excel", "data-toggle":"tooltip" } },
			{ extend: 'pdf', className: 'pdfButton btn-danger', text: '<i class="fa-solid fa-file-pdf"></i>', attr: { title: "PDF", "data-toggle":"tooltip" } },
			{ extend: 'print', className: 'printButton btn-info', text: '<i class="fa-solid fa-print"></i>', attr: { title: "Imprimir", "data-toggle":"tooltip" } },
			{ extend: 'pageLength', className: ""}
		],
		deferRender: true
	};

	delete config['tblId'];
	for (var attrname in config) {
		settings[attrname] = config[attrname];
		delete config[attrname];
	}
	settings = Object.assign(settings, config);
	var dt = $($tblID).DataTable(settings);
	$('[data-toggle="tooltip"]').tooltip();
	return dt;
}

var oldExportAction = function (self, e, dt, button, config) {
	if (button[0].className.indexOf('buttons-excel') >= 0) {
		if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
			$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
		}else{
			$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
		}
	} else if (button[0].className.indexOf('buttons-print') >= 0) {
		$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
	}
};

var newExportAction = function (e, dt, button, config) {
	var self = this;
	var oldStart = dt.settings()[0]._iDisplayStart;

	dt.one('preXhr', function (e, s, data) {
		// Just this once, load all data from the server...
		data.start = 0;
		//data.length = 2147483647;
		data.length = -1;

		dt.one('preDraw', function (e, settings) {
			// Call the original action function 
			oldExportAction(self, e, dt, button, config);

			dt.one('preXhr', function (e, s, data) {
				// DataTables thinks the first item displayed is index 0, but we're not drawing that.
				// Set the property to what it was before exporting.
				settings._iDisplayStart = oldStart;
				data.start = oldStart;
			});

			// Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
			setTimeout(dt.ajax.reload, 0);

			// Prevent rendering of the full data to the DOM
			return false;
		});
	});

	// Requery the server with the new one-time export settings
	dt.ajax.reload();
};