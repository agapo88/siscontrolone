<?php 
/**
* CLASE SESSION
*/
class Session
{
	
	// OBTENER ID DEL USUARIO
	function getIdUser()
	{
		return (int) $_SESSION['idUser'];
	}

	function getUsername(){
		return $_SESSION['username'];
	}


}
?>