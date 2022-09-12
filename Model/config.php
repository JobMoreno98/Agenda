
<?php

    # Universidad de Guadalajara CUCSH
    # Fecha de Ultima Modificacion : 26/06/2018 
    # Modifico : Jose Eduardo Mendez 

    # Parámetros de conexión.
    define("HOST"       , "localhost");
    define("USERNAME"   , "agendacsh"); #linea modificada por credenciales localhost original: user
    define("PASSWORD"   , "Ag3nd@_@ct1v1d@d35"); #linea modificada por credenciales localhost original: pass
    define("DB_NAME"    , "agenda_belenes2");
    define("DB_CHARSET" , "utf8");



    # Tablas.
    define("EVENTS"      , "eventos");
    define("SESSIONS"    , "sesiones");
    define("EVENT_TYPES" , "tipos_evento");
    define("SPACES"      , "espacios");
    define("CLASSES"     , "clases");
    define("DEPENDENCIES", "dependencias");
    define("USERS"       , "usuarios");

    # Archivos.
    define("LOGIN_INDEX" , "/AgendaBelenes/index.php");
    define("MAIN_INDEX"  , "index.php");
    #define("MAIN_INDEX"  , "main_index.php");
    define("MANAGE_USERS", "/AgendaBelenes/manage_users.php");
    define("LOGOUT_INDEX", "logout.php");
    define("CONTROLLER"  , "/AgendaBelenes/Controller/controller.php");

    # Longitud de campos.
    define("MIN_NAME_LENGTH"     , 5);
    define("MIN_CODE_LENGTH"     , 7);
    define("MIN_PASS_LENGTH"     , 8);

    define("MIN_TITLE_LENGTH"    , 10);
    define("MIN_ORGANIZER_LENGTH", 5);
    define("MIN_RESPONSIBLE_LENGTH", 5);
    define("MIN_PHONE_LENGTH"    , 5);
    define("MAX_PHONE_LENGTH"    , 10);
    define("MAX_NOTE_LENGTH"     , 255);

    #Formato de Aulas
    define("MIN_CLASSROOM", 1);
    define("MAX_A_CLASSROOM", 16);
    define("MAX_B_CLASSROOM", 1);
    define("MAX_C_CLASSROOM", 20);
    define("MAX_D_CLASSROOM", 19);
    define("MAX_E_CLASSROOM", 18);
    define("MAX_F4_CLASSROOM", 21);


    # Fuerza del cifrado.
    define("FORCE", "15");


    # Show all warnings & errors.
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

?>
