<?php 
/**
* DONANTES
*/
class Donante
{
	
	private $con;

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}


	// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function consultarDonantes(){

		$lstDonadores = array();
		$sql = "SELECT idDonador, nombre, telefono, email, fechaIngreso, tipoEntidad FROM vstConsultaDonantes;";

		if( $result = $this->con->query($sql) ){
			while( $row = $result->fetch_object() )
				$lstDonadores[] = $row;
		}

		return $lstDonadores;
	}

	
}
?>