<?php
include_once 'config/Database.php';
include_once 'class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listSalesRep') {
	$user->listSalesRep();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getProjects') {
	$user->id = $_POST["id"];
	$user->getProjects();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addSalesRep') {	
	$user->sales_name = $_POST["sales_name"];
    $user->sales_email = $_POST["sales_email"];
	$user->sales_salary = $_POST["sales_salary"];
	$user->sales_password = $_POST["sales_password"];	
	$user->insertSalesRep();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getSalesRep') {
	$user->sales_rep_id = $_POST["id"];
	$user->getSalesRep();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateSalesRep') {
	$user->sales_rep_id = $_POST["id"];
	$user->sales_name = $_POST["sales_name"];
    $user->sales_email = $_POST["sales_email"];
	$user->sales_salary = $_POST["sales_salary"];
	$user->sales_password = $_POST["sales_password"];	
	$user->updateSalesRep();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteSalesRep') {
	$user->sales_rep_id = $_POST["id"];
	$user->deleteSalesRep();
}



?>