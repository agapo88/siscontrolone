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


	// CONSULTAR AREAS
	function consultarAreas(){
		$lstAreas = array();

		$sql = "SELECT idArea, area FROM area;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstAreas[] = $row;
			}
		}

		return $lstAreas;
	}

	// CONSULTAR PARENTESCOS
	function consultarParentescos(){
		$lstParentesco = array();

		$sql = "SELECT idParentesco, parentesco FROM parentesco;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstParentesco[] = $row;
			}
		}

		return $lstParentesco;
	}


	// CONSULTAR PARENTESCOS
	function consultarGeneros(){
		$lstGeneros = array();

		$sql = "SELECT idGenero, genero FROM genero;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstGeneros[] = $row;
			}
		}

		return $lstGeneros;
	}


	// CONSULTAR PARENTESCOS
	function consultarDepartamentos(){
		$lstDepartamentos = array();

		$sql = "SELECT idDepartamento, departamento FROM departamento;;";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstDepartamentos[] = $row;
			}
		}

		return $lstDepartamentos;
	}

	function consultarMunicipios( $idDepartamento ){
		$lstMunicipios = array();
		$idDepartamento = (int) $idDepartamento;
		$sql = "SELECT idMunicipio, idDepartamento, municipio FROM municipio WHERE idDepartamento = {$idDepartamento};";
		
		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				$lstMunicipios[] = $row;
			}
		}

		return $lstMunicipios;
	}


	

}
/*
djsmurf10@gmail.com

Toby Love Ft. Judy Santos - No Hay Colores

parkeastmusic@gmail.com

*/

?>
