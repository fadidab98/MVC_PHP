<?php

namespace app\model;

use app\core\Model;

class RegisterModel extends Model
{
    public string $email ='';
    public string $password ='';
    public string $repeat_password ='';

    public function register()
    {
        return "Creating New User";
    }
    public function rules():array
    {
    return [
        "email" => [self::RULE_REQUIRED,self::RULE_EMAIL],
        "password" =>  [self::RULE_REQUIRED,[self::RULE_MIN,"min"=>8],[self::RULE_MAX,"max"=>20]],
        "repeat_password" =>  [self::RULE_REQUIRED,[self::RULE_MATCH,"match"=>"password"]]
    ];
    }
}