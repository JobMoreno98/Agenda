
<?php

	require ("./Model/config.php");


	# Reanudar la sesión del usuario.
	session_start();

	# Destruir la sesión del usuario.
	session_destroy();

	# Redirigir al usuario a la página de inicio de sesión.
    header("location: ". LOGIN_INDEX ."");

?>
