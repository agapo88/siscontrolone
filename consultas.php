<?php 
session_start();

$_SESSION['idUser'] = 1;

$data = json_decode( file_get_contents("php://input") );

require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
require_once 'class/areas.bodega.class.php';
require_once 'class/consultas.class.php';
require_once 'class/compras.class.php';
require_once 'class/donante.class.php';
require_once 'class/donaciones.class.php';
require_once 'class/familia.class.php';
require_once 'class/producto.class.php';
require_once 'class/proveedor.class.php';
require_once 'class/reportes.class.php';

$datos    = array();
$conexion = new Conexion();

switch ( $data->accion ) {

	case 'inicio':
		$consulta = new Consultas( $conexion );
		//$datos = $consulta->consultarTipo();
		echo json_encode( $datos );
		
		break;

	case 1:
		$reportes = new Reporte( $conexion );
		$reportes->generarInserts();
		break;

	case 'consultarMunicipio':
		$consulta = new Consultas( $conexion );
		$datos['lstMunicipios'] = $consulta->consultarMunicipios( $data->idDepartamento );
		echo json_encode( $datos );
		
		break;

	/*** PROVEEDORES ***/
	case 'inicioProveedor':
		$producto  = new Producto( $conexion );
		$datos['lstProductos']   = $producto->catalogoProductos();

		echo json_encode( $datos );
		break;

	case 'consultarProveedores':		// CONSULTAR LISTA DE PROVEEDORES
		$proveedor = new Proveedor( $conexion );
		$datos['lstProveedores'] = $proveedor->cargarListaProveedores();

		echo json_encode( $datos );
		break;

	case 'guardarProveedor':		// GUARDAR PROVEEDOR
		$proveedor = new Proveedor( $conexion );
		$datos = $proveedor->registrarProveedor( $data->datos->nombre, $data->datos->telefono, $data->datos->email );
		echo json_encode( $datos );
		break;

	/*** COMPRAS ***/
	case 'inicioCompras':
		$donacion  = new Donacion( $conexion );
		$producto  = new Producto( $conexion );
		$proveedor = new Proveedor( $conexion );

		$datos['lstMontos']      = $donacion->cargarMontosFondo();
		$datos['lstProductos']   = $producto->catalogoProductos();
		$datos['lstProveedores'] = $proveedor->consultarProveedores();
		echo json_encode( $datos );
		break;

	case 'guardarCompras':
		$compra = new Compra( $conexion );
		$datos = $compra->guardarCompras();
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

	case 'verDonacionesFamilia':
		$ayudaFamilia = new Reporte(  $conexion );
		$idFamilia = $data->idFamilia;
		$datos['lstAyudasFam'] = $ayudaFamilia->verDonacionesFamilia( $idFamilia );

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
		$datos['lstAreas']         = $consulta->consultarAreas();
		$datos['lstParentesco']    = $consulta->consultarParentescos();
		$datos['lstGeneros']       = $consulta->consultarGeneros();
		$datos['lstDepartamentos'] = $consulta->consultarDepartamentos();

		echo json_encode( $datos );
		break;

	case 'consultarFamilias':
		$familia = new Familia( $conexion );
		$datos['lstFamiliasB'] = $familia->consultarFamilias();

		echo json_encode( $datos );
		break;

	case 'verHistorialEconomico':
		$familia = new Familia( $conexion );
		$datos['lstHistorialFamilia'] = $familia->verHistorialEconomico( $data->idFamilia );

		echo json_encode( $datos );
		break;

	case 'guardarFamilia':
		//var_dump( $data );
		$familia = new Familia( $conexion );
		$datos   = $familia->guardarFamilia();

		echo json_encode( $datos );
		break;

	case 'verMiembrosFamilia':
		$familia = new Familia( $conexion );
		$datos   = $familia->verMiembrosFamilia( $data->idFamilia );

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