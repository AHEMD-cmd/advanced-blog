<?php

namespace App\Controllers;

use System\Controller;
 
class HomeController extends Controller
{
    public function index($arg){
        
        echo $this->app->request->url();
    }

    

    
}