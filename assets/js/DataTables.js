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

function dtSS($parametros) {
	try {
		var $tblID = $parametros.data.tblID;
	} catch (e) {
		console.error('No hay tblID definida');
		return false;
	}
	var settings = {
		processing: true,
		serverSide: true,
		order: [],
		draw: 25,
		language,
		pageLength: 25,
		ajax: {
			url: base_url() + "DataTables/dtSS/",
			type: 'POST',
			data: {
				select: JSON.stringify($parametros.data.select),
				table: JSON.stringify($parametros.data.table),
				column_order: JSON.stringify($parametros.data.column_order),
				column_search: JSON.stringify($parametros.data.column_search),
				orden: $parametros.data.orden,
				columnas: JSON.stringify($parametros.data.columnas),
				group_by: JSON.stringify($parametros.data.group_by),
				having: JSON.stringify($parametros.data.having),
				or_where: JSON.stringify($parametros.data.or_where),
				where_in: JSON.stringify($parametros.data.where_in)
			}
		},
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
		dom: domlftri,
		buttons: [
			{ extend: 'copy', className: 'copyButton', text: 'Copiar' },
			{ extend: 'csv', className: 'csvButton', text: 'CSV' },
			//{ extend: 'excel', className: 'excelButton', text: 'Excel' },
			{ extend: 'excel', action: newExportAction, text: 'Excel' },
			{ extend: 'pdf', className: 'pdfButton', tex: 'PDF' },
			{ extend: 'print', className: 'printButton', text: 'Imprimir' }
		],
		deferRender: true
	};
	delete $parametros['data'];
	for (var attrname in $parametros) {
		settings[attrname] = $parametros[attrname];
		delete $parametros[attrname];
	}
	settings = Object.assign(settings, $parametros);
	var dt = $($tblID).DataTable(settings);
	return dt;
}

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