<?php
    require_once 'api/models/Model.php';

    class PersonasModel extends Model{


        public function getPersonas($Cantidad = false, $orderBy = false, $Direction = false){
            $sql = 'SELECT * FROM `persona`';

            //TP3-WEB2/api/persona?nombre=Personas Argentina
            if($Cantidad){
                $sql .= " WHERE `cantidad` = ?";
            }

            //TP3-WEB2/api/persona?orderBy=cantidad
            if($orderBy){
                switch($orderBy){
                    case 'id':
                        $sql .= ' ORDER BY `id`';
                        break;
                    case 'nombre':
                        $sql .= ' ORDER BY `nombre`';
                        break;
                    case 'edad':
                        $sql .= ' ORDER BY `edad`';
                        break;
                    case 'cantidad':
                        $sql .= ' ORDER BY `cantidad`';
                        break;
                    case 'destino':
                        $sql .= ' ORDER BY `destino`';
                        break;
                }
            }

            //TP3-WEB2/api/persona?orderBy=cantidad&Direction=DESC
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
            $sql = 'SELECT * FROM persona WHERE id = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id]);

            $persona = $query->fetch(PDO::FETCH_OBJ); 
            
            return $persona;
        }

        //TP3-WEB2/api/persona/:id
        public function deletePersona($id){
            $sql = 'DELETE FROM persona WHERE id=?';

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
            $sql = 'UPDATE persona SET nombre = ?, edad = ?, cantidad = ?, destino = ? WHERE id = ?';

            $query = $this->db->prepare($sql);
            $query->execute([$id, $nombre, $edad, $cantidad, $destino]);
        }
    }
