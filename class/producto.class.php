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


		// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function consultarProductos(  $groupBy = 'anio'){

		// FILTRAR POR ESTADO
		if( $groupBy == 'estado' )
			$filtroEstado = "";
		else
			$filtroEstado = " WHERE idEstadoDonador = 1 ";

		$firstDate    = true;
		$lstDonadores = array();

		$sql = "SELECT 
					    idProducto,
					    producto,
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
				
				$iTipoProducto = -1;
				$iUbicacion        = -1;
				$iEstado      = -1;
				$iDonador     = -1;

				// VER TIPO DE AGRUPACIÓN
				if( $groupBy == 'tipoProducto' ): 		//tipoProducto
					// VER SI EXISTE ENTIDAD
					foreach ($lstDonadores AS $ixtipoProducto => $tipoProducto) {
						if( $tipoProducto['idTipoProducto'] == $row->idTipoProducto ){
							$iTipoProducto = $ixtipoProducto;
							break;
						}
					}

				elseif( $groupBy == 'ubicacion' ):			// AÑO
					// VER SI EXISTE ENTIDAD
					foreach ($lstDonadores AS $ixUbicacion => $anio) {
						if( $anio['anio'] == $row->anio ){
							$iUbicacion = $ixUbicacion;
							break;
						}
					}

				elseif( $groupBy == 'estado' ):			// AÑO
					// VER SI EXISTE ENTIDAD
					foreach ($lstDonadores AS $ixEstado => $estado) {
						if( $estado['idEstadoDonador'] == $row->idEstadoDonador ){
							$iEstado = $ixEstado;
							break;
						}
					}

				endif;

				// SI NO EXISTE TIPO DE ENTIDAD Y/O AÑO
				if( $iTipoProducto == -1 AND $iUbicacion == -1 AND $iEstado == -1 ){

					if( $groupBy == 'tipoProducto' ):				// tipoProducto
						$iTipoProducto = count( $lstDonadores );

					elseif( $groupBy == 'anio' ):					// AÑO
						$iUbicacion = count( $lstDonadores );

					elseif( $groupBy == 'estado' ):					// AÑO
						$iEstado = count( $lstDonadores );

					endif;

					$lstDonadores[] = array(
						'idTipoProducto' => (int) $row->idTipoProducto,
						'tipoProducto'   => $row->tipoProducto,
						'lstProductos'   => array(),
						'totalProductos' => 0
					);
				}

				// VERIFICAR QUE VENGAN LOS DONANTES
				foreach ($lstDonadores AS $ixtipoProducto => $tipoProducto) {
					foreach ($tipoProducto['lstProductos'] AS $ixDonante => $donante) {
						if( $donante['idProducto'] == $row->idProducto )		{
							$iDonador = $ixDonante;
							break;
						}
					}
				}

				// SI NO EXISTE EL DONANTE
				if( $iDonador == -1 ){
					if( $groupBy == 'tipoProducto' ):		// tipoProducto
						$ixSolicitud = $iTipoProducto;
					elseif( $groupBy == 'anio' ):			// AÑO
						$ixSolicitud = $iUbicacion;
					elseif( $groupBy == 'estado' ):			// ESTADO
						$ixSolicitud = $iEstado;
					endif;

					$lstDonadores[ $ixSolicitud ][ 'lstProductos' ][] = array(
						'idProducto'      => $row->idProducto,
						'producto'        => $row->producto,
						'esPerecedero'    => $row->esPerecedero,
						'perecedero'      => $row->perecedero,
						'ubicacionBodega' => $row->seccionBodega,
						'idTipoProducto'  => $row->idTipoProducto,
						'tipoProducto'    => $row->tipoProducto,
						'totalProducto'   => $row->totalProducto ? $row->totalProducto : 0,
						
					);
					$lstDonadores[ $ixSolicitud ]['totalProductos'] ++;
				}


			}

		}

		return $lstDonadores;
	}

	/*
	// CONSULTAR LISTA DE PRODUCTOS BD
	function consultarProductos()
	{
		$lstProductos = array();
		$sql = "SELECT 
					    idProducto, producto, esPerecedero
					FROM
					    producto";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstProductos[] = $row;
			}
		}

		return $lstProductos;
	}
	*/

}
?>