let rutaBase = base_url() + "Perfiles/";

var arbolPermisos = $('#tree').tree({
  primaryKey: 'id',
  uiLibrary: 'bootstrap4',
  checkboxes: true,
  select: false,
  cascadeCheck: false,
  dataSource: $PERMISOS
});

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
        btnEditar = validPermissions(22) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>': '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnPermisos = validPermissions(23) ? '<button type="button" class="btn btn-info btnPermisos" title="Permisos"><i class="fa-solid fa-lock"></i></button>' : '';

        btnCambiarEstado = validPermissions(24) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-${data.estado == "1" ? "ban" : "check"}"></i></button>` : '';
        return `<div class="btn-group btn-group-sm" role="group">
                  ${btnEditar}
                  ${btnPermisos}
                  ${btnCambiarEstado}
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".btnCambiarEstado").click(function(e){
      e.preventDefault();
      eliminar(data);
    });

    $(row).find(".btnEditar, .btnVer").click(function(e){
      e.preventDefault();

      if ($(this).hasClass("btnVer")) {
        $("#modalPefilesLabel").html(`<i class="fa-solid fa-eye"></i> Ver perfil`);
        $(".inputVer").addClass("disabled").prop("disabled", true);
        $("button[form='formPefiles']").addClass("d-none");
      } else {
        $("#modalPefilesLabel").html(`<i class="fa-solid fa-edit"></i> Editar perfil`);
        $(".inputVer").removeClass("disabled").prop("disabled", false);
        $("button[form='formPefiles']").removeClass("d-none");
      }
      
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#descripcion").val(data.descripcion);
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#modalPefiles").modal("show");
    });

    $(row).find(".btnPermisos").click(function(e){
      e.preventDefault();
      $("#modalPermisosLabel").html("<i class='fa-solid fa-lock'></i> " +data.nombre + " | Permisos");
      $("#btnGuardarPermisos").data("id", data.id);
      $.ajax({
        url: base_url() + "Permisos/Perfil/" + data.id,
        type: "GET",
        dataType: "json",
        success: function(data) {
          data.forEach(it => {
            let node = arbolPermisos.getNodeById(it.permiso);
            arbolPermisos.check(node).expand(node);
          });
          $("#modalPermisos").modal("show");
        }
      });
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

  $('#modalPefiles').on('shown.bs.modal	', function (event) {
    if($("#id").val().length <= 0) {
      $("#nombre").trigger('focus');
    }
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

  $("#modalPermisos").on('hidden.bs.modal', function (event) {
    arbolPermisos.reload();
    $("#btnGuardarPermisos").data("id", 0);
  });

  $("#checkAllPermisos").click(function(e){
    e.preventDefault();
    arbolPermisos.checkAll().expandAll();
  });

  $("#unCheckAllPermisos").click(function(e){
    e.preventDefault();
    arbolPermisos.uncheckAll().collapseAll();
  });

  $("#btnGuardarPermisos").click(function(e){
    e.preventDefault();
    let id = $(this).data("id");
    
    if (id != 0) {
      var checked = arbolPermisos.getCheckedNodes();
      $.ajax({
        url: base_url() + "Permisos/Guardar",
        type: "POST",
        dataType: "json",
        data: {id, checked, tipo: 1},
        success: function(resp) {
          if (resp.success) {
            $("#modalPermisos").modal("hide");
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }
        }
      });
    } else {
      alertify.alert("No se ha seleccionado el perfil para guardar.");
    }
  });
});

function eliminar(data){
  alertify.confirm('Cambiar estado', `Esta seguro de cambiar el estado del perfil <b>${data.nombre}</b> a ${data.estado == "1" ? 'Ina' : 'A'}ctivo`, 
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