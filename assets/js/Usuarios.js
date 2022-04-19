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
        return `<a href="${base_url()}Usuarios/Foto/${data.foto}" data-fancybox="images${data.id}" data-caption="${data.nombre}">
                  <img class="img-thumbnail" src="${base_url()}Usuarios/Foto/${data.foto}" alt="" />
                </a>`;
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
                  <button type="button" class="btn btn-${data.estado == "1" ? "danger" : "info"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-user-${data.estado == "1" ? "large-slash" : "check"}"></i></button>
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".btnCambiarEstado").on("click", function(){
      eliminar(data);
    });
  }
});

$(function(){
  $("#selectEstado").on("change", function(){
    DTUsuarios.ajax.reload();
  });

  $("#btnCrearUsuario").on("click", function(){
    $("#modalUsuario").modal("show");
    $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-plus"></i> Crear usuario`)
  });
});

function eliminar(data){
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del usuario ${data.usuario} ("${data.nombre}") a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`, 
    function(){
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          idUsuario: data.id,
          estado: (data.estado == "1" ? 0 : 1)
        },
        success: function (resp) {
          if(resp.success){
            alertify.success(resp.msj);
            DTUsuarios.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    },function(){});
  
}