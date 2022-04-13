let rutaBase = base_url() + "Usuarios/";

$(function(){
  dataTable({
    tblId: "#table",
    buttonsAdd: [
      { extend: 'print', className: 'printButton btn-info', text: '<i class="fa-solid fa-print"></i>' },
    ],
    ajax: {
      url: rutaBase + "DT",
      type: "POST"
    },
    columns: [
      {data: 'nombre'},
      {data: 'usuario'},
      {data: 'perfil'},
      {data: 'estado'},
      {data: 'ultimo_login'},
      {data: 'fecha'},
      {data: 'id'},
    ]
  });
});