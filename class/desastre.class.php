<?php 

/**
* DESASTRE
*/
class Desastre
{
	
	var $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}

	// METODO PARA CONSULTA TIPO DE DESASTRES
	function consultarTipoDesastre(){

		$sql = "SELECT * FROM tipoDesastre;";
		$lstTiposDesastre = array();

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstTiposDesastre[] = $row;
			}
		}

		return $lstTiposDesastre;
	}

	// METODO GUARDAR DESASTRE
	function guardarDesastre($desastre, $idTipoDesastre, $fechaDesastre){

		$sql = "CALL ingresarDesastre('{$desastre}', {$idTipoDesastre}, '{$fechaDesastre}');";
		if( $rs = $this->con->query( $sql ) ){
			$row = $rs->fetch_object();

			$this->respuesta = (int) $row->respuesta;
			$this->mensaje   = $row->mensaje;

		}else{
			$this->respuesta = 0;
			$this->mensaje   = "Error al ejecutar el procedimiento para ingreso.";
		}

		$response = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $response;
	}


	// METODO PARA CONSULTAR DESASTRES
	function consultarDesastres(){

		$sql = "SELECT * FROM vstDesastres;";
		$lstDesastres = array();

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstDesastres[] = $row;
			}
		}

		return $lstDesastres;
	}

}
?>