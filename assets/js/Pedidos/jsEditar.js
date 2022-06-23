$DATOSPEDIDO = JSON.parse($DATOSPEDIDO);

$(function(){
  //Validamos si el numero de pedido es diferente al crear
  if($NROPEDIDO != 0) {
    //Traemos los datos de la factura
    var vendedorOption = new Option($DATOSPEDIDO.NombreVendedor, $DATOSPEDIDO.id_vendedor, true, true);
    var clienteOption = new Option(($DATOSPEDIDO.NroDocumentoCliente + ' | ' + $DATOSPEDIDO.NombreCliente), $DATOSPEDIDO.id_cliente, true, true);

    $("#metodoPago").val($DATOSPEDIDO.metodo_pago).trigger('change');
    $("#observacion").val($DATOSPEDIDO.observacion);
    $("#total").val($DATOSPEDIDO.total);
    $("#idPedido").val($DATOSPEDIDO.id);
    $('#vendedor').append(vendedorOption).trigger('change');
    $('#cliente').append(clienteOption).trigger('change');
    
    productosPedido = $DATOSPEDIDO.productos;
    DTProductosPedido.clear().rows.add(productosPedido).draw();
    DTProductos.ajax.reload();
  } else {
    alertify.alert('¡Advertencia!', `No hay factura para editar.`);
  }
});