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
		let formData = new FormData(document.getElementById('createSponsorForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sponsors/create",
			data: formData,
			processData: false,
			contentType: false,
			error: function(jqXHR, textStatus, errorMessage)
			{
				toastr.error(errorMessage);
				//console.log(errorMessage); // Optional
			},
			success: function(data)
			{
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
		let formData = new FormData(document.getElementById('createSponsorForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sponsors/update",
			data: formData,
			processData: false,
			contentType: false,
			error: function(jqXHR, textStatus, errorMessage)
			{
				toastr.error(errorMessage);
				//console.log(errorMessage); // Optional
			},
			success: function(data)
			{
				data = JSON.parse(data);

				if (data.status == 'success')
				{
					listSponsors();
					toastr.success('Sponsor updated');
					$('#createSponsorModal').modal('hide');

				}else{
					toastr.error("Error");
				}
			}
		});
	}

</script>
