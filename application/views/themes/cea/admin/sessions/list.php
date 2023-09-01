<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<style>
#sessionsTable_filter, #sessionsTable_paginate{float: right;}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Sessions</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Sessions</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<select class="form-control" id="session_list_type">
									<option value="all_sessions" url="getAllJson">Sessions</option>
									<option value="today_sessions" url="getAllToday">Today Sessions</option>
										<option value="tomorrow_sessions" url="getAllTomorrow">Tomorrow Sessions</option>
									<option value="archived_sessions" url="getAllArchived">Archived Sessions</option>
								</select>
							</h3>
							<button class="add-session-btn btn btn-success float-right"><i class="fas fa-plus"></i> Add</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="sessionsTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Session ID</th>
										<th>Day</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Name</th>
										<th>People</th>
										<th>Credits</th>
										<th>Notes</th>
										<th>Actions</th>
										<th>Manage</th>
										<th>Export</th>
										<th>JSON(s)</th>
									</tr>
								</thead>
								<tbody id="sessionsTableBody">
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
	// let session_list_type = $('#session_list_type').find(':selected').val();
		// let getFrom = $('#session_list_type').attr('url');
		listSessions();
		
		$('#session_list_type').on('change', function(){
			listSessions();
		})

		$('#sessionsTable').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});

		$('.add-session-btn').on('click', function () {

			getColorPreset();
			$('#addSessionModalLabelspan').text(`Add New Session`)
			$('#addSessionForm')[0].reset();
			$('#currentPhotoDiv').hide();
			$('#currentSponsorLogoDiv').hide();
			$('#sponsorLogoWidth').val('');
			$('#sponsorLogoHeight').val('');
			$('#sessionDescription').summernote('reset');
			$('.removeall').click();
			// $('#sponsorId').val(0);
			// $('#logo_preview').hide();
			// $('#logo_label').text('');
			// $('#banner_preview').hide();
			// $('#banner_label').text('');
			$('#save-session').html('<i class="fas fa-plus"></i> Create');

			$('#addSessionModal').modal({
				backdrop: 'static',
				keyboard: false
			});


		});

		$('#sessionsTable').on('click', '.manageSession', function () {

			let session_id = $(this).attr('session-id');
			getColorPreset();

			const translationData = fetchAllText(); // Fetch the translation data

            translationData.then((arrData) => {
                const selectedLanguage = $('#languageSelect').val(); // Get the selected language

                // Find the translations for the dialog text
                let dialogTitle = 'Please Wait';
                let dialogText = 'Loading session data...';
				let imageAltText = 'Loading...';

                for (let i = 0; i < arrData.length; i++) {
                    if (arrData[i].english_text === dialogTitle) {
                        dialogTitle = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === dialogText) {
                        dialogText = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === imageAltText) {
                        imageAltText = arrData[i][selectedLanguage + '_text'];
                    }
                }
				
				Swal.fire({
					title: dialogTitle,
					text: dialogText,
					imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
					imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
					imageAlt: imageAltText,
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});
                
				$.get(project_admin_url+"/sessions/getByIdJson/"+session_id, function (session) {
					session = JSON.parse(session);
					console.log(session);

					// set the session title here
					$('#addSessionModalLabelspan').text(`Session ID: ${session.id}`)

					$('#sessionId').val(session.id);
					$('#sessionName').val(session.name);
					$('#sessionNameOther').val(session.other_language_name);

					$(`#roomID`).val(session.room_id);

					$('#eventID').val(session.event_id);
					$(`#sessionTrack option[value="${session.track}"]`).prop('selected', true);
	
					$('#sessionExternalUrl').val('');
					$('#sessionExternalUrlDiv').hide();
					$('#sessionExternalUrl').val(session.external_meeting_link);
	
					if (session.external_meeting_link != null || session.external_meeting_link == '' )
						$('#sessionExternalUrlDiv').show();
	
					$(`#sessionType option[value="${session.session_type}"]`).prop('selected', true);
	
					$('#sessionCredits').val(session.credits);
					$("#sessionDescription").summernote("code", session.description);
					$('#startDateTimeInput').datetimepicker('date', moment(session.start_date_time, 'YYYY-MM-DD HH:mm:ss'));
					$('#endDateTimeInput').datetimepicker('date', moment(session.end_date_time, 'YYYY-MM-DD HH:mm:ss'));
	
					$('#sessionPhoto').val('');
					if (session.thumbnail != '') {
						$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/'+session.thumbnail);
						$('#currentPhotoDiv').show();
					}else{
						$('#currentPhotoDiv').hide();
					}
	
					$('#sessionSponsorLogo').val('');
					if ((session.sponsor_logo) !== "" ) {
						$('#currentSponsorLogo').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/'+session.sponsor_logo);
						$('#currentSponsorLogoDiv').show();
					}else{
						$('#currentSponsorLogoDiv').hide();
					}
	
					$('#sessionSessionLogo').val('');
					if ((session.session_logo) !== "" ) {
						$('#currentSessionLogo').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/logo/'+session.session_logo);
						$('#currentSessionLogoDiv').show();
					}else{
						$('#currentSessionLogoDiv').hide();
					}
					
					if(session.session_logo  !== '') {
							$('#currentMobileSessionBackground').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/images/background/' + session.mobile_session_background);
							$('#currentMobileSessionBackgroundDiv').show();
					}else
						$('#currentMobileSessionBackgroundDiv').hide();
	
					$('#sponsorLogoWidth').val(session.sponsor_logo_width);
					$('#sponsorLogoHeight').val(session.sponsor_logo_height);
					$('#sessionLogoHeight').val(session.session_logo_width);
					$('#sessionLogoHeight').val(session.session_logo_height);
	
					$("#sessionAgenda").summernote("code", session.agenda);
					$('#millicastStream').val(session.millicast_stream);
					$('#zoomLink').val(session.zoom_link);
					$('#sessionVideo').val(session.video_url);
					$('#slidesHtml').html(session.presenter_embed_code);
	
					$('#sessionClaimCreditLink').val(session.claim_credit_link);
					$('#sessionClaimCreditUrl').val(session.claim_credit_url);
	
					$('#notes_text').val(session.toolbox_note_text);
					$('#resource_text').val(session.toolbox_resource_text);
					$('#question_text').val(session.toolbox_question_text);
					$('#ask_a_rep_text').val(session.toolbox_askrep_text);
					$('#sessionNotes').val(session.notes);
	
					$('#button1_text').val(session.button1_text);
					$('#button1_link').val(session.button1_link);
					$('#button2_text').val(session.button2_text);
					$('#button2_link').val(session.button2_link);
					$('#button3_text').val(session.button3_text);
					$('#button3_link').val(session.button3_link);
	
					$('#sessionColorPreset').val(session.attendee_settings_id);
					$('#sessionEndRedirect').val(session.session_end_redirect);

					if(session.auto_redirect_status == 1){
						$('#autoRedirectSwitch').attr('checked','checked')
					}else{
						$('#autoRedirectSwitch').removeAttr('checked')
					}
					// Moderators
					$('select[name="sessionModerators[]"] option').prop('selected', false);
					$('select[name="sessionModerators[]"]').bootstrapDualListbox('refresh', true);
					$.each(session.moderators, function(key, moderator){
						$('select[name="sessionModerators[]"] option[value="'+moderator.id+'"]').prop('selected', true);
					});
					$('select[name="sessionModerators[]"]').bootstrapDualListbox('refresh', true);
	
					// Keynote Speakers
					$('select[name="sessionKeynoteSpeakers[]"] option').prop('selected', false);
					$('select[name="sessionKeynoteSpeakers[]"]').bootstrapDualListbox('refresh', true);
					$.each(session.keynote_speakers, function(key, keynote_speaker){
						$('select[name="sessionKeynoteSpeakers[]"] option[value="'+keynote_speaker.id+'"]').prop('selected', true);
					});
					$('select[name="sessionKeynoteSpeakers[]"]').bootstrapDualListbox('refresh', true);
	
					// Presenters
					$('select[name="sessionPresenters[]"] option').prop('selected', false);
					$('select[name="sessionPresenters[]"]').bootstrapDualListbox('refresh', true);
					$.each(session.presenters, function(key, presenter){
						$('select[name="sessionPresenters[]"] option[value="'+presenter.id+'"]').prop('selected', true);
					});
					$('select[name="sessionPresenters[]"]').bootstrapDualListbox('refresh', true);
	
					// Invisible Moderators
					$('select[name="sessionInvisibleModerators[]"] option').prop('selected', false);
					$('select[name="sessionInvisibleModerators[]"]').bootstrapDualListbox('refresh', true);
					$.each(session.invisible_moderators, function(key, invisible_moderator){
						$('select[name="sessionInvisibleModerators[]"] option[value="'+invisible_moderator.id+'"]').prop('selected', true);
					});
					$('select[name="sessionInvisibleModerators[]"]').bootstrapDualListbox('refresh', true);
	
	
					//Settings
					if(session.header_toolbox_status == 1){
						$('#headerToolboxSwitch').attr('checked','checked')
					}
					if(session.right_sticky_notes == 1){
						$('#rightNotesSwitch').attr('checked','checked')
					}
					if(session.right_sticky_resources == 1){
						$('#rightResourcesSwitch').attr('checked','checked')
					}
					if(session.right_sticky_question == 1){
						$('#rightQuestionSwitch').attr('checked','checked')
					}
					if(session.right_sticky_askrep == 1){
						$('#rightAskARepSwitch').attr('checked','checked')
					}
	
	
					if(session.header_question == 1){
						$('#headerQuestion').attr('checked','checked')
					}
					if(session.header_notes == 1){
						$('#headerNotes').attr('checked','checked')
					}
					if(session.header_resources == 1){
						$('#headerResources').attr('checked','checked')
					}
					if(session.header_askrep == 1){
						$('#headerAskRep').attr('checked','checked')
					}
					if(session.time_zone == "EDT"){
						$('#timeZone').val("EDT")
					}else{
						$('#timeZone').val("EST")
					}
	
	
					$("#sessionEndText").summernote("code", session.session_end_text);
					if (session.session_end_image != '' && session.session_end_image !== null) {
						$('#currentSessionEndImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/images/'+session.session_end_image);
						$('#currentSessionEndImage').show();
					}else{
						$('#currentSessionEndImage').hide();
					}
	
	
					$('#save-session').html('<i class="fas fa-save"></i> Save');
	
					Swal.close();
	
					$('#addSessionModal').modal({
						backdrop: 'static',
						keyboard: false
					});
				});
            });

		});

		$('#sessionsTable').on('click', '.removeSession', function () {
			let session_id = $(this).attr('session-id');
			let session_name = $(this).attr('session-name');

			const translationData = fetchAllText(); // Fetch the translation data

            translationData.then((arrData) => {
                const selectedLanguage = $('#languageSelect').val(); // Get the selected language

                // Find the translations for the dialog text
                let dialogTitle = 'Are you sure?';
				let html1 = "You are about to remove";
				let html2 = "(We will still keep it in our records for auditing)";
                let confirmButtonText = 'Yes, remove it!';
                let cancelButtonText = 'Cancel';

				// Swal 2
				let dialogTitle2 = 'Please Wait';
				let dialogText2 = "Removing the session...";
				let imageAltText2 = 'Loading...';

				// Swal 3
				let errorText = "Error!";
				let errorMsg = "Unable to remove";

				// Toastr
				let removedText = "has been removed!";

                for (let i = 0; i < arrData.length; i++) {
                    if (arrData[i].english_text === dialogTitle) {
                        dialogTitle = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === html1) {
                        html1 = arrData[i][selectedLanguage + '_text'];
                    }
					if (arrData[i].english_text === html2) {
                        html2 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === confirmButtonText) {
                        confirmButtonText = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === cancelButtonText) {
                        cancelButtonText = arrData[i][selectedLanguage + '_text'];
                    }

					if (arrData[i].english_text === dialogTitle2) {
                        dialogTitle2 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === dialogText2) {
                        dialogText2 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === imageAltText2) {
                        imageAltText2 = arrData[i][selectedLanguage + '_text'];
                    }

					if (arrData[i].english_text === errorText) {
                        errorText = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === errorMsg) {
                        errorMsg = arrData[i][selectedLanguage + '_text'];
                    }

					if (arrData[i].english_text === removedText) {
                        removedText = arrData[i][selectedLanguage + '_text'];
                    }
                }

				Swal.fire({
					title: dialogTitle,
					html: '<span class="text-white">'+html1+'<br>['+session_id+'] '+session_name+'<br><br><small>'+html2+'</small></span>',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText
				}).then((result) => {
					if (result.isConfirmed) {
	
						Swal.fire({
							title: dialogTitle2,
							text: dialogText2,
							imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
							imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
							imageAlt: imageAltText2,
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});
	
						$.get(project_admin_url+"/sessions/remove/"+session_id, function (response) {
							response = JSON.parse(response);
	
							if (response.status == 'success') {
								listSessions();
								toastr.success(session_name+" "+removedText);
							}else{
								Swal.fire(
										errorText,
										errorMsg+" "+session_name,
										'error'
								);
							}
						});
					}
				});
                
            });

		});

		// $('#sessionsTable').on('click', '.openPoll', function () {
		// 	socket.emit('openPoll');
		// });
		//
		// $('#sessionsTable').on('click', '.closePoll', function () {
		// 	socket.emit('closePoll');
		// });
		//
		// $('#sessionsTable').on('click', '.openResult', function () {
		// 	socket.emit('openResult');
		// });
		//
		// $('#sessionsTable').on('click', '.closeResult', function () {
		// 	socket.emit('closeResult');
		// });
	});

	function listSessions()
	{
		let getFrom = $('#session_list_type').find(':selected').attr('url');
		console.log(getFrom)
		const translationData = fetchAllText(); // Fetch the translation data

		translationData.then((arrData) => {
			const selectedLanguage = $('#languageSelect').val(); // Get the selected language

			// Find the translations for the dialog text
			let dialogTitle = 'Please Wait';
			let dialogText = 'Loading sessions data...';
			let imageAltText = 'Loading...';

			for (let i = 0; i < arrData.length; i++) {
				if (arrData[i].english_text === dialogTitle) {
					dialogTitle = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === dialogText) {
					dialogText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === imageAltText) {
					imageAltText = arrData[i][selectedLanguage + '_text'];
				}
			}

			Swal.fire({
				title: dialogTitle,
				text: dialogText,
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: imageAltText,
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});
			
			$.get(project_admin_url+"/sessions/"+ getFrom, function (sessions) {
				sessions = JSON.parse(sessions);
	
				$('#sessionsTableBody').html('');
				if ($.fn.DataTable.isDataTable('#sessionsTable'))
				{
					$('#sessionsTable').dataTable().fnClearTable();
					$('#sessionsTable').dataTable().fnDestroy();
				}
	
				$.each(sessions, function(key, session)
				{
					// Moderators badge
					let moderatorsList = '';
					let moderatorsNumber = Object.keys(session.moderators).length;
					let moderatorsBadgeType = 'badge-danger';
	
					if (moderatorsNumber > 0)
						moderatorsList += '<strong>Moderators List</strong><br><br>';
	
					$.each(session.moderators, function(key, moderator)
					{
						moderatorsList += moderator.name+' '+moderator.surname+' <br>('+moderator.email+')<br><br>';
					});
	
					if (moderatorsNumber > 0)
						moderatorsBadgeType = 'badge-success';
	
					let moderatorsBadge = '<badge class="badge badge-pill '+moderatorsBadgeType+'" data-html="true" data-toggle="tooltip" title="'+moderatorsList+'">M ('+moderatorsNumber+')</badge>';
	
					// Invisible Moderators badge
					let invisibleModeratorsList = '';
					let invisibleModeratorsNumber = Object.keys(session.invisible_moderators).length;
					let invisibleModeratorsBadgeType = 'badge-danger';
	
					if (invisibleModeratorsNumber > 0)
						invisibleModeratorsList += '<strong>Invisible Moderators</strong><br><br>';
	
					$.each(session.invisible_moderators, function(key, moderator)
					{
						invisibleModeratorsList += moderator.name+' '+moderator.surname+' <br>('+moderator.email+')<br><br>';
					});
	
					if (invisibleModeratorsNumber > 0)
						invisibleModeratorsBadgeType = 'badge-success';
	
					let invisibleModeratorsBadge = '<badge class="badge badge-pill '+invisibleModeratorsBadgeType+'" data-html="true" data-toggle="tooltip" title="'+invisibleModeratorsList+'">InM ('+invisibleModeratorsNumber+')</badge>';
	
					// Keynote Speakers badge
					let keynoteSpeakersList = '';
					let keynoteSpeakersNumber = Object.keys(session.keynote_speakers).length;
					let keynoteSpeakerBadgeType = 'badge-danger';
	
					if (keynoteSpeakersNumber > 0)
						keynoteSpeakersList += '<strong>Keynote Speakers List</strong><br><br>';
	
					$.each(session.keynote_speakers, function(key, keynote_speaker)
					{
						keynoteSpeakersList += keynote_speaker.name+' '+keynote_speaker.surname+' <br>('+keynote_speaker.email+')<br><br>';
					});
	
					if (keynoteSpeakersNumber > 0)
						keynoteSpeakerBadgeType = 'badge-success';
	
					let keynoteSpeakersBadge = '<badge class="badge badge-pill '+keynoteSpeakerBadgeType+'" data-html="true" data-toggle="tooltip" title="'+keynoteSpeakersList+'">K ('+keynoteSpeakersNumber+')</badge>';
	
					// Presenters badge
					let presentersList = '';
					let presentersNumber = Object.keys(session.presenters).length;
					let presenterBadgeType = 'badge-danger';
	
					if (presentersNumber > 0)
						presentersList += '<strong>Presenters List</strong><br><br>';
	
					$.each(session.presenters, function(key, presenter)
					{
						presentersList += presenter.name+' '+presenter.surname+' <br>('+presenter.email+')<br><br>';
					});
	
					if (presentersNumber > 0)
						presenterBadgeType = 'badge-success';
	
					let presentersBadge = '<badge class="badge badge-pill '+presenterBadgeType+'" data-html="true" data-toggle="tooltip" title="'+presentersList+'">P ('+presentersNumber+')</badge>';
	
					$('#sessionsTableBody').append(
						'<tr>' +
						'	<td>' +
						'		'+session.id+
						'	</td>' +
						'	<td>' +
						'		'+moment.tz(session.start_date_time, "<?=$this->project->timezone?>").format("MMMM Do (dddd)")+
						'	</td>' +
						'	<td>' +
						'		'+moment.tz(session.start_date_time, "<?=$this->project->timezone?>").format("h:mmA")+
						'	</td>' +
						'	<td>' +
						'		'+moment.tz(session.end_date_time, "<?=$this->project->timezone?>").format("h:mmA")+
						'	</td>' +
						'	<td>' +
						'		'+session.name+
						'	</td>' +
						'	<td>' +
						'		'+moderatorsBadge+' '+keynoteSpeakersBadge+' '+presentersBadge+' '+invisibleModeratorsBadge+
						'	</td>' +
						'	<td>' +
						'		'+session.credits+
						'	</td>' +
						'	<td>' +
						'		'+session.notes+
						'	</td>' +
						'	<td>' +
						'		<a href="'+project_admin_url+'/sessions/view/'+session.id+'">' +
						'			<button class="btn btn-sm btn-info m-1"><i class="fas fa-tv"></i> View</button>' +
						'		</a>' +
						'		<a target="_blank" href="'+project_admin_url+'/sessions/polls/'+session.id+'">' +
						'			<button class="btn btn-sm btn-success m-1">Polls <i class="fas fa-external-link-alt"></i></button>' +
						'		</a>' +
						'		<button class="reload_attendee btn btn-sm btn-danger m-1" session-id="'+session.id+'"><i class="fas fa-sync"></i> Reload Atendee</button>' +
						'		<button class="mobileSessionQR btn btn-sm btn-primary m-1" session-id="'+session.id+'" room_id="'+session.room_id+'"><i class="fas fa-qrcode"></i> Generate QRcode</button>' +
						'		<button class="session_resources btn btn-sm btn-primary m-1" session-id="'+session.id+'"><i></i> Resources</button>' +
						'	</td>' +
						'	<td>' +
						'		<button class="manageSession btn btn-sm btn-primary m-1" session-id="'+session.id+'"><i class="fas fa-edit"></i> Edit</button>' +
						'		<button class="removeSession btn btn-sm btn-danger m-1" session-id="'+session.id+'" session-name="'+session.name+'"><i class="fas fa-trash-alt"></i> Remove</button>' +
						'		<!--<button class="openPoll btn btn-sm btn-primary">Open Poll</button>-->' +
						'		<!--<button class="closePoll btn btn-sm btn-primary">Close Poll</button>-->' +
						'		<!--<button class="openResult btn btn-sm btn-primary">Open Result</button>-->' +
						'		<!--<button class="closeResult btn btn-sm btn-primary">Close Result</button>-->' +
						'	</td>' +
						'<td>' +
						'		<a href="'+project_admin_url+'/sessions/flash_report/'+session.id+'" style="width:80px; height:50px" class="flashReport btn btn-sm btn-info m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Flash Report</a><br>' +
						'		<a href="'+project_admin_url+'/sessions/polling_report/'+session.id+'" style="width:80px; height:50px" class="pollingReport btn btn-sm btn-success m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Polling Report</a><br>' +
						'		<a  href="" style="width:80px; height:50px" class="askARepBtn btn btn-sm btn-warning m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Ask a Rep - Report</a><br>' +
						'		<a href="'+project_admin_url+'/sessions/attendee_question_report/'+session.id+'" style="width:80px; height:50px" class="Question btn btn-sm btn-primary m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Question Report</a><br>' +
						'</td>'+
						'<td>'+
						'		<a  style="width:80px; height:50px" class="sendJsonBtn btn btn-sm btn-primary m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Send JSON </a><br>' +
						'		<a href="'+project_admin_url+'/sessions/view_json/'+session.id+'" target="_blank" style="width:80px; height:50px" class="Question btn btn-sm btn-secondary m-1" session-id="'+session.id+'" session-name="'+session.name+'"> View JSON </a><br>' +
						'		<a href="" style="width:80px; height:50px" class="clearJsonBtn btn btn-sm btn-info m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Clear JSON </a><br>' +
						'		<a href="" style="width:80px; height:50px" class="Question btn btn-sm btn-danger m-1" session-id="'+session.id+'" session-name="'+session.name+'"> Delete Session </a><br>' +
	
						'</td>'+
						'</tr>'
					);
				});
	
				$('[data-toggle="tooltip"]').tooltip();
	
				$('#sessionsTable').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"responsive": false,
					"order": [[ 0, "desc" ]],
					"destroy": true
				});
	
				Swal.close();
			});
		});
	}

	$(function(){

		$('#sessionsTableBody').on('click', '.clearJsonBtn', function(e){
			e.preventDefault();
			let session_id = $(this).attr('session-id')

			const translationData = fetchAllText(); // Fetch the translation data

			translationData.then((arrData) => {
				const selectedLanguage = $('#languageSelect').val(); // Get the selected language

				// Find the translations for the dialog text
				let dialogTitle = 'Are you sure?';
				let dialogText = "You won't be able to revert this!";
				let confirmButtonText = 'Yes, clear it!';
				let cancelButtonText = 'Cancel';

				// Toast
				let successText = "Success";
				let successMsg = "Json Cleared";

				for (let i = 0; i < arrData.length; i++) {
					if (arrData[i].english_text === dialogTitle) {
						dialogTitle = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === dialogText) {
						dialogText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === confirmButtonText) {
						confirmButtonText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === cancelButtonText) {
						cancelButtonText = arrData[i][selectedLanguage + '_text'];
					}

					if (arrData[i].english_text === successText) {
						successText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === successMsg) {
						successMsg = arrData[i][selectedLanguage + '_text'];
					}
				}

				Swal.fire({
					title: dialogTitle,
					text: dialogText,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText
				}).then((result) => {
					if (result.isConfirmed) {
						$.post(project_admin_url+'/sessions/clearJson/'+session_id,{},
							function(response){
								console.log(response);
								if(response.status == 'success'){
									Swal.fire(
										successText,
										successMsg,
										'success'
									)
								}
							},'json')
					}
				})
				
			});
		});

		$('#sessionsTableBody').on('click', '.reload_attendee', function(){


			const translationData = fetchAllText(); // Fetch the translation data

			translationData.then((arrData) => {
				const selectedLanguage = $('#languageSelect').val(); // Get the selected language

				// Find the translations for the dialog text
				let dialogTitle = 'Are you sure?';
				let dialogText = "";
				let confirmButtonText = 'Yes, reload it!';
				let cancelButtonText = 'Cancel';

				// Toast
				let successText = "Success";
				let successMsg = "Attendee Reloaded";

				for (let i = 0; i < arrData.length; i++) {
					if (arrData[i].english_text === dialogTitle) {
						dialogTitle = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === dialogText) {
						dialogText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === confirmButtonText) {
						confirmButtonText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === cancelButtonText) {
						cancelButtonText = arrData[i][selectedLanguage + '_text'];
					}

					if (arrData[i].english_text === successText) {
						successText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === successMsg) {
						successMsg = arrData[i][selectedLanguage + '_text'];
					}
				}

				Swal.fire({
					title: dialogTitle,
					text: dialogText,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire(
							successText,
							successMsg,
							'success'
						)
						socket.emit('reload-attendee',{'session_id':$(this).attr('session-id')});
					}
				})
			});

		})

		$('#sessionsTableBody').on('click', '.session_resources', function(){
			let session_id = $(this).attr('session-id')
			$('#addResourceModal').modal('show')
			$('#save-resource').attr('session-id', session_id);

			getSessionResources(session_id);
		});

		$('#sessionsTableBody').on('click', '.mobileSessionQR', function(e){
			e.preventDefault();
			let session_id = $(this).attr('session-id');
			let room_id = $(this).attr('room_id');
			
			console.log(room_id);
			$.post('<?= $this->project_url?>/admin/sessions/generateQRCode/'+session_id+'/'+room_id,
				{}, function(success){
					if(success=="success"){
						Swal.fire({
							text:'<?=$this->project_url?>/mobile/sessions/room/'+room_id,
							imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/qrcode/qr_'+session_id+'.png',
							imageHeight: 300,
							imageAlt: 'QRCODE'
						})

					}
					
					else console.log("Failed");
				})
		})
	})
	
	$('#sessionsTableBody').on('click', '.sendJsonBtn', function() {

		const translationData = fetchAllText(); // Fetch the translation data

		translationData.then((arrData) => {
			const selectedLanguage = $('#languageSelect').val(); // Get the selected language

			// Find the translations for the dialog text
			let dialogTitle = 'Are you sure?';
			let confirmButtonText = 'Yes, send it!';
			let cancelButtonText = 'Cancel';

			// Swal 2
			let successText = "Success";
			let infoText = "Info";

			for (let i = 0; i < arrData.length; i++) {
				if (arrData[i].english_text === dialogTitle) {
					dialogTitle = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === confirmButtonText) {
					confirmButtonText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === cancelButtonText) {
					cancelButtonText = arrData[i][selectedLanguage + '_text'];
				}

				if (arrData[i].english_text === successText) {
					successText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === infoText) {
					infoText = arrData[i][selectedLanguage + '_text'];
				}
			}

			Swal.fire({
				title: dialogTitle,
				text: "",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: confirmButtonText,
				cancelButtonText: cancelButtonText
			}).then((result) => {
				if (result.isConfirmed) {
					let session_id = $(this).attr('session-id');
					$.post({
						url: project_admin_url + '/sessions/send_json/' + session_id,
						data: '',
						beforeSend: function() {
							getTranslatedSelectAccess("Sending Json...").then((msg) => {
								Swal.fire({
									title: 'msg',
										showCancelButton: false,
										showConfirmButton: false,
									onBeforeOpen: () => {
										Swal.showLoading()
									}
								})
							});
						}
					}).done(function(result) {
	
						result = JSON.parse(result)
						console.log(result)
						if (result.status == "ok") {
							Swal.fire({
								text: result.status,
								icon: 'success',
								title: successText
							})
						} else {
							Swal.fire({
								text: result.message,
								icon: 'info',
								title: infoText
							})
						}
					});
				}
			})
			
		});
	})

	function getColorPreset(){
		$.post('<?= $this->project_url?>/admin/settings/getColorPresets/',
			{}, function(data){

			data = JSON.parse(data);
				$('#sessionColorPreset').html(
					'<option value="0">Select Color Preset for this Session</option>'
				);
				$.each(data.data, function(i, val){
					console.log(val);
					$('#sessionColorPreset').append(
						'<option value="'+val.id+'">Preset ('+val.id+') : '+val.name+'</option>'
					)
				})
			})
	}
</script>
