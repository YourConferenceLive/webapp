<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<style>
	body{overflow: hidden;}
</style>

<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/eposters.css?v=<?=rand()?>" rel="stylesheet">

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg" style="z-index: -1;">

<div class="clearfix" style="margin-top: 77px;"></div>

<div class="eposters-view-container container-fluid pl-md-6 pr-md-6 text-center" id="eposter-container">
<?php
// $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".str_replace(array('https://', 'vimeo.com/'), array(''), $eposter->video_url).".php"));
// echo $hash[0]['thumbnail_large'];
// die();
			if (($eposter->type == 'surgical_video' && $eposter->video_url != '') || $eposter->type == 'eposter'): 
				if ($eposter->type == 'surgical_video'):?>
			<iframe id="vimeo_player" src="https://player.vimeo.com/video/<?=str_replace(array('https://', 'vimeo.com/'), array(''), $eposter->video_url);?>?color=f7dfe9&title=0&byline=0&portrait=0" style="/*position:absolute;top:0;left:0;*/width:100%;height:90%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
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
					if ($eposter->type == 'eposter') {?>
					<button type="button" class="btn btn-primary btn-sm" id="enlargeable">View Full Screen</button>
<?php
					}?>
					<a role="button" class="btn btn-secondary btn-sm" href="<?=$this->project_url?>/eposters">Return to ePoster Listing</a>
				</div>
			</div>
<?php
			if ($eposter->prize){?>
			<div class="tool-btns prize hide">
				<a><img data-toggle="tooltip" data-placement="left" title="<?php echo (($eposter->prize != 'hot topic') ? 'Won ' : '' ).ucwords($eposter->prize);?>" class="img-fluid img-prize-detail img-thumbnail"
					  		 src="<?= ycl_root ?>/theme_assets/default_theme/images/eposters/thumb/<?=str_replace(' ', '_', $eposter->prize).'.png';?>"
							 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/default.jpg'"></a>
			</div>
<?php
			}?>
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

			<div class="tool-btns first"><a href="javascript:void(0);" class="claim-credits" title="Claim Credits" data-toggle="tooltip" data-placement="left"><i class="fas fa-certificate"></i></div>
<?php
			$link_order = '';
			foreach ($eposter->author as $row) {
				if ($row->contact) {?>
			<div class="tool-btns email">
				<a href="mailto:<?php echo $row->email;?>" class="email-author" title="Contact <?php echo $row->author;?>" data-toggle="tooltip" data-placement="left"><i class="fas fa-envelope"></i></a></div>
<?php
					$link_order = ' third';
					break;
				}
			}?>
			<div class="tool-btns<?php echo $link_order;?>"><a href="javascript:void(0);" data-eposter-id="<?php echo $eposter->id;?>" class="comments" title="Discuss" data-toggle="tooltip" data-placement="left"><i class="fas fa-comment"></i></a></div>
<?php
			else: ?>//In case eposter is deactivated or deleted
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3>No ePoster found!</h3>
				</div>
			</div>
<?php
			endif; ?>
</div>

<script type="application/javascript">
	let project_id = "<?=$this->project->id?>";
	let comment_page = 1;
	let comments_per_page = "<?=$comments_per_page;?>";

	$(function () {
		iframeResize();
		$(window).on('resize', function(){
			iframeResize();
		});

		$('[data-toggle="tooltip"]').tooltip();


		$('.comments').click(function() {
			var eposter_id = $(this).data('eposter-id');

			loadComments(eposter_id, comment_page);
			$('#comments_list_container').html('');
			$('#commentsModal').modal('show');
		});
	});

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
					// console.log('Comment Total Page : '+ (jsonObj.total / comments_per_page));
					// console.log('Comment Current Page : '+ comment_page);
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
							let comment 	= jsonObj.data[x].comment.replace(/(?:\r\n|\r|\n)/g, '<br>');;
							let commenter 	= jsonObj.data[x].commenter;
							let datetime 	= jsonObj.data[x].time;
							let user_id 	= jsonObj.data[x].user_id;

							iHTML += '<!-- Start List Comment ' + (x) +' --><li class="box_result row"><div class="avatar_comment col-md-1"><img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+avatar+'" onerror="this.onerror=null;this.src=\''+ycl_root+'/ycl_assets/images/person_dp_placeholder.png\'" alt="DP Image"></div><div class="result_comment col-md-11"><h4>'+commenter+'</h4><p>'+comment+'</p><div class="tools_comment"><span>'+datetime+'</span></div></div></li>';
						}

						if (previousHTML == '')
							iHTML += '</ul>';

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

	function showMore(eposter_id, comment_page) {
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
	if ($eposter->type == 'eposter') {?>
	window.addEventListener("load", startup, false);

	function startup() {
		// Get the reference to elem
		const elem = document.getElementById("eposter-img");

		document.getElementById("enlargeable").addEventListener("click", function() {
		  toggleFullScreen(elem);
		});

		// On pressing ENTER call toggleFullScreen method
	  	document.addEventListener("keypress", function(e) {
	    	if (e.key === 'Enter') {
	      		toggleFullScreen(elem);
	    	}
	  	}, false);
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
	}?>
</script>
