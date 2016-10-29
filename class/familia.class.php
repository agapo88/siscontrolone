<?php 

/**
* FAMILIAS BENEFICIADAS
*/
class Familia extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";
	private $error     = false;

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
				    DATE_FORMAT(fechaIngreso, '%d/%m/%Y') AS fechaIngreso,
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
				$iFechaIngreso = -1;

				// VER TIPO DE AGRUPACIÓN
				if( $groupBy == 'departamento' ): 		// DEPARTAMENTO
					// VER SI EXISTE DEPARTAMENTO
					foreach ($lstFamiliasB AS $ixDepartamento => $departamento) {
						if( $departamento['idDepartamento'] == $row->idDepartamento ){
							$iDepartamento = $ixDepartamento;
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
				if( $iDepartamento == -1 ){

					if( $groupBy == 'departamento' ):					// DEPARTAMENTO
						$iDepartamento = count( $lstFamiliasB );

					elseif( $groupBy == 'estado' ):						// ESTADO ECONOMICO
						$iEstado = count( $lstFamiliasB );

					endif;

					$lstFamiliasB[ $iDepartamento ] = array(
						'idDepartamento'     => $row->idDepartamento,
						'departamento'       => $row->departamento,
						'lstMunicipios'      => array(),
						'totalFamiliasDepto' => 0
					);
				}

				// VERIFICAR QUE EXISTA EL DEPARTAMENTO
				foreach ($lstFamiliasB[ $iDepartamento ]['lstMunicipios'] AS $ixMunicipio => $municipio) {
					if( $municipio['idMunicipio'] == $row->idMunicipio AND $municipio['idDepartamento'] == $row->idDepartamento ){
						$iMunicipio = $ixMunicipio;
						break;
					}
				}

				if( $groupBy == 'departamento' ):		// TIPOENTIDAD
					$ixSolicitud = $iDepartamento;
				elseif( $groupBy == 'estado' ):			// ESTADO
					$ixSolicitud = $iEstado;
				endif;

				// SI NO EXISTE MUNICIPIO
				if( $iMunicipio == -1 ){
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
						if( $familia['idFamilia'] == $row->idFamilia && $familia['idMunicipio'] == $row->idMunicipio && $familia['idDepartamento'] == $row->idDepartamento ) {
							$iFamilia = $ixFamilia;
							break;
						}
					}
					if ( $iFamilia != -1 )
						break;
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
							'idDepartamento'=> $row->idDepartamento,
							'idMunicipio'   => $row->idMunicipio,
							'municipio'     => $row->municipio,
							'estado'        => $row->estado,
							'fechaIngreso'  => $row->fechaIngreso
						);
					$lstFamiliasB[ $ixSolicitud ]['totalFamiliasDepto']++;
					$lstFamiliasB[ $ixSolicitud ]['lstMunicipios'][ $iMunicipio ]['subTotal']++;
				}
	
			}

		}

		return $lstFamiliasB;
	}

	// FUNCIÓN CONSULTAR HISTORIAL ECONOMICO
	function verHistorialEconomico( $idFamilia ){
		
		$lstHistorialEco = array();
		$idFamilia       = (int) $idFamilia;

		$sql = "SELECT 
					    idFamilia,
					    nombreFamilia,
					    direccion,
					    idEstado,
					    estado,
					    observacion,
					    username,
					    fechaHora,
					    DATE_FORMAT(fechaHora, '%d/%m/%Y %h:%i %p') AS fechaIngreso
					FROM
					    vstHistorialEconomico
				WHERE idFamilia = {$idFamilia};";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){

				$iFamilia = -1;
				$iEstado  = -1;

				// RECORRER LISTA FAMILIAS
				foreach ($lstHistorialEco AS $ixHistorialE => $historialE) {
					if( $historialE['idFamilia'] == $row->idFamilia ){
						$iFamilia = $ixHistorialE;
						break;
					}
				}

				if( $iFamilia == -1 ){
					$iFamilia = count( $lstHistorialEco );
					$lstHistorialEco[ $iFamilia ] = array(
							'idFamilia'     => (int) $row->idFamilia,
							'nombreFamilia' => $row->nombreFamilia,
							'direccion'     => $row->direccion,
							'lstEstados'    => array(),
						);
				}

				// RECORRER LISTA ESTADOS
				foreach ($lstHistorialEco[ $iFamilia ]['lstEstados'] AS $ixEstado => $estado) {
					if( $estado['idEstado'] == $row->idEstado ){
						$iEstado = $ixEstado;
						break;
					}
				}

				if( $iEstado == -1 ){
					$iEstado = count( $lstHistorialEco[ $iFamilia ]['lstEstados'] );
					$lstHistorialEco[ $iFamilia ]['lstEstados'][$iEstado] = array(
							'idEstado'        => $row->idEstado,
							'estado'          => $row->estado,
							'lstSeguimientos' => array(),
						);
				}
				
				$lstHistorialEco[ $iFamilia ]['lstEstados'][$iEstado]['lstSeguimientos'][] = array(
						'observacion'  => $row->observacion,
						'username'     => $row->username,
						'fechaIngreso' => $row->fechaIngreso,
					);
			}
		}

		return $lstHistorialEco;
	}

	// FUNCIÓN GUARDAR FAMILIA
	function guardarFamilia(){
		global $data;

		$nombreFamilia  = $this->con->real_escape_string( $data->datos->nombre );
		$fechaIngreso   = $this->con->real_escape_string( $data->fechaIngreso );
		$direccion      = $this->con->real_escape_string( $data->datos->direccion );
		$idArea         = (int) $data->datos->idArea;
		$idMunicipio    = (int) $data->datos->idMunicipio;
		$idDepartamento = (int) $data->datos->idDepartamento;

		$this->con->query( "START TRANSACTION" );
		$sql = "CALL ingresarFamilia('{$nombreFamilia}', '{$fechaIngreso}', {$idArea}, '{$direccion}', {$idMunicipio}, {$idDepartamento}, {$this->getIdUser()});";


		if( $rs = $this->con->query( $sql ) ){

			$this->con->next_result();
			$row = $rs->fetch_object();

			$this->mensaje   = $row->mensaje;
			$this->respuesta = (int) $row->respuesta;

			if( $this->respuesta ){
				$idFamilia = (int) $row->idFamilia;
				$this->guardarMiembro($idFamilia, $data->datos->lstMiembros );
			}
			
		}else{
			$this->error   = true;
			$this->mensaje = "Error al ejecutar el Procedimiento de ingreso." ;
		}

		// VALIDAR REGISTRO PARA FINALIZAR TRANSACCIÓN
		if( $this->error )
			$this->con->query( "ROLLBACK" );
		else
			$this->con->query( "COMMIT" );

		$respuesta = array( 'mensaje' => $this->mensaje, 'respuesta' => $this->respuesta );

		return $respuesta;
	}

	// FUNCIÓN GUARDAR MIEMBROS
	function guardarMiembro($idFamilia, $lstMiembros){

		foreach ($lstMiembros AS $ixMiembro => $miembro) {
			if( $miembro->idParentesco != 99 )
				$miembro->parentesco = "NULL";
			else
				$miembro->parentesco = "'".$miembro->parentesco."'";

			$sql = "CALL ingresarMiembro('{$miembro->cui}', '{$miembro->nombres}', '{$miembro->apellidos}', '{$miembro->fechaNacimiento}', {$miembro->idGenero}, {$miembro->parentesco}, {$miembro->idParentesco}, {$idFamilia});";

			if( $rs = $this->con->query( $sql ) ){

				$this->con->next_result();
				$row = $rs->fetch_object();

				$this->mensaje   = $row->mensaje;
				$this->respuesta = (int) $row->respuesta;

				if( !$this->respuesta ){
					$this->error = true;
					break;
				}
				
			}else{
				$this->error   = true;
				$this->mensaje = "Error en el Procedimiento de ingreso de familiares." ;
			}
		}
	}

	function verMiembrosFamilia( $idFamilia ){

		$lstMiembrosFam = array();
		$sql = "SELECT 
					    idMiembro,
					    cui,
					    nombres,
					    apellidos,
					    fechaNacimiento,
					    edad,
					    idParentesco,
					    otroParentesco,
					    parentesco,
					    idFamilia,
					    nombreFamilia,
					    fechaIngreso,
					    direccion,
					    idGenero,
					    genero
					FROM
					    vstMiembrosFamilia
				WHERE idFamilia = {$idFamilia};";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				
				$iMiembro = -1;

				if( !count($lstMiembrosFam) ){
					$lstMiembrosFam[0] = array(
							'idFamilia'    => $row->idFamilia,
							'nombreFamilia'      => $row->nombreFamilia,
							'fechaIngreso' => $row->fechaIngreso,
							'direccion'    => $row->direccion,
							'lstMiembros'  => array()
						);
				}

				foreach ($lstMiembrosFam[0]['lstMiembros'] AS $ixMiembro => $miembro) {
					if( $miembro['idMiembro'] == $row->idMiembro ){
						$iMiembro = $ixMiembro;
						break;
					}
				}

				if( $iMiembro == -1 ){

					$lstMiembrosFam[0]['lstMiembros'][] = array(
							'idMiembro'       => $row->idMiembro,
							'cui'             => $row->cui,
							'nombres'         => $row->nombres,
							'apellidos'       => $row->apellidos,
							'parentesco'      => $row->idParentesco == 99 ? $row->otroParentesco : $row->parentesco,
							'genero'          => $row->genero,
							'fechaNacimiento' => $row->fechaNacimiento,
							'edad'            => $row->edad,
						);
				}
			}
		}

		return $lstMiembrosFam;
	}

}
?>