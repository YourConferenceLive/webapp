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
					<h1 class="m-0">Credits Report</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Credits Report</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<section class="content" style="width: fit-content;">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Credits Report</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="card">
								      	<div class="card-header">
								        	<h3 class="card-title">Section 1 - Group Learning</h3>
								      	</div>
								      		<div class="card-body">
												<table id="sessionCreditTable" class="dataTable table table-striped table-bordered mt-2" style="width:100%;">
													<thead>
														<tr>
															<th>ParticipantId</th>
															<th>ActivityId</th>
															<th>MP_GroupLearningDirect</th>
															<th>MP_GroupLearing_Accredited</th>
															<th>MP_ActivityHours</th>
															<th>MP_DescribeGroupActivity(title)</th>
															<th>MP_ActivityConclusion</th>
															<th>MP_ActivityCompletionDate</th>
															<th>MP_Canmeds</th>
															<th>MP_Resources</th>
															<th>MP_Organization_Name</th>
															<th>MP_Location</th>
															<th class="text-nowrap">MP_reflection q1</th>
															<th class="text-nowrap">MP_reflection q2</th>
															<th class="text-nowrap">MP_reflection q3</th>
															<th>MP_CanMEDsCollaborator</th>
															<th>MP_CanMEDsCommunicator</th>
															<th>MP_CanMEDsHealthAdvocate</th>
															<th>MP_CanMEDsManager</th>
															<th>MP_CanMEDsMedicalExpert</th>
															<th>MP_CanMEDsProfessional</th>
															<th>MP_CanMEDsScholar</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
								      		</div>
								    	</div>
									</div>
								</div>

								<div class="row">
									<div class="col-12">
										<div class="card">
											<div class="card-header">
								        		<h3 class="card-title">Section 2 - Self - Learning</h3>
								      		</div>
								      		<div class="card-body">
												<table id="eposterCreditTable" class="dataTable table table-striped table-bordered mt-2" style="width:100%;">
													<thead>
														<tr>
															<th>ParticipantId</th>
															<th>ActivityId</th>
															<th>MP_SelfLearningList</th>
															<th>MP_ActivityHours</th>
															<th>MP_DescribeAssessmentActivity(title)</th>
															<th>MP_ActivityConclusion</th>
															<th>MP_SelfLearningCompletionDate</th>
															<th>MP_Canmeds</th>
															<th>MP_Resources</th>
															<th>MP_Organization_Name</th>
															<th>MP_Location</th>
															<th class="text-nowrap">MP_reflection q1</th>
															<th>MP_reflection q2</th>
															<th>MP_reflection q3</th>
															<th>MP_CanMEDsCollaborator</th>
															<th>MP_CanMEDsCommunicator</th>
															<th>MP_CanMEDsHealthAdvocate</th>
															<th>MP_CanMEDsManager</th>
															<th>MP_CanMEDsMedicalExpert</th>
															<th>MP_CanMEDsProfessional</th>
															<th>MP_CanMEDsScholar</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-12">
										<div class="card">
											<div class="card-header">
								        		<h3 class="card-title">Section 3 - Practice Assessment</h3>
								        	</div>
								      		<div class="card-body">
												<table id="stcCreditTable" class="dataTable table table-striped table-bordered mt-2" style="width:100%;">
													<thead>
														<tr>
															<th>ParticipantID</th>
															<th>ActivityID</th>
															<th>MP_AssessmentActivityDirect</th>
															<th>MP_ActivityHours</th>
															<th>MP_DescribeAssessmentActivity(title)</th>
															<th>MP_AssessmentCompletionDate</th>
															<th>MP_Organization_Name</th>
															<th>MP_Location</th>
															<th>MP_Canmeds</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

	<!-- DataTables & Plugins -->
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
		$(document).ready(function() {
			$('#sessionCreditTable').DataTable({
        		"columnDefs": [ {"targets": 'no-sort', "orderable": false} ],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/admin/accreditation_reports/getAllSessionsCredits/gs", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });
	
			$('#eposterCreditTable').DataTable({
        		"columnDefs": [ {"targets": 'no-sort', "orderable": false} ],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/admin/accreditation_reports/getAllEpostersCredits", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });
	
			$('#stcCreditTable').DataTable({
        		"dom": 'lBfrtip',
				"columnDefs": [ {"targets": 'no-sort', "orderable": false} ],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/admin/accreditation_reports/getAllSessionsCredits/stc", type : 'POST'},
		        "order": [[ 0, "ASC" ]],
				buttons:[{ extend: 'excel', text: '<i class="far fa-file-excel"></i> Export Excel', className:'btn-success', title:'Practice Assessment Export' }]
		    });
		});
	</script>
