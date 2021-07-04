<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($logs);exit("</pre>");
?>

<style>
	#sessionsTable_filter, #sessionsTable_paginate{
		float: right;
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Analytics</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Analytics</a></li>
						<li class="breadcrumb-item active">Relaxation Zone</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
	        <div class="row">

				<div class="col-lg-6 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
<?php
							foreach ($stats as $row) {
								if (in_array($row->date, array('2021-06-24', '2021-06-25', '2021-06-26', '2021-06-27'))):?>
							<div class="col-6 m-0 p-0 float-sm-left">
								<h3<?php echo ((in_array($row->date, array('2021-06-26', '2021-06-27'))) ? ' class="m-0"' : '' );?>><?php echo $row->total_rows;?> <sup style="font-size:50%; font-weight: normal; font-style:italic;">visits on <?php echo $row->date;?></sup></h3>
							</div>
<?php
								endif;
							}?>
							<div class="clearfix"></div>
						</div>
              			<div class="icon"><i class="ion ion-person-add"></i></div>
            		</div>
          		</div>
          		<!-- ./col -->

          		<div class="col-lg-3 col-6">
            		<!-- small box -->
            		<div class="small-box bg-info">
              			<div class="inner">
                			<h3><?php echo count($logs);?></h3>
                			<p>Total Visitors</p>
              			</div>
              			<div class="icon"><i class="ion ion-bag"></i></div>
            		</div>
         		</div>
				<!-- ./col -->

				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
			                <h3><?php echo number_format(($unique_visitors/count($logs))*100, 2);?><sup style="font-size: 20px">%</sup></h3>
			                <p>Unique Visitors</p>
            			</div>
						<div class="icon"><i class="ion ion-stats-bars"></i></div>
            		</div>
          		</div>
				<!-- ./col -->
	        </div>
	        <!-- /.row -->

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Relaxation Zone</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="logsTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Name</th>
										<th>Surname</th>
										<th>Degree</th>
										<th>Email</th>
										<th>City</th>
										<th>What</th>
										<th>Browser</th>
										<th>OS</th>
										<th>Time</th>
									</tr>
								</thead>
								<tbody id="logsTableBody">
<?php
								foreach ($logs as $log):?>
									<tr>
										<td><?=$log->user_id?></td>
										<td><?=$log->user_fname?></td>
										<td><?=$log->user_surname?></td>
										<td><?=$log->credentials?></td>
										<td><?=$log->email?></td>
										<td><?=$log->city?></td>
										<td><?=$log->name?></td>
										<td><?=$log->browser?></td>
										<td><?=$log->os?></td>
										<td><?=$log->date_time?></td>
									</tr>
<?php
								endforeach;?>
								</tbody>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
			<!-- /.row -->
		</div><!--/. container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
	$(function () {
		$('#logsTable').DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
								   buttons:[{ extend: 'excel', 
					   						  text: '<i class="far fa-file-excel"></i> Relaxation Zone Export', 
					   						  className:'btn-info', 
					   						  title:'Relaxation-Zone-Export-<?php echo date('mdY');?>'
											}],
								   "paging": true,
								   "lengthChange": true,
								   "searching": true,
								   "ordering": true,
								   "info": true,
								   "autoWidth": false,
								   "responsive": true,
								   "order": [[ 7, "desc" ]]
		});
	});
</script>
