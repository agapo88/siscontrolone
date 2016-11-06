<div class="row">
   <div class="title-section">
      <span class="titulo">
         <span class="glyphicon glyphicon-flag"></span> DESASTRES
      </span>
   </div>
</div>

<div class="col-sm-12 text-right">
   <button type="button" class="btn btn-success btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
      <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
      Agregar Desastre
   </button>
</div>

<!-- AGREGAR FAMILIAS -->
<div class="col-sm-12" style="margin-top: 50px">
   <table class="table table-striped table-hover">
      <thead>
         <tr>
            <th>No.</th>
            <th>Desastre</th>
            <th>Fecha Desastre</th>
            <th>Tipo de Desastre</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <tr ng-repeat="desastre in lstDesastres">
            <td>{{ $index+1 }}</td>
            <td>{{desastre.desastre}}</td>
            <td>{{desastre.fechaDesastre | date :  "dd/MM/y" }}</td>
            <td>{{desastre.tipoDesastre}}</td>
            <td>
               <div class="menu-opciones">
                  <button class="btn btn-xs btn-opcion" ng-click="editar=!editar">
                     <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span> Editar
                  </button>
                  <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                     <span class="glyphicon glyphicon-signal"></span> Estadisticas
                  </button>
               </div>
            </td>
            
         </tr>
      </tbody>
   </table>
</div>

<!-- VENTANA MODAL AGREGAR -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header title-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
               <span class="glyphicon glyphicon-flag"></span> Agregar Desastre
            </h4>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" novalidate autocomplete="off">
               <div class="form-group">
                  <label class="control-label col-sm-3">Desastre:</label>
                  <div class="col-sm-7 col-md-7">
                     <input type="text" class="form-control" ng-model="desastre.desastre" maxlength="100">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">Tipo Desastre:</label>
                  <div class="col-sm-6 col-md-6">
                     <select class="form-control" ng-model="desastre.idTipoDesastre">
                        <option value="{{tipoDesastre.idTipoDesastre}}" ng-repeat="tipoDesastre in lstTiposDesastre">
                           {{tipoDesastre.tipoDesastre}}
                        </option>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-3">Fecha Del Desastre:</label>
                  <div class="col-sm-5 col-md-5">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaDonacion" class="form-control" ng-model="desastre.fechaDesastre" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="margin-top: 25px">
                  <div class="col-sm-12 text-right">
                     <button type="button" class="btn btn-success noBorder" ng-click="guardarDesastre()">
                        <i class="glyphicon glyphicon-saved"></i> Guardar Desastre
                     </button>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()">
               <i class="glyphicon glyphicon-log-out"></i> Cerrar
            </button>
         </div>
      </div>
   </div>
</div>
