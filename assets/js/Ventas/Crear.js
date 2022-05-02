let rutaBase = base_url() + "Ventas/";
let productosVentas = [];

let DTProductos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function(d){
      return $.extend(d, {"estado": 1} )
    }
  },
  dom: domlftrip,
  order: [[2, "asc"]],
  columns: [
    {
      orderable: false,
      searchable: false,
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
    {
      data: 'stock',
      render: function(meta, type, data, meta) {
        //Se coloca el color según el stock
        let btnColor = "success";
        if (data.stock <= 0) {
          btnColor = "danger";
        } else if (data.stock > 0 &&  data.stock <= 24) {
          btnColor = "warning";
        }  

        return `<button class="btn btn-${btnColor}">${data.stock}</button>`;
      }
    },
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center',
      render: function(meta, type, data, meta) {
        let btn = true;
        let resultado = productosVentas.find((it) => it.id == data.id);

        if (resultado){
          btn = false;
        } 

        return `<div class="btn-group btn-group-sm" role="group">
                  <button id="p${data.id}" type="button" class="btn btn-primary btnAdd ${(btn == true ? '' : 'disabled')}" ${(btn == true ? '' : 'disabled')} title="Agregar"><i class="fa-solid fa-plus"></i></button>
                </div>`;
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".btnAdd").on("click", function(){
      let result = productosVentas.find((it) => it.id == data.id);
      if (result) {
        alertify.error("Este producto ya se encuentra agregado");
      } else {
        $("#p" + data.id).addClass("disabled").prop("disabled", true);
        data.cantidad = 1;
        data.valorTotal = data.precio_venta;
        productosVentas.push(data);
        DTProductosVenta.clear().rows.add(productosVentas).draw();
      }
    });
  }
});

let DTProductosVenta = $("#tblProductos").DataTable({
  data: productosVentas,
  dom: domlftrip,
  processing: false,
	serverSide: false,
  columns: [
    {
      orderable: false,
      searchable: false,
      defaultContent: '',
      className: 'text-center',
      render: function(meta, type, data, meta) {
        return `<div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-danger btnBorrar" title="Borrar Producto"><i class="fa-solid fa-times"></i></button>
                </div>`;
      }
    },
    {
      data: 'item',
      width: "30%",
      render: function(meta, type, data, meta) {
        return `<span title="${data.item} - ${data.descripcion}" class="text-descripcion">${data.item} - ${data.descripcion}</span>`;
      }
    },
    {
      data: 'cantidad',
      render: function(meta, type, data, meta) {
        return `<input type="number" class="form-control form-control-sm cantidadProduct inputFocusSelect soloNumeros" min="1" value="${data.cantidad}">`;
      }
    },
    {
      data: 'valorTotal',
      className: 'text-right valorTotal',
      render: function(meta, type, data, meta) {
        return formatoPesos.format(data.valorTotal);
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".cantidadProduct").on("change", function(){
      let cant = $(this).val().trim();
      let resultado = productosVentas.find((it) => it.id == data.id);
      console.log(cant);
      console.log(data.stock);
      console.log((cant <= data.stock));
      if (cant <= data.stock) {
        resultado.cantidad = $(this).val().trim();
        resultado.valorTotal = resultado.cantidad * resultado.precio_venta;
  
        $(row).find(".valorTotal").text(formatoPesos.format(resultado.valorTotal));
        calcularTotal();
      } else {
        alertify.alert("Advertencia", `Ha superado la cantidad maxima, solo hay <b>${data.stock}</b> disponibles`);
        resultado.cantidad = 1;
        resultado.valorTotal = resultado.precio_venta;
        $(this).val(1);
        $(row).find(".valorTotal").text(formatoPesos.format(data.precio_venta));
      }
    })
  }
});

$(function(){
  $("#vendedor").on("change", function(e){
    e.preventDefault();
    selfi = this
    selfValue = $(selfi).val().trim();
    if(selfValue != lastFocusValue){
      if(selfValue.length > 0){
        $.ajax({
          type: "POST",
          url: base_url() + "Busqueda/Vendedor",
          dataType: 'json',
          data: {
            buscar: selfValue,
          },
          success: function (resp) {
            if(resp.success){
              $(selfi).val(resp.data.usuario);
              $(selfi).next(".input-group-append").find("span").text(resp.data.nombre);
            } else {
              selfValue = selfValue == "." ? "" : selfValue;
              alertify.ajaxAlert = function(url){
                $.ajax({
                  url: url,
                  async: false,
                  success: function(data){
                    alertify.busquedaAlert(data);
                    $("#tblBusqueda").DataTable({
                      ajax: {
                        url: base_url() + "Busqueda/Vendedores",
                        type: "POST",
                        data: {estado: 1}
                      },
                      dom: domSearch,
                      oSearch: { sSearch: selfValue },
                      columns: [
                        {data: 'usuario'},
                        {data: 'nombre'},
                      ],
                      deferRender: true,
                      scrollY: screen.height - 500,
                      scroller: {
                        loadingIndicator: true
                      },
                      createdRow: function(row,data,dataIndex){
                        $(row).click(function(){
                          busquedaModal = false;
                          lastFocus.val(data.usuario).change();
                          lastFocusValue = data.usuario;
                          alertify.busquedaAlert().close();
                        });
                      },
                    });
                  }
                });
              }
              var campos = encodeURIComponent(JSON.stringify(['Usuario', 'Nombre']));
              alertify.ajaxAlert(base_url() + "Busqueda/DT?campos="+campos);
            }
          }
        });
      } else {
        $(selfi).val("");
        $(selfi).next(".input-group-append").find("span").text("");
      }
    }
  });

  $("#cliente").on("change", function(e){
    e.preventDefault();
    selfi = this
    selfValue = $(selfi).val().trim();
    if(selfValue != lastFocusValue){
      if(selfValue.length > 0){
        $.ajax({
          type: "POST",
          url: base_url() + "Busqueda/Cliente",
          dataType: 'json',
          data: {
            buscar: selfValue,
          },
          success: function (resp) {
            if(resp.success){
              $(selfi).val(resp.data.documento);
              $(selfi).next(".input-group-append").find("span").text(resp.data.nombre);
            } else {
              selfValue = selfValue == "." ? "" : selfValue;
              alertify.ajaxAlert = function(url){
                $.ajax({
                  url: url,
                  async: false,
                  success: function(data){
                    alertify.busquedaAlert(data);
                    $("#tblBusqueda").DataTable({
                      ajax: {
                        url: base_url() + "Busqueda/Clientes",
                        type: "POST",
                        data: {estado: 1}
                      },
                      dom: domSearch,
                      oSearch: { sSearch: selfValue },
                      columns: [
                        {data: 'documento'},
                        {data: 'nombre'},
                      ],
                      deferRender: true,
                      scrollY: screen.height - 500,
                      scroller: {
                        loadingIndicator: true
                      },
                      createdRow: function(row,data,dataIndex){
                        $(row).click(function(){
                          busquedaModal = false;
                          lastFocus.val(data.documento).focusin().change();
                          lastFocusValue = data.documento;
                          alertify.busquedaAlert().close();
                        });
                      },
                    });
                  }
                });
              }
              var campos = encodeURIComponent(JSON.stringify(['Nro Documento', 'Nombre']));
              alertify.ajaxAlert(base_url() + "Busqueda/DT?campos="+campos);
            }
          }
        });
      } else {
        $(selfi).val("");
        $(selfi).next(".input-group-append").find("span").text("");
      }
    }
  });

  $("#formVenta").submit(function(e){
    e.preventDefault();
    if ($(this).valid()) {
      if (productosVentas.length > 0) {

      } else {
        alertify.alert("Advertencia", "Debe de elegiar minimo un producto para guardar la venta.");
      }
    }
  });
});

function calcularTotal(){

}