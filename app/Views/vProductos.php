<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-8 col-md-5 d-flex">
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
        <div class="input-group ml-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <input id="verImg" type="checkbox" <?= $imagenProd == 1 ? 'checked' : '' ?>>
            </div>
          </div>
          <label for="verImg" class="form-control">¿Ver Imagenes?</label>
        </div>
      </div>
      <?php if (validPermissions([51], true)) { ?>
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
            <th>Imagen</th>
            <th>Referencia</th>
            <th>Item</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Paca X</th>
            <th>Costo</th>
            <th>Precio venta</th>
            <th>Ubicación</th>
            <th>Manifiesto</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalCrearEditar" data-backdrop="static" data-keyboard="false" aria-labelledby="modalCrearEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearEditarLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCrearEditar" class="formValid" enctype="multipart/form-data">
          <input type="hidden" name="id" class="inputVer" id="id">
          <input type="hidden" name="editFoto" id="editFoto" value="0">
          <div class="form-row">
            <div class="col-6">
              <div id="content-upload">
                <div class="content-img rounded d-flex align-items-center justify-content-center">
                  <div class="text-center position-absolute w-90">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span> Selecciona o arrastre su imagen</span>
                  </div>
                  <input id="foto" name="imagen" class="input-file-img inputVer" accept=".png, .jpg, .jpeg" type="file">
                </div>
              </div>
              <div id="content-preview" class="d-none text-center">
                <img id="imgFoto" src="<?= base_url("Productos/Foto") ?>" class="img-thumbnail h-100">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-foto"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group form-valid">
                <label class="mb-0" for="categoria">Categoria <span class="text-danger">*</span></label>
                <select id="categoria" required name="categoria" class="custom-select select2 inputVer" data-placeholder="Seleccione..." data-allow-clear="1">
                  <option></option>
                  <?php foreach ($categorias as $it) : ?>
                    <option value="<?=  $it->id?>"><?= $it->nombre ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group form-valid">
                <label class="mb-0" for="referencia">Referencia <span class="text-danger">*</span></label>
                <input placeholder="Ingrese la referencia" data-campo="referencia" class="form-control soloLetras validaCampo inputVer" id="referencia" name="referencia" type="text" minlength="1" maxlength="255" required autocomplete="off">
              </div>
              <div class="form-group form-valid <?= $camposProducto["item"] == "1" ? '' : 'd-none' ?>">
                <label class="mb-0" for="item">Item <span class="text-danger">*</span></label>
                <input placeholder="Ingrese el ítem" type="text" <?= $camposProducto["item"] == "1" ? '' : 'disabled' ?> data-campo="item" id="item" name="item" class="form-control soloLetras inputVer" minlength="1" maxlength="300" required autocomplete="off">
              </div>
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="stock">Stock <span class="text-danger">*</span></label>
              <input class="form-control inputFocusSelect inputVer <?= $inventario_negativo == '1' ? 'soloNumerosNegativo' : 'soloNumeros' ?>" id="stock" name="stock" type="number" <?= $inventario_negativo == '1' ? '' : 'min="0"' ?> value="0" placeholder="Ingrese el stock" autocomplete="off" required autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid  <?= $camposProducto["paca"] == "1" ? '' : 'd-none' ?>">
              <label class="mb-0" for="paca">Paca X <span class="text-danger">*</span></label>
              <input class="form-control inputFocusSelect inputVer soloNumeros" <?= $camposProducto["paca"] == "1" ? '' : 'disabled' ?> id="paca" name="paca" type="number" min="1" value="1" placeholder="Ingrese # por paca" autocomplete="off" required autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="precioVent">Precio venta <span class="text-danger">*</span></label>
              <input class="form-control inputPesos inputVer" id="precioVent" name="precioVent" type="tel" value="0" placeholder="Ingrese el precio de venta" autocomplete="off" required autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid <?= $camposProducto["costo"] == "1" ? '' : 'd-none' ?>">
              <label class="mb-0" for="costo">Costo <span class="text-danger">*</span></label>
              <input class="form-control inputPesos inputVer" id="costo" <?= $camposProducto["costo"] == "1" ? '' : 'disabled' ?> name="costo" type="tel" value="0" placeholder="Ingrese el costo" autocomplete="off" required autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid <?= $camposProducto["ubicacion"] == "1" ? '' : 'd-none' ?>">
              <label class="mb-0" for="ubicacion">Ubicación</label>
              <input class="form-control inputVer" id="ubicacion" <?= $camposProducto["ubicacion"] == "1" ? '' : 'disabled' ?> name="ubicacion" type="text" minlength="0" maxlength="255" placeholder="Ingrese la ubicación" autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid <?= $camposProducto["manifiesto"] == "1" ? '' : 'd-none' ?>">
              <label class="mb-0" for="manifiesto">Manifiesto</label>
              <select id="manifiesto" name="manifiesto" class="custom-select select2 inputVer" <?= $camposProducto["manifiesto"] == "1" ? '' : 'disabled' ?> data-placeholder="Seleccione..." data-allow-clear="1">
                <option></option>
                <?php foreach ($manifiestos as $it) : ?>
                  <option value="<?=  $it->id?>"><?= $it->nombre ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-12 form-group form-valid">
              <label class="mb-0" for="descripcion">Descripción <span class="text-danger">*</span></label>
              <textarea class="form-control inputVer" id="descripcion" name="descripcion" minlength="1" required maxlength="500" placeholder="Ingrese la descripción" rows="3" autocomplete="off"></textarea>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="ventas">Ventas</label>
              <input class="form-control" id="ventas" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaMod">Fecha modificación</label>
              <input class="form-control" id="fechaMod" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="fechaCre">Fecha creación</label>
              <input class="form-control" id="fechaCre" disabled>
            </div>
            <div class="col-6 form-group form-group-edit">
              <label class="mb-0" for="estado">Estado</label>
              <input class="form-control" id="estado" disabled>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formCrearEditar"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script>
  $CATEGORIAS = <?= COUNT($categorias) ?>;
  $CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
  $INVENTARIONEGATIVO = "<?= $inventario_negativo ?>";
  $imagenProd = <?= $imagenProd ?>
</script>