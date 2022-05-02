let rutaBase = base_url() + "Ventas/";

let DT = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DT",
    type: "POST",
  },
  columns: [
    {data: 'codigo'},
    {data: 'NombreCliente'},
    {data: 'NombreVendedor'},
    {data: 'metodo_pago'},
    {data: 'neto'},
    {data: 'total'},
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
                  <button type="button" class="btn btn-info" title="Imprimir Factura"><i class="fa-solid fa-print"></i></button>
                  <button type="button" class="btn btn-success" title="Imprimir Pedido"><i class="fa-solid fa-file-pdf"></i></button>
                  <button type="button" class="btn btn-secondary btnEditar" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
                  <button type="button" class="btn btn-danger btnEliminar" title="Eliminar"><i class="fa-regular fa-trash-can"></i></button>
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".btnEliminar").click(function(e){
      e.preventDefault();
      eliminar(data);
    });

    /* $(row).find(".btnEditar").click(function(e){
      e.preventDefault();
      $("#modalCategoriasLabel").html(`<i class="fa-solid fa-edit"></i> Editar categoria`);
      $("#id").val(data.id);
      $("#nombre").val(data.nombre);
      $("#descripcion").val(data.descripcion);
      $("#fechaMod").val(moment(data.updated_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#fechaCre").val(moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY hh:mm:ss A"));
      $("#estado").val(data.Estadito);
      $(".form-group-edit").removeClass("d-none");
      $("#modalCategorias").modal("show");
    }); */
  }
});

function eliminar(data){
  alertify.confirm('Advertencia', `Esta seguro de eliminar la venta Nro <b>${data.codigo}</b>`, 
    function(){
      $.ajax({
        type: "POST",
        url: rutaBase + "Eliminar",
        dataType: 'json',
        data: {
          id: data.id,
        },
        success: function (resp) {
          if(resp.success){
            alertify.success(resp.msj);
            DT.ajax.reload();
          } else {
            alertify.error(resp.msj);
          }
        }
      });
    },function(){});
}