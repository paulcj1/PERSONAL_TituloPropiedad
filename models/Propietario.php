<?php
    class Propietario extends Conectar{
        public function get_propietario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * 
                    FROM sc_titulopropiedad.tb_propietario
                    WHERE 
                    est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_propietario_id($prop_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_titulopropiedad.tb_propietario WHERE est = 1 AND prop_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prop_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_propietario($prop_nombre,$prop_apep,$prop_apem,$prop_estadocivil,$prop_dni,$prop_tipo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_titulopropiedad.tb_propietario (prop_nombre,prop_apep,prop_apem,prop_estadocivil,prop_dni,prop_tipo, est) VALUES (?,?,?,?,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prop_nombre);
            $sql->bindValue(2, $prop_apep);
            $sql->bindValue(3, $prop_apem);
            $sql->bindValue(4, $prop_estadocivil);
            $sql->bindValue(5, $prop_dni);
            $sql->bindValue(6, $prop_tipo);
            
            $sql->execute();
            return $conectar->lastInsertId();
        }
        public function update_propietario($prop_id,$prop_nombre,$prop_apep,$prop_apem,$prop_estadocivil,$prop_dni,$prop_tipo){
            $conectar= parent::conexion(); 
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_propietario
                SET
                    prop_nombre =?,
                    prop_apep = ?,
                    prop_apem = ?,
                    prop_estadocivil = ?,
                    prop_dni = ?,
                    prop_tipo = ?
                WHERE
                    prop_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prop_nombre);
            $sql->bindValue(2, $prop_apep);
            $sql->bindValue(3, $prop_apem);
            $sql->bindValue(4, $prop_estadocivil);
            $sql->bindValue(5, $prop_dni);
            $sql->bindValue(6, $prop_tipo);
            $sql->bindValue(7, $prop_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function delete_propietario($prop_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_propietario
                SET
                    est = 0
                WHERE
                    prop_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prop_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_propietario_x_id_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    p.prop_id,
                    p.prop_nombre,
                    p.prop_apep,
                    p.prop_apem,
                    p.prop_estadocivil,
                    p.prop_dni,
                    p.prop_tipo
                    FROM 
                    sc_titulopropiedad.td_certificado_propietario cpr INNER JOIN
                    sc_titulopropiedad.tb_propietario p on cpr.prop_id = p.prop_id INNER JOIN
                    sc_titulopropiedad.tb_certificado c on cpr.cert_id = c.cert_id 
                    WHERE c.est = 1 AND c.cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_propietario_x_id_titulo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    p.prop_id,
                    p.prop_nombre,
                    p.prop_apep,
                    p.prop_apem,
                    p.prop_estadocivil,
                    p.prop_dni,
                    p.prop_tipo
                    FROM 
                    sc_titulopropiedad.td_certificado_propietario cpr INNER JOIN
                    sc_titulopropiedad.tb_propietario p on cpr.prop_id = p.prop_id INNER JOIN
                    sc_titulopropiedad.tb_certificado c on cpr.cert_id = c.cert_id INNER JOIN
					sc_titulopropiedad.tb_titulo t on c.cert_id = t.cert_id 
                    WHERE t.est = 1 AND t.titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
    }