
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

        public function register_user($nombre, $codigo, $contrasenia, $area, $sede, $permiso) {

            $this->SQL_sentence = "INSERT INTO ".USERS." VALUES (:nombre, :codigo, :contrasenia, :permisos, :area, :sede)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":nombre"     , $nombre);
                $this->stmt->bindValue(":codigo"     , $codigo);
                $this->stmt->bindValue(":contrasenia", $contrasenia);
                $this->stmt->bindValue(":permisos"   , $permiso);
                $this->stmt->bindValue(":area"       , $area);
                $this->stmt->bindValue(":sede"       , $sede);
               

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

                    Operation::$error_message = "Ya existe un usuario de código $codigo";
                    Operation::print_error_message($e);
                }
                else {

                    #Operation::$error_message = "An error occurred while trying to register the user";
                    Operation::$error_message = "Se produjo un error al intentar registrar al usuario";
                    Operation::print_error_message($e, "Yes");
                }
            }
        }

        #***************************************************************************************************#

        public function get_users() {

            $this->SQL_sentence = "SELECT nombre, codigo, area, centro_univ FROM ".USERS." WHERE permisos = 0";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

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

        public function delete_user($codigo) {

            $this->SQL_sentence = "DELETE FROM ".USERS." WHERE codigo = :codigo";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":codigo", $codigo);

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

                #Operation::$error_message = "An error occurred while trying to delete the user";
                Operation::$error_message = "Se produjo un error al intentar eliminar al usuario";
                Operation::print_error_message($e);
            }
        }

        #***************************************************************************************************#

        #, $empieza="",$termina, $lugar, $dia
        public function retrieve_from_table($attribute, $table, $titulo="", $centro_univ="", $id_evento="", $empieza="",$termina, $lugar, $dia)
         {

            # PDO Statements can't accept a table name or column name as parameter for a later binding.
            if ($attribute == "*") {
                $this->SQL_sentence = "SELECT * FROM ".$table."";
            }
            if($attribute == "personal")
            {
                $this->SQL_sentence = "SELECT * FROM ".$table." WHERE activo = 1";
            }
            if ($attribute == "tipo") {

                $this->SQL_sentence = "SELECT tipo FROM ".$table."";
            }
            else if ($attribute == "dependencia") {

                $this->SQL_sentence = "SELECT dependencia FROM ".$table."";
            }
            else if ($attribute == "espacio") {
                if($centro_univ != "Ambas")
                {
                    $this->SQL_sentence = "SELECT espacio FROM ".$table." WHERE centro_univ = :centro_univ";
                }
                else
                {
                    $this->SQL_sentence = "SELECT espacio, centro_univ FROM ".$table." ";
                }
            }
            else if ($attribute == "ID") {

                $this->SQL_sentence = "SELECT ID FROM ".$table." WHERE titulo = :titulo";
            }
            else if ($attribute == "IDC") {

                $this->SQL_sentence = "SELECT ID_actividad FROM ".$table." WHERE ID = :titulo";
            }
            else if ($attribute == "id_evento") {

                $this->SQL_sentence = "SELECT ID FROM ".$table." WHERE ID = :ID_actividad";
            }
             else if ($attribute == "show") {

                $this->SQL_sentence = "SELECT eventos.`ID`, `titulo` AS title, `tipo`, `dependencia`, `organizador`, `tel_organizador`, `notas_cta`, `notas_sg`, `registrado_por`,IFNULL(espacios.`centro_univ`,'Belenes') AS centro_univ, sesiones.`espacio`,`personal`.`nombre` AS 'personal',sesiones.`ID` AS 'id_sesion',CONCAT('#',IFNULL(`color`,'8159a4')) AS 'backgroundColor', CONCAT('#',IFNULL(`color`,'8159A4')) AS 'borderColor', CONCAT(`fecha`,'T', `hora_inicial`) AS 'start', CONCAT(`fecha`,'T', `hora_final`) AS 'end', `eventos`.`registrado_por`, 0 AS 'view' FROM `eventos` INNER JOIN `sesiones` ON `eventos`.`ID` = `sesiones`.`ID_actividad` LEFT JOIN `personal` ON `personal`.`id` = `sesiones`.`id_persona` LEFT JOIN `espacios` ON `sesiones`.`espacio` = `espacios`.`espacio` WHERE `tipo_actividad` ='Evento'";
            }

            else if($attribute == "clases")
            {

                $this->SQL_sentence = "SELECT eventos.`ID`, `titulo` AS title, `tipo`, `dependencia`, `organizador`, `tel_organizador`, `notas_cta`, `notas_sg`, `registrado_por`,'Clases' AS 'centro_univ', sesiones.`espacio`,sesiones.`ID` AS 'id_sesion',CONCAT('#',IFNULL(`color`,'8159a4')) AS 'backgroundColor', CONCAT('#',IFNULL(`color`,'8159A4')) AS 'borderColor', CONCAT(`fecha`,'T', `hora_inicial`) AS 'start', CONCAT(`fecha`,'T', `hora_final`) AS 'end', `eventos`.`registrado_por`, 0 AS 'view' FROM `eventos` INNER JOIN `sesiones` ON `eventos`.`ID` = `sesiones`.`ID_actividad` LEFT JOIN `espacios` ON `sesiones`.`espacio` = `espacios`.`espacio` WHERE `tipo_actividad` ='Clase'";

            }

            else if ($attribute == "ocupado")
            {
                
                $this->SQL_sentence = "SELECT COUNT(hora_inicial) AS ocupado FROM ".$table." WHERE hora_final > :empieza AND hora_inicial < :termina AND fecha= :dia AND espacio =  :lugar";

            }
                

            else if ($attribute == "todayEvents")
            {
                
                $this->SQL_sentence = "SELECT * FROM ".SESSIONS." WHERE fecha = :dia";

            }
            else if ($attribute == "act")
            {
                
                $this->SQL_sentence = "SELECT COUNT(hora_inicial) AS ocupado FROM ".$table." WHERE hora_final > :empieza AND hora_inicial < :termina AND fecha= :dia AND espacio =  :lugar AND ID_actividad != :id_evento";

            }

            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                if ($centro_univ != "") {

                    $this->stmt->bindValue(":centro_univ", $centro_univ);
                }

                if ($attribute == "ID") {

                    $this->stmt->bindValue(":titulo", $titulo);
                }
                if ($attribute == "IDC") {

                    $this->stmt->bindValue(":titulo", $titulo);
                }
                else if ($attribute == "id_evento") {

                    $this->stmt->bindValue(":id_evento", $id_evento);
                }
                else if ($attribute == "ocupado") {

                   
                   $this->stmt->bindValue(":empieza",$empieza);
                   $this->stmt->bindValue(":termina",$termina);
                   $this->stmt->bindValue(":lugar",$lugar);
                   $this->stmt->bindValue(":dia",$dia);
                   
                }
               else if ($attribute == "act") {
      
                   $this->stmt->bindValue(":empieza",$empieza);
                   $this->stmt->bindValue(":termina",$termina);
                   $this->stmt->bindValue(":lugar",$lugar);
                   $this->stmt->bindValue(":dia",$dia);
                   $this->stmt->bindValue(":id_evento", $id_evento);
                }
                else if ($attribute == "todayEvents") {
      
                   $this->stmt->bindValue(":dia",$dia);
                   
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
                                      notas_cta, notas_sg, registrado_por)
                                        VALUES
                                    (:titulo, :tipo, :dependencia, :organizador, :tel_organizador,
                                    :notas_cta, :notas_sg, :registrado_por)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":titulo"          , $titulo);
                $this->stmt->bindValue(":tipo"            , $tipo);
                $this->stmt->bindValue(":dependencia"     , $dependencia);
                $this->stmt->bindValue(":organizador"     , $organizador);
                $this->stmt->bindValue(":tel_organizador" , $tel_organizador);
                #$this->stmt->bindValue(":responsable"     , $responsable);
                #$this->stmt->bindValue(":tel_responsable" , $tel_responsable);
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

        public function insert_into_clases($titulo, $nrc, $nombre, $profesor,$registrado_por) {

            $this->SQL_sentence = "INSERT INTO ".CLASSES."
                                    (`nrc`, `nombre`, `profesor`, `registrado_por`) VALUES (:nrc,:titulo,:profesor,:registrado_por)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":titulo"          , $titulo);
                $this->stmt->bindValue(":nrc"             , $nrc);
                $this->stmt->bindValue(":profesor"        , $profesor);
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

        public function insert_into_sessions($id_evento,$act, $espacio, $fecha, $hora_inicial, $hora_final) {

            $this->SQL_sentence = "INSERT INTO ".SESSIONS."
                                    (ID_actividad,tipo_actividad, espacio, fecha, hora_inicial, hora_final)
                                        VALUES
                                    (:id_evento,:actividad, :espacio, :fecha, :hora_inicial, :hora_final)";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_evento"   , $id_evento);
                $this->stmt->bindValue(":espacio"     , $espacio);
                $this->stmt->bindValue(":fecha"       , $fecha);
                $this->stmt->bindValue(":hora_inicial", $hora_inicial);
                $this->stmt->bindValue(":hora_final"  , $hora_final);
                $this->stmt->bindValue(":actividad"   , $act);

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
        #************************************************************************************************

        public function insert_into_personal($id_even, $id_persona)
        {

            $this->SQL_sentence = "UPDATE ".SESSIONS." SET id_persona = :id_persona WHERE ID = :id_evento";

            try
            {
                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_persona", $id_persona);
                $this->stmt->bindValue(":id_evento", $id_even);

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }

            catch (PDOException $e)
            {
                Operation::$error_message = "Se produjo un error al intentar registrar la sesión del evento";
                Operation::print_error_message($e);
            }

            

        }

        #***************************************************************************************************#
        public function update_personal($id_persona, $status)
        {
            $this->SQL_sentence = "UPDATE `personal` SET `activo` = :status WHERE `personal`.`id` =  :id_persona ";
            

            try
            {
                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_persona", $id_persona);
                $this->stmt->bindValue(":status",$status);
            
                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return true;
                }
                else {

                    return false;
                }

            }

            catch (PDOException $e)
            {
                Operation::$error_message = "Se produjo un error al intentar registrar la sesión del evento";
                Operation::print_error_message($e);
            }
        } 
        #***************************************************************************************************#

        public function modify_eventos($id,$titulo, $tipo, $dependencia, $organizador, $tel_organizador, $responsable, $tel_responsable, $notas_cta, $notas_sg) {

            $this->SQL_sentence = "UPDATE ".EVENTS."
                                                SET
                                                    titulo = :titulo, tipo = :tipo, dependencia = :dependencia,
                                                    organizador = :organizador, tel_organizador = :tel_organizador,
                                                    notas_cta = :notas_cta, notas_sg = :notas_sg
                                                    WHERE ID = :id_orig";

           
            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_orig"         , $id);
                $this->stmt->bindValue(":titulo"         , $titulo);
                $this->stmt->bindValue(":tipo"           , $tipo);
                $this->stmt->bindValue(":dependencia"    , $dependencia);
                $this->stmt->bindValue(":organizador"    , $organizador);
                $this->stmt->bindValue(":tel_organizador", $tel_organizador);
                #$this->stmt->bindValue(":responsable"    , $responsable);
                #$this->stmt->bindValue(":tel_responsable", $tel_responsable);
                $this->stmt->bindValue(":notas_cta"      , $notas_cta);
                $this->stmt->bindValue(":notas_sg"       , $notas_sg);

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

public function modify_sesiones($id, $espacio, $fecha, $hora_inicial, $hora_final) {

            $this->SQL_sentence = "UPDATE ".SESSIONS."
                                                SET
                                                    espacio = :espacio, fecha = :fecha, 
                                                    hora_inicial = :hora_inicial, hora_final = :hora_final
                                                    WHERE ID = :id_orig";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_orig"         , $id);
                $this->stmt->bindValue(":espacio"         , $espacio);
                $this->stmt->bindValue(":fecha"           , $fecha);
                $this->stmt->bindValue(":hora_inicial"    , $hora_inicial);
                $this->stmt->bindValue(":hora_final"    , $hora_final);
              

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


        public function modify_sesiones_clases($id, $espacio, $hora_inicial, $hora_final) {

            $this->SQL_sentence = "UPDATE ".SESSIONS."
                                                SET
                                                    espacio = :espacio, 
                                                    hora_inicial = :hora_inicial, hora_final = :hora_final
                                                    WHERE ID_actividad = :id_orig";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id_orig"         , $id);
                $this->stmt->bindValue(":espacio"         , $espacio);
                #$this->stmt->bindValue(":fecha"           , $fecha);
                $this->stmt->bindValue(":hora_inicial"    , $hora_inicial);
                $this->stmt->bindValue(":hora_final"    , $hora_final);
              

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


        public function modify_clases($id, $nrc, $nombre, $profesor) {

            $this->SQL_sentence = "UPDATE clases SET nrc=:nrc,nombre=:nombre,profesor=:profesor WHERE ID = :id ";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":id"          , $id);
                $this->stmt->bindValue(":nrc"         , $nrc);
                $this->stmt->bindValue(":nombre"      , $nombre);
                $this->stmt->bindValue(":profesor"    , $profesor);
              

                $this->stmt->execute();

                $this->stmt->closeCursor();

                if ($this->stmt->rowCount() >= 1) {

                    return "hola";
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

        #***************************************************************************************************#*/

        public function delete($ID) {

            $this->SQL_sentence = "DELETE FROM ".SESSIONS." WHERE ID = :ID;";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":ID", $ID);

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

                
                Operation::$error_message = "Se produjo un error al intentar eliminar el registro";
                Operation::print_error_message($e);
            }

        }

        #***************************************************************************************************#
         public function delete_clases($ID) {

            $this->SQL_sentence = "DELETE FROM `clases` WHERE `clases`.`ID` = :ID; ";


            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":ID", $ID);

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

                
                Operation::$error_message = "Se produjo un error al intentar eliminar el registro";
                Operation::print_error_message($e);
            }

        }
        #***************************************************************************************************#

        public function insert_into($table, $column, $value, $id) {

            $this->SQL_sentence = "UPDATE $table SET $column=:value WHERE ID = :id";

            try {

                $this->stmt = $this->connection->prepare($this->SQL_sentence);

                $this->stmt->bindValue(":value", $value);
                $this->stmt->bindValue(":id", $id);

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
      #######################################################################################################

      public function insert_nuevo_personal($nombre)
      {
          $this->SQL_sentence = "INSERT INTO personal (nombre,activo) VALUES (:nombre,1)";

          try{
              $this->stmt = $this->connection->prepare($this->SQL_sentence);

              $this->stmt->bindValue(":nombre", $nombre);

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
    }

?>
