<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	body{
		overflow: hidden;
		background-color: #151515;
	}
</style>

<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<div class="sessions-view-container container-fluid p-0">
		<?php if (isset($session->millicast_stream) && $session->millicast_stream != ''): ?>
			<iframe id="millicastIframe" class="" src="https://viewer.millicast.com/v2?streamId=pYVHx2/<?=str_replace(' ', '', $session->millicast_stream)?>&autoPlay=true&muted=true&disableFull=true" width="100%" style="height: 100%"></iframe>
		<?php else: ?>
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3>No Stream Found</h3>
				</div>
			</div>
		<?php endif; ?>
</div>

<!--bizim-->
<div class="rightSticky" data-screen="customer">
	<ul>
		<li data-type="notesSticky"><i class="fas fa-edit" aria-hidden="true"></i> <span>TAKE NOTES</span></li>
		<li data-type="resourcesSticky"><i class="fa fa-paperclip" aria-hidden="true"></i> <span>RESOURCES</span></li>
		<li data-type="messagesSticky"><i class="fa fa-comments" aria-hidden="true"></i> <span class="notify displayNone"></span> <span>MESSAGES</span></li>
		<li data-type="questionsSticky"><i class="fa fa-question" aria-hidden="true"></i> <span>QUESTIONS</span></li>
	</ul>
</div>

<div class="rightSticykPopup notesSticky" style="display: none">
	<div class="header"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off">Resources</li>
					<li data-type="messagesSticky" data-type2="off">Messages</li>
					<li data-type="questionsSticky" data-type2="off">Questions</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader">Take Notes</div>
		<div id="briefcase_section">
			<div id="briefcase_section">
				<div class="col-md-12 input-group">
					<input type="hidden" name="session_id" id="session_id" value="<?php echo $session_id;?>">
					<textarea type="text" id="briefcase" class="form-control" placeholder="Enter Note" value=""><?=isset($sessions_notes_download) ? $sessions_notes_download : "" ?></textarea>
				</div>
				<div class="col-md-12 pt-1">
					<a class="button color btn btn-info btn-sm" id="briefcase_send"><i class="fas fa-save"></i> <span>Save</span></a>
				</div>
				<div class="col-md-12">
<?php
					if($notes != new stdClass()):?>
					<div class="contentHeader p-0 pt-2 pb-2">Previous Notes</div>
					<div id="notes_list_container">
						<ul class="list-group">
<?php
						foreach ($notes as $note):
							if (trim($note->note_text) != ''):?>
							<li class="list-group-item p-1"><?php echo ((strlen($note->note_text) > 20) ? substr($note->note_text, 0, 20).'&hellip; <a href="javascript:void(0);" class="note_detail" data-note-text="'.$note->note_text.'">more&raquo;</a>' : $note->note_text );?></li>
<?php
							endif;
						endforeach;?>
						</ul>
					</div>
<?php
					else:?>
					<div class="alert alert-info mb-1 mt-3 p-1">No previous notes</div>
<?php
					endif;?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="rightSticykPopup resourcesSticky" style="display: none">
	<div class="header"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="messagesSticky" data-type2="off">Messages</li>
					<li data-type="questionsSticky" data-type2="off">Questions</li>
					<li data-type="notesSticky" data-type2="off">Take Notes</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader">
			Resources
		</div>
		<div id="resource_section" style="padding: 0px 0px 0px 0px; margin-top: 10px; background-color: #fff; border-radius: 5px;">
			<div style="padding: 0px 15px 15px 15px; overflow-y: auto; height: 240px;" id="resource_display_status">
				<?php
				if (!empty($session_resource)) {
					foreach ($session_resource as $val) {
						?>
						<div class="row" style="margin-bottom: 10px; padding-bottom: 5px">
							<?php if ($val->resource_link != "") { ?>
								<div class="col-md-12"><a href="<?= $val->resource_link ?>" target="_blank"><?= $val->link_published_name ?></a></div>
							<?php } ?>
							<?php
							if ($val->upload_published_name) {
								if ($val->resource_file != "") {
									?>
									<div class="col-md-12"><a href="<?= base_url() ?>uploads/resource_sessions/<?= $val->resource_file ?>" download> <?= $val->upload_published_name ?> </a></div>
									<?php
								}
							}
							?>
						</div>
						<?php
					}
				}
				?>
				<span id='success_resource' style='color:green;'></span>
			</div>
		</div>
	</div>

</div>
<div class="rightSticykPopup messagesSticky" style="display: none">
	<div class="header"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off">Resources</li>
					<li data-type="questionsSticky" data-type2="off">Questions</li>
					<li data-type="notesSticky" data-type2="off">Take Notes</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader">
			Messages
		</div>
		<div class="messages">

		</div>

		<input type="text" class="form-control" placeholder="Enter message" id='sendGroupChat'>

	</div>

</div>
<div class="rightSticykPopup questionsSticky" style="display: none">
	<div class="header"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off">Resources</li>
					<li data-type="messagesSticky" data-type2="off">Messages</li>
					<li data-type="notesSticky" data-type2="off">Take Notes</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader">
			Questions
		</div>
		<div class="questionElement">
		</div>
		<div id="ask_questions_section" style="background-color: #fff; border-radius: 5px; position: absolute; bottom: 0; width: 100%;">
			<div style="padding:5px;">
				<div style="text-align: center; display: flex; " id="questions_section">

					<div class="col-md-12 input-group">
						<span class="input-group-addon" style="padding: 5px 6px"><img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/happy.png" id="questions_emjis_section_show" title="Check to Show Emoji" data-questions_emjis_section_show_status="0" style="width: 20px; height: 20px;" alt=""/></span>
						<input type="text" id="questions" class="form-control" placeholder="Enter Question" value="">
					</div>
					<a class="button color btn" style="margin: 0px; padding: 15px 7px;" id="ask_questions_send"><span>Send</span></a>
				</div>
				<div style="text-align: left; padding-left: 10px; display: flex;" id="questions_emojis_section">
					<img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/happy.png" title="Happy" id="questions_happy" data-title_name="&#128578;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/sad.png" title="Sad" id="questions_sad" data-title_name="&#128543" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/laughing.png" title="Laughing" id="questions_laughing" data-title_name="😁" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/thumbs_up.png" title="Thumbs Up" id="questions_thumbs_up" data-title_name="&#128077;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/thumbs_down.png" title="Thumbs Down" id="questions_thumbs_down" data-title_name="&#128078" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/default_theme/images/emoji/clapping.png" title="Clapping" id="questions_clapping" data-title_name="&#128079;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
				</div>
				<span id='error_questions' style='color:red;'></span>
				<span id='success_questions' style='color:green;'></span>
			</div>
		</div>
	</div>

</div>

<style>
.list-group {overflow: auto; height: 100px;}
.list-group-item:nth-child(odd) {background-color: #FFFFFF;}
.list-group-item:nth-child(even) {background-color: #ECECEC;}
</style>
<!--<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dRp5VbWCQ3A?playlist=dRp5VbWCQ3A&controls=1&autoplay=1&mute=1&loop=1"></iframe>-->

<script src="<?=ycl_root?>/theme_assets/default_theme/js/sponsor/sessions.js?v=<?=rand()?>"></script>

<script type="application/javascript">
	var note_page = 1;

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

		$.ajax({type: "GET",
				url: project_url+"/eposters/notes/"+entity_type+'/'+entity_type_id+'/'+note_page,
				data: '',
				success: function(response){
					Swal.close();
					jsonObj = JSON.parse(response);
					// Add response in Modal body
					if (jsonObj.total) {
						var iHTML = '<ul class="list-group">';

						for (let x in jsonObj.data) {
							let note_id 	= jsonObj.data[x].id;
							let note 		= jsonObj.data[x].note_text.replace(/(?:\r\n|\r|\n)/g, '<br>');
							let datetime 	= jsonObj.data[x].time;

							iHTML += '<!-- Start List Note ' + (x) +' --><li class="list-group-item p-1">'+((note.length > 20) ? note.substr(0, 20) + '&hellip; <a href="javascript:void(0);" class="note_detail" data-note-text="' + note + '">more&raquo;</a>' : note )+'</li>';
						}

						iHTML += '</ul>';

						$('#notes_list_container').html(iHTML);
					} else {
					}
				}
			});
	}

	$(function (){
		iframeResize();
		$(window).on('resize', function(){
			iframeResize();
		});
	});

	function iframeResize()
	{
		let totalHeight = window.innerHeight;
		let menuHeight = document.getElementById('mainMenu').offsetHeight;
		let iFrameHeight = totalHeight-menuHeight;

		$('#millicastIframe').css('height', iFrameHeight+'px');
	}

	$(function () {
		$('#briefcase_send').on('click', function () {
			let entity_type 	= 'session';
			let entity_type_id 	= $('#session_id').val();
			let note_text   	= $('#briefcase').val();

			if (entity_type_id == ''  || note_text == '') {
				toastr.error('Invalid request.');
				return;
			}

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

			let formData = new FormData();
			formData.append("entity_type_id", entity_type_id);
			formData.append("origin_type", entity_type);
			formData.append("notes", $('#briefcase').val());

			$.ajax({type: "POST",
					url: project_url+"/eposters/add_notes/session",
					data: formData,
					processData: false,
					contentType: false,
					error: function(jqXHR, textStatus, errorMessage) {
						Swal.close();
						toastr.error(errorMessage);
					},
					success: function(data) {
						data = JSON.parse(data);

						if (data.status == 'success') {
							$('#notes_list_container').html('');
							$('#briefcase').val('');
							loadNotes(entity_type, entity_type_id, note_page);
							toastr.success('Note added.');
							$('#notes').val('');
						}else{
							toastr.error("Error");
						}
					}
			});
		});

		$('.note_detail').on('click', function () {
			$('#noteModal').modal('hide');
  			let note_text = $(this).data('note-text');
  			$('.modal-body .note-text').text(note_text);
			$('#noteModal').modal('show');
			$('#pollModal').modal('hide');
			$('#pollResultModal').modal('hide');
		});

		socket.on('openPollNotification', ()=>{
			$('#pollModal').modal('show');
			$('#pollResultModal').modal('hide');
			$('#noteModal').modal('show');
		});

		socket.on('closePollNotification', ()=>{
			$('#pollModal').modal('hide');
		});

		socket.on('openResultNotification', ()=>{
			$('#pollModal').modal('hide');
			$('#noteModal').modal('show');
			$('#pollResultModal').modal('show');
		});

		socket.on('closeResultNotification', ()=>{
			$('#pollResultModal').modal('hide');
		});
	});
</script>
