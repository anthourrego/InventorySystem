var membresias = [];
const rutaBase = base_url() + "Membresias/";
const DTMembresias = $("#tblMembresia").DataTable({
  data: membresias,
  dom: domBftrip,
  processing: false,
  serverSide: false,
  order: [],
  scrollX: true,
  columns: [
    { data: 'plan' },
    { data: 'documento' },
    { data: 'fechaAfiliacion' },
    { data: 'fechaInicio' },
    { data: 'fechaPago' },
    { data: 'idAfiliado' },
    { data: 'Afiliado' },
    { data: 'valorPagado' },
    { data: 'efectivo' },
    { data: 'tarjeta' },
    { data: 'transferencia' },
    { data: 'cuentasxCobrar' },
    { data: 'celular' },
    { data: 'correo' },
    { data: 'nroPagos' },
    { data: 'porceDecuento' }
  ],
  createdRow: function (row, data, dataIndex) {
  },
  drawCallback: function (settings) {
  }
});

$(function () {
  bsCustomFileInput.init();
  $("#frm-Excel").trigger("reset");

  $("#excelFile").change(function (e) {
    e.preventDefault();
    $(document).find(".btnAdd").removeClass("disabled").prop("disabled", false);
    membresias = [];
    let fileName = $(this).val().split('\\').pop();
    DTMembresias.clear().draw();

    if (fileName == '') return;

    form = new FormData($("#frm-Excel")[0]);
    $.ajax({
      url: rutaBase + "ImportarExcel",
      type: 'POST',
      dataType: 'json',
      processData: false,
      contentType: false,
      cache: false,
      data: form,
      success: function (resp) {
        if (resp.success) {
          /* resp.data.forEach(data => {
            $("#p" + data.id).addClass("disabled").prop("disabled", true);
            data.valorTotal = data.precio_venta * data.cantidad;
            data.nuevo = true;
          }); */
          console.log(resp.data);
          membresias = resp.data;
          DTMembresias.clear().rows.add(membresias).draw();
          //calcularTotal();
        } else {
          alertify.alert("Error", resp.msj);
        }
      },
      complete: () => {
        //$("#frm-Excel").trigger("reset");
      }
    });
  });
});