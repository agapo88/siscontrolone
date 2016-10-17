miApp.controller('ctrlProductos', function($scope, $http, $alert, $filter, $timeout){
	
	$scope.$parent.menu  = 'productos';
	$scope.lstAreas      = [];

	$scope.filtro           = "tipoProducto"
	$scope.producto         = {};
	$scope.itemProducto     = {};
	$scope.lstProductos     = [];
	$scope.lstProveedores   = [];
	$scope.lstSeccionBodega = [];
	$scope.tab              = 1;

	$scope.$watch( 'filtro', function( _new, _old){
		if( _new != _old ){
			$scope.consultarProductos();
		}
	});

	$scope.producto = {
		producto        : '',
		idSeccionBodega : null,
		idTipoProducto  : null,
		perecedero      : false,
		observacion     : ''
	};


	// CARGAR LISTA DE PRODUCTOS
	($scope.consultarProductos = function(){
		$http.post('consultas.php',{accion: 'consultarProductos', filtro: $scope.filtro})
		.success(function(data){
			console.log(data);
			$scope.lstProductos = data.lstProductos;
		}).error(function(data){
			console.log(data);
		});
	})();


	($scope.cargarAreasBodega = function(){
		$http.post('consultas.php', {accion: 'cargarSeccionBodega'})
		.success(function(data){
			console.log(data);
			$scope.lstSeccionBodega = data.lstSeccionBodega;
		}).error(function(data){
			console.log(data);
		});
	})();

	($scope.cargarTiposProducto = function(){
		$http.post('consultas.php', {accion: 'cargarTiposProducto'})
		.success(function(data){
			console.log(data);
			$scope.lstTiposProducto = data.lstTiposProducto;
		}).error(function(data){
			console.log(data);
		});
	})();

	$scope.catProductos = [];
	// CARGAR CATEGORÍA DE PRODUCTOS
	($scope.cargarCatProductos = function(){
		$http.post('consultas.php', {accion: 'categoriaProductos'})
		.success(function(data){
			console.log(data);
			$scope.catProductos = data.catProductos;
		}).error(function(data){
			console.log(data);
		});
	})();


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

	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.producto = {
			producto        : '',
			idSeccionBodega : null,
			idTipoProducto  : null,
			perecedero      : false,
			observacion     : ''
		};
	};

	var indice = null;
	$scope.openModalOficios = function( index ){
		console.log( index );
		indice = angular.copy( index );
	}

	// GUARDAR DONADOR
	$scope.guardarProducto = function(){

		var producto = $scope.producto;
		var error = false;

		if( !(producto.idSeccionBodega) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el Area de bodega.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(producto.idTipoProducto) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el tipo de producto.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(producto.producto.length > 3)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Nombre del producto muy corto, debe tener minimo 4 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			$http.post('consultas.php', {accion: 'guardarProducto', datos: $scope.producto})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.reset();
					$scope.consultarProductos();
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