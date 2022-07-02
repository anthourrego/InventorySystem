<div class="row">
	<div class="col-<?= (!(!is_null($pedido) && $pedido->estado == 2) ? '7' : '12') ?>">
		<div class="card">
			<div class="card-body">
				<form id="formPedido" class="formValid form-row">
					<input type="hidden" name="idPedido" id="idPedido">
					<div class="col-4 form-group mb-1">
						<label class="mb-0">Nro pedido<span class="text-danger">*</span></label>
						<input type="text" id="nroPedido" name="nroPedido" class="form-control form-control-sm" disabled value="<?= $nroPedido ?>">
					</div>
					<div class="col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="metodoPago">Método de pago<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || (!is_null($pedido) && $pedido->estado == 2) ? 'disabled' : '' ?>  id="metodoPago" required name="metodoPago" class="custom-select custom-select-sm select2" data-placeholder="Seleccione..." data-allow-clear="1">
							<option></option>
							<option value="1">Contado</option>
							<option value="2">Credito</option>
						</select>
					</div>
					<div class="col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="vendedor">Vendedor<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || (!is_null($pedido) && $pedido->estado == 2) ? 'disabled' : '' ?> id="vendedor" required name="vendedor" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un vendedor..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<div class="col-6 form-group mb-1 form-valid">
						<label class="mb-0" for="cliente">Cliente<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || (!is_null($pedido) && $pedido->estado == 2) ? 'disabled' : '' ?> id="cliente" required name="cliente" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un cliente..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<div class="col-6 form-group mb-1 form-valid">
						<label class="mb-0" for="sucursal">Sucursales<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || (!is_null($pedido) && $pedido->estado == 2) ? 'disabled' : '' ?> id="sucursal" required name="sucursal" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un sucursal..." data-allow-clear="1">
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
						<textarea <?= $prefijoValido == 'N' || (!is_null($pedido) && $pedido->estado == 2) ? 'disabled' : '' ?> class="form-control" name="observacion" id="observacion" rows="2" minlength="1" maxlength="500"></textarea>
					</div>
					<div class="col-4 form-group mb-0">
						<label class="mb-0" for="total">Total</label>
						<input class="form-control inputPesos" disabled type="text" name="total" id="total" value="0">
					</div>
					<div class="offset-4 col-4 d-flex align-items-end justify-content-end">
						<?php if(!(!is_null($pedido) && $pedido->estado == 2)) { ?>
							<button <?= $prefijoValido == 'N' ? 'disabled' : '' ?> type="submit" form="formPedido" class="btn btn-success"><i class="fas fa-save"></i> Guardar Pedido</button>
						<?php } ?>
					</div>
				</div> 
			</div>
		</div>
	</div>
	<?php if (!(!is_null($pedido) && $pedido->estado == 2)) { ?>
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
	<?php } ?>
</div>

<div class="modal fade" id="modalObservacion" data-backdrop="static" data-keyboard="false" aria-labelledby="modalObservacionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalObservacionLabel">Observación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<ul id="itemsModalObser"></ul>
				<div class="row">
					<div class="col-12 form-group form-valid">
						<label class="mb-0" for="observacionModal">Observación</label>
						<textarea class="form-control inputVer" id="observacionModal" name="observacionModal" minlength="1" maxlength="500" placeholder="Observación" rows="3" autocomplete="off"></textarea>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnConfirmObser"><i class="fas fa-check"></i> Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
	$INVENTARIONEGATIVO = "<?= $inventario_negativo ?>";
	$CANTIDADVENDEDORES ="<?= $cantidadVendedores ?>";
	$CANTIDADCLIENTES ="<?= $cantidadClientes ?>";
	$PREFIJOVALIDO ="<?= $prefijoValido ?>";
	$NROPEDIDO = "<?= $nroPedido ?>";
	$DATOSPEDIDO = '<?= is_null($pedido) ? '' : json_encode($pedido) ?>';
	$IMAGENPROD = <?= $imagenProd ?>;
	$CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
</script>