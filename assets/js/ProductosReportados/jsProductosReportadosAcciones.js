let idProdsReported = `modalProductosReportados`;

function iniciarProductosReportados(datosRender) {
  $('body').append(`<div class="modal fade modalFormulario" id="${idProdsReported}" data-backdrop="static" data-keyboard="false" aria-labelledby="${idProdsReported}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="${idProdsReported}Label">Reporte de productos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="spinner-border" role="status"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>`);
  $('#' + idProdsReported).modal('show');
  $('#' + idProdsReported + " .modal-body").load(`${base_url()}ProductosReportados/home/${datosRender.modulo}/${datosRender.idRegistro}`);
}