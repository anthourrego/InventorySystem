<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Database;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{

    public $content;
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $db;
    protected $routes;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->routes = service("routes");
        $this->db = Database::connect();

        $this->db->simpleQuery("SET time_zone = '-05:00'");

        $this->content['Project_Name'] = "Inventory System";

        $this->LJQuery();

        if(session()->has("logged_in") && session()->get("logged_in")){
            $this->LAdminLTE();
            $this->LOverlayScrollbars();
            $this->LGlobal();
            $this->content['Project_Name'] = session()->get("nombreEmpresa");
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

    public function LExport() {
        $this->content['js'][] = [
            'assets/Libraries/ExportExcel/export-excel.js'
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
            'vendor/datatables.net/datatables.net-bs4/css/dataTables.bootstrap4.min.css'
            ,'vendor/datatables.net/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
        ];

        $this->content['js'][] = [
            'vendor/datatables.net/datatables.net/js/dataTables.min.js'
            ,'vendor/datatables.net/datatables.net-bs4/js/dataTables.bootstrap4.min.js'
            ,'vendor/datatables.net/datatables.net-buttons/js/dataTables.buttons.min.js'
            ,'vendor/datatables.net/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'
            ,'vendor/stuk/jszip/dist/jszip.min.js'
            ,'vendor/bpampuch/pdfmake/build/pdfmake.min.js'
            ,'vendor/bpampuch/pdfmake/build/vfs_fonts.js'
            ,'vendor/datatables.net/datatables.net-buttons/js/buttons.html5.min.js'
            ,'vendor/datatables.net/datatables.net-buttons/js/buttons.print.min.js'
            ,'vendor/datatables.net/datatables.net-scroller/js/dataTables.scroller.min.js'
            ,'vendor/datatables.net/datatables.net-select/js/dataTables.select.min.js'
        ];

        $this->content['js_add'][] = [
            'DataTables.js'
        ];
    }

    public function LMoment(){
        $this->content['js'][] = [
            'vendor/moment/moment/moment.js',
            'vendor/moment/moment/locale/es-mx.js'
        ];
    }

    public function LLightbox(){
        $this->content['css'][] = [
            'assets/Libraries/lightbox/lightbox.min.css'
        ];

        $this->content['js'][] = [
            'assets/Libraries/lightbox/lightbox.min.js'
        ];
    }

    public function LFancybox(){
        $this->content['css'][] = [
            'assets/Libraries/fancybox/jquery.fancybox.min.css'
        ];

        $this->content['js'][] = [
            'assets/Libraries/fancybox/jquery.fancybox.min.js'
        ];
    }

    public function LSelect2(){
        $this->content['css'][] = [
            'vendor/select2/select2/dist/css/select2.min.css'
            ,'vendor/ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css'
        ];

        $this->content['js'][] = [
            'vendor/select2/select2/dist/js/select2.full.min.js',
            'vendor/select2/select2/dist/js/i18n/es.js',
        ];

        $this->content['js_add'][] = [
            'select2.js'
        ];
    }

    public function LInputMask(){
        $this->content['js'][] = [
            'vendor/robinherbots/jquery.inputmask/dist/jquery.inputmask.min.js',
        ];

        $this->content['js_add'][] = [
            'InputMask.js'
        ];
    }

    public function Lgijgo(){
        $this->content['css'][] = [
            'assets/Libraries/gijgo/css/gijgo.min.css'
        ];

        $this->content['js'][] = [
            'assets/Libraries/gijgo/js/gijgo.min.js',
            'assets/Libraries/gijgo/js/messages/messages.es-es.min.js'
        ];
    }

    public function LSweetAlert2(){
        $this->content['css'][] = [
            'assets/Libraries/sweetAlert2/css/sweetalert2.min.css'
        ];

        $this->content['js'][] = [
            'assets/Libraries/sweetAlert2/js/sweetalert2.min.js'
        ];
    }

    public function LCropperImageEditor(){
        $this->content['css'][] = [
            'assets/Libraries/rcrop/rcrop.min.css'
        ];
        $this->content['js'][] = [
            'assets/Libraries/rcrop/rcrop.min.js'
        ];
    }

    public function LTinymceEditor() {
        $this->content['js'][] = [
            'vendor/tinymce/tinymce/tinymce.min.js'
        ];
    }

    public function LBsCustomFileInput() {
        $this->content['js'][] = [
            'assets/Libraries/bs-custom-file-input/bs-custom-file-input.min.js'
        ];
    }

    public function LTempusDominusBoostrap4() {
        $this->content['css'][] = [
            'vendor/tempusdominus/bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css'
        ];
        $this->content['js'][] = [
            'vendor/tempusdominus/bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js'
        ];
    }
}
