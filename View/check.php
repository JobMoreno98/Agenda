<?PHP 

session_start();
include "../Model/classOperation.php";
include "../Model/config.php";
$postdata = file_get_contents("php://input");
date_default_timezone_set("America/Mexico_City");
 

$request = json_decode($postdata);

        $titulo          = $request->titulo;
        $tipo            = $request->tipo;
        $dependencia     = $request->dependencia;
        $organizador     = $request->organizador;
        $tel_organizador = $request->tel_organizador;
        $responsable     = "No aplica";#$request->responsable;
        $tel_responsable = "0000000";#$request->tel_responsable;
        $notas_cta       = $request->notas_cta;
        $notas_sg        = $request->notas_sg;
        $registrado_por  = $_SESSION["name"];
        $actividad    = $request->actividad;
        $espacio      = $request->espacios;
        $aula         = $request->aula;
        $fecha        = $request->fecha;
        $hora_inicial = $request->hora_inicial;
        $hora_final   = $request->hora_final;

        #ajuste de hora para este servidor
        $sizeA = count($fecha);

        if($sizeA == 0)
        {
          $data["datos"] =  array("info" => "No hay fechas seleccionadas.", "estatus" => 2);
                      header('Content-Type: application/json');
                      echo json_encode($data); 
                exit;
        }

        if(count($hora_inicial) == 0 || count($hora_final) == 0)
        {
          $data["datos"] =  array("info" => "Hora Inicial o de termino no valida.", "estatus" => 2);
                      header('Content-Type: application/json');
                      echo json_encode($data); 
                exit;
        } 

        $searchString = '?';
        if(count($hora_inicial) != 0)
        {
          for($i = 0; $i < $sizeA; $i++)
          {

              if(strpos($hora_inicial[$i], $searchString) !== false)
              {
                 $data["datos"] =  array("info" => "Alguno(s) inicial de los campos no contiene(n) información válida.", "estatus" => 2);
                        header('Content-Type: application/json');
                        echo json_encode($data); 
                  exit;
              }
              $hora_inicial[$i] = strtotime($hora_inicial[$i]);
              $hora_inicial[$i] = $hora_inicial[$i] + 21600;
          }  
        }

        $start_time_allowed  = date("H:i", strtotime("+2 hours"));
        $start_time_allowed_b  = date("H:i", strtotime("+30 minutes"));
        $start_day_allowed   = date("d");
        $start_day_allowed_b   = date("d" ,strtotime('+1 day'));
        $start_month_allowed = date("m");
        $start_year_allowed  = date("Y");

        if(count($hora_final) != 0)
        {
          for($i = 0; $i < $sizeA; $i++)
                {
                    if(strpos($hora_final[$i], $searchString) !== false)
                    {
                       $data["datos"] =  array("info" => "Alguno(s) final de los campos no contiene(n) información válida.", "estatus" => 2);
                              header('Content-Type: application/json');
                              echo json_encode($data); 
                        exit;
                    }
                    $hora_final[$i] = strtotime($hora_final[$i]);
                    $hora_final[$i] = $hora_final[$i] + 21600;
                }  
        }

        
        for($i = 0; $i < $sizeA; $i++)
        {
            $solo_day1   = explode("-",$fecha[$i]);
            $solo_month1 = explode("-",$fecha[$i]);
            $solo_year1  = explode("-",$fecha[$i]);
            
            $solo_year[$i] = explode("T", $solo_day1[0]);

            $solo_month[$i] = explode("T", $solo_day1[1]);

            $solo_day[$i] = explode("T", $solo_day1[2]);
        
        }  
       
        if(strlen($aula) == 0)
        {
            $aula = 'A 00';
        }
       
           $subcadenas = explode(" ", $aula);

        
        
        
        
        for($i = 0; $i < $sizeA; $i++)
        {      

          $subcadenas = explode(" ", $espacio[$i]);
            if (empty($espacio) || $espacio[$i] == "Seleccionar" ) 
            {
                $data["datos"] =  array("info" => "Ningún espacio para el evento fue seleccionado.", "estatus" => 2);
                        header('Content-Type: application/json');
                        echo json_encode($data); 
                exit;
            }
            
            else if (strpos($espacio[$i], '?') !== false) 
            {

                $data["datos"] =  array("info" => "Alguno(s) espacio de los campos no contiene(n) información válida.", "estatus" => 2);
                      header('Content-Type: application/json');
                      echo json_encode($data); 
                exit;
                
            
            }

            else if( date('w', strtotime($fecha[$i])) == 0)
            {
                 $data["datos"] =  array("info" => "El registro de actividades el dia domingo no esta permitido. $hora_inicial ", "estatus" => 2);
                 header('Content-Type: application/json');
                 echo json_encode($data); 
                
            }

            else if( ((date("H:i",$hora_inicial[$i]) < $start_time_allowed) && ($solo_day[$i][0] == $start_day_allowed)  && ($solo_month[$i][0] == $start_month_allowed) && ($solo_year[$i][0] == $start_year_allowed) ) && $_SESSION['university_center'] =='La Normal')
            {
                 $centroU =  $_SESSION['university_center'];
                 $data["datos"] =  array("info" => "Se necesitan almenos 2 horas de anticipacion.", "estatus" => 2);
                 header('Content-Type: application/json');
                 echo json_encode($data); 
                 exit;
                
            }
            else if( (date("H:i",$hora_inicial[$i]) < $start_time_allowed_b) && ($solo_day[$i][0] == $start_day_allowed)  && ($solo_month[$i][0] == $start_month_allowed) && ($solo_year[$i][0] == $start_year_allowed)  && $_SESSION['university_center'] !='La Normal')
            {

                 $data["datos"] =  array("info" => "Se necesitan almenos 30 minutos de anticipacion. ", "estatus" => 2);
                 header('Content-Type: application/json');
                 echo json_encode($data); 
                 exit;
                
            }

        }  

        if (ctype_space($titulo) || ctype_space($tipo) || ctype_space($dependencia) || ctype_space($organizador) || ctype_space($tel_organizador) ||
            ctype_space($responsable) || ctype_space($tel_responsable) || ctype_space($notas_cta) || ctype_space($notas_sg)) {

            
            $data["datos"] =  array("info" => "Alguno(s) de los campos no contiene(n) información válida.", "estatus" => 1);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        else if (! ctype_digit($tel_organizador)) {

            
             $data["datos"] =  array("info" => "El teléfono del organizador no es válido.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        else if (! ctype_digit($tel_responsable)) {
           
            $data["datos"] =  array("info" => "El teléfono del responsable no es válido.", "estatus" => 2);
                    header('Content-Type: application/json');
                    echo json_encode($data); 
        }
        else if ($tipo == "Seleccionar") {

            $data["datos"] =  array("info" => "Ningún tipo de evento fue seleccionado.", "estatus" => 2);
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
         else if( $hora_final == $hora_inicial )
        {
             $data["datos"] =  array("info" => "La hora inicial y final no pueden ser iguales", "estatus" => 2);
             header('Content-Type: application/json');
             echo json_encode($data); 
        }
        else if (($subcadenas[0] == "FBA") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_A_CLASSROOM)) && $aula == 1) {

             $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0].$subcadenas[1]." sólo comprende las aulas ". MIN_CLASSROOM ." - ". MAX_A_CLASSROOM .".", "estatus" => 2);
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
        else if (($subcadenas[0] == "FB4") && (($subcadenas[1] < MIN_CLASSROOM) || ($subcadenas[1] > MAX_FB4_CLASSROOM)) /*&& $espacio == 'Aula'*/) 
        {
                  $data["datos"] =array("info" => "El aula seleccionada no es válida. El módulo ".$subcadenas[0]." sólo comprende las aulas del ". MIN_CLASSROOM ." - ". MAX_FB4_CLASSROOM .".", "estatus" => 2);
                  header('Content-Type: application/json');
                  echo json_encode($data);
                 
        }
            

        else {

            $titulo      = mb_convert_case($titulo, MB_CASE_TITLE);
            $organizador = mb_convert_case($organizador, MB_CASE_TITLE);
            $responsable = mb_convert_case($responsable, MB_CASE_TITLE);
            $notas_cta   = ucfirst($notas_cta);
            $notas_sg    = ucfirst($notas_sg);

            for($i = 0; $i < $sizeA; $i++)
            {
                $hora_inicial[$i] =  date('H:i', $hora_inicial[$i]);
                $hora_final[$i] =  date('H:i', $hora_final[$i]);
                $solo_year[$i] = explode("T", $fecha[$i]);
            }  

            $operation = new Operation();
           
            for($i = 0; $i < $sizeA; $i++)
            {

                if($espacio[$i] == 'Aula')
                  {
                     $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$i],$hora_final[$i],$aula,$solo_year[$i][0]);
                     $ocupado = $bool_ocupado[0]->ocupado;
                  }
                 
                if( $espacio[$i] != 'Aula')
                  {
                     $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$i],$hora_final[$i],$espacio[$i],
                      $solo_year[$i][0]);
                     $ocupado = $bool_ocupado[0]->ocupado;
                  }

                if($bool_ocupado[0]->ocupado  != 0 )
                  {
                      $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                      header('Content-Type: application/json');
                      echo json_encode($data); 

                      exit;
                  }
            }  

        for($i = 0; $i < $sizeA; $i++)
          {
            if($bool_ocupado[0]->ocupado == 0 && $espacio[$i] != 'Aula')
            {   
                      if(!isset($ID))
                        {
                          $bool_result = $operation->insert_into_events($titulo, $tipo, $dependencia, $organizador, $tel_organizador, $responsable, $tel_responsable, $notas_cta, $notas_sg, $registrado_por);
                        }
                       
                        if ($bool_result) 
                        {
                          if(!isset($ID))
                          {
                            $ID = $operation->getLastInsertID();
                          }

                          $bool_result = $operation->insert_into_sessions($ID, $actividad ,$espacio[$i], $fecha[$i], $hora_inicial[$i], $hora_final[$i]);

                            if ($bool_result) 
                            {

                                
                                $bool_ocupado[0]->ocupado = 0;
                                
                               
                                $data["datos"] =  array("info" => "El evento $ID ha sido registrado correctamente. Ya puedes cerrar esta ventana", "estatus" => 1);
                                  
                                if($i == ($sizeA-1))
                                {
                                  header('Content-Type: application/json');
                                  echo json_encode($data); 
                                }
                                

                            }
                            else
                            {
                                $data["datos"] =  array("info" => "No fue posible registrar el evento.", "estatus" => 3);
                                if($i == ($sizeA-1))
                                {
                                  header('Content-Type: application/json');
                                  echo json_encode($data); 
                                }
                            }

                        }
                        else 
                        {

                            
                            $data["datos"] =  array("info" => "No fue posible registrar la información del evento.", "estatus" => 3);
                                if($i == ($sizeA-1))
                                {
                                  header('Content-Type: application/json');
                                  echo json_encode($data); 
                                }
                        }
            }

         
            if($bool_ocupado[0]->ocupado == 0 && $espacio[$i] == 'Aula')
            {
                        $bool_result = $operation->insert_into_events($titulo, $tipo, $dependencia, $organizador, $tel_organizador, $responsable, $tel_responsable, $notas_cta, $notas_sg, $registrado_por);
                       
                        if ($bool_result) 
                        {

                            $ID = $operation->getLastInsertID();

                            $bool_result = $operation->insert_into_sessions($ID, $aula, $fecha[$i], $hora_inicial[$i], $hora_final[$i]);

                            if ($bool_result) {

                                
                                $bool_ocupado[0]->ocupado = 1;
                                $data["datos"] =  array("info" => "El evento $ID ha sido registrado correctamente $aula.", "estatus" => 1);
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
        } 


?>