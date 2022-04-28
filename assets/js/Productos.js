let rutaBase = base_url() + "Productos/";

let DTProductos = $("#table").DataTable({
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
      defaultContent: '',
      className: "text-center",
      render: function(meta, type, data, meta) {
        return `<a href="${base_url()}Usuarios/Foto/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
                  <img class="img-thumbnail" src="${base_url()}Usuarios/Foto/${data.imagen}" alt="" />
                </a>`;
      }
    },
    {data: 'referencia'},
    {data: 'item'},
    {data: 'descripcion'},
    {data: 'nombreCategoria'},
    {data: 'stock'},
    {data: 'precio_venta'},
    {data: 'ubicacion'},
    {data: 'manifiesto'},
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
                  <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-user-pen"></i></button>
                  <button type="button" class="btn btn-info btnCambiarPass" title="Cambiar Contraseña"><i class="fa-solid fa-user-lock"></i></button>
                  <button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-user-${data.estado == "1" ? "large-slash" : "check"}"></i></button>
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){

  }
});

$(function(){
  $("#selectEstado").on("change", function(){
    DTProductos.ajax.reload();
  });

  $("#btnCrear").on("click", function(){
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalCrearEditarLabel").html(`<i class="fa-solid fa-plus"></i> Crear producto`)
    $("#modalCrearEditar").modal("show");
  });

  $("#formCrearEditar").submit(function(e){
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
            $("#modalCrearEditar").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });
});