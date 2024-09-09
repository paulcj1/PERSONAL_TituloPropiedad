<?php
class Ubigeo extends Conectar
{

    public function llenar_provincia() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                DISTINCT    
                            cod_prov_inei AS provincia_id, 
                            desc_prov_inei AS provincia_descripcion
                FROM 
                        sc_escalafon.tb_ubigeo 
                WHERE 
                        cod_dep_inei = '14'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function llenar_distrito() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT DISTINCT
                            cod_ubigeo_inei AS distrito_id, 
                            desc_ubigeo_inei AS distrito_descripcion
                FROM 
                        sc_escalafon.tb_ubigeo 
              WHERE 
			  			cod_prov_inei = '1401'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}