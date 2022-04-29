let rutaBase = base_url() + "Usuarios/";

let DTUsuarios = $("#table").DataTable({
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
        return `<div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-user-pen"></i></button>
                  <button type="button" class="btn btn-info btnCambiarPass" title="Cambiar Contraseña"><i class="fa-solid fa-user-lock"></i></button>
                  <button type="button" class="btn btn-${data.estado == "1" ? "danger" : "success"} btnCambiarEstado" title="${data.estado == "1" ? "Ina" : "A"}ctivar"><i class="fa-solid fa-user-${data.estado == "1" ? "large-slash" : "check"}"></i></button>
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
    $(row).find(".btnEditar").click(function(e){
      e.preventDefault();
      $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-pen"></i> Editar usuario`);
      console.log(data);
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#usuario").val(data.usuario);
      $("#perfil").val((data.perfilId == null ? 0 : data.perfilId)).trigger('change');
      $("#fechaLog").val(moment(data.ultimo_login, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $("#editFoto").val(0);
      if (data.foto != null) {
        $("#foto").val('');
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
      console.log(data);
      $("#formPass input[name='id'").val(data.id);

      $("#cambioPassModal").modal("show");
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
    $("#id").val("");
    $("#editFoto").val(0);
    $("#foto").val('');
    $('#imgFoto').attr('src', base_url() + "Usuarios/Foto");
    $("#content-preview").addClass("d-none");
    $("#content-upload").removeClass("d-none");
    $("#modalUsuarioLabel").html(`<i class="fa-solid fa-user-plus"></i> Crear usuario`);
    $(".form-group-edit").addClass("d-none");
    $("#pass, #RePass").closest(".form-group").removeClass("d-none");
    $("#modalUsuario").modal("show");
    $('#modalUsuario').on('shown.bs.modal	', function (event) {
      $("#usuario").trigger('focus');
    });
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