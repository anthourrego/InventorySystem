$DATOSVENTA = JSON.parse($DATOSVENTA);

$(function(){
  //Validamos si el numero de venta es diferente al crear
  if($NROVENTA != 0) {
    //Traemos los datos de la factura
    
    console.log($DATOSVENTA);
    $("#metodoPago").val($DATOSVENTA.metodo_pago).change();
    $("#vendedor").data("id", $DATOSVENTA.id_vendedor).val($DATOSVENTA.Vendedor).closest(".input-group").find(".input-group-text").text($DATOSVENTA.NombreVendedor);
    $("#cliente").data("id", $DATOSVENTA.id_cliente).val($DATOSVENTA.NroDocumentoCliente).closest(".input-group").find(".input-group-text").text($DATOSVENTA.NombreCliente);
    $("#observacion").val($DATOSVENTA.observacion);
    $("#total").val($DATOSVENTA.total);
    $("#idVenta").val($DATOSVENTA.id);

    productosVentas = $DATOSVENTA.productos;
    DTProductosVenta.clear().rows.add(productosVentas).draw();
    DTProductos.ajax.reload();
  } else {
    alertify.alert('¡Advertencia!', `No hay factura para editar.`);
  }
});