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
    .when('/familias/:idFamilia', {
        templateUrl : 'views/form.miembros.php',
        controller  : 'ctrlFamilias'
    })
    .when('/donaciones', {
        templateUrl : 'views/form.donaciones.php',
        controller  : 'ctrlDonaciones'
    })
    .when('/donaciones/fondoComun', {
        templateUrl : 'views/form.fondo.comun.php',
        controller  : 'ctrlDonaciones'
    })
    .when('/productos', {
        templateUrl : 'views/form.producto.php',
        controller  : 'ctrlProductos'
    })
    .when('/proveedor', {
        templateUrl : 'views/form.proveedor.php',
        controller  : 'ctrlProveedor'
    })
    .when('/compras', {
        templateUrl : 'views/form.compras.php',
        controller  : 'ctrlCompras'
    })
    .when('/reportes', {
        templateUrl : 'views/form.reportes.php',
        controller  : 'ctrlReportes'
    })
    .when('/desastres', {
        templateUrl : 'views/form.desastres.php',
        controller  : 'ctrlDesastres'
    })
    .otherwise({
        redirectTo: '/'
    });
    
});