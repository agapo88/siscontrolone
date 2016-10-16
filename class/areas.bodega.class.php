<?php 
/**
* AREAS
*/
class Area
{
	
	var $con;

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}

	// CONSULTAR TIPOS DONANTE
	function consultarSeccionB()
	{
		$lstAreasBodega = array();

		$sql = "SELECT idSeccionBodega, seccionBodega FROM seccionBodega;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstAreasBodega[] = $row;
			}
		}

		return $lstAreasBodega;
	}


}
?>