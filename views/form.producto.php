<div class="row">
   <div class="title-section">
      <span class="titulo">PRODUCTOS</span>
   </div>
   <div class="col-sm-12 text-right">
      <button type="button" class="btn btn-success btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
         <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
         Agregar Producto
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
               <input type="text" class="form-control" ng-model="searchProducto"  placeholder="Buscar Producto">
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="panel panel-primary" ng-repeat="(ixProducto, producto) in lstProductos">
         <div class="panel-heading">
            <a ng-click="producto.mostrar=!producto.mostrar">
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': producto.mostrar, 'glyphicon-chevron-down': !producto.mostrar}"></span>
               <strong ng-if="filtro=='tipoProducto'">
                  {{ producto.tipoProducto }}
               </strong>
               <strong ng-if="filtro=='seccionBodega'">
                  {{ producto.seccionBodega }}
               </strong>
               <strong ng-if="filtro=='clasificacion'">
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
            <div class="text-right">
               <div class="btn-group " role="group" aria-label="...">
                  <div class="btn-group" role="group">
                     <button type="button" class="btn btn-sm btn-success">
                        Stock Alto
                        <span class="badge">
                           {{producto.totalStockAlto}}
                        </span>
                     </button>
                  </div>
                  <div class="btn-group" role="group">
                     <button type="button" class="btn btn-sm btn-warning">
                        Alerta Stock
                        <span class="badge">
                           {{producto.totalAlertas}}
                        </span>
                     </button>
                  </div>
                  <div class="btn-group" role="group">
                     <button type="button" class="btn btn-sm btn-danger">
                        Stock Vacio
                        <span class="badge">
                           {{producto.totalStockVacio}}
                        </span>
                     </button>
                  </div>
               </div>
            </div>
            <br>
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="text-center col-sm-4">Producto</th>
                     <th class="text-center">Tipo Producto</th>
                     <th class="text-center">Perecedero</th>
                     <th class="text-center">Mínima</th>
                     <th class="text-center">Máxima</th>
                     <th class="text-center">Disponible</th>
                     <th class="text-center">Ubicación</th>
                     <th class="text-center">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixProducto, producto) in producto.lstProductos | orderBy: '-cantidadMinima' | filter:searchProducto" ng-class="{'danger': producto.alertaStock==1,'warning': producto.alertaStock==2,'success': producto.alertaStock==3}">
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
                     <td class="text-center"> {{ producto.cantidadMinima }}  </td>
                     <td class="text-center"> {{ producto.cantidadMaxima }}  </td>
                     <td class="text-center"> {{ producto.totalProducto }}  </td>
                     <td class="text-center"> {{ producto.ubicacionBodega }} </td>
                     <td>
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
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
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header title-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-plus"></span> Agregar Producto
            </h4>
         </div>
         <div class="modal-body">              
            <form class="form-horizontal" novalidate autocomplete="off">
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Área Bodega
                  </label>
                  <div class="col-sm-4">
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
                        <option value="{{ tipoProducto.idTipoProducto }}" ng-repeat="tipoProducto in lstTiposProducto">
                           {{tipoProducto.tipoProducto}}
                        </option>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Descripción Producto
                  </label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control" maxlength="95" ng-model="producto.producto">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Es Perecedero
                  </label>
                  <div class="col-sm-5">
                     <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':producto.perecedero}" ng-click="producto.perecedero=true">
                        Si <span class="glyphicon" ng-class="{'glyphicon-check': producto.perecedero, 'glyphicon-unchecked': !producto.perecedero}"></span>
                     </button>
                     <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':!producto.perecedero}" ng-click="producto.perecedero=false">
                        No <span class="glyphicon" ng-class="{'glyphicon-check': !producto.perecedero, 'glyphicon-unchecked': producto.perecedero}"></span>
                     </button>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Cantidad Mínima
                  </label>
                  <div class="col-sm-4">
                     <input type="number" class="form-control" ng-model="producto.cantidadMinima">
                  </div>
                  <span class="glyphicon glyphicon-triangle-bottom"></span>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Cantidad Máxima
                  </label>
                  <div class="col-sm-4">
                     <input type="number" class="form-control" ng-model="producto.cantidadMaxima">
                  </div>
                  <span class="glyphicon glyphicon-triangle-top"></span>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Observación
                  </label>
                  <div class="col-sm-8">
                     <textarea class="form-control" rows="3" ng-model="producto.observacion"></textarea>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="guardarProducto()"><i class="glyphicon glyphicon-saved"></i> Guardar Producto</button>
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