<?php
    class Tipovia extends Conectar{
        public function get_tipovia(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        * 
                    FROM 
                        sc_titulopropiedad.tb_tipo_via 
                    WHERE 
                        tivi_estado = 'A'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        
    }
   