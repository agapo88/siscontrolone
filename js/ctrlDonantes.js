miApp.controller('ctrlDonantes', function($scope, $http){
	
	$scope.lstDonantes = [];

	($scope.fnCargar = function(){
		$http.post('consultas.php', {accion: 'cargarDonantes'})
		.success(function( data ){
			console.log( data );
			$scope.lstDatos = data;
		}).error(function(data){
			console.log(data);
		});
	})();

	
});