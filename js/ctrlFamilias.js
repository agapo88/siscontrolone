miApp.controller('ctrlFamilias', function($scope, $http, $alert, $filter, $timeout){
	

	$scope.$parent.menu  = 'familias';
	$scope.tab = 1;

	$scope.lstFamilias   = [];
	$scope.lstGeneros    = [];
	$scope.lstAreas      = [];
	$scope.lstParentesco = [];
	$scope.filtro        = "departamento";

	$scope.agregarMiembros = false;
	$scope.$watch('agregarMiembros', function(){
		if( $scope.agregarMiembros == true ){
			$timeout(function(){
				$('#miembroCui').focus();
			}, 100);
		}
	});

	$scope.$watch('tab', function(){
		if( $scope.tab == 2){
			$timeout(function(){
				$('#nombreFamilia').focus();
			});
		}
	});

	$scope.familia = {
		nombre         : 'Familia ',
		fechaIngreso   : '',
		direccion      : '',
		idArea         : null,
		idMunicipio    : null,
		idDepartamento : null,
		lstMiembros    : [
			{
				nombres         : 'Jose Antonio',
				apellidos       : 'Perez García',
				cui             : '0031231231231',
				fechaNacimiento : '1988-12-05',
				idGenero        : '1',
				parentesco      : '',
				idParentesco    : '3',
			},
			{
				nombres         : 'Maria',
				apellidos       : 'Perez García',
				cui             : '0031231231231',
				fechaNacimiento : '1999-10-04',
				idGenero        : '2',
				parentesco      : '',
				idParentesco    : '3',
			},
		]
	};

	$scope.miembro = {
		nombres         : '',
		apellidos       : '',
		cui             : '',
		fechaNacimiento : '',
		idGenero        : null,
		parentesco      : '',
		idParentesco    : null,
	};

	($scope.cargarInicio = function(){
		$http.post('consultas.php', {accion: 'cargaDataFamilia'})
		.success(function( data ){
			console.log(data);
			$scope.lstAreas         = data.lstAreas;
			$scope.lstParentesco    = data.lstParentesco;
			$scope.lstGeneros       = data.lstGeneros;
			$scope.lstDepartamentos = data.lstDepartamentos;
		}).error(function(data){
			console.log(data);
		});
	})();


	$scope.lstMunicipios = [];
	$scope.consultarMunicipio = function( idDepartamento ){
		$http.post('consultas.php',{accion: 'consultarMunicipio', idDepartamento: idDepartamento})
		.success(function(data){
			$scope.lstMunicipios = data.lstMunicipios;
		}).error(function(data){
			console.log(data);
		});
	}

	$scope.lstAyudasFam = [];
	$scope.verDonacionesFamilia = function( idFamilia ){
		$http.post('consultas.php',{accion: 'verDonacionesFamilia', idFamilia: idFamilia})
		.success(function(data){
			console.log(data);
			$scope.lstAyudasFam = data.lstAyudasFam;
		}).error(function(data){
			console.log(data);
		});
	};

	$scope.lstSeguimientoFam = [];
	$scope.verSeguimiento = function( idFamilia ){
		$http.post('consultas.php',{accion: 'verHistorialEconomico', idFamilia: idFamilia})
		.success(function(data){
			$scope.lstSeguimientoFam = data.lstHistorialFamilia;
			if( data.lstHistorialFamilia.length > 0 )
				$('#modalSeguimiento').modal('show');
			else
				$alert({title: 'Notificación: ', content: 'No se encontro seguimientos para esta familia.', placement: 'top', type: 'warning', show: true, duration: 4});
		}).error(function(data){
			console.log(data);
		});
	};


	$scope.lstFamiliasB = [];
	($scope.consultarFamilias = function(){
		$http.post('consultas.php',{accion: 'consultarFamilias'})
		.success(function(data){
			$scope.lstFamiliasB = data.lstFamiliasB;
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

	// AGREGAR MIEMRBO A LA FAMILIA
	$scope.addMiembro = function(){

		var miembro = $scope.miembro;
		var error   = false;

		if( miembro.cui && !(miembro.cui.length == 13) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'No. de <b>CUI<b> Invalido, debe tener 13 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.nombres.length > 2) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Nombre del familiar muy corto, debe tener minimo 3 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.apellidos.length > 2) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Apellidos del familiar son cortos, debe tener minimo 3 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.fechaNacimiento) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe ingresar la fecha de Nacimiento.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.idGenero) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe seleccionar el género.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( !(miembro.idParentesco) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe seleccionar un parentesco.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}
		else if( miembro.idParentesco==9 && !(miembro.idParentesco.length > 2 ) ){
			error = true;
			$alert({title: 'Notificación: ', content: 'Debe ingresar el otro Parentesco.', placement: 'top', type: 'warning', show: true, duration: 4});
			return;
		}

		// SI NO EXISTE ERROR
		if( !error ){
			var fechaNacimiento = $filter('date')($scope.familia.fechaNacimiento, "yyyy-MM-dd");
			// AGREGA AL ARREGLO LOS VALORES DEL OBJETO
			$scope.familia.lstMiembros.push({
				nombres         : miembro.nombres,
				apellidos       : miembro.apellidos,
				cui             : miembro.cui,
				fechaNacimiento : fechaNacimiento,
				idGenero        : miembro.idGenero,
				parentesco      : miembro.parentesco,
				idParentesco    : miembro.idParentesco,
			});
			$scope.resetObject();
			$scope.agregarMiembros = false;
		}
	};

	// QUITAR MIEMBRO DE LA LISTA
	$scope.removeMiembro = function( index ){
		$scope.familia.lstMiembros.splice( index, 1 );
	};


	// RESETEAR VALORES
	$scope.reset = function(){
		$scope.familia = {
			nombre         : 'Familia',
			fechaIngreso   : '',
			direccion      : '',
			idArea         : null,
			idMunicipio    : null,
			idDepartamento : null,
			lstMiembros    : []
		};
	};

	// CONSULTAR LISTA DONANTES
	$scope.consultarDonadores = function(){
		$http.post('consultas.php', {accion: 'cargarDonantes'})
		.success(function( data ){
			console.log( 'donantes', data );
			$scope.lstDonantes = data.lstDonantes;
		}).error(function(data){
			console.log(data);
		});
	};

	// GUARDAR DONADOR
	$scope.guardarFamilia = function(){

		var familia = $scope.familia;
		var error = false;

		if( !(familia.nombre && familia.nombre.length > 9)  ){
			error = true;
			$alert({title: 'Alerta: ', content: 'El nombre de la familia debe tener mínimo 10 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(familia.idArea && familia.idArea != null) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el área de pertenencia.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(familia.direccion && familia.direccion.length > 7) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'La dirección de la familia debe tener más de 7 caracteres.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(familia.fechaIngreso) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha ingresado fecha de Ingreso.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(familia.idDepartamento && familia.idDepartamento != null) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el departamento.', placement: 'top', type: 'warning', show: true, duration: 4});
		}
		else if( !(familia.idMunicipio && familia.idMunicipio != null) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'No ha seleccionado el Municipio.', placement: 'top', type: 'warning', show: true, duration: 4});
		}else if( !(familia.lstMiembros.length >0) ){
			error = true;
			$alert({title: 'Alerta: ', content: 'Aun no ingresa miembros de la familia.', placement: 'top', type: 'warning', show: true, duration: 4});
		}

		// SI NO EXISTE ERROR
		if( !error ){
			console.log("Accedio");
			
			var fechaIngreso = $filter('date')($scope.familia.fechaIngreso, "yyyy-MM-dd");
			$http.post('consultas.php', {accion: 'guardarFamilia', datos: $scope.familia, fechaIngreso: fechaIngreso})
			.success(function(data){
				console.log(data);
				/*
				if( data.respuesta ){
					$scope.$parent.hideModalAgregar();
					$scope.reset();
					$scope.consultarDonadores();
					$alert({title: 'Mensaje: ', content: data.mensaje, placement: 'top', type: 'success', show: true, duration: 4});
				}else{
					$alert({title: 'Error: ', content: data.mensaje, placement: 'top', type: 'danger', show: true, duration: 4});
				}
				*/
			}).error(function(data){
				console.log(data);
			});
		}
	}
	
});