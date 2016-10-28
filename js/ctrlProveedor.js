miApp.controller('ctrlProveedor', function($scope, $http, $alert){
	
	/*
	$scope.$parent.menu     = 'productos';
	$scope.filtro           = "tipoProducto";
	$scope.producto         = {};
	$scope.itemProducto     = {};
	$scope.lstAreas         = [];
	$scope.lstSeccionBodega = [];
*/
	$scope.lstProductos   = [];
	$scope.lstProveedores = [];

	($scope.cargarTiposProducto = function(){
		$http.post('consultas.php', {accion: 'inicioProveedor'})
		.success(function(data){
			console.log(data);
		}).error(function(data){
			console.log(data);
		});
	})();

	$scope.proveedor = {};

	// GUARDAR PROVEEDOR
	$scope.guardarProveedor = function(){
		var proveedor = $scope.proveedor;
		var error = false;

		if( !(proveedor.nombre && proveedor.nombre.length > 5) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha Ingresado el nombre del proveedor.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(proveedor.telefono && proveedor.telefono > 0 ) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado el número de Telefono.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(proveedor.email && proveedor.email.length > 5)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado un correo válido, verifique.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		
		// SI NO EXISTE ERROR
		if( !error ){		
			$http.post('consultas.php', {accion: 'guardarProveedor', datos: $scope.proveedor})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.reset();
					$scope.consultarProveedores();
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