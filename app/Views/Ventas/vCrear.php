<style>
	div.dataTables_wrapper div.dataTables_filter input {
		width: 100%;
	}
</style>
<div class="row">
	<div class="col-7">
		<div class="card height-card-global">
			<div class="card-body">
				<form id="formVenta" class="formValid form-row">
					<input type="hidden" name="idVenta" id="idVenta">
					<div class="col-4 form-group mb-1">
						<label class="mb-0" for="nroVenta">Nro venta<span class="text-danger">*</span></label>
						<input type="text" id="nroVenta" name="nroVenta" class="form-control form-control-sm" disabled value="<?= $nroVenta ?>">
					</div>
					<div class="col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="metodoPago">Método de pago<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' ? 'disabled' : '' ?> id="metodoPago" required name="metodoPago" class="custom-select custom-select-sm select2" data-placeholder="Seleccione..." data-allow-clear="1">
							<option></option>
							<option value="1">Contado</option>
							<option value="2" selected>Credito</option>
						</select>
					</div>
					<div class="col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="vendedor">Vendedor<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' ? 'disabled' : '' ?> id="vendedor" required name="vendedor" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un vendedor..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<div class="col-8 form-group mb-1 form-valid">
						<label class="mb-0" for="sucursal">Sucursales<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' ? 'disabled' : '' ?> id="sucursal" required name="sucursal" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un sucursal..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<div class="col-4 form-group mb-1">
						<label class="mb-0" for="fechaVencimiento">Fecha de vencimiento<span class="text-danger">*</span></label>
						<input type="text" id="fechaVencimiento" name="fechaVencimiento" class="form-control form-control-sm" disabled>
					</div>
				</form>
				<div class="form-row">
					<div class="col-12">
						<hr class="my-2">
					</div>
					<div class="col-12">
						<div class="table-responsive">
							<table id="tblProductos" class="table table-sm table-striped table-hover table-bordered w-100">
								<thead>
									<tr>
										<th>Acción</th>
										<th>Referencia</th>
										<th>Descripción</th>
										<th>Pacas</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
					<div class="col-12">
						<hr class="my-2">
					</div>
					<div class="col-12 form-group mb-2">
						<label class="mb-0" for="observacion">Observacion</label>
						<textarea <?= $prefijoValido == 'N' ? 'disabled' : '' ?> class="form-control" name="observacion" id="observacion" rows="2" minlength="1" maxlength="500"></textarea>
					</div>
					<div class="col-4 mb-0" id="input-check-discount">
						<div class="input-group mt-4">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input type="checkbox" id="aplicarDescuento" aria-label="Checkbox for following text input">
								</div>
							</div>
							<input type="text" style="font-weight: bold;" disabled readonly class="form-control" value="¿Aplicar descuento?" aria-label="Text input with checkbox">
						</div>
					</div>
					<div class="col-4 mb-0 d-none" id="input-applied-discount">
						<label class="mb-0" for="descuentoAplicado">Descuento</label>
						<div class="input-group mb-0">
							<div class="input-group-prepend">
								<button type="button" id="removeDiscount" class="btn btn-danger"><i class="fas fa-trash"></i></button>
							</div>
							<input class="form-control inputPesos" type="text" name="descuentoAplicado" id="descuentoAplicado" value="0">
							<div class="input-group-append">
								<span class="input-group-text" id="percentageDiscount"></span>
							</div>
						</div>
					</div>
					<div class="col-4 form-group mb-0">
						<label class="mb-0" for="totalSinDescuento">Total sin descuento</label>
						<input class="form-control inputPesos" disabled type="text" name="totalSinDescuento" id="totalSinDescuento" value="0">
					</div>
					<div class="col-4 form-group mb-0">
						<label class="mb-0" for="total">Total</label>
						<input class="form-control inputPesos" disabled type="text" name="total" id="total" value="0">
					</div>
					<div class="col-12 d-flex align-items-end justify-content-end mt-3">

						<?php if(is_null($venta)) { ?>
							<button type="button" id="btnCancelarCreacion" class="btn btn-danger mr-2 deshabilitarboton"><i class="fas fa-times"></i> Cancelar</button>
						<?php } ?>

						<button <?= $prefijoValido == 'N' ? 'disabled' : '' ?> type="submit" form="formVenta" class="btn btn-success deshabilitarboton"><i class="fas fa-save"></i> Guardar</button>
					</div>
				</div> 
			</div>
		</div>
	</div>
	<div class="col-5">
		<div class="card height-card-global">
			<div class="card-header">
				<div class="row">
					<div class="col-12 col-md-5">
						<div class="input-group ml-2">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input id="verImg" type="checkbox" <?= $imagenProd == 1 ? 'checked' : '' ?>>
								</div>
							</div>
							<label for="verImg" class="form-control">¿Ver Imagenes?</label>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
					<thead>
						<tr>
							<th>Imagen</th>
							<th>Referencia</th>
							<th>Item</th>
							<th>Descripción</th>
							<th>Pac</th>
							<th>Stock</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$INVENTARIONEGATIVO = "<?= $inventario_negativo ?>";
	$CANTIDADVENDEDORES ="<?= $cantidadVendedores ?>";
	$CANTIDADCLIENTES ="<?= $cantidadClientes ?>";
	$PREFIJOVALIDO ="<?= $prefijoValido ?>";
	$NROVENTA = "<?= $nroVenta ?>";
	$DATOSVENTA = JSON.stringify(<?= json_encode(is_null(value: $venta) ? '' : $venta) ?>);
	$DATOSVENTA = $DATOSVENTA.length == 0 ? '' : JSON.parse($DATOSVENTA);
	$IMAGENPROD = <?= $imagenProd ?>;
	$CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
	$NOMBREEMPRESA = "<?= session()->get("nombreEmpresa") ?>";
	$DIASVENCIMIENTOFACTURAGENERAL = <?= $diasVencimientoFacturaGeneral ?>;
	$PORCENTAJEDESCUENTOFACTURAGENERAL = <?= $porcentajeDescuento ?>;
	$IDUSUARIO = "<?= session()->get("id_user") ?>";
	$NOMBREUSUARIO = "<?= session()->get("nombre") ?>";
</script>