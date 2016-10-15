<?php 
/**
* DONANTES
*/
class Donante extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function consultarDonantes(  $groupBy = 'tipoEntidad'){

		$firstDate         = true;
		$lstDonadores = array();
		$donantes = array();
		$sql = "SELECT 
						idDonador,
					    nombre,
					    telefono,
					    email,
					    fechaIngreso,
					    DATE_FORMAT(fechaIngreso, '%Y') AS anio,
    					DATE_FORMAT(fechaIngreso, '%m') AS mes,
					    idTipoEntidad,
					    tipoEntidad,
					    idEstadoDonador,
					    estadoDonador
					FROM
					    vstDonadores;";

		if( $rs = $this->con->query( $sql ) ){

			while( $row = $rs->fetch_object() ){

				$iTipoDonador = -1;
				$iAnio        = -1;
				$iFecha       = -1;

				$groupEntidad = array( 'idTipoEntidad' => $row->idTipoEntidad, 'tipoEntidad' => $row->tipoEntidad );

				// AGRUPAR POR TIPO ENTIDAD
				foreach ( $lstDonadores as $ixTipoDonador => $donador ) {
					if ( $donador['idTipoEntidad'] == $groupEntidad['idTipoEntidad'] ) {
						$iTipoDonador = $ixTipoDonador;
						break;
					}
				}

				// SI NO EXISTE TIPO DONADOR
				if ( $iTipoDonador == -1 )
					$lstDonadores[] = array(
						'idTipoEntidad' => $groupEntidad['idTipoEntidad'],
						'tipoEntidad'   => $groupEntidad['tipoEntidad'],
						'count'         => 0
					);


				/********
					ORDEN Y AGRUPAR
				**********/

				// REVISA SI EXISTE ORDEN
				if ( $groupBy == 'anio' ):
					foreach ( $donantes AS $ixAnio => $anio ) {
						if ( $anio['anio'] == $row->anio ) {
							$iAnio = $ixAnio;
							break;
						}
					}
				
				else:
					foreach ( $donantes AS $ixFecha => $fecha ) {
						if ( $fecha['fechaIngreso'] == $row->fechaIngreso ) {
							$iFecha = $ixFecha;
							break;
						}
					}

				endif;

				// SI NO EXISTE EN EL ARREGLO SE AGREGA
				if ( $iAnio === -1 AND $iMes === -1 AND $iFecha === -1 ) {

					if ( $groupBy === 'anio' ):
						$iAnio  = count( $donantes );
					else:
						$iTipoDonador = count( $donantes );
					endif;


					$donantes[] = array(
						'fechaIngreso'   => $row->fechaIngreso,
						'idEstadoDonador'  => $row->idEstadoDonador,
						'estadoDonador'  => $row->estadoDonador,
						'anio'           => $row->anio,
						'mes'            => $row->mes,
						'idTipoEntidad'  => $groupEntidad['idTipoEntidad'],
						'tipoEntidad'    => $groupEntidad['tipoEntidad'],
						'lstSolicitudes' => array(),
						'lstAgencias'  	 => array(),
						'count'          => 0,
						'groupBy'        => $groupBy,
						'show'           => ( $firstDate ? true : false )
					);

					$firstDate  = false;
					// ELIMINAR FECHA GROUP
					unset( $row->fechaIngreso );
				}

								// SI ES POR FECHA O FECHA => AGENCIA
				if ( $groupBy === '' OR $groupBy === 'tipoEntidad' ) {
					$donantes[ $iTipoDonador ]['count']++;
				}

				// SI SE AGRUPA POR FECHA
				if ( $groupBy === '' ):
					$donantes[ $iTipoDonador ]['lstSolicitudes'][] = $row;
				
				// SI SE AGRUPA POR NO. ORDEN
				elseif ( $groupBy === 'anio' ):
					$donantes[ $iAnio ]['lstSolicitudes'][] = $row;
					$donantes[ $iAnio ]['count']++;

				// SI SE AGRUPA POR ESTADO DE GESTIÓN
				elseif ( $groupBy === 'mes' ):
					$donantes[ $iMes ]['lstSolicitudes'][] = $row;
					$donantes[ $iMes ]['count']++;

				endif;


				// SI SE AGRUPA =====> POR AGENCIA
				if ( $groupBy === 'tipoEntidad' ) {
					$iTipoDonador = -1;

					// CONSULTA FECHA SI EXISTE EN AGENCIA
					foreach ($donantes[ $iTipoDonador ]['lstAgencias'] AS $ixAgencia => $agencia) {
						if ( $agencia['idAgencia'] == $groupEntidad['idAgencia'] ) {
							$iAgencia = $ixAgencia;
							break;
						}
					}

					// SI NO EXISTE EN ARREGLO
					if ( $iAgencia === -1 ) {
						$iAgencia = count( $donantes[ $iTipoDonador ]['lstAgencias'] );

						// AGREGA FECHA A AGENCIA ACTUAL
						$donantes[ $iTipoDonador ]['lstAgencias'][] = array(
							'idTipoEntidad'       => $groupEntidad['idTipoEntidad'],
							'tipoEntidad'         => $groupEntidad['tipoEntidad'],
							'lstSolicitudes'  => array(),
							'count'  		  => 0,
							'show'            => ( $firstAg ? true : false ),
						);

						$firstAg = false;
					}
					
					$donantes[ $iFecha ]['lstAgencias'][ $iAgencia ]['lstSolicitudes'][] = $row;
					$donantes[ $iFecha ]['lstAgencias'][ $iAgencia ]['count']++;
				}

			}
		}

		return $lstDonadores;
	}


	// FUNCIÓN GUARDAR NUEVO DONADOR
	function guardarDonador($nombre, $telefono, $email, $idTipoEntidad, $fechaIngreso){
		$respuesta      = array();
		$_nombre        = $this->con->real_escape_string( $nombre );
		$_telefono      = $this->con->real_escape_string( $telefono );
		$_email         = $this->con->real_escape_string( $email );
		$_fechaIngreso  = $this->con->real_escape_string( $fechaIngreso );
		$_idTipoEntidad = (int) $idTipoEntidad;
		$_idUsuario     = (int) $this->getIdUser();

		$sql = "CALL ingresarDonador('{$_nombre}', '{$_telefono}', '{$_email}', {$_idTipoEntidad}, '{$_fechaIngreso}', {$_idUsuario});";

		if( $rs = $this->con->query( $sql ) ){
			// LIBERAR SIGUIENTE RESULTADO
			$this->con->next_result();
			$row = $rs->fetch_object();
			$this->mensaje   = $row->mensaje;
			$this->respuesta = $row->respuesta;

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
	}

}
?>