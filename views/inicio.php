<h1>BIENVENIDO</h1>


<table>
	<caption>table title and/or explanatory text</caption>
	<thead>
		<tr>
			<th>header</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="(ixDato, dato) in lstDatos">
			<td>{{ dato.idArea}}</td>
			<td>{{ dato.area }}</td>
		</tr>
	</tbody>
</table>