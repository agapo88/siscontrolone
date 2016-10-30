miApp.controller('ctrlProductos', function($scope, $http, $alert){
	
	$scope.$parent.menu     = 'productos';
	$scope.filtro           = "tipoProducto";
	$scope.producto         = {};
	$scope.itemProducto     = {};
	$scope.lstAreas         = [];
	$scope.lstProductos     = [];
	$scope.lstSeccionBodega = [];

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
		cantidadMinima  : 0,
		cantidadMaxima  : 0,
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

	$scope.lstDetalleProducto = {
		lstProductos: []
	};
	$scope.consultarDetalleProducto = function( idProducto ){
		$http.post('consultas.php',{accion: 'consultarDetalleProducto', idProducto: idProducto})
		.success(function(data){
			console.log(data);
			$scope.lstDetalleProducto = data.lstDetalleProducto;
			if( $scope.lstDetalleProducto.lstProductos.length > 0 )
				$('#detalleProducto').modal('show');
			else
				$alert({title: 'Notificación: ', content: 'No se encontrarón productos disponibles.', placement: 'top', type: 'info', show: true, duration: 4});
		}).error(function(data){
			console.log(data);
		});
	};


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

	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.producto = {
			producto        : '',
			idSeccionBodega : null,
			idTipoProducto  : null,
			perecedero      : false,
			cantidadMinima  : 0,
			cantidadMaxima  : 0,
			observacion     : ''
		};
	};

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
		else if( !(producto.cantidadMinima > 0)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado la cantidad Mínima.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(producto.cantidadMaxima > 0 && producto.cantidadMaxima >= producto.cantidadMinima)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'La Cantidad máxima es menor a la cantidad Minima.', placement: 'top', type: 'warning', show: true, duration: 4});
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