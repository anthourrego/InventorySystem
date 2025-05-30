<style>
	div.dataTables_wrapper div.dataTables_filter input {
		width: 100%;
	}
</style>
<div class="row">
	<div class="col-<?= ($editarPedido == 'S' ? '7' : '12') ?>">
		<div class="card height-card-global">
			<div class="card-body">
				<form id="formPedido" class="formValid form-row">
					<input type="hidden" name="idPedido" id="idPedido">
					<div class="col-4 form-group mb-1">
						<label class="mb-0">Nro pedido<span class="text-danger">*</span></label>
						<input type="text" id="nroPedido" name="nroPedido" class="form-control form-control-sm" disabled value="<?= $nroPedido ?>">
					</div>
					<div class="col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="metodoPago">Método de pago<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || $editarPedido == 'N' ? 'disabled' : '' ?>  id="metodoPago" required name="metodoPago" class="custom-select custom-select-sm select2" data-placeholder="Seleccione..." data-allow-clear="1">
							<option></option>
							<option value="1">Contado</option>
							<option value="2" selected>Credito</option>
						</select>
					</div>
					<div class="col-4 form-group mb-1 form-valid">
						<label class="mb-0" for="vendedor">Vendedor<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || $editarPedido == 'N' ? 'disabled' : '' ?> id="vendedor" required name="vendedor" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un vendedor..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
					<!-- <div class="col-6 form-group mb-1 form-valid">
						<label class="mb-0" for="cliente">Cliente<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || $editarPedido == 'N' ? 'disabled' : '' ?> id="cliente" required name="cliente" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un cliente..." data-allow-clear="1">
							<option></option>
						</select>
					</div> -->
					<div class="col-12 form-group mb-1 form-valid">
						<label class="mb-0" for="sucursal">Sucursales<span class="text-danger">*</span></label>
						<select <?= $prefijoValido == 'N' || $editarPedido == 'N' ? 'disabled' : '' ?> id="sucursal" required name="sucursal" class="custom-select custom-select-sm select2" data-placeholder="Seleccione un sucursal..." data-allow-clear="1">
							<option></option>
						</select>
					</div>
				</form>     
				<div class="form-row">
					<div class="col-12">
						<hr class="my-2">
					</div>
					<div class="col-12">
						<form enctype="multipart/form-data" accept-charset="utf-8" name="frmExcel" id="frm-Excel">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupFileAddon01">Subir</span>
								</div>
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="excelFile" name="excelFile" accept=".csv, application/vnd.ms-excel,xls,csv,application/xml,application/zip,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vn.openxmlformats-officedocument.spreadsheetml.sheet" aria-describedby="inputGroupFileAddon01">
									<label class="custom-file-label" for="excelFile" data-browse="Elegir">Seleccionar Archivo</label>
								</div>
							</div>	
						</form>
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
					<div class="col-12 form-group mb-0">
						<label class="mb-0" for="observacion">Observacion</label>
						<textarea <?= $prefijoValido == 'N' || $editarPedido == 'N' ? 'disabled' : '' ?> class="form-control" name="observacion" id="observacion" rows="2" minlength="1" maxlength="500"></textarea>
					</div>
					<div class="col-4 form-group mb-0">
						<label class="mb-0" for="total">Total</label>
						<input class="form-control inputPesos" disabled type="text" name="total" id="total" value="0">
					</div>
					<div class="offset-4 col-4 d-flex align-items-end justify-content-end">
						<?php if(is_null($pedido)) { ?>
							<button type="button" id="btnCancelarCreacion" class="btn btn-danger mr-2 deshabilitarboton"><i class="fas fa-times"></i> Cancelar</button>
						<?php } ?>
						<?php if($editarPedido == 'S') { ?>
							<button <?= $prefijoValido == 'N' ? 'disabled' : '' ?> type="submit" form="formPedido" class="btn btn-success deshabilitarboton"><i class="fas fa-save"></i> Guardar</button>
						<?php } ?>
					</div>
				</div> 
			</div>
		</div>
	</div>
	<?php if ($editarPedido == 'S') { ?>
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
	<?php } ?>
</div>

<div class="modal fade" id="modalObservacion" data-backdrop="static" data-keyboard="false" aria-labelledby="modalObservacionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalObservacionLabel">Observación</h5>
      </div>
      <div class="modal-body">
				<ul id="itemsModalObser"></ul>
				<div class="row">
					<div class="col-12 form-valid">
						<label for="motivoModal" class="mb-0">Motivo</label>
						<select class="form-control" id="motivoModal">
							<?php foreach (MOTIVOSDEVOLUCION as $key => $value) {
                echo '<option value="' . $value['valor'] . '">' . $value['titulo'] . '</option>';
              }
              ?>
						</select>
					</div>
					<div class="col-12 form-group form-valid">
						<label class="mb-0" for="observacionModal">Observación</label>
						<textarea class="form-control inputVer" id="observacionModal" name="observacionModal" minlength="1" maxlength="500" placeholder="Observación" rows="3" autocomplete="off"></textarea>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnConfirmObser"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
	$INVENTARIONEGATIVO = "<?= $inventario_negativo ?>";
	$CANTIDADDESPACHAR = <?= $cantidad_despachar ?>;
	$CANTIDADVENDEDORES ="<?= $cantidadVendedores ?>";
	$CANTIDADCLIENTES ="<?= $cantidadClientes ?>";
	$PREFIJOVALIDO ="<?= $prefijoValido ?>";
	$NROPEDIDO = "<?= $nroPedido ?>";
	$DATOSPEDIDO = JSON.stringify(<?= json_encode(is_null($pedido) ? '' : $pedido) ?>);
	$DATOSPEDIDO = $DATOSPEDIDO.length == 0 ? '' : JSON.parse($DATOSPEDIDO);
	$IMAGENPROD = <?= $imagenProd ?>;
	$CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
	$EDITARPEDIDO = "<?= $editarPedido ?>";
	$NOMBREEMPRESA = "<?= session()->get("nombreEmpresa") ?>";
	$IDUSUARIO = "<?= session()->get("id_user") ?>";
	$NOMBREUSUARIO = "<?= session()->get("nombre") ?>";
</script>