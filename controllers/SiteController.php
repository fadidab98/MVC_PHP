<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

class SiteController extends Controller
{
        public function index(){
            $params = [
                'name'=> "FadiDabboura"
            ];
            return $this->render("layouts.user.main.home",$params);
        }
}