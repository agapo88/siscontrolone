var miApp = angular.module('proyecto', ['ngRoute']);

miApp.controller('home', function($scope, $http){
	

	$scope.lstDatos = [];
	($scope.fnCargar = function(){
		$http.post('consultas.php', {accion: 'inicio'})
		.success(function( data ){
			console.log( data );
			$scope.lstDatos = data;
		}).error(function(data){
			console.log(data);
		});
	})();

	
});


miApp.config(function($routeProvider) {
	$routeProvider
	.when('/',{
		templateUrl : 'views/inicio.php'
	})
	.when('/ingresar',{
		templateUrl : 'ingresar.tema.php',
		controller : 'ctrlIngresar'
	})
	.when('/tema/:idTema', {
		templateUrl : 'tema.view.php',
		controller  : 'ctrlTema'
	})
	.when('/tag/:tag', {
		templateUrl : 'temas.php',
		controller  : 'ctrlTemas'
	})
	.otherwise({
		redirectTo: '/'
	});
});