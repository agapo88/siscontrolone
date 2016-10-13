miApp.controller('ctrlDonantes', function($scope, $http){
	
	$scope.lstDonantes = [];

	

	$scope.donador = {
		nombre        : '',
		telefono      : '',
		email         : '',
		idTipoEntidad : null,
		fechaIngreso  : null
	};

	($scope.fnCargar = function(){
		$http.post('consultas.php', {accion: 'cargarDonantes'})
		.success(function( data ){
			console.log( 'donantes', data );
			$scope.lstDonantes = data.lstDonantes;
		}).error(function(data){
			console.log(data);
		});
	})();

	
});