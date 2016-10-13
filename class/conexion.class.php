<?php 
/**
* CONEXIÓN DB
*/

class Conexion extends mysqli
{

	private $server = 'localhost';
	private $user   = 'root';
	private $pass   = '';
	private $db     = 'db_siscontrolone';
	protected $con  = false;
	
	// INICIALIZAR EL CONSTRUCTOR CON DATOS DE LA BD
	function __construct()
	{
		if( !$this->con ){

			parent::__construct($this->server, $this->user, $this->pass, $this->db);
        	parent::set_charset( 'utf8' );

        	if( $this->connect_error )
            	die($this->connect_errno );
		}

	}


}


?>