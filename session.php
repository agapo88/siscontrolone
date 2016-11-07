<?php 
require_once 'class/conexion.class.php';

$conexion = new Conexion();

function crearSession( $username ){
	global $conexion;
	$sql = "SELECT u.idPerfil, perfil, idUsuario, username
				FROM perfil AS p
					JOIN usuario AS u
						ON p.idPerfil = u.idPerfil
				WHERE username = '{$username}'";

	if( $rs = $conexion->query( $sql )  ){
		if( $row = $rs->fetch_object() ){
			$_SESSION['idPerfil']  = (int) $row->idPerfil;
			$_SESSION['perfil']    = $row->perfil;
			$_SESSION['idUsuario'] = (int) $row->idUsuario;
			$_SESSION['username']  = $row->username;
		}
	}
}


?>