<nav class="navbar navbar-default">
   <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="#">Bienvenido</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <li ng-class="{'active':menu=='inicio'}"><a href="#">Inicio <span class="sr-only">(current)</span></a></li>

            

            <li class="dropdown"  >
               <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Donación <span class="caret"></span></a>
               <ul class="dropdown-menu">
                  <li><a href="#/donaciones/fondoComun">Fondo Común</a></li>
                  
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Desastres</a></li>
               </ul>
            </li>

            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compras <span class="caret"></span></a>
               <ul class="dropdown-menu">
                  <li><a href="#">Suministros</a></li>
                  <li><a href="#">Reportes</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">One more separated link</a></li>
               </ul>
            </li>
         </ul>

         <ul class="nav navbar-nav navbar-right">
            <li ng-class="{'active':menu=='comprarProducto'}"><a href="#/compras">Comprar</a></li>
            <li ng-class="{'active':menu=='reporte'}"><a href="#">Reportes</a></li>
            <li class="dropdown">
               <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
               <ul class="dropdown-menu">
                  <li ng-class="{'active':menu=='donaciones'}"><a href="#/donaciones">Donaciones</a></li>
                  <li ng-class="{'active':menu=='productos'}"><a href="#/productos">Productos</a></li>
                  <li ng-class="{'active':menu=='donantes'}"><a href="#/donantes">Donantes</a></li>
                  <li ng-class="{'active':menu=='familias'}"><a href="#/familias">Familias</a></li>
                  <li><a href="#">Beneficiarios</a></li>
                  <li><a href="#">Suministros</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Desastres</a></li>
               </ul>
            </li>
            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
         </ul>
      </div>
   </div>
</nav>