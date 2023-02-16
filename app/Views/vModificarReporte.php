<div class="row">
	<div class="col-7">
		<div class="card">
      <div class="card-header">
        <?php
          foreach ($reportes as $key => $value) {
            echo "<button type='button' class='btn btn-" . $value['color'] . " ml-2 btn-reporte' title='" . $key . "' data-btn='" . str_replace(" ", "", $key) . "'>
              <span class='badge'><i class='" . $value['icono'] . "'></i></span> " . str_replace("_", " ", $key) . "
            </button>";
          }
        ?>
      </div>
			<div class="card-body">   
        <div class="table-responsive">
          <table id="tblVariables" class="table table-sm table-striped table-hover table-bordered w-100">
            <thead> 
              <tr>
                <th>Variable</th>
                <th>Descripción</th>
                <th>Aplica</th>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach ($variables as $llave => $valor) {
                echo "<tr>
                  <td>{" . $llave . "}</td>
                  <td>" . $valor['descripcion'] . "</td>
                  <td>
                ";
                $btns = "";
                foreach ($valor['aplica'] as $opcion) {
                  $btns .= "<button type='button' class='btn btn-sm btn-" . $reportes[$opcion]['color'] . " ml-2 btnaplica " . str_replace(" ", "", $opcion) . "' title='" . $opcion . "'>
                    <i class='" . $reportes[$opcion]['icono'] . "'></i>
                  </button>";
                }
                echo $btns . "</td></tr>";
              }
            ?>
            </tbody>
          </table>
        </div> 
			</div>
		</div>
	</div>
	<div class="col-5">
		<div class="card">
			<div class="card-body">
        <!-- <div class="alert alert-warning" role="alert">
          <?php
            foreach ($instrucciones as $value) {
              echo "<span>" . $value . "</span></br>";
            }
          ?>
        </div> -->
        <h4>Modificar Reporte</h4>
        <div class="row">
          <?php
            foreach ($reportes as $key => $value) {
              echo "<div class='col-12 col-md-4 mt-2'>
                <button type='button' class='btn btn-" . $value['color'] . " btn-modifica-reporte w-100' title='Editar " . $key . "' data-btn='" . str_replace(" ", "_", $key) . "'>
                <span class='badge'><i class='" . $value['icono'] . "'></i></span>" . str_replace("_", " ", $key) . "
                </button>
              </div>";
            }
          ?>
        </div>
        <hr>
        <h4>Plantilla Reporte</h4>
        <div class="row">
          <?php
            foreach ($reportes as $key => $value) {
              echo "<div class='col-12 col-md-4 mt-2'>
                <button type='button' class='btn btn-" . $value['color'] . " btn-plantilla-reporte w-100' title='Reemplazar " . $key . "' data-btn='" . str_replace(" ", "_", $key) . "'>
                <span class='badge'><i class='" . $value['icono'] . "'></i></span>" . str_replace("_", " ", $key) . "
                </button>
              </div>";
            }
          ?>
        </div>
      </div>
		</div>
	</div>
</div>