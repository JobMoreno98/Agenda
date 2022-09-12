
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

                require ("../Model/classOperation.php");


                session_cache_limiter("private"); # Evitar la pantalla de "Documento expirado" cuando se envía el formulario y luego se presiona "Atrás" en el navegador.

                session_start();


                if (empty($_SESSION)) {

                    header("location: ../". LOGIN_INDEX ."");
                }
                else {

                    $server = $_SERVER["PHP_SELF"];

                    echo "
                        <div>
                            <div>".$_SESSION["name"]."</div>
                            <div><a href='../".LOGOUT_INDEX."'>Cerrar sesión</a></div>
                        </div>
                    ";


                        if ($_SESSION["permission"] == 1) {

                            if (isset($_POST["insert"])) {

                                require ("../View/insert.php");
                            }
                            else if (isset($_POST["add"])) {

                                require ("../View/add.php");
                            }
                            else if (isset($_POST["show"])) {

                                require ("../View/show.php");
                            }
                            else if (isset($_POST["search"])) {

                                require ("../View/search.php");
                            }
                            else if (isset($_POST["modify"])) {

                                require ("../View/modify.php");
                            }
                            else if (isset($_POST["delete"])) {

                                require ("../View/delete.php");
                            }
                            else {

                                header("location: ../". MAIN_INDEX ."");
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


                    echo "<p><a href='../'><button type='button' value='regresar'>Regresar</button></a></p>";

                }


            ?>


        </div>

    </body>

</html>
