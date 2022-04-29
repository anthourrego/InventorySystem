<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-8 col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="selectEstado">Estado</label>
          </div>
          <select class="custom-select" id="selectEstado">
            <option selected value="1">Activo</option>
            <option value="0">Inactivo</option>
            <option value="-1">Todos</option>
          </select>
        </div>
      </div>
      <div class="col-5 col-md-3 text-right">
        <button type="button" class="btn btn-primary" id="btnCrear"><i class="fa-solid fa-plus"></i> Crear</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
        <thead> 
          <tr>
            <th>Nro Documento</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Administrador</th>
            <th>Catera</th>
            <th>Teléfono cartera</th>
            <th>Total Compras</th>
            <th>Ultima compra</th>
            <th>Fecha creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalClientes" data-backdrop="static" data-keyboard="false" aria-labelledby="modalClientesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalClientesLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formClientes" class="formValid">
          <input type="hidden" name="id" id="id">
          <div class="form-row">
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="documento">Nro documento</label>
              <input placeholder="Ingresar nro documento" class="form-control soloNumeros" id="documento" name="documento" type="tel" minlength="1" maxlength="30" autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
              <input placeholder="Ingresar nombre" class="form-control soloLetrasEspacio" id="nombre" name="nombre" type="text" minlength="1" maxlength="255" required autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="direccion">Dirección <span class="text-danger">*</span></label>
              <input placeholder="Ingresar dirección" class="form-control soloLetrasEspacioCaracteres" id="direccion" name="direccion" type="text" minlength="1" maxlength="300" required autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="telefono">Teléfono <span class="text-danger">*</span></label>
              <input placeholder="Ingresar teléfono" class="form-control soloNumeros inputTel" id="telefono" name="telefono" type="tel" minlength="10" maxlength="50" required autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="administrador">Administrador</label>
              <input placeholder="Ingresar administrador" class="form-control soloLetrasEspacio" id="administrador" name="administrador" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="cartera">Cartera</label>
              <input placeholder="Ingresar encargado cartera" class="form-control soloLetrasEspacio" id="cartera" name="cartera" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-12 form-group form-valid mb-1">
              <label class="mb-0" for="telefonoCart">Teléfono cartera</label>
              <input placeholder="Ingresar teléfono cartera" class="form-control soloNumeros inputTel" id="telefonoCart" name="telefonoCart" type="tel" minlength="10" maxlength="50" autocomplete="off">
            </div>
            <div class="col-6 form-group form-group-edit mb-1">
              <label class="mb-0" for="cantCompras">Cantidad compras</label>
              <input class="form-control" id="cantCompras" disabled>
            </div>
            <div class="col-6 form-group form-group-edit mb-1">
              <label class="mb-0" for="fechaCompra">Ultima compra</label>
              <input class="form-control" id="fechaCompra" disabled>
            </div>
            <div class="col-6 form-group form-group-edit mb-1">
              <label class="mb-0" for="fechaMod">Fecha modificación</label>
              <input class="form-control" id="fechaMod" disabled>
            </div>
            <div class="col-6 form-group form-group-edit mb-1">
              <label class="mb-0" for="fechaCre">Fecha creación</label>
              <input class="form-control" id="fechaCre" disabled>
            </div>
            <div class="col-6 form-group form-group-edit mb-1">
              <label class="mb-0" for="estado">Estado</label>
              <input class="form-control" id="estado" disabled>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formClientes"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>