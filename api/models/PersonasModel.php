<?php
    require_once 'api/models/Model.php';

    class PersonasModel extends Model{


        public function getPersonas($Cantidad = false, $orderBy = false, $Direction = false){
            $sql = 'SELECT * FROM `persona`';

            //TP3-WEB2/api/persona?cantidad=2
            if($Cantidad){
                $sql .= " WHERE `Cantidad` = ?";
            }

            if($orderBy){
                switch($orderBy){
                    case 'id_persona':
                        $sql .= ' ORDER BY `id_persona`';
                        break;
                    case 'Nombre':
                        $sql .= ' ORDER BY `Nombre`';
                        break;
                    case 'edad':
                        $sql .= ' ORDER BY `edad`';
                        break;
                    case 'Cantidad':
                        $sql .= ' ORDER BY `Cantidad`';
                        break;
                    case 'Destino':
                        $sql .= ' ORDER BY `Destino`';
                        break;
                }
            }

            if($Direction == 'DESC'){
                $sql .= ' DESC';
            }

            //Ejecuto la consulta
            $query = $this->db->prepare($sql);

            if($Cantidad){
                $query->execute([$Cantidad]);
            }else{
                $query->execute();
            }

            //Obtengo los datos en un arreglo de objetos
            $personas = $query->fetchAll(PDO::FETCH_OBJ); 
    
            return $personas;
        }

        public function getPersona($id){
            $sql = 'SELECT * FROM persona WHERE id_persona = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);

            $persona = $query->fetch(PDO::FETCH_OBJ); 
            
            return $persona;
        }

        //TP3/api/persona/:id
        public function deletePersona($id){
            $sql = 'DELETE FROM persona WHERE id_persona=?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);
        }

        public function insertPersona($nombre, $edad, $cantidad, $destino){
            $sql = 'INSERT INTO persona (nombre, edad, cantidad, destino) VALUES (?, ?, ?, ?)';

            $query = $this->db->prepare($sql);
            $query->execute([$nombre, $edad, $cantidad, $destino]);

            $id = $this->db->lastInsertId();

            return $id;
        }

        public function editarPersona($id, $nombre, $edad, $cantidad, $destino){
            $sql = 'UPDATE persona SET nombre = ?, edad = ?, cantidad = ?, destino = ? WHERE id_persona = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id, $nombre, $edad, $cantidad, $destino]);
        }
    }
