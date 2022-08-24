let DTVariables = $("#tblVariables").DataTable({
  processing: false,
  serverSide: false,
  pageLength: 10,
  columns: [
    { data: 'variable' },
    { data: 'descripcion' },
    {
      data: 'aplica',
      className: 'text-center',
    },
  ]
});
let dataOriginal = DTVariables.rows().data();

$(function () {
  console.log("Funciona");

  $(".btn-reporte").on('click', function () {
    if (!$(this).hasClass('active')) {
      let btn = $(this).data('btn');
      $(".btn-reporte").removeClass('active');
      let dat = dataOriginal.filter((it) => $(it.aplica).hasClass(btn));
      DTVariables.clear().rows.add(dat).draw();
      $(this).addClass('active');
    } else {
      DTVariables.clear().rows.add(dataOriginal).draw();
      $(".btn-reporte").removeClass('active');
    }
  });

});