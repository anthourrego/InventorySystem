let rutaBase = base_url() + "Contabilidad/CatalogoCuentas/";

let arbolCuentas = null;

$(function () {

  $('[data-toggle="tooltip"]').tooltip()

  initData($CUENTAS);

  $("#formCuenta").submit(function (e) {
    e.preventDefault();
    let id = $("#id").val().trim();

    if ($(this).valid()) {

      $("#estado").is(':checked')

      let form = new FormData(this);
      form.set('estado', $("#estado").is(':checked'))

      let dataNode = getDataNode($("#idParent").val());
      let dataClasifica = dataClasificacion(dataNode.clasificacion);

      form.set('clasificacion', dataClasifica.valorhijo)

      $.ajax({
        url: rutaBase + (id.length > 0 ? "Editar" : "Crear"),
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: form,
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
          } else {
            alertify.alert('¡Advertencia!', resp.msj);
          }

          if (resp.cuentas) {
            arbolCuentas.destroy();
            $CUENTAS = resp.cuentas;
            initData(resp.cuentas);
          }

          selectFirst()
        }
      });
    }
  });

  $("#bnt-cancelar-form").on('click', function () {
    selectFirst()
  })

  selectFirst()
});

function initData(cuentas) {
  arbolCuentas = $('#tree').tree({
    uiLibrary: 'bootstrap4',
    dataSource: cuentas,
    checkboxes: false,
    select: false,
    cascadeCheck: false,
    primaryKey: 'id',
    icons: {
      expand: '<i class="fa fa-caret-right"></i>',
      collapse: '<i class="fa fa-caret-down"></i>'
    }
  });

  agregarIconosAgregar();

  /* // Aplica los iconos después de cargar el árbol
  arbolCuentas.on('dataBound', function () {
    console.log('Hola',)
    agregarIconosAgregar();
  }); */

  arbolCuentas.on('expand', function () {
    agregarIconosAgregar()
  });
}

function selectFirst() {
  $('.gj-list .list-group-item [data-role=display]').first().click()
}

function getDataNode(idNode, arrayData = $CUENTAS) {
  for (const element of arrayData) {
    if (element.id == idNode) return element;

    if (element.children.length) {
      let find = getDataNode(idNode, element.children)
      if (find) return find;
    }
  }
  return null;
}

function dataClasificacion(clasificacionCuenta) {
  for (const element of CLASIFICACIONCUENTACONTABILIDAD) {
    if (element.valor == clasificacionCuenta) {
      return element;
    }
  }
  return null;
}

function agregarIconosAgregar() {
  $('.gj-list .list-group-item').each(function () {

    let idNode = $(this).data('id');
    let dataNode = getDataNode(idNode);

    let dataClasifica = dataClasificacion(dataNode.clasificacion);

    if ($(this).find('.add-node-icon').length === 0 && dataClasifica.aplicahijo == "S" && dataNode.type == "CMA") {
      $(this).find('[data-role=display]').append('<span class="add-node-icon" style="margin-left: 10px; cursor: pointer;"><i class="fa-solid fa-plus"></i></span>');
    }

    if (($(this).find('.add-node-icon').length > 0 && ["", "N"].includes(dataClasifica.aplicahijo)) || (dataClasifica.aplicahijo === "S" && dataNode.type == "CMO")) {
      $(this).find('.add-node-icon').remove()
    }
  });

  $('.add-node-icon').off('click').on('click', function (e) {
    e.stopPropagation();

    let $item = $(this).closest('li');
    let nodeId = $item.attr('data-id');

    $("#idParent").val(nodeId);
    $("#id, #nombre, #codigo").val('');
    $("#tipo").val('CMA');
    $("#estado").prop("checked", true);

    $(".inputVer").prop("disabled", false);

    $(".btns-form").addClass('d-flex');
    $(".btns-form").removeClass('d-none');

    $("#btnHabilitarEditar, #btnEliminarCuenta").hide()
  });

  $('.gj-list .list-group-item [data-role=display]').off('click').on('click', function (e) {
    e.stopPropagation();

    let $item = $(this).closest('li');
    let nodeId = $item.attr('data-id');

    let dataNode = getDataNode(nodeId);

    $("#id").val(nodeId);
    $("#nombre").val(dataNode.nombre);
    $("#codigo").val(dataNode.codigo);
    $("#tipo").val(dataNode.type);
    $("#estado").prop("checked", dataNode.estado);
    $("#naturaleza").val(dataNode.naturaleza);
    console.log(dataNode)
    $("#comportamiento").val(dataNode.comportamiento);
    $("#idParent").val(dataNode.id_parent);

    $(".inputVer").prop("disabled", true);

    $(".btns-form").removeClass('d-flex');
    $(".btns-form").addClass('d-none');

    if (dataNode.solo_lectura != "1") {
      $("#btnHabilitarEditar").show()

      $("#btnHabilitarEditar").off('click').on('click', function () {
        $(".inputVer").prop("disabled", false);

        $(".btns-form").addClass('d-flex');
        $(".btns-form").removeClass('d-none');

        $("#btnHabilitarEditar").hide()
      });
    } else {
      $("#btnHabilitarEditar").hide()
    }
    
    if (dataNode.eliminable == '1') {
      $("#btnEliminarCuenta").show()

      $("#btnEliminarCuenta").off('click').on('click', function () {
        eliminar()
      })
    } else {
      $("#btnEliminarCuenta").hide()
    }
  });
}

function eliminar() {
  alertify.confirm('Cambiar estado', `Esta seguro de eliminar la cuenta <b>${$("#nombre").val()}</b>`,
    function () {
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          id: $("#id").val(),
        },
        success: function (resp) {
          if (resp.success) {
            alertify.success(resp.msj);
          } else {
            alertify.error(resp.msj);
          }

          if (resp.cuentas) {
            arbolCuentas.destroy();
            $CUENTAS = resp.cuentas;
            initData(resp.cuentas);
          }

          selectFirst()
        }
      });
    }, function () { });
}