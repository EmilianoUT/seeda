<?php
class Project {	
   
	private $userTable = 'crm_users';
	private $projectTable = 'crm_project';	
	private $tasksTable = 'crm_tasks';			
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listProject(){
		
		$sqlWhere = '';
		if($_SESSION["role"] == 'sales') { 
			$sqlWhere = " WHERE p.sales_rep = '".$_SESSION["userid"]."'";
		}	
		
		$sqlQuery = "SELECT p.id, p.project_name, p.company, p.industry, p.budget, u.name 
		FROM ".$this->projectTable." p
		LEFT JOIN ".$this->userTable." u ON p.sales_rep = u.id $sqlWhere";
		
		if(!empty($_POST["order"])){
			$sqlQuery .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= ' ORDER BY id ASC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->projectTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($project = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $project['id'];
			$rows[] = ucfirst($project['project_name']);			
			$rows[] = $project['company'];
			$rows[] = $project['industry'];	
			$rows[] = $project['budget'];		
			$rows[] = $project['name'];				
			$rows[] = '<button  type="button" name="view" id="'.$project["id"].'" class="btn btn-info btn-xs view"><span title="Ver Tareas">Ver tareas</span></button>';			
			$rows[] = '<button type="button" name="update" id="'.$project["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';			
			$rows[] = '<button type="button" name="delete" id="'.$project["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';			
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}

	public function insert(){
		
		if($this->project_name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->projectTable."(`project_name`, `company`, `industry`, `budget`, `sales_rep`)
			VALUES(?,?,?,?,?)");
		
			$this->project_name = htmlspecialchars(strip_tags($this->project_name));			
			$this->project_company = htmlspecialchars(strip_tags($this->project_company));
			$this->project_industry = htmlspecialchars(strip_tags($this->project_industry));
			$this->project_budget = htmlspecialchars(strip_tags($this->project_budget));
			$this->project_sales_rep = htmlspecialchars(strip_tags($this->project_sales_rep));			
			
			$stmt->bind_param("ssssi", $this->project_name, $this->project_company, $this->project_industry, $this->project_budget, $this->project_sales_rep);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function getProject(){
		if($this->project_id) {
			$sqlQuery = "
			SELECT p.id, p.project_name, p.company, p.industry, p.budget, u.id as sale_rep_id, u.name 
			FROM ".$this->projectTable." p
			LEFT JOIN ".$this->userTable." u ON p.sales_rep = u.id 
			WHERE p.id = ?";		
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->project_id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}


	public function update(){		
		if($this->project_id) {				
			$stmt = $this->conn->prepare("
			UPDATE ".$this->projectTable." 
			SET project_name = ?, company = ?, industry = ?, budget = ?, sales_rep = ?
			WHERE id = ?"); 			
			$this->project_name = htmlspecialchars(strip_tags($this->project_name));			
			$this->project_company = htmlspecialchars(strip_tags($this->project_company));
			$this->project_industry = htmlspecialchars(strip_tags($this->project_industry));
			$this->project_budget = htmlspecialchars(strip_tags($this->project_budget));
			$this->project_sales_rep = htmlspecialchars(strip_tags($this->project_sales_rep));				
			$stmt->bind_param("ssssii", $this->project_name, $this->project_company, $this->project_industry, $this->project_budget, $this->project_sales_rep, $this->project_id);			
			if($stmt->execute()){
				return true;
			}			
		}	
	}

	public function delete(){
		if($this->project_id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->projectTable." 
				WHERE id = ?");

			$this->project_id = htmlspecialchars(strip_tags($this->project_id));

			$stmt->bind_param("i", $this->project_id);

			if($stmt->execute()){
				return true;
			}
		}
	} 

	
	public function getTasks(){
		if($this->project_id) {
			$sqlQuery = "SELECT t.id, t.created,  t.task_description, t.task_due_date, t.task_status, p.project_name, u.name
			FROM ".$this->tasksTable." t 
			LEFT JOIN ".$this->projectTable." p ON t.project = p.id
			LEFT JOIN ".$this->userTable." u ON t.sales_rep = u.id
			WHERE t.project = ?";	
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->project_id);	
			$stmt->execute();
			$result = $stmt->get_result();			
			$records = array();		
			while ($tasks = $result->fetch_assoc()) { 				
				$rows = array();			
				$rows[] = $tasks['id'];
				$rows[] = $tasks['created'];			
				$rows[] = $tasks['task_description'];
				$rows[] = $tasks['task_due_date'];	
				$rows[] = $tasks['task_status'];
				$rows[] = $tasks['project_name'];
				$rows[] = $tasks['name'];
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}	

	

}
?>