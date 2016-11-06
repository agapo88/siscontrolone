miApp.controller('ctrlDesastres', function($scope, $http, $alert, $filter){
	
	$scope.$parent.menu = 'desastres';
	$scope.lstTiposDesastre = [];
	
	$scope.desastre = {
		desastre       : '',
		idTipoDesastre : null,
		fechaDesastre  : '',
	};

	($scope.cargarInicio = function(){
		$http.post('consultas.php', {accion: 'inicioDesastres'})
		.success(function( data ){
			console.log( 'tipos', data );
			$scope.lstTiposDesastre = data.lstTiposDesastre;
			$scope.consultarDesastres();
		}).error(function(data){
			console.log(data);
		});
	})();

	$scope.reset = function(){
		$scope.desastre = {
			desastre       : '',
			idTipoDesastre : null,
			fechaDesastre  : '',
		};
	}


	$scope.lstDesastres = [];
	$scope.consultarDesastres = function(){
		$http.post('consultas.php',{accion: 'consultarDesastres'})
		.success(function(data){
			console.log(data);
			$scope.lstDesastres = data.lstDesastres;
		}).error(function(data){
			console.log(data);
		});
	}


	// GUARDAR DONADOR
	$scope.guardarDesastre = function(){
		var error = false;

		if( !($scope.desastre.desastre && $scope.desastre.desastre.length > 5)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Nombre del desastre muy corto, debe tener minimo 5 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.desastre.idTipoDesastre) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el tipo de Desastre.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.desastre.fechaDesastre) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado la fecha del Desastre.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaDesastre = $filter('date')($scope.desastre.fechaDesastre, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'guardarDesastre', datos: $scope.desastre, fechaDesastre: fechaDesastre})
			.success(function(data){
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.reset();
					$scope.consultarDesastres();
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