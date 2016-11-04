<div class="row">
   <div class="title-section">
      <span class="titulo">PROVEEDOR</span>
   </div>
   <div class="col-sm-12 text-right" style="margin-bottom: 10px">
      <a class="btn btn-primary btn-sm noBorder" target="_blank" href="reporte.provee.producto.php">
         <span class="glyphicon glyphicon-save"></span>
         Generar Reporte
      </a>
      <button type="button" class="btn btn-success btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
         <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
         Agregar Proveedor
      </button>
   </div>
   <div class="col-sm-12">
      <div class="row">
         <div class="col-sm-offset-8 col-sm-4">
            <div class="input-group">
               <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Buscar:</button>
               </span>
               <input type="text" class="form-control" ng-model="searchProveedor"  placeholder="Buscar Proveedor">
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <a ng-click="proveedor.mostrar=!proveedor.mostrar">
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': proveedor.mostrar, 'glyphicon-chevron-down': !proveedor.mostrar}"></span>
               <strong>
                  LISTA DE PROVEEDORES
               </strong>
            </a>
            <div class="pull-right">
               <label class="label label-primary">
                  <strong>TOTAL: <span class="badge">{{lstProveedores.length}}</span></strong>
               </label>
            </div>
         </div>
         <div class="panel-body" ng-hide="proveedor.mostrar">
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th class="text-center">No.</th>
                     <th class="text-center col-sm-4">Proveedor</th>
                     <th class="text-center">Telefono</th>
                     <th class="text-center">Email</th>
                     <th class="text-center">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixProveedor, proveedor) in lstProveedores | filter: searchProveedor">
                     <td class="text-center">
                        {{ proveedor.idProveedor }}
                     </td>
                     <td>
                        {{ proveedor.proveedor }}
                     </td>
                     <td class="text-center"> {{ proveedor.telefono }} </td>
                     <td class="text-center"> {{ proveedor.email }}  </td>
                     <td>
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button class="btn btn-xs btn-opcion" ng-click="editarDonador( donador )">
                              <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                           </button>
                           <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                              <span class="glyphicon glyphicon-folder-open"></span> Catalogo
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
               <span class="glyphicon glyphicon-plus"></span> Agregar Proveedor
            </h4>
         </div>
         <div class="modal-body">              
            <form class="form-horizontal" novalidate autocomplete="off">
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Proveedor
                  </label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control" maxlength="50" ng-model="proveedor.nombre">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Telefono
                  </label>
                  <div class="col-sm-6">
                     <input type="number" class="form-control" ng-model="proveedor.telefono">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">
                     Correo
                  </label>
                  <div class="col-sm-6">
                     <input type="email" class="form-control" maxlength="35" ng-model="proveedor.email">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="guardarProveedor()"><i class="glyphicon glyphicon-saved"></i> Guardar Proveedor</button>
         </div>
      </div>
   </div>
</div>