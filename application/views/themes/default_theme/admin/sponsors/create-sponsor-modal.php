<?php
//echo "<pre>";
//print_r($exhibitors); exit;
//echo "</pre>";
//exit;
?>
<!--Create Sponsor Modal-->
<div class="modal fade" id="createSponsorModal" tabindex="-1" role="dialog" aria-labelledby="createSponsorModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createSponsorModalLabel">Create New Sponsor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="createSponsorForm">

					<div class="card card-primary card-outline card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">General</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Admins</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-three-tabContent">

								<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
									<div class="form-group">
										<label>Sponsor name</label>
										<input name="sponsor_name" id="sponsor_name" class="form-control form-control-lg" type="text" placeholder="Sponsor name">
									</div>

									<div class="form-group">
										<label>About us</label>
										<textarea name="about_us" id="about_us" class="form-control" rows="5" placeholder="About the sponsor" ></textarea>
									</div>

									<div class="form-group">
										<label>Logo</label>
										<div class="custom-file">
											<input name="logo" id="logo" type="file" class="custom-file-input">
											<label id="logo_label" class="custom-file-label" for="logo"></label>
										</div>
									</div>
									<img class="image-preview mb-5" id="logo_preview" src="" style="display: none;" width="75px">

									<div class="form-group">
										<label>Banner</label>
										<div class="custom-file">
											<input name="banner" id="banner" type="file" class="custom-file-input">
											<label id="banner_label" class="custom-file-label" for="banner"></label>
										</div>
									</div>
									<img class="image-preview" id="banner_preview" src="" style="display: none;" width="75px">
								</div>

								<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">

									<div class="form-group">
										<label>Select booth admins from the box on the left</label>
										<select multiple="multiple" size="10" name="boothAdmins[]" title="boothAdmins[]">
											<?php foreach ($exhibitors as $exhibitor): ?>
												<option value="<?=$exhibitor->id?>"><?=$exhibitor->name?> <?=$exhibitor->surname?> (<?=$exhibitor->email?>)</option>
											<?php endforeach; ?>
										</select>
									</div>

								</div>
							</div>
						</div>
						<!-- /.card -->
					</div>

					<input type="hidden" id="sponsorId" name="sponsorId" value="0">
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="save-sponsor" type="button" class="btn btn-success"><i class="fas fa-plus"></i> Create</button>
			</div>
		</div>
	</div>
</div>

<script>

	$('select[name="boothAdmins[]"]').bootstrapDualListbox({
		selectorMinimalHeight : 300
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

	$('#save-sponsor').on('click', function () {
		if ($('#sponsorId').val() == 0)
			createSponsor();
		else
			updateSponsor();
	});

	function createSponsor()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Creating the sponsor...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('createSponsorForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sponsors/create",
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
					listSponsors();
					toastr.success('Sponsor created');
					$('#createSponsorModal').modal('hide');

				}else{
					toastr.error("Error");
				}
			}
		});
	}

	function updateSponsor()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Updating the sponsor...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('createSponsorForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sponsors/update",
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
					listSponsors();
					toastr.success('Sponsor updated');

				}else{
					toastr.warning("No changes made");
				}
			}
		});
	}

</script>
