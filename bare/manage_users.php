
<!DOCTYPE html>

<html>

	<head>

		<title>Administrar usuarios</title>

        <link rel="icon" type="image/x-icon" href="X.ico" />

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="es" />

	</head>

	<body>


		<?php

			require ("./Model/classOperation.php");

            session_start();


            if ($_SESSION["permission"] == 1) {

                $server = $_SERVER["PHP_SELF"];

                if (isset($_POST["register_user"])) {

                    echo "
                        <div>

                            <h1>Registrar usuario</h1>

                            <form action='$server' method='POST'>

                                <p><input type='hidden' name='register_user' required readonly /></p>

                                <p>
                                    <label for='id_nombre'>Nombre:</label>
                                    <input type='text' id='id_nombre' name='nombre' minlength='".MIN_NAME_LENGTH."' placeholder='Nombre' required autofocus /></p>
                                </p>
                                <p>
                                    <label for='id_codigo'>Código:</label>
                                    <input type='text' id='id_codigo' name='codigo' minlength='".MIN_CODE_LENGTH."' placeholder='#######' required /></p>
                                </p>
                                <p>
                                    <label for='id_contraseña'>Contraseña:</label>
                                    <input type='password' id='id_contraseña' name='contrasenia' minlength='".MIN_PASS_LENGTH."' placeholder='**********' required /></p>
                                </p>
                                <p>
                                    <label for='id_contraseña'>Confirmar contraseña:</label>
                                    <input type='password' id='id_contraseña2' name='contrasenia2' minlength='".MIN_PASS_LENGTH."' placeholder='**********' required /></p>
                                </p>
                                <p>
                                    <label for='id_area'>Área:</label>
                                    <select id='id_area' name='area'>
                                        <option name='seleccionar' value='seleccionar' selected>Seleccionar</option>
                                        <option name='cta' value='CTA'>CTA</option>
                                        <option name='sg' value='Serv. Generales'>Serv. Generales</option>
                                    </select>
                                </p>
                                <p>
                                    <label for='id_area'>Centro Universitario:</label>
                                    <select id='id_cu' name='cu'>
                                    <option name='seleccionar' value='seleccionar' selected>Seleccionar</option>
                                       <option name='la_normal' value='La Normal'>La Normal</option>
                                       <option name='belenes' value='Belenes'>Belenes</option>
                                    </select>
                                </p>

                                <p>
                                    <input type='submit' name='registrar_usuario' value='Registrar' />
                                    <input type='reset' name='limpiar' value='Limpiar' />
                                </p>

                            </form>

                        </div>
                    ";


                    if (isset($_POST["registrar_usuario"])) {

                        $nombre       = $_POST["nombre"];
                        $codigo       = $_POST["codigo"];
                        $contrasenia  = $_POST["contrasenia"];
                        $contrasenia2 = $_POST["contrasenia2"];
                        $permisos     = 0;
                        $area         = $_POST["area"];
                        $cu           = $_POST["cu"]; # "cu" = Centro universitario.


                        if ((ctype_space($nombre)) || ($nombre == "") || ($codigo == "") || ($contrasenia == "") || ($contrasenia2 == "") || ($area == "") || ($cu == "")) {

                            echo "<p>Alguno(s) de los campos no contiene(n) información válida.</p>";
                        }
                        else if (strlen($nombre) < MIN_NAME_LENGTH) {

                            echo "<p>El nombre deber contener al menos ".MIN_NAME_LENGTH." caracteres.</p>";
                        }
                        else if (strlen($codigo) < MIN_CODE_LENGTH) {

                            echo "<p>El código deber ser de ".MIN_CODE_LENGTH." dígitos.</p>";
                        }
                        else if (! is_numeric($codigo)) {

                            echo "<p>El código debe ser numérico.</p>";
                        }
                        else if ((strlen($contrasenia) < MIN_PASS_LENGTH) || (strlen($contrasenia2) < MIN_PASS_LENGTH)) {

                            echo "<p>La contraseña deber contener al menos ".MIN_PASS_LENGTH." caracteres.</p>";
                        }
                        else if ((! in_array($area, ["CTA", "Serv. Generales"]))) {

                            echo "<p>El área no es válida.</p>";
                        }
                        else if ((! in_array($cu, ["La Normal", "Belenes"]))) {

                            echo "<p>El centro universitario no es válido.</p>";
                        }
                        else {

                            $nombre = mb_convert_case($nombre, MB_CASE_TITLE);

                            # Crear el hash de "contrasenia" con el algoritmo por default.
                            $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
                            #$contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT, array("cost"=>FORCE));


                            $operation = new Operation();

                            $bool_result = $operation->user_register($nombre, $codigo, $contrasenia, $permisos, $area, $cu);

                            if ($bool_result) {

                                echo "<p>El usuario $nombre ($codigo) ha sido registrado correctamente.</p>";
                            }
                            else {

                                echo "<p>No fue posible registrar al usuario.</p>";
                            }

                        }

                    }

                }
                else if (isset($_POST["delete_user"])) {

                    echo "<h1>¡Próximamente!</h1>";
                }
                else {

                    header("location: ". MAIN_INDEX ."");
                }

            }
            else {

                header("location: ". MAIN_INDEX ."");
            }

            echo "<p><a href='./".MAIN_INDEX."'><button type='button' value='regresar'>Regresar</button></a></p>";

		?>


	</body>

</html>
