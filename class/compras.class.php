<?php 

/**
* COMPRAS
*/
class Compra extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function consultarEfectivo( $groupBy = 'departamento'){


}
?>