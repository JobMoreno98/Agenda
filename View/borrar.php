<?php
	session_start();
	include "../Model/classOperation.php";
	include "../Model/config.php";
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$id = $request->id;

	$operation = new Operation();
	$bool_result = $operation->delete($id);
	
	if ($bool_result) {

		#$operation->insert_into("sesiones_canceladas", "eliminado_por", $_SESSION["name"], $array[0]->ID); 
		$bool_result = $operation->insert_into("sesiones_canceladas", "eliminado_por", $_SESSION["name"], $id); 

		if ($bool_result) {

			$data["datos"] = array("info" => "Cancelado con exito recuerda llamar a la cordinacion de tecnologias para el aprensizaje y cordinacion de servicios generales, ya puedes cerrar esta ventana", "estatus" => 1);
		    header('Content-Type: application/json');
		    echo json_encode($data);
		}
		else {

			echo "<script>console.log('Error en inserción.')<script>";

		}

	}
	else {

		$data["datos"] =array("info" => "Ocurrio un problema al intentar borrar", "estatus" => 2);
	    header('Content-Type: application/json');
	    echo json_encode($data);
	}

?>