<?PHP 

session_start();
include "../Model/classOperation.php";
include "../Model/config.php";
$postdata = file_get_contents("php://input");
date_default_timezone_set("America/Mexico_City");
 

$request = json_decode($postdata);

        $titulo          = $request->nombre;
     
        $organizador     = $request->profesor;
        
        $responsable     = "No aplica";
        $tel_responsable = "0000000";
        
        $registrado_por  = $_SESSION["name"];
        
        $espacio      = "Aula";
        $aula         = $request->salon;
        $fecha        = $request->fecha;
        $hora_inicial = $request->hora_inicial;
        $hora_final   = $request->hora_final;
        $diaSemana    = $request->weekDay;
        $nrc          = $request->nrc;
        $diaSemana    = get_object_vars($diaSemana);
        #ajuste de hora para este servidor
        $sizeA = count($fecha);
        
        if($sizeA == 0)
        {
          $data["datos"] =  array("info" => "No hay fechas seleccionadas.", "estatus" => 2);
                      header('Content-Type: application/json');
                      echo json_encode($data); 
                exit;
        }
        if($sizeA == 1)
        {
          $sizeA = 0;
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
          for($i = 0; $i < count($hora_inicial); $i++)
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
              if(count($hora_inicial) == 1)
              {
                $i = count($hora_inicial);
              }
          }  
        }

        $start_time_allowed  = date("H:i", strtotime("+2 hours"));+
        $start_day_allowed   = date("d");
        $start_month_allowed = date("m");
        $start_year_allowed  = date("Y");

        if(count($hora_final) > 0)
        {
          for($i = 0; $i < count($hora_inicial); $i++)
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
          if(count($hora_inicial) == 1)
              {

                $i = count($hora_inicial);
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
        
        
        for($i = 0; $i < count($hora_inicial); $i++)
        {   

            if( date('w', strtotime($fecha[$i])) == 0)
            {
                 $data["datos"] =  array("info" => "El registro de actividades el dia domingo no esta permitido. $hora_inicial ", "estatus" => 2);
                 header('Content-Type: application/json');
                 echo json_encode($data); 
                
            }

            else if( (date("H:i",$hora_inicial[$i]) < $start_time_allowed) && ($solo_day[$i][0] == $start_day_allowed)  && ($solo_month[$i][0] == $start_month_allowed) && ($solo_year[$i][0] == $start_year_allowed) )
            {

                 $data["datos"] =  array("info" => "Se necesitan almenos 2 horas de anticipacion.", "estatus" => 2);
                 header('Content-Type: application/json');
                 echo json_encode($data); 
                 exit;
                
            }

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
            
        else if((strlen($aula) <= 3) || (strlen($aula) >= 10)) 
        {
             $data["datos"] =array("info" => "Espacio no valido $subcadenas[0]", "estatus" => 2);
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
            
            for($i = 0; $i < count($hora_inicial); $i++)
            {
                $hora_inicial[$i] =  date('H:i', $hora_inicial[$i]);
                $hora_final[$i] =  date('H:i', $hora_final[$i]);
                $solo_year[$i] = explode("T", $fecha[$i]);
            }  

            $operation = new Operation();
           
            for($i = 0; $i < count($hora_inicial); $i++)
            {
             
                if($espacio == 'Aula')
                  {
                     $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$i],$hora_final[$i],$aula,$solo_year[$i][0]);
                     $bool_ocupado[0]->ocupado = 0;

                  }
                 
                if( $espacio[$i] != 'Aula')
                  {
                     $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$i],$hora_final[$i],$espacio[$i],
                      $solo_year[$i][0]);
                     $ocupado = $bool_ocupado[0]->ocupado;
                  }
            }  

        for($i = 0; $i < 1; $i++)
          {
            if($bool_ocupado[0]->ocupado == 0 && $espacio != 'Aula')
            {   
                      if(!isset($ID))
                        {
                          $bool_result = $operation->insert_into_clases($titulo, $nrc, $titulo, $organizador, $registrado_por);
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

         
            if($bool_ocupado[0]->ocupado == 0 && $espacio == 'Aula')
            {

                      
                       $date_time = strtotime($fecha[0]);
                       $bool_result = $operation->insert_into_clases($titulo, $nrc, $titulo, $organizador, $registrado_por);
                        
                        if ($bool_result) 
                        {

                            $ID = $operation->getLastInsertID();
                            $paro =  strtotime($fecha[1]);
                            $paro = strtotime('+1 day', $paro);
                            $horas_c = 0;

                            do
                            {
                                $fecha_pro = date("Y-m-d H:i:s", $date_time);
                                if(array_key_exists('1', $diaSemana))
                                {
                                  
                                  if( date('w', strtotime($fecha_pro)) == 1 && $diaSemana[1] == 1 )
                                  {
                                      ##################################################################################################
                                      $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$horas_c],$hora_final[$horas_c],$aula,$fecha_pro);
                                      $ocupado = $bool_ocupado[0]->ocupado;
                                      if($ocupado != 0 )
                                        {
                                           $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                                                                    header('Content-Type: application/json');
                                                                    echo json_encode($data);
                                           $operation->delete_clases($ID); 

                                          exit;
                                        }
                                    ####################################################################################################
                                        $bool_result = $operation->insert_into_sessions($ID, "Clase" , $aula, $fecha_pro, $hora_inicial[$horas_c], $hora_final[$horas_c]);
                                        $horas_c = $horas_c + 1;
                                  }
                                }
                                if(array_key_exists('2', $diaSemana))
                                { 
                                    if( date('w', strtotime($fecha_pro)) == 2 && $diaSemana[2] == 1 )
                                    {
                                                                 
                                      $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$horas_c],$hora_final[$horas_c],$aula,$fecha_pro);
                                      $ocupado = $bool_ocupado[0]->ocupado;
                                      if($ocupado != 0 )
                                        {
                                           $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                                                                    header('Content-Type: application/json');
                                                                    echo json_encode($data);
                                           $operation->delete_clases($ID); 

                                          exit;
                                        }
                                    
                                        $bool_result = $operation->insert_into_sessions($ID, "Clase" , $aula, $fecha_pro, $hora_inicial[$horas_c], $hora_final[$horas_c]);
                                        $horas_c = $horas_c + 1;
                                  }
                                }
                                if(array_key_exists('3', $diaSemana))
                                {
                                  if( date('w', strtotime($fecha_pro)) == 3 && $diaSemana[3] == 1 )
                                      {
                                          $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$horas_c],$hora_final[$horas_c],$aula,$fecha_pro);
                                          $ocupado = $bool_ocupado[0]->ocupado;
                                          if($ocupado != 0 )
                                            {
                                               $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                                                                        header('Content-Type: application/json');
                                                                        echo json_encode($data);
                                               $operation->delete_clases($ID); 

                                              exit;
                                            }
                                        
                                            $bool_result = $operation->insert_into_sessions($ID, "Clase" , $aula, $fecha_pro, $hora_inicial[$horas_c], $hora_final[$horas_c]);
                                            $horas_c = $horas_c + 1;
                                    }
                                }
                                
                                if(array_key_exists('4', $diaSemana))
                                  {
                                    if( date('w', strtotime($fecha_pro)) == 4 && $diaSemana[4] == 1 )
                                    {
                                        
                                          $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$horas_c],$hora_final[$horas_c],$aula,$fecha_pro);
                                          $ocupado = $bool_ocupado[0]->ocupado;
                                          if($ocupado != 0 )
                                            {
                                               $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                                                                        header('Content-Type: application/json');
                                                                        echo json_encode($data);
                                               $operation->delete_clases($ID); 

                                              exit;
                                            }
                                        
                                            $bool_result = $operation->insert_into_sessions($ID, "Clase" , $aula, $fecha_pro, $hora_inicial[$horas_c], $hora_final[$horas_c]);
                                            $horas_c = $horas_c + 1;
                                    }
                                  }
                                if(array_key_exists('5', $diaSemana))
                                { 
                                  if( date('w', strtotime($fecha_pro)) == 5 && $diaSemana[5] == 1 )
                                  {
                                                                   $bool_result = $operation->insert_into_sessions($ID, "Clase" , $aula, $fecha_pro, $hora_inicial[$horas_c], $hora_final[$horas_c]);
                                                                    $horas_c = $horas_c + 1;
                                  }
                                }
                                if(array_key_exists('6', $diaSemana))
                                { 
                                  if( date('w', strtotime($fecha_pro)) == 6 && $diaSemana[6] == 1 )
                                  {
                                    
                                          $bool_ocupado = $operation->retrieve_from_table("ocupado",SESSIONS,NULL,NULL,NULL,$hora_inicial[$horas_c],$hora_final[$horas_c],$aula,$fecha_pro);
                                          $ocupado = $bool_ocupado[0]->ocupado;
                                          if($ocupado != 0 )
                                            {
                                               $data["datos"] =  array("info" => "El horario del evento tiene conflictos.", "estatus" => 2);
                                                                        header('Content-Type: application/json');
                                                                        echo json_encode($data);
                                               $operation->delete_clases($ID); 

                                              exit;
                                            }
                                        
                                            $bool_result = $operation->insert_into_sessions($ID, "Clase" , $aula, $fecha_pro, $hora_inicial[$horas_c], $hora_final[$horas_c]);
                                            $horas_c = $horas_c + 1;
                                  }
                                }
                                if( date('w', strtotime($fecha_pro)) == 0)
                                {
                                  $horas_c=0;
                                }
                                
                                $date_time = strtotime('+1 day', $date_time);
                               
                            }while( $paro > $date_time );



                            if ($bool_result) {

                                
                                $bool_ocupado[0]->ocupado = 1;
                                $data["datos"] =  array("info" => "Las clases han sido registradas correctamente.", "estatus" => 1);
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