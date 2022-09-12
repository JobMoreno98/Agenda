
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

    $array_records_types = $operation->retrieve_from_table("tipo", EVENT_TYPES);
    $array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, $_SESSION["university_center"], NULL);

    if (count($array_records_types) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 8973.
            </div>
        ";
        #echo "<p>An error occurred while trying to search for the records for field \"Tipo\" inside insert form.</p>";
    }
    else if (count($array_records_spaces) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 77223.
            </div>
        ";

        #echo "<p>An error occurred while trying to search for the records for field \"Espacio\" inside insert form.</p>";
    }


    echo "
        <h1>REGISTRAR</h1>

        <form action='$server' method='POST'>

            <p><input type='hidden' name='insert' required readonly /></p>

            <div>
                <p>
                    <label for='id_titulo'>Título</label>
                    <input type='text' id='id_titulo' name='titulo' required autofocus minlength='' maxlength='' />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_tipo'>Tipo</label>
                    <select id='id_tipo' name='tipo'>
                        <option value='Seleccionar' name='tipo' selected>Seleccionar</option>
                    ";

                        foreach ($array_records_types as $record) {

                            $tipo = $record->tipo;

                                echo "<option value='$tipo' name='$tipo'>$tipo</option>";
                        }

                    echo "
                    </select>
                </p>
            </div>

            <div>
                <p>
                    <label for='id_dependencia'>Dependencia</label>
                    <input type='text' id='id_dependencia' name='dependencia' required minlength='' maxlength='' />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_organizador'>Organizador</label>
                    <input type='text' id='id_organizador' name='organizador' required minlength='' maxlength='' />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_tel_organizador'>Tel. Organizador</label>
                    <input type='text' id='id_tel_organizador' name='tel_organizador' required minlength='".MIN_PHONE_LENGTH."' maxlength='".MAX_PHONE_LENGTH."' placeholder='Extensión/Celular' />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_responsable'>Responsable</label>
                    <input type='text' id='id_responsable' name='responsable' required minlength='' maxlength='' />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_tel_responsable'>Tel. Responsable</label>
                    <input type='text' id='id_tel_responsable' name='tel_responsable' required minlength='".MIN_PHONE_LENGTH."' maxlength='".MAX_PHONE_LENGTH."' placeholder='Extensión/Celular' />
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

                    <label for='id_hora_inicial'>Hora inicial</label>
                    <input type='time' id='id_hora_inicial' name='hora_inicial' required />

                    <label for='id_hora_final'>Hora final</label>
                    <input type='time' id='id_hora_final' name='hora_final' required />
                </p>
            </div>

            <div>
                <p>
                    <label for='id_notas_cta'>Notas CTA</label>
                    <textarea type='text' id='id_notas_cta' name='notas_cta' maxlength='' rows='' cols='' placeholder='Notas para CTA.'></textarea>
                </p>
            </div>

            <div>
                <p>
                    <label for='id_notas_sg'>Notas SG</label>
                    <textarea type='text' id='id_notas_sg' name='notas_sg' maxlength='' rows='' cols='' placeholder='Notas para Servicios generales.'></textarea>
                </p>
            </div>

            <div>
                <p>
                    <input type='submit' name='insertar_registo' value='Registrar' />
                    <input type='reset' float-right' name='limpiar' value='Limpiar' />
                </p>
            </div>

        </form>
    ";


    if (isset($_POST["insertar_registo"])) {

        $titulo          = $_POST["titulo"];
        $tipo            = $_POST["tipo"];
        $dependencia     = $_POST["dependencia"];
        $organizador     = $_POST["organizador"];
        $tel_organizador = $_POST["tel_organizador"];
        $responsable     = $_POST["responsable"];
        $tel_responsable = $_POST["tel_responsable"];
        $notas_cta       = $_POST["notas_cta"];
        $notas_sg        = $_POST["notas_sg"];
        $registrado_por  = $_SESSION["name"];

        $espacio      = $_POST["espacio"];
        $fecha        = $_POST["fecha"];
        $hora_inicial = $_POST["hora_inicial"];
        $hora_final   = $_POST["hora_final"];


        if (ctype_space($titulo) || ctype_space($tipo) || ctype_space($dependencia) || ctype_space($organizador) || ctype_space($tel_organizador) ||
            ctype_space($responsable) || ctype_space($tel_responsable) || ctype_space($notas_cta) || ctype_space($notas_sg)) {

            echo "<div>Alguno(s) de los campos no contiene(n) información válida.</div>";
        }
        else if (ctype_space($espacio) || ctype_space($fecha) || ctype_space($hora_inicial) || ctype_space($hora_final)) {

            echo "<div>Alguno(s) de los campos no contiene(n) información válida.</div>";
        }
        else if (! ctype_digit($tel_organizador)) {

            echo "<div>El teléfono del organizador no es válido.";
        }
        else if (! ctype_digit($tel_responsable)) {

            echo "<div>El teléfono del responsable no es válido.";
        }
        else if ($tipo == "Seleccionar") {

            echo "<div>Ningún tipo de evento fue seleccionado.</div>";
        }
        else if ($espacio == "Seleccionar") {

            echo "<div>Ningún espacio para el evento fue seleccionado.</div>";
        }
        else {

            $titulo      = mb_convert_case($titulo, MB_CASE_TITLE);
            $organizador = mb_convert_case($organizador, MB_CASE_TITLE);
            $responsable = mb_convert_case($responsable, MB_CASE_TITLE);
            $notas_cta   = ucfirst($notas_cta);
            $notas_sg    = ucfirst($notas_sg);

            $operation = new Operation();

            $bool_result = $operation->insert_into_events($titulo, $tipo, $dependencia, $organizador, $tel_organizador, $responsable, $tel_responsable, $notas_cta, $notas_sg, $registrado_por);

            if ($bool_result) {

                $ID = $operation->getLastInsertID();

                $bool_result = $operation->insert_into_sessions($ID, $espacio, $fecha, $hora_inicial, $hora_final);

                if ($bool_result) {

                    echo "<div>El evento #ID ha sido registrado correctamente.</div>";

                    /*echo "
                        <script type='text/javascript'>
                            noBackButton();
                        </script>"
                    ;*/
                    # Falta "noRefresh()"

                }
                else {

                    echo "<div>No fue posible registrar el evento.</div>";
                }

            }
            else {

                echo "<div>No fue posible registrar la información del evento.</div>";
            }

        }

    }

?>
