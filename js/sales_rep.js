$(document).ready(function(){	

	var projectRecords = $('#salesRepListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"manager_action.php",
			type:"POST",
			data:{action:'listSalesRep'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 4, 5, 6],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addSalesRep').click(function(){
		$('#salesRepModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#salesForm')[0].reset();
		$("#salesRepModal").on("shown.bs.modal", function () { 
			$('.modal-title').html("<i class='fa fa-plus'></i> Crear Vendedor");
			$('#newPassword').text('Password');
			$('#action').val('addSalesRep');
			$('#save').val('Guardar');
		});
	});		
	
	$("#salesRepListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getSalesRep';
		$.ajax({
			url:'manager_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#salesRepModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#sales_name').val(data.name);
					$('#sales_email').val(data.email);	
					$('#sales_salary').val(data.salary);	
					$('#newPassword').text('New Password');
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Vendedor");
					$('#action').val('updateSalesRep');
					$('#save').val('Guardar');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#salesRepModal").on('submit','#salesForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"manager_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#salesForm')[0].reset();
				$('#salesRepModal').modal('hide');				
				$('#save').attr('disabled', false);
				projectRecords.ajax.reload();
			}
		})
	});		
	
	$(document).on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getProjects';
		$.ajax({
			url:'manager_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#salesRepDetails").on("shown.bs.modal", function () {
					var resultHTML = '';
					respData.data.forEach(function(item){						
						resultHTML +="<tr>";
						for (var i = 0; i < item.length; i++) {							 
							 resultHTML +="<td>"+item[i]+"</td>";
						}
						resultHTML +="</tr>";
					});					
					$('#salesRepRow').html(resultHTML);												
				}).modal();			
			}
		});
	});

	$("#salesRepListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteSalesRep";
		if(confirm("¿Estás seguro de que quieres eliminar este registro?")) {
			$.ajax({
				url:"manager_action.php",
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
	
});