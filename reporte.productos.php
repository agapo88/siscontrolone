<?php 
session_start();
require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
include 'class/reportes.class.php';

$conexion = new Conexion();
$reporte = new Reporte( $conexion );

header('Content-type: application/ms-excel');	
header('Content-Disposition: attachment; filename=reporte-productos.xls');

// FECHA INICIO
$fechaInicio = str_replace('/', '-', $_POST['fechaInicio']);
$fechaInicio = explode('-', $fechaInicio );
$fechaInicio = $fechaInicio[2].'-'.$fechaInicio[1].'-'.$fechaInicio[0];

// FECHA FINAL
$fechaFinal = str_replace('/', '-', $_POST['fechaFinal']);
$fechaFinal = explode('-', $fechaFinal );
$fechaFinal = $fechaFinal[2].'-'.$fechaFinal[1].'-'.$fechaFinal[0];

$lstProductos = array();
$lstProductos = $reporte->consultarDetalleProducto( $fechaInicio, $fechaFinal );

?>
<table border="1">
	<thead>
		<tr style="background: green; color: white">
			<th>No. Producto</th>
			<th>Producto</th>
			<th>Fecha de Adquisición</th>
			<th>Cantidad Disponible</th>
			<th>Tipo de Producto</th>
			<th>Fecha de Vencimiento</th>
			<th>Meses Para Vencer</th>
			<th>Sección de Bodega</th>
			<th>Observaciones</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($lstProductos AS $ixProducto => $producto) {
		echo "<tr>
			<td style='text-align: center'>{$producto->idProducto}</td>
			<td style='text-align: center'>{$producto->producto}</td>
			<td style='text-align: center'>{$producto->fechaAdquisicion}</td>
			<td style='text-align: center'>{$producto->cantidadDisponible}</td>
			<td style='text-align: center'>{$producto->tipoProducto}</td>
			<td style='text-align: center'>{$producto->fechaVencimiento}</td>
			<td style='text-align: center'>{$producto->mesVencimiento}</td>
			<td style='text-align: center'>{$producto->seccionBodega}</td>
			<td style='text-align: center'>{$producto->observacion}</td>
		</tr>";
}

?>
	</tbody>
</table>