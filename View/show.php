<?php

session_start();
include "../Model/classOperation.php";
include "../Model/config.php";
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

    $resquest_data = $_GET['cu'];
    $operation = new Operation();
    //Obtencion de datos registrados de la BD
    if($resquest_data != "Clases")
    {

      $array_records_evento_tipo = $operation->retrieve_from_table("show", EVENTS,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

    }

    if($resquest_data == "Clases")
    {
   
      $array_records_evento_tipo = $operation->retrieve_from_table("clases", EVENTS,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
      //$resquest_data = "Belenes";
    }

    $data = array();
    $tags = array();
    $aux  = array();
   // Se guarda en el arreglo "show"

    $data = $array_records_evento_tipo;

      for($i = 0; $i < sizeof($data); $i++)
        { 
            //modificar para poner el tipo de actividad (eventos o clases recibir el parametro de tipo tambien)
            if($data[$i]->centro_univ == $resquest_data) //Aqui se puede utilizar
             {
                array_push($aux,$data[$i]);
             }

        }

    if($resquest_data == "Clases")
    {
       for($i = 0; $i < sizeof($aux); $i++)
        { 
            //modificar para poner el tipo de actividad (eventos o clases recibir el parametro de tipo tambien)
            $color = explode(" ",$aux[$i]->espacio);
            if($color[0] == 'FBA') //Aqui se puede utilizar
             {
                $aux[$i]->color = '#e87f00';
                $aux[$i]->backgroundColor = '#e87f00';
                $aux[$i]->borderColor = '#e87f00';
             }
             if($color[0] == 'FBB') //Aqui se puede utilizar
             {
                $aux[$i]->color = '#158706';
                $aux[$i]->backgroundColor = '#158706';
                $aux[$i]->borderColor = '#158706';
             }
             if($color[0] == 'FBC') //Aqui se puede utilizar
             {
                $aux[$i]->color = '#870505';
                $aux[$i]->backgroundColor = '#870505';
                $aux[$i]->borderColor = '#870505';
             }

             if($color[0] == 'FBD') //Aqui se puede utilizar
             {
                $aux[$i]->color = '#051287';
                $aux[$i]->backgroundColor = '#051287';
                $aux[$i]->borderColor = '#051287';
             }


        }
    }
    
    $rewriteKeys = array('titulo' => 'tittle', 'fecha' => 'start');

    header('Content-Type: application/json');
    echo json_encode($aux);




?>