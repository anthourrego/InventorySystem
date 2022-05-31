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

    $(row).find(".btnEditar").click(function(e){
      e.preventDefault();
      window.location.href = base_url() + 'Ventas/Editar/'+data.id.trim();
    });
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