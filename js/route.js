miApp.config(function($routeProvider) {
	$routeProvider
	.when('/',{
		templateUrl : 'views/inicio.php'
	})
	.when('/donantes',{
		templateUrl : 'views/donantes.php',
		controller : 'ctrlDonador'
	})
	.when('/familias', {
		templateUrl : 'views/form.familias.php',
		controller  : 'ctrlFamilias'
	})
	.when('/donaciones', {
		templateUrl : 'views/form.donaciones.php',
		controller  : 'ctrlDonaciones'
	})
	.when('/tema/:idTema', {
		templateUrl : 'tema.view.php',
		controller  : 'ctrlTema'
	})
	.otherwise({
		redirectTo: '/'
	});
});