<?php
//echo "<pre>";
//print_r($types);
//exit("</pre>");
?>
<!--Add Session Modal-->
<style>
.note-editable{background-color: white;color: black;}
.select2-container--default .select2-selection--multiple{background-color: #343a40 !important;}
.select2-container--default .select2-selection--multiple .select2-selection__choice{background-color: #006cac !important;}
</style>

<div class="modal fade" id="addSessionModal" tabindex="-1" role="dialog" aria-labelledby="addSessionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addSessionModalLabel"><i class="fas fa-calendar-plus"></i> Add New Session</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addSessionForm">

					<div class="card card-primary card-outline card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="sessionTabs" role="tablist">

								<li class="nav-item">
									<a class="nav-link active" id="generalTab" data-toggle="pill" href="#generalTabContents" role="tab" aria-controls="generalTabContents" aria-selected="true"><i class="fas fa-clipboard-list"></i> General</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="mediaTab" data-toggle="pill" href="#mediaTabContents" role="tab" aria-controls="mediaTabContents" aria-selected="false"><i class="fas fa-image"></i> Media</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="agendaTab" data-toggle="pill" href="#agendaTabContents" role="tab" aria-controls="agendaTabContents" aria-selected="false"><i class="fas fa-clipboard-check"></i> Agenda</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="videoTab" data-toggle="pill" href="#videoTabContents" role="tab" aria-controls="videoTabContents" aria-selected="false"><i class="fab fa-vimeo"></i> Video</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="streamTab" data-toggle="pill" href="#streamTabContents" role="tab" aria-controls="streamTabContents" aria-selected="false"><i class="fas fa-video"></i> Stream</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="moderatorsTab" data-toggle="pill" href="#moderatorsTabContents" role="tab" aria-controls="moderatorsTabContents" aria-selected="false"><i class="fas fa-user-tie"></i> Moderators</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="keynoteSpeakersTab" data-toggle="pill" href="#keynoteSpeakersTabContents" role="tab" aria-controls="keynoteSpeakersTabContents" aria-selected="false"><i class="fas fa-user-check"></i> Keynote Speakers</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="presentersTab" data-toggle="pill" href="#presentersTabContents" role="tab" aria-controls="presentersTabContents" aria-selected="false"><i class="fas fa-user-friends"></i> Presenters</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="invisibleModeratorsTab" data-toggle="pill" href="#invisibleModeratorsTabContents" role="tab" aria-controls="invisibleModeratorsTabContents" aria-selected="false"><i class="fas fa-user-secret"></i> Invisible Moderators</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="sessionSettingsTab" data-toggle="pill" href="#sessionSettingsTabContents" role="tab" aria-controls="sessionSettingsTabContents" aria-selected="false"><i class="fas fa-cog"></i> Settings</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="sessionTabsContent">

								<div class="tab-pane fade active show" id="generalTabContents" role="tabpanel" aria-labelledby="generalTab">

									<div class="form-group">
										<label for="sessionName">Name</label>
										<input type="text" class="form-control" id="sessionName" name="sessionName" placeholder="Enter session title/name">
									</div>

									<div class="form-group">
										<label for="sessionNameOther">Other name (alternative language)</label>
										<input type="text" class="form-control" id="sessionNameOther" name="sessionNameOther" placeholder="Enter alternative session title/name eg; French">
									</div>

									<div class="form-group">
										<label>Type</label>
										<select id="sessionType" name="sessionType" class="form-control">
											<?php if (isset($types)): ?>
												<?php foreach ($types as $type): ?>
													<option value="<?=$type->type_code?>" is-external="<?=$type->is_external?>"><?=$type->type_name?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
									<div class="form-group" id="sessionExternalUrlDiv" style="display: none;">
										<label for="sessionExternalUrl">External Meeting URL (eg; Zoom Link)</label>
										<input type="text" class="form-control" id="sessionExternalUrl" name="sessionExternalUrl" placeholder="This link will open in a new tab (unless user blocked pop opening windows) once the meeting starts (always prefix the URL with protocol ie; http/https)">
									</div>

									<div class="form-group">
										<label>Track or <a href="<?=base_url()?>"><u> Add Track </u></a></label>
										<select id="sessionTrack" name="sessionTrack" class="form-control">
											<option value="">Select Track</option>
											<?php if (isset($tracks)): ?>
												<?php foreach ($tracks as $track): ?>
													<option value="<?=$track->id?>"><?=$track->name?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>

									<div class="form-group">
										<label for="sessionCredits">Credits</label>
										<input type="number" class="form-control" id="sessionCredits" name="sessionCredits" placeholder="How much credit user will receive by attending this session? (default:0 | min:0 | max:20)" min="0" max="20" >
									</div>

									<div class="form-group">
										<label for="sessionDescription">Description</label>
										<textarea id="sessionDescription" name="sessionDescription" class="form-control" placeholder="Enter session description"></textarea>
									</div>

									<div class="form-group">
										<label>Start date and time</label>
										<div class="input-group date" id="startDateTime" data-target-input="nearest">
											<input type="text" id="startDateTimeInput" name="startDateTime" class="form-control datetimepicker-input" data-target="#startDateTime">
											<div class="input-group-append" data-target="#startDateTime" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>End date and time</label>
										<div class="input-group date" id="endDateTime" data-target-input="nearest">
											<input type="text" id="endDateTimeInput" name="endDateTime" class="form-control datetimepicker-input" data-target="#endDateTime">
											<div class="input-group-append" data-target="#endDateTime" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>

								</div>

								<div class="tab-pane fade" id="mediaTabContents" role="tabpanel" aria-labelledby="mediaTab">

									<div class="form-group">
										<label for="customFile">Session photo</label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="sessionPhoto" name="sessionPhoto">
											<label class="custom-file-label" for="customFile">Choose file</label>
										</div>
									</div>
									<div class="form-group" id="currentPhotoDiv" style="display: none;">
										<label for="customFile"><small>Current photo</small></label>
										<br>
										<img id="currentPhotoImg" src="" width="200px">
									</div>

								</div>

								<div class="tab-pane fade" id="agendaTabContents" role="tabpanel" aria-labelledby="agendaTab">
									<div class="form-group">
										<label for="sessionAgenda">Agenda</label>
										<textarea id="sessionAgenda" name="sessionAgenda" class="form-control" placeholder="Enter session agenda"></textarea>
									</div>
								</div>

								<div class="tab-pane fade" id="videoTabContents" role="tabpanel" aria-labelledby="videoTab">
									<div class="form-group">
										<label for="sessionVideo">Video</label>
										<input type="text" class="form-control" id="sessionVideo" name="sessionVideo" placeholder="Eg; https://vimeo.com/123456789">
									</div>
								</div>

								<div class="tab-pane fade" id="streamTabContents" role="tabpanel" aria-labelledby="streamTab">

									<div class="form-group">
										<label for="millicastStream">Millicast stream name</label>
										<input type="text" class="form-control" id="millicastStream" name="millicastStream" placeholder="Eg; kpih785i">
									</div>

									<div class="form-group">
										<label for="slidesHtml">Presenter slides embed HTML</label>
										<textarea id="slidesHtml" name="slidesHtml" class="form-control" rows="5" placeholder="Copy paste presenter slides iframe html"></textarea>
									</div>

									<div class="form-group">
										<label for="zoomLink">Presenter Zoom Link</label>
										<input type="text" class="form-control" id="zoomLink" name="zoomLink" placeholder="Enter Zoom URL with password if any">
									</div>

								</div>

								<div class="tab-pane fade" id="moderatorsTabContents" role="tabpanel" aria-labelledby="moderatorsTab">
									<div class="form-group">
										<label>Select moderators from the box on the left</label><br>
										<label><small>(You must add moderators with <badge id="moderatorBadge" class="badge badge-primary mr-1" style="background-color:#228893;"><i class="fas fa-id-card"></i> Moderator</badge> privilege in <a class="btn btn-xs btn-secondary ml-1 mr-1" href="<?=$this->project_url?>/admin/users"><i class="fas fa-users"></i> Users</a> list in order to list them here)</small></label>
										<select box-id="sessionModerators" multiple="multiple" size="10" name="sessionModerators[]" title="sessionModerators[]">
											<?php if (isset($moderators)): ?>
												<?php foreach ($moderators as $moderator): ?>
													<option value="<?=$moderator->id?>"><?=$moderator->name?> <?=$moderator->surname?> (<?=$moderator->email?>)</option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>

								<div class="tab-pane fade" id="keynoteSpeakersTabContents" role="tabpanel" aria-labelledby="keynoteSpeakersTab">
									<div class="form-group">
										<label>Select keynote speakers from the box on the left</label><br>
										<label><small>(You must add keynote speakers with <badge id="presenterBadge" class="badge badge-primary mr-1" style="background-color:#228893;"><i class="fas fa-id-card"></i> Presenter</badge> privilege in <a class="btn btn-xs btn-secondary ml-1 mr-1" href="<?=$this->project_url?>/admin/users"><i class="fas fa-users"></i> Users</a> list in order to list them here)</small></label>
										<select box-id="sessionKeynoteSpeakers" multiple="multiple" size="10" name="sessionKeynoteSpeakers[]" title="sessionKeynoteSpeakers[]">
											<?php if (isset($presenters)): ?>
												<?php foreach ($presenters as $presenter): ?>
													<option value="<?=$presenter->id?>"><?=$presenter->name?> <?=$presenter->surname?> (<?=$presenter->email?>)</option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>

								<div class="tab-pane fade" id="presentersTabContents" role="tabpanel" aria-labelledby="presentersTab">
									<div class="form-group">
										<label>Select presenters from the box on the left</label><br>
										<label><small>(You must add presenters with <badge id="presenterBadge" class="badge badge-primary mr-1" style="background-color:#228893;"><i class="fas fa-id-card"></i> Presenter</badge> privilege in <a class="btn btn-xs btn-secondary ml-1 mr-1" href="<?=$this->project_url?>/admin/users"><i class="fas fa-users"></i> Users</a> list in order to list them here)</small></label>
										<select box-id="sessionPresenters" multiple="multiple" size="10" name="sessionPresenters[]" title="sessionPresenters[]">
											<?php if (isset($presenters)): ?>
												<?php foreach ($presenters as $presenter): ?>
													<option value="<?=$presenter->id?>"><?=$presenter->name?> <?=$presenter->surname?> (<?=$presenter->email?>)</option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>

								<div class="tab-pane fade" id="invisibleModeratorsTabContents" role="tabpanel" aria-labelledby="invisibleModeratorsTab">
									<div class="form-group">
										<label>Select invisible moderators from the box on the left</label><br>
										<label><small>(You must add moderators with <badge id="moderatorBadge" class="badge badge-primary mr-1" style="background-color:#228893;"><i class="fas fa-id-card"></i> Moderator</badge> privilege in <a class="btn btn-xs btn-secondary ml-1 mr-1" href="<?=$this->project_url?>/admin/users"><i class="fas fa-users"></i> Users</a> list in order to list them here)</small></label>
										<select box-id="sessionInvisibleModerators" multiple="multiple" size="10" name="sessionInvisibleModerators[]" title="sessionInvisibleModerators[]">
											<?php if (isset($moderators)): ?>
												<?php foreach ($moderators as $moderator): ?>
													<option value="<?=$moderator->id?>"><?=$moderator->name?> <?=$moderator->surname?> (<?=$moderator->email?>)</option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>

								<div class="tab-pane fade" id="sessionSettingsTabContents" role="tabpanel" aria-labelledby="sessionSettingsTab">
									<div class="form-group">
										<label>Header Settings</label><br>
										<div class="custom-control custom-switch">
											<input name="header_toolbox" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->header_toolbox_status == 1)?'checked':''?> id="headerToolboxSwitch">
											<label class="custom-control-label" for="headerToolboxSwitch">Header Toolbox</label>
										</div>
									</div>

									<div class="form-group">
										<label>Right Sticky Toolbox</label><br>
										<div class="custom-control custom-switch">
											<input name="right_sticky_notes" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->right_sticky_notes == 1)?'checked':''?> id="rightNotesSwitch">
											<label class="custom-control-label" for="rightNotesSwitch">Notes</label>
										</div>

										<div class="custom-control custom-switch">
											<input name="right_sticky_resources" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->right_sticky_resources == 1)?'checked':''?> id="rightResourcesSwitch">
											<label class="custom-control-label" for="rightResourcesSwitch">Resources</label>
										</div>

										<div class="custom-control custom-switch">
											<input name="right_sticky_question" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->right_sticky_question == 1)?'checked':''?> id="rightQuestionSwitch">
											<label class="custom-control-label" for="rightQuestionSwitch">Question</label>
										</div>
									</div>

								</div>

							</div>
						<!-- /.card -->
					</div>

					<input type="hidden" id="sessionId" name="sessionId" value="0">
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="save-session" type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
			</div>
		</div>
	</div>
</div>

<!-- PDF selection Modal -->
<div class="modal fade" id="SN_PdfSelectionModal" tabindex="-1" role="dialog" aria-labelledby="SN_PdfSelectionModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="SN_PdfSelectionModalLabel">Choose PDF File</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="sn_pdf_input" accept="application/pdf">
						<label class="custom-file-label" for="sn_pdf_input">Choose file</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>

	$(function () {

		$('#presenterBadge').css('background-color', access_color_codes['presenter']);
		$('#presenterBadge').html('<i class="'+access_icons['presenter']+'"></i> Presenter');

		$('#moderatorBadge').css('background-color', access_color_codes['moderator']);
		$('#moderatorBadge').html('<i class="'+access_icons['moderator']+'"></i> Moderator');


		if($('option:selected', this).attr('is-external') == 1)
			$('#sessionExternalUrlDiv').show();
		else
			$('#sessionExternalUrlDiv').hide();
		$('#sessionType').on('change', function() {
			if($('option:selected', this).attr('is-external') == 1)
				$('#sessionExternalUrlDiv').show();
			else
				$('#sessionExternalUrlDiv').hide();
		});

		$('#sessionDescription')
				.summernote
				({
					dialogsInBody: true,
					placeholder: $('#sessionDescription').attr('placeholder'),
					height: 200,
					toolbar:
							[
								["history", ["undo", "redo"]],
								["style", ["style"]],
								["font", ["bold", "italic", "underline", "fontname", "strikethrough", "superscript", "subscript", "clear"]],
								['fontsize', ['fontsize']],
								["color", ["color"]],
								["paragraph", ["ul", "ol", "paragraph", "height"]],
								["table", ["table"]],
								["insert", ["link", "resizedDataImage", "picture", "video"]],
								["view", ["codeview"] ]
							],
					fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '36', '48' , '64', '82', '150']
				});


		let pdfButton = function (context) {
			let ui = $.summernote.ui;

			// create button
			let button = ui.button({
				contents: '<i class="fas fa-file-pdf"></i>',
				tooltip: 'PDF',
				click: function () {

					$('#SN_PdfSelectionModal').modal('show');

					$("#sn_pdf_input").change(function (){
						//Read File
						var selectedFile = document.getElementById("sn_pdf_input").files;
						//Check File is not Empty
						if (selectedFile.length > 0) {
							// Select the very first file from list
							var fileToLoad = selectedFile[0];
							// FileReader function for read the file.
							var fileReader = new FileReader();
							var base64;
							// Onload of file read the file content
							fileReader.onload = function (fileLoadedEvent) {
								base64 = fileLoadedEvent.target.result;
								// Print data in console
								//console.log(base64);

								let pdfObjectTag = '' +
										'<object data="'+base64+'" type="application/pdf" width="100%" height="100%">' +
											'<strong>PDF file is not supported by your browser or PDF file is invalid</strong>' +
										'</object>';

								context.invoke('code', pdfObjectTag);
								$('#SN_PdfSelectionModal').modal('hide');

							};
							fileReader.readAsDataURL(fileToLoad);
						}else{
							console.log('No file found!');
						}
					});

				}
			});

			return button.render();   // return button as jquery object
		}
		$('#sessionAgenda')
				.summernote
				({
					dialogsInBody: true,
					placeholder: $('#sessionAgenda').attr('placeholder'),
					height: 400,
					toolbar:
							[
								["history", ["undo", "redo"]],
								["style", ["style"]],
								["font", ["bold", "italic", "underline", "fontname", "strikethrough", "superscript", "subscript", "clear"]],
								['fontsize', ['fontsize']],
								["color", ["color"]],
								["paragraph", ["ul", "ol", "paragraph", "height"]],
								["table", ["table"]],
								["insert", ["link", "resizedDataImage", "picture", "video", "pdf"]],
								["view", ["codeview"] ]
							],
					buttons: {
						pdf: pdfButton
					},
					fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '36', '48' , '64', '82', '150'],
				});

		$('#startDateTime, #endDateTime').datetimepicker(
				{
					icons: { time: 'far fa-clock' },
					//format: 'MMMM Mo (dddd) - h:mmA'
				}
		);

		$('select[name="sessionModerators[]"]').bootstrapDualListbox({
			selectorMinimalHeight : 300
		});

		$('select[name="sessionKeynoteSpeakers[]"]').bootstrapDualListbox({
			selectorMinimalHeight : 300
		});

		$('select[name="sessionPresenters[]"]').bootstrapDualListbox({
			selectorMinimalHeight : 300
		});

		$('select[name="sessionInvisibleModerators[]"]').bootstrapDualListbox({
			selectorMinimalHeight : 300
		});
	});

	$('#logo, #banner').on('change',function(){
		let item = $(this);
		let fileName = $(this).val();
		let reader = new FileReader();

		reader.onload = function (e) { item.parent().parent().next('.image-preview').attr('src', e.target.result); }
		reader.readAsDataURL(this.files[0]);
		item.parent().parent().next('.image-preview').show();
		fileName = fileName.replace("C:\\fakepath\\", "");
		$(this).next('.custom-file-label').html(fileName);
	});

	$('#save-session').on('click', function () {

		if($('input[name="startDateTime"]').val() == '')
		{
			toastr.warning('Please select start date and time!')
			return false;
		}

		if($('input[name="endDateTime"]').val() == '')
		{
			toastr.warning('Please select end date and time!')
			return false;
		}

		if(!$.isNumeric($('input[name="sessionCredits"]').val()))
		{
			toastr.warning('Credit must be a positive number!')
			return false;
		}

		let sessionName = ($('#sessionName').val() =='')?'[Empty Session Name]':$('#sessionName').val();
		Swal.fire({
			title: 'Are you sure?',
			html: '<span style="color: white;">'+sessionName+
					'<br><br> <small>starts on</small> '+$('#startDateTimeInput').val()+
					'<br> <small>and ends on</small> '+$('#endDateTimeInput').val()+' ? </span>',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, save it!',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.isConfirmed) {
				if ($('#sessionId').val() == 0)
					addSession();
				else
					updateSession();
			}
		})
	});



	function addSession()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Adding the session...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addSessionForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sessions/add",
			data: formData,
			processData: false,
			contentType: false,
			error: function(jqXHR, textStatus, errorMessage)
			{
				Swal.close();
				toastr.error(errorMessage);
				//console.log(errorMessage); // Optional
			},
			success: function(data)
			{
				Swal.close();

				data = JSON.parse(data);

				if (data.status == 'success')
				{
					listSessions();
					toastr.success('Session added');
					$('#addSessionModal').modal('hide');

				}else{
					toastr.error("Error");
				}
			}
		});
	}

	function updateSession()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Updating the session...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addSessionForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sessions/update",
			data: formData,
			processData: false,
			contentType: false,
			error: function(jqXHR, textStatus, errorMessage)
			{
				Swal.close();
				toastr.error(errorMessage);
				//console.log(errorMessage); // Optional
			},
			success: function(data)
			{
				Swal.close();

				data = JSON.parse(data);

				if (data.status == 'success')
				{
					$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/'+data.session.thumbnail);
					$('#currentPhotoDiv').show();

					listSessions();
					toastr.success('Session updated');
				}else if(data.status == 'warning'){
					toastr.warning(data.msg);
				}else{
					toastr.error(data.technical_data);
				}
			}
		});
	}

</script>
