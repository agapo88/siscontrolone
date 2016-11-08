<style type="text/css" media="screen">

	.row{
		margin: 30px;
	}

</style>
<?php
	session_start();
	include '../class/session.class.php';
	$session = new Session();
?>
<div class="row">
	<legend>
		<span class="glyphicon glyphicon-th-large"></span> MENU
		<span class="badge" style="font-size: 14px"><?php echo $session->getPerfil(); ?></span>
	</legend>

	<?php
		if( $session->getIdPerfil() == 1 || $session->getIdPerfil() == 2 ){
	?>
		<a href="#/familias">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-user"></span>
						<h4>
							<span class="badge">FAMILIAS</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

		<a href="#/donantes">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-globe"></span>
						<h4>
							<span class="badge">DONADORES</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

		<a href="#/donaciones">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-piggy-bank"></span>
						<h4>
							<span class="badge">DONACIONES</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

		<a href="#/">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-folder-open"></span>
						<h4>
							<span class="badge">SEGUIMIENTO</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

	<?php
		}
		if( $session->getIdPerfil() == 1 || $session->getIdPerfil() == 3 ){
	?>

			<a href="#/compras">
				<div class="col-sm-4 col-md-3 col-lg-2">
					<div class="panel-menu">
						<div class="panel-heading text-center">
							<span style="font-size: 40px;" class="glyphicon glyphicon-shopping-cart"></span>
							<h4>
								<span class="badge">COMPRAS</span>
							</h4>
						</div>
						<div class="panel-footer text-center">
							INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
						</div>
					</div>
				</div>
			</a>

			<a href="#/proveedor">
				<div class="col-sm-4 col-md-3 col-lg-2">
					<div class="panel-menu">
						<div class="panel-heading text-center">
							<span style="font-size: 40px;" class="glyphicon glyphicon-phone-alt"></span>
							<h4>
								<span class="badge">PROVEEDORES</span>
							</h4>
						</div>
						<div class="panel-footer text-center">
							INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
						</div>
					</div>
				</div>
			</a>
			
			<a href="#/productos">
				<div class="col-sm-4 col-md-3 col-lg-2">
					<div class="panel-menu">
						<div class="panel-heading text-center">
							<span style="font-size: 40px;" class="glyphicon glyphicon-shopping-cart"></span>
							<h4>
								<span class="badge">PRODUCTOS</span>
							</h4>
						</div>
						<div class="panel-footer text-center">
							INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
						</div>
					</div>
				</div>
			</a>

			<a href="#/productos">
				<div class="col-sm-4 col-md-3 col-lg-2">
					<div class="panel-menu">
						<div class="panel-heading text-center">
							<span style="font-size: 40px;" class="glyphicon glyphicon-shopping-cart"></span>
							<h4>
								<span class="badge">HISTORIAL</span>
							</h4>
						</div>
						<div class="panel-footer text-center">
							INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
						</div>
					</div>
				</div>
			</a>
			
	<?php
		}
		if( $session->getIdPerfil() == 1 ){
	?>
		<a href="#/desastres">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-flag"></span>
						<h4>
							<span class="badge">DESASTRES</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

		<a href="#/reportes">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-list-alt"></span>
						<h4>
							<span class="badge">REPORTES</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

		<a href="#/usuario">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-lock"></span>
						<h4>
							<span class="badge">USUARIOS</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>

		<a href="#/usuario">
			<div class="col-sm-4 col-md-3 col-lg-2">
				<div class="panel-menu">
					<div class="panel-heading text-center">
						<span style="font-size: 40px;" class="glyphicon glyphicon-cog"></span>
						<h4>
							<span class="badge">ADMINISTRAR</span>
						</h4>
					</div>
					<div class="panel-footer text-center">
						INGRESAR <span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</div>
			</div>
		</a>
	<?php
		}
	?>

</div>


<footer class="text-center">
	<address>
	  	<strong>ONG TODOS SOMOS UNO</strong><br>
	  	Guatemala, C.A<br>
	  	<abbr title="Phone">Tel:</abbr> (502) 7767-1116<br>
	  	<abbr title="Phone">Cel:</abbr> (502) 5045-7895<br>
	</address>
</footer>