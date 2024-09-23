<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="tabConfiguracion" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link <?= is_null($tab) ? "active" : '' ?>" id="producto-tab" data-toggle="tab" href="#productoTab" role="tab" aria-controls="productoTab" aria-selected="true">Productos</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="inventario-tab" data-toggle="tab" href="#inventarioTab" role="tab" aria-controls="inventarioTab" aria-selected="false">Inventario</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="consecutivo-tab" data-toggle="tab" href="#consecutivoTab" role="tab" aria-controls="consecutivoTab" aria-selected="false">Consecutivo</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="ventas-tab" data-toggle="tab" href="#ventasTab" role="tab" aria-controls="ventasTab" aria-selected="false">Pedidos / Ventas</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="empresa-tab" data-toggle="tab" href="#empresaTab" role="tab" aria-controls="empresaTab" aria-selected="false">Empresa</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="general-tab" data-toggle="tab" href="#generalTab" role="tab" aria-controls="generalTab" aria-selected="false">General</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link <?= $tab == "Reportes" ? "active" : '' ?>" id="reportes-tab" data-toggle="tab" href="#reportesTab" role="tab" aria-controls="reportesTab" aria-selected="false">Reportes</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="smtpcorreos-tab" data-toggle="tab" href="#smtpcorreosTab" role="tab" aria-controls="smtpcorreosTab" aria-selected="false">SMTP Correo</a>
      </li>
      <!-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="showroom-tab" data-toggle="tab" href="#showroomTab" role="tab" aria-controls="showroomTab" aria-selected="false">Showroom</a>
      </li> -->
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="contentTab">
      <div class="tab-pane fade <?= is_null($tab) ? "show active" : '' ?>" id="productoTab" role="tabpanel" aria-labelledby="producto-tab">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-3">
            <label for="costoProducto">Costo:</label>
            <select id="costoProducto" data-nombre="Costo de producto" <?= !$editar ? 'disabled' : '' ?> name="costoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="imageProd">Imagen:</label>
            <select id="imageProd" data-nombre="Imagen Producto" <?= !$editar ? 'disabled' : '' ?> name="imageProd" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="itemProducto">Item:</label>
            <select id="itemProducto" data-nombre="Item Producto" <?= !$editar ? 'disabled' : '' ?> name="itemProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="ubicacionProducto">Ubicación:</label>
            <select id="ubicacionProducto" data-nombre="Ubicación Producto" <?= !$editar ? 'disabled' : '' ?> name="ubicacionProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="manifiestoProducto">Manifiesto:</label>
            <select id="manifiestoProducto" data-nombre="Manifiesto Producto" <?= !$editar ? 'disabled' : '' ?> name="manifiestoProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="pacaProducto">Paca X:</label>
            <select id="pacaProducto" data-nombre="Paca X Producto" <?= !$editar ? 'disabled' : '' ?> name="pacaProducto" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="pacDescarga">Paquete Descarga X:</label>
            <input type="number" id="pacDescarga" data-nombre="Paquete descarga" name="pacDescarga" min="1" max="100" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="pacDescarga">Sugerir Cantidad Despachar:</label>
            <input type="number" id="cantDespachar" data-nombre="Sugerir Cantidad Despachar" name="cantDespachar" min="1" max="100" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="inventarioTab" role="tabpanel" aria-labelledby="inventario-tab">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-3">
            <label for="inventarioNegativo">Inventario negativo:</label>
            <select id="inventarioNegativo" data-nombre="Inventario negativo" <?= !$editar ? 'disabled' : '' ?> name="inventarioNegativo" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <option value=""></option>
              <option value="1">Si</option>
              <option value="0" selected>No</option>
            </select>
          </div>
          <hr class="col-12">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="row">
              <div class="col-12">
                <div class="row mb-3">
                  <label class="col-11 text-left">Rangos Inventario:</label>
                  <div class="col-1 text-right">
                    <button class="btn btn-secondary btn-sm infobtn">
                      <i class="fas fa-info"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-11 col-md-3 input-group mb-3">
                <input data-nombre="Rango Bajo" value="0" id="inventarioBajo" name="inventarioBajo" <?= !$editar ? 'disabled' : '' ?> type="text" class="configAct form-control bg-danger text-center inputFocusSelect lastFocus">
              </div>
              <div class="col-1 input-group mb-3">
                <input readonly disabled value="<" type="text" class="form-control text-center">
              </div>
              <div class="col-12 col-md-4 input-group mb-3">
                <input data-nombre="Rango Medio" value="25" id="inventarioMedio" name="inventarioMedio" <?= !$editar ? 'disabled' : '' ?> type="text" class="configAct form-control bg-warning text-center inputFocusSelect lastFocus">
              </div>
              <div class="col-1 input-group mb-3">
                <input readonly disabled value=">" type="text" class="form-control text-center">
              </div>
              <div class="col-11 col-md-3 input-group mb-3">
                <input disabled type="text" data-nombre="Rango Alto" id="inventarioAlto" name="inventarioAlto" value="25" class="configAct form-control bg-success text-center inputFocusSelect">
              </div>
              <div class="col-12 alert-info-data" style="display: none;">
                <div class="alert alert-info text-center" role="alert"></div>
              </div>
            </div>
          </div>
          <hr class="col-12">
        </div>
      </div>
      <div class="tab-pane fade" id="consecutivoTab" role="tabpanel" aria-labelledby="consecutivo-tab">
        <div class="form-row">
          <h5 class="mb-1 col-12">Factura:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="prefijoFact">Prefijo:</label>
            <input type="text" id="prefijoFact" data-nombre="Prefijo Factura" name="prefijoFact" <?= !$editar ? 'disabled' : '' ?> class="soloLetras form-control configAct" required autocomplete="off"placeholder="Ingrese el Prefijo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="consecutivoFact">Consecutivo:</label>
            <input type="number" id="consecutivoFact" data-nombre="Consecutivo Factura" name="consecutivoFact" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese el consecutivo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="digitosFact">Cant digitos:</label>
            <input type="number" id="digitosFact"  data-nombre="Digitos Factura" name="digitosFact" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad de digitos">
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Pedidos:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="prefijoPed">Prefijo:</label>
            <input type="text" id="prefijoPed" data-nombre="Prefijo Factura" name="prefijoPed" <?= !$editar ? 'disabled' : '' ?> class="soloLetras form-control configAct" required autocomplete="off"placeholder="Ingrese el Prefijo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="consecutivoPed">Consecutivo:</label>
            <input type="number" id="consecutivoPed"  data-nombre="Consecutivo Factura" name="consecutivoPed" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese el consecutivo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="digitosPed">Cant digitos:</label>
            <input type="number" id="digitosPed"  data-nombre="Consecutivo Factura" name="digitosPed" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad de digitos">
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Compras:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="prefijoCompra">Prefijo:</label>
            <input type="text" id="prefijoCompra" data-nombre="Prefijo Compra" name="prefijoCompra" <?= !$editar ? 'disabled' : '' ?> class="soloLetras form-control configAct" required autocomplete="off"placeholder="Ingrese el Prefijo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="consecutivoCompra">Consecutivo:</label>
            <input type="number" id="consecutivoCompra"  data-nombre="Consecutivo Compra" name="consecutivoCompra" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese el consecutivo">
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="digitosCompra">Cant digitos:</label>
            <input type="number" id="digitosCompra"  data-nombre="Consecutivo Compra" name="digitosCompra" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad de digitos">
          </div>
          <hr class="col-12 my-2">
          <h5 class="mb-1 col-12">Ingreso mercancia:</h5>
          <div class="col-12 col-md-6 col-lg-3">
            <label for="consecutivoIngresoMercancia">Consecutivo:</label>
            <input type="number" id="consecutivoIngresoMercancia"  data-nombre="Consecutivo Ingreso Mercancia" name="consecutivoIngresoMercancia" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese el consecutivo">
          </div>
          <hr class="col-12 my-2">
        </div>
      </div>
      <div class="tab-pane fade" id="ventasTab" role="tabpanel" aria-labelledby="ventas-tab">
        <div class="form-row">
          <div class="col-12 col-md-6">
            <h5 class="mb-1 col-12">Pedidos:</h5>
            <div class="col-12 col-md-6">
              <label for="manejaEmpaque">Maneja Empaque:</label>
              <select id="manejaEmpaque" data-nombre="Maneja Empaque" <?= !$editar ? 'disabled' : '' ?> name="manejaEmpaque" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
                <option value=""></option>
                <option value="1" selected>Si</option>
                <option value="0">No</option>
              </select>
            </div>
            <hr class="col-12 my-2">
            <h5 class="mb-1 col-12">Ventas:</h5>
            <div class="row">
              <div class="col-12 col-md-6">
                <label for="diasVencimientoVenta">Días de vencimiento:</label>
                <input type="number" id="diasVencimientoVenta"  data-nombre="Días de vencimiento" name="diasVencimientoVenta" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese la cantidad de días">
              </div>
              <div class="col-12 col-md-6">
                <label for="porcentajeDescuento">Porcentaje de descuento:</label>
                <div class="input-group">
                  <input type="text" class="soloNumeros configAct form-control" data-nombre="Porcentaje de descuento" maxlength="3" <?= !$editar ? 'disabled' : '' ?> name="porcentajeDescuento" id="porcentajeDescuento" required autocomplete="off" placeholder="Porcentaje" aria-describedby="descrip_porcenteaje">
                  <div class="input-group-append">
                    <span class="input-group-text" id="descrip_porcenteaje">%</span>
                  </div>
                </div>
              </div>
            </div>
            <hr class="col-12 my-2">
          </div>
          <div class="col-12 col-md-6">
            <h5 class="mb-1 col-12">Pedidos/Ventas</h5>
            <div class="col-12 col-md-6">
              <label for="pacaProducto">X Paca: <button class="btn btn-info btn-sm fas fa-info" data-toggle="tooltip" title="Este campo se mostrara habilitado siempre y cuando el parametro 'Productos -> Paca X' activo."></button></label>
              <select id="ventaXPaca" data-nombre="Venta y Pedido X Paca" <?= !$editar ? 'disabled' : '' ?> name="ventaXPaca" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
                <option value=""></option>
                <option value="1">Si</option>
                <option value="0" selected>No</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="empresaTab" role="tabpanel" aria-labelledby="empresa-tab">
        <div class="form-row">
          <div class="col-3">
            <div id="content-upload-logoEmpresa">
              <div class="content-img rounded d-flex align-items-center justify-content-center">
                <div class="text-center position-absolute w-90">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <span> Selecciona o arrastre su imagen</span>
                </div>
                <input data-nombre="Logo Empresa" name="logoEmpresa" id="logoEmpresa" class="input-file-img configAct" accept=".jpg, .jpeg, .png" type="file">
              </div>
            </div>
            <div id="content-preview-logoEmpresa" class="d-none text-center">
              <img id="imgFotologoEmpresa" src="#" class="img-thumbnail h-100">
              <button type="button" onclick="eliminarImagen('logoEmpresa', 'Logo Empresa')" class="btn btn-danger btn-sm btn-eliminar-foto"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="col-9">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-3">
                <label for="tipoDocumentoEmpresa">Tipo documento:</label>
                <select id="tipoDocumentoEmpresa" data-nombre="Tipo documento" <?= !$editar ? 'disabled' : '' ?> name="tipoDocumentoEmpresa" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
                  <?php foreach (TIPODOCS as $key => $value) {
                    echo '<option value="' . $value['valor'] . '">' . $value['titulo'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 col-md-6 col-lg-3">
                <label for="documentoEmpresa">Identificación:</label>
                <input type="text" id="documentoEmpresa" data-nombre="Identificación" name="documentoEmpresa" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off" placeholder="Ingrese Identificación">
              </div>
              <div class="col-12 col-md-6 col-lg-2">
                <label for="digitoVeriEmpresa">D.V:</label>
                <input type="text" id="digitoVeriEmpresa" data-nombre="digito verificación" name="digitoVeriEmpresa" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" maxlength="1" required autocomplete="off"placeholder="Ingrese D.V">
              </div>
              <div class="col-12 col-md-6 col-lg-4">
                <label for="telefonoEmpresa">Teléfono:</label>
                <input type="text" id="telefonoEmpresa" data-nombre="Teléfono" name="telefonoEmpresa" <?= !$editar ? 'disabled' : '' ?> class="soloNumeros form-control configAct" required autocomplete="off"placeholder="Ingrese Teléfono">
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <label for="nombreEmpresa">Razón Social:</label>
                <input type="text" id="nombreEmpresa" data-nombre="Razón Social" name="nombreEmpresa" <?= !$editar ? 'disabled' : '' ?> class="form-control configAct" required autocomplete="off"placeholder="Ingrese razón social">
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <label for="direccionEmpresa">Dirección:</label>
                <input type="text" id="direccionEmpresa" data-nombre="Dirección" name="direccionEmpresa" <?= !$editar ? 'disabled' : '' ?> class="form-control configAct" required autocomplete="off"placeholder="Ingrese dirección">
              </div>
              <div class="col-12 col-md-6 col-lg-4">
                <label for="emailEmpresa">Correo electrónico:</label>
                <input type="text" id="emailEmpresa" data-nombre="Correo electrónico" name="emailEmpresa" <?= !$editar ? 'disabled' : '' ?> class="form-control configAct" required autocomplete="off"placeholder="Ingrese correo electrónico">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="generalTab" role="tabpanel" aria-labelledby="general-tab">
        <div class="form-row">
          <div class="col-12 col-md-6">
            <div class="row">
              <div class="col-12 alert alert-info text-center mb-1 p-1" role="alert">Logo: representación grafica de la empresa. Fondo Inicio: imagen corporativa en el inicio de sesión. Ambas deben tener un peso maximo de 2MB</div>
              <div class="col-12 col-md-6">
                <label for="logoLogin">Logo:</label>
                <div id="content-upload-logoLogin">
                  <div class="content-img rounded d-flex align-items-center justify-content-center">
                    <div class="text-center position-absolute w-90">
                      <i class="fas fa-cloud-upload-alt"></i>
                      <span> Selecciona o arrastre su imagen</span>
                    </div>
                    <input data-nombre="Logo Login" name="logoLogin" id="logoLogin" class="input-file-img configAct" accept=".png" type="file">
                  </div>
                </div>
                <div id="content-preview-logoLogin" class="d-none text-center">
                  <img id="imgFotoLogoLogin" src="#" class="img-thumbnail h-100">
                  <button type="button" onclick="eliminarImagen('logoLogin', 'Logo Empresa')" class="btn btn-danger btn-sm btn-eliminar-foto"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label for="logoFondoLogin">Fondo Inicio:</label>
                <div id="content-upload-logoFondoLogin">
                  <div class="content-img rounded d-flex align-items-center justify-content-center">
                    <div class="text-center position-absolute w-90">
                      <i class="fas fa-cloud-upload-alt"></i>
                      <span> Selecciona o arrastre su imagen</span>
                    </div>
                    <input data-nombre="Fondo Login" name="logoFondoLogin" id="logoFondoLogin" class="input-file-img configAct" accept=".jpg, .jpeg" type="file">
                  </div>
                </div>
                <div id="content-preview-logoFondoLogin" class="d-none text-center">
                  <img id="imgFotoLogoFondoLogin" src="#" class="img-thumbnail h-100">
                  <button type="button" onclick="eliminarImagen('logoFondoLogin', 'Logo Empresa')" class="btn btn-danger btn-sm btn-eliminar-foto"><i class="fas fa-times"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade <?= $tab == "Reportes" ? "show active" : '' ?>" id="reportesTab" role="tabpanel" aria-labelledby="reportes-tab">
        <?= view("vModificarReporte"); ?>
      </div>
      <div class="tab-pane fade" id="smtpcorreosTab" role="tabpanel" aria-labelledby="smtpcorreos-tab">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-4">
            <label for="tipoCEnvioEmpresa">Tipo Correo:</label>
            <select id="tipoCEnvioEmpresa" data-nombre="Tipo Correo" <?= !$editar ? 'disabled' : '' ?> name="tipoCEnvioEmpresa" data-placeholder="Seleccione una opción" class="custom-select select2 configAct">
              <?php foreach (TIPOCORREO as $key => $value) {
                echo '<option value="' . $value['valor'] . '" data-smtp="' . $value['smtp'] . '">' . $value['titulo'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="hostEnvioEmpresa">SMTP Host:</label>
            <input type="text" id="hostEnvioEmpresa" data-nombre="Host" name="hostEnvioEmpresa" <?= !$editar ? 'disabled' : '' ?> class="form-control configAct" required autocomplete="off"placeholder="Ingrese correo electrónico">
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="emailEnvioEmpresa">Correo:</label>
            <input type="text" id="emailEnvioEmpresa" data-nombre="Correo electrónico" name="emailEnvioEmpresa" <?= !$editar ? 'disabled' : '' ?> class="form-control configAct" required autocomplete="off"placeholder="Ingrese correo electrónico">
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="passEnvioEmpresa">Contraseña:</label>
            <input type="password" id="passEnvioEmpresa" placeholder="Contraseña" maxlength="100" <?= !$editar ? 'disabled' : '' ?> name="passEnvioEmpresa" class="form-control soloLetras configAct" autocomplete="off">
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="puertoEnvioEmpresa">Puerto:</label>
            <input type="text" id="puertoEnvioEmpresa" data-nombre="Puerto" name="puertoEnvioEmpresa" <?= !$editar ? 'disabled' : '' ?> class="form-control configAct" required autocomplete="off"placeholder="Ingrese Puerto">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="showroomTab" role="tabpanel" aria-labelledby="showroom-tab">
        <div class="form-row">
          <div class="col-12 col-md-6 col-lg-3">
            <label for="prefijoFact">URL Firebase:</label>
            <input type="text" id="urlFirebase" data-nombre="URL Firebase" name="urlFirebase" <?= !$editar ? 'disabled' : '' ?> class="soloLetras form-control configAct" required autocomplete="off"placeholder="Ingrese la url de firebase">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>