<?php
    class Home extends Conectar{
        public function get_resumen_certificado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        cert_nomtipourb nombrepoblacion,
                        SUM(CASE WHEN c.est = 1 THEN 1 ELSE 0 END) AS registrados,
                        SUM(CASE WHEN c.cert_estimp = 1 THEN 1 ELSE 0 END) AS pendientes,
                        SUM(CASE WHEN c.cert_estimp = 0 THEN 1 ELSE 0 END) AS descargados
                  FROM 
                        sc_titulopropiedad.tb_certificado c
                  GROUP BY 
                        cert_nomtipourb;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }