<?php

namespace App\Controllers;

class Home extends Libraries {
    public function index() {
        $this->LJQueryValidation();
        
        $this->content['title'] = "Inicio Sesión";
        $this->content['view'] = "vLogin";
        $this->content['css_add'][] = [
            'Login.css'
        ];

        $this->content['js_add'][] = [
            'Login.js'
        ];
        
        return view('UI/viewSimple', $this->content);
    }
    
    public function iniciarSesion(){
        if ($this->request->isAJAX()){
            echo "funca";
        } else {
            show_404();
        }
    }
}
