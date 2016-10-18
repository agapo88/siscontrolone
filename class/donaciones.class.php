<?php 
/**
* DONACIÓN
*/
class Donacion extends Session
{
	
	var $con;

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}

	// GUARDAR DONACION PRODUCTO
	function guardarDonacionProducto( $lstProductosD ){

		var_dump( $lstProductosD );

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

		$sql = "CALL agregarCompraDonacion({$_idDonador}, {$_fechaAdquisicion}, {$_noFactura}, {$_idUsuario});";


		if( $rs = $this->con->query( $sql ) ){
			// LIBERAR SIGUIENTE RESULTADO
			$this->con->next_result();
			$row = $rs->fetch_object();
			
			/*if( $row->respuesta == "1" ){
				foreach( $lstProductosD->lstProductos )
			}
			*/
		
			$this->mensaje   = $row->mensaje;
			$this->respuesta = (int) $row->respuesta;

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
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