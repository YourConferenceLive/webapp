<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Add Eposter Modal-->
<style>
.note-editable{background-color: white;color: black;}
.select2-container--default .select2-selection--multiple{background-color: #343a40 !important;}
.select2-container--default .select2-selection--multiple .select2-selection__choice{background-color: #006cac !important;}
</style>

<div class="modal fade" id="addePosterModal" tabindex="-1" role="dialog" aria-labelledby="addePosterModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addePosterModalLabel"><i class="fas fa-calendar-plus"></i> Add New Eposter</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addePosterForm">
					<div class="card card-primary card-outline card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="eposterTabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="generalTab" data-toggle="pill" href="#generalTabContents" role="tab" aria-controls="generalTabContents" aria-selected="true"><i class="fas fa-clipboard-list"></i> General</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="mediaTab" data-toggle="pill" href="#mediaTabContents" role="tab" aria-controls="mediaTabContents" aria-selected="false"><i class="fas fa-image"></i> Media</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="streamTab" data-toggle="pill" href="#streamTabContents" role="tab" aria-controls="streamTabContents" aria-selected="false"><i class="fas fa-video"></i> Stream</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="presentersTab" data-toggle="pill" href="#authorsTabContents" role="tab" aria-controls="authorsTabContents" aria-selected="false"><i class="fas fa-user-friends"></i> Authors</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="eposterTabsContent">

								<div class="tab-pane fade active show" id="generalTabContents" role="tabpanel" aria-labelledby="generalTab">

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="eposterPrize">Prize</label>
												<select id="eposterPrize" name="eposterPrize" class="form-control">
													<option value="">N/A</option>
<?php
										if (isset($prizes)):
											foreach ($prizes as $prize):?>
													<option value="<?=$prize?>"><?=ucwords($prize);?></option>
<?php
											endforeach;
										endif;?>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Type</label>
												<select id="eposterType" name="eposterType" class="form-control">
<?php
										if (isset($types)):
											foreach ($types as $type):?>
													<option value="<?=$type?>"><?=(($type == 'eposter') ? 'ePoster' : 'Surgical Video' );?></option>
<?php
											endforeach;
										endif;?>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Track</label>
												<select id="eposterTrack" name="eposterTrack" class="form-control">
<?php
										if (isset($tracks)):
											foreach ($tracks as $track):?>
													<option value="<?=$track->id?>"><?=$track->track?></option>
<?php
											endforeach;
										endif;?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="eposterName">Name</label>
										<input type="text" class="form-control" id="eposterName" name="eposterName" placeholder="Enter ePoster title / name">
									</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="eposterCredits">Credits</label>
												<input type="number" class="form-control" id="eposterCredits" name="eposterCredits" placeholder="How much credit user will receive by attending this eposter? (default:0 | min:0 | max:20)" min="0" max="20" >
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="eposterControlNumber">Control Number</label>
												<input type="number" class="form-control" id="eposterControlNumber" name="eposterControlNumber" placeholder="What is the control number of this eposter?">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Status</label>
												<select id="eposterStatus" name="eposterStatus" class="form-control">
													<option value="1">Active</option>
													<option value="0">Inactive</option>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="mediaTabContents" role="tabpanel" aria-labelledby="mediaTab">

									<div class="form-group">
										<label for="customFile">ePoster</label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="eposterPhoto" name="eposterPhoto">
											<label class="custom-file-label" for="customFile">Choose file</label>
										</div>
									</div>
									<div class="form-group" id="currentPhotoDiv" style="display: none;">
										<label for="customFile"><small>Current photo</small></label>
										<br>
										<img id="currentPhotoImg" src="" width="200px">
									</div>
								</div>

								<div class="tab-pane fade" id="streamTabContents" role="tabpanel" aria-labelledby="streamTab">
									<div class="form-group">
										<label for="videoLink">Video Link (Vimeo only)</label>
										<input type="text" class="form-control" id="videoLink" name="videoLink" placeholder="Enter Video URL (for example https://vimeo.com/12345789)">
									</div>
								</div>

								<div class="tab-pane fade" id="authorsTabContents" role="tabpanel" aria-labelledby="presentersTab">
									<div class="form-group">
										<label>Select authors from the box on the left</label><br>
										<select box-id="eposterAuthors" multiple="multiple" size="10" name="eposterAuthors[]" title="eposterAuthors[]">
<?php
										if (isset($authors)):
											foreach ($authors as $author):?>
											<option value="<?=$author->id?>"><?=$author->name?> <?=$author->surname?> (<?=$author->email?>)</option>
<?php
											endforeach;
										endif;?>
										</select>
									</div>
								</div>
							</div>
						<!-- /.card -->
					</div>

					<input type="hidden" id="eposterId" name="eposterId" value="0">
					<input type="hidden" id="eposterOldPoster" name="eposterOldPoster" value="0">
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="save-eposter" type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(function () {
		$('#streamTab').parent().hide();

		$('#eposterType').on('change', function() {
			if($('option:selected', this).val() == 'surgical_video')
				$('#streamTab').parent().show();
			else
				$('#streamTab').parent().hide();
		});

		$('#authorBadge').css('background-color', access_color_codes['presenter']);
		$('#authorBadge').html('<i class="'+access_icons['presenter']+'"></i> Author');

		$('select[name="eposterAuthors[]"]').bootstrapDualListbox({
			selectorMinimalHeight : 300
		});
	});

	$('#save-eposter').on('click', function () {
		if(!$('input[name="eposterName"]').val())
		{
			toastr.warning('ePoster name cannot be empty!')
			return false;
		}

		if(!$.isNumeric($('input[name="eposterCredits"]').val()))
		{
			toastr.warning('Credit must be a positive number!')
			return false;
		}

		if($('select[name="eposterType"]').find(":selected").val() != 'eposter' && !$('input[name="videoLink"]').val())
		{
			toastr.warning('Surgical Video cannot be empty!')
			return false;
		}

		let eposterName = ($('#eposterName').val() =='')?'[Empty ePoster Name]':$('#eposterName').val();

		Swal.fire({
			title: 'Are you sure?',
			html: '<span style="color: white;">'+eposterName+'</span>',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, save it!',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.isConfirmed) {
				if ($('#eposterId').val() == 0)
					addEposter();
				else
					updateEposter();
			}
		})
	});

	function addEposter()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Adding the eposter...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addePosterForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/eposters/add",
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
					listePosters();
					console.log('eposter list executed');
					toastr.success('ePoster added');
					$('#addePosterModal').modal('hide');

				}else{
					toastr.error("Error");
				}
			}
		});
	}

	function updateEposter()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Updating the eposter...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addePosterForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/eposters/update",
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
					$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/'+data.eposter.eposter);
					$('#currentPhotoDiv').show();

					listePosters();
					toastr.success('ePoster updated');
				}else if(data.status == 'warning') {
					toastr.warning(data.msg);
				}else{
					toastr.error("Error");
				}
			}
		});
	}
</script>
