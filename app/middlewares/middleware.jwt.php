<?php
    require_once "libs/jwt.php";
    
    class JWTmiddleware{
        public function run($req,$res){
            $auth_header=$_SERVER['HTTP_AUTHORIZATION'];
            $auth_header=explode(' ',$auth_header);//Bearer header.payload.signature

            //verifico que sea Bearer header.payload.signature,token
            if(count($auth_header)!=2)
                return;

            if($auth_header[0]!='Bearer')
                return;

            $jwt=$auth_header[1];
            $res->user=validateJwt($jwt);
        }
    }