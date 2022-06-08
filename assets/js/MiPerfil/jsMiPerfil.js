let baseRuta = base_url() + "Perfil/";

var arbolModulos = $('#tree').tree({
  primaryKey: 'campo',
  uiLibrary: 'bootstrap4',
  checkboxes: true,
  select: false,
  cascadeCheck: false,
  dataSource: modulos
});

$(function () {
  console.log("Carga");
});