<div class="row">
   <div class="title-section">
      <span class="titulo">DONACIONES</span>
   </div>
   <div class="col-sm-12 text-right">
      <button type="button" class="btn btn-success btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
         <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
         Agregar Donación
      </button>
   </div>
   <div class="col-sm-12">
      <b>AGRUPAR POR:</b>
      <div class="btn-group" role="group">
         <button type="button" class="btn btn-default" ng-click="filtro='tipoEntidad'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='tipoEntidad', 'glyphicon-unchecked': filtro!='tipoEntidad'}"></span> Tipo Entidad
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='anio'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='anio', 'glyphicon-unchecked': filtro!='anio'}"></span> Año Ingreso
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='estado'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='estado', 'glyphicon-unchecked': filtro!='estado'}"></span> Estado
         </button>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="row">
         <div class="col-sm-offset-8 col-sm-4">
            <div class="input-group">
               <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Buscar:</button>
               </span>
               <input type="text" class="form-control" ng-model="searchDonador"  placeholder="Buscar donador">
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="panel panel-info" ng-repeat="(ixEntidad, entidad) in lstEntidades ">
         <div class="panel-heading">
            <a ng-click="entidad.mostrar=!entidad.mostrar">
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': entidad.mostrar, 'glyphicon-chevron-down': !entidad.mostrar}"></span>
               <strong ng-show="filtro=='tipoEntidad'">
                  {{ entidad.tipoEntidad }}
               </strong>
               <strong ng-show="filtro=='anio'">
                  {{ entidad.anio }}
               </strong>
               <strong ng-show="filtro=='estado'">
                  {{ entidad.estadoDonador }}
               </strong>
            </a>
            <div class="pull-right">
               <label class="label label-primary">
                  <strong>TOTAL: <span class="badge">{{entidad.totalDonantes}}</span></strong>
               </label>
            </div>
         </div>
         <div class="panel-body" ng-hide="entidad.mostrar">
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="text-center">Donador</th>
                     <th class="text-center" ng-if="filtro!='tipoEntidad'">Tipo Donador</th>
                     <th class="text-center">Telefono</th>
                     <th class="text-center">Fecha Ingreso</th>
                     <th class="text-center">Correo</th>
                     <th class="text-center">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixDonante, donador) in entidad.lstDonantes | filter:searchDonador || searchDonante" ng-init="$idIndex = $index">
                     <td class="text-center">
                      {{ $idIndex + 1 }} </td>
                     <td> {{ donador.nombre }} </td>
                     <td class="text-center" ng-if="filtro!='tipoEntidad'"> {{ donador.tipoEntidad }} </td>
                     <td class="text-center"> {{ donador.telefono }} </td>
                     <td class="text-center"> {{ donador.fechaFormato }}  </td>
                     <td class="text-center"> {{ donador.email }} </td>
                     <td>
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button class="btn btn-xs btn-opcion" ng-click="removeMiembro( ixMiembro )" >
                              <span class="glyphicon glyphicon-trash"></span>
                           </button>
                           <button class="btn btn-xs btn-opcion" ng-click="editarDonador( donador )">
                              <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                           </button>
                           <!--
                           <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                              <span class="glyphicon glyphicon-plus"></span> Oficio
                           </button>
                           -->
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>


<!-- VENTANA MODAL AGREGAR -->
<div class="" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header title-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-user"></span> Agregar Donador
            </h4>
         </div>
         <div class="modal-body">
            <div>

              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" ng-class="{'active': tab==1}" ng-click="tab=1"><a role="tab">Home</a></li>
                <li role="presentation" ng-class="{'active': tab==2}" ng-click="tab=2"><a role="tab">Profile</a></li>
                <li role="presentation" ng-class="{'active': tab==3}" ng-click="tab=3"><a role="tab">Messages</a></li>
                <li role="presentation" ng-class="{'active': tab==4}" ng-click="tab=4"><a role="tab">Settings</a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                  <div role="tabpanel" ng-class="{'active': tab==1}" class="tab-pane active" ng-show="tab==1">
                     <h3>
                        Bienvenido(a)
                     </h3>
                     Por favor ingrese el tipo de Donación

                     <form class="form-horizontal" novalidate autocomplete="off">
                        <div class="form-group">
                           <label class="control-label col-sm-3">
                              SELECCIONE PRODUCTO
                           </label>
                           <div class="col-sm-7">
                              <select class="form-control" ng-model="producto.idProducto">
                                 <option value="{{  }}"></option>
                              </select>
                              <input type="number" class="form-control" ng-model="producto.cantidad">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-sm-3">
                              Cantidad
                           </label>
                           <div class="col-sm-7">
                              <input type="number" class="form-control" ng-model="producto.cantidad">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="">Lista de Productos</label>
                        </div>
                     </form>
                  </div>
                  <div role="tabpanel" ng-class="{'active': tab==2}" class="tab-pane" ng-show="tab==2">
                  </div>
                  <div role="tabpanel" ng-class="{'active': tab==3}" class="tab-pane" ng-show="tab==3">
                     pruebas...
                  </div>
                  <div role="tabpanel" ng-class="{'active': tab==4}" class="tab-pane" ng-show="tab==4">
                     pruebas...
                  </div>
              </div>
            </div>
            <form class="form-horizontal" name="formAgregar">
               <div class="form-group">
                  <label class="control-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                     <input type="text" ng-model="donador.nombre" class="form-control">
                  </div>
               </div>
               <div class="form-group"  ng-class="{'has-error': formAgregar.telefono.$invalid}">
                  <label class="control-label col-sm-3">Telefono:</label>
                  <div class="col-sm-8">
                     <input type="text" name="telefono" minlength="8" maxlength="15" ng-model="donador.telefono" class="form-control">
                  </div>
               </div>
               <div class="form-group" ng-class="{'has-error': formAgregar.email.$invalid}">
                  <label class="control-label col-sm-3">Email:</label>
                  <div class="col-sm-8">
                     <input type="email" name="email" ng-model="donador.email" class="form-control">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">Tipo Donante:</label>
                  <div class="col-sm-6">
                     <select class="form-control" ng-model="donador.idTipoEntidad">
                        <option value="{{tipoEntidad.idTipoEntidad}}" ng-repeat="tipoEntidad in lstTipoEntidad">
                           {{tipoEntidad.tipoEntidad}}
                        </option>
                     </select>
                  </div>
               </div>
               
               <div class="form-group" ng-class="{'has-error': formAgregar.fechaIngreso.$invalid}">
                  <label class="control-label col-sm-3">Fecha Ingreso:</label>
                  <div class="col-sm-6">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaIngreso" class="form-control" ng-model="donador.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="guardarDonador()"><i class="glyphicon glyphicon-saved"></i> Guardar Donador</button>
         </div>
      </div>
   </div>
</div>



<!-- VENTANA MODAL EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
         <div class="modal-header title-editar">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-user"></span> Actualizar Donador
            </h4>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" name="formAgregar">
               <div class="form-group">
                  <label class="control-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                     <input type="text" ng-model="itemDonador.nombre" class="form-control">
                  </div>
               </div>
               <div class="form-group"  ng-class="{'has-error': formAgregar.telefono.$invalid}">
                  <label class="control-label col-sm-3">Telefono:</label>
                  <div class="col-sm-8">
                     <input type="text" name="telefono" minlength="8" maxlength="15" ng-model="itemDonador.telefono" class="form-control">
                  </div>
               </div>
               <div class="form-group" ng-class="{'has-error': formAgregar.email.$invalid}">
                  <label class="control-label col-sm-3">Email:</label>
                  <div class="col-sm-8">
                     <input type="email" name="email" ng-model="itemDonador.email" class="form-control">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">Tipo Donante:</label>
                  <div class="col-sm-6">
                     <select class="form-control" ng-model="itemDonador.idTipoEntidad">
                        <option value="{{tipoEntidad.idTipoEntidad}}" ng-repeat="tipoEntidad in lstTipoEntidad">
                           {{tipoEntidad.tipoEntidad}}
                        </option>
                     </select>
                  </div>
               </div>
               <div class="form-group" ng-class="{'has-error': formAgregar.fechaIngreso.$invalid}">
                  <label class="control-label col-sm-3">Fecha Ingreso:</label>
                  <div class="col-sm-6">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaIngreso" class="form-control" ng-model="itemDonador.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="actualizarDonador()"><i class="glyphicon glyphicon-saved"></i> Guardar Donador</button>
         </div>
      </div>
   </div>
</div>














<div class="row">
   <div class="title-section">
      <span class="titulo">PRODUCTOS</span>
   </div>
   <div class="col-sm-12 text-right">
      <button type="button" class="btn btn-success btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
         <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
         Agregar PRODUCTO
      </button>
   </div>
   <div class="col-sm-12">
      <b>AGRUPAR POR:</b>
      <div class="btn-group" role="group">
         <button type="button" class="btn btn-default" ng-click="filtro='tipoProducto'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='tipoProducto', 'glyphicon-unchecked': filtro!='tipoProducto'}"></span> Tipos Producto
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='seccionBodega'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='seccionBodega', 'glyphicon-unchecked': filtro!='seccionBodega'}"></span> Área Bodega
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='clasificacion'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='clasificacion', 'glyphicon-unchecked': filtro!='clasificacion'}"></span> Clasificacion
         </button>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="row">
         <div class="col-sm-offset-8 col-sm-4">
            <div class="input-group">
               <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Buscar:</button>
               </span>
               <input type="text" class="form-control" ng-model="searchDonador"  placeholder="Buscar donador">
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="panel panel-info" ng-repeat="(ixProducto, producto) in lstProductos">
         <div class="panel-heading">
            <a ng-click="producto.mostrar=!producto.mostrar">
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': producto.mostrar, 'glyphicon-chevron-down': !producto.mostrar}"></span>
               <strong ng-show="filtro=='tipoProducto'">
                  {{ producto.tipoProducto }}
               </strong>
               <strong ng-show="filtro=='seccionBodega'">
                  {{ producto.seccionBodega }}
               </strong>
               <strong ng-show="filtro=='clasificacion'">
                  Perecedero: {{ producto.perecedero }}
               </strong>
            </a>
            <div class="pull-right">
               <label class="label label-primary">
                  <strong>TOTAL: <span class="badge">{{producto.totalProductos}}</span></strong>
               </label>
            </div>
         </div>
         <div class="panel-body" ng-hide="producto.mostrar">
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="text-center col-sm-4">Producto</th>
                     <th class="text-center">Tipo Producto</th>
                     <th class="text-center">Perecedero</th>
                     <th class="text-center">Disponible</th>
                     <th class="text-center">Ubicación</th>
                     <th class="text-center">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixProducto, producto) in producto.lstProductos | filter:searchproducto || searchDonante" ng-init="$idIndex = $index">
                     <td class="text-center">
                        {{ producto.idProducto }}
                     </td>
                     <td>
                        <button type="button" class="btn btn-xs btn-default" ng-click="producto.showOb=!producto.showOb" ng-show="producto.observacion.length > 0">
                           <span class="glyphicon" ng-class="{'glyphicon-eye-open': !producto.showOb, 'glyphicon-eye-close': producto.showOb}"></span>
                        </button>
                        {{ producto.producto }}
                        <br>
                        <div ng-show="producto.showOb">
                           {{ producto.observacion }}
                        </div>
                      </td>
                     <td class="text-center">
                        {{ producto.tipoProducto }}
                     </td>
                     <td class="text-center"> {{ producto.perecedero }} </td>
                     <td class="text-center"> {{ producto.totalProducto }}  </td>
                     <td class="text-center"> {{ producto.ubicacionBodega }} </td>
                     <td>
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button class="btn btn-xs btn-opcion" ng-click="removeMiembro( ixMiembro )" >
                              <span class="glyphicon glyphicon-trash"></span>
                           </button>
                           <button class="btn btn-xs btn-opcion" ng-click="editarDonador( donador )">
                              <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                           </button>
                           <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                              <span class="glyphicon glyphicon-folder-open"></span>
                           </button>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>


<!-- VENTANA MODAL AGREGAR -->
<div class="" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header title-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-user"></span> Agregar Donador
            </h4>
         </div>
         <div class="modal-body">
            
              <!-- TABS -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" ng-class="{'active': tab==1}" ng-click="tab=1"><a role="tab">Home</a></li>
                <li role="presentation" ng-class="{'active': tab==2}" ng-click="tab=2"><a role="tab">Profile</a></li>
                <li role="presentation" ng-class="{'active': tab==3}" ng-click="tab=3"><a role="tab">Messages</a></li>
              </ul>
              <!-- PANELES -->
              <div class="tab-content">
                  <div role="tabpanel" ng-class="{'active': tab==1}" class="tab-pane active" ng-show="tab==1">
                     <h3>
                        Bienvenido(a)
                     </h3>

                     <form class="form-horizontal" novalidate autocomplete="off">
                        <div class="form-group">
                           <label class="control-label col-sm-3">
                              Área Bodega
                           </label>
                           <div class="col-sm-3">
                              <select class="form-control" ng-model="producto.idSeccionBodega">
                                 <option value="{{ seccionBodega.idSeccionBodega  }}" ng-repeat="seccionBodega in lstSeccionBodega">
                                    {{seccionBodega.seccionBodega}}
                                 </option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-sm-3">
                              Tipo Producto
                           </label>
                           <div class="col-sm-5">
                              <select class="form-control" ng-model="producto.idTipoProducto">
                                 <option value="{{ tipoProducto.idTipoProducto  }}" ng-repeat="tipoProducto in lstTiposProducto">
                                    {{tipoProducto.tipoProducto}}
                                 </option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-sm-3">
                              Cantidad
                           </label>
                           <div class="col-sm-5">
                              <input type="number" class="form-control" ng-model="producto.cantidad">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-sm-3">
                              Cantidad
                           </label>
                           <div class="col-sm-5">
                              <input type="number" class="form-control" ng-model="producto.cantidad">
                           </div>
                        </div>

                        <div class="form-group">
                           <label for="">Lista de Productos</label>
                        </div>
                     </form>
                  </div>
                  <div role="tabpanel" ng-class="{'active': tab==2}" class="tab-pane" ng-show="tab==2">
                  </div>
                  <div role="tabpanel" ng-class="{'active': tab==3}" class="tab-pane" ng-show="tab==3">
                     pruebas...
                  </div>
              </div>
            
            <form class="form-horizontal" name="formAgregar">
               <div class="form-group">
                  <label class="control-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                     <input type="text" ng-model="donador.nombre" class="form-control">
                  </div>
               </div>
               <div class="form-group"  ng-class="{'has-error': formAgregar.telefono.$invalid}">
                  <label class="control-label col-sm-3">Telefono:</label>
                  <div class="col-sm-8">
                     <input type="text" name="telefono" minlength="8" maxlength="15" ng-model="donador.telefono" class="form-control">
                  </div>
               </div>
               <div class="form-group" ng-class="{'has-error': formAgregar.email.$invalid}">
                  <label class="control-label col-sm-3">Email:</label>
                  <div class="col-sm-8">
                     <input type="email" name="email" ng-model="donador.email" class="form-control">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">Tipo Donante:</label>
                  <div class="col-sm-6">
                     <select class="form-control" ng-model="donador.idTipoEntidad">
                        <option value="{{tipoEntidad.idTipoEntidad}}" ng-repeat="tipoEntidad in lstTipoEntidad">
                           {{tipoEntidad.tipoEntidad}}
                        </option>
                     </select>
                  </div>
               </div>
               
               <div class="form-group" ng-class="{'has-error': formAgregar.fechaIngreso.$invalid}">
                  <label class="control-label col-sm-3">Fecha Ingreso:</label>
                  <div class="col-sm-6">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaIngreso" class="form-control" ng-model="donador.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="guardarDonador()"><i class="glyphicon glyphicon-saved"></i> Guardar Donador</button>
         </div>
      </div>
   </div>
</div>



<!-- VENTANA MODAL EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
         <div class="modal-header title-editar">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-user"></span> Actualizar Donador
            </h4>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" name="formAgregar">
               <div class="form-group">
                  <label class="control-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                     <input type="text" ng-model="itemDonador.nombre" class="form-control">
                  </div>
               </div>
               <div class="form-group"  ng-class="{'has-error': formAgregar.telefono.$invalid}">
                  <label class="control-label col-sm-3">Telefono:</label>
                  <div class="col-sm-8">
                     <input type="text" name="telefono" minlength="8" maxlength="15" ng-model="itemDonador.telefono" class="form-control">
                  </div>
               </div>
               <div class="form-group" ng-class="{'has-error': formAgregar.email.$invalid}">
                  <label class="control-label col-sm-3">Email:</label>
                  <div class="col-sm-8">
                     <input type="email" name="email" ng-model="itemDonador.email" class="form-control">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">Tipo Donante:</label>
                  <div class="col-sm-6">
                     <select class="form-control" ng-model="itemDonador.idTipoEntidad">
                        <option value="{{tipoEntidad.idTipoEntidad}}" ng-repeat="tipoEntidad in lstTipoEntidad">
                           {{tipoEntidad.tipoEntidad}}
                        </option>
                     </select>
                  </div>
               </div>
               <div class="form-group" ng-class="{'has-error': formAgregar.fechaIngreso.$invalid}">
                  <label class="control-label col-sm-3">Fecha Ingreso:</label>
                  <div class="col-sm-6">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaIngreso" class="form-control" ng-model="itemDonador.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="actualizarDonador()"><i class="glyphicon glyphicon-saved"></i> Guardar Donador</button>
         </div>
      </div>
   </div>
</div>