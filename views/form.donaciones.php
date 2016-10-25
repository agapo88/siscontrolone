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
         <button type="button" class="btn btn-default" ng-click="filtro='fechaDonacion'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='fechaDonacion', 'glyphicon-unchecked': filtro!='fechaDonacion'}"></span> Fecha Donación
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='moneda'">
            <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='moneda', 'glyphicon-unchecked': filtro!='moneda'}"></span> Moneda
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
               <input type="text" class="form-control" ng-model="searchDonador"  placeholder="Buscar donación">
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="panel panel-fondo" ng-repeat="(ixFondo, fondoComun) in lstFondoComun ">
         <div class="panel-heading">
            <a ng-click="fondoComun.mostrar=!fondoComun.mostrar">
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': fondoComun.mostrar, 'glyphicon-chevron-down': !fondoComun.mostrar}"></span>
               <strong ng-show="filtro=='tipoEntidad'">
                  {{ fondoComun.tipoEntidad }}
               </strong>
               <strong ng-show="filtro=='fechaDonacion'">
                  {{ fondoComun.fechaDonacion }}
               </strong>
               <strong ng-show="filtro=='moneda'">
                  {{ fondoComun.moneda }}
               </strong>
            </a>
            <div class="pull-right">
               <label class="label label-primary">
                  <strong>TOTAL: <span class="badge">{{fondoComun.totalDonacionEntidad}}</span></strong>
               </label>
            </div>
         </div>
         <div class="panel-body" ng-hide="fondoComun.mostrar">
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="text-center">Donador</th>
                     <th class="text-center" ng-if="filtro!='tipoEntidad'">Tipo Donador</th>
                     <th class="text-center">Telefono</th>
                     <th class="text-center">Fecha Ingreso</th>
                     <th class="text-center">Telefono</th>
                     <th class="text-center">Donación</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixFondo, fondo) in fondoComun.lstFondos | filter:searchDonador || searchDonante" ng-init="$idIndex = $index">
                     <td class="text-center">
                      {{ $idIndex + 1 }} </td>
                     <td>
                        <span class="glyphicon glyphicon-user" ng-hide="fondo.idDonador"></span>
                        {{ fondo.nombre }}
                     </td>
                     <td class="text-center" ng-if="filtro!='tipoEntidad'"> {{ fondo.tipoEntidad }} </td>
                     <td class="text-center"> {{ fondo.telefono }} </td>
                     <td class="text-center"> {{ fondo.fechaDonacion }} </td>
                     <td class="text-center"> {{ fondo.telefono }} </td>
                     <td class="text-right"> {{ fondo.tipoMoneda + (fondo.donacion | number:2) }} </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>


<!-- VENTANA MODAL AGREGAR -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog  modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header title-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-user"></span> Agregar Donador
            </h4>
         </div>
         <div class="modal-body">
            <!-- TABS -->
            <ul class="nav nav-tabs" role="tablist">
               <li role="presentation" ng-class="{'active': tab==1}" ng-click="tab=1"><a role="tab">Fondo Común</a></li>
               <li role="presentation" ng-class="{'active': tab==2}" ng-click="tab=2"><a role="tab">Productos</a></li>
            </ul>

            <div>
              <!-- Tab panes -->
              <div class="tab-content" >
                  <div style="margin-top:15px">
                     <!-- FONDO COMUN -->
                     <div role="tabpanel" ng-show="tab==1">
                        <form class="form-horizontal" novalidate autocomplete="off">
                           <div class="form-group">
                              <div class="col-sm-11 text-right">
                                 <strong>DONADOR ANONIMO</strong>
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-primary':donacionFondo.esAnonimo}" ng-click="donacionFondo.esAnonimo=!donacionFondo.esAnonimo">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': donacionFondo.esAnonimo==1, 'glyphicon-unchecked': !donacionFondo.esAnonimo}"></span> Si
                                 </button>
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-primary':!donacionFondo.esAnonimo}" ng-click="donacionFondo.esAnonimo=!donacionFondo.esAnonimo">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': !donacionFondo.esAnonimo, 'glyphicon-unchecked': donacionFondo.esAnonimo}"></span> No
                                 </button>
                              </div>
                           </div>
                           <div class="form-group" ng-hide="donacionFondo.esAnonimo">
                              <label class="control-label col-sm-3">
                                 Donador
                              </label>
                              <div class="col-sm-8">
                                 <select class="form-control" ng-model="donacionFondo.idDonador">
                                    <option value="{{ donador.idDonador }}" ng-repeat="donador in lstDonadores">
                                       {{donador.nombre}}
                                    </option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-sm-2">
                                 Moneda
                              </label>
                              <div class="col-sm-5">
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':donacionFondo.idMoneda==1}" ng-click="donacionFondo.idMoneda=1">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': donacionFondo.idMoneda==1, 'glyphicon-unchecked': donacionFondo.idMoneda==2}"></span> Quetzales
                                 </button>
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':donacionFondo.idMoneda==2}" ng-click="donacionFondo.idMoneda=2">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': donacionFondo.idMoneda==2, 'glyphicon-unchecked': donacionFondo.idMoneda==1}"></span> Dolares
                                 </button>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-sm-2">
                                 Monto
                              </label>
                              <div class="col-sm-3">
                                 <input type="number" class="form-control" ng-model="donacionFondo.cantidad" step="0.01">
                              </div>
                              <label class="control-label col-sm-2">Fecha Ingreso:</label>
                              <div class="col-sm-4 col-md-3">
                                 <div class="input-group">
                                    <span class="input-group-addon">
                                       <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                    <input type="text" name="fechaDonacion" class="form-control" ng-model="donacionFondo.fechaDonacion" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group" style="margin-top: 25px">
                              <div class="col-sm-12 text-right">
                                 <button type="button" class="btn btn-success btn-lg noBorder" ng-click="guardarDonacionFondo()">
                                    <i class="glyphicon glyphicon-saved"></i> Guardar Donación
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                     <!-- FONDO PRODUCTOS -->
                     <div role="tabpanel" ng-show="tab==2">
                        <form class="form-horizontal" novalidate autocomplete="off">
                           <div class="form-group">
                              <div class="col-sm-11 text-right">
                                 <strong>DONADOR ANONIMO</strong>
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':donacionProducto.esAnonimo}" ng-click="donacionProducto.esAnonimo=!donacionProducto.esAnonimo">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': donacionProducto.esAnonimo==1, 'glyphicon-unchecked': !donacionProducto.esAnonimo}"></span> Si
                                 </button>
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':!donacionProducto.esAnonimo}" ng-click="donacionProducto.esAnonimo=!donacionProducto.esAnonimo">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': !donacionProducto.esAnonimo, 'glyphicon-unchecked': donacionProducto.esAnonimo}"></span> No
                                 </button>
                              </div>
                           </div>
                           <div class="form-group" ng-hide="donacionProducto.esAnonimo">
                              <label class="control-label col-sm-3">
                                 Donador
                              </label>
                              <div class="col-sm-8">
                                 <select class="form-control" ng-model="donacionProducto.idDonador">
                                    <option value="{{ donador.idDonador }}" ng-repeat="donador in lstDonadores">
                                       {{donador.nombre}}
                                    </option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-sm-3">
                                 Tiene Factura
                              </label>
                              <div class="col-sm-5">
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':donacionProducto.tieneFactura}" ng-click="donacionProducto.tieneFactura=true">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': donacionProducto.tieneFactura, 'glyphicon-unchecked': !donacionProducto.tieneFactura}"></span> Si
                                 </button>
                                 <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':!donacionProducto.tieneFactura}" ng-click="donacionProducto.tieneFactura=false">
                                    <span class="glyphicon" ng-class="{'glyphicon-check': !donacionProducto.tieneFactura, 'glyphicon-unchecked': donacionProducto.tieneFactura}"></span> No
                                 </button>
                              </div>
                           </div>
                           <div class="form-group" ng-show="donacionProducto.tieneFactura">
                              <label class="control-label col-sm-3">
                                 No. Factura
                              </label>
                              <div class="col-sm-4 col-md-3">
                                 <input type="number" class="form-control" id="numeroFactura" ng-model="noFactura">
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-sm-3">Fecha Adquisición:</label>
                              <div class="col-sm-4 col-md-3">
                                 <div class="input-group">
                                    <span class="input-group-addon">
                                       <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                    <input type="text" name="fechaDonacion" class="form-control" ng-model="donacionProducto.fechaDonacion" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                                 </div>
                              </div>
                           </div>

                           <!-- AGREGA PRODUCTOS -->
                           <div class="form-group" style="margin-left: 10px; margin-right: 10px">
                              <label class="label label-primary">Agregar Productos</label>
                              <table class="table table-striped table-condensed">
                                 <thead>
                                    <tr>
                                       <th class="col-sm-3 text-center">Producto</th>
                                       <th class="col-sm-3 text-center">Cantidad</th>
                                       <th class="col-sm-3 text-center">Precio Unitario</th>
                                       <th class="col-sm-2 text-center">Fecha Caducidad</th>
                                       <th class="text-center">Agregar</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <select class="form-control" ng-model="dcProducto.idProducto">
                                             <option value="{{ product.idProducto }}" ng-repeat="product in lstProductos">
                                                {{product.producto}}
                                             </option>
                                          </select>
                                       </td>
                                       <td>
                                          <input type="number" class="form-control" ng-model="dcProducto.cantidad">
                                       </td>
                                       <td>
                                          <input type="number" class="form-control" ng-model="dcProducto.precioUnitario">
                                       </td>
                                       <td>
                                          <input type="text" class="form-control" ng-model="dcProducto.fechaCaducidad" data-date-format="dd/MM/yyyy" data-date-type="number" data-max-date="today" data-autoclose="1" bs-datepicker ng-disabled="!bloquearFecha">
                                       </td>
                                       <td>
                                          <button type="button" class="btn btn-xs btn-success" ng-click="addProducto()">
                                             <span class="glyphicon glyphicon-plus"></span>
                                          </button>
                                       </td>
                                    </tr>
                                    <tr> 
                                       <td>
                                          <!-- CANCELAR AGREGAR PRODUCTO -->
                                          <button type="button" class="btn btn-danger btn-sm noBorder" ng-click="resetObject()">
                                             CANCELAR
                                          </button>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <hr>
                           <div class="form-group" style="margin-left: 10px; margin-right: 10px">
                              <label class="label label-warning">Agregar Productos</label>
                              <table class="table table-striped">
                                 <thead>
                                    <tr>
                                       <th class="col-sm-3 text-center">Producto</th>
                                       <th class="col-sm-2 text-center">Cantidad</th>
                                       <th class="col-sm-2 text-center">Precio Unitario</th>
                                       <th class="col-sm-2 text-center">Fecha Caducidad</th>
                                       <th class="col-sm-2 text-center">Total</th>
                                       <th>Quitar</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr ng-repeat="(ixProd, prod) in donacionProducto.lstProductos">
                                       <td>{{ prod.idProducto }}</td>
                                       <td>{{ prod.cantidad }}</td>
                                       <td>{{ prod.precioUnitario | number: 2 }}</td>
                                       <td>{{ prod.fechaCaducidad | date :  "dd/MM/y" }}</td>
                                       <td>{{ prod.cantidad * prod.precioUnitario | number: 2 }}</td>
                                       <td>
                                          <button type="button" class="btn btn-danger btn-xs" ng-click="removerProducto( ixProd )">
                                             <span class="glyphicon glyphicon-remove"></span>
                                          </button>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <div class="form-group" style="margin-top: 25px">
                              <div class="col-sm-12 text-right">
                                 <button type="button" class="btn btn-success btn-lg noBorder" ng-click="guardarDonacionProducto()">
                                    <i class="glyphicon glyphicon-saved"></i> Guardar Donación
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
              </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()">
               <i class="glyphicon glyphicon-log-out"></i> Cerrar
            </button>
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