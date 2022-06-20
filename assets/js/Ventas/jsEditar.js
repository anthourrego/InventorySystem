$DATOSVENTA = JSON.parse($DATOSVENTA);

$(function(){
  //Validamos si el numero de venta es diferente al crear
  if($NROVENTA != 0) {
    //Traemos los datos de la factura
    var vendedorOption = new Option($DATOSVENTA.NombreVendedor, $DATOSVENTA.id_vendedor, true, true);
    var clienteOption = new Option(($DATOSVENTA.NroDocumentoCliente + ' | ' + $DATOSVENTA.NombreCliente), $DATOSVENTA.id_cliente, true, true);

    console.log($DATOSVENTA);
    $("#metodoPago").val($DATOSVENTA.metodo_pago).trigger('change');
    $("#observacion").val($DATOSVENTA.observacion);
    $("#total").val($DATOSVENTA.total);
    $("#idVenta").val($DATOSVENTA.id);
    $('#vendedor').append(vendedorOption).trigger('change');
    $('#cliente').append(clienteOption).trigger('change');
    
    productosVentas = $DATOSVENTA.productos;
    DTProductosVenta.clear().rows.add(productosVentas).draw();
    DTProductos.ajax.reload();
  } else {
    alertify.alert('¡Advertencia!', `No hay factura para editar.`);
  }
});