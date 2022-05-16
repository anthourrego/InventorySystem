let rutaBase = base_url() + "Usuarios/";

var arbolPermisos = $('#tree').tree({
  primaryKey: 'id',
  uiLibrary: 'bootstrap4',
  checkboxes: true,
  select: false,
  cascadeCheck: false,
  dataSource: $PERMISOS
});

let DTUsuarios = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
    data: function(d){
      return $.extend(d, {"estado": $("#selectEstado").val()} )
    }
  },
  order: [[2, "asc"]],
  columns: [
    {
      orderable: false,
      defaultContent: '',
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
        return moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A");
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

        btnEditar = validPermissions(12) ? '<button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-user-pen"></i></button>': '<button type="button" class="btn btn-dark btnVer" title="Ver"><i class="fa-solid fa-eye"></i></button>';

        btnCambiarPass = validPermissions(13) ?  '<button type="button" class="btn btn-warning btnCambiarPass" title="Cambiar Contraseña"><i class="fa-solid fa-user-lock"></i></button>' : '';

        btnPermisos = (data.perfilId == null && validPermissions(15)) ? '<button type="button" class="btn btn-info btnPermisos" title="Permisos"><i class="fa-solid fa-user-shield"></i></button>' : '';

        btnCambiarEstado = validPermissions(14) ? `<button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-user-${data.estado == "1" ? "large-slash" : "check"}"></i></button>` : '';

        return `<div class="btn-group btn-group-sm" role="group">
                  ${btnEditar}
                  ${btnCambiarPass}
                  ${btnPermisos}
                  ${btnCambiarEstado}
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    //Cambio de estado
    $(row).find(".btnCambiarEstado").on("click", function(){
      eliminar(data);
    });

    //Editar usuario
    $(row).find(".btnEditar, .btnVer").click(function(e){
      e.preventDefault();
      if ($(this).hasClass("btnVer")) {
        $("#modalUsuarioLabel").html(`<i class="fa-solid fa-eye"></i> Ver usuario`);
        $(".btn-eliminar-foto, button[form='formUsuario']").addClass("d-none");
        $(".inputVer").addClass("disabled").prop("disabled", true).trigger('change');
      } else {
        $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-pen"></i> Editar usuario`);
        $(".inputVer").removeClass("disabled").prop("disabled", false).trigger('change');
        $(".btn-eliminar-foto, button[form='formUsuario']").removeClass("d-none");
      }
      
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#usuario").val(data.usuario);
      $("#perfil").val((data.perfilId == null ? 0 : data.perfilId));
      $("#fechaLog").val(moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $("#editFoto").val(0);
      $("#foto").val('');
      if (data.foto != null) {
        $('#imgFoto').attr('src', base_url() + "Usuarios/Foto/" + data.foto);
        $("#content-preview").removeClass("d-none");
        $("#content-upload").addClass("d-none");
      } else {
        $("#content-preview").addClass("d-none");
        $("#content-upload").removeClass("d-none");
      }
      $("#pass, #RePass").closest(".form-group").addClass("d-none");
      $(".form-group-edit").removeClass("d-none");
      $("#modalUsuario").modal("show");
    });

    //Cambio de contraseña
    $(row).find(".btnCambiarPass").click(function(e){
      $("#formPass input[name='id'").val(data.id);

      $("#cambioPassModal").modal("show");
    });

    //Permisos
    $(row).find(".btnPermisos").click(function(e){
      e.preventDefault();
      $("#modalPermisosLabel").html("<i class='fa-solid fa-user-shield'></i> " +data.nombre + " | Permisos");
      $("#btnGuardarPermisos").data("id", data.id);
      $.ajax({
        url: base_url() + "Permisos/Usuarios/" + data.id,
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
    DTUsuarios.ajax.reload();
  });

  $("#foto").on("change", function(event){
    const file = this.files[0];
    if (file){
      if(file.size <= 2000000){
        let reader = new FileReader();
        reader.onload = function(event){
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

  $(".btn-eliminar-foto").on("click", function(e){
    e.preventDefault();
    $("#foto").val('');
    $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload").removeClass("d-none");

    if ($("#id").val().length > 0) {
      $("#editFoto").val(1);
    }
  });

  $("#btnCrearUsuario").on("click", function(){
    $(".inputVer").val("").removeClass("disabled").prop("disabled", false).trigger('change');
    $("#editFoto").val(0);
    $("#foto").val('').removeClass("disabled").prop("disabled", false);
    $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload, .btn-eliminar-foto, button[form='formUsuario']").removeClass("d-none");
    $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-plus"></i> Crear usuario`);
    $(".form-group-edit").addClass("d-none");
    $("#pass, #RePass").closest(".form-group").removeClass("d-none");
    $("#modalUsuario").modal("show");
  });

  $('#modalUsuario').on('shown.bs.modal	', function (event) {
    if($("#id").val().length <= 0) {
      $("#usuario").trigger('focus');
    }
  });

  $(".btn-pass").on("click", function () {
    if ($(this).find('i').hasClass('fa-eye')) {
      $(this).closest('.input-group').find('input').attr('type', 'text');
      $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
      $(this).closest('.input-group').find('input').attr('type', 'password');
      $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    }
  });

  //Las condiciones del formulario
  $("#formUsuario").validate({
    rules: {
      pass: "required",
      RePass: {
        equalTo: "#pass"
      }
    }
  });

  $("#usuario").on("focusout", function(){
    let usuario = $(this).val();
    let id = $("#id").val().length ? $("#id").val() : 0;
    if(usuario.length > 0){
      $.ajax({
        type: "GET",
        url: rutaBase + "ValidaUsuario/" + usuario + "/" + id,
        dataType: 'json',
        success: function (resp) {
          if(resp > 0){
            alertify.warning("El usuario <b>" + usuario + "</b>, ya se encuentra creado, intente con otro nombre.");
            $("#usuario").trigger("focus");
          }
        }
      });
    }
  });

  //Formulario de usuario
  $("#formUsuario").on("submit", function(e){
    e.preventDefault();
    let id = $("#id").val().trim();
    let pass = $("#pass").val().trim();
    let RePass = $("#RePass").val().trim();
    
    if ($(this).valid()) {
      if (pass == RePass) {
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
              DTUsuarios.ajax.reload();
              $("#modalUsuario").modal("hide");
              $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
              $("#content-preview").addClass("d-none");
              $("#content-upload").removeClass("d-none");
              alertify.success(resp.msj);
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.warning("La contraseñas no coinciden, intentelo de nuevo");
        $("#pass").trigger("focus");
      }
    }
  });

  //Las condiciones del formulario password
  $("#formPass").validate({
    rules: {
      pass: "required",
      RePass: {
        equalTo: "#formPassPass"
      }
    }
  })

  $("#formPass").submit(function(e) {
    e.preventDefault();
    let pass = $(this).find("input[name='pass']").val().trim();
    let RePass = $(this).find("input[name='RePass']").val().trim();
    
    if ($(this).valid()) {
      if (pass == RePass) {
      $.ajax({ 
          url: rutaBase + "CambiarPass",
          type:'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: new FormData(this),
          success: function(resp){
            if (resp.success) {
              DTUsuarios.ajax.reload();
              $("#cambioPassModal").modal("hide");
              alertify.success(resp.msj);
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.warning("La contraseñas no coinciden, intentelo de nuevo");
        $(this).find("input[name='pass']").trigger("focus");
      }
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
        data: {id, checked, tipo: 2},
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