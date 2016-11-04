<?php 
session_start();
require_once 'class/conexion.class.php';
require_once 'class/session.class.php';
include 'class/reportes.class.php';

$conexion = new Conexion();
$reporte = new Reporte( $conexion );

header('Content-type: application/ms-excel');	
header('Content-Disposition: attachment; filename=reporte-productos.xls');

$lstDonacionesFam = array();
$lstDonacionesFam = $reporte->verDonacionesFamilia();


?>
<table border="1">
	<thead>
		<tr>
			<th colspan="5" style="background: #ff5722; color: white">
				LISTADO DE AYUDAS POR FAMILIA
			</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($lstDonacionesFam as $ixDonacion => $donacion) {
	echo "
		<tr>
			<td colspan='5' style='background: #3f51b5; color: white; font-weight: bold; text-align: center;'>{$donacion['nombreFamilia']}</td>
		</tr>
	";
	foreach ($donacion['lstDesastres'] AS $ixDesastre => $desastre) {
		echo "
			<tr>
				<td colspan='2'><b>Desastre:</b> {$desastre['desastre']}</td>
				<td colspan='2'><b>Tipo Desastre:</b> {$desastre['tipoDesastre']}</td>
				<td><b>Total Recibido:</b> {$desastre['totalGeneral']}</td>
			</tr>
		";

		foreach ($desastre['lstAnio'] as $ixAnio => $anio) {
			echo "
				<tr>
					<td colspan='5' style='text-align: right; font-weight: bold; '>Año {$anio['anio']}</td>
				</tr>
			";
			foreach ($anio['lstMeses'] as $ixMes => $mes) {
				echo "
					<tr>
						<td>{$mes['idDonador']}</td>
						<td>{$mes['nombre']}</td>
						<td style='text-align: center;'>{$mes['tipoEntidad']}</td>
						<td style='text-align: center;'>{$mes['mes']}</td>
						<td style='text-align: right;'>{$mes['cantidad']}</td>
					</tr>
				";	
			}
		}
		
	}
}

?>
	</tbody>
</table>