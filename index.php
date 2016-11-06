<!DOCTYPE html>
<html ng-app="proyecto" lang="es-GT">
<head>
	<title>Proyecto</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/ngstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body ng-controller="home">
<?php 
	include 'include/menu.php';
?>
	<div class="principal">
		<!-- VISTA -->
		<div ng-view></div>
	</div>

	<!-- LIBRERIAS -->
	<script type="text/javascript" src="js/libs/jquery-1.12.1.min.js"></script>
	<script type="text/javascript" src="js/libs/angular.min.js"></script>
	<script type="text/javascript" src="js/libs/angular-route.min.js"></script>
	<script type="text/javascript" src="js/libs/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/libs/ngstrap.js"></script>
	<script type="text/javascript" src="js/libs/dirPagination.js"></script>

	<!-- CONTROLADORES -->
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/route.js"></script>
	<script type="text/javascript" src="js/ctrlDonador.js"></script>
	<script type="text/javascript" src="js/ctrlFamilias.js"></script>
	<script type="text/javascript" src="js/ctrlDonaciones.js"></script>
	<script type="text/javascript" src="js/ctrlProductos.js"></script>
	<script type="text/javascript" src="js/ctrlCompras.js"></script>
	<script type="text/javascript" src="js/ctrlProveedor.js"></script>
	<script type="text/javascript" src="js/ctrlReportes.js"></script>
</body>
</html>