<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-12 col-md-8">
        <div class="row">
          <div class="col-12 col-md-6 col-xl-4 mb-2 mb-xl-0">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input id="verImg" type="checkbox" <?= $imagenProd == 1 ? 'checked' : '' ?>>
                </div>
              </div>
              <label for="verImg" class="form-control">¿Ver Imagen?</label>
            </div>
          </div>
          <?php if (validPermissions([54], true)) { ?>
            <div class="col-12 col-md-6 col-xl-4 mb-2 mb-xl-0">
              <div class="input-group">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="valorInventarioActual">Valor Inventario</label>
                </div>
                <input type="text" id="valorInventarioActual" class="form-control" disabled value="$ 0">
              </div>
            </div>
          <?php } ?>
          <?php if ($camposProducto['costo'] == "1" && validPermissions([57], true)) { ?>
          <div class="col-12 col-md-6 col-xl-4 mb-2 mb-xl-0">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="costoInventarioActual">Costo Inventario</label>
              </div>
              <input type="text" id="costoInventarioActual" class="form-control" disabled value="$ 0">
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-12 col-md-4 mt-2 mt-md-0 text-right botones-acciones">
        <?php if (validPermissions([56], true)) { ?>
        <button type="button" class="btn btn-secondary mb-2 mb-xl-0" id="btnSincronizar"><i class="fa-solid fa-sync"></i></button>
        <?php } ?>
        <?php if (validPermissions([55], true)) { ?>
          <button type="button" class="btn btn-dark mb-2 mb-xl-0" data-toggle="modal" data-target="#modalFotos"><i class="fa-solid fa-camera"></i> Fotos</button>
        <?php } ?>
        <?php if (validPermissions([58], true)) { ?>
          <button type="button" type="button" id="btnPlantillaExcel" class="btn btn-info mb-2 mb-xl-0"><i class="fa-solid fa-file-excel"></i> Plantilla</button>
        <?php } ?>
        <button type="button" class="btn btn-warning mb-2 mb-xl-0" id="btnFiltros"><i class="fa-solid fa-filter"></i> Filtros</button>
        <?php if (validPermissions([51], true)) { ?>
          <button type="button" class="btn btn-primary mb-2 mb-xl-0" id="btnCrear"><i class="fa-solid fa-plus"></i> Crear</button>
        <?php } ?>
      </div>
      <div class="col-12 col-md-3 mt-2 mt-md-0 text-right loading-fotos d-none">
        <span class="loaderprod text-primary">Sincronizando fotos...</span>
      </div>
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
    <div id="myGrid" class="ag-theme-alpine d-none"></div>
  </div>
</div>

<div class="modal fade modalFormulario" id="modalCrearEditar" data-backdrop="static" data-keyboard="false" aria-labelledby="modalCrearEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
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
              <button type="button" style="z-index: 30" id="tomarFoto" class="btn btn-info btn-sm col-10 mb-1"><i class="fas fa-camera"></i> Tomar Foto</button>
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
                <label class="mb-0" for="categoria">Categoria</label>
                <select id="categoria" name="categoria" class="custom-select select2 inputVer" data-placeholder="Seleccione..." data-allow-clear="1">
                  <option></option>
                  <?php foreach ($categorias as $it) : ?>
                    <option value="<?=  $it->id?>"><?= $it->nombre ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group form-valid">
                <label class="mb-0" for="referencia">Referencia <span class="text-danger">*</span></label>
                <input placeholder="Ingrese la referencia" data-campo="referencia" class="form-control soloLetras validarenie validaCampo inputVer" id="referencia" name="referencia" type="text" minlength="1" maxlength="255" required autocomplete="off">
              </div>
              <div class="form-group form-valid <?= $camposProducto["item"] == "1" ? '' : 'd-none' ?>">
                <label class="mb-0" for="item">Item <span class="text-danger">*</span></label>
                <input placeholder="Ingrese el ítem" type="text" <?= $camposProducto["item"] == "1" ? '' : 'disabled' ?> data-campo="item" id="item" name="item" class="form-control soloLetras validarPuntoComa validarSlash inputVer" minlength="1" maxlength="300" required autocomplete="off">
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
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="precioVentDos">Precio venta 2<span class="text-danger">*</span></label>
              <input class="form-control inputPesos inputVer" id="precioVentDos" name="precioVentDos" type="tel" value="0" placeholder="Ingrese el precio de venta" autocomplete="off" required autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid <?= $camposProducto["ubicacion"] == "1" ? '' : 'd-none' ?>">
              <label class="mb-0" for="ubicacion">Ubicación</label>
              <input class="form-control inputVer volverMayuscula" id="ubicacion" <?= $camposProducto["ubicacion"] == "1" ? '' : 'disabled' ?> name="ubicacion" type="text" minlength="0" maxlength="255" placeholder="Ingrese la ubicación" autocomplete="off">
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

<div class="modal fade modalFormulario" id="modalEditarImage" data-backdrop="static" data-keyboard="false" aria-labelledby="modalEditarImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarImageLabel">Editar Imagen</h5>
        <button type="button" class="close btnCancelarImg" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="image" width="100%" src="" alt="">

        <img id="imageTemp" style="display: none;" width="100%" src="assets/img/nofoto.png" alt="">

        <video muted="muted" width="100%" style="display: none;" id="video"></video>
	      <canvas id="canvas" style="display: none;"></canvas>

      </div>
      <div class="modal-footer d-flex justify-content-between footer-modal">
        <div class="btnsync">
          <button type="button" onclick="cambiarCamara()" class="btn btn-secondary btnsyncaction"><i class="fas fa-sync"></i></button>  
          <button type="button" onclick="reintentarFoto()" class="btn btn-danger reloadFoto"><i class="fas fa-redo"></i></button>  
        </div>
        <div class="btnactions">
          <button type="button" onclick="guardarImage()" class="btn btn-success btnGuadarFoto"><i class="fas fa-save"></i> Confirmar</button>
          <button type="button" class="btn btn-secondary btnCancelarImg"><i class="fas fa-times"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (validPermissions([55], true)) { ?>
<div class="modal fade" id="modalFotos" data-backdrop="static" data-keyboard="false" aria-labelledby="modalFotosLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFotosLabel"><i class="fa-solid fa-camera"></i> Descargar fotos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="inputs-tipo-fotos mb-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipoFoto" id="tipoFotoOriginal" value="original" checked>
            <label class="form-check-label" for="tipoFotoOriginal">
              Originales
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipoFoto" id="tipoFotoPrecio1" value="precio1">
            <label class="form-check-label" for="tipoFotoPrecio1">
              Precio de venta uno
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipoFoto" id="tipoFotoPrecio2" value="precio2">
            <label class="form-check-label" for="tipoFotoPrecio2">
              Precio de venta dos
            </label>
          </div>
        </div>
        <div class="input-group">
          <input type="number" id="cantFiltroPaquete"  value="<?= $camposProducto["pacDescarga"] ?>" class="form-control inputFocusSelect soloNumeros noEnter" min="1" max="100" placeholder="Cantidad x paquete">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btnFiltrarPaquetes"><i class="fas fa-filter"></i></button>
          </div>
        </div>
        <small id="nroPaquetes" class="d-none">Cantidad paquetes: <span>1</span></small>

        <div id="listaPaquetes" class="list-group mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php if (validPermissions([59], true) && $camposProducto["ubicacion"] == "1") { ?>
<div class="modal fade modalFormulario" id="modalEditarUbicacion" data-backdrop="static" data-keyboard="false" aria-labelledby="modalEditarUbicacionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarUbicacionLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEditarUbicacion">
          <input type="hidden" name="idProductoUbicacion" class="inputVer" id="idProductoUbicacion">
          <div class="form-row">
            <div class="col-12 form-group form-valid">
              <label class="mb-0" for="ubicacionProducto">Ubicación</label>
              <input class="form-control inputVer volverMayuscula" id="ubicacionProducto" name="ubicacionProducto" type="text" minlength="0" maxlength="255" placeholder="Ingrese la ubicación" autocomplete="off">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" form="formEditarUbicacion"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

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
              <label class="mb-0" for="selectEstado">Estado</label>
              <select class="custom-select" id="selectEstado">
                <option selected value="1">Activo</option>
                <option value="0">Inactivo</option>
                <option value="-1">Todos</option>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group">
              <label class="mb-0" for="cateFiltro">Categoria</label>
              <select id="cateFiltro" name="cateFiltro" class="custom-select select2" data-placeholder="Seleccione..." data-allow-clear="1">
                <option></option>
                <?php foreach ($categorias as $it) : ?>
                  <option value="<?=  $it->id?>"><?= $it->nombre ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-6 col-md-3 form-group form-valid">
              <label class="mb-0" for="cantIni">Cantidad Inicial</label>
              <input placeholder="Cantidad Inicial" class="form-control soloNumeros" id="cantIni" name="cantIni" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-6 col-md-3 form-group form-valid">
              <label class="mb-0" for="cantFin">Cantidad Final</label>
              <input placeholder="Cantidad Final" class="form-control soloNumeros" id="cantFin" name="cantFin" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-6 col-md-3 form-group form-valid">
              <label class="mb-0" for="preciIni">Precio Inicial</label>
              <input placeholder="Precio Inicial" class="form-control soloNumeros" id="preciIni" name="preciIni" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-6 col-md-3 form-group form-valid">
              <label class="mb-0" for="preciFin">Precio Final</label>
              <input placeholder="Precio Final" class="form-control soloNumeros" id="preciFin" name="preciFin" type="text" minlength="1" maxlength="255" autocomplete="off">
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

<script>
  $CATEGORIAS = <?= COUNT($categorias) ?>;
  $CAMPOSPRODUCTO = <?= json_encode($camposProducto) ?>;
  $INVENTARIONEGATIVO = "<?= $inventario_negativo ?>";
  $imagenProd = <?= $imagenProd ?>;
  $valorInventarioActual = '<?= $valorInventarioActual ?>';
  $costoInventarioActual = '<?= $costoInventarioActual ?>';
</script>