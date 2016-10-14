<?php 
/**
* DONANTES
*/
class Donante extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function consultarDonantes(){

		$lstDonadores = array();
		$sql = "SELECT idDonador, nombre, telefono, email, DATE_FORMAT(fechaIngreso, '%d/%m/%Y') AS fechaIngreso, tipoEntidad FROM vstConsultarDonantes;";

		//echo $sql;
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstDonadores[] = $row;
			}
		}

		return $lstDonadores;
	}


	// FUNCIÓN GUARDAR NUEVO DONADOR
	function guardarDonador($nombre, $telefono, $email, $idTipoEntidad, $fechaIngreso){
		
		$respuesta      = array();
		$_nombre        = $this->con->real_escape_string( $nombre );
		$_telefono      = $this->con->real_escape_string( $telefono );
		$_email         = $this->con->real_escape_string( $email );
		$_fechaIngreso  = $this->con->real_escape_string( $fechaIngreso );
		$_idTipoEntidad = (int) $idTipoEntidad;
		$_idUsuario     = (int) $this->getIdUser();

		$sql = "CALL ingresarDonadosr('{$_nombre}', '{$_telefono}', '{$_email}', {$_idTipoEntidad}, '{$_fechaIngreso}', {$_idUsuario});";

		if( $rs = $this->con->query( $sql ) ){
			$row = $rs->fetch_object();

			$this->mensaje   = $row->mensaje;
			$this->respuesta = $row->respuesta;

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
	}

	
	}
?>