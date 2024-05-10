<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\model\RegisterModel;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if($request->is_Post())
        {
            return "Login Handler";
        }
        if($request->is_Get())
        {
            return $this->render("layouts.user.main.login");
        }
    }
    public function register(Request $request)
    {
        $registerModel = new RegisterModel();
       if($request->is_Post())
       {
           $registerModel->loadData($request->postBody());
           if($registerModel->validate() && $registerModel->register())
           {
               return "Registered Successfully";
           }
           return $this->render("layouts.user.main.register",["model"=>$registerModel]);
       }
        if($request->is_Get())
        {
            return $this->render("layouts.user.main.register",["model"=>$registerModel]);
        }
    }
}