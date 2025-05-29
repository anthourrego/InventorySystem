<div class="row">
  <div class="col-12">
    <div class="card">
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
                        <th style="width: 12%; text-align: center;" colspan="2">Saldo Inicial</th>
                        <th style="width: 12%; text-align: center;" colspan="2">Movimientos</th>
                        <th style="width: 12%; text-align: center;" colspan="2">Saldo final</th>
                      </tr>
                    </thead>
                    <thead class="table-header">
                      <tr>
                        <th style="text-align: left; width: 30%;">Cuenta contable</th>
                        <th style="width: 12%; text-align: center;">Débito</th>
                        <th style="width: 12%; text-align: center;">Crédito</th>
                        <th style="width: 12%; text-align: center;">Débito</th>
                        <th style="width: 12%; text-align: center;">Crédito</th>
                        <th style="width: 12%; text-align: center;">Débito</th>
                        <th style="width: 10%; text-align: center;">Crédito</th>
                      </tr>
                    </thead>

                    <tbody id="balance-tbody">
                      <?php function renderAccount($cuenta, $padre, $nivel = 0) { ?>
                        <tr class="account-row level-<?=$cuenta->id?>-<?=$nivel?> collapsible <?=str_replace(" ", "_", $padre->nombre);?>" data-level="<?=$cuenta->id?>-<?=$nivel?>">
                          <td class="account-name" style="padding-left: <?=$nivel*15?>px">
                            <?php if (!empty($cuenta->children)) { ?>
                              <i class="fas fa-minus expand-icon expanded" style="cursor: pointer;" data-target="<?=str_replace(" ", "_", $padre->nombre)?>"></i>
                            <?php } else { ?>
                              <i class="fas fa-minus" style="color: transparent;"></i>
                            <?php } ?>
                            <?= $cuenta->nombre ?>
                          </td>
                          <td class="amount-cell amount-positive">$106.000.000</td>
                          <td class="amount-cell amount-zero">$0</td>
                          <td class="amount-cell amount-zero">$0</td>
                          <td class="amount-cell amount-zero">$0</td>
                          <td class="amount-cell amount-positive">$106.000.000</td>
                          <td class="amount-cell amount-zero">$0</td>
                        </tr>
                        <?php if (!empty($cuenta->children)):
                          foreach ($cuenta->children as $children) {
                            renderAccount($children, $cuenta, $nivel + 1);
                          }
                        endif;
                      } ?>

                      <?php foreach ($cuentasContables as $index => $cuentaContable): ?>
                        <?php renderAccount($cuentaContable, $cuentaContable); ?>
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
