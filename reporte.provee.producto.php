<?php 
session_start();
require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
require_once 'class/reportes.class.php';

$conexion = new Conexion();
$reporte  = new Reporte( $conexion );

header('Content-type: application/ms-excel');	
header('Content-Disposition: attachment; filename=reporte-proveedores.xls');

$lstProductoProv = array();
$lstProductoProv = $reporte->reporteProveedorProducto();
?>

<table border="1">
	<thead>
		<tr>
			<td colspan="5" style='background: #163c5a; color: white; text-align: center; font-weight: bold' >
				LISTADO DE PROVEEDORES Y PRODUCTOS
			</td>
		</tr>
	</thead>
	<tbody>
<?php

foreach ($lstProductoProv AS $ixProveedor => $proveedor){
	echo "
	<tr>
		<td style='font-weight: bold' colspan='2'>{$proveedor['proveedor']}</td>
		<td style='text-align: center; font-weight: bold'>Telefono: {$proveedor['telefono']}</td>
		<td style='text-align: center; font-weight: bold'>Correo: {$proveedor['email']}</td>
		<td style='text-align: center; font-weight: bold'>TOTAL/PROD: {$proveedor['totalProductos']}</td>
	</tr>
	";

	echo "
	<tr >
		<th style='background: #2196f3; color: white'>ID Producto.</th>
		<th style='background: #2196f3; color: white'>PRODUCTO</th>
		<th style='background: #2196f3; color: white'>TIPO PRODUCTO</th>
		<th style='background: #2196f3; color: white'>CANTIDAD MIN/MAX</th>
		<th style='background: #2196f3; color: white'>PRODUCTO PERECEDERO</th>
	</tr>";
	foreach ($proveedor['lstProductos'] AS $ixProducto => $producto) {
		echo "
		<tr>
			<td style='text-align: center'>{$producto['idProducto']}</td>
			<td style='text-align: center'>{$producto['producto']}</td>
			<td style='text-align: center'>{$producto['tipoProducto']}</td>
			<td style='text-align: center'>{$producto['cantidadMinima']} / {$producto['cantidadMaxima']}</td>
			<td style='text-align: center'>{$producto['esPerecedero']}</td>
		</tr>
		<tr>
			<td colspan='5'>
		</tr>
		";
	}
}

?>
	</tbody>
</table>