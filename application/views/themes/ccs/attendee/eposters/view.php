<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
	<style>
		body{overflow: hidden;}
	</style>

	<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/css/eposters.css?v=<?=rand()?>" rel="stylesheet">

	<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg" style="z-index: -1;">

	<div class="clearfix" style="margin-top: 77px;"></div>

	<div class="eposters-view-container container-fluid pl-md-6 pr-md-6 text-center" id="eposter-container">
<?php
			if (($eposter->type == 'surgical_video' && $eposter->video_url != '') || $eposter->type == 'eposter'): 
				if ($eposter->type == 'surgical_video'):
					$video_url = preg_replace('/[^0-9]/', '', $eposter->video_url)?>
		<iframe id="vimeo_player" src="https://player.vimeo.com/video/<?=$video_url;?>?color=f7dfe9&title=0&byline=0&portrait=0" style="/*position:absolute;top:0;left:0;*/width:100%;height:90%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
		<script src="https://player.vimeo.com/api/player.js"></script>
<?php
			else: ?>
		<img class="eposter-img"
			 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/<?=$eposter->eposter?>"
			 onerror="this
			 .src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/default.jpg'" id="eposter-img">
<?php
				endif;?>
		<br clear="all">
		<div class="row">
    		<div class="col-auto my-1 mx-auto">
<?php
				// echo $eposter->title.'<br>'.$eposter->eposter.'<br>'.$eposter->id.'_'.substr(str_replace(array(' ', ' - ', '-', ':', '.', ',', '(', ')', '\'', 'è'), array('_', ''), strtolower( $eposter->title)), 0, 142).'<br>';
				if ($eposter->type == 'eposter') :?>
				<button type="button" class="btn btn-info btn-sm" id="enlargeable">View Full Screen</button>
<?php
				endif;?>
				<a role="button" class="btn btn-info btn-sm" href="<?=$this->project_url?>/eposters">Return to ePoster Listing</a>
			</div>
		</div>
<?php
			if ($eposter->prize) :?>
		<div class="tool-btns prize hide">
			<a><img data-toggle="tooltip" data-placement="left" title="<?php echo (($eposter->prize != 'hot topic') ? 'Won ' : '' ).ucwords($eposter->prize);?>" class="img-fluid img-prize-detail img-thumbnail"
				  		 src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/eposters/thumb/<?=str_replace(' ', '_', $eposter->prize).'.png';?>"
						 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/default.jpg'"></a>
		</div>
<?php
			endif;?>
		<div class="custom_pagination">
<?php
			if(@$previous->id) {?>
			<a role="button" title="Previous" class="eposter_view-browse" href="<?=$this->project_url?>/eposters/view/<?=$previous->id;?>" rel="prev">
				<i class="fas fa-chevron-left"></i>
			</a>
<?php
				}
				if(@$next->id) {?>
				<a role="button" title="Next" class="eposter_view-browse eposter_view-browse--right" href="<?=$this->project_url?>/eposters/view/<?=$next->id;?>" rel="next">
					<i class="fas fa-chevron-right"></i>
				</a>
<?php
				}?>
			</div>

			<div class="tool-btns btn-cstm-first"><a href="javascript:void(0);" data-action-type="notes" data-entity-type="eposter" data-eposter-id="<?php echo $eposter->id;?>" class="take-notes" title="Take Notes" data-toggle="tooltip" data-placement="left"><i class="fas fa-clipboard fa-fw fa-2x"></i><br>Take Notes</a></div>
			<div class="tool-btns btn-cstm-second"><a href="javascript:void(0);" data-eposter-id="<?php echo $eposter->id;?>" data-credits="<?php echo $eposter->credits;?>" class="claim-credits" title="Claim Credits" data-toggle="tooltip" data-placement="left"><i class="fas fa-certificate fa-fw fa-2x"></i><br>Claim Credits</a></div>
<?php
			$link_order = ' btn-cstm-third';
			foreach ($eposter->author as $row) {
				if ($row->contact) {?>
			<div class="tool-btns<?php echo $link_order;?>"><a href="mailto:<?php echo $row->email;?>" class="email-author" title="Contact <?php echo $row->author.(!empty(trim($row->credentials))?' '.trim($row->credentials):'');?>" data-toggle="tooltip" data-placement="left"><i class="fas fa-envelope fa-fw fa-2x"></i><br>Contact</a></div>
<?php
					$link_order = ' btn-cstm-fourth';
					break;
				}
			}?>
			<div class="tool-btns<?php echo $link_order;?>"><a href="javascript:void(0);" data-action-type="comments" data-entity-type="eposter" data-eposter-id="<?php echo $eposter->id;?>" class="comments" title="Discuss" data-toggle="tooltip" data-placement="left"><i class="fas fa-comment fa-fw fa-2x"></i><br>Discuss</a></div>
<?php
			else: //In case eposter is deactivated or deleted ?>
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3>No ePoster found!</h3>
				</div>
			</div>
<?php
			endif; ?>
		</div>
		<script type="application/javascript">
			let note_page = 1;
			let notes_per_page = "<?=$notes_per_page;?>";

			let comment_page = 1;
			let comments_per_page = "<?=$comments_per_page;?>";

			$(function () {
				iframeResize();
				$(window).on('resize', function(){
					iframeResize();
				});

				$('[data-toggle="tooltip"]').tooltip();

				$('.claim-credits').click(function(e) {
					var eposter_id 	= $(this).data('eposter-id');
					var credits 	= $(this).data('credits');

					if (eposter_id != '' && credits != '') {
						Swal.fire({
							title: 'Please Wait',
							text: 'Checking credits...',
							imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
							imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
							imageAlt: 'Loading...',
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});

						var formData = new FormData();
						formData.append("origin_type_id", eposter_id);
						formData.append("origin_type", 'eposter');
						formData.append("credits", credits);

						$.ajax({type: "POST",
								url: project_url+"/eposters/add_credits",
								data: formData,
								processData: false,
								contentType: false,
								error: function(jqXHR, textStatus, errorMessage)
								{
									Swal.close();
									toastr.error(errorMessage);
								},

								success: function(data)
								{
									Swal.close();

									data = JSON.parse(data);

									if (data.status == 'success') {
										toastr.success('Credits claimed successfully.');
									} else {
										toastr.error("Error");
									}
								}
							});
					}
				});

				$('.comments, .take-notes').click(function(e) {

					var action_type = $(this).data('action-type');
					var entity_type = $(this).data('entity-type');
					var entity_type_id 	= $(this).data('eposter-id');

					if (action_type == 'notes') {
						$('#addUserNotes input[name="entity_type"]').val(entity_type);
						$('#addUserNotes input[name="entity_type_id"]').val(entity_type_id);
						loadNotes(entity_type, entity_type_id, note_page);
						$('#notes_list_container').html('');
						$('#notesModal').modal('show');
					} else {
						loadComments(entity_type_id, comment_page);
						$('#comments_list_container').html('');
						$('#commentsModal').modal('show');
					}
				});
			});

			function loadNotes(entity_type, entity_type_id, note_page) {
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

				$.ajax({
						type: "GET",
						url: project_url+"/eposters/notes/"+entity_type+'/'+entity_type_id+'/'+note_page,
						data: '',
						success: function(response){
							Swal.close();
							jsonObj = JSON.parse(response);
							// Add response in Modal body

							$('#notesModalLabel').html( jsonObj.eposter.title + ' Notes');

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

								$('#notesModal .modal-footer').html('<button' + (((note_page+1) <= Math.ceil(jsonObj.total/notes_per_page)) ? ' class="btn btn-info btn-sm btn-block" onclick="showMoreNotes(\''+entity_type+'\', '+entity_type_id+', '+note_page+');"' : ' class="btn btn-info btn-block btn-sm disabled not-allowed" disabled' ) + ' type="button">Load more notes</button>');

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

			function loadComments(eposter_id, comment_page) {
				Swal.fire({
					title: 'Please Wait',
					text: 'Loading comments...',
					imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
					imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
					imageAlt: 'Loading...',
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});

				$.ajax({
						type: "GET",
						url: project_url+"/eposters/comments/"+eposter_id+'/'+comment_page,
						data: '',
						success: function(response){
							Swal.close();
							jsonObj = JSON.parse(response);
							// Add response in Modal body
							if (jsonObj.total) {
								$('.count_comment strong').text(jsonObj.total);
								var previousHTML = $('#comments_list_container').html();
								var iHTML = '';
								if (previousHTML == '')
									iHTML += '<ul id="list_comment" class="col-md-12">';

								for (let x in jsonObj.data) {
									let comment_id 	= jsonObj.data[x].id;
									let avatar 		= ((jsonObj.data[x].avatar === null) ? '' : jsonObj.data[x].avatar );
									let comment 	= jsonObj.data[x].comment.replace(/(?:\r\n|\r|\n)/g, '<br>');
									let commenter 	= jsonObj.data[x].commenter;
									let datetime 	= jsonObj.data[x].time;
									let user_id 	= jsonObj.data[x].user_id;

									iHTML += '<!-- Start List Comment ' + (x) +' --><li class="box_result row"><div class="avatar_comment col-md-1"><img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+avatar+'" onerror="this.onerror=null;this.src=\''+ycl_root+'/ycl_assets/images/person_dp_placeholder.png\'" alt="DP Image"></div><div class="result_comment col-md-11"><h4>'+commenter+'</h4><p>'+comment+'</p><div class="tools_comment"><span>'+datetime+'</span></div></div></li>';
								}

								if (previousHTML == '')
									iHTML += '</ul>';

								$('#commentsModal .modal-footer').html('<button' + (((comment_page+1) <= Math.ceil(jsonObj.total/comments_per_page)) ? ' class="btn btn-info btn-sm btn-block" onclick="showMoreComments('+eposter_id+', '+comment_page+');"' : ' class="btn btn-info btn-block btn-sm disabled not-allowed" disabled' ) + ' type="button">Load more comments</button>');

								if (previousHTML == '') {
									$('#comments_list_container').html(iHTML);
								} else {
									$('#list_comment').append(iHTML);
								}

							} else {
								$('.count_comment strong').text('No ');
							}
						}
					});
			}

			function showMoreNotes(entity_type, entity_type_id, note_page) {
				note_page = note_page+1;
				loadNotes(entity_type, entity_type_id, note_page);
			}

			function showMoreComments(eposter_id, comment_page) {
				comment_page = comment_page+1;
				loadComments(eposter_id, comment_page);
			}

			function iframeResize()
			{
				let totalHeight = window.innerHeight;
				let menuHeight = document.getElementById('mainMenu').offsetHeight;
				let iFrameHeight = totalHeight-menuHeight;

				$('#eposter-container').css('height', iFrameHeight+'px');

				$('.eposter-img').css('height', (iFrameHeight - 50) +'px');
			}
<?php
			//Load that part of ePosters only.
			if ($eposter->type == 'eposter') :?>
			window.addEventListener("load", startup, false);

			function startup() {
				// Get the reference to elem
				const elem = document.getElementById("eposter-img");

				document.getElementById("enlargeable").addEventListener("click", function() {
				  toggleFullScreen(elem);
				});
			}

			function toggleFullScreen(elem) {
				if (!document.fullscreenElement) {
					// If the document is not in full screen mode
					// make the elem full screen
					elem.requestFullscreen();
				} else {
					// Otherwise exit the full screen
					if (document.exitFullscreen) {
						document.exitFullscreen();
					}
				}
			}
<?php
			endif;?>
		</script>
