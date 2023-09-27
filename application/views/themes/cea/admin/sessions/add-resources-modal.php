<div class="modal fade" id="addResourceModal" tabindex="-1" role="dialog" aria-labelledby="addSessionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addSessionModalLabel"><i class="fas fa-calendar-plus"></i> Resources </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form>
				<div class="card">
					<div class="card-header">
						Add Session Resources
					</div>
					<div class="card-body">
						<label> Note : URL must start with http:// or https:// for example https://google.com </label><br>
						<label class="ml-5"> Please leave the url empty when uploading a file</label>
						<div class="row">
							<div class="col-md-4" >
								<label for="">Link published name:</label><br>
								<input class="form-control" type="text" name="" id="resource_name" value="" placeholder="Google">
							</div>
							<div class="col-md-4">
								<label for="">Link URL:</label><br>
								<input class="form-control" type="text" name="" id="resource_url" value="" placeholder="example https://google.com">
							</div>
							<div class="col-md-4">
								<label for="">File</label><br>
								<input class="form-control" type="file" name="" id="resource_file" value="" >
							</div>

						</div>
							<hr class="mt-3"/>

						<button id="save-resource" type="button" class="btn btn-success mt-5 float-right"><i class="fas fa-plus"></i> Add</button>
						<input type="reset" id="clear-resource" class="btn btn-warning mt-5 mr-5 float-right" value="Clear">
					</div>

				</div>
				</form>
				<div class="card-footer">
					<label>Resource Table</label>
					<table class="table table-striped" id="resourceTable">
						<thead>
							<th>Resource Name</th>
							<th>Resource Data</th>
							<th>Action</th>
						</thead>
						<tbody id="resourceTableBody">

						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script>
	$(function(){

		$('#save-resource').on('click', function(){

			let fd = new FormData();
			let session_id = $(this).attr('session-id');
			fd.append('resource_name', $('#resource_name').val());
			fd.append('resource_url',  $('#resource_url').val());
			fd.append('session-id',  $(this).attr('session-id'));
			fd.append('resource_file', $('#resource_file')[0].files[0]);

			$.ajax({
				url: project_admin_url+'/sessions/addSessionResources/',
				data: fd,
				type: 'POST',
				contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
				processData: false, // NEEDED, DON'T OMIT THIS
				success: function (response) {
					response = JSON.parse(response);
					if(response.status === 'success'){
						toastr.success(response.msg);
					}else{
						toastr.error(response.msg);
					}

					$('#resource_name').val('');
					$('#resource_url').val('');
					$('#resource_file').val('');
					getSessionResources(session_id);
				}
			});
			return false;
		})

		$('#resourceTableBody').on('click', '.removeResource', function(e){
			e.preventDefault();
			let resource_id = $(this).attr('resource-id');
			let session_id = $(this).attr('session-id');

			Swal.fire({
				title: "Are you sure?",
				text: "",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: "Yes, remove it!",
				cancelButtonText: "Cancel"
			}).then((result) => {
				if (result.isConfirmed) {
					if(resource_id !== ''){
						$.post(project_admin_url+'/sessions/updateSessionResource/',
							{
								'resource_id':resource_id,
								'is_active':0
							}, function(response){
								getSessionResources(session_id);
							})
					}
				}
			});

		})
	})

	function getSessionResources(session_id){
		if ($.fn.DataTable.isDataTable('#resourceTable')) {
			$('#resourceTable').DataTable().destroy();
		}

		$.post(project_admin_url+'/sessions/getSessionResources/'+session_id, function(response){
			response = JSON.parse(response);
			$('#resourceTableBody').html('');
			if(response.status === 'success'){
				let resource_data;
				$.each(response.data, function(i, data){
					console.log(data);
					if(data.resource_type === 'url'){
						resource_data = "<a href='"+data.resource_path+"' target='_blank'>"+data.resource_path+"</a>";
					}else{
						resource_data = "<a href='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/resources/"+data.resource_path+"' target='_blank'> "+data.resource_path+"</a>"
					}
					$('#resourceTableBody').append('<tr>' +
						'<td>'+data.resource_name+'</td>' +
						'<td>'+resource_data+'</td>' +
						'<td><a class="btn btn-danger btn-sm removeResource" resource-id ="'+data.id+'" session-id ="'+data.session_id+'"><i class="fas fa-trash-alt"></i> Remove</td>' +
						'</tr>')
				})
				$('#resourceTable').dataTable();
			}
		})
	}


</script>
