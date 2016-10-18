<?php 
/**
* PRODUCTO
*/
class Producto extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// FUNCION PARA CONSULTAR PRODUCTOS
	function consultarProductos(  $groupBy = 'tipoProducto'){
		$lstProductos = array();

		$sql = "SELECT 
					    idProducto,
					    producto,
					    observacion,
					    esPerecedero,
					    if(esPerecedero = 1, 'Si', 'No') AS perecedero,
					    idSeccionBodega,
					    seccionBodega,
					    idTipoProducto,
					    tipoProducto,
					    cantidadMinima,
					    cantidadMaxima,
					    totalProducto,
					    idUsuario,
					    fechaHora
					FROM
					    vstProductos;";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				
				$iTipoProducto  = -1;
				$iSeccionBodega = -1;
				$iPerecedero    = -1;
				$iProducto      = -1;

				// VER TIPO DE AGRUPACIÓN
				if( $groupBy == 'tipoProducto' ): 		// TIPOPRODUCTO
					foreach ($lstProductos AS $ixtipoProducto => $tipoProducto) {
						if( $tipoProducto['idTipoProducto'] == $row->idTipoProducto ){
							$iTipoProducto = $ixtipoProducto;
							break;
						}
					}

				elseif( $groupBy == 'seccionBodega' ):			// SECCION BODEGA
					foreach ($lstProductos AS $ixSeccionBodega => $seccionBodega) {
						if( $seccionBodega['idSeccionBodega'] == $row->idSeccionBodega ){
							$iSeccionBodega = $ixSeccionBodega;
							break;
						}
					}

				elseif( $groupBy == 'clasificacion' ):			// CLASIFICACION
					foreach ($lstProductos AS $ixPerecedero => $perecedero) {
						if( $perecedero['esPerecedero'] == $row->esPerecedero ){
							$iPerecedero = $ixPerecedero;
							break;
						}
					}

				endif;

				// SI NO EXISTE EL TIPO LO AGREGA
				if( $iTipoProducto == -1 AND $iSeccionBodega == -1 AND $iPerecedero == -1 ){

					if( $groupBy == 'tipoProducto' ):				// TIPOPRODUCTO
						$iTipoProducto = count( $lstProductos );

					elseif( $groupBy == 'seccionBodega' ):			// BODEGA
						$iSeccionBodega = count( $lstProductos );

					elseif( $groupBy == 'clasificacion' ):			// CLASIFICACION
						$iPerecedero = count( $lstProductos );

					endif;

					$lstProductos[] = array(
						'idTipoProducto'  => (int) $row->idTipoProducto,
						'tipoProducto'    => $row->tipoProducto,
						'idSeccionBodega' => (int) $row->idSeccionBodega,
						'seccionBodega'   => $row->seccionBodega,
						'esPerecedero'    => (int) $row->esPerecedero,
						'perecedero'      => strtoupper( $row->perecedero ),
						'lstProductos'    => array(),
						'totalProductos'  => 0,
						'totalStockVacio' => 0,
						'totalAlertas'    => 0,
						'totalStockAlto'  => 0,
					);
				}

				// VERIFICAR QUE VENGAN LOS LOS PRODUCTOS
				foreach ($lstProductos AS $ixTipoProducto => $tipoProducto) {
					foreach ($tipoProducto['lstProductos'] AS $ixProducto => $producto) {
						if( $producto['idProducto'] == $row->idProducto ){
							$iProducto = $ixProducto;
							break;
						}
					}
				}

				// SI NO EXISTE EL DONANTE
				if( $iProducto == -1 ){
					if( $groupBy == 'tipoProducto' ):			// TIPO PRODUCTO
						$ixSolicitud = $iTipoProducto;
					elseif( $groupBy == 'seccionBodega' ):		// SECCION BODEGA
						$ixSolicitud = $iSeccionBodega;
					elseif( $groupBy == 'clasificacion' ):		// CLASIFICACION
						$ixSolicitud = $iPerecedero;
					endif;

					$alertaStock = 0;
					// GENERAR ALERTA STOCK BAJO / ALTO / VACIO
					if( $row->totalProducto < $row->cantidadMinima ):
						$alertaStock = 1;
					elseif( $row->totalProducto <= $row->cantidadMinima + 15 ):
						$alertaStock = 2;
					elseif( $row->totalProducto > $row->cantidadMaxima ):
						$alertaStock = 3;
					endif;

					$lstProductos[ $ixSolicitud ][ 'lstProductos' ][] = array(
						'idProducto'      => $row->idProducto,
						'producto'        => $row->producto,
						'cantidadMinima'  => $row->cantidadMinima,
						'cantidadMaxima'  => $row->cantidadMaxima,
						'observacion'     => $row->observacion,
						'esPerecedero'    => $row->esPerecedero,
						'perecedero'      => $row->perecedero,
						'idSeccionBodega' => $row->idSeccionBodega,
						'ubicacionBodega' => $row->seccionBodega,
						'idTipoProducto'  => $row->idTipoProducto,
						'tipoProducto'    => $row->tipoProducto,
						'totalProducto'   => $row->totalProducto ? $row->totalProducto : 0,
						'alertaStock'	  => $alertaStock
					);
					if( $alertaStock == 1 )
						$lstProductos[ $ixSolicitud ]['totalStockVacio'] ++;
					if( $alertaStock == 2 )
						$lstProductos[ $ixSolicitud ]['totalAlertas'] ++;
					if( $alertaStock == 3 )
						$lstProductos[ $ixSolicitud ]['totalStockAlto'] ++;

					$lstProductos[ $ixSolicitud ]['totalProductos'] ++;

				}

			}
		}

		return $lstProductos;
	}

	// CONSULTAR LISTA DE PRODUCTOS BD
	function catalogoProductos()
	{
		$catProductos = array();
		$sql = "SELECT 
					    idProducto, producto, esPerecedero
					FROM
					    producto";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$catProductos[] = $row;
			}
		}

		return $catProductos;
	}

	function consultarTipoProducto(){
		$lsTiposProducto = array();
		$sql = "SELECT 
					    idTipoProducto, tipoProducto
					FROM
					    tipoproducto;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lsTiposProducto[] = $row;
			}
		}

		return $lsTiposProducto;
	}

	function guardarProducto($producto, $perecedero, $idTipoProducto, $idSeccionBodega, $cantidadMinima, $cantidadMaxima, $observacion){

		$_producto        = $this->con->real_escape_string( $producto );
		$_perecedero      = (int) $perecedero;
		$_idTipoProducto  = (int) $idTipoProducto;
		$_idSeccionBodega = (int) $idSeccionBodega;
		$_cantidadMinima  = (int) $cantidadMinima;
		$_cantidadMaxima  = (int) $cantidadMaxima;
		$_observacion     = $this->con->real_escape_string( $observacion );
		$_idUsuario       = (int) $this->getIdUser();

		$sql = "CALL registrarProducto( '{$producto}', {$_perecedero}, {$_idTipoProducto}, {$_idSeccionBodega}, {$_cantidadMinima}, {$_cantidadMaxima}, '{$observacion}', {$_idUsuario});";

		if( $rs = $this->con->query( $sql ) ){
			// LIBERAR SIGUIENTE RESULTADO
			$this->con->next_result();
			$row = $rs->fetch_object();
			$this->mensaje   = $row->mensaje;
			$this->respuesta = (int) $row->respuesta;

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
	}

}
?>