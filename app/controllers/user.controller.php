<?php
    require_once "app/models/user.model.php";
    require_once "app/views/json.view.php";
    require_once "libs/jwt.php";

    class UserController{
        private $model;
        private $view;

        public function __construct()
        {
            $this->model=new UserModel();
            $this->view=new JSONView();
        }

        public function getToken($req,$res){
            //obtengo el mail y password desde el header "basic"
            $auth_header=$_SERVER['HTTP_AUTHORIZATION'];
            $auth_header=explode(' ',$auth_header);
            //verifico si tiene tipo de auth y datos usuario
            if(count($auth_header)!=2)
                return $this->view->response("Los datos ingresados no son correctos",400);

            if($auth_header[0]!='Basic')
                return $this->view->response("Errror en el tipo de verificacion",400);
            
            //desencripto los datos usuario
            $user=base64_decode($auth_header[1]);
            $user=explode(':',$user);

            //busco en la base de datos con el email si es que existe
            $userDb=$this->model->getUserByEmail($user[0]);

            if($userDb && password_verify($user[1],$userDb->password)){
                $payload=new stdClass();
                $payload->id=$userDb->id;
                $payload->email=$userDb->email;
                $payload->rol='admin';
                $payload->actividad=time();
                $payload->expiracion=time()+60;

                $token=createJWT($payload);
                return $this->view->response($token);
            }

            return $this->view->response("Los datos ingresados no coinciden con ningun usuario",400);   
        }

    }