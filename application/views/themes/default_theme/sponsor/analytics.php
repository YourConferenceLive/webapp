<?php
//echo"<pre>";
//print_r($booth);
//exit("</pre>");
?>

<style>
	body{
		background: #e8e8e8;
	}

	.info-box {
		box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
		border-radius: 0.25rem;
		background-color: #fff;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		margin-bottom: 1rem;
		min-height: 80px;
		padding: .5rem;
		position: relative;
		width: 100%;
	}

	.info-box .info-box-icon {
		border-radius: 0.25rem;
		-webkit-align-items: center;
		-ms-flex-align: center;
		align-items: center;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		font-size: 1.875rem;
		-webkit-justify-content: center;
		-ms-flex-pack: center;
		justify-content: center;
		text-align: center;
		width: 70px;
	}

	.info-box .info-box-content {
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		-webkit-flex-direction: column;
		-ms-flex-direction: column;
		flex-direction: column;
		-webkit-justify-content: center;
		-ms-flex-pack: center;
		justify-content: center;
		line-height: 1.8;
		-webkit-flex: 1;
		-ms-flex: 1;
		flex: 1;
		padding: 0 10px;
	}

	.info-box .progress-description, .info-box .info-box-text {
		display: block;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.info-box .info-box-number {
		display: block;
		margin-top: .25rem;
		font-weight: 700;
	}

	div.dt-buttons {
		float: right;
		margin-left: 10px;
	}


</style>

<div class="clearfix" style="margin-top: 75px"></div>
<div class="container-fluid mt-5">

	<div class="row mb-2">
		<div class="col-12">
			<nav class="navbar navbar-light bg-light">
				<span class="navbar-brand mb-0 h1" style="color: #487391;"><h4><i class="fas fa-chart-pie"></i> Analytics</h4></span>
			</nav>
		</div>
	</div>

	<div class="row mb-2">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<div class="row">

						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon bg-info elevation-1" style="background-color: #bf9737 !important;"><i class="fas fa-users text-white"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">Number of total visits</span>
									<span class="info-box-number">
										<?=$total_visits?>
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						</div>

						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon bg-info elevation-1"><i class="fas fa-id-card-alt text-white"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">Number of unique visitors</span>
									<span class="info-box-number">
										<?=$unique_visits?>
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						</div>


						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon elevation-1" style="background-color: #426db0 !important;"><i class="fas fa-user-friends text-white"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">Number of returning visitors</span>
									<span class="info-box-number">
										<?=$returning_visits?>
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						</div>

						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon elevation-1" style="background-color: #75930b !important;"><i class="fas fa-briefcase text-white"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">Number of total resource to the briefcases</span>
									<span class="info-box-number">
										<?=$total_resource_downloads?>
									</span>
								</div>
								<!-- /.info-box-content -->
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="row mb-2">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title"><i class="fas fa-clipboard-list" style="color: #5b8cff;"></i> All Logs</h5>
				</div>
				<div class="card-body pb-0">
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
		"dom": 'lBfrtip',
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
		"order": [[ 5, "desc" ]],
		buttons:
				[
					{ extend: 'excel', text: '<i class="far fa-file-excel"></i> Export Excel', className:'btn-success', title:'<?=$booth->name?> - booth analytics (<?=date('Y-m-d')?>)' }
				]
	});
</script>
