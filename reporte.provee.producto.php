<?php 
session_start();
require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
include 'class/reportes.class.php';

$conexion = new Conexion();
$reporte = new Reporte( $conexion );

// header('Content-type: application/ms-excel');	
// header('Content-Disposition: attachment; filename=reporte-productos.xls');

/* FECHA INICIO
$fechaInicio = str_replace('/', '-', $_POST['fechaInicio']);
$fechaInicio = explode('-', $fechaInicio );
$fechaInicio = $fechaInicio[2].'-'.$fechaInicio[1].'-'.$fechaInicio[0];

// FECHA FINAL
$fechaFinal = str_replace('/', '-', $_POST['fechaFinal']);
$fechaFinal = explode('-', $fechaFinal );
$fechaFinal = $fechaFinal[2].'-'.$fechaFinal[1].'-'.$fechaFinal[0];
*/

$lstProductoProv = array();
$lstProductoProv = $reporte->reporteProveedorProducto();

/*
echo "<pre>";
	var_dump( $lstProductoProv );
echo "</pre>";
*/
?>
<table border="1">
	<thead>

	</thead>
	<tbody>
<?php

foreach ($lstProductoProv AS $ixProveedor => $proveedor){
	echo "
	<tr>
		<td style='font-weight: bold' colspan='3'>PROVEEDOR: {$proveedor['proveedor']}</td>
		<td style='text-align: center; font-weight: bold'>TELEFONO: {$proveedor['telefono']}</td>
		<td style='text-align: center; font-weight: bold'>CORREO: {$proveedor['email']}</td>
	</tr>
	";

	echo "
	<tr style='background: #2196f3; color: white'>
		<th>ID Producto.</th>
		<th>PRODUCTO</th>
		<th>CANTIDAD MINIMA</th>
		<th>CANTIDAD MÁXIMA</th>
		<th>PRODUCTO PERECEDERO</th>
	</tr>";
	foreach ($proveedor['lstProductos'] AS $ixProducto => $producto) {

		echo "
		<tr>
			<td style='text-align: center'>{$producto['idProducto']}</td>
			<td style='text-align: center'>{$producto['producto']}</td>
			<td style='text-align: center'>{$producto['cantidadMinima']}</td>
			<td style='text-align: center'>{$producto['cantidadMaxima']}</td>
			<td style='text-align: center'>{$producto['esPerecedero']}</td>
		</tr>
		";	
		
	}
}

?>
	</tbody>
</table>