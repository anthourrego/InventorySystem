$.fn.select2.defaults.set('width', '100%');
$.fn.select2.defaults.set('theme', 'bootstrap4');
$.fn.select2.defaults.set('placeholder', $(this).data('placeholder'));
$.fn.select2.defaults.set('allowClear', Boolean($(this).data('allow-clear')));
$.fn.select2.defaults.set('closeOnSelect', !$(this).attr('multiple'));

$(function () {
  $('.select2').each(function () {
    $(this).select2();
  });
});
