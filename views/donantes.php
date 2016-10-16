<div class="row">
   <div class="title-section">
      <span class="titulo">DONANTES</span>
   </div>
   <div class="col-sm-12 text-right">
      <button type="button" class="btn btn-primary btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
         <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
         Agregar Donador
      </button>
   </div>
   <div class="col-sm-12">
      <b>AGRUPAR POR:</b>
      <div class="btn-group" role="group" aria-label="...">
         <button type="button" class="btn btn-default" ng-click="filtro=''">
            <span class="glyphicon" ng-class="{'glyphicon-ok': filtro==''}"></span> Ninguno
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='tipoEntidad'">
            <span class="glyphicon" ng-class="{'glyphicon-ok': filtro=='tipoEntidad'}"></span> Tipo de Entidad
         </button>
         <button type="button" class="btn btn-default" ng-click="filtro='anio'">
            <span class="glyphicon" ng-class="{'glyphicon-ok': filtro=='anio'}"></span> Año
         </button>
      </div>
   </div>
   <div class="col-sm-12">
      <form class="navbar-right" role="search">
         <div class="form-group">
            <label class="control-label col-sm-4">Buscar Donador:</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" ng-model="searchDonador" placeholder="Buscar donador">
            </div>
         </div>
      </form>
   </div>
   <div class="col-sm-12">
      <div class="panel panel-default" ng-repeat="(ixEntidad, entidad) in lstEntidades ">
         <div class="panel-heading">
            <a ng-click="entidad.mostrar=!entidad.mostrar">
               <strong>
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': entidad.mostrar, 'glyphicon-chevron-down': !entidad.mostrar}"></span>
               {{ entidad.tipoEntidad }}
               </strong>
            </a>
         </div>
         <div class="panel-body" ng-hide="entidad.mostrar">
            <table class="table table-striped table-hover">
               <thead>
                  <tr id="tb-title">
                     <th class="text-center">No.</th>
                     <th class="text-center">Donador</th>
                     <th class="text-center">Tipo Donador</th>
                     <th class="text-center">Telefono</th>
                     <th class="text-center">Correo</th>
                     <th class="text-center">Fecha Ingreso</th>
                     <th class="text-center">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixDonante, donante) in entidad.lstDonantes | filter:searchDonador" ng-init="$idIndex = $index">
                     <td class="text-center"> {{ $idIndex + 1 }} </td>
                     <td> {{ donante.nombre }} </td>
                     <td class="text-center"> {{ donante.tipoEntidad }} </td>
                     <td class="text-center"> {{ donante.telefono }} </td>
                     <td class="text-center"> {{ donante.fechaIngreso }} </td>
                     <td class="text-center"> {{ donante.email }} </td>
                     <td>
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button class="btn btn-xs btn-opcion" ng-click="removeMiembro( ixMiembro )" >
                              <span class="glyphicon glyphicon-remove"></span>
                           </button>
                           <button class="btn btn-xs btn-opcion">
                              <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                           </button>
                           <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                              <span class="glyphicon glyphicon-plus"></span> Oficio
                           </button>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
                     donante.idDonador
         </div>
      </div>
   </div>
</div>


<!-- VENTANA MODAL AGREGAR -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header title-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-user"></span> Agregar Donador
            </h4>
         </div>
         <div class="modal-body">
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