<?PHP 

session_start();
include "../Model/classOperation.php";
include "../Model/config.php";
$postdata = file_get_contents("php://input");
date_default_timezone_set("America/Mexico_City");

$request = json_decode($postdata);
        $titulo          = $request->titulo;
        $sesion_id       = $request->ID;
        $organizador     = $request->organizador;
        
        #$registrado_por  = $_SESSION["name"];
        $edificio     = $request->edificio;
        $n_salon      = $request->numero_salon;
        $salon        = $request->espacio;
        $espacio      = "Aula";
        #$aula        = $request->salon;
        $fecha        = $request->fecha;
        $hora_inicial = $request->hora_inicial;
        $hora_final   = $request->hora_final;
        #$diaSemana   = $request->weekDay;
        $nrc          = $request->tel_organizador;
        #$diaSemana   = get_object_vars($diaSemana);
        #ajuste de hora para este servidor
        
        if(strlen($hora_inicial) == 0 || strlen($hora_final) == 0)
        {
          $data["datos"] =  array("info" => "Hora Inicial o de termino no valida.", "estatus" => 2);
                      header('Content-Type: application/json');
                      echo json_encode($data); 
                exit;
        } 

        $searchString = '?';
        if(strlen($hora_inicial) != 0)
        {
          
              if(strpos($hora_inicial, $searchString) !== false)
              {
                 $data["datos"] =  array("info" => "Alguno(s) inicial de los campos no contiene(n) información válida.", "estatus" => 2);
                        header('Content-Type: application/json');
                        echo json_encode($data); 
                  exit;
              }

              $hora_inicial = strtotime($hora_inicial);
              $hora_inicial = $hora_inicial + 21600;
           
        }
        $subcadenas = explode(" ", $salon);
        $start_time_allowed  = date("H:i", strtotime("+2 hours"));+
        $start_day_allowed   = date("d");
        $start_month_allowed = date("m");
        $start_year_allowed  = date("Y");

        if(strlen($hora_final) > 0)
        {
          
                    if(strpos($hora_final, $searchString) !== false)
                    {
                       $data["datos"] =  array("info" => "Alguno(s) final de los campos no contiene(n) información válida.", "estatus" => 2);
                              header('Content-Type: application/json');
                              echo json_encode($data); 
                        exit;
                    }
                    $hora_final = strtotime($hora_final);
                    $hora_final = $hora_final + 21600;
              
         
        }
        
          

        if (ctype_space($titulo) || ctype_space($organizador) ) {

            
            $data["datos"] =  array("info" => "Alguno(s) de los campos no contiene(n) información válida.", "estatus" => 1);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }

        else if( $hora_inicial == 21600 || $hora_final == 21600 )
        {
             $data["datos"] =  array("info" => "Hora no seleccionada", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data); 
        }

         else if( $hora_final < $hora_inicial )
        {
             $data["datos"] =  array("info" => "Incongruencia en los horarios establecidos.", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data); 
        }
        else if (($subcadenas[0] == "FBA") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_A_CLASSROOM)) /*&& $espacio == 'Aula'*/) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }
      else if (($subcadenas[0] == "FBB") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_C_CLASSROOM)) /*&& $espacio == 'Aula'¨*/) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del". MIN_CLASSROOM ." - ". MAX_B_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }
         else if (($subcadenas[0] == "FBC") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_C_CLASSROOM)) /*&& $espacio == 'Aula'¨*/) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del ". MIN_CLASSROOM ." - ". MAX_C_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "FBD") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_D_CLASSROOM)) /*&& $espacio == 'Aula'*/) {

            #echo "El aula seleccionada no es válida. El módulo A sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".";
             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del". MIN_CLASSROOM ." - ". MAX_D_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "FBE") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_E_CLASSROOM))) {

            #echo "El aula seleccionada no es válida. El módulo A sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".";
             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del". MIN_CLASSROOM ." - ". MAX_E_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);

        }

         else if (($subcadenas[0] == "F") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_F4_CLASSROOM)) /*&& $espacio == 'Aula'*/) 
           {
             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del". MIN_CLASSROOM ." - ". MAX_F4_CLASSROOM .".", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data);
            
            }
        else {

            $titulo      = mb_convert_case($titulo, MB_CASE_TITLE);
            $organizador = mb_convert_case($organizador, MB_CASE_TITLE);
            
           
                $hora_inicial =  date('H:i', $hora_inicial);
                $hora_final =  date('H:i', $hora_final);
                $solo_year = explode("T", $fecha);
            

            $operation = new Operation();
           
             $salon = $edificio." ".$n_salon;
            if($espacio == 'Aula')
            {
                     $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial,$hora_final,$salon,$solo_year[0]);
                     $bool_ocupado[0]->ocupado = 0;

            }
            
      

            if($bool_ocupado[0]->ocupado == 0 && $espacio == 'Aula')
            {

                       $clase_id = $operation->retrieve_from_table("IDC","sesiones",$sesion_id,NULL,NULL,NULL,NULL,NULL,NULL);
                       $date_time = strtotime($fecha[0]);
                       $bool_result = $operation->modify_clases($clase_id[0]->ID_actividad, $nrc, $titulo." ", $organizador);
                        
                        if ($bool_result) 
                        {

                            $ID = $operation->getLastInsertID();
                            $paro =  strtotime($fecha[1]);
                            $paro = strtotime('+1 day', $paro);
                            $horas_c = 0;
                            $fecha_pro = date("Y-m-d H:i:s", $date_time);
                            $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial,$hora_final,$salon,$fecha_pro);
                            #do
                            #{
                               
                               #$date_time = strtotime('+1 day', $date_time);
                            #}while( $paro > $date_time );



                            if ($bool_result) {
                     
                                $operation->modify_sesiones_clases($clase_id[0]->ID_actividad, $salon, $hora_inicial, $hora_final);
                                $bool_ocupado[0]->ocupado = 1;
                                $data["datos"] =  array("info" => "Las clases han sido actualizadas correctamente.", "estatus" => 1);
                                header('Content-Type: application/json');
                                echo json_encode($data); 

                            }
                            else 
                            {
                                $data["datos"] =  array("info" => "No fue posible registrar el evento.", "estatus" => 3);
                                header('Content-Type: application/json');
                                echo json_encode($data); 
                            }

                        }

                        else 
                        {                       
                            $data["datos"] =  array("info" => "No fue posible registrar la información del evento.", "estatus" => 3);
                                header('Content-Type: application/json');
                                echo json_encode($data); 
                        }
                  }   
        } 


?>