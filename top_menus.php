<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<div class="card">
  <div class="card-body">
		<h3><?php if($_SESSION["userid"]) { echo "Usuario : ".ucfirst($_SESSION["name"]); } ?> | <a href="logout.php">Salir</a> </h3>
		<p><strong>Bienvenido <?php echo ucfirst($_SESSION["role"]); ?></strong></p>
	</div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
	  <?php if($_SESSION["role"] == 'manager') { ?>
        <li class="nav-item">
          <a class="nav-link" id="project" aria-current="page" href="project.php">Proyectos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tasks" href="tasks.php">Tareas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="sales_people" href="sales_people.php">Vendedores</a>
        </li>
        </li>
		<?php } ?>
		<?php if($_SESSION["role"] == 'sales') { ?>

			<li class="nav-item"> 
        <a class="nav-link" id="tasks" href="tasks.php">Tareas</a>
      </li> 
		
		<?php } ?>
      </ul>
    </div>
  </div>
</nav>
