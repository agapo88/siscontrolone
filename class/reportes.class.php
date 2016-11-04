<?php
/**
* REPORTES
*/
class Reporte
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// GENERAR DETALLE DE APORTES POR FAMILIAS
	function verDonacionesFamilia( $idFamilia = null){

		$lstAyudasRecibidas = array();
		$filtro = "";
		if( isset( $idFamilia ) )
			$filtro = " WHERE idFamilia = {$idFamilia}";

		$sql = "SELECT 
				    *
					FROM
					    vstAportePadrinos $filtro";

		if( $rs = $this->con->query($sql ) ){
			while( $row = $rs->fetch_object() ){
				
				$iAnio     = -1;
				$iMes      = -1;
				$iDesastre = -1;
				$iFamilia  = -1;

				foreach ($lstAyudasRecibidas AS $ixAyudaRecibida => $ayudaRecibida) {
					if( $ayudaRecibida['idFamilia'] == $row->idFamilia ){
						$iFamilia = $ixAyudaRecibida;
						break;
					}
				}

				if( $iFamilia == -1 ){
					$iFamilia = count( $lstAyudasRecibidas );
					$lstAyudasRecibidas[ $iFamilia ] = array(
						'idFamilia'     => $row->idFamilia,
						'nombreFamilia' => $row->nombreFamilia,
						'lstDesastres'  => array(),
					);
				}

				foreach ($lstAyudasRecibidas[ $iFamilia ]['lstDesastres'] AS $ixDesastre => $desastre) {
					if( $desastre['idDesastre'] == $row->idDesastre ){
						$iDesastre = $ixDesastre;
						break;
					}
				}

				if( $iDesastre == -1 ){
					$iDesastre = count ( $lstAyudasRecibidas[ $iFamilia ]['lstDesastres']);
					$lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ] = array(
						'idDesastre'     => $row->idDesastre,
						'desastre'       => $row->desastre,
						'idTipoDesastre' => $row->idTipoDesastre,
						'tipoDesastre'   => $row->tipoDesastre,
						'totalGeneral'   => 0,
						'lstAnio'        => array(),
					);
				}


				foreach ($lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ][ 'lstAnio' ] AS $ixAnio => $anio) {
					if( $anio['anio'] == $row->anio ){
						$iAnio = $ixAnio;
						break;
					}
				}

				if( $iAnio == -1 ){
					
					$iAnio = count ( $lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ][ 'lstAnio' ]);
					$lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ][ 'lstAnio' ][ $iAnio ] = array(
						'anio'          => $row->anio,
						'lstMeses'      => array(),
						'totalRecibido' => 0,
					);
				}

				$lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ][ 'lstAnio' ][ $iAnio ][ 'lstMeses' ][] = 
				array(
					'idDonador'   => $row->idDonador,
					'nombre'      => $row->nombre,
					'tipoEntidad' => $row->tipoEntidad,
					'idMes'       => $row->idMes,
					'mes'         => $row->mes,
					'cantidad'    => (int) $row->cantidad
					);				

				$lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ][ 'lstAnio' ][ $iAnio ]['totalRecibido'] += (int) $row->cantidad;

				$lstAyudasRecibidas[ $iFamilia ]['lstDesastres'][ $iDesastre ]['totalGeneral'] += (int) $row->cantidad;
			}
		}

		return $lstAyudasRecibidas;
	}


	// CONSULTAR PRODUCTOS POR VENCER
	function consultarDetalleProducto( $fechaInicio, $fechaFinal ){
		$lstProductosVen = array();

		$sql = "SELECT 
					    idProducto,
					    producto,
					    DATE_FORMAT(fechaAdquisicion, '%d/%m/%Y') AS fechaAdquisicion,
					    DATE_FORMAT(fechaCaducidad, '%d/%m/%Y') AS fechaVencimiento,
					    esPerecedero,
					    mesVencimiento,
					    cantidadDisponible,
					    precioUnitario,
					    observacion,
					    seccionBodega,
					    tipoProducto,
                        idTipoProducto
					FROM
					    vstControlCompras
					WHERE esPerecedero = 1 AND fechaCaducidad BETWEEN '{$fechaInicio}' AND '{$fechaFinal}'";

		if( $rs = $this->con->query($sql) ){
			while( $row = $rs->fetch_object() ){
				$lstProductosVen[] = $row;
			}
		}

		return $lstProductosVen;
	}


}
?>