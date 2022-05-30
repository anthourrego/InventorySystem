let rutaBase = base_url() + "Ventas/";
let productosVentas = [];

let DTProductos = $("#table").DataTable({
  ajax: {
    url: rutaBase + "DTProductos",
    type: "POST",
    data: function(d){
      return $.extend(d, {"estado": 1, "ventas": 1} )
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
        data.valorUnitario = data.precio_venta;
        data.valorTotal = data.precio_venta;
        productosVentas.push(data);
        DTProductosVenta.clear().rows.add(productosVentas).draw();
      }
      calcularTotal();
    });
  }
});

let DTProductosVenta = $("#tblProductos").DataTable({
  data: productosVentas,
  dom: domSearch1,
  processing: false,
	serverSide: false,
  order: [[1, "asc"]],
  scrollY: screen.height - 750,
  scroller: {
    loadingIndicator: true
  },
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
      orderable: false,
      searchable: false,
      data: 'cantidad',
      render: function(meta, type, data, meta) {
        return `<input type="number" class="form-control form-control-sm cantidadProduct inputFocusSelect soloNumeros" min="1" value="${data.cantidad}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorUnitario',
      render: function(meta, type, data, meta) {
      return `<input type="tel" class="form-control form-control-sm inputPesos text-right inputFocusSelect soloNumeros valorUnitario" min="0" value="${data.valorUnitario}">`;
      }
    },
    {
      orderable: false,
      searchable: false,
      data: 'valorTotal',
      className: 'text-right valorTotal',
      render: function(meta, type, data, meta) {
        return formatoPesos.format(data.valorTotal);
      }
    },
  ],
  createdRow: function(row, data, dataIndex){
    $(row).find(".cantidadProduct, .valorUnitario").on("change", function(){
      let cant = Number($(row).find(".cantidadProduct").val().trim());
      let valorUnitario = $(row).find(".valorUnitario").val().trim().replaceAll(",", "").replaceAll("$ ", "");
      let resultado = productosVentas.find((it) => it.id == data.id);
      
      //Validamos si puede asignar inventario negativo
      if (($INVENTARIONEGATIVO == "1") || ($INVENTARIONEGATIVO == "0" && cant <= Number(data.stock))) {
        resultado.cantidad = cant;
        resultado.valorUnitario = valorUnitario;
        resultado.valorTotal = resultado.cantidad * resultado.valorUnitario;
  
        $(row).find(".valorTotal").text(formatoPesos.format(resultado.valorTotal));
      } else {
        alertify.alert("Advertencia", `Ha superado la cantidad maxima, solo hay <b>${data.stock}</b> disponibles`);
        resultado.cantidad = 1;
        resultado.valorTotal = resultado.valorUnitario;
        $(this).val(1);
        $(row).find(".valorTotal").text(formatoPesos.format(data.valorUnitario));
      }

      data = resultado;

      calcularTotal();
    });

    $(row).find(".btnBorrar").click(function(e){
      e.preventDefault();
      productosVentas = productosVentas.filter(it => it.id != data.id);
      DTProductosVenta.clear().rows.add(productosVentas).draw();
      $("#p"+data.id).removeClass("disabled").prop("disabled", false);
      calcularTotal();
    });
  },
  drawCallback: function( settings ) {
    inputPesos();
  }
});

$(function(){
  if ($CANTIDADVENDEDORES == 0 || $CANTIDADCLIENTES == 0) {
    if ($CANTIDADVENDEDORES == 0 && $CANTIDADCLIENTES == 0) {
      $msj = "vendedore y clientes";
    } else {
      $msj = $CANTIDADVENDEDORES == 0 ? "vendedores" : "clientes";
    }

    alertify.alert('¡Advertencia!', `No hay ${$msj} disponibles.`);
  }

  $("#vendedor").on("focusout, change", function(e){
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
            vendedor: 1
          },
          success: function (resp) {
            if(resp.success){
              $(selfi).val(resp.data.usuario).data("id", resp.data.id);
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
                        data: {estado: 1, vendedor: 1}
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
                          lastFocus.data("id", "");
                          lastFocus.val(data.usuario).focusin().change();
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
        $(selfi).val("").data("id", "");
        $(selfi).next(".input-group-append").find("span").text("");
      }
    }
  });

  $("#cliente").on("focusout, change", function(e){
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
              $(selfi).val(resp.data.documento).data("id", resp.data.id);
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
                          lastFocus.data("id", "")
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
        $(selfi).val("").data("id", "");
        $(selfi).next(".input-group-append").find("span").text("");
      }
    }
  });

  $("#formVenta").submit(function(e){
    e.preventDefault();
    if ($(this).valid()) {
      if (productosVentas.length > 0) {
        form = new FormData(this);
        form.append("idCliente", $("#cliente").data("id"));
        form.append("idUsuario", $("#vendedor").data("id"));
        form.append("observacion", $("#observacion").val());
        form.append("productos", JSON.stringify(productosVentas));
        
        $.ajax({ 
          url: rutaBase + "Crear",
          type:'POST',
          dataType: 'json',
          processData: false,
          contentType: false,
          cache: false,
          data: form,
          success: function(resp){
            if (resp.success) {
              alertify.confirm("Venta creada correctamente", `Nro de venta: <b>${resp.msj.codigo}</b> por valor de <b>${formatoPesos.format(resp.msj.total)}</b><br>Quiere crear una nueva venta?`, 
                function(){
                  productosVentas = [];
                  $("#nroVenta").val(resp.msj.codigo + 1);
                  $("#cliente, #vendedor").data("id", "").closest(".input-group").find(".input-group-text").text("");
                  $("#observacion").val("");
                  $("#total").val(0)
                  DTProductos.ajax.reload();
                  DTProductosVenta.clear().rows.add(productosVentas).draw();
                  resetForm("#formVenta");
                }, 
                function(){ 
                  window.location.href = base_url() + 'Ventas/Administrar';
                });
            } else {
              alertify.alert('¡Advertencia!', resp.msj);
            }
          }
        });
      } else {
        alertify.alert("Advertencia", "Debe de elegiar minimo un producto para guardar la venta.");
      }
    }
  });
});

function calcularTotal(){
  sumTotal = 0;
  productosVentas.forEach((it) => {
    sumTotal += Number(it.valorTotal);
  });

  $("#total").val(sumTotal);
}