<?php 
/**
* PROVEEDOR
*/
class Proveedor extends session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	function consultarProveedores(){

		$lstProveedores = array();
		$sql = "SELECT 
					    idProveedor, proveedor
					FROM
					    proveedor;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstProveedores[] = $row;
			}
		}

		return $lstProveedores;
	}

	// REGISTRAR PROVEEDOR
	function registrarProveedor($nombreProveedor, $telefono, $email){

		$_nombreProveedor = $this->con->real_escape_string( $nombreProveedor );
		$_telefono        = (int) $telefono;
		$_email          = $this->con->real_escape_string( $email );

		$sql = "CALL ingresarProveedor('{$_nombreProveedor}', '{$_telefono}', '{$_email}')";

		if( $rs = $this->con->query( $sql ) ){

			$this->con->next_result();
			$row = $rs->fetch_object();

			$this->respuesta = (int) $row->respuesta;
			$this->mensaje   = $row->mensaje;
		}else{
			$this->respuesta = 0;
			$this->mensaje   = "Error al ejectuar el procedimiento de registro.";
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
	}

	function cargarListaProveedores(){
		$lstProveedores = array();
		$sql = "SELECT 
				    idProveedor, proveedor, telefono, email
				FROM
				    proveedor";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstProveedores[] = $row;
			}
		}

		return $lstProveedores;
	}


}
?>