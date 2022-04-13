<?php 
namespace App\Controllers;

class Libraries extends BaseController {

  public $content;
  
  function __construct() {
    parent::__construct();
    
    $this->content['Project_Name'] = "Inventory System";
    $this->content["session"] = $this->session;
    $this->LJQuery();
    
    if($this->session->has("logged_in") && $this->session->get("logged_in")){
      $this->LAdminLTE();
      $this->LOverlayScrollbars();
      $this->LGlobal();
    } else {
      $this->LBootstrap();
    }

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
    ];

    $this->content['js_add'][] = [
      'validate.js'
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

  public function LAdminLTE(){
    $this->content['css'][] = [
      'vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css'
    ];

    $this->content['js'][] = [
      'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js'
      ,'vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js'
    ];
  }

  public function LGlobal(){
    $this->content['css_add'][] = [
      'Global.css'
    ];

    $this->content['js_add'][] = [
      'Global.js'
    ];
  }

  public function LOverlayScrollbars(){
    $this->content['css'][] = [
      'assets/Libraries/OverlayScrollbars/css/OverlayScrollbars.min.css'
    ];

    $this->content['js'][] = [
      'assets/Libraries/OverlayScrollbars/js/OverlayScrollbars.min.js'
    ];
  }

  public function LDataTables(){
    $this->content['css'][] = [
      'vendor/datatables/datatables/media/css/dataTables.bootstrap4.min.css'
      ,'vendor/datatables.net/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
    ];

    $this->content['js'][] = [
      'vendor/datatables/datatables/media/js/jquery.dataTables.min.js'
      ,'vendor/datatables/datatables/media/js/dataTables.bootstrap4.min.js'
      ,'vendor/datatables.net/datatables.net-buttons/js/dataTables.buttons.min.js'
      ,'vendor/datatables.net/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'
      ,'vendor/stuk/jszip/dist/jszip.min.js'
      ,'vendor/bpampuch/pdfmake/build/pdfmake.min.js'
      ,'vendor/bpampuch/pdfmake/build/vfs_fonts.js'
      ,'vendor/datatables.net/datatables.net-buttons/js/buttons.html5.min.js'
      ,'vendor/datatables.net/datatables.net-buttons/js/buttons.print.min.js'
      ,'vendor/datatables.net/datatables.net-scroller/js/dataTables.scroller.min.js'
    ];

    $this->content['js_add'][] = [
      'DataTables.js'
    ];
  }

} 