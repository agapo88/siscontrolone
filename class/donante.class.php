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
	function consultarDonantes(  $groupBy = 'anio'){

		// FILTRAR POR ESTADO
		if( $groupBy == 'estado' )
			$filtroEstado = "";
		else
			$filtroEstado = " WHERE idEstadoDonador = 1 ";

		$firstDate    = true;
		$lstDonadores = array();

		$sql = "SELECT 
						idDonador,
					    nombre,
					    telefono,
					    email,
					    fechaIngreso,
					    DATE_FORMAT(fechaIngreso, '%d/%m/%Y') AS fechaFormato,
					    DATE_FORMAT(fechaIngreso, '%Y') AS anio,
    					DATE_FORMAT(fechaIngreso, '%m') AS mes,
					    idTipoEntidad,
					    tipoEntidad,
					    idEstadoDonador,
					    estadoDonador
					FROM
					    vstDonadores $filtroEstado;";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){
				
				$iTipoEntidad = -1;
				$iAnio        = -1;
				$iEstado      = -1;
				$iDonador     = -1;

				// VER TIPO DE AGRUPACIÓN
				if( $groupBy == 'tipoEntidad' ): 		//TIPOENTIDAD
					// VER SI EXISTE ENTIDAD
					foreach ($lstDonadores AS $ixTipoEntidad => $tipoEntidad) {
						if( $tipoEntidad['idTipoEntidad'] == $row->idTipoEntidad ){
							$iTipoEntidad = $ixTipoEntidad;
							break;
						}
					}

				elseif( $groupBy == 'anio' ):			// AÑO
					// VER SI EXISTE ENTIDAD
					foreach ($lstDonadores AS $ixAnio => $anio) {
						if( $anio['anio'] == $row->anio ){
							$iAnio = $ixAnio;
							break;
						}
					}

				elseif( $groupBy == 'estado' ):			// AÑO
					// VER SI EXISTE ENTIDAD
					foreach ($lstDonadores AS $ixEstado => $estado) {
						if( $estado['idEstadoDonador'] == $row->idEstadoDonador ){
							$iEstado = $ixEstado;
							break;
						}
					}

				endif;

				// SI NO EXISTE TIPO DE ENTIDAD Y/O AÑO
				if( $iTipoEntidad == -1 AND $iAnio == -1 AND $iEstado == -1 ){

					if( $groupBy == 'tipoEntidad' ):				// TIPOENTIDAD
						$iTipoEntidad = count( $lstDonadores );

					elseif( $groupBy == 'anio' ):					// AÑO
						$iAnio = count( $lstDonadores );

					elseif( $groupBy == 'estado' ):					// AÑO
						$iEstado = count( $lstDonadores );

					endif;

					$lstDonadores[] = array(
						'idTipoEntidad'   => (int) $row->idTipoEntidad,
						'tipoEntidad'     => $row->tipoEntidad,
						'anio'            => $row->anio,
						'idEstadoDonador' => $row->idEstadoDonador,
						'estadoDonador'   => $row->estadoDonador,
						'lstDonantes'     => array(),
						'totalDonantes'   => 0
					);
				}

				// VERIFICAR QUE VENGAN LOS DONANTES
				foreach ($lstDonadores AS $ixTipoEntidad => $tipoEntidad) {
					foreach ($tipoEntidad['lstDonantes'] AS $ixDonante => $donante) {
						if( $donante['idDonador'] == $row->idDonador )		{
							$iDonador = $ixDonante;
							break;
						}
					}
				}

				// SI NO EXISTE EL DONANTE
				if( $iDonador == -1 ){
					if( $groupBy == 'tipoEntidad' ):		// TIPOENTIDAD
						$ixSolicitud = $iTipoEntidad;
					elseif( $groupBy == 'anio' ):			// AÑO
						$ixSolicitud = $iAnio;
					elseif( $groupBy == 'estado' ):			// ESTADO
						$ixSolicitud = $iEstado;
					endif;

					$lstDonadores[ $ixSolicitud ][ 'lstDonantes' ][] = array(
						'anio'          => $row->anio,
						'idDonador'     => $row->idDonador,
						'nombre'        => $row->nombre,
						'telefono'      => $row->telefono,
						'email'         => $row->email,
						'idTipoEntidad' => $row->idTipoEntidad,
						'tipoEntidad'   => $row->tipoEntidad,
						'fechaIngreso'  => $row->fechaIngreso,
						'fechaFormato'  => $row->fechaFormato,
						
					);
					$lstDonadores[ $ixSolicitud ]['totalDonantes'] ++;
				}


			}

		}

		return $lstDonadores;
	}

	// FUNCIÓN GUARDAR NUEVO DONADOR
	function actualizarDonador($idDonador, $nombre, $telefono, $email, $idTipoEntidad, $fechaIngreso){
		$respuesta      = array();

		$_idDonador     = (int) $idDonador;
		$_nombre        = $this->con->real_escape_string( $nombre );
		$_telefono      = $this->con->real_escape_string( $telefono );
		$_email         = $this->con->real_escape_string( $email );
		$_fechaIngreso  = $this->con->real_escape_string( $fechaIngreso );
		$_idTipoEntidad = (int) $idTipoEntidad;
		$_idUsuario     = (int) $this->getIdUser();

		$sql = "CALL actualizarDonador($_idDonador,'{$_nombre}', '{$_telefono}', '{$_email}', {$_idTipoEntidad}, '2014-05-01', {$_idUsuario});";

		//echo $sql;

		if( $rs = $this->con->query( $sql ) ){
			// LIBERAR SIGUIENTE RESULTADO
			$this->con->next_result();
			$row = $rs->fetch_object();
			$this->mensaje   = $row->mensaje;
			$this->respuesta = (int) $row->respuesta;

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
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
			$this->respuesta = (int) $row->respuesta;

		}else{
			$this->mensaje   = "No se pudo ejecutar el procedimiento.";
			$this->respuesta = 0;
		}

		$respuesta = array( 'respuesta' => $this->respuesta, 'mensaje' => $this->mensaje );

		return $respuesta;
	}

}
?>