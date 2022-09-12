
<html>

    <head>

        <title>Agenda Belenes</title>

        <link rel="icon" type="image/x-icon" href="X.ico" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="es" />

    </head>

    <body>

        <div>


            <?php
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

                session_start();

                date_default_timezone_set("America/Mexico_City");
                
                require ("../Model/classOperation.php");

               /*if (empty($request->search)) {
                    $request->search =  false;
                }
                if (empty($request->reporte)) {
                    $request->reporte =  false;
                }
                */if (empty($_SESSION)) {
                      if(isset($request->report)){
                                require ("../View/reporte.php");
                                exit;
                            }
                             else if (isset($request->search)) {

                                require ("../View/search.php");
                                exit;
                            }
                             else if (isset($request->today)) {

                                require ("../View/today.php");
                                exit;
                            }
                            
                    //header("location: ../". LOGIN_INDEX ."");
                }/*
                else {*/

                    $server = $_SERVER["PHP_SELF"];
                         if(!isset($_SESSION["permission"]))
                            {
                                echo "Por seguridad tu sesion ha caducado <br> para poder continuar con el registro de eventos por favor vuelve a iniciar sesion
                                <a href='login.php'>aqui</a>";

                                 exit();
                            }
                        if ($_SESSION["permission"] == 1 or $_SESSION["permission"] == 0 ) {

                            if (isset($request->insert)) {

                                require ("../View/insert.php");
                            }
                            else if (isset($_POST["add"])) {

                                require ("../View/add.php");
                            }
                            else if (isset($_POST["show"])) {

                                require ("../View/show.php");
                            }
                            else if (isset($request->modify)) {

                                require ("../View/modify.php");
                            }
                            else if (isset($request->modify_clases)) {

                                require ("../View/modify_clases.php");
                            }

                            else if (isset($request->today)) {

                                require ("../View/today.php");
                            }
                           
                            else if(isset($request->report)){
                                require ("../View/reporte.php");
                            }
                            else if (isset($request->search)) {

                                require ("../View/search.php");
                            }
                            else if (isset($request->clases)) {

                                require ("../View/insert_aulas.php");
                            }
                            else if (isset($_POST["delete"])) {

                                require ("../View/delete.php");
                            }
                           

                        }
                        else {

                            if (isset($_POST["search"])) {

                                require ("../View/search.php");
                            }
                            else if (isset($_POST["show"])) {

                                require ("../View/show.php");
                            }
                            else {

                                header("location: ../". MAIN_INDEX ."");
                            }

                        }


                    #echo "<p><a href='../'><button type='button' value='regresar'>Regresar</button></a></p>";

                //}


            ?>


        </div>

    </body>

</html>
