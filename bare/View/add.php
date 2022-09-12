
<script type="text/javascript">

    function noBackButton() {

        window.location.hash="no-back-button";
        window.location.hash="Again-no-back-button";

        window.onhashchange = function() {
            window.location.hash="no-back-button";
        }

    }

</script>


<?php

    require_once ("../Model/config.php");

    if (empty($server)) {

        header("location: ". INDEX ."");
    }


    $operation = new Operation();

    $array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, $_SESSION["university_center"]);

    if (count($array_records_spaces) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 77223.
            </div>
        ";

        #echo "<p>An error occurred while trying to search for the records for field \"Espacio\" inside insert form.</p>";
    }


    echo "
        <h1>REGISTRAR NUEVA SESIÓN</h1>

        <form action='$server' method='POST'>

            <p><input type='hidden' name='add' required readonly /></p>

            <div>
                <p>
                    <label for='id_evento'>ID Evento</label>
                    <input type='number' id='id_evento' name='id_evento' required autofocus min='' max='' />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_espacio'>Espacio</label>
                    <select id='id_espacio' name='espacio' onchange=\"if(this.value=='Aula') document.getElementById('aula').disabled=false; else if(this.value!='Aula') document.getElementById('aula').disabled=true;\"'>
                        <option value='Seleccionar' name='espacio' selected>Seleccionar</option>
                    ";

                        foreach ($array_records_spaces as $record) {

                            $espacio = $record->espacio;

                            echo "<option value='$espacio' name='$espacio'>$espacio</option>";
                        }

                    echo "
                            <option value='Aula'>Aula</option>
                    </select>
                            <input type='text' id='aula' name='espacio' placeholder='A 00' disabled>
                </p>
            </div>

            <div>
                <p>
                    <label for='id_fecha'>Fecha</label>
                    <input type='date' id='id_fecha' name='fecha' required />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_hora_inicial'>Hora inicial</label>
                    <input type='time' id='id_hora_inicial' name='hora_inicial' required />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_hora_final'>Hora final</label>
                    <input type='time' id='id_hora_final' name='hora_final' required />
                </p>
            </div>

            <div>
                <p>
                    <input type='submit' name='agregar_sesion' value='Registrar' />
                    <input type='reset' float-right' name='limpiar' value='Limpiar' />
                </p>
            </div>

        </form>
    ";


    if (isset($_POST["agregar_sesion"])) {

        $id_evento    = $_POST["id_evento"];
        $espacio      = $_POST["espacio"];
        $fecha        = $_POST["fecha"];
        $hora_inicial = $_POST["hora_inicial"];
        $hora_final   = $_POST["hora_final"];


        if (ctype_space($id_evento) || ctype_space($espacio) || ctype_space($fecha) || ctype_space($hora_inicial) || ctype_space($hora_final)) {

            echo "<div>Alguno(s) de los campos no contiene(n) información válida.</div>";
        }
        else if ($espacio == "Seleccionar") {

            echo "<div>Ningún espacio para el evento fue seleccionado.</div>";
        }
        else {

            $operation = new Operation();

            $array_records_events = $operation->retrieve_from_table("id_evento", EVENTS, NULL, NULL, $id_evento);

            if (count($array_records_events) <= 0) {

                echo "
                    <div>
                        Primero registre la información general del evento $id_evento antes de intentar agregar sesiones.
                    </div>
                ";
            }
            else {

                $bool_result = $operation->insert_into_sessions($id_evento, $espacio, $fecha, $hora_inicial, $hora_final);

                if ($bool_result) {

                    echo "<div>La nueva sesión para el evento ha sido agregada correctamente.</div>";

                    /*echo "
                        <script type='text/javascript'>
                            noBackButton();
                        </script>"
                    ;*/
                    # Falta "noRefresh()"

                }
                else {

                    echo "<div>No fue posible registrar la sesión para el evento.</div>";
                }

            }

        }

    }

?>
