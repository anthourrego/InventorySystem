<?php 
namespace App\Controllers;

class Libraries extends BaseController {

  public $content;
  
  function __construct() {
    $this->content['Project_Name'] = "Inventory System";
    $this->LJQuery();
    $this->LBootstrap();
    $this->LAlertify();
    $this->LFontAwesome();
  }

  public function LJQuery(){
    $this->content['js'][] = [
      'vendor/components/jquery/jquery.min.js'
    ];
  }

  public function LBootstrap(){
    $this->content['css'][] = [
      'vendor/twbs/bootstrap/dist/css/bootstrap.min.css'
    ];

    $this->content['js'][] = [
      'vendor/twbs/bootstrap/dist/js/bootstrap.min.js'
    ];
  }

  public function LJQueryValidation(){
    $this->content['js'][] = [
      'assets/Libraries/jquery-validation/jquery.validate.min.js'
      ,'assets/Libraries/jquery-validation/additional-methods.min.js'
      ,'assets/Libraries/jquery-validation/messages_es.min.js'
      ,'assets/Libraries/validate.js'
    ];
  }

  public function LAlertify(){
    $this->content['css'][] = [
      'assets/Libraries/alertifyjs/css/alertify.min.css'
      ,'assets/Libraries/alertifyjs/css/themes/bootstrap.min.css'
    ];

    $this->content['js'][] = [
      'assets/Libraries/alertifyjs/alertify.min.js'
    ];
  }

  public function LFontAwesome(){
    $this->content['css'][] = [
      'vendor/fortawesome/font-awesome/css/all.min.css'
    ];
  }

} 