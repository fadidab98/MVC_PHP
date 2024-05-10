<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;

class SiteController extends Controller
{
        public function index(){
            $params = [
                'name'=> "FadiDabboura"
            ];
            return $this->render("layouts.user.main.home",$params);
        }
    public function contact(Request $request):string
    {
            $body = $request->postBody();
            var_dump($body);
        $params = [
            'name'=> "FadiDabboura"
        ];
        return "handling";
    }
}