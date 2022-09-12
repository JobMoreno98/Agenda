
<?php

    require ("classConnection.php");


    class Operation
    {

        private $connection;
        private $SQL_sentence;
        private $stmt;

        private static $error_message = ""; # Variable propia de la clase (static) para almacenar mensajes de error.


        public function __construct()
        {
            $this->connection = Connection::set_connection();
        }

        public function __destruct()
        {
            $this->connection = null;
        }


        #***************************************************************************************************#
        #***************************************************************************************************#

        private static function print_error_message($e, $contact_responsible="No") {

            echo "
                <div class='alert alert-danger text-center'>"
                    . Operation::$error_message . ".";

                    if ($contact_responsible == "Yes") {
                        echo "<br /><br />Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: " . $e->getCode() .".";
                    }

            echo "
                </div>
            ";
            #echo "<br /><br />Contact the responsible for the application and provide him the following code: " . $e->getCode() .".";
            echo "<p>Error (" . $e->getCode() . "): " . $e->getMessage() . ".</p>";

            echo "
                <div>
                    <a href='../".MAIN_INDEX."'><button type='button' class='btn btn-info btn-sm btn-block' value='regresar'>Regresar</button></a>
                </div>
            ";

            exit;
        }

        #***************************************************************************************************#

        public function login($codigo, $contrasenia) {

            $this->SQL_sentence = "SELECT * FROM ". USERS ." WHERE codigo = :codigo";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":codigo", $codigo);

                $this->stmt->execute();

                $user_data = [];

                /*
                 * Aunque el resultado de la sentencia contenga sólo un registro,
                 * es necesario (por ahora) utilizar "while" en lugar de hacer
                 * una igualación directa ($record = $stmt->fetch(PDO::FETCH_OBJ))
                 * para evitar un warning de tipo "Notice: Trying to get property of non-object...".
                 */
                while ($record = $this->stmt->fetch(PDO::FETCH_OBJ)) {

                    # Verificar si la contraseña proporcionada coincide con la almacenada.
                    if (password_verify($contrasenia, $record->contrasenia)) {

                        $user_data[] = $record->nombre;
                        $user_data[] = $record->codigo;
                        $user_data[] = $record->permisos;
                        $user_data[] = $record->area;
                        $user_data[] = $record->centro_univ;
                        break;
                    }
                }

                $this->stmt->closeCursor();

                return $user_data;

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to login";
                Operation::$error_message = "Se produjo un error al intentar iniciar sesión";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        /*public function user_register($nombre, $codigo, $contrasenia, $area) {

            $this->SQL_sentence = "INSERT INTO ". USERS ." VALUES (:nombre, :codigo, :contrasenia, :permisos, :area)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":nombre"     , $nombre);
                $this->stmt->bindValue(":codigo"     , $codigo);
                $this->stmt->bindValue(":contrasenia", $contrasenia);
                $this->stmt->bindValue(":permisos"   , 0);
                $this->stmt->bindValue(":area"       , $area);

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }
            catch (PDOException $e) {

                if ($e->getCode() == "23000") {

                    Operation::$error_message = "Ya existe un usuario con ese código";
                    Operation::print_error_message($e);
                }
                else {

                    #Operation::$error_message = "An error occurred while trying to register the user";
                    Operation::$error_message = "Se produjo un error al intentar registrar al usuario";
                    Operation::print_error_message($e, "Yes");
                }

            }

        }*/

        #***************************************************************************************************#

        public function retrieve_from_table($attribute, $table, $titulo="", $centro_univ="", $id_evento="") {

            # PDO Statements can't accept a table name or column name as parameter for a later binding.
            if ($attribute == "tipo") {

                $this->SQL_sentence = "SELECT tipo FROM ".$table."";
            }
            else if ($attribute == "espacio") {

                $this->SQL_sentence = "SELECT espacio FROM ".$table." WHERE centro_univ = :centro_univ";
            }
            else if ($attribute == "ID") {

                $this->SQL_sentence = "SELECT ID FROM ".$table." WHERE titulo = :titulo";
            }
            else if ($attribute == "id_evento") {

                $this->SQL_sentence = "SELECT ID FROM ".$table." WHERE ID = :id_evento";
            }


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                if ($centro_univ != "") {

                    $this->stmt->bindValue(":centro_univ", $centro_univ);
                }

                if ($attribute == "ID") {

                    $this->stmt->bindValue(":titulo", $titulo);
                }
                else if ($attribute == "id_evento") {

                    $this->stmt->bindValue(":id_evento", $id_evento);
                }


                $this->stmt->execute();

                $array_records = $this->stmt->fetchAll(PDO::FETCH_OBJ);

                $this->stmt->closeCursor();

                return $array_records;

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to retrieve the records";
                Operation::$error_message = "Se produjo un error al intentar recuperar los registros";
                Operation::print_error_message($e, "Yes");
            }

        }

        #***************************************************************************************************#

        public function insert_into_events($titulo, $tipo, $dependencia, $organizador, $tel_organizador,
                               $responsable, $tel_responsable, $notas_cta, $notas_sg, $registrado_por) {

            $this->SQL_sentence = "INSERT INTO ".EVENTS."
                                    (titulo, tipo, dependencia, organizador, tel_organizador,
                                     responsable, tel_responsable, notas_cta, notas_sg, registrado_por)
                                        VALUES
                                    (:titulo, :tipo, :dependencia, :organizador, :tel_organizador,
                                     :responsable, :tel_responsable, :notas_cta, :notas_sg, :registrado_por)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":titulo"          , $titulo);
                $this->stmt->bindValue(":tipo"            , $tipo);
                $this->stmt->bindValue(":dependencia"     , $dependencia);
                $this->stmt->bindValue(":organizador"     , $organizador);
                $this->stmt->bindValue(":tel_organizador" , $tel_organizador);
                $this->stmt->bindValue(":responsable"     , $responsable);
                $this->stmt->bindValue(":tel_responsable" , $tel_responsable);
                $this->stmt->bindValue(":notas_cta"       , $notas_cta);
                $this->stmt->bindValue(":notas_sg"        , $notas_sg);
                $this->stmt->bindValue(":registrado_por"  , $registrado_por);

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }
            catch (PDOException $e) {

                Operation::$error_message = "Se produjo un error al intentar registrar la información general del evento";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        public function getLastInsertID() {

            return $this->connection->lastInsertId();
        }

        #***************************************************************************************************#

        public function insert_into_sessions($id_evento, $espacio, $fecha, $hora_inicial, $hora_final) {

            $this->SQL_sentence = "INSERT INTO ".SESSIONS."
                                    (id_evento, espacio, fecha, hora_inicial, hora_final)
                                        VALUES
                                    (:id_evento, :espacio, :fecha, :hora_inicial, :hora_final)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_evento"   , $id_evento);
                $this->stmt->bindValue(":espacio"     , $espacio);
                $this->stmt->bindValue(":fecha"       , $fecha);
                $this->stmt->bindValue(":hora_inicial", $hora_inicial);
                $this->stmt->bindValue(":hora_final"  , $hora_final);

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }
            catch (PDOException $e) {

                Operation::$error_message = "Se produjo un error al intentar registrar la sesión del evento";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#
        /*
        public function count_records($segment) {

            $this->SQL_sentence = "SELECT COUNT(*) AS TOTAL_RECORDS FROM ".RECORDS." WHERE IP LIKE :segment";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":segment", "148.202.$segment.%");

                $this->stmt->execute();

                $total_records = ($this->stmt->fetch(PDO::FETCH_OBJ))->TOTAL_RECORDS;

                $this->stmt->closeCursor();

                return $total_records;

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to search for the records";
                Operation::$error_message = "Se produjo un error al intentar buscar los registros";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        public function show_with_limit($segment, $start, $limit) {

            $this->SQL_sentence = "SELECT * FROM ".RECORDS." WHERE IP LIKE :segment ORDER BY CHAR_LENGTH(IP), IP ASC LIMIT :start, :limit ";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":segment", "148.202.$segment.%");
                $this->stmt->bindValue(":start"  , $start, PDO::PARAM_INT);
                $this->stmt->bindValue(":limit"  , $limit, PDO::PARAM_INT);

                $this->stmt->execute();

                $array_records = $this->stmt->fetchAll(PDO::FETCH_OBJ);

                $this->stmt->closeCursor();

                return $array_records;

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to search for the records";
                Operation::$error_message = "Se produjo un error al intentar buscar los registros";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        public function show_occupied($table, $segment) {

            $this->SQL_sentence = "SELECT IP FROM ".$table." WHERE IP LIKE :segment ORDER BY CHAR_LENGTH(IP), IP ASC";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":segment", "148.202.$segment.%");

                $this->stmt->execute();

                $array_records = $this->stmt->fetchAll(PDO::FETCH_OBJ);

                $this->stmt->closeCursor();

                return $array_records;

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to search for the occupied records";
                Operation::$error_message = "Se produjo un error al intentar buscar los registros ocupados";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        public function search($criteria, $filter="IP") {

            if ($filter == "IP") {

                $this->SQL_sentence = "SELECT * FROM ".RECORDS." WHERE IP = :IP";
            }
            else if ($filter == "MAC") {

                $this->SQL_sentence = "SELECT * FROM ".RECORDS." WHERE MAC = :MAC";
            }
            else if ($filter == "responsable") {

                $this->SQL_sentence = "SELECT * FROM ".RECORDS." WHERE responsable LIKE :responsable";
            }
            else if ($filter == "descripcion") {

                $this->SQL_sentence = "SELECT * FROM ".RECORDS." WHERE descripcion LIKE :descripcion";
            }
            else { exit; } # Jamás se debería entrar en este "else".


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                if ($filter == "IP") {

                    $this->stmt->bindValue(":IP", $criteria);
                }
                else if ($filter == "MAC") {

                    $this->stmt->bindValue(":MAC", $criteria);
                }
                else if ($filter == "responsable") {

                    $this->stmt->bindValue(":responsable", "%$criteria%");
                }
                else if ($filter == "descripcion") {

                    $this->stmt->bindValue(":descripcion", "%$criteria%");
                }
                else { exit; }


                $this->stmt->execute();

                $array_records = $this->stmt->fetchAll(PDO::FETCH_OBJ);

                $this->stmt->closeCursor();

                return $array_records;

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to search for the record(s)";
                Operation::$error_message = "Se produjo un error al intentar buscar los registros";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        public function modify($IP_orig, $IP, $MAC, $no_serie, $dependencia, $responsable, $descripcion) {

            $this->SQL_sentence = "UPDATE ".RECORDS."
                                                SET
                                                    IP = :IP, MAC = :MAC, numero_serie = :no_serie,
                                                    dependencia = :dependencia, responsable = :responsable,
                                                    descripcion = :descripcion
                                                WHERE IP = :IP_orig";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":IP"         , $IP);
                $this->stmt->bindValue(":MAC"        , $MAC);
                $this->stmt->bindValue(":no_serie"   , $no_serie);
                $this->stmt->bindValue(":dependencia", $dependencia);
                $this->stmt->bindValue(":responsable", $responsable);
                $this->stmt->bindValue(":descripcion", $descripcion);
                $this->stmt->bindValue(":IP_orig"    , $IP_orig);

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to modify the record";
                Operation::$error_message = "Se produjo un error al intentar modificar el registro";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#

        public function delete($IP) {

            $this->SQL_sentence = "DELETE FROM ".RECORDS." WHERE IP = :IP";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":IP", $IP);

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }
            catch (PDOException $e) {

                #Operation::$error_message = "An error occurred while trying to delete the record";
                Operation::$error_message = "Se produjo un error al intentar eliminar el registro";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#
        #***************************************************************************************************#

        */
    }

?>
