<?php

session_start();
include "../Model/classOperation.php";
include "../Model/config.php";
$operation = new Operation();
$full_date="2018-07-16T05:00:00.000Z";

$conexion = new mysqli("localhost", "root", "", "agenda_belenes");
for($i=1 ; $i < 22; $i++)
{

	if($i < 10)
	{	
		$sql = "INSERT INTO `espacios` (`ID`, `centro_univ`, `modulo`, `espacio`, `color`) VALUES (NULL, 'La Normal', 'F4', 'F4 0$i', '8159a4')";
		$conexion->query($sql);
		if ($conexion->connect_error) 
		{
			    die("Connection failed: " . $conn->connect_error);
			} 
	}
	else
	{
		$sql = "INSERT INTO `espacios` (`ID`, `centro_univ`, `modulo`, `espacio`, `color`) VALUES (NULL, 'La Normal', 'F4', 'F4 $i', '8159a4')";
		$conexion->query($sql);
	}

}

?>