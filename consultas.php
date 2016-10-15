<?php 
session_start();

$_SESSION['idUser'] = 1;

$data = json_decode( file_get_contents("php://input") );

require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
require_once 'class/consultas.class.php';
require_once 'class/donante.class.php';

$datos    = array();
$conexion = new Conexion();

switch ( $data->accion ) {

	case 'inicio':
		$consulta = new Consultas( $conexion );

		//$datos = $consulta->consultarTipo();
		echo json_encode( $datos );

		break;

	/***** DONANTES *****/
	case 'cargaDataFamilia':
		$consulta = new Consultas( $conexion );

		$datos['lstAreas']      = $consulta->consultarAreas();
		$datos['lstParentesco'] = $consulta->consultarParentescos();
		$datos['lstGeneros'] = $consulta->consultarGeneros();
		

		echo json_encode( $datos );
		break;

	/***** DONANTES *****/

	case 'cargarCatDonantes':
		$consulta = new Consultas( $conexion );

		$datos['lstTipoEntidad'] = $consulta->consultarTipoEntidad();

		echo json_encode( $datos );

		break;

	case 'guardarDonador':		// GUARDAR DONADOR	
		$donante = new Donante( $conexion );

		$datos = $donante->guardarDonador( $data->datos->nombre, $data->datos->telefono, $data->datos->email, $data->datos->idTipoEntidad, $data->fechaIngreso);

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