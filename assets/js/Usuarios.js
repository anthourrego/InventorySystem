let rutaBase = base_url() + "Usuarios/";

let DTUsuarios = dataTable({
  tblId: "#table",
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function(d){
      return $.extend(d, {"estado": $("#selectEstado").val()} )
    }
  },
  columns: [
    {
      orderable: false,
      data: 'foto',
      className: "text-center",
      render: function(meta, type, data, meta) {
        return `<img src="${base_url()}Usuarios/Foto/${data.foto}" class="img-thumbnail">`;
      }
    },
    {data: 'nombre'},
    {data: 'usuario'},
    {data: 'perfil'},
    {data: 'Estadito'},
    {
      data: 'ultimo_login',
      render: function(meta, type, data, meta) {
        return moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYYY hh:mm:ss A");
      }
    },
    {
      data: 'fecha',
      render: function(meta, type, data, meta) {
        return moment(data.fecha, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYYY hh:mm:ss A");
      }
    },
    {
      orderable: false,
      defaultContent: '',
      className: 'text-center',
      render: function(meta, type, data, meta) {
        return `<div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-user-pen"></i></button>
                  <button type="button" class="btn btn-danger btnEliminar" title="Eliminar"><i class="fa-solid fa-user-large-slash"></i></button>
                </div>`;
      }
    },
  ]
});

$(function(){
  $("#selectEstado").on("change", function(){
    DTUsuarios.ajax.reload();
  });
});