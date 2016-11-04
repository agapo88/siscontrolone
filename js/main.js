var miApp = angular.module('proyecto', ['mgcrea.ngStrap','ngRoute','angularUtils.directives.dirPagination'], ['$provide', function($provide) {
    var PLURAL_CATEGORY = {ZERO: "zero", ONE: "one", TWO: "two", FEW: "few", MANY: "many", OTHER: "other"};
    $provide.value("$locale", {
            "DATETIME_FORMATS": {
                "AMPMS": [
                    "AM",
                    "PM"
                ],
            "DAY": [
                "Dom","Lun","Mar","Mie","Jue","Vie","Sab"
            ],
            "MONTH": ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre",
                "octubre","noviembre","diciembre"
            ],
            "SHORTDAY": [
                "Dom","Lun","Mar","Mie","Jue","Vie","Sab"
            ],
            "SHORTMONTH": [
                "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sept","Oct","Nov","Dic"
            ],
            "fullDate"  : "EEEE d MMMM y",
            "longDate"  : "d MMMM y",
            "medium"    : "d MMM y HH:mm:ss",
            "mediumDate": "d MMM y",
            "mediumTime": "HH:mm:ss",
            "short"     : "dd/MM/yy HH:mm",
            "shortDate" : "dd/MM/yy",
            "shortTime" : "HH:mm:ss"
        },

        "NUMBER_FORMATS": {
        "CURRENCY_SYM": ",",
        "DECIMAL_SEP": ".",
        "GROUP_SEP": ",",
        "PATTERNS": [
        {
            "gSize": 3,
            "lgSize": 3,
            "macFrac": 0,
            "maxFrac": 3,
            "minFrac": 0,
            "minInt": 1,
            "negPre": "-",
            "negSuf": "",
            "posPre": "",
            "posSuf": ""
        },
        {
            "gSize": 3,
            "lgSize": 3,
            "macFrac": 0,
            "maxFrac": 2,
            "minFrac": 2,
            "minInt": 1,
            "negPre": "(",
            "negSuf": "\u00a0\u00a4)",
            "posPre": "",
            "posSuf": "\u00a0\u00a4"
        }
    ]
    },
        "id": "es-es",
        "pluralCat": function (n) { 
         if (n >= 0 && n <= 2 && n != 2) {   return PLURAL_CATEGORY.ONE;  }  return PLURAL_CATEGORY.OTHER;
        }
    });
}]);


miApp.config(function($alertProvider) {
  angular.extend($alertProvider.defaults, {
    animation: 'am-fade-and-slide-top',
    placement: 'top'
  });
});


miApp.controller('home', function($scope, $http){

	$scope.menu = 'inicio';
    
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

    // OCULTAR VENTANA MODAL AGREGAR
    $scope.hideModalAgregar = function(){
        $('#modalAgregar').modal('hide');
    }

    // OCULTAR VENTANA MODAL AGREGAR
    $scope.hideModalEditar = function(){
        $('#modalEditar').modal('hide');
    }
    

	
});