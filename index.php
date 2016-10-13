<!DOCTYPE html>
<html ng-app="proyecto" lang="es-GT">
<head>
	<title>Proyecto</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body ng-controller="home">
<?php 
	include 'include/menu.php';
?>
	<!-- VISTA -->
	<div ng-view></div>

	<!-- LIBRERIAS -->
	<script type="text/javascript" src="js/libs/jquery-1.12.1.min.js"></script>
	<script type="text/javascript" src="js/libs/angular.min.js"></script>
	<script type="text/javascript" src="js/libs/angular-route.min.js"></script>
	<script type="text/javascript" src="js/libs/bootstrap.min.js"></script>

	<!-- CONTROLADORES -->
	<script type="text/javascript" src="js/main.js"></script>

</body>
</html>