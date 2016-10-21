
<div class="row">
   <div class="title-section">
      <span class="titulo">
         <i class="glyphicon glyphicon-shopping-cart"></i> COMPRAS
      </span>
   </div>
   <div class="col-sm-12">
            
      <div class="col-sm-12 text-right">
         <strong>MONEDA</strong>
         <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':idTipoMoneda==1}" ng-click="idTipoMoneda=1">
            <span class="glyphicon" ng-class="{'glyphicon-check': idTipoMoneda==1, 'glyphicon-unchecked': idTipoMoneda==2}"></span> QUETZALES
         </button>
         <button type="button" class="btn btn-default noBorder" ng-class="{'btn-success':idTipoMoneda == 2}" ng-click="idTipoMoneda=2">
            <span class="glyphicon" ng-class="{'glyphicon-check': idTipoMoneda==2, 'glyphicon-unchecked': idTipoMoneda==1}"></span> DOLARES
         </button>
      </div>
      <div class="form-group text-right">
         <div class="col-sm-12">
            <h3 class="h3" ng-show="idTipoMoneda==1">
               DISPONIBLE: Q.{{ compras.totalQuetzales - subTotalQuetzales() | number: 2 }} 
            </h3>
            <h3 class="h3" ng-show="idTipoMoneda==2">
               DISPONIBLE: $.{{ comprasD.totalDolares - subTotalDolares() | number: 2 }} 
            </h3>
         </div>
      </div>
      <!-- QUETZALES -->
      <form class="form-horizontal" novalidate autocomplete="off" ng-show="idTipoMoneda==1">
         <div class="form-group">
            <label class="control-label col-sm-3">
               No. Factura
            </label>
            <div class="col-sm-3 col-md-2">
               <input type="number" class="form-control" id="numeroFactura" ng-model="compras.noFactura">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-sm-3">Fecha Adquisición:</label>
            <div class="col-sm-3 col-md-2">
               <div class="input-group">
                  <span class="input-group-addon">
                     <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="fechaDonacion" class="form-control" ng-model="compras.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
               </div>
            </div>
            <label class="control-label col-sm-2 col-md-2">Proveedor:</label>
            <div class="col-sm-4 col-md-4">
               <select class="form-control" ng-model="compras.idProveedor">
                  <option value="{{ proveedor.idProveedor }}" ng-repeat="proveedor in lstProveedores">
                     {{ proveedor.proveedor }} 
                  </option>
               </select>
            </div>
         </div>
         <!-- SELECCIONAR PRODUCTOS -->
         <div class="form-group" style="margin-left: 5px; margin-right: 5px">
            <label class="label label-default">Agregar compras</label>
            <table class="table table-striped table-condensed">
               <thead>
                  <tr>
                     <th class="col-sm-3 text-center">compras</th>
                     <th class="col-sm-3 text-center">Cantidad</th>
                     <th class="col-sm-3 text-center">Precio Unitario</th>
                     <th class="col-sm-2 text-center">Fecha Caducidad</th>
                     <th class="text-center">Agregar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>
                        <select class="form-control" ng-model="detalleCompra.idProducto">
                           <option value="{{ producto.idProducto }}" ng-repeat="producto in lstProductos">
                              {{producto.producto}}
                           </option>
                        </select>
                     </td>
                     <td class="text-center">
                        <input type="number" class="form-control" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" ng-model="detalleCompra.cantidad">
                     </td>
                     <td class="text-left">
                        <input type="number" class="form-control" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" ng-model="detalleCompra.precioUnitario">
                     </td>
                     <td class="text-left">
                        <input type="text" class="form-control" ng-model="detalleCompra.fechaCaducidad" data-date-format="dd/MM/yyyy" data-date-type="number" data-min-date="today" data-autoclose="1" bs-datepicker ng-disabled="!bloquearFecha">
                     </td>
                     <td class="text-center">
                        <button type="button" class="btn btn-xs btn-success" ng-click="addCompra( 1 )">
                           <span class="glyphicon glyphicon-plus"></span>
                        </button>
                     </td>
                  </tr>
                  <tr> 
                     <td colspan="5" class="text-right">
                        <!-- CANCELAR AGREGAR compras -->
                        <button type="button" class="btn btn-danger btn-sm noBorder" ng-click="resetObject()">
                           CANCELAR
                        </button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <hr>
         <div class="form-group text-center">
            <legend>LISTADO DE PRODUCTOS</legend>
         </div>
         <div class="form-group" style="margin-left: 5px; margin-right: 5px">
            <label class="label label-info">Listado de Productos</label>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="col-sm-3 text-center">Producto</th>
                     <th class="col-sm-3 text-center">Proveedor</th>
                     <th class="col-sm-1 text-center">Cantidad</th>
                     <th class="col-sm-1 text-center">Precio Unitario</th>
                     <th class="col-sm-2 text-center">Fecha Caducidad</th>
                     <th class="text-center">Total</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <!-- QUETZALES -->
                  <tr ng-repeat="(ixProd, prod) in compras.lstProductos" ng-show="compras.lstProductos.length > 0">
                     <td>
                        {{ prod.idProducto }}
                     </td>
                     <td class="text-center">
                        <select class="form-control" ng-model="prod.idProducto" ng-show="editarProd">
                           <option value="{{ producto.idProducto }}" ng-repeat="producto in lstProductos">
                              {{producto.producto}}
                           </option>
                        </select>
                        <div ng-show="!editarProd">
                           {{ verNombreProducto(prod.idProducto) }}
                        </div>
                     </td>
                     <td class="text-center">
                        <select class="form-control" ng-model="prod.idProveedor" ng-show="editarProd">
                           <option value="{{ proveedor.idProveedor }}" ng-repeat="proveedor in lstProveedores">
                              {{ proveedor.proveedor }} 
                           </option>
                        </select>
                        <div ng-show="!editarProd">
                           {{ verNombreProveedor(prod.idProveedor) }}
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="editarProd">
                           <input type="number" class="form-control" ng-model="prod.cantidad" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01">
                        </div>
                        <div ng-show="!editarProd">
                           {{ prod.cantidad }}
                        </div>
                     </td>
                     <td class="text-right">
                        <div ng-show="editarProd">
                           <input type="number" class="form-control" ng-model="prod.precioUnitario" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01">
                        </div>
                        <div ng-show="!editarProd">
                           {{ prod.precioUnitario | number }}
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="editarProd">
                           <input type="text" class="form-control" ng-model="prod.fechaCaducidad" data-date-format="dd/MM/yyyy" data-date-type="number" data-min-date="today" data-autoclose="1" bs-datepicker ng-disabled="!bloquearFecha">
                        </div>
                        <div ng-show="!editarProd">
                           {{ prod.fechaCaducidad | date :  "dd/MM/y" }}
                        </div>
                     </td>
                     <td class="text-right">{{ prod.cantidad * prod.precioUnitario | number: 2 }}</td>
                     <td class="text-center">
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button type="button" class="btn btn-xs btn-opcion" ng-click="editarProd=!editarProd" ng-show="editarProd">
                              <span class="glyphicon glyphicon-ok"></span>
                           </button>
                           <button type="button" class="btn btn-xs btn-opcion" ng-click="editarProd=!editarProd" ng-show="!editarProd">
                              <span class="glyphicon glyphicon-pencil"></span>
                           </button>
                           <button type="button" class="btn btn-xs btn-opcion" ng-click="deleteProdQuetzales( ixProd )" ng-show="!editarProd">
                              <span class="glyphicon glyphicon-remove"></span>
                           </button>
                        </div>
                     
                     </td>
                  </tr>
                  <tr id="tb-title" ng-show="compras.lstProductos.length > 0">
                     <td colspan="7" class="text-right">
                        <strong> SUBTOTAL {{ subTotalQuetzales() | number: 2 }}</strong>
                     </td>
                     <td></td>
                  <td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="form-group" style="margin-top: 20px">
            <div class="col-sm-12 text-right">
               <button type="button" class="btn btn-success btn-lg noBorder" ng-click="guardarCompraQ()">
                  <i class="glyphicon glyphicon-saved"></i> Guardar Compra
               </button>
            </div>
         </div>
      </form>
      <!-- DOLARES -->
      <form class="form-horizontal" novalidate autocomplete="off" ng-show="idTipoMoneda==2">
         <div class="form-group">
            <label class="control-label col-sm-3">
               No. Factura
            </label>
            <div class="col-sm-3 col-md-2">
               <input type="number" class="form-control" id="numeroFactura" ng-model="comprasD.noFactura">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-sm-3">Fecha Adquisición:</label>
            <div class="col-sm-3 col-md-2">
               <div class="input-group">
                  <span class="input-group-addon">
                     <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="fechaDonacion" class="form-control" ng-model="comprasD.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
               </div>
            </div>
            <label class="control-label col-sm-2 col-md-2">Proveedor:</label>
            <div class="col-sm-4 col-md-4">
               <select class="form-control" ng-model="comprasD.idProveedor">
                  <option value="{{ proveedor.idProveedor }}" ng-repeat="proveedor in lstProveedores">
                     {{ proveedor.proveedor }} 
                  </option>
               </select>
            </div>
         </div>

         <!-- SELECCIONAR PRODUCTOS -->
         <div class="form-group" style="margin-left: 5px; margin-right: 5px">
            <label class="label label-default">Agregar compras</label>
            <table class="table table-striped table-condensed">
               <thead>
                  <tr>
                     <th class="col-sm-3 text-center">compras</th>
                     <th class="col-sm-3 text-center">Cantidad</th>
                     <th class="col-sm-3 text-center">Precio Unitario</th>
                     <th class="col-sm-2 text-center">Fecha Caducidad</th>
                     <th class="text-center">Agregar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>
                        <select class="form-control" ng-model="detalleCompra.idProducto">
                           <option value="{{ producto.idProducto }}" ng-repeat="producto in lstProductos">
                              {{producto.producto}}
                           </option>
                        </select>
                     </td>
                     <td class="text-center">
                        <input type="number" class="form-control" ng-model="detalleCompra.cantidad">
                     </td>
                     <td class="text-left">
                        <input type="number" class="form-control" ng-model="detalleCompra.precioUnitario">
                     </td>
                     <td class="text-left">
                        <input type="text" class="form-control" ng-model="detalleCompra.fechaCaducidad" data-date-format="dd/MM/yyyy" data-date-type="number" data-min-date="today" data-autoclose="1" bs-datepicker ng-disabled="!bloquearFecha">
                     </td>
                     <td class="text-center">
                        <button type="button" class="btn btn-xs btn-success" ng-click="addCompra( 2 )">
                           <span class="glyphicon glyphicon-plus"></span>
                        </button>
                     </td>
                  </tr>
                  <tr> 
                     <td colspan="5" class="text-right">
                        <!-- CANCELAR AGREGAR compras -->
                        <button type="button" class="btn btn-danger btn-sm noBorder" ng-click="resetObject()">
                           CANCELAR
                        </button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <hr>
         <div class="form-group text-center">
            <legend>LISTADO DE PRODUCTOS</legend>
         </div>
         <div class="form-group" style="margin-left: 5px; margin-right: 5px">
            <label class="label label-info">Listado de Productos</label>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="col-sm-3 text-center">Producto</th>
                     <th class="col-sm-3 text-center">Proveedor</th>
                     <th class="col-sm-1 text-center">Cantidad</th>
                     <th class="col-sm-1 text-center">Precio Unitario</th>
                     <th class="col-sm-2 text-center">Fecha Caducidad</th>
                     <th class="text-center">Total</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <!-- QUETZALES -->
                  <tr ng-repeat="(ixProd, prod) in comprasD.lstProductos" ng-show="comprasD.lstProductos.length > 0">
                     <td>{{ prod.idProducto }}</td>
                     <td class="text-center">
                        <select class="selectpicker" ng-model="prod.idProducto" disabled>
                           <option value="{{ producto.idProducto }}" ng-repeat="producto in lstProductos">
                              {{producto.producto}}
                           </option>
                        </select>
                     </td>
                     <td class="text-center">
                        <select class="selectpicker" ng-model="prod.idProveedor" disabled>
                           <option value="{{ proveedor.idProveedor }}" ng-repeat="proveedor in lstProveedores">
                              {{ proveedor.proveedor }} 
                           </option>
                        </select>
                     </td>
                     <td class="text-center">{{ prod.cantidad }}</td>
                     <td class="text-right">{{ prod.precioUnitario | number: 2 }}</td>
                     <td class="text-center">{{ prod.fechaCaducidad | date :  "dd/MM/y" }}</td>
                     <td class="text-right">{{ prod.cantidad * prod.precioUnitario | number: 2 }}</td>
                     <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs" ng-click="deleteProdQuetzales( ixProd )">
                           <span class="glyphicon glyphicon-remove"></span>
                        </button>
                     </td>
                  </tr>
                  <tr id="tb-title" ng-show="compras.lstProductos.length > 0">
                     <td colspan="7" class="text-right">
                        <strong> SUBTOTAL {{ subTotalQuetzales() | number: 2 }}</strong>
                     </td>
                     <td></td>
                  <td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="form-group" style="margin-top: 20px">
            <div class="col-sm-12 text-right">
               <button type="button" class="btn btn-success btn-lg noBorder" ng-click="guardarCompraQ()">
                  <i class="glyphicon glyphicon-saved"></i> Guardar Compra
               </button>
            </div>
         </div>
      </form>
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