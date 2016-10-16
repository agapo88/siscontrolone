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
					    idProducto, producto, esPerecedero
					FROM
					    producto";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstProveedores[] = $row;
			}
		}

		return $lstProveedores;
	}
}
?>