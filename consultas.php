<?php 

$data = json_decode( file_get_contents("php://input") );

require_once 'class/conexion.class.php';
require_once 'class/consultas.class.php';

$datos    = array();
$conexion = new Conexion();

switch ( $data->accion ) {

	case 'inicio':
		$consulta = new Consultas( $conexion);

		$datos = $consulta->consultarTipo();
		echo json_encode( $datos );

		break;

	case 'cargarDonantes':		// CONSULTAR LISTA DE DONANTES
		$donate = new Donante();
		break;

}

$conexion->close();

?>