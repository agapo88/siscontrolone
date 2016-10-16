miApp.controller('ctrlProductos', function($scope, $http, $alert, $filter, $timeout){
	
	$scope.$parent.menu  = 'productos';

	$scope.lstFamilias   = [];
	$scope.lstGeneros    = [];
	$scope.lstAreas      = [];
	$scope.lstParentesco = [];

	$scope.filtro = "tipoProducto"

	$scope.producto = {};
	$scope.itemProducto = {};

	$scope.lstProductos = [];
	$scope.lstProveedores = [];

	$scope.tab = 1;


	$scope.$watch( 'filtro', function( _new, _old){
		console.log( _new, _old );
		if( _new != _old )
			$scope.consultarProductos();
	});

	// CARGAR LISTA DE PRODUCTOS
	$scope.consultarProductos = function(){
		$http.post('consultas.php',{accion: 'consultarProductos', filtro: $scope.filtro})
		.success(function(data){
			console.log(data);
			$scope.lstProductos = data.lstProductos;
		}).error(function(data){
			console.log(data);
		});
	}


	$scope.miembro = {
		nombres         : '',
		apellidos       : '',
		cui             : '',
		fechaNacimiento : '',
		idGenero        : null,
		parentesco      : '',
		idParentesco    : null,
	};

	($scope.cargarInicio = function(){
		$http.post('consultas.php', {accion: 'infoProducto'})
		.success(function( data ){
			$scope.consultarProductos();
		}).error(function(data){
			console.log(data);
		});
	})();

	// CARGAR LISTA DE PROVEEDORES
	$scope.cargarLstProveedores = function(){
		$http.post('consultas.php', {accion: 'cargarProveedores'}).success(function(data){
			console.log(data);
			$scope.lstProveedores = data.lstProveedores;
			
		}).error(function(data){
			console.log(data);
		});
	}

	// CARGAR LISTA DE PRODUCTOS
	$scope.cargarLstProductos = function(){
		$http.post('consultas.php', {accion: 'cargarProductos'}).success(function(data){
			console.log(data);
			$scope.lstProductos = data.lstProductos;
		}).error(function(data){
			console.log(data);
		});
	}


	// RESETEAR OBJETO
	$scope.resetObject = function(){
		$scope.miembro = {
			nombres         : '',
			apellidos       : '',
			cui             : '',
			fechaNacimiento : '',
			idGenero        : '',
			parentesco      : '',
			idParentesco    : null,
		};
	};

	// AGREGAR MIEMRBO A LA FAMILIA
	$scope.addMiembro = function(){

		var miembro = $scope.miembro;
		var error   = false;

		if( miembro.cui && !(miembro.cui.length == 13) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No. de <b>CUI<b> Invalido, debe tener 13 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.nombres.length > 2) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Nombre del familiar muy corto, debe tener minimo 3 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.apellidos.length > 2) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Apellidos del familiar son cortos, debe tener minimo 3 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.fechaNacimiento) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe ingresar la fecha de Nacimiento.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.idGenero) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe seleccionar el género.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.idParentesco) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe seleccionar un parentesco.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( miembro.idParentesco==9 && !(miembro.idParentesco.length > 2 ) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe ingresar el otro Parentesco.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}

		// SI NO EXISTE ERROR
		if( !error ){
			// AGREGA AL ARREGLO LOS VALORES DEL OBJETO
			$scope.familia.lstMiembros.push({
				nombres         : miembro.nombres,
				apellidos       : miembro.apellidos,
				cui             : miembro.cui,
				fechaNacimiento : miembro.fechaNacimiento,
				idGenero        : miembro.idGenero,
				parentesco      : miembro.parentesco,
				idParentesco    : miembro.idParentesco,
				lstOcupacion    : [],
			});
			$scope.resetObject();
			$scope.agregarMiembros = false;
		}
	};

	// QUITAR MIEMBRO DE LA LISTA
	$scope.removeMiembro = function( index ){
		$scope.familia.lstMiembros.splice( index, 1 );
	};


	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.donador = {
				nombre        : '',
				telefono      : '',
				email         : '',
				idTipoEntidad : null,
				fechaIngreso  : null
			};
	}


	var indice = null;
	$scope.openModalOficios = function( index ){
		console.log( index );
		indice = angular.copy( index );
	}


	// AGREGAR OCUPACIÓN
	$scope.agregarOficios = function(){
		console.log( $scope.familia.lstMiembros[ indice ] );

		$scope.familia.lstMiembros[ indice ].lstOcupacion.push({
			prueba : 'uno',
			dos    : 'dos',
			tres   : 'tres',
			cuatro : 'cuatro',
			cinco  : 'cinco'
		});
	}



	// CONSULTAR LISTA DONANTES
	$scope.consultarDonadores = function(){
		$http.post('consultas.php', {accion: 'cargarDonantes'})
		.success(function( data ){
			console.log( 'donantes', data );
			$scope.lstDonantes = data.lstDonantes;
		}).error(function(data){
			console.log(data);
		});
	}

	// GUARDAR DONADOR
	$scope.guardarFamilia = function(){

		var familia = $scope.familia;
		var error = false;

		if( !($scope.donador.nombre.length > 5)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Nombre del donador muy corto, debe tener minimo 5 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.donador.telefono.length > 3) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No de telefono corto, debe tener minimo 8 digitos.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.donador.email.length > 3) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Correo electronico Invalido, verifique.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.donador.idTipoEntidad) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el tipo de Donante.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.donador.fechaIngreso) ){

			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el tipo de Donante.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaIngreso = $filter('date')($scope.donador.fechaIngreso, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'guardarDonador', datos: $scope.donador, fechaIngreso: fechaIngreso})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.reset();
					$scope.consultarDonadores();
					$alert({title: 'Mensaje: ', content: data.mensaje, placement: 'top', type: 'success', show: true, duration: 4});
				}else{
					$alert({title: 'Error: ', content: data.mensaje, placement: 'top', type: 'danger', show: true, duration: 4});
				}
			}).error(function(data){
				console.log(data);
			});
			
		}
	}
	
});