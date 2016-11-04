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

	// GENERAR REPORTE PROVEEDORES/PRODUCTOS
	function reporteProveedorProducto(){
		$lstProProducto = array();

		$sql = "SELECT 
					    idTipoProducto,
					    tipoProducto,
					    idProducto,
					    producto,
					    esPerecedero,
					    idSeccionBodega,
					    cantidadMinima,
					    cantidadMaxima,
					    idProveedor,
					    proveedor,
					    telefono,
					    email
					FROM
					    vstProveedorProducto;";

		if( $rs = $this->con->query( $sql ) ){
			while( $row = $rs->fetch_object() ){

				$iProveedor = -1;
				$iProducto = -1;
				foreach ($lstProProducto as $ixProProducto => $proProducto) {
					if( $proProducto['idProveedor'] == $row->idProveedor ){
						$iProveedor = $ixProProducto;
						break;
					}
				}

				if( $iProveedor == -1 ){
					$iProveedor = count( $lstProProducto );
					$lstProProducto[$iProveedor] = array(
							'idProveedor'    => $row->idProveedor,
							'proveedor'      => $row->proveedor,
							'telefono'       => $row->telefono,
							'email'          => $row->email,
							'totalProductos' => 0,
							'lstProductos'   => array(),
						);
				}


				foreach ($lstProProducto[$iProveedor]['lstProductos'] AS $ixProducto => $producto) {
					if( $producto['idProducto'] == $row->idProducto ){
						$iProducto = $ixProducto;
						break;
					}
				}

				if( $iProducto == -1 ){

					$lstProProducto[$iProveedor]['lstProductos'][] = array(
							'idProducto'     => $row->idProducto,
							'producto'       => $row->producto,
							'tipoProducto'   => $row->tipoProducto,
							'cantidadMinima' => $row->cantidadMinima,
							'cantidadMaxima' => $row->cantidadMaxima,
							'esPerecedero'   => $row->esPerecedero ? 'Si': 'No'
						);
					$lstProProducto[$iProveedor]['totalProductos']++;
				}
			}
		}

		return $lstProProducto;
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
						'nombreFamilia' => strtoupper( $row->nombreFamilia ),
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
					'cantidad'    => number_format( $row->cantidad, 2 )
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

	// CONSULTAR BENEFICIADOS
	function consultarBeneficiados(){

		$sql = "SELECT 
			    idMiembro,
			    fechaNacimiento,
			    nombreFamilia,
			    fechaIngreso,
			    direccion,
			    idGenero,
			    edad
			FROM
			    vstMiembrosFamilia;";

	}


}
?>