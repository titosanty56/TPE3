<?php
    require_once 'api/models/Model.php';

    class AerolineasModel extends Model{


        public function getAerolineas($Nombre = false, $orderBy = false, $Direction = false){
            $sql = 'SELECT * FROM `aerolinea`';

            //TP3-WEB2/api/aerolinea?Pais= Argentina
            if($Pais){
                $sql .= " WHERE `Pais` = ?";
            }

            if($orderBy){
                switch($orderBy){
                    case 'id':
                        $sql .= ' ORDER BY `id`';
                        break;
                    case 'Nombre':
                        $sql .= ' ORDER BY `Nombre`';
                        break;
                    case 'Pais':
                        $sql .= ' ORDER BY `Pais`';
                        break;
                    case 'Fundacion':
                        $sql .= ' ORDER BY `Fundacion`';
                        break;
                    case 'servicios':
                        $sql .= ' ORDER BY `servicios`';
                        break;
                }
            }

            if($Direction == 'DESC'){
                $sql .= ' DESC';
            }

            //Ejecuto la consulta
            $query = $this->db->prepare($sql);

            if($Nombre){
                $query->execute([$Nombre]);
            }else{
                $query->execute();
            }

            //Obtengo los datos en un arreglo de objetos
            $aerolineas = $query->fetchAll(PDO::FETCH_OBJ); 
    
            return $aerolineas;
        }

        public function getAerolinea($id){
            $sql = 'SELECT * FROM aerolinea WHERE id = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);

            $aerolinea = $query->fetch(PDO::FETCH_OBJ); 
            
            return $aerolinea;
        }

        //TP3/api/aerolinea/:id
        public function deleteAerolinea($id){
            $sql = 'DELETE FROM aerolinea WHERE id=?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);
        }

        public function insertAerolinea($nombre, $pais, $fundacion, $servicios){
            $sql = 'INSERT INTO aerolinea(nombre, pais, fundacion, servicios) VALUES (?, ?, ?, ?)';

            $query = $this->db->prepare($sql);
            $query->execute([$nombre, $pais, $fundacion, $servicios]);

            $id = $this->db->lastInsertId();

            return $id;
        }

        public function editarAerolinea($id, $nombre, $pais, $fundacion, $servicios){
            $sql = 'UPDATE aerolinea SET nombre = ?, pais = ?, fundacion = ?, servicios = ? WHERE id = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id, $nombre, $pais, $fundacion, $servicios]);
        }
    }
