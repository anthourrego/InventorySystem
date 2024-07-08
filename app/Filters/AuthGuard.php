<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface {

  public function before(RequestInterface $request, $arguments = null){
    if (!session()->has("logged_in") && !session()->get('logged_in')) {
      if ($request->isAJAX()) {
        $response = service('response');
        $resp["logged_out"] = true;
        $resp["logged_msj"] = "La sesión ha finalizado para continuar puedes abrir una nueva pestaña y iniciar sesión nuevamente o recargar esta pestaña para ser redireccionado al login.";
        return $response->setJSON($resp);
      } else {
        return redirect()->route('/');
      }
    }
    
    //Con los argumentos validamos los numero de permisos
    if ($arguments != null) {
      return validPermissions($arguments, false, $request->isAJAX());
    }
  }
  
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
      
  }
}