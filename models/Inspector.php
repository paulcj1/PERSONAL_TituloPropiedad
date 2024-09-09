<?php
    class Inspector extends Conectar{
        public function get_inspector(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * 
                    FROM sc_titulopropiedad.tb_inspector
                    WHERE 
                    est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_inspector($insp_nombre,$insp_apep, $insp_apem,$insp_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_titulopropiedad.tb_inspector (insp_nombre,insp_apep, insp_apem,insp_dni, est) VALUES (?,?,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $insp_nombre);
            $sql->bindValue(2, $insp_apep);
            $sql->bindValue(3, $insp_apem);
            $sql->bindValue(4, $insp_dni);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_inspector_x_id_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        i.insp_id,
                        i.insp_nombre,
                        i.insp_apep,
                        i.insp_apem,
                        i.insp_dni
                    FROM 
                        sc_titulopropiedad.tb_certificado c INNER JOIN
                        sc_titulopropiedad.tb_inspector i on c.insp_id = i.insp_id
                    WHERE 
                        i.est = 1 AND c.cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function update_inspector($insp_id,$insp_nombre,$insp_apep,$insp_apem,$insp_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_inspector
                    SET
                        insp_nombre = ?,
                        insp_apep = ?,
                        insp_apem = ?,
                        insp_dni = ?

                    WHERE
                        insp_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $insp_nombre);
            $sql->bindValue(2, $insp_apep);
            $sql->bindValue(3, $insp_apem);
            $sql->bindValue(4, $insp_dni);
            $sql->bindValue(5, $insp_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        
        public function delete_inspector($insp_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_inspector
                SET
                    est = 0
                WHERE
                    insp_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $insp_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    
        
        public function get_inspector_id($insp_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_titulopropiedad.tb_inspector WHERE insp_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $insp_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }