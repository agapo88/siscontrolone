miApp.controller('ctrlDonador', function($scope, $http, $alert, $filter){
	
	$scope.$parent.menu = 'donantes';

	$scope.lstEntidades = [];
	$scope.lstTipoEntidad = [];
	
	$scope.donador = {
		nombre        : '',
		telefono      : '',
		email         : '',
		idTipoEntidad : null,
		fechaIngreso  : null
	};

	$scope.filtro = 'tipoEntidad';

	$scope.$watch( 'filtro', function( _new, _old){
		console.log( _new, _old );
		if( _new != _old )
			$scope.consultarDonadores();
	});

	($scope.cargarInicio = function(){
		$http.post('consultas.php', {accion: 'cargarCatDonantes'})
		.success(function( data ){
			console.log( 'donantes', data );
			$scope.lstTipoEntidad = data.lstTipoEntidad;
			$scope.consultarDonadores();
		}).error(function(data){
			console.log(data);
		});
	})();

	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.donador = {
				nombre        : '',
				telefono      : '',
				email         : '',
				idTipoEntidad : null,
				fechaIngreso  : null
			};
		$scope.itemDonador = {};
	}

	// CONSULTAR LISTA DONANTES
	$scope.consultarDonadores = function(){
		$http.post('consultas.php', {accion: 'cargarDonantes', filtro: $scope.filtro})
		.success(function( data ){
			console.log( 'donantes', data );
			$scope.lstEntidades = data.lstEntidades;
		}).error(function(data){
			console.log(data);
		});
	};

	$scope.editarDonador = function( donador ){
		$scope.itemDonador = angular.copy( donador );
		$('#modalEditar').modal('show');
	}

	// ACTUALIZAR DONADOR
	$scope.actualizarDonador = function(){
		var error = false;

		if( !($scope.itemDonador.nombre && $scope.itemDonador.nombre.length > 5)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Nombre del donador muy corto, debe tener minimo 5 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.itemDonador.telefono && $scope.itemDonador.telefono.length > 3) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No de telefono corto, debe tener minimo 8 digitos.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.itemDonador.email && $scope.itemDonador.email.length > 3) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Correo electronico Invalido, verifique.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.itemDonador.idTipoEntidad) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el tipo de Donante.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.itemDonador.fechaIngreso) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el tipo de Donante.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaIngreso = $filter('date')($scope.itemDonador.fechaIngreso, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'actualizarDonador', datos: $scope.itemDonador, fechaIngreso: fechaIngreso})
			.success(function(data){
				console.log( data );
				if( data.respuesta ){
					$scope.$parent.hideModalEditar();
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
	};

	// GUARDAR DONADOR
	$scope.guardarDonador = function(){
		var error = false;

		if( !($scope.donador.nombre && $scope.donador.nombre.length > 5)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Nombre del donador muy corto, debe tener minimo 5 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.donador.telefono && $scope.donador.telefono.length > 3) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No de telefono corto, debe tener minimo 8 digitos.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.donador.email && $scope.donador.email.length > 3) ){
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
	};
	
});