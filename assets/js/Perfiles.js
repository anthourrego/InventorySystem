let rutaBase = base_url() + "Perfiles/";

let DTPefiles = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function(d){
      return $.extend(d, {"estado": $("#selectEstado").val()} )
    }
  },
  columns: [
    {data: 'nombre'},
    {
      data: 'descripcion',
      width: "30%",
      render: function(meta, type, data, meta) {
        return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
      }
    },
    {data: 'Estadito',},
    {
      data: 'created_at',
      render: function(meta, type, data, meta) {
        return moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center',
      render: function(meta, type, data, meta) {
        return `<div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".btnCambiarEstado").click(function(e){
      e.preventDefault();
      eliminar(data);
    });

    $(row).find(".btnEditar").click(function(e){
      e.preventDefault();
      $("#modalPefilesLabel").html(`<i class="fa-solid fa-edit"></i> Editar perfil`);
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#descripcion").val(data.descripcion);
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#modalPefiles").modal("show");
    });
  }
});

$(function(){
  $("#selectEstado").on("change", function(){
    DTPefiles.ajax.reload();
  });

  $("#btnCrear").on("click", function(){
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalPefilesLabel").html(`<i class="fa-solid fa-plus"></i> Crear perfil`)
    $("#modalPefiles").modal("show");
  });

  $("#formPefiles").submit(function(e){
    e.preventDefault();
    let id = $("#id").val().trim();
    if ($(this).valid()) {
      $.ajax({ 
        url: rutaBase + (id.length > 0 ? "Editar" : "Crear"),
        type:'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: new FormData(this),
        success: function(resp){
          if (resp.success) {
            DTPefiles.ajax.reload();
            $("#modalPefiles").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });
});

function eliminar(data){
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del perfil ${data.nombre} a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`, 
    function(){
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          id: data.id,
          estado: (data.estado == "1" ? 0 : 1)
        },
        success: function (resp) {
          if(resp.success){
            alertify.success(resp.msj);
            DTPefiles.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    },function(){});
}