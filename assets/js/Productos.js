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
        return `<a href="${base_url()}Productos/Foto/${data.id}/${data.imagen}" data-fancybox="images${data.id}" data-caption="${data.referencia} - ${data.item}">
                  <img class="img-thumbnail" src="${base_url()}Productos/Foto/${data.id}/${data.imagen}" alt="" />
                </a>`;
      }
    },
    {data: 'referencia'},
    {data: 'item'},
    {
      data: 'descripcion',
      width: "30%",
      render: function(meta, type, data, meta) {
        return `<span title="${data.descripcion}" class="text-descripcion">${data.descripcion}</span>`;
      }
    },
    {data: 'nombreCategoria'},
    {data: 'stock'},
    {
      data: 'precio_venta',
      className: 'text-right',
      render: function(meta, type, data, meta) {
        return formatoPesos.format(data.precio_venta);
      }
    },
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
  }
});

$(function(){
  $("#foto").on("change", function(event){
    const file = this.files[0];
    if (file){
      if(file.size <= 2000000){
        let reader = new FileReader();
        reader.onload = function(event){
          //console.log(event.target.result);
          $('#imgFoto').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
        $("#content-preview").removeClass("d-none");
        $("#content-upload").addClass("d-none");

        if ($("#id").val().length > 0) {
          $("#editFoto").val(0);
        }
      } else {
        alertify.error("La imagen es superior a 2mb");
        $("#foto").val('');
        $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
        $("#content-preview").addClass("d-none");
        $("#content-upload").removeClass("d-none");
      }
    } else {
      $("#foto").val('');
      $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
      $("#content-preview").addClass("d-none");
      $("#content-upload").removeClass("d-none");
    }
  });

  $("#selectEstado").on("change", function(){
    DTProductos.ajax.reload();
  });

  $(".validaCampo").on("focusout", function(){
    let selfi = $(this);
    let campo = $(this).data("campo");
    let valor = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if(valor.length > 0){
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaProducto/" + campo + "/" + valor + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if(resp > 0){
            inicio = campo == "item" ? "El item" : "La referencia "; 
            alertify.warning(inicio + " <b>" + valor + "</b>, ya se encuentra creado, intente con otro nombre.");
            selfi.trigger("focus");
          }
        }
      });
    }
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
            DTProductos.ajax.reload();
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

function eliminar(data){
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del producto <b>${data.referencia}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`, 
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
            DTProductos.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    },function(){});
}