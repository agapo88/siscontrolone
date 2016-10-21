miApp.controller('ctrlCompras', function($scope, $http, $alert, $filter){
	
	$scope.$parent.menu = 'compras';
	$scope.idTipoMoneda = 1;
	$scope.compras = {
		idMoneda : 1,
		noFactura    : null,
		fechaIngreso : null,
		totalDolares : 0,
		idProveedor  : "1",
		lstProductos : [],
	};

	$scope.comprasD = {
		idMoneda : 2,
		noFactura    : null,
		fechaIngreso : null,
		totalDolares : 0,
		idProveedor  : "1",
		lstProductos : [],
	};

	$scope.subTotalQuetzales = function(){

		var subTotalQuetzales = 0;
		for (var i = 0; i < $scope.compras.lstProductos.length; i++) {
			subTotalQuetzales += ($scope.compras.lstProductos[i].cantidad * $scope.compras.lstProductos[i].precioUnitario );
		}
		return subTotalQuetzales;

	};

	$scope.subTotalDolares = function(){
		var subTotalDolares = 0;
		for (var i = 0; i < $scope.comprasD.lstProductos.length; i++) {
			subTotalDolares += ($scope.comprasD.lstProductos[i].cantidad * $scope.comprasD.lstProductos[i].precioUnitario );
		}
		return subTotalDolares;
	};

	$scope.lstProductos   = [];
	$scope.lstProveedores = [];
	$scope.lstMontos      = [];
	($scope.cargarInicio = function(){
		$http.post('consultas.php', {accion: 'inicioCompras'})
		.success(function( data ){
			console.log(data);
			$scope.compras.totalQuetzales = parseFloat( data.lstMontos[0].total );
			$scope.comprasD.totalDolares   = parseFloat( data.lstMontos[1].total );
			$scope.lstProductos   = data.lstProductos;
			$scope.lstProveedores = data.lstProveedores;
			$scope.lstMontos      = data.lstMontos;
		}).error(function(data){
			console.log(data);
		});
	})();


	$scope.bloquearFecha = 0;
	$scope.$watch('detalleCompra.idProducto', function(){
		for (var i = 0; i < $scope.lstProductos.length; i++) {
			if( $scope.lstProductos[i].idProducto == $scope.detalleCompra.idProducto){
				$scope.bloquearFecha = parseInt( $scope.lstProductos[i].esPerecedero );
				break;
			}
		}
		for (var i = 0; i < $scope.lstProductos.length; i++) {
			if( $scope.lstProductos[i].idProducto == $scope.detalleCompra.idProducto){
				$scope.bloquearFecha = parseInt( $scope.lstProductos[i].esPerecedero );
				break;
			}
		}
	});

	$scope.deleteProdDolares = function( index ){
		$scope.compras.lstProductosD.splice( index, 1);
	}

	$scope.deleteProdQuetzales = function( index ){
		$scope.compras.lstProductos.splice( index, 1);
	}

	$scope.resetObject = function( cod ){
		$scope.detalleCompra = {};

		if( cod == 1 ){
			$scope.compras = {
				idMoneda : 1,
				noFactura    : null,
				fechaIngreso : null,
				totalDolares : 0,
				idProveedor  : "1",
				lstProductos : [],
			};
		}

		if( cod == 2 ){
			$scope.comprasD = {
				idMoneda : 2,
				noFactura    : null,
				fechaIngreso : null,
				totalDolares : 0,
				idProveedor  : "1",
				lstProductos : [],
			};
		}
	}


	// AGREGAR TOTAL
	$scope.detalleCompra = {};
	$scope.addCompra = function( idTipoMoneda ){
		var error         = false;
		var detalleCompra = $scope.detalleCompra;

		if( !(detalleCompra.idProducto) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No ha seleccionado el producto.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(detalleCompra.cantidad && detalleCompra.cantidad > 0) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No ha ingresado la cantidad.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(detalleCompra.precioUnitario && detalleCompra.precioUnitario > 0.01) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No Ha ingresado el precio unitario.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( $scope.bloquearFecha ){
			if (!(detalleCompra.fechaCaducidad) ){
				error = true;
				$alert({title: 'Notificación: ', content: 'Debe ingresar la fecha de Caducidad.', placement: 'top', type: 'warning', show: true, duration: 4});
				return;
			}			
		}

		console.log("pRECIO UNITARTIO:::", detalleCompra.precioUnitario);

		// VALIDACIÓN QUETZALES
		if ( idTipoMoneda == 1 ){
			if( $scope.compras.lstProductos.length > 0 ){
				if( !($scope.compras.totalQuetzales >= $scope.subTotalQuetzales() + (detalleCompra.cantidad * detalleCompra.precioUnitario) ) ){
					error = true;
					$alert({title: 'Alerta: ', content: 'No tiene disponibilidad de dinero en quetzales.', placement: 'top', type: 'danger', show: true, duration: 5});
				}
			}else{
				if( !($scope.compras.totalQuetzales >= (detalleCompra.cantidad * detalleCompra.precioUnitario) ) ){
					error = true;
					$alert({title: 'Alerta: ', content: 'La cantidad ingresada supera el monto disponible en quetzales.', placement: 'top', type: 'danger', show: true, duration: 5});
				}
			}
		}

		// VALIDACIÓN DOLARES
		if ( idTipoMoneda == 2 ){
			if( $scope.comprasD.lstProductos.length > 0 ){
				if( !($scope.comprasD.totalDolares >= $scope.subTotalDolares() + (detalleCompra.cantidad * detalleCompra.precioUnitario) ) ){
					error = true;
					$alert({title: 'Alerta: ', content: 'No tiene disponibilidad de dinero en dolares.', placement: 'top', type: 'danger', show: true, duration: 5});
				}
			}else{
				if( !($scope.comprasD.totalDolares >= (detalleCompra.cantidad * detalleCompra.precioUnitario) ) ){
					error = true;
					$alert({title: 'Alerta: ', content: 'La cantidad ingresada supera el monto disponible en dolares.', placement: 'top', type: 'danger', show: true, duration: 5});
				}
			}
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaCaducidad = $filter('date')($scope.detalleCompra.fechaCaducidad, "yyyy-MM-dd");

			if( idTipoMoneda == 1 ){
				// AGREGA AL ARREGLO LOS VALORES DEL OBJETO
				$scope.compras.lstProductos.push({
					idProducto     : detalleCompra.idProducto,
					cantidad       : detalleCompra.cantidad,
					precioUnitario : parseFloat( detalleCompra.precioUnitario ),
					idProveedor    : $scope.compras.idProveedor,
					fechaCaducidad : fechaCaducidad
				});
			}
			if( idTipoMoneda == 2 ){
				// AGREGA AL ARREGLO LOS VALORES DEL OBJETO
				$scope.comprasD.lstProductos.push({
					idProducto     : detalleCompra.idProducto,
					cantidad       : detalleCompra.cantidad,
					precioUnitario : parseFloat( detalleCompra.precioUnitario ),
					idProveedor    : $scope.compras.idProveedor,
					fechaCaducidad : fechaCaducidad
				});		
			}

			$scope.detalleCompra = {};
		}
	};


	$scope.verNombreProducto = function( idProducto ){
		var nombreProducto = "";

		for (var i = 0; i < $scope.lstProductos.length; i++) {
			if( $scope.lstProductos[i].idProducto == idProducto){
				nombreProducto = $scope.lstProductos[i].producto;
				break;
			}
		}

		return nombreProducto;
	}

	$scope.verNombreProveedor = function( idProveedor ){
		var nombreProveedor = "";
		for (var i = 0; i < $scope.lstProveedores.length; i++) {
			if( $scope.lstProveedores[i].idProveedor == idProveedor){
				nombreProveedor = $scope.lstProveedores[i].proveedor;
				break;
			}
		}

		return nombreProveedor;
	}


	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.donador = {
				nombre        : '',
				telefono      : '',
				email         : '',
				idTipoEntidad : null,
				fechaIngreso  : null
			};
		$scope.itemDonador = {};
	}

	// GUARDAR COMPRAS QUETZALES
	$scope.guardarCompraQ = function(){
		var error = false;

		if( !($scope.compras.noFactura && $scope.compras.noFactura > 0)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado un número de Factura.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.compras.fechaIngreso) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado la fecha de ingreso.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.compras.lstProductos.length > 0 || $scope.compras.lstProductosD.length > 0 ) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha registrado ningún producto.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaIngreso = $filter('date')($scope.compras.fechaIngreso, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'guardarCompras', datos: $scope.compras, fechaIngreso: fechaIngreso})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.resetObject(1);
					$alert({title: 'Mensaje: ', content: data.mensaje, placement: 'top', type: 'success', show: true, duration: 4});
				}else{
					$alert({title: 'Error: ', content: data.mensaje, placement: 'top', type: 'danger', show: true, duration: 4});
				}
			}).error(function(data){
				console.log(data);
			});
		}
	};
	

	// GUARDAR COMPRAS DOLARES
	$scope.guardarCompraD = function(){
		var error = false;

		if( !($scope.comprasD.noFactura && $scope.comprasD.noFactura > 0)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado un número de Factura.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.comprasD.fechaIngreso) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado la fecha de ingreso.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !($scope.comprasD.lstProductos.length > 0 || $scope.comprasD.lstProductosD.length > 0 ) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha registrado ningún producto.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaIngreso = $filter('date')($scope.comprasD.fechaIngreso, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'guardarCompras', datos: $scope.comprasD, fechaIngreso: fechaIngreso})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.resetObject(2);
					$alert({title: 'Mensaje: ', content: data.mensaje, placement: 'top', type: 'success', show: true, duration: 4});
				}else{
					$alert({title: 'Error: ', content: data.mensaje, placement: 'top', type: 'danger', show: true, duration: 4});
				}
			}).error(function(data){
				console.log(data);
			});
		}
	};
});