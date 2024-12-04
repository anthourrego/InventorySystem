<div class="card">
    <div class="card-header">
        <div class="row justify-content-between">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-warning mb-2 mb-xl-0" id="btnFiltros"><i class="fa-solid fa-filter"></i> Filtros</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tblReporteInventario" class="table table-sm table-striped table-hover table-bordered w-100">
                <thead>
                    <tr>
                    <th>Referencia | Item</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
            <div class="col-12 col-md-4 form-group">
              <label class="mb-0" for="selectEstado">Tipo</label>
              <select class="custom-select" id="selectEstado">
                <option value="I">Ingreso</option>
                <option value="S">Salida</option>
                <option selected value="-1">Todos</option>
              </select>
            </div>
            <div class="col-6 col-md-4 form-group form-valid">
              <label class="mb-0" for="cantIni">Cantidad Inicial</label>
              <input placeholder="Cantidad Inicial" class="form-control soloNumeros" id="cantIni" name="cantIni" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-6 col-md-4 form-group form-valid">
              <label class="mb-0" for="cantFin">Cantidad Final</label>
              <input placeholder="Cantidad Final" class="form-control soloNumeros" id="cantFin" name="cantFin" type="text" minlength="1" maxlength="255" autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="fechaIni">Fecha Inicial</label>
              <input placeholder="yyyy-mm-dd" class="form-control soloNumeros" id="fechaIni" name="fechaIni" type="date" autocomplete="off">
            </div>
            <div class="col-6 form-group form-valid">
              <label class="mb-0" for="fechaFin">Fecha Final</label>
              <input placeholder="yyyy-mm-dd" class="form-control soloNumeros" id="fechaFin" name="fechaFin" type="date" autocomplete="off">
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