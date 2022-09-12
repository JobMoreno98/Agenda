
<?php

	require ("config.php");


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
                #An error occurred while trying to open connection.<br /><br />
                #Contact the responsible for the application and provide him the following code: " . $e->getCode() .".
                #echo "<p>Error (" . $e->getCode() . "): " . $e->getMessage() . ".</p>";

                echo "
                    <div class='container'>
                    <div class='row'>
                    <div class='col-12'></div>
                    <div class='col-12'>
                        <p><a href='".MAIN_INDEX."'><button type='button' class='btn btn-info btn-sm btn-block' value='regresar'>Regresar</button></a></p>
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
