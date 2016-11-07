<?php 
/**
* VALIDACIÓN
*/
class Validacion
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";
	private $error   = false;

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}


	// FUNCIÓN VALIDAR DATOS LOGIN
	function validarUsuario( $username, $password ){

		$sql = "CALL loginUserPass ('{$username}', '{$password}');";

		if( $rs = $this->con->query( $sql) ){
			$this->con->next_result();
			$row = $rs->fetch_object();	

			$this->respuesta = (int) $row->respuesta;
			$this->mensaje   = $row->mensaje;

		}else{
			$this->error   = true;
			$this->mensaje = "Error al ejecutar el procedimiento de Login.";
		}

		$response = array( 'mensaje' => $this->mensaje, 'respuesta' => $this->respuesta );
		return (object) $response; 
	}


	// FUNCIÓN CAMBIAR PASSWORD
	function cambiarPassword( $username, $passwordNuevo ){

		$sql = "CALL cambiarPassword('{$username}', '{$passwordNuevo}');";

		if( $rs = $this->con->query( $sql) ){
			$this->con->next_result();
			$row = $rs->fetch_object();	

			$this->respuesta = (int) $row->respuesta;
			$this->mensaje   = $row->mensaje;

		}else{
			$this->error   = true;
			$this->mensaje = "Error al ejecutar el procedimiento de actualización.";
		}

		$response = array( 'mensaje' => $this->mensaje, 'respuesta' => $this->respuesta );
		return (object) $response; 
	}


}
?>