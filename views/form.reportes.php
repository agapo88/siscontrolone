<div class="row">
   <div class="title-section">
      <span class="titulo">REPORTES</span>
   </div>

   <div class="col-sm-12" style="margin-top: 20px">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <a ng-click="entidad.mostrar=!entidad.mostrar">
               <span class="glyphicon" ng-class="{'glyphicon-chevron-right': entidad.mostrar, 'glyphicon-chevron-down': !entidad.mostrar}"></span>
               <strong >
                  PRODUCTOS POR VENCER
               </strong>
            </a>
         </div>
         <div class="panel-body" ng-hide="entidad.mostrar">
            <form class="form-horizontal" action="reporte.productos.php" method="POST" target="_blank" autocomplete="off" style="margin-top: 20px; margin-bottom: 20px;" name="frmProductosP">
               <div class="form-group">
                  <!-- INICIO -->
                  <label class="col-sm-2 col-md-2 control-label">Fecha Inicio</label>
                  <div class="col-sm-3 col-md-2 col-lg-2">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaInicio" value="{{ fechaInicio }}" class="form-control" ng-model="fechaInicio" data-date-format="dd/MM/yyyy" data-date-type="number" data-max-date="{{fechaFinal}}" data-autoclose="1" bs-datepicker required>
                     </div>
                  </div>
                  <!-- FECHA FINAL -->
                  <label class="col-sm-2 col-md-2 control-label">Fecha Inicio</label>
                  <div class="col-sm-3 col-md-2 col-lg-2">
                     <div class="input-group">
                        <span class="input-group-addon">
                           <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" name="fechaFinal" value="{{ fechaFinal }}" class="form-control" ng-model="fechaFinal" data-date-format="dd/MM/yyyy" data-date-type="number"  data-min-date="{{fechaInicio}}" data-autoclose="1" bs-datepicker required>
                     </div>
                  </div>
                  <button type="" class="btn btn-success btn-sm noBorder" ng-disabled="frmProductosP.$invalid">
                     <span class="glyphicon glyphicon-save"></span> Generar
                  </button>
               </div>
            </form>
         </div>
         <div class="panel-footer">
            <strong>Generar reporte de Productos por vencer</strong>
         </div>
      </div>


   </div>
</div>