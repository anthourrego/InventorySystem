let rutaBase = base_url() + "Clientes/";

let DTClientes = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function(d){
      return $.extend(d, {"estado": $("#selectEstado").val()} )
    }
  },
  columns: [
    {data: 'documento'},
    {data: 'nombre'},
    {data: 'direccion'},
    {data: 'telefono'},
    {data: 'administrador'},
    {data: 'cartera'},
    {data: 'telefonocart'},
    {data: 'compras'},
    {
      data: 'ultima_compra',
      render: function(meta, type, data, meta) {
        return moment(data.ultima_compra, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
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
      console.log(data);
      $("#modalClientesLabel").html(`<i class="fa-solid fa-edit"></i> Editar cliente`);
      $("#id").val(data.id);
      $("#documento").val(data.documento);
      $("#nombre").val(data.nombre);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#administrador").val(data.administrador);
      $("#cartera").val(data.cartera);
      $("#telefonoCart").val(data.telefonocart);
      $("#cantCompras").val(data.compras);
      $("#fechaCompra").val(moment(data.ultima_compra, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#modalClientes").modal("show");
    });
  }
});

$(function(){
  $("#selectEstado").on("change", function(){
    DTClientes.ajax.reload();
  });

  $("#btnCrear").on("click", function(){
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalClientesLabel").html(`<i class="fa-solid fa-plus"></i> Crear cliente`)
    $("#modalClientes").modal("show");
    $('#modalClientes').on('shown.bs.modal	', function (event) {
      $("#documento").trigger('focus');
    });
  });

  $("#formClientes").submit(function(e){
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
          console.log(resp);
          if (resp.success) {
            DTClientes.ajax.reload();
            $("#modalClientes").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    }
  });


  //Validamos el clientes
  $("#documento").on("focusout", function(){
    let documento = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if(documento.length > 0){
      $.ajax({
        type: "GET",
        url: rutaBase + "Validar/" + documento + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if(resp > 0){
            alertify.warning("El número de documento <b>" + documento + "</b>, ya se encuentra creado, intente con otro número.");
            $("#documento").trigger("focus");
          }
        }
      });
    }
  });
});


function eliminar(data){
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del cliente <b>${data.nombre}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`, 
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
            DTClientes.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    },function(){});
}