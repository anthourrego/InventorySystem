<div class="row">
  <div class="col-12 col-md-6">
    <div class="card">
      <div class="card-body">
        <div id="tree"></div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="row justify-content-end">
          <?php if (validPermissions([120101], true)) { ?>
          <div class="text-right">
            <button type="button" style="display: none;" class="btn btn-primary" id="btnHabilitarEditar"><i class="fa-solid fa-edit"></i> Editar</button>
          </div>
          <?php } ?>
          <?php if (validPermissions([120102], true)) { ?>
          <div class="text-right ml-2">
            <button type="button" style="display: none;" class="btn btn-danger" id="btnEliminarCuenta"><i class="fa-solid fa-trash"></i> Eliminar</button>
          </div>
          <?php } ?>
        </div>
        <form id="formCuenta" class="formValid">
          <input type="hidden" class="inputVer" name="id" id="id">
          <input type="hidden" class="inputVer" name="idParent" id="idParent">
          <div class="form-row">
            <div class="col-12 col-md-6 form-group form-valid">
              <label class="mb-0" for="nombre">Código <span class="text-danger">*</span></label>
              <input placeholder="Código" class="form-control soloNumeros inputVer" id="codigo" name="codigo" type="text" minlength="1" maxlength="2" required autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label class="mb-0" for="nombre">Nombre <span class="text-danger">*</span></label>
              <input placeholder="Nombre" class="form-control soloLetrasEspacio inputVer" id="nombre" name="nombre" type="text" minlength="1" maxlength="255" required autocomplete="off">
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label for="tipo">Tipo Cuenta</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right"
                    title="Una cuenta de movimiento puedes usarla para registros contables o asientos automatizados, mientras que una cuenta mayor solo acumula los saldos correspondientes a sus subcuentas">
                    <i class="fa-solid fa-info"></i>
                  </button>
                </div>
                <select id="tipo" name="tipo" data-placeholder="Seleccione una opción" class="custom-select select2 inputVer">
                  <?php foreach (TIPOSCUENTACONTABILIDAD as $key => $value) {
                    echo '<option value="' . $value['valor'] . '">' . $value['titulo'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-6 form-group form-valid d-flex align-items-end">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" id="estado" aria-label="Checkbox for following text input inputVer">
                  </div>
                </div>
                <input type="text" style="font-weight: bold;" disabled readonly class="form-control" value="Estado" aria-label="Text input with checkbox">
              </div>
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label for="naturaleza">Naturaleza</label>
              <select id="naturaleza" name="naturaleza" data-placeholder="Seleccione una opción" class="custom-select select2 inputVer">
                <?php foreach (NATURALEZACUENTACONTABILIDAD as $key => $value) {
                  echo '<option value="' . $value['valor'] . '">' . $value['titulo'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-12 col-md-6 form-group form-valid">
              <label for="comportamiento">Comportamiento</label>
              <select id="comportamiento" name="comportamiento" data-placeholder="Seleccione una opción" class="custom-select select2 inputVer">
                <?php foreach (TIPOCOMPORTAMIENTOCONTABILIDAD as $clave => $item) {
                  echo '<option value="' . $clave . '">' . $item['titulo'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="d-flex justify-content-end btns-form">
            <button type="button" class="btn btn-secondary mr-2" id="bnt-cancelar-form" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            <button type="submit" class="btn btn-success" form="formCuenta"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  let $CUENTAS = <?= json_encode($cuentas) ?>;
  const TIPOSCUENTACONTABILIDAD = <?= json_encode(TIPOSCUENTACONTABILIDAD); ?>;
  const CLASIFICACIONCUENTACONTABILIDAD = <?= json_encode(CLASIFICACIONCUENTACONTABILIDAD); ?>;
  const CANADDACCOUNTS = <?= validPermissions([31], true); ?>
</script>
