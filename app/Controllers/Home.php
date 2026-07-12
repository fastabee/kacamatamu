<?php

namespace App\Controllers;


class Home extends BaseController
{


    public function __construct()
    {
       
    }
    public function index()
    {
        
        $data = array(
           
            'body' => 'dashboard'
        );
        return view('template', $data);
    }
}
