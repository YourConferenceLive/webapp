<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Evaluation</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Evaluations</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">All evaluations</h3>

						</div>
						<div class="card-body">
							<table class="table table-striped table-bordered" id="evaluation_table">
								<thead>
									<tr>
										<th>#</th>
										<th>
											Evaluation Name
										</th>
										<th>
											Evaluation Header
										</th>
										<th>
											Export
										</th>
									</tr>
								</thead>
								<tbody class="evaluation-table-body">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
	$(function()
	{
		evaluation_list();

		$('.evaluation-table-body').on('click', '#btn-view', function(){
			toastr['warning']('Under Development');
		});
	});

	function evaluation_list()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Loading users data...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		$.post("<?=$this->project_url?>/admin/evaluation/get_evaluation_data",
					function(response) {
						response = JSON.parse(response);
						$('.evaluation-table-body').html('');
						if ($.fn.DataTable.isDataTable('#evaluation_table')) {
							$('#evaluation_table').dataTable().fnClearTable();
							$('#evaluation_table').dataTable().fnDestroy();
						}
						$.each(response, function (index, data) {
	
							let export_btn = '<a href="'+project_url+'/admin/evaluation/evaluationToCSV/'+data.id+'" class="btn btn-success float-right" id="export-csv"><i class="fas fa-file-csv"></i> Export CSV</a>';
	
							$('.evaluation-table-body').append(
									'<tr>' +
									'	<td>' + (index + 1) + '</td>' +
									'	<td>' + data.name + '</td>' +
									'	<td>' + data.title + '</td>' +
									'	<td>' + export_btn + '</td>' +
									'</tr>'
							)
						});
	
						$('#evaluation_table').DataTable({
							"paging": true,
							"lengthChange": true,
							"searching": true,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"order": [[0, "desc"]],
							"destroy": true
						});
	
						Swal.close();
					});
	}
</script>
