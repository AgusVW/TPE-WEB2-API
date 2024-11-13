<?php
    require_once "app/models/Model.php";

    class ClubModel extends Model{

        public function getAll($orderBy,$tipoOrder,$club,$fundacion,$localidad,$sede,$contacto){
            $sql='SELECT * FROM club';

            if($club!=null)
                $sql.=" WHERE club='$club'";

            if($fundacion!=null)
                $sql.=" WHERE fundacion='$fundacion'";

            if($localidad!=null)
                $sql.=" WHERE localidad='$localidad'";

            if($sede!=null)
                $sql.=" WHERE sede='$sede'";

            if($contacto!=null)
                $sql.=" WHERE contacto=$contacto";

            if($orderBy!=null){
                switch($orderBy){
                    case 'id':
                        $sql.= ' ORDER BY id_club';
                        break;

                    case 'club':
                        $sql.= ' ORDER BY club';
                        break;

                    case 'fundacion':
                        $sql.= ' ORDER BY fundacion';
                        break;

                    case 'localidad':
                        $sql.= ' ORDER BY localidad';
                        break;

                    case 'sede':
                        $sql.= ' ORDER BY sede';
                        break;

                    case 'contacto':
                        $sql.= ' ORDER BY contacto';
                        break;
                    
                }
                
                if($tipoOrder!=null && str_contains($sql,"ORDER BY")){
                    switch($tipoOrder){
                        case 'ascendente':
                            $sql.= ' ASC';
                            break;
                        case 'descendente':
                            $sql.= ' DESC';
                            break;
                    }
                }

            }

            $query=$this->db->prepare($sql);
            $query->execute();
            $clubes=$query->fetchAll(PDO::FETCH_OBJ);
            return $clubes;
        }

        public function get($id){
            $query=$this->db->prepare('SELECT * FROM club WHERE id_club=?');
            $query->execute([$id]);
            $club=$query->fetch(PDO::FETCH_OBJ);
            return $club;
        }

        public function create($club,$fundacion,$localidad,$sede,$contacto){
            $query=$this->db->prepare('INSERT INTO club (club,fundacion,localidad,sede,contacto) VALUES (?,?,?,?,?)');
            $query->execute([$club,$fundacion,$localidad,$sede,$contacto]);
            $id=$this->db->lastInsertId();
            return $id;
        }

        public function delete($id){
            $query=$this->db->prepare('DELETE FROM club WHERE id_club=?');
            $query->execute([$id]);
        }

        public function update($id,$club,$fundacion,$localidad,$sede,$contacto){
            $query=$this->db->prepare('UPDATE club SET club=?,fundacion=?,localidad=?,sede=?,contacto=? WHERE id_club=?');
            $query->execute([$club,$fundacion,$localidad,$sede,$contacto,$id]);
            return;
        }


    }