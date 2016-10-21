<?php 
/**
* DONACIÓN
*/
class Donacion extends Session
{
	
	var $con;
	private $error   = false;
	private $mensaje = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}

	function consultarFondoComun( $groupBy = 'tipoEntidad' ){
		$lstFondoComun = array();

		$sql = "SELECT 
				    idFondoComun,
				    idDonador,
				    nombre,
				    telefono,
				    idTipoEntidad,
				    tipoEntidad,
				    donacion,
				    fechaDonacion,
				    DATE_FORMAT(fechaDonacion, '%d/%m/%Y') AS fechaDonador,
				    idMoneda,
				    moneda,
				    total
				FROM
				    vstFondoComun;";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				
				$iTipoEntidad   = -1;
				$iFechaDonacion = -1;
				$iMoneda        = -1;
				$iFondo         = -1;

				// VER TIPO DE AGRUPACIÓN
				if( $groupBy == 'tipoEntidad' ): 		// TIPOPRODUCTO
					foreach ($lstFondoComun AS $ixTipoEntidad => $tipoEntidad) {
						if( $tipoEntidad['idTipoEntidad'] == $row->idTipoEntidad ){
							$iTipoEntidad = $ixTipoEntidad;
							break;
						}
					}

				elseif( $groupBy == 'fechaDonacion' ):			// SECCION BODEGA
					foreach ($lstFondoComun AS $ixFondoComun => $fechaDonacion) {
						if( $fechaDonacion['fechaDonacion'] == $row->fechaDonacion ){
							$iFechaDonacion = $ixFondoComun;
							break;
						}
					}

				elseif( $groupBy == 'moneda' ):			// CLASIFICACION
					foreach ($lstFondoComun AS $ixMoneda => $moneda) {
						if( $moneda['idMoneda'] == $row->idMoneda ){
							$iMoneda = $ixMoneda;
							break;
						}
					}

				endif;

				// SI NO EXISTE EL TIPO LO AGREGA
				if( $iTipoEntidad == -1 AND $iFechaDonacion == -1 AND $iMoneda == -1 ){

					if( $groupBy == 'tipoEntidad' ):				// TIPOPRODUCTO
						$iTipoEntidad = count( $lstFondoComun );

					elseif( $groupBy == 'fechaDonacion' ):			// BODEGA
						$iFechaDonacion = count( $lstFondoComun );

					elseif( $groupBy == 'moneda' ):			// CLASIFICACION
						$iMoneda = count( $lstFondoComun );

					endif;

					$lstFondoComun[] = array(
						'idTipoEntidad'        => (int) $row->idTipoEntidad,
						'tipoEntidad'          => $row->tipoEntidad,
						'fechaDonacion'        => $row->fechaDonacion,
						'idMoneda'             => $row->idMoneda,
						'moneda'               => $row->moneda,
						'total'                => $row->total,
						'totalDonacionEntidad' => 0,
						'lstFondos'         => array(),
					);
				}

				// VERIFICAR QUE VENGAN LOS LOS PRODUCTOS
				foreach ($lstFondoComun AS $ixFondoComun => $fondoComun) {
					foreach ($fondoComun['lstFondos'] AS $ixFondo => $fondo) {
						if( $fondo['idFondoComun'] == $row->idFondoComun ){
							$iFondo = $ixFondo;
							break;
						}
					}
				}

				// SI NO EXISTE EL DONANTE
				if( $iFondo == -1 ){
					if( $groupBy == 'tipoEntidad' ):			// TIPO PRODUCTO
						$ixSolicitud = $iTipoEntidad;
					elseif( $groupBy == 'fechaDonacion' ):		// SECCION BODEGA
						$ixSolicitud = $iFechaDonacion;
					elseif( $groupBy == 'moneda' ):		// CLASIFICACION
						$ixSolicitud = $iMoneda;
					endif;


					$lstFondoComun[ $ixSolicitud ][ 'lstFondos' ][] = array(
						'idFondoComun'  => $row->idFondoComun,
						'idDonador'     => $row->idDonador,
						'nombre'        => $row->idDonador ? $row->nombre : 'Donador Anónimo',
						'telefono'      => $row->telefono,
						'tipoEntidad'   => $row->idDonador ? $row->tipoEntidad : 'Donador Anónimo',
						'donacion'      => $row->donacion,
						'fechaDonacion' => $row->fechaDonador,
						'tipoMoneda'    => $row->idMoneda == 1 ? 'Q.' : '$.',
					);

					//$lstFondoComun[ $ixSolicitud ]['totalProductos'] ++;
					$lstFondoComun[ $ixSolicitud ]['totalDonacionEntidad'] += $row->donacion;
				}

			}
		}

		return $lstFondoComun;
	}

	// GUARDAR DONACION PRODUCTO
	function guardarDonacionProducto( $lstProductosD ){

		$respuesta = array();

		if( $lstProductosD->esAnonimo )
			$_idDonador = "NULL";
		else
			$_idDonador = (int) $lstProductosD->idDonador;

		if(  $lstProductosD->tieneFactura )
			$_noFactura = (int) $lstProductosD->noFactura;
		else
			$_noFactura = "NULL";

		$_fechaAdquisicion = $lstProductosD->fecha;
		$_idUsuario        = (int) $this->getIdUser();

		$this->con->query( "START TRANSACTION" );

		$sql = "CALL agregarCompraDonacion({$_idDonador}, '{$_fechaAdquisicion}', {$_noFactura}, NULL, {$_idUsuario});";

		if( $rs = $this->con->query( $sql ) ){
			// LIBERAR SIGUIENTE RESULTADO
			$this->con->next_result();
			$row = $rs->fetch_object();
			$row->respuesta = (int) $row->respuesta;

			if( $row->respuesta ){
				$_idCompraDonacion = (int) $row->idCompraDonacion;

				if( !$this->error ){
					foreach( $lstProductosD->lstProductos AS $producto ){

						if( !isset($producto->fechaCaducidad) )
							$producto->fechaCaducidad = "NULL";
						else
							$producto->fechaCaducidad = "'".$producto->fechaCaducidad."'";

						$sql = "CALL adquisionProducto({$_idCompraDonacion}, {$producto->idProducto}, NULL, {$producto->cantidad}, {$producto->precioUnitario}, {$producto->fechaCaducidad});";

						if( $rs = $this->con->query( $sql ) ){
							// LIBERAR SIGUIENTE RESULTADO
							$this->con->next_result();
							$row = $rs->fetch_object();
							$this->mensaje   = $row->mensaje;
							$this->respuesta = (int) $row->respuesta;
								if( !$this->respuesta ){
									$this->error = true;
									break;
								}
						}else{
							$this->mensaje   = "Error al guardar el producto";
							$this->respuesta = 0;
							$this->error     = true;
							break;
						}
					}
				}
			}else{
				$this->respuesta = $row->respuesta;
				$this->mensaje   = $row->mensaje;
				$this->error     = true;
			}

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
			$this->error     = true;
		}

		if ( $this->error ){
			$this->con->query( "ROLLBACK" );
		}
		else{
			$this->con->query( "COMMIT" );
			$this->mensaje   = "Donación de productos registrado exitosamente.";
			$this->respuesta = 1;
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
	}

	// GUARDAR DONACIONES DEL FONDO COMUN
	function guardarFondoComun($esAnonimo, $idDonador, $donacion, $idMoneda, $fechaDonacion){

		$respuesta      = array();
		if( $esAnonimo )
			$_idDonador = "NULL";
		else
			$_idDonador = (int) $idDonador;

		$_donacion      = (double) $donacion;
		$_idMoneda      = (int) $idMoneda;
		$_fechaDonacion = $fechaDonacion;
		$_idUsuario     = (int) $this->getIdUser();

		$sql = "CALL ingresarFondoComun({$_idDonador}, {$_donacion}, {$_idMoneda}, '{$_fechaDonacion}', {$_idUsuario});";

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

	// CONSULTAR FONDO COMUN POR MONEDA
	function cargarMontosFondo(){
		$lstTotalFondos = array();

		$sql = "SELECT cc.idMoneda, moneda, total 
					FROM controlCaja As cc
						JOIN moneda AS m
							ON m.idMoneda = cc.idMoneda";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstTotalFondos[] = $row;
			}
		}

		return $lstTotalFondos;
	}

}
?>