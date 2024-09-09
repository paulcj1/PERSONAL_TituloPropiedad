<?php
    class Tipourbanizacion extends Conectar{
        public function get_tipourbanizacion(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        * 
                        FROM 
                            sc_titulopropiedad.tb_tipo_urbanizacion
                        WHERE
                            tiur_estado = 'A'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        
    }
   