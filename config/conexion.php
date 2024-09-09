<?php 
    /* Inicializando la sesion del usuario */
    session_start();
    /* Iniciamos clase Conextar */
    class Conectar{
        protected $dbh;

        /* Funcion protegida de la cadena de conexion */
        public function Conexion(){
        
            // Parámetros de conexión
            $host = 'localhost';
            $dbname = 'db_titulospropiedad';
            $username = 'postgres';
            $password = '4550151445';
            
            try {
                // Crear una conexión PDO
                $conectar = $this->dbh = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password); 
                return $conectar;
                // Aquí puedes ejecutar consultas, insertar datos, etc.
                
            } catch (PDOException $e) {
                // Manejar errores de conexión
                print "Error de conexión: " . $e->getMessage() . "<br>"; 
                die();
            }
            return $conn;
            
        }
        /* Para impedir tener problemas con las ñ o tildes */
        public function set_names(){
            
            return $this->dbh->query("SET NAMES 'utf8'");
        }

        /* Ruta principal del proyecto */
        public static function ruta(){
            return "http://localhost/PERSONAL_TituloPropiedad/";
        }
    }
    
?>