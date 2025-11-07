<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-end">
          <div class="mr-3">
            <button class="btn btn-success w-100" id="exapandAll"><i class="fa-solid fa-expand"></i> Expandir Todo</button>
          </div>
          <div class="mr-3">
            <button class="btn btn-info w-100" id="collapseAll"><i class="fa-solid fa-compress"></i> Colapsar Todo</button>
          </div>
          <div>
            <button type="button" class="btn btn-warning mb-2 mb-xl-0" id="btnFiltros"><i class="fa-solid fa-filter"></i> Filtros</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="container-fluid py-4">
          <div class="row">
            <div class="col-12">
              <div class="balance-table">
                <div class="table-responsive">
                  <table class="table table-sm mb-0">
                    <thead class="table-header">
                      <tr>
                        <th style="text-align: left; width: 30%;"></th>
                        <th style="width: 12%; text-align: center;" colspan="2">Movimientos</th>
                      </tr>
                    </thead>
                    <thead class="table-header">
                      <tr>
                        <th style="text-align: left; width: 30%;">Cuenta contable</th>
                        <th style="width: 12%; text-align: center;">Total</th>
                        <!-- <th style="width: 12%; text-align: center;">Crédito</th> -->
                      </tr>
                    </thead>

                    <tbody id="balance-tbody">
                      <?php function renderAccount($cuenta, $padre = '', $nivel = 0) { ?>
                        <tr class="account-row level-<?=$cuenta->id?>-<?=$nivel?> <?=$nivel == 0 ? 'cuenta-padre' : ''?> collapsible <?=$padre == '' ? $padre : $padre->codigo;?>" data-level="<?=$cuenta->id?>-<?=$nivel?>">
                          <td class="account-name" style="padding-left: <?=$nivel*15?>px">
                            <?php if (!empty($cuenta->children)) { ?>
                              <i class="fas fa-minus expand-icon expanded" style="cursor: pointer;" data-target="<?=$cuenta->codigo;?>"></i>
                            <?php } else { ?>
                              <i class="fas fa-minus" style="color: transparent;"></i>
                            <?php } ?>
                            <?= $cuenta->nombre ?>
                          </td>
                          <td class="amount-cell amount-zero">$ <?=number_format($cuenta->movimientoDebito)?></td>
                          <!-- <td class="amount-cell amount-zero">$ <?=number_format($cuenta->movimientoCredito)?></td> -->
                        </tr>
                        <?php if (!empty($cuenta->children)):
                          foreach ($cuenta->children as $children) {
                            renderAccount($children, $cuenta, $nivel + 1);
                          }
                        endif;
                      } ?>

                      <?php foreach ($cuentasContables as $index => $cuentaContable): ?>
                        <?php renderAccount($cuentaContable); ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFiltros" data-backdrop="static" data-keyboard="false" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFiltrosLabel"><i class="fa-solid fa-filter"></i> Filtros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formFiltros">
          <div class="form-row">
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="fechaIni">Fecha Inicial</label>
              <input placeholder="yyyy-mm-dd" class="form-control soloNumeros" id="fechaIni" name="fechaIni" value="<?= isset($filtros['fechaIni']) ? $filtros['fechaIni'] : '' ?>" type="date" autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="fechaFin">Fecha Final</label>
              <input placeholder="yyyy-mm-dd" class="form-control soloNumeros" id="fechaFin" name="fechaFin" value="<?= isset($filtros['fechaFin']) ? $filtros['fechaFin'] : '' ?>" type="date" autocomplete="off">
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
