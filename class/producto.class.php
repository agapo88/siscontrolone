<?php 
/**
* PRODUCTO
*/
class Producto
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
						'perecedero'      => $row->perecedero,
						'lstProductos'    => array(),
						'totalProductos'  => 0
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

					$lstProductos[ $ixSolicitud ][ 'lstProductos' ][] = array(
						'idProducto'      => $row->idProducto,
						'producto'        => $row->producto,
						'observacion'     => $row->observacion,
						'esPerecedero'    => $row->esPerecedero,
						'perecedero'      => $row->perecedero,
						'idSeccionBodega' => $row->idSeccionBodega,
						'ubicacionBodega' => $row->seccionBodega,
						'idTipoProducto'  => $row->idTipoProducto,
						'tipoProducto'    => $row->tipoProducto,
						'totalProducto'   => $row->totalProducto ? $row->totalProducto : 0,
						
					);
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
	*/

}
?>