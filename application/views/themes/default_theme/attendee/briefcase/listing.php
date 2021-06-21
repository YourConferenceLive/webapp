<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/briefcase.css?v=<?=rand()?>" rel="stylesheet">

	<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/briefcase/briefcase_background.jpg">

	<div class="clearfix" style="margin-bottom: 7rem;"></div>
	<div class="briefcase-container container-fluid pl-md-6 pr-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center btn card mb-2 page-title"><h1 class="mb-0">My Briefcase</h1></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="briefcase-items">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 p-3">
								<!-- Briefcase tabs -->
								<ul class="nav nav-tabs" id="briefcase-tabs" role="tablist">
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('itinerary' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="itinerary-tab" data-toggle="tab" href="#itinerary" role="tab" aria-controls="itinerary">My Agenda</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('resources' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources">Resources</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('credits' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="credits-tab" data-toggle="tab" href="#credits" role="tab" aria-controls="credits">Credits</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('notes' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes">Notes</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane p-2<?php echo (('itinerary' == $active_briefcase_tab) ? ' active' : '' );?>" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab">
										<div class="text-center btn card mb-2 page-title"><h2 class="mb-0">My Agenda</h2></div>
										<!-- /********************************************/ -->
<?php
										foreach ($sessions as $session):?>
										<!-- Session Listing Item -->
										<div class="sessions-listing-item pb-3">
											<div class="container-fluid">
												<div class="row mt-2">
													<div class="col-md-3 col-sm-12 p-0">
														<div class="session-img-div pl-2 pt-2 pb-2 pr-2 text-center">
															<img class="session-img img-fluid"
																 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/<?=$session->thumbnail?>"
																 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/default'">
														</div>
													</div>
													<div class="col-md-9 col-sm-12 pl-0 pt-2">
														<div class="col-12 text-md-left text-sm-center">
															<div class="col-6 text-left float-left p-0">
																<span><?=date("l, jS F, Y g:iA", strtotime($session->start_date_time))?> - <?=date("g:iA", strtotime($session->end_date_time))?> EST</span>  
															</div>
															<div class="col-4 text-right float-right p-0 ">
																<span class="badge badge-pill badge-primary pull-right"><?php echo $session->session_track;?></span>  
															</div>
															<div class="clearfix"></div>
															<h4 class="p-0 m-0 mt-1 mb-1"><a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="p-0 mt-1" style="color:#487391"><?=$session->name?></a></h4>
															<h4 class="p-0 m-0 mt-1 mb-1"><a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="" style="color: #284050;"><?=$session->other_language_name?></a></h4>
															<p><?php if($session->moderators != new stdClass()):?>
																<span>Moderator:</span>
																<?php foreach ($session->moderators as $index=> $moderator):?>
																	<?=(isset($index) && ($index >= 1))?',':''?>
																	<?=$moderator->name." ".$moderator->surname.(!empty($moderator->credentials)?' '.$moderator->credentials:'')?>
																<?php endforeach; ?><br>
																<?php endif;?>

																<?php if($session->keynote_speakers != new stdClass()):?>
																<span>Keynote:</span>
																<?php foreach ($session->keynote_speakers as $index=> $keynote):?>
																	<?=(isset($index) && ($index >= 1))?',':''?>
																	<a style="cursor: pointer" class="keynote-link" keynote-id="<?=$keynote->id?>" speaker-name="<?= $keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')?>">
																		<?=$keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')?>
																	</a>
																		<bio style="display: none;" session-id="<?=$keynote->id?>"><?=$keynote->bio?></bio>
																		<disclosure style="display: none;" session-id="<?=$keynote->id?>"><?=$keynote->disclosures?></disclosure>
																<?php endforeach; ?><br>
																<?php endif; ?>
																<?php if($session->presenters != new stdClass()):?>
																<span>Speakers:</span>
<?php
																	foreach ($session->presenters as $index=>$presenter):
																		echo ((isset($index) && ($index>=1))?", ":'').trim($presenter->name)." ".trim($presenter->surname).(!empty(trim($presenter->credentials))?' '.trim($presenter->credentials):'');
																	endforeach;?><br>
																<?php endif; ?>
															</p>
															<hr>
															<p><?=$session->description?></p>
														</div>

														<div class="col-12 text-md-right text-sm-center" style="position: relative;bottom: 0;">
															<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="btn btn-sm btn-danger m-1 rounded-0 text-white"><i class="fas fa-trash"></i> Remove</a>
														</div>
														<agenda style="display: none;" session-id="<?=$session->id?>"><?=$session->agenda?></agenda>

													</div>
												</div>
											</div>
										</div>
<?php
										endforeach; ?>
										<!-- /********************************************/ -->
									</div>
									<div class="tab-pane p-2<?php echo (('resources' == $active_briefcase_tab) ? ' active' : '' );?>" id="resources" role="tabpanel" aria-labelledby="resources-tab">
										<div class="text-center btn card mb-2 page-title"><h2 class="mb-0">Resources</h2></div>
										<table id="sessionResourcesTable" class="dataTable table table-bordered" style="width:100%;">
											<thead>
												<tr>
													<th>#</th>
													<th>Session</th>
													<th>Action</th>
													<th>Added On</th>
												</tr>
											</thead>
										</table>
									</div>
									<div class="tab-pane p-2<?php echo (('credits' == $active_briefcase_tab) ? ' active' : '' );?>" id="credits" role="tabpanel" aria-labelledby="credits-tab">
										<a href="#" class="btn btn-info float-right">Get Certificate</a>

										<div class="clearfix"></div>

										<!-- Credit tabs -->
										<ul class="nav nav-tabs" id="credit-tabs" role="tablist">
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('session-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="session-credits-tab" data-toggle="tab" href="#session-credits" role="tab" aria-controls="session-credits">General Sessions</a></li>
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('eposter-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="eposter-credits-tab" data-toggle="tab" href="#eposter-credits" role="tab" aria-controls="eposter-credits">ePosters</a></li>
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('stc-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="stc-credits-tab" data-toggle="tab" href="#stc-credits" role="tab" aria-controls="stc-credits">STC</a></li>
										</ul>

										<div class="tab-content" id="credit-tab-content">
											<div class="tab-pane p-2 fade show active" id="session-credits" role="tabpanel" aria-labelledby="session-credits-tab">
												<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">Session Credits</h3></div>
												<table id="sessionCreditTable" class="dataTable table table-bordered" style="width:100%;">
													<thead>
														<tr>
															<th>#</th>
															<th>Session</th>
															<th>Credit</th>
															<th>Added On</th>
														</tr>
													</thead>
												</table>
											</div>
											<div class="tab-pane p-2 fade" id="eposter-credits" role="tabpanel" aria-labelledby="eposter-credits-tab">
												<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">ePoster Credits</h3></div>
												<table id="eposterCreditTable" class="dataTable table table-bordered" style="width:100%;">
													<thead>
														<tr>
															<th>#</th>
															<th>ePoster</th>
															<th>Type</th>
															<th>Credit</th>
															<th>Added On</th>
														</tr>
													</thead>
												</table>
											</div>
											<div class="tab-pane p-2 fade" id="stc-credits" role="tabpanel" aria-labelledby="stc-credits-tab">
												<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">STC Credits</h3></div>
												<table id="stcCreditTable" class="dataTable table table-bordered" style="width:100%;">
													<thead>
														<tr>
															<th>#</th>
															<th>Session</th>
															<th>Credit</th>
															<th>Added On</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane p-2<?php echo (('notes' == $active_briefcase_tab) ? ' active' : '' );?>" id="notes" role="tabpanel" aria-labelledby="notes-tab">
										<!-- Notes tabs -->
										<ul class="nav nav-tabs" id="notes-tabs" role="tablist">
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('session-notes' == $active_note_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="session-notes-tab" data-toggle="tab" href="#session-notes" role="tab" aria-controls="session-notes">Sessions</a></li>
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('eposter-notes' == $active_note_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="eposter-notes-tab" data-toggle="tab" href="#eposter-notes" role="tab" aria-controls="eposter-notes">ePosters</a></li>
										</ul>

										<div class="tab-content" id="notes-tab-content">
											<div class="tab-pane p-2 fade<?php echo (('session-notes' == $active_note_tab) ? ' show active"' : '"' );?>" id="session-notes" role="tabpanel" aria-labelledby="session-notes-tab">
												<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">Session Notes</h3></div>
												<table id="sessionNotesTable" class="dataTable table table-bordered" style="width:100%;">
													<thead>
														<tr>
															<th>#</th>
															<th>Session</th>
															<th>Action</th>
															<th>Added On</th>
														</tr>
													</thead>
												</table>
											</div>
											<div class="tab-pane p-2 fade<?php echo (('eposter-notes' == $active_note_tab) ? ' show active"' : '"' );?>" id="eposter-notes" role="tabpanel" aria-labelledby="eposter-notes-tab">
												<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">ePoster Notes</h3></div>
												<table id="eposterNotesTable" class="dataTable table table-bordered" style="width:100%;">
													<thead>
														<tr>
															<th>#</th>
															<th>ePoster</th>
															<th>Type</th>
															<th>Action</th>
															<th>Added On</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- DataTables  & Plugins -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#sessionCreditTable').DataTable({
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '8%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getSessionCredits/gs", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('#stcCreditTable').DataTable({
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '8%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getSessionCredits/zm", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('#eposterCreditTable').DataTable({
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '8%' }, { sWidth: '7%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getEposterCredits", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('#sessionNotesTable, #sessionResourcesTable').DataTable({
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '7%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getSessionNotes", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('#eposterNotesTable').DataTable({
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '7%' }, { sWidth: '6%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getEposterNotes", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('.view-notes').click(function(e) {
				alert('Here is now');
			});
		});
	</script>
