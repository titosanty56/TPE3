<?php
    require_once 'api/views/json.view.php';
    require_once 'api/models/AerolineasModel.php';

    class AerolineasApiController{
        private $model;
        private $view;

        public function __construct(){
            $this->model = new AerolineasModel();
            $this->view = new JSONView();
        }

        public function getAllAerolineas($req, $res){
            //Filtrado por pais
            $Pais = false;
            if(isset($req->query->Pais)){
                $Pais = $req->query->Pais;
            }
    
            $orderBy = false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $Direction = false;
            if(isset($req->query->Direction)){
                $Direction = $req->query->Direction;
            }

            $pagina = false;
            if(isset($req->query->pagina)){
                if(is_numeric($req->query->pagina)){
                    $pagina = $req->query->pagina;
                }
            }

            $items = false;
            if(isset($req->query->items)){
                if(is_numeric($req->query->items)){
                    $items = $req->query->items;
                }
            }
        

            //traigo aerolineas a la db
            $aerolineas = $this->model->getAerolineas($Pais, $orderBy, $Direction, $pagina, $items);

            if(!$aerolineas){
                return $this->view->response("No hay aerolineas para mostrar", 404);
            }
            //envio las aerolineas a la vista
            return $this->view->response($aerolineas);
        }

        public function getAerolinea($req, $res){
            //obtengo id de las aerolineas desde la ruta
            $id = $req->params->id;
            
            $aerolinea = $this->model->getAerolinea($id);
            
            if(!$aerolinea) {
                return $this->view->response("La aerolinea con el id=$id no existe", 404);
            }

            return $this->view->response($aerolinea);
        }

        public function delete($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id = $req->params->id;

            $aerolinea = $this->model->getAerolinea($id);
            if(!$aerolinea) {
                return $this->view->response("La aerolinea con el id=$id no existe", 404);
            }

            $this->model->deleteAerolinea($id);
            $this->view->response("La aerolinea con el id= $id se elimino con exito");
        }

        public function create($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            if(empty($req->body->Nombre) || empty($req->body->Pais) || empty($req->body->Fundacion) || empty($req->body->servicios)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->Nombre;
            $pais = $req->body->Pais;
            $fundacion= $req->body->Fundacion;
            $servicios = $req->body->servicios;

            $id = $this->model->insertAerolinea($nombre,$pais,$fundacion,$servicios);

            if(!$id){
                return $this->view->response('Error al insertar la aerolinea', 500);
            }

            $aerolinea = $this->model->getAerolinea($id);
            return $this->view->response($aerolinea, 201);
        }

        public function edit($req, $res){
            if($res->user == null) {
                return $this->view->response("No autorizado", 401);
            }

            $id = $req->params->id;

            $aerolinea = $this->model->getAerolinea($id);
            if(!$aerolinea){
                return $this->view->response("La aerolinea con el id=$id no existe", 404);
            }

            if(empty($req->body->Nombre) || empty($req->body->Pais) || empty($req->body->Fundacion) || empty($req->body->servicios)){
                return $this->view->response('Falta completar campos', 400);
            }

            $nombre = $req->body->Nombre;
            $pais= $req->body->Pais;
            $fundacion = $req->body->Fundacion;
            $servicios = $req->body->servicios;

            $this->model->editar($id, $nombre, $pais, $fundacion, $servicios);

            $aerolinea = $this->model->getAerolinea($id);
            $this->view->response($aerolinea, 200); 

        }
    }