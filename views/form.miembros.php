<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>
			<h2><span class="glyphicon glyphicon-user"></span> {{lstMiembrosFamilia[0].nombreFamilia | uppercase }}</h2>
  				<strong>Dirección: </strong> {{lstMiembrosFamilia[0].direccion}} <br>
  				<strong>Fecha de Ingreso: </strong> {{lstMiembrosFamilia[0].fechaIngreso | date:'dd/MM/yyyy' }} <br />
			</ul>
		</blockquote>
		<div class="text-right">
			<button type="" class="btn btn-success noBorder">
				<span class="glyphicon glyphicon-plus"></span>
				Agregar Miembros
			</button>
		</div>
		<legend class="text-center">
			<strong>Miembros de la Familia</strong>
		</legend>
		<div class="text-right">
			<div class="btn-group" role="group">
			  	<button type="button" class="btn btn-default">
			  		Hombres <span class="badge">{{ lstMiembrosFamilia[0].totalHombres }}</span>
			  	</button>
			  	<button type="button" class="btn btn-default">
			  		Mujeres <span class="badge"> {{ lstMiembrosFamilia[0].totalMujeres }}</span>
			  	</button>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr id="tb-familiares">
					<th class="text-center">CUI</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Genero</th>
					<th class="text-center">Fecha de Nacimiento</th>
					<th class="text-center">Edad</th>
					<th class="text-center">Parentesco</th>
					<th class="text-center">Menú</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="miembro in lstMiembrosFamilia[0].lstMiembros">
					<td class="text-center">{{miembro.cui }}</td>
					<td>{{miembro.nombres + ' ' + miembro.apellidos }}</td>
					<td class="text-center">{{miembro.genero }}</td>
					<td class="text-center">{{miembro.fechaNacimiento | date:'dd/MM/yyyy' }}</td>
					<td class="text-center">{{miembro.edad }}</td>
					<td class="text-center">{{miembro.parentesco }}</td>
					<td class="text-center">
						                        <!-- OPCIONES -->
                        <div class="menu-opciones">
                           <button class="btn btn-xs btn-opcion" ng-click="editarDonador( donador )">
                              <span class="glyphicon" ng-class="{'glyphicon-pencil': !editar, 'glyphicon-ok': editar}"></span>
                           </button>
                           <button type="button" class="btn btn-sm btn-opcion" data-toggle="modal" data-target="#myModal" ng-click="openModalOficios( ixMiembro )">
                              <span class="glyphicon glyphicon-briefcase"></span> Oficios
                           </button>
                           <button class="btn btn-xs btn-opcion" ng-click="removeMiembro( ixMiembro )" >
                              <span class="glyphicon glyphicon-trash"></span>
                           </button>
                        </div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>