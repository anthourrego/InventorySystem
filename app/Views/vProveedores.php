<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-12 col-md-3">
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
      <div class="col-4 col-md-3 text-right">
        <button type="button" class="btn btn-secondary" id="btnFiltros"><i class="fa-solid fa-filter"></i> Filtros</button>
        <?php if (validPermissions([501], true)) { ?>
          <button type="button" class="btn btn-primary" id="btnCrear">
            <i class="fa-solid fa-plus"></i> Crear
          </button>
        <?php } ?>
        </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100">
        <thead> 
          <tr>
            <th>Nit</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Contacto</th>
            <th>Teléfono contacto</th>
            <th>Pais</th>
            <th>Departmento</th>
            <th>Ciudad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalProveedores" data-backdrop="static" data-keyboard="false" aria-labelledby="modalProveedoresLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProveedoresLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formProveedor" class="formValid">
          <input type="hidden" class="inputVer" name="id" id="id"> 
          <div class="form-row">
            <div class="col-12 col-md-6 form-group form-valid mb-1">
              <label class="mb-0" for="nit">Nit <span class="text-danger">*</span></label>
              <input placeholder="Ingresar nit" class="form-control soloNumeros inputVer" id="nit" name="nit" type="tel" minlength="1" maxlength="30" autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid mb-1">
              <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
              <input placeholder="Ingresar nombre" class="form-control soloLetrasEspacio inputVer" id="nombre" name="nombre" type="text" minlength="1" maxlength="255" required autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid mb-1">
              <label class="mb-0" for="telefono">Teléfono <span class="text-danger">*</span></label>
              <input placeholder="Ingresar teléfono" class="form-control soloNumeros inputTel inputVer" id="telefono" name="telefono" type="tel" minlength="10" maxlength="50" required autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid mb-1">
              <label class="mb-0" for="direccion">Dirección <span class="text-danger">*</span></label>
              <input placeholder="Ingresar dirección" class="form-control soloLetrasEspacioCaracteres inputVer" id="direccion" name="direccion" type="text" minlength="1" maxlength="300" required autocomplete="off">
            </div>
            <div class="col-12 col-md-4 form-group form-valid">
              <label for="id_pais" class="mb-0">País <span class="text-danger">*</span></label>
              <select id="id_pais" name="id_pais" data-placeholder="Seleccione un país" required class="custom-select select2 inputVer" data-depto="id_depto">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-4 form-group form-valid">
              <label for="id_depto" class="mb-0">Departamento <span class="text-danger">*</span></label>
              <select id="id_depto" name="id_depto" data-placeholder="Seleccione un departamento" required class="custom-select select2 inputVer" data-ciudad="id_ciudad">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-4 form-group form-valid">
              <label for="id_ciudad" class="mb-0">Ciudad <span class="text-danger">*</span></label>
              <select id="id_ciudad" name="id_ciudad" data-placeholder="Seleccione una ciudad" required class="custom-select select2 inputVer">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group form-valid mb-1">
              <label class="mb-0" for="contacto">Contacto</label>
              <input placeholder="Ingresar contacto" class="form-control soloLetrasEspacio inputVer" id="contacto" name="contacto" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid mb-1">
              <label class="mb-0" for="telefonocontacto">Teléfono contacto</label>
              <input placeholder="Ingresar teléfono contacto" class="form-control soloNumeros inputTel inputVer" id="telefonocontacto" name="telefonocontacto" type="tel" minlength="10" maxlength="50" autocomplete="off">
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
        <button type="submit" class="btn btn-success" form="formProveedor"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFiltros" data-backdrop="static" data-keyboard="false" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFiltrosLabel">Filtros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formFiltros">
          <div class="form-row">
            <div class="col-12 col-md-6 form-group">
              <label for="id_paisFiltro" class="mb-0">País <span class="text-danger">*</span></label>
              <select id="id_paisFiltro" name="id_paisFiltro" data-placeholder="Seleccione un país" class="custom-select select2 inputVer" data-depto="id_deptoFiltro">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group">
              <label for="id_deptoFiltro" class="mb-0">Departamento <span class="text-danger">*</span></label>
              <select id="id_deptoFiltro" name="id_deptoFiltro" data-placeholder="Seleccione un departamento" class="custom-select select2 inputVer" data-ciudad="id_ciudadFiltro">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group">
              <label for="id_ciudadFiltro" class="mb-0">Ciudad <span class="text-danger">*</span></label>
              <select id="id_ciudadFiltro" name="id_ciudadFiltro" data-placeholder="Seleccione una ciudad" class="custom-select select2 inputVer">
                <option value=""></option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formFiltros"><i class="fas fa-search"></i> Buscar</button>
        <button type="button" class="btn btn-warning" id="reiniciarFiltros"><i class="fas fa-refresh"></i> Reiniciar Filtros</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>