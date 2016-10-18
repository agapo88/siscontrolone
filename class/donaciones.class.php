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

		$sql = "CALL agregarCompraDonacion({$_idDonador}, '{$_fechaAdquisicion}', {$_noFactura}, {$_idUsuario});";

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

}
?>