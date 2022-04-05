$(document).ready(function(){	

	var taskRecords = $('#tasksListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"task_action.php",
			type:"POST",
			data:{action:'listTasks'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addTasks').click(function(){
		$('#taskModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#taskForm')[0].reset();
		$("#taskModal").on("shown.bs.modal", function () { 
			$('.modal-title').html("<i class='fa fa-plus'></i> Crear Tarea");			
			$('#action').val('addTask');
			$('#save').val('Guardar');
		});
	});		
	
	$("#tasksListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getTask';
		$.ajax({
			url:'task_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#taskModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#description').val(data.task_description);
					$('#due_date').val(data.task_due_date);
					$('#project').val(data.project_name);	
					$('#sales_rep').val(data.sales_rep);	
					$('#status').val(data.task_status);										
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Tarea");
					$('#action').val('updateTask');
					$('#save').val('Guardar');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#taskModal").on('submit','#taskForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"task_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#taskForm')[0].reset();
				$('#taskModal').modal('hide');				
				$('#save').attr('disabled', false);
				taskRecords.ajax.reload();
			}
		})
	});		

	$("#tasksListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteTasks";
		if(confirm("¿Estás seguro de que quieres eliminar este registro?")) {
			$.ajax({
				url:"task_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					taskRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
});