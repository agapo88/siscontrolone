<?php 
/**
* PROVEEDOR
*/
class Proveedor
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
}
?>