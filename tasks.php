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
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css"/>
<script src="js/task.js"></script>	
<script src="js/general.js"></script>
<div class="container">  
<nav class="navbar navbar-dark bg-dark">
  		<div class="container-fluid">
    		<span class="navbar-brand mb-0 h1">CRM Proyectos</span>
  		</div>
</nav>		
	<?php include('top_menus.php'); ?>	
	<br>
	<h3>Lista de Tareas</h3>		
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addTasks" class="btn btn-info" title="Crear Tarea"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="tasksListing" class="table table-light table-bordered table-striped">
			<thead>
				<tr>						
					<th>ID</th>					
					<th>Descripción</th>					
					<th>Fecha de Entrega</th>
					<th>Proyecto</th>
					<th>Vendedor Asignado</th>
					<th>Estatus</th>					
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	
	<div id="taskModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="taskForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Editar Tarea</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="project" class="control-label">Descripción</label>
							<input type="text" class="form-control" id="description" name="description" placeholder="Description name" required>			
						</div>

						<div class="form-group"
							<label for="project" class="control-label">Fecha de Entrega</label>
							<input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due date" >			
						</div>	

						<div class="form-group">
							<label for="country" class="control-label">Proyecto</label>							
							<select class="form-control" id="project" name="project"/>
							<?php 
							$projectResult = $user->projectList();
							while ($conatct = $projectResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $conatct['id']; ?>"><?php echo $conatct['name']; ?></option>							
							<?php } ?>
							</select>							
						</div>

						<div class="form-group">
							<label for="country" class="control-label">Vendedor Asignado</label>							
							<select class="form-control" id="sales_rep" name="sales_rep"/>
							<?php 
							$salesRepResult = $user->salesRepList();
							while ($salesRep = $salesRepResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $salesRep['id']; ?>"><?php echo $salesRep['name']; ?></option>							
							<?php } ?>
							</select>							
						</div>

						<div class="form-group">
							<label for="country" class="control-label">Estatus</label>							
							<select class="form-control" id="status" name="status"/>							
								<option value="Pendiente">Pendiente</option>
								<option value="Completado">Completado</option>		
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
