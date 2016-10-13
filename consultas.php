<?php 

$data = json_decode( file_get_contents("php://input") );

require_once 'class/conexion.class.php';
require_once 'class/consultas.class.php';
require_once 'class/donante.class.php';

$datos    = array();
$conexion = new Conexion();

switch ( $data->accion ) {

	case 'inicio':
		$consulta = new Consultas( $conexion);

		//$datos = $consulta->consultarTipo();
		echo json_encode( $datos );

		break;

	case 'cargarDonantes':		// CONSULTAR LISTA DE DONANTES
		$donante = new Donante( $conexion );

		$datos['lstDonantes'] = $donante->consultarDonantes();

		echo json_encode( $datos );
		break;

}

$conexion->close();

?>