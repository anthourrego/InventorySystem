let rutaBase = base_url() + "ModificarReporte/";
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

  $(".btn-modifica-reporte").on('click', function () {
    location.href = rutaBase + "Reporte/" + $(this).data('btn');
  });

  $(".btn-plantilla-reporte").on('click', function () {
    let reporte = $(this).data('btn');
    alertify.confirm("¿Esta seguro de reemplazar el reporte de " + reporte.split('_').join(' ') + " por la plantilla?", function () {
      $.ajax({
        url: rutaBase + "/Plantilla",
        type: 'POST',
        dataType: 'json',
        data: { reporte },
        success: function (resp) {
          if (resp.success) {
            alertify.alert('¡Advertencia!', resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }, function () { });
  });
});