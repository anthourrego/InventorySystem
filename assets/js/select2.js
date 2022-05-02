$(function () {
  $('.select2').each(function () {
    $(this).select2({
      width: '100%',
      theme: 'bootstrap4',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
      closeOnSelect: !$(this).attr('multiple'),
    });
  });
});
