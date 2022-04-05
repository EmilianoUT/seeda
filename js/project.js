$(document).ready(function(){	

	var projectRecords = $('#projectListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"project_action.php",
			type:"POST",
			data:{action:'listProject'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7, 8],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addProject').click(function(){
		$('#projectModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#projectForm')[0].reset();
		$("#projectModal").on("shown.bs.modal", function () { 
			$('.modal-title').html("<i class='fa fa-plus'></i> Crear Proyecto");			
			$('#action').val('addProject');
			$('#save').val('Guardar');
		});
	});		
	
	$("#projectListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getProject';
		$.ajax({
			url:'project_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#projectModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#project_name').val(data.project_name);
					$('#project_company').val(data.company);	
					$('#project_industry').val(data.industry);	
					$('#project_budget').val(data.budget);	
					$('#project_sales_rep').val(data.sale_rep_id);						
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Proyecto");
					$('#action').val('updateProject');
					$('#save').val('Guardar');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#projectModal").on('submit','#projectForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"project_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#projectForm')[0].reset();
				$('#projectModal').modal('hide');				
				$('#save').attr('disabled', false);
				projectRecords.ajax.reload();
			}
		})
	});		

	$("#projectListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteProject";
		if(confirm("¿Estás seguro de que quieres eliminar este registro?")) {
			$.ajax({
				url:"project_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					projectRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	

	$(document).on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getTasks';
		$.ajax({
			url:'project_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#tasksDetails").on("shown.bs.modal", function () {
					var resultHTML = '';
					respData.data.forEach(function(item){						
						resultHTML +="<tr>";
						for (var i = 0; i < item.length; i++) {							 
							 resultHTML +="<td>"+item[i]+"</td>";
						}
						resultHTML +="</tr>";
					});					
					$('#tasksList').html(resultHTML);											
				}).modal();			
			}
		});
	});
	
});