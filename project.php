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
<script src="js/project.js"></script>	
<script src="js/general.js"></script>
<div class="container">  
	<nav class="navbar navbar-dark bg-dark">
  		<div class="container-fluid">
    		<span class="navbar-brand mb-0 h1">CRM Proyectos</span>
  		</div>
	</nav>	
	<?php include('top_menus.php'); ?>	
	<br>
	<h3>Lista de Proyectos</h3>	
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addProject" class="btn btn-info" title="Crear Proyecto"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="projectListing" class="table table-light table-bordered table-striped">
			<thead>
				<tr>						
					<th>ID</th>					
					<th>Nombre del Proyecto</th>					
					<th>Compañia</th>
					<th>Industria</th>
					<th>Presupuesto</th>
					<th>Vendedor Asignado</th>
					<th></th>	
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tasksDetails" class="modal fade">
		<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Detalles de Tarea</h4>
				</div>
				<div class="modal-body">
					<table id="" class="table table-light table-bordered table-striped">
						<thead>
							<tr>						
								<th>Id</th>					
								<th>Creado</th>					
								<th>Descripcion</th>	
								<th>Fecha de entrega</th>
								<th>Estatus</th>	
								<th>Proyecto</th>
								<th>Vendedor Asignado</th>														
							</tr>
						</thead>
						<tbody id="tasksList">							
						</tbody>
					</table>								
				</div>    				
			</div>    		
		</div>
	</div>	
	<div id="projectModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="projectForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Editar Proyecto</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="project" class="control-label">Nombre del Proyecto</label>
							<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Nombre" required>			
						</div>
	
						
						<div class="form-group">
							<label for="address" class="control-label">Compañia</label>							
							<input type="text" class="form-control" id="project_company" name="project_company" placeholder="Compañia" required>									
						</div>

						<div class="form-group">
							<label for="address" class="control-label">Industria</label>							
							<input type="text" class="form-control" id="project_industry" name="project_industry" placeholder="Industria" required>									
						</div>
						
						<div class="form-group">
							<label for="address" class="control-label">Presupuesto</label>							
							<input type="text" class="form-control" id="project_budget" name="project_budget" placeholder="Presupuesto" required>									
						</div>

						<div class="form-group">
							<label for="country" class="control-label">Vendedor</label>							
							<select class="form-control" id="project_sales_rep" name="project_sales_rep"/>
							<?php 
							$salesRepResult = $user->salesRepList();
							while ($salesRep = $salesRepResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $salesRep['id']; ?>"><?php echo $salesRep['name']; ?></option>							
							<?php } ?>
							</select>							
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
