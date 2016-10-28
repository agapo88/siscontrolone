<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Modal title</h4>
         </div>
         <div class="modal-body">
            <p>One fine body&hellip;</p>
            <button type="button" ng-click="agregarOficios()">
               Prueba
            </button>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="modalReporte">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div ng-repeat="ayudaFamilia in lstAyudasFam">
            <div class="modal-header title-info">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <blockquote>
                  <strong>{{ ayudaFamilia.nombreFamilia | uppercase }}</strong>
                  <footer>Reporte de donaciones y ayudas</footer>
               </blockquote>
            </div>
            <div class="modal-body" ng-repeat="desastre in ayudaFamilia.lstDesastres">

               <div class="panel panel-default">
                  <div class="panel-heading">
                     <blockquote>
                        <a ng-click="desastre.mostrar=!desastre.mostrar">
                              <span class="glyphicon" ng-class="{'glyphicon-chevron-right': desastre.mostrar, 'glyphicon-chevron-down': !desastre.mostrar}"></span>
                              <strong>{{desastre.idDesastre + '. ' + desastre.desastre | uppercase }}</strong>
                              <footer>{{desastre.tipoDesastre}}</footer>
                           <div class="pull-right">
                              <strong>TOTAL AYUDA: <span class="badge">{{desastre.totalGeneral | number:2 }}</span></strong>
                           </div>
                        </a>
                     </blockquote>
                  </div>
                  <div class="panel-body" ng-show="!desastre.mostrar" ng-repeat="anio in desastre.lstAnio">
                     <a ng-click="anio.mostrar=!anio.mostrar">
                        <span class="glyphicon" ng-class="{'glyphicon-chevron-right': desastre.mostrar, 'glyphicon-chevron-down': !desastre.mostrar}"></span>
                        <strong>
                           Año {{ anio.anio }}
                        </strong>
                     </a>
                     <div class="pull-right">
                        <label class="label label-default">
                           <strong>TOTAL: <span class="badge">{{anio.totalRecibido | number: 2}}</span></strong>
                        </label>
                     </div>
                     <table class="table table-striped" ng-show="!anio.mostrar">
                        <thead>
                           <tr>
                              <th class="text-center">No.</th>
                              <th class="text-center">Donador</th>
                              <th class="text-center">Entidad</th>
                              <th class="text-center">Mes</th>
                              <th class="text-center">Cantidad</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr ng-repeat="mes in anio.lstMeses">
                              <td>{{mes.idDonador}}</td>
                              <td>{{mes.nombre}}</td>
                              <td class="text-center">{{mes.tipoEntidad}}</td>
                              <td class="text-center">{{mes.mes}}</td>
                              <td class="text-right">{{mes.cantidad | number: 2}}</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="row">
   <div class="title-section">
      <span class="titulo">FAMILIAS</span>
   </div>

   <!--
   <div class="col-sm-12 text-right">
      <button type="button" class="btn btn-primary btn-sm noBorder" ng-mouseleave="hoveri=false" ng-mouseenter="hoveri=true" data-toggle="modal" data-target="#modalAgregar">
         <span class="glyphicon" ng-class="{'glyphicon-plus-sign': hoveri, 'glyphicon-plus':!hoveri}"></span>
         Agregar Donador
      </button>
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
   -->
</div>

<ul class="nav nav-tabs" role="tablist">
   <li role="presentation" ng-class="{'active': tab==1}" ng-click="tab=1"><a role="tab">Listado de Familias</a></li>
   <li role="presentation" ng-class="{'active': tab==2}" ng-click="tab=2"><a role="tab">Agregar Familia</a></li>
</ul>


   <!-- AGREGAR FAMILIAS -->
   <div class="col-sm-12" ng-show="tab==2" style="margin-top: 50px">
      <form class="form-horizontal" name="formAgregar">
         <div class="form-group" ng-class="{'has-error': formAgregar.familia.$invalid}">
            <label class="control-label col-sm-2">Familia:</label>
            <div class="col-sm-5">
               <input type="text" ng-model="familia.nombre" name="familia" ng-minlength="5" class="form-control" placeholder="Nombre de la Familia">
            </div>
            <label class="control-label col-sm-2">Área:</label>
            <div class="col-sm-3 col-md-2">
               <select class="form-control" ng-model="familia.idArea">
                  <option value="{{area.idArea}}" ng-repeat="area in lstAreas">
                     {{area.area}}
                  </option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-sm-2">Dirección:</label>
            <div class="col-sm-5">
               <input type="text" ng-model="familia.direccion" name="direccion" ng-minlength="5" class="form-control" placeholder="Dirección de residencia">
            </div>
            <div ng-class="{'has-error': formAgregar.fechaIngreso.$invalid}">
               <label class="control-label col-sm-2">Fecha Ingreso:</label>
               <div class="col-sm-3 col-md-2">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                     </span>
                     <input type="text" name="fechaIngreso" class="form-control" ng-model="familia.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group">

            <label class="control-label col-sm-2">Departamento:</label>
            <div class="col-sm-3">
               <div class="input-group">
                  <span class="input-group-addon">
                     <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="fechaIngreso" class="form-control" ng-model="familia.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
               </div>
            </div>
            <label class="control-label col-sm-2">Municipio:</label>
            <div class="col-sm-3">
               <div class="input-group">
                  <span class="input-group-addon">
                     <i class="glyphicon glyphicon-calendar"></i>
                  </span>
                  <input type="text" name="fechaIngreso" class="form-control" ng-model="familia.fechaIngreso" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1"  bs-datepicker>
               </div>
            </div>
         </div>
         <div class="form-group text-right">
            <button type="button" class="btn btn-info">
               <b>TOTAL MIEMBROS: <span class="badge">{{ familia.lstMiembros.length }}</span></b>
            </button>
         </div>
         
         <!-- AGREGAR MIEMBROS -->
         <div class="form-group">
            <table class="table table-striped table-hover">
               <thead>
                  <tr>
                     <th class="text-center col-sm-2">CUI</th>
                     <th class="text-center col-sm-2">Nombres</th>
                     <th class="text-center col-sm-2">Apellidos</th>
                     <th class="text-center col-sm-2">Fecha Nacimiento</th>
                     <th class="text-center col-sm-2">Género</th>
                     <th class="text-center col-sm-2">Parentesco</th>
                     <th class="text-center"></th>
                  </tr>
               </thead>
               <tbody>
                  <tr ng-repeat="(ixMiembro, miembro) in familia.lstMiembros" ng-hide="familia.lstMiembros.length==0" ng-mouseenter="mostrarMenu=true" ng-mouseleave="mostrarMenu=false">
                     <td class="text-center">
                        <div ng-show="!editar">
                           {{ miembro.cui }}
                        </div>
                        <div ng-show="editar">
                           <input type="text" class="form-control" maxlength="13" ng-model="miembro.cui">
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="!editar">
                           {{ miembro.nombres }}
                        </div>
                        <div ng-show="editar">
                           <input type="text" class="form-control" maxlength="45" ng-model="miembro.nombres">
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="!editar">
                           {{ miembro.apellidos }}
                        </div>
                        <div ng-show="editar">
                           <input type="text" class="form-control" maxlength="45" ng-model="miembro.apellidos">
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="!editar">
                           {{miembro.fechaNacimiento | date :  "dd/MM/y"}}
                        </div>
                        <div ng-show="editar">
                           <input type="text" class="form-control" ng-model="miembro.fechaNacimiento" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1" bs-datepicker>
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="!editar">
                           {{ (miembro.idGenero == 1 ? 'Masculino' : 'Femenino') }}
                        </div>
                        <div ng-show="editar">
                           <select class="form-control" ng-model="miembro.idGenero">
                              <option value="{{genero.idGenero}}" ng-repeat="genero in lstGeneros">
                                 {{ genero.genero }}
                              </option>
                           </select>
                        </div>
                     </td>
                     <td class="text-center">
                        <div ng-show="!editar && miembro.idParentesco==99">
                           {{ miembro.parentesco}}
                        </div>
                        <div ng-show="!editar && miembro.idParentesco!=99">
                           <select class="form-control" ng-model="miembro.idParentesco" ng-disabled="!editar">
                              <option value="{{parentesco.idParentesco}}" ng-repeat="parentesco in lstParentesco">
                                 {{ parentesco.parentesco }}
                              </option>
                           </select>
                        </div>
                        <div ng-show="editar">
                           <select class="form-control" ng-model="miembro.idParentesco">
                              <option value="{{parentesco.idParentesco}}" ng-repeat="parentesco in lstParentesco">
                                 {{ parentesco.parentesco }}
                              </option>
                           </select>
                           <div ng-show="miembro.idParentesco==99">
                              <input type="text" class="form-control" ng-model="miembro.parentesco">
                           </div>
                        </div>
                     </td>
                     <td class="text-center">
                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button class="btn btn-xs btn-opcion" ng-click="removeMiembro( ixMiembro )" ng-show="!editar">
                              <span class="glyphicon glyphicon-remove"></span>
                           </button>
                           <button class="btn btn-xs btn-opcion" ng-click="editar=!editar">
                              <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                           </button>
                           <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                              <span class="glyphicon glyphicon-plus"></span> Oficio
                           </button>
                        </div>
                     </td>
                  </tr>

                  <!-- AGREGAR MIEMBROS -->
                  <tr ng-show="agregarMiembros">
                     <td class="text-center">
                        <input type="text" class="form-control" id="miembroCui" maxlength="13" ng-model="miembro.cui">
                        456456
                     </td>
                     <td class="text-center">
                        <input type="text" name="" class="form-control" maxlength="45" ng-model="miembro.nombres">
                     </td>
                     <td class="text-center">
                        <input type="text" name="" class="form-control"  maxlength="45" ng-model="miembro.apellidos">
                     </td>
                     <td class="text-center">
                        <input type="text" class="form-control" ng-model="miembro.fechaNacimiento" data-date-format="dd/MM/yyyy" data-date-type="number"  data-max-date="today" data-autoclose="1" bs-datepicker>
                     </td>
                     <td class="text-center">
                        <select name="" class="form-control" ng-model="miembro.idGenero">
                           <option value="{{genero.idGenero}}" ng-repeat="genero in lstGeneros">
                              {{ genero.genero }}
                           </option>
                        </select>
                     </td>
                     <td class="text-center">
                        <select name="" class="form-control" ng-model="miembro.idParentesco">
                           <option value="{{parentesco.idParentesco}}" ng-repeat="parentesco in lstParentesco">
                              {{ parentesco.parentesco }}
                           </option>
                        </select>
                        <input type="text" ng-show="miembro.idParentesco==99" class="form-control" ng-model="miembro.parentesco">
                     </td>
                     <td class="text-center">
                        <button class="btn btn-success btn-xs noBorder" ng-click="addMiembro()">
                           <span class="glyphicon glyphicon-plus"></span>
                        </button>
                     </td>
                  </tr>
                  <!-- CANCELAR AGREGAR MIEMBRO -->
                  <tr ng-show="agregarMiembros">
                     <td>
                        <button type="button" class="btn btn-danger btn-sm noBorder" ng-click="agregarMiembros=!agregarMiembros">
                           CANCELAR
                        </button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="form-group" ng-show="!agregarMiembros">
            <button type="button" class="btn btn-info btn-sm noBorder" ng-click="agregarMiembros=!agregarMiembros">
               <span class="glyphicon glyphicon-plus-sign"></span> Agregar Miembro
            </button>
         </div>
      </form>
   </div>

   <!-- LISTAR FAMILIAS -->
   <div ng-show="tab==1" style="margin-top: 50px">
      <div class="col-sm-12">
         <b>AGRUPAR POR:</b>
         <div class="btn-group" role="group">
            <button type="button" class="btn btn-default" ng-click="filtro='departamento'">
               <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='departamento', 'glyphicon-unchecked': filtro!='departamento'}"></span> Departamentos
            </button>
            <button type="button" class="btn btn-default" ng-click="filtro='anio'">
               <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='anio', 'glyphicon-unchecked': filtro!='anio'}"></span> Año Ingreso
            </button>
            <button type="button" class="btn btn-default" ng-click="filtro='area'">
               <span class="glyphicon" ng-class="{'glyphicon-check': filtro=='area', 'glyphicon-unchecked': filtro!='area'}"></span> Área
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
                  <input type="text" class="form-control" ng-model="searchFamilia"  placeholder="Buscar familia">
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-12">
         <div class="panel panel-primary" ng-repeat="(ixFamilias, familiaB) in lstFamiliasB ">
            <div class="panel-heading">
               <a ng-click="familiaB.mostrar=!familiaB.mostrar">
                  <span class="glyphicon" ng-class="{'glyphicon-chevron-right': familiaB.mostrar, 'glyphicon-chevron-down': !familiaB.mostrar}"></span>
                  <strong ng-show="filtro=='departamento'">
                     {{ familiaB.departamento }}
                  </strong>
                  <strong ng-show="filtro=='estado'">
                     {{ familiaB.estadoDonador }}
                  </strong>
               </a>
               <div class="pull-right">
                  <label class="label label-success">
                     <strong>TOTAL: <span class="badge">{{familiaB.totalFamiliasDepto}}</span></strong>
                  </label>
               </div>
            </div>
            <div class="panel-body" ng-hide="familiaB.mostrar">
               <div class="panel panel-default" ng-repeat="(ixMunicipio, municipio) in familiaB.lstMunicipios | filter: searchFamilia">
                  <div class="panel-heading">
                     <a ng-click="familiaMuni.mostrar=!familiaMuni.mostrar">
                        <span class="glyphicon" ng-class="{'glyphicon-chevron-right': familiaMuni.mostrar, 'glyphicon-chevron-down': !familiaMuni.mostrar}"></span>
                        <strong ng-show="filtro=='departamento'">
                           {{ municipio.municipio }}
                        </strong>
                        <strong ng-show="filtro=='estado'">
                           {{ familiaB.estadoDonador }}
                        </strong>
                     </a>
                     <div class="pull-right">
                        <label class="label label-warning">
                           <strong>SUBTOTAL: <span class="badge">{{municipio.subTotal}}</span></strong>
                        </label>
                     </div>
                  </div>
                  <div class="panel-body" ng-show="!familiaMuni.mostrar">
                     <table class="table table-striped table-hover">
                        <thead>
                           <tr>
                              <th class="text-center">No.</th>
                              <th class="text-center">Familia</th>
                              <th class="text-center">Dirección</th>
                              <th class="text-center">Estado</th>
                              <th class="text-center">Fecha Ingreso</th>
                              <th class="text-center">Área</th>
                              <th class="text-center">Opciones</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr ng-repeat="(ixFamilia, familia) in municipio.lstFamilias | filter:searchfamilia || searchDonante" ng-init="$idIndex = $index">
                              <td class="text-center">
                               {{ $idIndex + 1 }} </td>
                              <td> {{ familia.nombreFamilia }} </td>
                              <td class="text-center"> {{ familia.direccion }} </td>
                              <td class="text-center"> {{ familia.estado }}  </td>
                              <td class="text-center"> {{ familia.fechaIngreso }} </td>
                              <td class="text-center"> {{ familia.area }} </td>
                              <td>
                                 <!-- OPCIONES -->
                                 <div class="menu-opciones">
                                    <button class="btn btn-xs btn-opcion" data-toggle="modal" data-target="#modalReporte"  ng-click="verDonacionesFamilia( familia.idFamilia )" >
                                       <span class="glyphicon glyphicon-folder-open"></span>
                                    </button>
                                    <button class="btn btn-xs btn-opcion" ng-click="removeMiembro( ixMiembro )" >
                                       <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                    <button class="btn btn-xs btn-opcion" ng-click="editarfamilia( donador )">
                                       <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                                    </button>
                                    
                                    <!--
                                    <button type="button" class="btn btn-sm btn-opcion" ng-click="openModalOficios( ixMiembro )">
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
            
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="reset()"><i class="glyphicon glyphicon-log-out"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" ng-click="guardarDonador()"><i class="glyphicon glyphicon-saved"></i> Guardar Donador</button>
         </div>
      </div>
   </div>
</div>