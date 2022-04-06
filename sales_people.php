<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	
</body>
</html>


<?php
include_once 'config/Database.php';
include_once 'class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header.php');
?>
<title>CRM Proyectos</title>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/sales_rep.js"></script>	
<script src="js/general.js"></script>
<div class="container">  
<nav class="navbar navbar-dark bg-dark">
  		<div class="container-fluid">
    		<span class="navbar-brand mb-0 h1">CRM Proyectos</span>
  		</div>
</nav>				
	<?php include('top_menus.php'); ?>	
	<br>
	<h3>Lista de vendedores</h3>	
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addSalesRep" class="btn btn-info" title="Add Sales Rep"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="salesRepListing" class="table table-light table-bordered table-striped">
			<thead>
				<tr>						
					<th>Id</th>					
					<th>Nombre</th>					
					<th>Email</th>
					<th>Sueldo</th>
					<th>Estatus</th>	
					<th></th>	
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="salesRepDetails" class="modal fade">
		<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i>Proyecto</h4>
				</div>
				<div class="modal-body">
					<table id="" class="table table-bordered table-striped">
						<thead>
							<tr>						
								<th>Id</th>					
								<th>Nombre</th>					
								<th>Compañia</th>
								<th>Industria</th>
								<th>Presupuesto ($)</th>														
							</tr>
						</thead>
						<tbody id="salesRepRow">							
						</tbody>
					</table>								
				</div>    				
			</div>    		
		</div>
	</div>	
	<div id="salesRepModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="salesForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Editar Vendedor</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="project" class="control-label">Nombre del Vendedor</label>
							<input type="text" class="form-control" id="sales_name" name="sales_name" placeholder="Nombre" required>			
						</div>					
						
						<div class="form-group">
							<label for="email" class="control-label">Correo</label>							
							<input pattern="[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+" type="email" class="form-control" id="sales_email" name="sales_email" placeholder="Correo" required>									
						</div>
						<div class="form-group"
							<label for="project" class="control-label">Sueldo</label>
							<input type="number" class="form-control" id="sales_salary" name="sales_salary" placeholder="Salario" required>			
						</div>
						<div class="form-group">
							<label for="address" class="control-label" id="newPassword">Contraseña</label>							
							<input regex="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$" type="password" class="form-control" id="sales_password" name="sales_password" placeholder=" 8 caracteres minimo, una letra mayusculas una minuscula, un numero y un caracter especial." required>									
						</div>
						
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id" id="id" />
						<input type="hidden" name="action" id="action" value="" />
						<input type="submit" name="save" id="save" class="btn btn-info" value="Guardar" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
			
</div>
 <?php include('inc/footer.php');?>
