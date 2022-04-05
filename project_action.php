<?php
include_once 'config/Database.php';
include_once 'class/Project.php';

$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listProject') {
	$project->listProject();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addProject') {	
	$project->project_name = $_POST["project_name"];
	$project->project_company = $_POST["project_company"];
	$project->project_industry = $_POST["project_industry"];
	$project->project_budget = $_POST["project_budget"];
	$project->project_sales_rep = $_POST["project_sales_rep"];
	$project->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getProject') {
	$project->project_id = $_POST["id"];
	$project->getProject();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateProject') {
	$project->project_id = $_POST["id"];
	$project->project_name = $_POST["project_name"];
	$project->project_company = $_POST["project_company"];
	$project->project_industry = $_POST["project_industry"];
	$project->project_budget = $_POST["project_budget"];
	$project->project_sales_rep = $_POST["project_sales_rep"];	
	$project->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteProject') {
	$project->project_id = $_POST["id"];
	$project->delete();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getTasks') {
	$project->project_id = $_POST["id"];
	$project->getTasks();
}
?>