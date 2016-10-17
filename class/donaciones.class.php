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

	// GUARDAR DONACIONES DEL FONDO COMUN
	function guardarFondoComun($esAnonimo, $idDonador, $donacion, $idMoneda, $fechaDonacion){

		$respuesta      = array();
		if( $esAnonimo )
			$_idDonador = (int) $idDonador;
		else
			$_idDonador = "NULL";

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