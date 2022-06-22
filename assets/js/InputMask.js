$(function(){
  inputPesos();
  $(".inputTel").inputmask({'mask':'(999) 999-9999'});
});

function inputPesos(){
  $(".inputPesos").inputmask({
    alias: 'decimal', 
    groupSeparator: '.',
    autoGroup: true, 
    digits: 0, 
    digitsOptional: false, 
    prefix: '$ ', 
    placeholder: '0'
  }).focus(function(){
    $(this).trigger("select");
  });

}