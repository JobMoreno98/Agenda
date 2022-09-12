
<!DOCTYPE html>

<html>

	<head>

		<title>Agenda Belenes</title>

		<link rel="icon" type="image/x-icon" href="X.ico" />

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="es" />

	</head>

	<!--<body style="background-color:#848484; color:#FFFFFF">-->
	<body>


		<?php

			require ("./Model/config.php");

			session_start();


			if (! isset($_SESSION["name"])) {

				header("location: ". LOGIN_INDEX ."");
			}
			else {

				if ($_SESSION["permission"] == 1) {

					$role = "Rectoría";
				}
				else {

					$role = $_SESSION["area"];
				}


				echo "
                	<div>
                		<div>".$_SESSION["name"]." - $role</div>
                		<div><a href='".LOGOUT_INDEX."'>Cerrar sesión</a></div>
                	</div>


					<div>
	                    <div><h1>Agenda de eventos</h1></div>
					</div>
				";
				#<img src='./Documents/Images/CTA.png' /><br />


				if ($_SESSION["permission"] == 1) {

					echo "
						<form action='".CONTROLLER."' method='POST'>

							<p><input type='submit' name='insert' value='Registrar' /></p>
							<p><input type='submit' name='add'    value='Agregar sesiones' /></p>
							<p><input type='submit' name='show'   value='Mostrar'   /></p>
							<p><input type='submit' name='search' value='Buscar'    /></p>
							<p><input type='submit' name='modify' value='Modificar' /></p>
							<p><input type='submit' name='delete' value='Eliminar'  /></p>

						</form>

						<br />

						<div>

						</div>
					";

					/*<div>
						<form action='".MANAGE_USERS."' method='POST'>

							<div>
								<p>
									<input type='submit' name='register_user' value='Registrar usuario' />
								</p>
							</div>

						</form>
					</div>*/
				}
				else {

					echo "
						<form action='".CONTROLLER."' method='POST'>

							<p><input type='submit' name='search' value='Buscar' /></p>

						</form>

						<p>Por ahora sólo pueden \"Buscar\".</p>
					";

				}


				if ($_SESSION["permission"] == 1) {

					echo "
						<div>
				        	<h5>PHP/MySQL Programming by <a href=''>Edgar Orozco</a>.</h5>
				        </div>
					";

				}

			}

		?>


	</body>

</html>
