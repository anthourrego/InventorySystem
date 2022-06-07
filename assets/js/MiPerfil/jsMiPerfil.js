let rutaBase = base_url() + "ConfiguracionUsuario/";

var arbolPermisos = $('#tree').tree({
  primaryKey: 'id',
  uiLibrary: 'bootstrap4',
  checkboxes: true,
  select: false,
  cascadeCheck: false,
  dataSource: $PERMISOS
});

$(function () {

});