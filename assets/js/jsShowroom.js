let rutaBase = base_url() + "Showroom/";
let estadoFiltro = '-1';
const tituloModulo = 'Showroom';
const permissionShowroom = {
  create: validPermissions(7001),
  edit: validPermissions(7002)
}

let DTShowroom = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function (d) {
      return $.extend(d, { "estado": estadoFiltro })
    }
  },
  scrollX: true,
  columns: [
    {data: 'nombre'},
    {
      data: 'fechaInicio',
      className: "text-right",
      render: function (data, type, row, meta) {
        if (data) {
          return  moment(data, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
        } else {
          return "";
        }
      }
    },
    {data: 'leerQRDesc'},
    {data: 'muestraValorDesc'},
    {data: 'inventarioNegativoDesc'},
    {
      data: 'created_at',
      className: "text-right",
      render: function (data, type, row, meta) {
        return moment(data, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
      }
    },
    {data: 'estadoDesc'},
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center noExport',
      render: function (data, type, row, meta) {
        btnEditar = permissionShowroom.edit ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>' : '<button type="button" class="btn btn-info btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';
        btnIniciar = "";
        if ($currentShowroom == null && permissionShowroom.edit) {
          btnIniciar = `<button type="button" class="btn btn-success btnStartShowroom" title="Iniciar"><i class="fa-solid fa-play"></i></button>`;
        }
  
        return `<div class="btn-group btn-group-sm" role="group">
            ${btnEditar}
            ${btnIniciar}
          </div>`;
      }
    }
  ],
  createdRow: function (row, data, dataIndex) {

    $(row).find(".btnEditar, .btnVer").click(function(e){
      e.preventDefault();

      if ($(this).hasClass("btnVer")) {
        $("#modalShowroomLabel").html(`<i class="fa-solid fa-eye"></i> Ver ${tituloModulo}`);
        $(".inputVer").addClass("disabled").prop("disabled", true);
        $("button[form='formShowroom']").addClass("d-none");
      } else {
        $("#modalShowroomLabel").html(`<i class="fa-solid fa-edit"></i> Editar ${tituloModulo}`);
        $(".inputVer").removeClass("disabled").prop("disabled", false);
        $("button[form='formShowroom']").removeClass("d-none");
      }

      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#descripcion").val(data.descripcion);
      $("#leerQR").val(data.leerQR);
      $("#inventarioNegativo").val(data.inventarioNegativo);
      $("#muestraValor").val(data.muestraValor);
      $("#estado").val(data.estadoDesc);
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $(".form-group-edit").removeClass("d-none");
      $("#modalShowroom").modal("show");
    });

    $(row).find(".btnStartShowroom").click(function(e){
      changeStatusShowroom(data);
    });
  }
});

function changeStatusShowroom(data){
  let showroom = null;
  //Validamos si hay un showroom activo
  /* $.ajax({
    type: "POST",
    url: rutaBase + "validShowroom",
    dataType: 'json',
    async: false,
    success: (resp) => {
      if (!resp.success && resp.alert) {
        alertify.alert("Advertencia", resp.msg);
        return;
      } else {
        showroom = resp.showroom;
      }
    }
  }); */

  if (showroom) {
    if (data.id == showroom.id) {
      console.log("Enviamos la petición para iniciar el showroom");
    } else {
      alertify.alert("Advertencia", `El ${tituloModulo} a iniciar no coincide con el showroom ${showroom.nombre} que actualmente se encuentra iniciado.`);
    }
  } else {
    //Acá vamos a iniciar el showroom
    $.ajax({
      type: "POST",
      url: rutaBase + "changeStatusShowroom",
      data: {
        showroom: data,
        type: "init"
      },
      dataType: 'json',
      async: false,
      success: (resp) => {
        console.log(resp);
      }
    });
  }
}

$(function(){
  $("#btnCrear").on("click", function () {
    $(".inputVer").removeClass("disabled").prop("disabled", false);
    $("button[form='formShowroom']").removeClass("d-none");
    $("#id").val("");
    $(".form-group-edit").addClass("d-none");
    $("#modalShowroomLabel").html(`<i class="fa-solid fa-plus"></i> Crear ${tituloModulo}`);
    $("#modalShowroom").modal("show");
  });


  $("#formShowroom").submit(function(e){
    e.preventDefault();
    if ($(this).valid()) {
      $.ajax({ 
        url: rutaBase + "Crear",
        type:'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: new FormData(this),
        success: function(resp){
          if (resp.success) {
            DTShowroom.ajax.reload();
            $("#modalShowroom").modal("hide");
            alertify.success(resp.msg);
          } else {
            alertify.alert('¡Advertencia!', resp.msg);
          }
        }
      });
    }
  });
});