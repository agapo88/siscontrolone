<?php 

/**
* FAMILIAS BENEFICIADAS
*/
class Familia extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function consultarFamilias( $groupBy = 'departamento'){


		$lstFamiliasB = array();

		$sql = "SELECT 
				    idFamilia,
				    nombreFamilia,
				    fechaIngreso,
				    idArea,
				    area,
				    direccion,
				    idMunicipio,
				    municipio,
				    idDepartamento,
				    departamento,
				    idEstado,
				    estado
				FROM
				    vstFamilias;";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				
				$iEstado       = -1;
				$iDepartamento = -1;
				$iMunicipio    = -1;

				$iFamilia      = -1;
				$iAnio         = -1;

				// VER TIPO DE AGRUPACIÓN
				if( $groupBy == 'departamento' ): 		// DEPARTAMENTO
					// VER SI EXISTE DEPARTAMENTO
					foreach ($lstFamiliasB AS $ixDepartamento => $departamento) {
						if( $departamento['idDepartamento'] == $row->idDepartamento ){
							$iDepartamento = $ixDepartamento;
							break;
						}
					}

				elseif( $groupBy == 'anio' ):			// AÑO
					// VER SI EXISTE ENTIDAD
					foreach ($lstFamiliasB AS $ixAnio => $anio) {
						if( $anio['anio'] == $row->anio ){
							$iAnio = $ixAnio;
							break;
						}
					}

				elseif( $groupBy == 'estado' ):			// AÑO
					// VER SI EXISTE ENTIDAD
					foreach ($lstFamiliasB AS $ixEstado => $estado) {
						if( $estado['idEstadoDonador'] == $row->idEstadoDonador ){
							$iEstado = $ixEstado;
							break;
						}
					}

				endif;

				// SI NO EXISTE TIPO DE ENTIDAD Y/O AÑO
				if( $iDepartamento == -1 AND $iAnio == -1 AND $iEstado == -1 ){

					if( $groupBy == 'departamento' ):				// TIPOENTIDAD
						$iDepartamento = count( $lstFamiliasB );

					elseif( $groupBy == 'anio' ):					// AÑO
						$iAnio = count( $lstFamiliasB );

					elseif( $groupBy == 'estado' ):					// AÑO
						$iEstado = count( $lstFamiliasB );

					endif;

					$iDepartamento = count( $lstFamiliasB );

					$lstFamiliasB[ $iDepartamento ] = array(
						'idDepartamento'     => (int) $row->idDepartamento,
						'departamento'       => $row->departamento,
						'lstMunicipios'      => array(),
						'totalFamiliasDepto' => 0
					);
				}

				// VERIFICAR QUE EXISTA EL DEPARTAMENTO
				foreach ($lstFamiliasB[ $iDepartamento ]['lstMunicipios'] AS $ixMunicipio => $municipio) {
					if( $municipio['idMunicipio'] == $row->idMunicipio && $municipio['idDepartamento'] == $row->idDepartamento ){
						$iMunicipio = $ixMunicipio;
						break;
					}
				}

				// SI NO EXISTE MUNICIPIO
				if( $iMunicipio == -1 ){
					if( $groupBy == 'departamento' ):		// TIPOENTIDAD
						$ixSolicitud = $iDepartamento;
					elseif( $groupBy == 'anio' ):			// AÑO
						$ixSolicitud = $iAnio;
					elseif( $groupBy == 'estado' ):			// ESTADO
						$ixSolicitud = $iEstado;
					endif;

					$iMunicipio = count( $lstFamiliasB[ $ixSolicitud ]['lstMunicipios'] );

					$lstFamiliasB[ $ixSolicitud ][ 'lstMunicipios' ][ $iMunicipio ] = array(
							'idDepartamento' => $row->idDepartamento,
							'departamento'   => $row->departamento,
							'idMunicipio'    => $row->idMunicipio,
							'municipio'      => $row->municipio,
							'lstFamilias'    => array(),
							'subTotal'       => 0,
						);
					
				}				

				
				// VERIFICAR QUE EXISTA LA FAMILIA
				foreach ($lstFamiliasB[ $ixSolicitud ]['lstMunicipios'] AS $ixMunicipio => $municipio) {
					// var_dump( $municipio )
					foreach ($municipio['lstFamilias'] AS $ixFamilia => $familia) {
						if( $familia['idFamilia'] == $row->idFamilia && $familia['idMunicipio'] == $row->idMunicipio   ) {
							$iFamilia = $ixFamilia;
							break;
						}
					}
				}

				// SI NO EXISTE FAMILIA
				if( $iFamilia == -1 ){
					$lstFamiliasB[ $ixSolicitud ]['lstMunicipios'][ $iMunicipio ]['lstFamilias'][] = 
						array(
							'idFamilia'     => $row->idFamilia,
							'nombreFamilia' => $row->nombreFamilia,
							'idEstado'      => $row->idEstado,
							'area'          => $row->area,
							'direccion'     => $row->direccion,
							'idMunicipio'   => $row->idMunicipio,
							'municipio'     => $row->municipio,
							'estado'        => $row->estado,
							'fechaIngreso'  => $row->fechaIngreso
						);
					$lstFamiliasB[ $ixSolicitud ]['totalFamiliasDepto']++;
				}
	
			}

		}

		//var_dump( $lstFamiliasB );
		return $lstFamiliasB;
	}


}
?>