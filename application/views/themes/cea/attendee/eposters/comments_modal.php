<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<!-- Comments Modal - attendee -->
		<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="commentsModalLabel">Discuss "<?php echo trim($eposter->title);?>"</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="height: 65vh;overflow-y: auto;">
						<div class="row">
							<div class="col-12">
								<!-- comments form -->
								<div class="col-md-12" id="comments-list">
									<div class="header_comment">
										<div class="row">
											<div class="col-md-6 text-left">
							  					<span class="count_comment"><strong></strong> Comments</span>
											</div>
										</div>
									</div>
									<div class="body_comment">
										<div class="row">
											<div class="avatar_comment col-md-1">
												<img class="direct-chat-img" 
													 src="<?=ycl_root;?>/cms_uploads/projects/<?=$this->project->id;?>/user_assets/user_photos/" 
													 onerror="this.onerror=null;this.src='<?=ycl_root;?>/ycl_assets/images/person_dp_placeholder.png'"
													  alt="DP Image">
											</div>
											<div class="box_comment col-md-11">
												<form id="addUserComments">
													<input type="hidden" name="eposterId" id="eposterId" value="<?php echo $eposter->id;?>">
													<textarea class="form-control" name="comments" id="comments" placeholder="Add a comment..."></textarea>
								  					<div class="box_post">
														<div class="pull-right">
										  					<button id="post-comment" class="btn btn-info btn-sm" type="button" value="1">Post</button>
														</div>
								  					</div>
								  				</form>
											</div>
										</div>
										<div class="row" id="comments_list_container"></div>
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
		$('#post-comment').on('click', function () {

			const translationData = fetchAllText(); // Fetch the translation data

			translationData.then((arrData) => {
				const selectedLanguage = $('#languageSelect').val(); // Get the selected language

				// Find the translations for the dialog text
				let dialogTitle = 'Please Wait';
				let dialogText = 'Posting your comments...';
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
			});


			let formData = new FormData(document.getElementById('addUserComments'));

			$.ajax({
				type: "POST",
				url: project_url+"/eposters/post_comments",
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

					if (data.status == 'success') {
						$('#comments_list_container').html('');
						loadComments(formData.get('eposterId'), comment_page);
						getTranslatedSelectAccess('Comment has been added.').then((msg) => {
							toastr.success(msg);
						});
						$('#comments').val('');
					}else{
						getTranslatedSelectAccess('Error').then((msg) => {
							toastr.error(msg);
						});
					}
				}
			});
		});
		</script>
