<style>
  #tblBusqueda_filter label, #tblBusqueda_filter label input {
		width: 100%;
    margin-left: 0px;
	}
  #tblBusqueda td:not(.dataTables_empty) {
		cursor: pointer;
	}
</style>
<table class="table table-bordered table-sm table-hover table-fixed table-striped w-100" id="tblBusqueda" cellspacing="0">
	<thead>
		<tr>
		<?php if(count($campos) > 0){
			foreach ($campos as $key) { ?>
				<th><?= $key ?></th>
			<?php }
		}else{ ?>
			<th>Código</th>
			<th>Nombre</th>
		<?php } ?>
		</tr>
	</thead>
	<tbody></tbody>
</table>