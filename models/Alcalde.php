<?php
    class Alcalde extends Conectar{

        

        public function get_alcalde(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT  
                           *
                    FROM 
                            sc_titulopropiedad.tb_alcalde 
                            
                    WHERE  
                            est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_alcalde($alca_nom,$alca_apep, $alca_apem,$alca_dni, $alca_fechini, $alca_fechfin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_titulopropiedad.tb_alcalde (alca_nom,alca_apep, alca_apem,alca_dni, alca_fechini, alca_fechfin, alca_est ,est) VALUES (?,?,?,?,?,?,'1','1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $alca_nom);
            $sql->bindValue(2, $alca_apep);
            $sql->bindValue(3, $alca_apem);
            $sql->bindValue(4, $alca_dni);
            $sql->bindValue(5, $alca_fechini);
            $sql->bindValue(6, $alca_fechfin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function update_alcalde($alca_id ,$alca_nom,$alca_apep, $alca_apem,$alca_dni, $alca_fechini, $alca_fechfin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_alcalde
                    SET
                        alca_nom = ?,
                        alca_apep = ?,
                        alca_apem = ?,
                        alca_dni = ?,
                        alca_fechini = ?,
                        alca_fechfin = ?

                    WHERE
                        alca_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $alca_nom);
            $sql->bindValue(2, $alca_apep);
            $sql->bindValue(3, $alca_apem);
            $sql->bindValue(4, $alca_dni);
            $sql->bindValue(5, $alca_fechini);
            $sql->bindValue(6, $alca_fechfin);
            $sql->bindValue(7, $alca_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        
        public function delete_alcalde($alca_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_alca
                SET
                    est = 0
                WHERE
                    alca_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $alca_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    
        public function get_alcalde_activo(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT  
                            *
                    FROM 
                            sc_titulopropiedad.tb_alcalde 
                    WHERE  
                            alca_est = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function alcalde_cambiarestado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE 
                        sc_titulopropiedad.tb_alcalde 
                    SET 
                        alca_est = 0
                    WHERE 
                        alca_fechfin < CURRENT_DATE AND alca_est = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            $rows_affected = $sql->rowCount();

        }
        public function alcalde_comprobar(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT alca_id
                    FROM sc_titulopropiedad.tb_alcalde 
                    WHERE est = 1 AND alca_est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            $rows_affected = $sql->rowCount();
            return $rows_affected > 0 ? ['status' => 'success', 'message' => 'Alcaldes activos encontrados'] : ['status' => 'error', 'message' => 'No hay alcaldes activos'];
        }
        public function get_alcalde_id($alca_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_titulopropiedad.tb_alcalde WHERE alca_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $alca_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

}