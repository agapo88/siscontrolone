<?php 
/**
* CLASE SESSION
*/
class Session
{
	
	// OBTENER ID DEL USUARIO
	function getIdUser()
	{
		return (int) $_SESSION['idUsuario'];
	}

	function getUsername(){
		return $_SESSION['username'];
	}

	function getIdPerfil(){
		return (int) $_SESSION['idPerfil'];
	}

	function getPerfil(){
		return $_SESSION['perfil'];
	}

}
?>