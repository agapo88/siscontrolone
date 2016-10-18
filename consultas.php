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
require_once 'class/areas.bodega.class.php';
require_once 'class/donaciones.class.php';


$datos    = array();
$conexion = new Conexion();

switch ( $data->accion ) {

	case 'inicio':
		$consulta = new Consultas( $conexion );
		//$datos = $consulta->consultarTipo();
		echo json_encode( $datos );
		
		break;

	/*** DONACIONES ***/
	case 'infoDonacion':
		$donador   = new Donador( $conexion );
		$producto  = new Producto( $conexion );
		$datos['lstDonadores']   = $donador->consultarDonadores();
		$datos['lstProductos']   = $producto->catalogoProductos();
		echo json_encode( $datos );
		break;

	case 'guardarFondoComun':
		$donacion = new Donacion( $conexion );

		$datos = $donacion->guardarFondoComun( $data->datos->esAnonimo, $data->datos->idDonador, $data->datos->cantidad, $data->datos->idMoneda, $data->fechaDonacion);
		echo json_encode( $datos );
		break;

	case 'guardarDonacionProducto':
		$donacion = new Donacion( $conexion );

		$datos = $donacion->guardarDonacionProducto( $data->datos );
		echo json_encode( $datos );
		break;

	case 'consultarFondoComun':
		$donacion = new Donacion( $conexion );

		$datos['lstFondoComun'] = $donacion->consultarFondoComun( $data->filtro );
		echo json_encode( $datos );

		break;


	/*** AREAS DE BODEGA ***/
	case 'cargarSeccionBodega':
		$area = new Area( $conexion );
		$datos['lstSeccionBodega'] = $area->consultarSeccionB();
		echo json_encode( $datos );
		break;


	/*** PRODUCTOS ****/
	case 'categoriaProductos':
		$producto = new Producto( $conexion );
		$datos['catProductos'] = $producto->catalogoProductos();
		echo json_encode( $datos );
		break;

	case 'cargarTiposProducto':
		$producto = new Producto( $conexion );
		$datos['lstTiposProducto'] = $producto->consultarTipoProducto();
		echo json_encode( $datos );
		break;

	case 'guardarProducto':
		$prod = $data->datos;
		$producto = new Producto( $conexion );
		$datos = $producto->guardarProducto( $prod->producto, $prod->perecedero, $prod->idTipoProducto, $prod->idSeccionBodega, $prod->cantidadMinima, $prod->cantidadMaxima, $prod->observacion );
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


	/***** FAMILIA *****/
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
		$donador = new Donador( $conexion );

		$datos = $donador->actualizarDonador( $data->datos->idDonador, $data->datos->nombre, $data->datos->telefono, $data->datos->email, $data->datos->idTipoEntidad, $data->fechaIngreso);

		echo json_encode( $datos );
	
		break;

	case 'guardarDonador':		// GUARDAR DONADOR	
		$donador = new Donador( $conexion );

		$datos = $donador->guardarDonador( $data->datos->nombre, $data->datos->telefono, $data->datos->email, $data->datos->idTipoEntidad, $data->fechaIngreso);

		echo json_encode( $datos );
	
		break;

	case 'cargarDonantes':		// CONSULTAR LISTA DE DONANTES
		$donador = new Donador( $conexion );

		$datos['lstEntidades'] = $donador->consultarDonantes( $data->filtro );

		echo json_encode( $datos );
		break;

}

$conexion->close();

?>