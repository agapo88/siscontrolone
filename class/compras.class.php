<?php 

/**
* COMPRAS
*/
class Compra extends Session
{
	
	private $con;
	private $respuesta = 0;
	private $mensaje   = "";
	private $error   = false;

	function __construct( &$conexion )
	{
		$this->con = $conexion;
	}	


	// FUNCION PARA CONSULTAR DONANTES EN LA BD
	function guardarCompras(){
		global $data;

		//var_dump( $data );
		$_fechaIngreso = $data->fechaIngreso;
		$_noFactura    = (int) $data->datos->noFactura;
		$_idMoneda     = (int) $data->datos->idMoneda;

		// VERIFICAR QUE LAS LISTAS VENGAN CON DATOS
		if( !(count($data->datos->lstProductos)) ){
			$this->error     = true;
			$this->mensaje   = "No se recibieron listas de productos";
			$this->respuesta = 0;
		}

		if( !$this->error ){

			$this->con->query( "START TRANSACTION" );
			$sql = "CALL agregarCompraDonacion(NULL,'{$_fechaIngreso}', {$_noFactura}, {$_idMoneda}, {$this->getIdUser()});";

//			echo $sql;

			if( $rs = $this->con->query( $sql ) ){
				$this->con->next_result();
				$row = $rs->fetch_object();

				$this->respuesta = (int) $row->respuesta;
				$this->mensaje   = (int) $row->mensaje;
				if( $this->respuesta ){

					$idCompraDonacion = (int) $row->idCompraDonacion;

					if( count($data->datos->lstProductos) ){
						$this->ingresarCompras( $idCompraDonacion, $data->datos->lstProductos );
					}

				}else{
					$this->con->next_result();
					$this->error = true;
				}
			}
		}

		if( $this->error ){
			$this->con->query( "ROLLBACK" );
		}else{
			$this->con->query( "COMMIT" );
			//$this->mensaje = "";
		}


		$respuesta = array('respuesta' => $this->respuesta, 'mensaje' => $this->mensaje);
		return $respuesta;
	}


	// FUNCIÓN INGRESAR COMPRAS
	function ingresarCompras( $idCompraDonacion, $lstCompras){

		foreach ($lstCompras AS $ixCompra => $compra) {
			
			if( empty($compra->fechaCaducidad) )
				$compra->fechaCaducidad = 'NULL';
			else
				$compra->fechaCaducidad = "'".$compra->fechaCaducidad ."'";

			$sql = "CALL adquisionProducto ({$idCompraDonacion}, {$compra->idProducto}, {$compra->idProveedor}, $compra->cantidad, $compra->precioUnitario, $compra->fechaCaducidad );";

			//echo $sql;

			if( $rs = $this->con->query( $sql) ){
				$this->con->next_result();
				$row = $rs->fetch_object();	

				$this->respuesta = (int) $row->respuesta;
				$this->mensaje   = $row->mensaje;
				if( !$this->respuesta )
					$this->error = true;

			}else{
				$this->error     = true;
				$this->mensaje   = "Error al ejecutar el procedimiento de Productos.";
			}
			
			if ( $this->error )
				break;
			
		}
	}


}
?>