<?php 
session_start();

$_SESSION['idUser'] = 1;

$data = json_decode( file_get_contents("php://input") );

require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
require_once 'class/consultas.class.php';
require_once 'class/donante.class.php';
require_once 'class/producto.class.php';
require_once 'class/proveedor.class.php';

$datos    = array();
$conexion = new Conexion();

switch ( $data->accion ) {

	case 'inicio':
		$consulta = new Consultas( $conexion );
		//$datos = $consulta->consultarTipo();
		echo json_encode( $datos );
		
		break;

	case 'infoProducto':
		// 5840  1430
		break;

	/*** PRODUCTOS ****/
	case 'cargarProductos':
		$producto = new Producto( $conexion );
		$datos['catProductos'] = $producto->catalogoProductos();
		echo json_encode( $datos );
		break;

	case 'consultarProductos':
		$producto = new Producto( $conexion );
		$datos['lstProductos'] = $producto->consultarProductos( $data->filtro );
		echo json_encode( $datos );
		break;

	case 'cargarProveedores':
		$proveedor = new Proveedor( $conexion );
		$datos['lstProveedores'] = $proveedor->consultarProveedores();
		echo json_encode( $datos );	
		break;


	/***** DONANTES *****/
	case 'cargaDataFamilia':
		$consulta = new Consultas( $conexion );
		$datos['lstAreas']      = $consulta->consultarAreas();
		$datos['lstParentesco'] = $consulta->consultarParentescos();
		$datos['lstGeneros']    = $consulta->consultarGeneros();
		echo json_encode( $datos );
		break;

	/***** DONANTES *****/

	case 'cargarCatDonantes':
		$consulta = new Consultas( $conexion );

		$datos['lstTipoEntidad'] = $consulta->consultarTipoEntidad();

		echo json_encode( $datos );

		break;

	case 'actualizarDonador':		// ACTUALIZAR DONADOR	
		$donante = new Donante( $conexion );

		$datos = $donante->actualizarDonador( $data->datos->idDonador, $data->datos->nombre, $data->datos->telefono, $data->datos->email, $data->datos->idTipoEntidad, $data->fechaIngreso);

		echo json_encode( $datos );
	
		break;

	case 'guardarDonador':		// GUARDAR DONADOR	
		$donante = new Donante( $conexion );

		$datos = $donante->guardarDonador( $data->datos->nombre, $data->datos->telefono, $data->datos->email, $data->datos->idTipoEntidad, $data->fechaIngreso);

		echo json_encode( $datos );
	
		break;

	case 'cargarDonantes':		// CONSULTAR LISTA DE DONANTES
		$donante = new Donante( $conexion );

		$datos['lstEntidades'] = $donante->consultarDonantes( $data->filtro );

		echo json_encode( $datos );
		break;

}

$conexion->close();

?>