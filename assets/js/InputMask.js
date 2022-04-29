$(function(){
  $(".inputPesos").inputmask({
    alias: 'decimal', 
    groupSeparator: '.',
    autoGroup: true, 
    digits: 2, 
    digitsOptional: false, 
    prefix: '$ ', 
    placeholder: '0,00'
  });

  $(".inputTel").inputmask({'mask':'(999) 999-9999'});
});