miApp.config(function($routeProvider) {
	$routeProvider
	.when('/',{
		templateUrl : 'views/inicio.php'
	})
	.when('/donantes',{
		templateUrl : 'views/donantes.php',
		controller : 'ctrlDonantes'
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