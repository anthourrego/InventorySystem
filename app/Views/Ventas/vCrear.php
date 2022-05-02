<div class="row">
  <div class="col-7">
    <div class="card">
      <div class="card-body">
        <form id="formVenta" class="formValid form-row">
          <div class="col-4 form-group mb-1">
            <label class="mb-0">Nro venta<span class="text-danger">*</span></label>
            <input type="text" id="nroVenta" name="nroVenta" class="form-control form-control-sm" disabled value="<?= $nroVenta ?>">
          </div>
          <div class="offset-4 col-4 form-group mb-1 form-valid">
            <label class="mb-0" for="metodoPago">Método de pago<span class="text-danger">*</span></label>
            <select id="metodoPago" required name="metodoPago" class="custom-select custom-select-sm select2" data-placeholder="Seleccione..." data-allow-clear="1">
              <option></option>
              <option value="Contado">Contado</option>
              <option value="Credito">Credito</option>
            </select>
          </div>
          <div class="col-12 form-group mb-1 form-valid">
            <label class="mb-0" for="vendedor">Vendedor <span class="text-danger">*</span></label>
            <div class="input-group input-group-sm">
              <input type="text" data-id="" id="vendedor" name="vendedor" required class="form-control form-control-sm lastFocus" autocomplete="off" placeholder="Vendedor">
              <div class="input-group-append w-75">
                <span class="input-group-text w-100"></span>
              </div>
            </div>
          </div>
          <div class="col-12 form-group mb-1 form-valid">
            <label class="mb-0" for="cliente">Cliente <span class="text-danger">*</span></label>
            <div class="input-group input-group-sm">
              <input type="text" data-id="" id="cliente" name="cliente" required class="form-control form-control-sm lastFocus" autocomplete="off" placeholder="Cliente">
              <div class="input-group-append w-75">
                <span class="input-group-text w-100"></span>
              </div>
            </div>
          </div>
        </form>     
        <div class="form-row">
          <div class="col-12">
            <hr class="my-2">
          </div>
          <div class="col-12">
            <!-- <label class="mb-0">Productos <span class="text-danger">*</span></label> -->
            <div class="table-responsive">
              <table id="tblProductos" class="table table-sm table-striped table-hover table-bordered w-100">
                <thead> 
                  <tr>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th >Precio</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <div class="col-12">
            <hr class="my-2">
          </div>
          <div class="col-4 form-group mb-0">
            <label class="mb-0" for="total">Total</label>
            <input class="form-control inputPesos" disabled type="text" name="total" id="total" value="0">
          </div>
          <div class="offset-4 col-4 d-flex align-items-end justify-content-end">
            <button type="submit" form="formVenta" class="btn btn-success"><i class="fas fa-save"></i> Guardar Venta</button>
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
                <th>Imagen</th>
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