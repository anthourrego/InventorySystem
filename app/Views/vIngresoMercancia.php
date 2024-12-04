<div class="card">
  <?php if (validPermissions([801], true)) { ?>
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-12 col-md-3 offset-md-9 mt-2 mt-md-0 text-right">
        <button type="button" class="btn btn-primary mb-2 mb-xl-0" id="btnCrear">
          <i class="fa-solid fa-plus"></i> Crear
        </button>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="card-body">
    <div class="table-responsive">
      <table id="table" class="table table-sm table-striped table-hover table-bordered w-100"
        aria-describedby="Tabla de Ingresos">
        <thead>
          <tr>
            <th>Código</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>T. Productos</th>
            <th>Observación</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalCrearEditarIngreso" data-backdrop="static"
  data-keyboard="false" aria-labelledby="modalCrearEditarIngresoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="modalCrearEditarIngresoLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 d-flex justify-content-end">
            <button type="button" id="btnAgregarProductoIngreso" class="btn btn-primary">
              <i class="fas fa-check"></i> Agregar Producto
            </button>
          </div>
        </div>

        <div class="table-responsive mt-3">
          <table id="tblProducts" class="table table-sm table-striped table-hover table-bordered w-100"
          aria-describedby="Tabla de Productos">
            <thead>
              <tr>
                <th>Referencia</th>
                <th>Item</th>
                <th>Descripción</th>
                <th>Stock actual</th>
                <th>Cantidad entrante</th>
                <th>Stock total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <hr />
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="observacion-ingreso-mercancia">Observación</label>
              <textarea class="form-control inputVer" placeholder="Observación..."
                name="observacion-ingreso-mercancia" id="observacion-ingreso-mercancia" cols="30" rows="2"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-confirm-entry">
          <i class="fas fa-check"></i> Confirmar
        </button>
        <button type="button" class="btn btn-success" id="btn-save-entry">
          <i class="fas fa-save"></i> Guardar
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalSearchProd" data-backdrop="static"
  data-keyboard="false" aria-labelledby="modalSearchProdLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSearchProdLabel">Búsqueda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formSearch" class="formValid">
          <div class="d-flex">
            <input placeholder="Buscar" type="text" id="buscar" name="buscar"
              class="form-control w-75" autocomplete="off">
            <button type="submit" class="btn btn-primary ml-3" form="formSearch">
              <i class="fas fa-search"></i> Buscar
            </button>
          </div>
        </form>

        <ul class="list-group list-group-flush mt-3" id="listProdsHtml"></ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalProdCuenta" data-backdrop="static" data-keyboard="false"
  aria-labelledby="modalProdCuentaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProdCuentaLabel">Producto Ingreso Mercancía</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCrearEditar" class="formValid">
          <input type="hidden" name="idProducto" class="inputVer" id="idProducto">
          <input type="hidden" name="idIngresoMercanciaProd" class="inputVer" id="idIngresoMercanciaProd">
          <div class="form-row">
            <div class="col-12 col-md-3">
              <div class="form-group form-valid">
                <label class="mb-0" for="referencia">
                  Referencia <span class="text-danger">*</span>
                </label>
                <div class="input-search">
                  <input placeholder="Ingrese la referencia" data-campo="referencia"
                    class="form-control soloLetras validarenie validaCampo inputVer volverMayuscula" id="referencia"
                    name="referencia" type="text" minlength="1" maxlength="255" required autocomplete="off">
                  <div class="input-group-append d-none">
                    <button type="button" class="btn btn-secondary" id="btnSearchReferencia">
                      <i class="fas fa-filter"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 <?= $camposProducto["item"] == "1" ? '' : 'd-none' ?>">
              <div class="form-group form-valid">
                <label class="mb-0" for="item">
                  Item
                </label>
                <input disabled readonly type="text" id="item" name="item"
                  class="form-control soloLetras validarPuntoComa validarSlash inputVer" minlength="1" maxlength="300"
                  autocomplete="off">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group form-valid">
                <label class="mb-0" for="descripcion">
                  Descripción
                </label>
                <textarea disabled readonly class="form-control inputVer" id="descripcion" name="descripcion"
                  minlength="1" maxlength="500" rows="1" autocomplete="off"></textarea>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="form-group form-valid">
                <label class="mb-0" for="stock">
                  Stock
                </label>
                <input disabled readonly class="form-control inputFocusSelect inputVer" id="stock" name="stock" type="number"
                  autocomplete="off" autocomplete="off">
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="form-group form-valid">
                <label class="mb-0" for="stock">
                  Cantidad entrante <span class="text-danger">*</span>
                </label>
                <input class="form-control inputVer" id="cantidad" name="cantidad" type="number"
                  placeholder="Ingrese el cantidad" autocomplete="off" autocomplete="off" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCancelarProdIngresoInventario">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-primary" form="formCrearEditar">
          <i class="fas fa-check"></i> Agregar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  let MANEJAITEM = <?= $camposProducto["item"]; ?>;
</script>
