 <?PHP 

session_start();
include "../Model/classOperation.php";
include "../Model/config.php";
$postdata = file_get_contents("php://input");
date_default_timezone_set("America/Mexico_City");
$request = json_decode($postdata);
        
        $event_id        = $request->id;
        $titulo          = $request->titulo;
        $tipo            = $request->tipo;
        $dependencia     = $request->dependencia;
        $organizador     = $request->organizador;
        $tel_organizador = $request->tel_organizador;
        $responsable     = "responsable";
        $tel_responsable = "tel_responsable";
        $notas_cta       = $request->notas_cta;
        $notas_sg        = $request->notas_sg;
        $registrado_por  = $_SESSION["name"];
        $sesi_id      = $request->idsesion;
        $espacio      = $request->espacio;
        $aula         = $request->aula;
        $fecha        = $request->fecha;
        $hora_inicial = $request->hora_inicial;
        $hora_final   = $request->hora_final;
        #ajuste de hora para este servidor
        $hora_inicial = strtotime($hora_inicial);
        $hora_inicial = $hora_inicial + 21600;

        //$hora_inicial =  date('c', $hora_inicial);
        $start_time_allowed = date("H:i", strtotime("+2 hours"));
        $start_day_allowed = date("d");
        $start_month_allowed = date("m");
        $start_year_allowed = date("Y");
        $hora_final = strtotime($hora_final);//-25200;
        $hora_final = $hora_final + 21600;
        $solo_day = explode("-",$fecha);
        $solo_month = explode("-",$fecha);
        $solo_year = explode("-",$fecha);
        
        $solo_year = explode("T", $solo_day[0]);

        $solo_month = explode("T", $solo_day[1]);

        $solo_day = explode("T", $solo_day[2]);
        
        if(strlen($aula) == 0)
        {
            $aula = 'A 00';
        }
        if($aula == 1)
        {
          $subcadenas = explode(" ", $espacio);
        }
        else{
          $subcadenas = explode(" ", $aula);
        }
        
        if (ctype_space($titulo) || ctype_space($tipo) || ctype_space($dependencia) || ctype_space($organizador) || ctype_space($tel_organizador) || ctype_space($notas_cta) || ctype_space($notas_sg)) {

            #echo "<div>Alguno(s) de los campos no contiene(n) información válida.</div>";
            $data["datos"] =  array("info" => "Alguno(s) de los campos no contiene(n) información válida.", "estatus" => 1);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        else if (ctype_space($espacio) || ctype_space($fecha) || ctype_space($hora_inicial) || ctype_space($hora_final)) {

             $data["datos"] =  array("info" => "Alguno(s) de los campos no contiene(n) información válida.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        else if (! ctype_digit($tel_organizador)) {

            #echo "<div>El teléfono del organizador no es válido.";
             $data["datos"] =  array("info" => "El teléfono del organizador no es válido.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        /*else if (! ctype_digit($tel_responsable)) {

           # echo "<div>El teléfono del responsable no es válido.";
            
            $data["datos"] =  array("info" => "El teléfono del responsable no es válido.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }*/
        else if ($tipo == "Seleccionar") {

            #echo "<div>Ningún tipo de evento fue seleccionado.</div>";
            $data["datos"] =  array("info" => "Ningún tipo de evento fue seleccionado.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        else if ($espacio == "Seleccionar") {

            #echo "<div>Ningún espacio para el evento fue seleccionado.</div>";
            $data["datos"] =  array("info" => "Ningún espacio para el evento fue seleccionado.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }

        else if( date('w', strtotime($fecha)+ 5 * 60 * 60) + 21600 == 0)
        {
             
             $data["datos"] =  array("info" => "El registro de actividades el dia domingo no esta permitido.", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data); 
        }

         else if( $hora_final < $hora_inicial )
        {
             $data["datos"] =  array("info" => "Incongruencia en los horarios establecidos.", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data); 
        }
            

          else if( (date("H:i",$hora_inicial) < $start_time_allowed) && ($solo_day[0] == $start_day_allowed)  && ($solo_month[0] == $start_month_allowed) && ($solo_year[0] == $start_year_allowed) )
        {
            
             $data["datos"] =  array("info" => "Se necesitan almenos 2 horas de anticipacion.", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data); 
        }

        else if (($subcadenas[0] == "FBA") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_A_CLASSROOM)) && $aula == 1) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

        else if (($subcadenas[0] == "FBB") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_B_CLASSROOM)) && $aula == 1) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_B_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "FBC") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_C_CLASSROOM)) && $aula == 1) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_C_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "FBD") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_D_CLASSROOM)) && $aula == 1) {

            #echo "El aula seleccionada no es válida. El módulo A sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".";
             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_D_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "FBE") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_E_CLASSROOM)) && $aula == 1) {

            #echo "El aula seleccionada no es válida. El módulo A sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".";
             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_E_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "FBF") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_F4_CLASSROOM)) && $aula == 1) 
           {
             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_F4_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);
            
            }

        else {

            $titulo      = mb_convert_case($titulo, MB_CASE_TITLE);
            $organizador = mb_convert_case($organizador, MB_CASE_TITLE);
            #$responsable = mb_convert_case($responsable, MB_CASE_TITLE);
            $notas_cta   = ucfirst($notas_cta);
            $notas_sg    = ucfirst($notas_sg);
            $hora_inicial =  date('H:i', $hora_inicial);
            $hora_final =  date('H:i', $hora_final);
            
            $solo_year = explode("T", $fecha);

            $operation = new Operation();
            
             if($espacio == 'Aula')
            {
               $bool_ocupado = $operation->retrieve_from_table("act",SESSIONS,NULL,NULL,$event_id,$hora_inicial,$hora_final,$aula,$solo_year[0]);
               $ocupado = $bool_ocupado[0]->ocupado;
            }
           
            if( $espacio != 'Aula')
            {
               $bool_ocupado = $operation->retrieve_from_table("act",SESSIONS,NULL,NULL,$event_id,$hora_inicial,$hora_final,$espacio,$solo_year[0]);
               $ocupado = $bool_ocupado[0]->ocupado;
            }
            if($bool_ocupado[0]->ocupado  != 0 )
                {
                    $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
                }


            if($bool_ocupado[0]->ocupado == 0 && $espacio != 'Aula')
            {
                    

                        $bool_result = $operation->modify_eventos($event_id,$titulo, $tipo, $dependencia, $organizador, $tel_organizador, $responsable, $tel_responsable, $notas_cta, $notas_sg);
                        $bool_result = 1;
                        if ($bool_result) 
                        {

                            $ID = $operation->getLastInsertID();

                            $bool_result = $operation->modify_sesiones($sesi_id, $espacio, $fecha, $hora_inicial, $hora_final);
                            $bool_result = 1;
                            if ($bool_result) {

                                
                                $bool_ocupado[0]->ocupado = 1;
                                $data["datos"] =  array("info" => "El evento ha sido actualizado correctamente. Ya puedes cerrar esta ventana", "estatus" => 1);
                                header('Content-Type: application/json');
                                echo json_encode($data); 

                              
                            }
                            else {

                                
                                $data["datos"] =  array("info" => "No fue posible registrar el evento.", "estatus" => 3);
                                header('Content-Type: application/json');
                                echo json_encode($data); 
                            }

                        }
                        else {

                            
                            $data["datos"] =  array("info" => "No fue posible registrar la información del evento.", "estatus" => 3);
                                header('Content-Type: application/json');
                                echo json_encode($data); 
                        }
            }


            if($bool_ocupado[0]->ocupado == 0 && $espacio == 'Aula')
            {
                        $bool_result = $operation->modify_eventos($event_id,$titulo, $tipo, $dependencia, $organizador, $tel_organizador, $responsable, $tel_responsable, $notas_cta, $notas_sg);
                       $bool_result = 1;
                        if ($bool_result) 
                        {

                            
                            $bool_result = $operation->modify_sesiones($sesi_id, $aula, $fecha, $hora_inicial, $hora_final);
                            $bool_result = 1;
                            if ($bool_result) {

                               
                                $bool_ocupado[0]->ocupado = 1;
                                $data["datos"] =  array("info" => "El evento ha sido registrado correctamente.$sesi_id", "estatus" => 1);
                                header('Content-Type: application/json');
                                echo json_encode($data); 

                            }
                            else {

                                
                                $data["datos"] =  array("info" => "No fue posible registrar el evento.", "estatus" => 3);
                                header('Content-Type: application/json');
                                echo json_encode($data); 
                            }

                        }
                        else {

                            
                            $data["datos"] =  array("info" => "No fue posible registrar la información del evento.", "estatus" => 3);
                                header('Content-Type: application/json');
                                echo json_encode($data); 
                        }
            }
        } 
 


?>