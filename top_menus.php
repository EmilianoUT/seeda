<h3><?php if($_SESSION["userid"]) { echo "Usuario : ".ucfirst($_SESSION["name"]); } ?> | <a href="logout.php">Salir</a> </h3><br>
<p><strong>Bienvenido <?php echo ucfirst($_SESSION["role"]); ?></strong></p>	
<ul class="nav nav-tabs">	
	<?php if($_SESSION["role"] == 'manager') { ?>
		<li id="project"><a href="project.php">Proyectos</a></li> 				
		<li id="tasks"><a href="tasks.php">Tareas</a></li> 
		<li id="sales_people"><a href="sales_people.php">Vendedores</a></li>
	<?php } ?>
	
	<?php if($_SESSION["role"] == 'sales') { ?>
		<li id="tasks"><a href="tasks.php">Tareas</a></li> 
		
	<?php } ?>
</ul>