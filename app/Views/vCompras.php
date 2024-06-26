<div class="card">
  <?php if (validPermissions([401], true)) { ?>
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
        aria-describedby="Tabla de Compras">
        <thead>
          <tr>
            <th>Código</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>T. Productos</th>
            <th>Observación</th>
            <th>Proveedor</th>
            <th>Total Compra</th>
            <th>Total Costo</th>
            <th>Ganancia</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalCrearEditarCompra" data-backdrop="static"
  data-keyboard="false" aria-labelledby="modalCrearEditarCompraLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="modalCrearEditarCompraLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6 col-md-3">
            <div class="input-group" title="Valor nuevo es menor que el actual">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Valor menor</label>
              </div>
              <input type="color" disabled readonly class="form-control form-control-color"
                value="#ff7c70" title="Sin Asignar">
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Producto nuevo</label>
              </div>
              <input type="color" disabled readonly class="form-control form-control-color"
                value="#8ae287" title="Sin Asignar">
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="input-group" title="Valor nuevo es mayor que el actual">
              <div class="input-group-prepend">
                <label class="input-group-text" for="selectEstado">Valor mayor</label>
              </div>
              <input type="color" disabled readonly class="form-control form-control-color"
                value="#98c0f6" title="Sin Asignar">
            </div>
          </div>
          <div class="col-6 col-md-3 d-flex justify-content-end">
            <button type="button" id="btnAgregarProductoCompra" class="btn btn-primary">
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
                <th>Categoria</th>
                <th>Ubicación</th>
                <th>Paca</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Costo</th>
                <th>Ganancia</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <hr />

        <div class="row">
          <div class="col-12 col-md-7">
            <div class="form-group">
              <label for="observacion-compra">Observación</label>
              <textarea class="form-control" placeholder="Observación..."
                name="observacion-compra" id="observacion-compra" cols="30" rows="2"></textarea>
            </div>

            <div class="form-group">
              <label class="mb-0" for="proveedor">Proveedor</label>
              <select id="proveedor" name="proveedor" class="custom-select custom-select-sm select2"
                data-placeholder="Seleccione un proveedor..." data-allow-clear="1">
                <option></option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-5">
            <div class="row">
              <div class="col-12 mt-3 d-flex justify-content-end">
                <span class="font-weight-bold h5 mr-3">Total Costo:</span>
                <span class="h5 valor-costo"></span>
              </div>
              <div class="col-12 mt-3 d-flex justify-content-end">
                <span class="font-weight-bold h5 mr-3">Total Compra:</span>
                <span class="h5 valor-compra"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-confirm-buy">
          <i class="fas fa-check"></i> Confirmar
        </button>
        <button type="button" class="btn btn-success" id="btn-save-buy">
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
              class="form-control w-50" autocomplete="off">
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
        <h5 class="modal-title" id="modalProdCuentaLabel">Producto Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCrearEditar" class="formValid">
          <input type="hidden" name="idProducto" class="inputVer" id="idProducto">
          <input type="hidden" name="idCompraProd" class="inputVer" id="idCompraProd">
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
                  Item <span class="text-danger">*</span>
                </label>
                <input placeholder="Ingrese el ítem" type="text" id="item" name="item"
                  class="form-control soloLetras validarPuntoComa validarSlash inputVer" minlength="1" maxlength="300"
                  required autocomplete="off">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group form-valid">
                <label class="mb-0" for="descripcion">
                  Descripción <span class="text-danger">*</span>
                </label>
                <textarea class="form-control inputVer" id="descripcion" name="descripcion"
                  minlength="1" required maxlength="500" placeholder="Ingrese la descripción"
                  rows="1" autocomplete="off"></textarea>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="form-group form-valid">
                <label class="mb-0" for="cateFiltro">Categoria</label>
                <select id="cateFiltro" name="cateFiltro" class="custom-select select2"
                  data-placeholder="Seleccione..." data-allow-clear="1">
                  <option></option>
                  <?php foreach ($categorias as $it) : ?>
                    <option value="<?=  $it->id?>"><?= $it->nombre ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-3 <?= $camposProducto["ubicacion"] == "1" ? '' : 'd-none' ?>">
              <div class="form-group form-valid">
                <label class="mb-0" for="ubicacion">Ubicación</label>
                <input class="form-control inputVer volverMayuscula" id="ubicacion"
                  <?= $camposProducto["ubicacion"] == "1" ? '' : 'disabled' ?> name="ubicacion" type="text"
                  minlength="0" maxlength="255" placeholder="Ingrese la ubicación" autocomplete="off">
              </div>
            </div>
            <!-- <div class="col-12 col-md-3 ?= $camposProducto['manifiesto'] == '1' ? '' : 'd-none' ?>">
              <div class="form-group form-valid">
                <label class="mb-0" for="manifiesto">Manifiesto</label>
                <select id="manifiesto" name="manifiesto" class="custom-select select2 inputVer" ?= $camposProducto['manifiesto'] == '1' ? '' : 'disabled' ?> data-placeholder="Seleccione..." data-allow-clear="1">
                  <option></option>
                  ?php foreach ($manifiestos as $it) : ?>
                    <option value="?=  $it->id?>">?= $it->nombre ?></option>
                  ?php endforeach ?>
                </select>
              </div>
            </div> -->
            <div class="col-12 col-md-3 <?= $camposProducto["paca"] == "1" ? '' : 'd-none' ?>">
              <div class="form-group form-valid">
                <label class="mb-0" for="paca">
                  Paca X <span class="text-danger">*</span>
                </label>
                <input class="form-control inputFocusSelect inputVer soloNumeros" id="paca" name="paca"
                  type="number" min="1" placeholder="Ingrese # por paca" autocomplete="off" required autocomplete="off">
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="form-group form-valid">
                <label class="mb-0" for="stock">
                  Stock <span class="text-danger">*</span>
                </label>
                <input class="form-control inputFocusSelect inputVer" id="stock" name="stock" type="number"
                  placeholder="Ingrese el stock" autocomplete="off" autocomplete="off" required>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="form-group form-valid">
                <label class="mb-0" for="precioVent">
                  Precio venta <span class="text-danger">*</span>
                </label>
                <input class="form-control inputPesos inputVer" data-valororiginal="0" id="precioVent"
                  name="precioVent" type="tel" placeholder="Ingrese el precio de venta" autocomplete="off"
                  autocomplete="off">
              </div>
            </div>
            <div class="col-12 col-md-3 <?= $camposProducto["costo"] == "1" ? '' : 'd-none' ?>">
              <div class="form-group form-valid">
                <label class="mb-0" for="costo">
                  Costo <span class="text-danger">*</span>
                </label>
                <input class="form-control inputPesos inputVer" id="costo" name="costo" type="tel"
                  placeholder="Ingrese el costo" autocomplete="off" autocomplete="off">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCancelarProdCompra">
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
  let MANEJACOSTO = <?= $camposProducto["costo"]; ?>;
</script>
