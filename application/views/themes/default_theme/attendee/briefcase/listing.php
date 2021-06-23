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
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('agenda' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda">My Agenda</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('resources' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources">Resources</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('credits' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="credits-tab" data-toggle="tab" href="#credits" role="tab" aria-controls="credits">Credits</a></li>
									<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('notes' == $active_briefcase_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes">Notes</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane p-2<?php echo (('agenda' == $active_briefcase_tab) ? ' active' : '' );?>" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
										<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">My Agenda</h3></div>
<?php
									if ($sessions != new stdClass()) :
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
															<p>
<?php
																if($session->moderators != new stdClass()):?>
																<span>Moderator:</span>
<?php
																	foreach ($session->moderators as $index=> $moderator):?>
																	<?=(isset($index) && ($index >= 1))?',':''?>
																	<?=$moderator->name." ".$moderator->surname.(!empty($moderator->credentials)?' '.$moderator->credentials:'')?>
<?php
																	endforeach;?><br>
<?php
																endif;
																if($session->keynote_speakers != new stdClass()):?>
																<span>Keynote:</span>
<?php
																	foreach ($session->keynote_speakers as $index=> $keynote):?>
																	<?=(isset($index) && ($index >= 1))?',':''?>
																	<a style="cursor: pointer" class="keynote-link" keynote-id="<?=$keynote->id?>" speaker-name="<?= $keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')?>">
																		<?=$keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')?>
																	</a>
																		<bio style="display: none;" session-id="<?=$keynote->id?>"><?=$keynote->bio?></bio>
																		<disclosure style="display: none;" session-id="<?=$keynote->id?>"><?=$keynote->disclosures?></disclosure>
<?php
																	endforeach;?><br>
<?php
																endif;

																if($session->presenters != new stdClass()):?>
																<span>Speakers:</span>
<?php
																	foreach ($session->presenters as $index=>$presenter):
																		echo ((isset($index) && ($index>=1))?", ":'').trim($presenter->name)." ".trim($presenter->surname).(!empty(trim($presenter->credentials))?' '.trim($presenter->credentials):'');
																	endforeach;?><br>
<?php
																endif; ?>
															</p>
															<hr>
															<p><?=$session->description?></p>
														</div>

														<div class="col-12 text-md-right text-sm-center" style="position: relative;bottom: 0;">
															<a class="btn btn-sm btn-danger m-1 rounded-0 text-white remove-briefcase-btn" data-session-id ="<?=$session->id?>"><i class="fas fa-trash"></i> Remove</a>
														</div>
														<agenda style="display: none;" session-id="<?=$session->id?>"><?=$session->agenda?></agenda>

													</div>
												</div>
											</div>
										</div>
										<!-- End Session Listing Item -->
<?php
										endforeach;
									else :?>

										<div class="alert alert-danger" role="alert">
										  Nothing in your agenda.
										</div>
<?php
									endif;?>
									</div>
									<div class="tab-pane p-2<?php echo (('resources' == $active_briefcase_tab) ? ' active' : '' );?>" id="resources" role="tabpanel" aria-labelledby="resources-tab">
										<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">Resources</h3></div>
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
										<!-- Credit tabs -->
										<ul class="nav nav-tabs" id="credit-tabs" role="tablist">
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('session-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="session-credits-tab" data-toggle="tab" href="#session-credits" role="tab" aria-controls="session-credits">General Sessions</a></li>
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('eposter-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="eposter-credits-tab" data-toggle="tab" href="#eposter-credits" role="tab" aria-controls="eposter-credits">ePosters</a></li>
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('stc-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="stc-credits-tab" data-toggle="tab" href="#stc-credits" role="tab" aria-controls="stc-credits">STC</a></li>
											<li class="nav-item" role="presentation"><a class="nav-link<?php echo (('scavenger-hunt-credits' == $active_credit_tab) ? ' active" aria-selected="true"' : '" aria-selected="false"' );?>" id="scavenger-hunt-credits-tab" data-toggle="tab" href="#scavenger-hunt-credits" role="tab" aria-controls="scavenger-hunt-credits">Scavenger Hunt</a></li>
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
											<div class="tab-pane p-2 fade" id="scavenger-hunt-credits" role="tabpanel" aria-labelledby="scavenger-hunt-credits-tab">
												<div class="text-center btn card mb-2 page-title"><h3 class="mb-0">Scavenger Hunt Items</h3></div>
												<table id="scavengerHuntItemTable" class="dataTable table table-bordered" style="width:100%;">
													<thead>
														<tr>
															<th>#</th>
															<th>Booth</th>
															<th>Item Found</th>
															<th>Collected On</th>
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
		let note_page = 1;
		let notes_per_page = parseInt(<?=$notes_per_page;?>);

		function showNotes(entity_type, entity_type_id, note_page) {
			$('#addUserNotes input[name="entity_type"]').val(entity_type);
			$('#addUserNotes input[name="entity_type_id"]').val(entity_type_id);
			loadNotes(entity_type, entity_type_id, note_page)
			$('#notes_list_container').html('');
			$('#notesModal').modal('show');
		}

		function showMoreNotes(entity_type, entity_type_id, note_page) {
			note_page = note_page+1;
			loadNotes(entity_type, entity_type_id, note_page);
		}

		function loadNotes(entity_type, entity_type_id, note_page) {
			console.log('Note Page : ' + note_page);
			Swal.fire({
				title: 'Please Wait',
				text: 'Loading notes...',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			$.ajax({type: "GET",
					url: project_url+"/eposters/notes/"+entity_type+'/'+entity_type_id+'/'+note_page,
					data: '',
					success: function(response){
						Swal.close();
						jsonObj = JSON.parse(response);
						// Add response in Modal body

						$('.modal-title').html( ((entity_type == 'eposter') ? jsonObj.eposter.title : jsonObj.session.name ) + ' Notes');

						if (jsonObj.total) {
							$('.count_note strong').text(jsonObj.total);
							var previousHTML = $('#notes_list_container').html();
							var iHTML = '';
							if (previousHTML == '')
								iHTML += '<ul id="list_note" class="col-md-12">';

							for (let x in jsonObj.data) {
								let note_id 	= jsonObj.data[x].id;
								let note 		= jsonObj.data[x].note_text.replace(/(?:\r\n|\r|\n)/g, '<br>');
								let datetime 	= jsonObj.data[x].time;

								iHTML += '<!-- Start List Note ' + (x) +' --><li class="box_result row"><div class="result_note col-md-12"><p>'+note+'</p><div class="tools_note"><span>'+datetime+'</span></div></div></li>';
							}

							if (previousHTML == '')
								iHTML += '</ul>';

							$('#notesModal .modal-footer').html('<button' + (((parseInt(note_page)+parseInt(1)) <= Math.ceil(parseInt(jsonObj.total)/parseInt(notes_per_page))) ? ' class="btn btn-info btn-sm btn-block" onclick="showMoreNotes(\''+entity_type+'\', '+entity_type_id+', '+note_page+');"' : ' class="btn btn-info btn-block btn-sm disabled not-allowed" disabled' ) + ' type="button">Load more notes</button>');

							if (previousHTML == '') {
								$('#notes_list_container').html(iHTML);
							} else {
								$('#list_note').append(iHTML);
							}
						} else {
							$('.count_note strong').text('No ');
						}
					}
				});
		}

		$(document).ready(function() {
			$('#sessionCreditTable').DataTable({
				dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			   	buttons: [{text: 'Get Certificate (Will be available soon)',
		   	   	className: 'btn btn-info disabled',
		   			action: function ( e, dt, button, config ) {
	 					// window.open(ycl_root +'/cms_uploads/projects/3/briefcase/2021_COS_Program.pdf', "_blank");
		   			}
	      		}],
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '8%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getSessionCredits/gs", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			//ePoster Credit Table
			$('#eposterCreditTable').DataTable({
				dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			   	buttons: [{text: 'Get Certificate (Will be available soon)',
		   	   	className: 'btn btn-info disabled',
		   			action: function ( e, dt, button, config ) {
	 					// window.open(ycl_root +'/cms_uploads/projects/3/briefcase/2021_COS_Program.pdf', "_blank");
		   			}
	      		}],
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '8%' }, { sWidth: '7%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getEposterCredits", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('#stcCreditTable').DataTable({
				dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			   	buttons: [{text: 'Get Certificate (Will be available soon)',
		   	   	className: 'btn btn-info disabled',
		   			action: function ( e, dt, button, config ) {
	 					// window.open(ycl_root +'/cms_uploads/projects/3/briefcase/2021_COS_Program.pdf', "_blank");
		   			}
	      		}],
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '8%' }, { sWidth: '18%' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getSessionCredits/zm", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('#scavengerHuntItemTable').DataTable({'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
													  bAutoWidth: false, 
													  aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '12%' }, { sWidth: '18%' }],
													  'processing': true,
													  'serverSide': true,
													  'serverMethod': 'post',
													  'ajax': {url : project_url+"/briefcase/scavengerHuntItems", type : 'POST'},
													  'order': [[ 0, "ASC" ]]
			});

		    $('#sessionResourcesTable').DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
						    					   buttons: [{text: 'Download COS 2021 Program',
						    				   	   className: 'btn btn-block btn-info',
						    				   			action: function ( e, dt, button, config ) {
										 					window.open(ycl_root +'/cms_uploads/projects/3/briefcase/2021_COS_Program.pdf', "_blank");
											   			}
										      		}],
													"columns": [
													    { "data": "id", "name": "id"},
													    { "data": "session_title", "name": "session_title"},
													    { "data": "action_link", "name": "action_link",
													        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
													            if(oData.session_id) {
													                $(nTd).html('<a href="javascript:void(0);" onclick="showNotes(\'session\', '+oData.session_id+', \''+note_page+'\');" data-action-type="notes" data-eposter-id="'+oData.session_id+'" class="eposter-notes" data-toggle="tooltip" data-placement="left" data-original-title="View Notes"><i class="fas fa-clipboard fa-fw"></i> View</a>');
													            }
													        }
													    },
													    { "data": "added_on", "name": "added_on"},
													],
										      		'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
										      		bAutoWidth: false, 
										      		aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '7%' }, { sWidth: '18%' }],
										      		'processing': true,
										      		'serverSide': true,
										      		'serverMethod': 'post',
										      		'ajax': {url : project_url+"/briefcase/getSessionNotes", type : 'POST'},
										      		"order": [[ 0, "ASC" ]]
			});

			$('#sessionNotesTable').DataTable({'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
											   'columns': [{"data": "id", "name": "id"},
											   			   {"data": "session_title", "name": "session_title"},
											   			   {"data": "action_link", "name": "action_link",
														        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
														            if(oData.session_id) {
														                $(nTd).html('<a href="javascript:void(0);" onclick="showNotes(\'session\', '+oData.session_id+', \''+note_page+'\');" data-action-type="notes" data-eposter-id="'+oData.session_id+'" class="eposter-notes" data-toggle="tooltip" data-placement="left" data-original-title="View Notes"><i class="fas fa-clipboard fa-fw"></i> View</a>');
														            }
														        }
				    									   },
				    									   {"data": "added_on", "name": "added_on"}],
												bAutoWidth: false,
												aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '7%' }, { sWidth: '18%' }],
												'processing': true,
												'serverSide': true,
												'serverMethod': 'post',
												'ajax': {url : project_url+"/briefcase/getSessionNotes", type : 'POST'},
												'order': [[0, 'ASC']]
		    });

			$('#eposterNotesTable').DataTable({
				'lengthMenu': [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				"columns": [
				    { "data": "id", "name": "id", "width": "2%"},
				    { "data": "eposter_name", "name": "eposter_name"},
				    { "data": "eposter_type", "name": "eposter_type", "width": "12%"},
				    { "data": "action_link", "name": "action_link", "width": "6%",
				        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
				            if(oData.eposter_id) {
				                $(nTd).html('<a href="javascript:void(0);" onclick="showNotes(\'eposter\', '+oData.eposter_id+', \''+note_page+'\');" data-action-type="notes" data-eposter-id="'+oData.eposter_id+'" class="eposter-notes" data-toggle="tooltip" data-placement="left" data-original-title="View Notes"><i class="fas fa-clipboard fa-fw"></i> View</a>');
				            }
				        }
				    },
				    { "data": "added_on", "name": "added_on", "width": "16%"},
				],
				bAutoWidth: false, 
				aoColumns : [{ sWidth: '2%' }, { sWidth: 'auto' }, { sWidth: '20%' }, { sWidth: '6%' }, { sWidth: 'auto' }],
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {url : project_url+"/briefcase/getEposterNotes", type : 'POST'},
		        "order": [[ 0, "ASC" ]]
		    });

			$('.remove-briefcase-btn').on('click', function() {
				Swal.fire({
					title: 'Please Wait',
					text: 'Removing from your briefcase...',
					imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
					imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
					imageAlt: 'Loading...',
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});

				var buttonElement = $(this);

				$.ajax({type: "POST",
						url: project_url+"/briefcase/delete",
						data: {'session_id' : $(this).data('session-id')},
						error: function(jqXHR, textStatus, errorMessage)
						{
							Swal.close();
							toastr.error(errorMessage);
						},
						success: function(response){
							$(buttonElement).parent().parent().parent().parent().parent().hide('slow').remove();
							Swal.close();
							toastr.success('Removed successfully.');
						}
				});
			});
		});
	</script>
