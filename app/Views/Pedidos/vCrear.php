<div class="row">
	<div class="col-7">
		<div class="card">
			<div class="card-body">
				<form id="formPedido" class="formValid form-row">
					<input type="hidden" name="idPedido" id="idPedido">
					<div class="col-4 form-group mb-1">
						<label class="mb-0">Nro pedido<span class="text-danger">*</span></label>
						<input type="text" id="nroPedido" name="nroPedido" class="form-control form-control-sm" disabled value="<?= $nroPedido ?>">
					</div>
					<div class="offset-4 col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="metodoPago">Método de pago<span class="text-danger">*</span></label>
						<select id="metodoPago" required name="metodoPago" class="custom-select custom-select-sm select2" data-placeholder="Seleccione..." data-allow-clear="1">
							<option></option>
							<option value="1">Contado</option>
							<option value="2">Credito</option>
						</select>
					</div>
					<div class="col-6 form-group mb-1 form-valid">
						<label class="mb-0" for="vendedor">Vendedor<span class="text-danger">*</span></label>
						<select id="vendedor" required name="vendedor" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un vendedor..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<div class="col-6 form-group mb-1 form-valid">
						<label class="mb-0" for="cliente">Cliente<span class="text-danger">*</span></label>
						<select id="cliente" required name="cliente" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un cliente..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<div class="col-6 form-group mb-1 form-valid">
						<label class="mb-0" for="sucursal">Sucursales<span class="text-danger">*</span></label>
						<select id="sucursal" required name="sucursal" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un sucursal..." data-allow-clear="1">
							<option></option>
						</select>
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
										<th>Nombre</th>
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
					<div class="col-12 form-group mb-0">
						<label class="mb-0" for="observacion">Observacion</label>
						<textarea class="form-control" name="observacion" id="observacion" rows="2" minlength="1" maxlength="500"></textarea>
					</div>
					<div class="col-4 form-group mb-0">
						<label class="mb-0" for="total">Total</label>
						<input class="form-control inputPesos" disabled type="text" name="total" id="total" value="0">
					</div>
					<div class="offset-4 col-4 d-flex align-items-end justify-content-end">
						<button type="submit" form="formPedido" class="btn btn-success"><i class="fas fa-save"></i> Guardar Pedido</button>
					</div>
				</div> 
			</div>
		</div>
	</div>
	<div class="col-5">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
						<thead> 
							<tr>
								<?php if ($imagenProd) { ?>
									<th>Imagen</th>
								<?php } ?>
								<th>Referencia</th>
								<th>Item</th>
								<th>Descripción</th>
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
</div>

<script>
	$INVENTARIONEGATIVO = "<?= $inventario_negativo ?>";
	$CANTIDADVENDEDORES ="<?= $cantidadVendedores ?>";
	$CANTIDADCLIENTES ="<?= $cantidadClientes ?>";
	$NROPEDIDO = "<?= $nroPedido ?>";
	$DATOSPEDIDO = '<?= is_null($pedido) ? '' : json_encode($pedido) ?>';
	$IMAGENPROD = <?= $imagenProd ?>;
	$CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
</script>