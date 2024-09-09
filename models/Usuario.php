<?php
    Class Usuario extends Conectar{
        /* Funcion para login de acceso del usuario */
        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usua_correo"];
                $pass = $_POST["usua_pass"];
                if(empty($correo) and empty($pass)){
                    /* En caso esten vacios los campos correo y contraseña, devolver index con el mensaje = 2 */
                    header("Location:".conectar::ruta()."index.php?m=2");
                    exit();
                }else{
                    $sql = "SELECT * FROM sc_titulopropiedad.tb_usuario WHERE usua_correo=? and usua_pass=? and est=1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usua_id"]=$resultado["usua_id"];
                        $_SESSION["usua_nom"]=$resultado["usua_nom"];
                        $_SESSION["usua_apep"]=$resultado["usua_apep"];
                        $_SESSION["usua_correo"]=$resultado["usua_correo"];
                        $_SESSION["usua_rol"]=$resultado["usua_rol"];
                        /* Si todo esta correcto indexar en home */
                        header("Location:".Conectar::ruta()."view/UsuHome/");
                        exit();


                    }else{
                        /* En caso no coincidan el usuario o la contraseña */
                        header("Location:".conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }

        }
         
}

?>