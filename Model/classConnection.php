         
<?php
                  #Universidad de Guadalajara
                  #Conexion con la clase Operation
                  #Ultima modificacion : 27/06/2018 
                  #Por: Jose Eduardo Mendez Ortiz

#require ("config.php");

    class Connection
    {

        private $connection;

        protected function __construct() { ; }
        protected function __destruct()  { $connection = null; }


        public static function set_connection() {

            try {

                $connection = new PDO("mysql:host=".HOST."; dbname=".DB_NAME."; charset=".DB_CHARSET."", USERNAME, PASSWORD);

                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $connection;

            }
            catch (PDOException $e) {

                echo "
                    <div class='container'>
                    <div class='row'>
                    <div class='col-12'></div>
                    <div class='col-12 text-center alert alert-danger'>
                        Se produjo un error al intentar abrir la conexión.<br /><br />
                        Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: " . $e->getCode() .".
                    </div>
                    <div class='col-12'></div>
                    </div>
                    </div>
                ";
               

                echo "
                    <div class='container'>
                    <div class='row'>
                    <div class='col-12'></div>
                    <div class='col-12'>
                        
                    </div>
                    <div class='col-12'></div>
                    </div>
                    </div>
                ";

                exit;
            }

        }


    }

?>
