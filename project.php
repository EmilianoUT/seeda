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
<div class="container" style="background-color:#f4f3ef;">  
	<h2>CRM Proyectos</h2>	
	<?php include('top_menus.php'); ?>	
	<br>
	<h4>Proyectos</h4>	
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
		<table id="projectListing" class="table table-bordered table-striped">
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
					<table id="" class="table table-bordered table-striped">
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
