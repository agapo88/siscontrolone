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

	// CONSULTAR TIPOS DONANTE
	function consultarTipoEntidad()
	{
		$lstTipoEntidad = array();

		$sql = "SELECT idTipoEntidad, tipoEntidad FROM tipoEntidad;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstTipoEntidad[] = $row;
			}
		}

		return $lstTipoEntidad;
	}

}
/*
djsmurf10@gmail.com

Toby Love Ft. Judy Santos - No Hay Colores

parkeastmusic@gmail.com

*/

?>
