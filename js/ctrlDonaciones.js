miApp.controller('ctrlDonaciones', function($scope, $http, $alert, $filter, $timeout){
	
	$scope.$parent.menu  = 'donaciones';
	$scope.filtro        = "tipoEntidad"
	$scope.lstFamilias   = [];
	$scope.lstGeneros    = [];
	$scope.lstAreas      = [];
	$scope.lstParentesco = [];

	$scope.producto = {};
	$scope.itemProducto = {};

	$scope.lstProductos = [];
	$scope.lstDonadores = [];

	$scope.lstProveedores = [];

	$scope.tab = 1;

	$scope.donacionFondo = {
		esAnonimo     : true,
		idDonador     : null,
		cantidad      : null,
		idMoneda      : 1,
		fechaDonacion : ''
	};

	$scope.donacionProducto = {
		esAnonimo        : true,
		idDonador        : null,
		fechaAdquisicion : '',
		tieneFactura     : false,
		noFactura        : '',
		lstProductos     : []
	};

	$scope.$watch( 'filtro', function( _new, _old){
		if( _new != _old ){
			$scope.consultarDonaciones();
		}
	});

	$scope.lstFondoComun = [];
	// CARGAR LISTA DE PRODUCTOS
	($scope.consultarDonaciones = function(){
		$http.post('consultas.php',{accion: 'consultarFondoComun', filtro: $scope.filtro})
		.success(function(data){
			console.log(data);
			$scope.lstFondoComun = data.lstFondoComun;
		}).error(function(data){
			console.log(data);
		});
	})();


	$scope.$watch('donacionProducto.tieneFactura', function(){
		if( $scope.donacionProducto.tieneFactura == true )
			$timeout(function(){
				$('#numeroFactura').focus();
			});
		else
			$timeout(function(){
				$('#cantidadDonacion').focus();
			});
	});


	($scope.cargarInicio = function(){
		$http.post('consultas.php', {accion: 'infoDonacion'})
		.success(function( data ){
			console.log(data);
			$scope.lstDonadores   = data.lstDonadores;
			$scope.lstProductos   = data.lstProductos;
		}).error(function(data){
			console.log(data);
		});
	})();

	// CARGAR LISTA DE PRODUCTOS
	$scope.cargarLstProductos = function(){
		$http.post('consultas.php', {accion: 'cargarProductos'}).success(function(data){
			console.log(data);
			$scope.lstProductos = data.lstProductos;
		}).error(function(data){
			console.log(data);
		});
	}

	// RESETEAR OBJETO
	$scope.resetObject = function(){
		$scope.dcProducto = {
			idProducto     : null,
			cantidad       : null,
			precioUnitario : null,
		};
	};

	$scope.bloquearFecha = 0;
	$scope.$watch('dcProducto.idProducto', function(){

		for (var i = 0; i < $scope.lstProductos.length; i++) {
			console.log( $scope.lstProductos[i] );
			if( $scope.lstProductos[i].idProducto == $scope.dcProducto.idProducto){
				$scope.bloquearFecha = parseInt( $scope.lstProductos[i].esPerecedero );
				break;
			}
		}

	});

	$scope.dcProducto = {};
	// AGREGAR MIEMRBO A LA FAMILIA
	$scope.addProducto = function(){

		var dcProducto   = $scope.dcProducto;
		var error        = false;

		if( !(dcProducto.idProducto) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No ha seleccionado el producto.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(dcProducto.cantidad && dcProducto.cantidad > 0) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No ha ingresado la cantidad.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(dcProducto.precioUnitario && dcProducto.precioUnitario > 0) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No Ha ingresado el precio unitario.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( $scope.bloquearFecha ){
			if (!(dcProducto.fechaCaducidad) ){
				error = true;
				$alert({title: 'Notificación: ', content: 'Debe ingresar la fecha de Caducidad.', placement: 'top', type: 'warning', show: true, duration: 4});
				return;
			}			
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaCaducidad = $filter('date')($scope.dcProducto.fechaCaducidad, "yyyy-MM-dd");

			// AGREGA AL ARREGLO LOS VALORES DEL OBJETO
			$scope.donacionProducto.lstProductos.push({
				idProducto     : dcProducto.idProducto,
				cantidad       : dcProducto.cantidad,
				precioUnitario : dcProducto.precioUnitario,
				fechaCaducidad : fechaCaducidad,
			});
			$scope.dcProducto = {};
		}
	};

	// QUITAR PRODUCTO
	$scope.removerProducto = function( index ){
		$scope.donacionProducto.lstProductos.splice( index, 1 );
	};

	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.donacionFondo = {
			esAnonimo     : true,
			idDonador     : null,
			cantidad      : null,
			idMoneda      : 1,
			fechaDonacion : ''
		};
		$scope.donacionProducto = {
			esAnonimo        : true,
			idDonador        : null,
			fechaAdquisicion : '',
			tieneFactura     : false,
			noFactura        : '',
			lstProductos     : []
		};
	}

	// GUARDAR DONACION PRODUCTO
	$scope.guardarDonacionProducto = function(){
		var error = false;

		if( !($scope.donacionProducto.esAnonimo) ){
			if( !( $scope.donacionProducto.idDonador ) ){
				error = true;
				$alert({title: 'Notificación: ', content: 'No ha seleccionado al donador, verifique.', placement: 'top', type: 'warning', show: true, duration: 4});
			}
		}
		else if( !($scope.donacionProducto.fechaDonacion)  ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No ha ingresado fecha de Adquisición.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( $scope.donacionProducto.tieneFactura ){
			if( !( $scope.donacionProducto.noFactura > 0 ) ){
				error = true;
				$alert({title: 'Notificación: ', content: 'No ha ingresado factura, verifique.', placement: 'top', type: 'warning', show: true, duration: 4});
			}
		}

		else if( $scope.donacionProducto.lstProductos.length == 0 ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No ha ingresado productos, verifique.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		if( !error ){
			$scope.donacionProducto.fecha = $filter('date')($scope.donacionProducto.fechaDonacion, "yyyy-MM-dd");
			$http.post('consultas.php',{accion: 'guardarDonacionProducto', datos: $scope.donacionProducto})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.reset();
					$alert({title: 'Mensaje: ', content: data.mensaje, placement: 'top', type: 'success', show: true, duration: 4});
				}else{
					$alert({title: 'Error: ', content: data.mensaje, placement: 'top', type: 'danger', show: true, duration: 4});
				}
			}).error(function(data){
				console.log(data);
			});
		}
	}

	// GUARDAR FONDO COMUN
	$scope.guardarDonacionFondo = function(){
		var fondoDonacion = $scope.donacionFondo;
		var error = false;

		if( !fondoDonacion.esAnonimo ){
			if( !(fondoDonacion.idDonador) ){
				error = true;
				$alert({title: 'Alerta: ', content: 'No ha seleccionado el donador.', placement: 'top', type: 'warning', show: true, duration: 4});
			}
		}
		else if( !(fondoDonacion.cantidad > 0) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado una cantidad correcta.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(fondoDonacion.fechaDonacion) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No Ha ingresado una fecha correcta.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaDonacion = $filter('date')($scope.donacionFondo.fechaDonacion, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'guardarFondoComun', datos: $scope.donacionFondo, fechaDonacion: fechaDonacion})
			.success(function(data){
				console.log(data);
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.consultarDonaciones();
					$scope.reset();
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