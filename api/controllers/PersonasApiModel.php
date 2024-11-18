<?php
    require_once 'api/views/json.view.php';
    require_once 'api/models/PersonasModel.php';

    class PersonasApiController{
        private $model;
        private $view;

        public function __construct(){
            $this->model = new PersonasModel();
            $this->view = new JSONView();
        }

        public function getAllPersonas($req, $res){
            //Filtrado por cantidad
            $Cantidad = false;
            if(isset($req->query->cantidad)){
                $Cantidad = $req->query->cantidad;
            }
    
            $orderBy = false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $Direction = false;
            if(isset($req->query->Direction)){
                $Direction = $req->query->Direction;
            }

            //traigo personas a la db
            $personas = $this->model->getAllPersonas($Cantidad, $orderBy, $Direction);

            if(!$personas){
                return $this->view->response("No hay Personas para mostrar", 404);
            }
            //envio las fabricas a la vista
            return $this->view->response($personas);
        }

        public function getPersona($req, $res){
            //obtengo id de las personas desde la ruta
            $id = $req->params->id;
            
            $persona = $this->model->getPersona($id);
            
            if(!$persona) {
                return $this->view->response("La persona con el id=$id no existe", 404);
            }

            return $this->view->response($persona);
        }

        public function delete($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id = $req->params->id;

            $persona = $this->model->getPersona($id);
            if(!$persona) {
                return $this->view->response("La persona con el id=$id no existe", 404);
            }

            $this->model->deletePersona($id);
            $this->view->response("La persona con el id= $id se elimino con exito");
        }

        public function create($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            if(empty($req->body->nombre) || empty($req->body->edad) || empty($req->body->cantidad) || empty($req->body->destino)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->nombre;
            $edad = $req->body->edad;
            $cantidad = $req->body->cantidad;
            $destino = $req->body->destino;

            $id = $this->model->insertPersona($nombre,$edad,$cantidad,$destino);

            if(!$id){
                return $this->view->response('Error al insertar la persona', 500);
            }

            $persona = $this->model->getPersona($id);
            return $this->view->response($persona, 201);
        }

        public function edit($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id = $req->params->id;

            $persona = $this->model->getPersona($id);
            if(!$persona){
                return $this->view->response("La persona con el id=$id no existe", 404);
            }

            if(empty($req->body->nombre) || empty($req->body->edad) || empty($req->body->cantidad) || empty($req->body->destino)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->nombre;
            $edad = $req->body->edad;
            $cantidad = $req->body->cantidad;
            $destino = $req->body->destino;

            $this->model->editar($id, $nombre, $edad, $cantidad, $sdestino);

            $persona = $this->model->getPersona($id);
            $this->view->response($persona, 200); 

        }
    }