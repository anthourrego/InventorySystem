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
      <?php if (validPermissions([41], true)) { ?>
        <div class="col-5 col-md-3 text-right">
          <button type="button" class="btn btn-primary" id="btnCrear"><i class="fa-solid fa-plus"></i> Crear</button>
        </div>
      <?php } ?>
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
  <div class="modal-dialog modal-lg modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalClientesLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link border-bottom active" id="cliente-tab" data-toggle="tab" href="#clienteTab" role="tab" aria-controls="clienteTab" aria-selected="true">Datos Basicos</a>
          </li>
          <?php if (validPermissions([44], true)) { ?>
            <li class="nav-item" role="presentation">
              <a class="nav-link border-bottom" id="sucursales-tab" data-toggle="tab" href="#sucursalesTab" role="tab" aria-controls="sucursalesTab" aria-selected="false">Sucursales</a>
            </li>
          <?php } ?>
        </ul>
          <div class="tab-content" id="contentTab">
            <div class="tab-pane fade show active" id="clienteTab" role="tabpanel" aria-labelledby="cliente-tab">
            
              <form id="formClientes" class="formValid">
                <input type="hidden" class="inputVer" name="id" id="id"> 
                <div class="form-row">
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="documento">Nro documento</label>
                    <input placeholder="Ingresar nro documento" class="form-control soloNumeros inputVer" id="documento" name="documento" type="tel" minlength="1" maxlength="30" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
                    <input placeholder="Ingresar nombre" class="form-control soloLetrasEspacio inputVer" id="nombre" name="nombre" type="text" minlength="1" maxlength="255" required autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="direccion">Dirección <span class="text-danger">*</span></label>
                    <input placeholder="Ingresar dirección" class="form-control soloLetrasEspacioCaracteres inputVer" id="direccion" name="direccion" type="text" minlength="1" maxlength="300" required autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="telefono">Teléfono <span class="text-danger">*</span></label>
                    <input placeholder="Ingresar teléfono" class="form-control soloNumeros inputTel inputVer" id="telefono" name="telefono" type="tel" minlength="10" maxlength="50" required autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="administrador">Administrador</label>
                    <input placeholder="Ingresar administrador" class="form-control soloLetrasEspacio inputVer" id="administrador" name="administrador" type="text" minlength="1" maxlength="255" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="cartera">Cartera</label>
                    <input placeholder="Ingresar encargado cartera" class="form-control soloLetrasEspacio inputVer" id="cartera" name="cartera" type="text" minlength="1" maxlength="255" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 form-group form-valid mb-1">
                    <label class="mb-0" for="telefonoCart">Teléfono cartera</label>
                    <input placeholder="Ingresar teléfono cartera" class="form-control soloNumeros inputTel inputVer" id="telefonoCart" name="telefonoCart" type="tel" minlength="10" maxlength="50" autocomplete="off">
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

            <div class="tab-pane fade" id="sucursalesTab" role="tabpanel" aria-labelledby="sucursales-tab">

                <div class="accordion mt-2" id="accordionExample">
                  <div class="card">
                    <div class="card-header" id="cabeceraDatos">
                      <h2 class="mb-0 d-flex" data-toggle="collapse" data-target="#collapseDatosBasicos" aria-expanded="true" aria-controls="collapseDatosBasicos">
                        <button class="btn btn-block text-left" type="button">
                          Datos Basicos
                        </button>
                        <i class="icono-collapse fas fa-arrow-down"></i>
                      </h2>
                    </div>

                    <div id="collapseDatosBasicos" class="p-3 collapse" aria-labelledby="cabeceraDatos" data-parent="#accordionExample">
                      <form id="formSucursal" class="formValid">
                        <input type="hidden" class="inputVer" name="idSucursal" id="idSucursal">
                        <div class="form-row">
                          <div class="col-12 col-md-6 form-group form-valid mb-1">
                            <label class="mb-0" for="nombreSucursal">Nombre <span class="text-danger">*</span></label>
                            <input placeholder="Ingresar nombre" class="form-control soloLetrasEspacio inputVer" id="nombreSucursal" name="nombreSucursal" type="text" minlength="1" maxlength="255" required autocomplete="off">
                          </div>
                          <div class="col-12 col-md-6 form-group form-valid">
                            <label for="id_deptoSucursal" class="mb-0">Departamento <span class="text-danger">*</span></label>
                            <select id="id_deptoSucursal" name="id_deptoSucursal" data-placeholder="Seleccione un departamento" required class="custom-select select2 inputVer">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 form-group form-valid">
                            <label for="id_ciudadSucursal" class="mb-0">Ciudad <span class="text-danger">*</span></label>
                            <select id="id_ciudadSucursal" name="id_ciudadSucursal" data-placeholder="Seleccione una ciudad" required class="custom-select select2 inputVer">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="col-12 col-md-6 form-group form-valid mb-1">
                            <label class="mb-0" for="direccionSucursal">Dirección <span class="text-danger">*</span></label>
                            <input placeholder="Ingresar dirección" class="form-control soloLetrasEspacioCaracteres inputVer" id="direccionSucursal" name="direccionSucursal" type="text" minlength="1" maxlength="300" required autocomplete="off">
                          </div>
                          <div class="col-12 col-md-4 form-group form-valid mb-1">
                            <label class="mb-0" for="administradorSucursal">Administrador <span class="text-danger">*</span></label>
                            <input placeholder="Ingresar administrador" class="form-control soloLetrasEspacio inputVer" id="administradorSucursal" required name="administradorSucursal" type="text" minlength="1" maxlength="255" autocomplete="off">
                          </div>
                          <div class="col-12 col-md-4 form-group form-valid mb-1">
                            <label class="mb-0" for="carteraSucursal">Cartera <span class="text-danger">*</span></label>
                            <input placeholder="Ingresar encargado cartera" required class="form-control soloLetrasEspacio inputVer" id="carteraSucursal" name="carteraSucursal" type="text" minlength="1" maxlength="255" autocomplete="off">
                          </div>
                          <div class="col-12 col-md-4 form-group form-valid mb-1">
                            <label class="mb-0" for="telefonoCartSucursal">Teléfono cartera <span class="text-danger">*</span></label>
                            <input placeholder="Ingresar teléfono cartera" required class="form-control soloNumeros inputTel inputVer" id="telefonoCartSucursal" name="telefonoCartSucursal" type="tel" minlength="10" maxlength="50" autocomplete="off">
                          </div>
                          <?php if (validPermissions([441], true)) { ?>
                            <div class="col-12 text-right">
                              <button type="submit" class="btn btn-primary" form="formSucursal"><i class="fas fa-plus"></i> Guardar</button>
                            </div>
                          <?php } ?>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              <div class="table-responsive mt-1">
                <table id="tblSucursal" class="table table-sm table-striped table-hover table-bordered w-100">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Ciudad</th>
                      <th>Dirección</th>
                      <th>Administrador</th>
                      <th>Cartera</th>
                      <th>Telefono Cartera</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formClientes"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>