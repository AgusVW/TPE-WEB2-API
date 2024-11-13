<?php
    require_once "app/views/json.view.php";
    require_once "app/models/clubes.model.php";

    class ClubController{
        private $model;
        private $view;

        public function __construct(){
            $this->model=new ClubModel();
            $this->view=new JSONView();
        }

        public function getAll($req,$res){
            $orderBy=null;
            $tipoOrder=null;
            $club=null;
            $fundacion=null;
            $localidad=null;
            $sede=null;
            $contacto=null;

            if(isset($req->query->orderBy))
                $orderBy=$req->query->orderBy;

            if(isset($req->query->tipoOrder))
                $tipoOrder=$req->query->tipoOrder;

            if(isset($req->query->club))
                $club=$req->query->club;

            if(isset($req->query->fundacion))
                $fundacion=$req->query->fundacion;

            if(isset($req->query->localidad))
                $localidad=$req->query->localidad;

            if(isset($req->query->sede))
                $sede=$req->query->sede;

            if(isset($req->query->contacto))
                $contacto=$req->query->contacto;

            $clubes=$this->model->getAll($orderBy,$tipoOrder,$club,$fundacion,$localidad,$sede,$contacto);
            return $this->view->response($clubes,200);
        }

        public function get($req,$res){
            $id=$req->params->id;
            $club=$this->model->get($id);
            if(!$club)
                return $this->view->response("El club que busca no existe",404);

            return $this->view->response($club,200);
        }

        public function add($req,$res){
            if(!$res->user)
                return $this->view->response("Usted no esta logueado",401);

            if(empty($req->body->club)||empty($req->body->fundacion)||empty($req->body->localidad)||
            empty($req->body->sede)||empty($req->body->contacto)){
                return $this->view->response("Complete todos los campos para insertar",400);
            }

            $club=$req->body->club;
            $fundacion=$req->body->fundacion;
            $localidad=$req->body->localidad;
            $sede=$req->body->sede;
            $contacto=$req->body->contacto;
            
            $id=$this->model->create($club,$fundacion,$localidad,$sede,$contacto);
            if(!$id){
                return $this->view->response("Hubo algun error al insertar la tarea en la base de datos",500);
            }

            $club=$this->model->get($id);
            return $this->view->response($club,201);
        }

        public function delete($req,$res){
            $id=$req->params->id;
            $club=$this->model->get($id);
            if(!$club)
                return $this->view->response("El club a eliminar no existe",404);

            $this->model->delete($id);
            return $this->view->response("Se elimino con exito el club con id=$id",200);
        }

        public function update($req,$res){
            if(!$res->user)
                return $this->view->response("Usted no esta logueado",401);

            $id=$req->params->id;
            $clubById=$this->model->get($id);
            if(!$clubById)
                return $this->view->response("El club a editar no existe",404);

            if(empty($req->body->club)||empty($req->body->fundacion)||empty($req->body->localidad)||
            empty($req->body->sede)||empty($req->body->contacto)){
                return $this->view->response("Complete todos los campos para editar el club",400);
            }

            $club=$req->body->club;
            $fundacion=$req->body->fundacion;
            $localidad=$req->body->localidad;
            $sede=$req->body->sede;
            $contacto=$req->body->contacto;

            $this->model->update($id,$club,$fundacion,$localidad,$sede,$contacto);
            $clubEditado=$this->model->get($id);
            return $this->view->response($clubEditado,200);
        }
    }