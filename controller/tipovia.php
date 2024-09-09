<?php
    /* LLamando a cadena de conexion */
    require_once("../config/conexion.php");
    /* LLamando a la clase */
    require_once("../models/Tipovia.php");
    /* Inicializando Clase */
    $tipovia = new Tipovia();


 switch($_GET["op"]){

    case "combo":
        $datos=$tipovia->get_tipovia();
        if(is_array($datos)==true and count($datos)>0){
            $html= " <option label='Seleccione'></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['tivi_id']."'>".$row['tivi_descripcion']."</option>";
            }
            echo $html;
        }
        break;
        
}
?>
