<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface {

  public function before(RequestInterface $request, $arguments = null){
    if (!session()->has("logged_in") && !session()->get('logged_in')) {
      return redirect()->route('/');
    }
    
    //Con los argumentos validamos los numero de permisos
    if ($arguments != null) {
      return validPermissions($arguments, false, $request->isAJAX());
    }
  }
  
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
      
  }
}