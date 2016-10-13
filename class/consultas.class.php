<?php 

/**
* CONSULTAS
*/
class Consultas
{
	var $con;

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}

	function consultarTipo()
	{
		$sql = "SELECT idArea, area FROM area";
		//$tipos = array();
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$tipos[] = $row;
			}
		}

		return $tipos;
	}

}
/*
djsmurf10@gmail.com

Toby Love Ft. Judy Santos - No Hay Colores

parkeastmusic@gmail.com

*/

?>
