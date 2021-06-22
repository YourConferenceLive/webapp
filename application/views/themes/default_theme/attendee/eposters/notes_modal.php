<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<!-- Notes Modal - attendee -->
		<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document" style="overflow-y: initial !important">
				<div class="modal-content">
					<div class="modal-header">
						<p class="modal-title text-justify" id="notesModalLabel">Notes</p>
					</div>
					<div class="modal-body" style="height: 65vh;overflow-y: auto;">
						<div class="row">
							<div class="col-12">
								<!-- notes form -->
								<div class="col-md-12" id="notes-list">
									<div class="header_note">
										<div class="row">
											<div class="col-md-6 text-left">
							  					<span class="count_note"><strong></strong> Notes</span>
											</div>
										</div>
									</div>
									<div class="body_note">
										<div class="row">
											<div class="box_note col-md-12">
												<form id="addUserNotes">
													<input type="hidden" name="entity_type_id" id="entity_type_id" value="<?php echo $eposter->id;?>">
													<input type="hidden" name="entity_type" id="entity_type" value="<?php echo (($entitiy_type) ? $entitiy_type : 'session' );?>">
													<textarea class="form-control" name="notes" id="notes" placeholder="Add a note..."></textarea>
								  					<div class="box_post">
														<div class="pull-right">
										  					<button id="add-note" class="btn btn-info btn-sm" type="button" value="1">Note</button>
														</div>
								  					</div>
								  				</form>
											</div>
										</div>
										<div class="row" id="notes_list_container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$('#add-note').on('click', function () {
				Swal.fire({
					title: 'Please Wait',
					text: 'Posting your notes...',
					imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
					imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
					imageAlt: 'Loading...',
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});

				let formData = new FormData(document.getElementById('addUserNotes'));

				$.ajax({
					type: "POST",
					url: project_url+"/eposters/add_notes",
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
						// Swal.close();

						data = JSON.parse(data);

						if (data.status == 'success') {
							$('#notes_list_container').html('');
							$('textarea[name="notes"]').val('');
							loadNotes(formData.get('entity_type'), formData.get('entity_type_id'), note_page);
							toastr.success('Note added.');
							$('#notes').val('');
						}else{
							toastr.error("Error");
						}
					}
				});
			});
		</script>
