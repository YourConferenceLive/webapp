<?php
//echo"<pre>";
//print_r($logs);
//exit("</pre>");
?>

<style>
	body{
		background: #e8e8e8;
	}
</style>

<div class="clearfix" style="margin-top: 75px"></div>
<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><i class="far fa-chart-bar"></i> Analytics</h4>
				</div>
				<div class="card-body">
					<table id="analyticsTable" class="table table-bordered">
						<thead>
						<tr>
							<th>User ID</th>
							<th>First Name</th>
							<th>Second Name</th>
							<th>Email</th>
							<th>Action</th>
							<th>Action Time</th>
							<th>IP</th>
						</tr>
						</thead>
						<tbody id="sessionsTableBody">
							<?php foreach ($logs as $log): ?>
								<tr>
									<td><?=$log->user_id?></td>
									<td><?=$log->user_fname?></td>
									<td><?=$log->user_surname?></td>
									<td><?=$log->email?></td>
									<td><?=$log->name?></td>
									<td><?=$log->date_time?></td>
									<td><?=$log->ip?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- DataTables  & Plugins -->
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
	$('#analyticsTable').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
	});
</script>
