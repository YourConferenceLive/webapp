<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($_SESSION['project_sessions']["project_{$this->project->id}"]);exit;

?>
<style>
body{overflow: hidden;background-color: #151515;}
</style>

<link href="<?=ycl_root?>/theme_assets/ccs/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<div class="sessions-view-container container-fluid p-0">
<?php
			if (isset($session->video_url) && $session->video_url != ''):
					$video_url = preg_replace('/[^0-9]/', '', $session->video_url);?>
			<iframe id="sessionIframe" src="https://player.vimeo.com/video/<?=$video_url;?>?color=f7dfe9&title=0&byline=0&portrait=0" width="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="height: 100%"></iframe>
			<script src="https://player.vimeo.com/api/player.js"></script>
<?php
			elseif (isset($session->millicast_stream) && $session->millicast_stream != ''):?>
			<iframe id="sessionIframe" class="" src="https://viewer.millicast.com/v2?streamId=pYVHx2/<?=str_replace(' ', '', $session->millicast_stream)?>&autoPlay=true&muted=true&disableFull=true" width="100%" style="height: 100%"></iframe>
<?php
			else:?>
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3>No Stream Found</h3>
				</div>
			</div>
<?php
			endif;?>
</div>

<!--bizim-->
<div class="rightSticky" data-screen="customer" >
	<ul>
		<li data-type="notesSticky" id="notesSticky"  style="<?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>"><i class="fas fa-edit" aria-hidden="true"></i> <span><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?>  </span></li>
		<li data-type="resourcesSticky" id="resourcesSticky"  style="<?=  ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>"><i class="fa fa-paperclip" aria-hidden="true"></i> <span><?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?> </span></li>
		<!--<li data-type="messagesSticky"><i class="fa fa-comments" aria-hidden="true"></i> <span class="notify displayNone"></span> <span>MESSAGES</span></li>-->
		<li data-type="questionsSticky" id="questionsSticky"  style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>"><i class="fa fa-question" aria-hidden="true"></i> <span><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></span></li>
		<li data-type="adminChatSticky" id="adminChatStickyIcon"  style="display:none" class="bg-primary"><i class="fa fa-life-ring" aria-hidden="true"></i> <span>Chat With Admin</span></li>
		<li data-type="askARepSticky" id="askARepSticky"  style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>"><img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/conversation_icon.png" style="height:25px; width:25px"> <span><?=(isset($session->toolbox_askrep_text) && !empty($session->toolbox_askrep_text))? $session->toolbox_askrep_text: 'Ask a Rep'?></span></li>
	</ul>
</div>

<div class="rightSticykPopup notesSticky" style="display: none; ">
	<div class="header"  style="<?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>;" ><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off"><?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?></li>
					<li data-type="questionsSticky" data-type2="off"><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></li>
					<li data-type="askARepSticky" data-type2="off"><?=(isset($session->toolbox_askrep_text) && !empty($session->toolbox_askrep_text))? $session->toolbox_askrep_text: 'Ask a Rep'?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader" style="<?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?> </div>
		<div id="briefcase_section">
			<div id="briefcase_section">
				<div class="col-md-12 input-group">
					<input type="hidden" name="session_id" id="session_id" value="<?php echo $session_id;?>">
					<textarea type="text" id="briefcase" class="form-control" placeholder="Enter Note" value=""><?=isset($sessions_notes_download) ? $sessions_notes_download : "" ?></textarea>
				</div>
				<div class="col-md-12 pt-1">
					<a class="button color btn btn-info btn-sm" id="briefcase_send" style="<?= ($view_settings&& $view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:''?>;"><i class="fas fa-save"></i> <span>Save</span></a>
				</div>
				<div class="col-md-12">
					<div class="contentHeader p-0 pt-2 pb-2" style="<?= (($view_settings) && $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:''?>;">Previous Notes</div>
					<div id="notes_list_container">
<?php
					if($notes != new stdClass()):?>
						<ul class="list-group">
<?php
						foreach ($notes as $note):
							if (trim($note->note_text) != ''):?>
							<li class="list-group-item p-1"><?php echo ((strlen($note->note_text) > 20) ? substr($note->note_text, 0, 20).'&hellip; <a href="javascript:void(0);" class="note_detail" data-note-text="'.$note->note_text.'">more&raquo;</a>' : $note->note_text );?></li>
<?php
							endif;
						endforeach;?>
						</ul>
<?php
					else:?>
						<div class="alert alert-info mb-1 mt-1 p-1" style="<?= (($view_settings) && $view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:''?>;">No previous notes</div>
<?php
					endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="rightSticykPopup resourcesSticky" style="display: none">
	<div class="header" style="<?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" id="resourcesStickyMinimize" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="questionsSticky" data-type2="off"><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></li>
					<li data-type="notesSticky" data-type2="off"><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?>  </li>
					<li data-type="askARepSticky" data-type2="off"><?=(isset($session->toolbox_askrep_text) && !empty($session->toolbox_askrep_text))? $session->toolbox_askrep_text: 'Ask a Rep'?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader" style="<?= (($view_settings) && $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:''?>;">
			<?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?>
		</div>
		<div id="resource_section" style="padding: 0px 0px 0px 0px; margin-top: 10px; background-color: #fff; border-radius: 5px;">
			<div style="padding: 0px 15px 15px 15px; overflow-y: auto; height: 240px;" id="resource_display_status">
<?php
				if (!empty($session->resources)) {
					foreach ($session->resources as $resource) {?>
						<div class="row" style="margin-bottom: 10px; padding-bottom: 5px">
<?php
							if ($resource->resource_type == "url") {?>
								<div class="col-md-12"><a href="<?=$resource->resource_path?>" target="_blank"><i class="fas fa-globe"></i> <?=$resource->resource_name?></a></div>
<?php
							}?>
<?php
							if ($resource->resource_type == "file") {
								if ($resource->resource_path != "") {?>
									<div class="col-md-12"><a href="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/resources/<?=$resource->resource_path?>" download><i class="fas fa-file-alt text-info"></i>  <?=$resource->resource_name?> </a></div>
<?php
								}
							}?>
						</div>
<?php
					}
				}?>
				<span id='success_resource' style='color:green;'></span>
			</div>
		</div>
	</div>
</div>
<div class="rightSticykPopup messagesSticky" style="display: none">
	<div class="header"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" id="messagesStickyMinimize" aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off"><?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?></li>
					<li data-type="questionsSticky" data-type2="off"><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></li>
					<li data-type="notesSticky" data-type2="off"><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?>  </li>
					<li data-type="adminChatSticky" data-type2="off">Ask a Rep</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader"><?=(isset($session->toolbox_chat_admin_text) && !empty($session->toolbox_chat_admin_text))? $session->toolbox_chat_admin_text: 'Chat With admin'?></div>
		<div class="messages"></div>
		<input type="text" class="form-control" placeholder="Enter message" id='sendGroupChat'>
	</div>
</div>
<div class="rightSticykPopup questionsSticky" style="display: none">
	<div class="header" style="<?=  ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" id="questionsStickyMinimize"  aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off"><?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?></li>
					<li data-type="notesSticky" data-type2="off"><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?>  </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">

		<div class="contentHeader" style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></div>
		<div id="questionElement" class="questionElement" style="overflow: scroll;height: 170px;"></div>
		<div id="ask_questions_section" style="background-color: #fff; border-radius: 5px; position: absolute; bottom: 0; width: 100%;">
			<div style="padding:5px;">
				<div style="text-align: center; display: flex; " id="questions_section">
					<div class="col-md-12 input-group">
						<span class="input-group-addon" style="padding: 5px 6px"><img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/happy.png" id="questions_emjis_section_show" title="Check to Show Emoji" data-questions_emjis_section_show_status="0" style="width: 20px; height: 20px;" alt=""/></span>
						<input type="text" id="questionText" class="form-control" placeholder="Press enter to send..." value="">
					</div>
					<a id="askQuestionBtn" class="button color btn" style="margin: 0px; padding: 15px 7px;" id="ask_questions_send"><span>Send</span></a>
				</div>
				<div style="text-align: left; padding-left: 10px; display: flex;" id="questions_emojis_section">
					<img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/happy.png" title="Happy" id="questions_happy" data-title_name="&#128578;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/sad.png" title="Sad" id="questions_sad" data-title_name="&#128543" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/laughing.png" title="Laughing" id="questions_laughing" data-title_name="😁" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/thumbs_up.png" title="Thumbs Up" id="questions_thumbs_up" data-title_name="&#128077;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/thumbs_down.png" title="Thumbs Down" id="questions_thumbs_down" data-title_name="&#128078" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
					<img src="<?= ycl_root ?>/theme_assets/ccs/<?=$this->project->theme?>/images/emoji/clapping.png" title="Clapping" id="questions_clapping" data-title_name="&#128079;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
				</div>
				<span id='error_questions' style='color:red;'></span>
				<span id='success_questions' style='color:green;'></span>
			</div>
		</div>
	</div>

</div>

<div class="rightSticykPopup adminChatSticky" style="display: none">
	<div class="header bg-primary" style=""><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" id="chatWithAdminMinimize"  aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="resourcesSticky" data-type2="off"><?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?></li>
					<li data-type="notesSticky" data-type2="off"><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?>  </li>
					<li data-type="askARepSticky" data-type2="off"><?=(isset($session->toolbox_askrep_text) && !empty($session->toolbox_askrep_text))? $session->toolbox_askrep_text: 'Ask a Rep'?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">

		<div class="contentHeader" style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><?=(isset($session->toolbox_chat_admin_text) && !empty($session->toolbox_chat_admin_text))? $session->toolbox_chat_admin_text: 'Chat With admin'?></div>
		<div id="chat_with_admin_body" class="chat_with_admin_body" style="overflow-y: scroll;height: 170px;">

		</div>
		<div id="chat_with_admin_footer" style="background-color: #fff; border-radius: 5px; position: absolute; bottom: 0; width: 100%;">
			<div style="padding:5px;">
				<div style="text-align: center; display: flex; " id="">
					<div class="col-md-12 input-group">
							<input type="text" id="chat_with_admin_text" class="form-control" placeholder="Press enter to send..." value="">
					</div>
					<a class="button color btn" style="margin: 0; padding: 15px 7px;" id="chat_with_admin_send"><span>Send</span></a>
				</div>
				<span id='error_chat_with_admin' style='color:red;'></span>
				<span id='success_chat_with_admin' style='color:green;'></span>
			</div>
		</div>
	</div>

</div>


<div class="rightSticykPopup askARepSticky" style="display: none">
	<div class="header" style="<?=  ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><span>Toolbox</span>
		<div class="rightTool">
			<i class="fa fa-minus" id="askARepStickyMinimize"  aria-hidden="true"></i>
			<div class="dropdown">
				<span class="fas fa-ellipsis-v" aria-hidden="true" data-toggle="dropdown"></span>
				<ul class="dropdown-menu">
					<li data-type="questionsSticky" data-type2="off"><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></li>
					<li data-type="resourcesSticky" data-type2="off"><?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?></li>
					<li data-type="notesSticky" data-type2="off"><?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?>  </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="contentHeader" style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><?=(isset($session->toolbox_askrep_text) && !empty($session->toolbox_askrep_text))? $session->toolbox_askrep_text: 'Ask a Rep'?></div>
		<div id="ask-a-rep" class="ask-a-rep" style="overflow-y: scroll;height: 170px;">
			I would like a representative to contact me.
		</div>
		<div id="ask_a_rep_footer" style="background-color: #fff; border-radius: 5px; position: absolute; bottom: 0; width: 100%;">
			<div style="padding:5px;">
				<div style="text-align: center; display: flex; " id="">
					<div class="col-md-9 input-group float-right">
						<div class="form-group ">
							<div class="form-check text-left">
								<input class="form-check-input" type="radio" name="ask_rep_radio" id="ask_rep_radio" value="rep">
								<label class="form-check-label" for="ask_rep_radio">
									Ask a Rep
								</label>
							</div>
							<div class="form-check text-left">
								<input class="form-check-input" type="radio" name="ask_rep_radio" id="ask_msl_radio" value="msl">
								<label class="form-check-label" for="ask_msl_radio">
									Ask an MSL
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-3 float-right text-right">
					<button class="float-right btn btn-success askARepSendBtn" id="askARepSendBtn" style="margin: 0; padding: 15px 7px;" id=""><span>Send</span></button>
					</div>
				</div>

				<span id='error_chat_with_admin' style='color:red;'></span>
				<span id='success_chat_with_admin' style='color:green;'></span>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($view_settings) && !empty($view_settings[0]->poll_music)) {
	foreach($view_settings as $music_setting){
		if ($music_setting->poll_music != "") {
			?>
			<audio allow="autoplay" id="audio_<?=$this->project->id?>" src="<?= ycl_root.'/cms_uploads/projects/'.$this->project->id.'/sessions/music/'.$music_setting->poll_music ?>" ></audio>
			<?php
		}
	}
}
?>

<input type="hidden" id="logs_id" value="">
<style>
.list-group {overflow: auto; height: 100px;}
.list-group-item:nth-child(odd) {background-color: #FFFFFF;}
.list-group-item:nth-child(even) {background-color: #ECECEC;}
</style>
<!--<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dRp5VbWCQ3A?playlist=dRp5VbWCQ3A&controls=1&autoplay=1&mute=1&loop=1"></iframe>-->

<script src="<?=ycl_root?>/theme_assets/ccs/<?=$this->project->theme?>/js/sponsor/sessions.js?v=<?=rand()?>"></script>
<script src="<?=ycl_root?>/theme_assets/ccs/<?=$this->project->theme?>/js/common/sessions/attendee_to_admin_chat.js?v=<?=rand()?>"></script>

<script type="application/javascript">
	let projectId = "<?=$this->project->id?>";
	let sessionId = "<?=$session->id?>";
	var note_page = 1;
   	let attendee_Fname = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['name'] ?>";
	let attendee_Lname = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['surname'] ?>";
	let attendee_FullName = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['name'].' '.$_SESSION['project_sessions']["project_{$this->project->id}"]['surname'] ?>";
	let uid = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] ?>";

	var timeSpentOnSessionFromDb;
	var timeSpentUntilNow;

	<?php
	$dtz = new DateTimeZone($this->project->timezone);
	$time_in_project = new DateTime('now', $dtz);
	$gmtOffset = $dtz->getOffset( $time_in_project ) / 3600;
	$gmtOffset = "GMT" . ($gmtOffset < 0 ? $gmtOffset : "+".$gmtOffset);
	?>

	let session_start_datetime = "<?= date('M j, Y H:i:s', strtotime($session->start_date_time)).' '. $gmtOffset ?>";
	let session_end_datetime = "<?= date('M j, Y H:i:s', strtotime($session->end_date_time)).' '. $gmtOffset ?>";

	function loadNotes(entity_type, entity_type_id, note_page) {
		Swal.fire({
			title: 'Please Wait',
			text: 'Loading notes...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/loading.gif',
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
		ask_a_rep();
		iframeResize();
		$(window).on('resize', function(){
			iframeResize();
		});

		$('#questionText').on('keyup', function (e) {
			if (e.key === 'Enter' || e.keyCode === 13) {
				$('#questionText').prop('disabled', true);

				let question = $(this).val();
				let sessionId = "<?=$session_id?>";

				if(question == '') {
					toastr.warning('Please enter your question');
					return false;
				}

				$.post(project_url+"/sessions/askQuestionAjax",{
						session_id:sessionId,
						question:question,
					},
						function (response) {
							response = JSON.parse(response);
							console.log(response.data);
							if (response.status == 'success') {
								socket.emit("ycl_session_question", {
									sessionId:sessionId,
									question:question,
									sender_name: attendee_Fname,
									sender_surname: attendee_Lname,
									sender_id: uid,
									question_id : (response.data)?response.data:''

								});

								$('#questionText').val('');
								$('#questionElement').prepend('<p>'+question+'</p>');
								toastr.success("Question sent");
							} else {
								toastr.error("Unable to send the question");
							}

							$('#questionText').prop('disabled', false);

						}).fail((error)=>{
							toastr.error("Unable to send the question");
							$('#questionText').prop('disabled', false);
						});
			}
		});
	});

	function iframeResize() {
		let totalHeight = window.innerHeight;
		let menuHeight = document.getElementById('mainMenu').offsetHeight;
		let iFrameHeight = totalHeight-menuHeight;

		$('#sessionIframe').css('height', iFrameHeight+'px');
	}

	$(function () {

		get_sessions_history_open(sessionId);

		$('#notes_list_container').on('click', '.note_detail', function (e) {
			$('#noteModal').modal('hide');
  			let note_text = $(this).data('note-text');
  			$('.modal-body .note-text').text(note_text);
			$('#noteModal').modal('show');
			$('#pollModal').modal('hide');
			$('#pollResultModal').modal('hide');
		});

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
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/loading.gif',
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
						} else {
							toastr.error("Error");
						}
					}
			});
		});

		socket.on('ycl_launch_poll', (data)=>{

			if(data.session_id == sessionId) {

				$('#pollId').val(data.session_id);
				$('#pollQuestion').text(data.poll_question);
				$('#howMuchSecondsLeft').text('');

				$('#pllOptions').html('');
				$.each(data.options, function (key, option) {
					$('#pllOptions').append('' +
							'<div class="form-check mb-2">' +
							'  <input class="form-check-input" type="radio" name="poll_option" value="'+option.id+'">' +
							'  <label class="form-check-label">'+option.option_text+'</label>' +
							'</div>');
				});

				$('#pollResultModal').modal('hide');
				$('#noteModal').modal('hide');

				$('#pollModal').modal({
					backdrop: 'static',
					keyboard: false
				});

				var timeleft = 10;
				var downloadTimer = setInterval(function(){
					play_music();
					if(timeleft <= 0) {
						stop_music();
						clearInterval(downloadTimer);
						$('#pollModal').modal('hide');

						if (data.show_result == 1) {// Show result automatically
							$.get(project_url+"/sessions/getPollResultAjax/"+data.id, function (results) {
								results = JSON.parse(results);

								$('#pollResults').html('');
								$('#pollResultModalLabel').text(data.poll_question);
								$.each(results, function (poll_id, option_details) {
									$('#pollResults').append('' +
											'<div class="form-group">' +
											'  <label class="form-check-label">'+option_details.option_name+'</label>' +
											'  <div class="progress" style="height: 25px;">' +
											'    <div class="progress-bar" role="progressbar" style="width: '+option_details.vote_percentage+'%;" aria-valuenow="'+option_details.vote_percentage+'" aria-valuemin="0" aria-valuemax="100">'+option_details.vote_percentage+'%</div>' +
											'  </div>' +
											'</div>');
								});

								$('#pollResultModal').modal({
									backdrop: 'static',
									keyboard: false
								});

								var resultTimeleft = 5;
								var resultTimer = setInterval(function(){
									if(resultTimeleft <= 0) {
										stop_music();
										clearInterval(resultTimer);
										$('#pollResultModal').modal('hide');
									} else {
										$('#howMuchSecondsLeftResult').text(resultTimeleft);
									}
									resultTimeleft -= 1;
								}, 1000);
							});
						}
					} else {
						$('#howMuchSecondsLeft').text(timeleft);
					}
					timeleft -= 1;
				}, 1000);

			}
		});

		socket.on('ycl_launch_poll_result', (data)=>{

			if(data.session_id == sessionId) {
				$('#pollResultModalLabel').text(data.poll_question);
				$.get(project_url+"/sessions/getPollResultAjax/"+data.poll_id, function (results) {
					results = JSON.parse(results);

					$('#pollResults').html('');

					if(results.poll_type === 'poll' || results.poll_type === 'presurvey') {
						$.each(results.poll, function (poll_id, option_details) {
							$('#pollResults').append('' +
								'<div class="form-group">' +
								'  <label class="form-check-label">'+option_details.option_name+'</label>' +
								'  <div class="progress" style="height: 25px;">' +
								'    <div class="progress-bar" role="progressbar" style="width: '+option_details.vote_percentage+'%;" aria-valuenow="'+option_details.vote_percentage+'" aria-valuemin="0" aria-valuemax="100">'+option_details.vote_percentage+'%</div>' +
								'  </div>' +
								'</div>');
						});
					}else {
						$.each(results.poll, function (poll_id, option_details) {
							$('#pollResults').append('' +
								'<div class="form-group">' +
								'  <label class="form-check-label">' + option_details.option_name + '</label>' +
								' <div class="progress_section" id="progress-section-'+option_details.poll_index+'"> ' +
								'	<div class="progress mb-1" style="height: 25px;">' +
								'    	<div class="progress-bar" role="progressbar" style="width: ' + option_details.vote_percentage + '%;" aria-valuenow="' + option_details.vote_percentage + '" aria-valuemin="0" aria-valuemax="100">' + option_details.vote_percentage + '%</div>' +
								'	</div> ' +
								'</div>' +
								'</div>');

						});
						$.each(results.compere, function (poll_id, option_details) {
							$('#progress-section-'+option_details.poll_index).prepend(
								'	<div class="progress mb-1" style="height: 25px;">' +
								'    	<div class="progress-bar bg-info" role="progressbar" style="width: ' + option_details.vote_percentage_compare + '%;" aria-valuenow="' + option_details.vote_percentage_compare + '" aria-valuemin="0" aria-valuemax="100">' + option_details.vote_percentage_compare + '%</div>' +
								'	</div> '
							);
						});
					}

					$('#pollResultModal').modal({
						backdrop: 'static',
						keyboard: false
					});
				});
			}
		});

		socket.on('ycl_close_poll_result', (data)=>{
			if(data.session_id == sessionId) {
				$('#pollResultModal').modal('hide');
			}
		});
	});

	$(function(){
		Swal.fire(
			'INFO',
			'Be sure to unmute the player located on the bottom right side of the page.',
			'warning'
		);

		let header_toolbox_status = "<?=(isset($session->header_toolbox_status)? $session->header_toolbox_status:'')?>";
		let header_question = "<?=(isset($session->header_question)? $session->header_question:'') ?>"
		let header_notes = "<?=(isset($session->header_notes)? $session->header_notes:'') ?>"
		let header_resources = "<?=(isset($session->header_resources)? $session->header_resources:'') ?>"
		let header_askrep = "<?=(isset($session->header_askrep)? $session->header_askrep:'') ?>"
		let right_sticky_resources = "<?=(isset($session->right_sticky_resources)? $session->right_sticky_resources:'') ?>"
		let right_sticky_question = "<?=(isset($session->right_sticky_question)? $session->right_sticky_question:'') ?>"
		let right_sticky_notes = "<?=(isset($session->right_sticky_notes)? $session->right_sticky_notes:'') ?>"
		let right_sticky_askrep = "<?=(isset($session->right_sticky_askrep)? $session->right_sticky_askrep:'') ?>"
		let claim_credit_link = "<?=(isset($session->claim_credit_link)? $session->claim_credit_link:'') ?>"
		let claim_credit_url = "<?=(isset($session->claim_credit_url)? $session->claim_credit_url:'') ?>"

		// console.log('res'+header_resources);
		if(header_toolbox_status == 0){
			$('#header-toolbox').css('display','none')
		}else{
			$('#header-toolbox').css('display','block')
		}

		if(header_question == 0){
			$('#questionStickyMenu').css('display','none')
		}else{
			$('#questionStickyMenu').css('display','block')
		}

		if(header_notes == 0){
			$('#notesStickyMenu').css('display','none')
		}else{
			$('#notesStickyMenu').css('display','block')
		}

		if(header_resources == 0){
			$('#resourcesStickyMenu').css('display','none')
		}else{
			$('#resourcesStickyMenu').css('display','block')
		}

		if(header_resources == 0){
			$('#resourcesStickyMenu').css('display','none')
		}else{
			$('#resourcesStickyMenu').css('display','block')
		}

		if(right_sticky_resources == 0){
			$('#resourcesSticky').css('display','none')
			$('li[data-type][data-type="resourcesSticky"]').hide();
		}else{
			$('#resourcesSticky').css('display','block')
		}

		if(right_sticky_question == 0){
			$('#questionsSticky').css('display','none')
			$('li[data-type][data-type="questionsSticky"]').hide();
		}else{
			$('#questionsSticky').css('display','block')
		}

		if(right_sticky_notes == 0){
			$('#notesSticky').css('display','none')
			$('li[data-type][data-type="notesSticky"]').hide();
		}else{
			$('#notesSticky').css('display','block')
		}

		if(claim_credit_link !== ''){
			$('#header_claim_credit').css('display','block')
			$('.claim_credit_href').attr('href', claim_credit_url);
			$('#header_claim_credit_link').html(claim_credit_link);
		}else{
			$('#header_claim_credit').css('display','none')
		}

		socket.on('reload-attendee-signal', function () {
				update_viewsessions_history_open();
				saveTimeSpentOnSessionAfterSessionFinished();

		});

	})


	/******* Saving time spent on session - by Rexter ************/

	function saveTimeSpentOnSessionAfterSessionFinished(){
		$.ajax({
			url: project_url+"/sessions/saveTimeSpentOnSession/"+sessionId+'/'+uid,
			type: "post",
			data: {'time': timeSpentUntilNow},
			dataType: "json",
			success: function (data) {
				location.reload();
			}
		});
	}

	function getTimeSpentOnSiteFromLocalStorage(){
		timeSpentOnSite = parseInt(localStorage.getItem('timeSpentOnSite'));
		timeSpentOnSite = isNaN(timeSpentOnSite) ? 0 : timeSpentOnSite;
		return timeSpentOnSite;
	}

	function saveTimeSpentOnSession(){
		// console.log(timeSpentUntilNow)
		$.ajax({
			url: project_url+"/sessions/saveTimeSpentOnSession/"+sessionId+'/'+uid,
			type: "post",
			data: {'time': timeSpentUntilNow},
			dataType: "json",
			success: function (data) {
				// update_viewsessions_history_open();
			}
		});

	}

	function getTimeSpentOnSession(){
		$.ajax({
			url: project_url+"/sessions/getTimeSpentOnSession/"+sessionId+'/'+uid,
			type: "post",
			dataType: "json",
			success: function (data) {
				timeSpentOnSessionFromDb = parseInt(data);
				startCounting();
				// saveTimeSpentOnSession();
				return parseInt(data);
			}
		});

	}

	function startCounting(){
		timeSpentUntilNow = timeSpentOnSessionFromDb;
		onSessiontimer = setInterval(function(){
			var datetime_now_newyork = calcTime('-5');
			if(datetime_now_newyork >= session_start_datetime && datetime_now_newyork <= session_end_datetime)
				timeSpentUntilNow = timeSpentUntilNow+1;
			if (datetime_now_newyork > session_end_datetime){
				// saveTimeSpentOnSession();
			}


		},1000);
		// Swal.fire(
		// 	'INFO',
		// 	'Be sure to unmute the player located on the bottom right side of the page.',
		// 	'warning'
		// );

	}

	// setInterval(saveTimeSpentOnSession, 1000); //Saving total time every 5 minutes as a backup

	function initiateTimerRecorder() {
		getTimeSpentOnSession();
	}

	initiateTimerRecorder();

	/******* End of saving time spent on session - by Rexter ************/

	/******* Update session history - by Rexter ************/
	function update_viewsessions_history_open()
	{
		$.ajax({
			url: base_url+"/sessions/update_viewsessions_history_open/"+sessionId,
			type: "post",
			data: {'logs_id': $("#logs_id").val()},
			dataType: "json",
			success: function (data) {

			}
		});
	}


	function calcTime(offset) {
		// create Date object for current location
		var d = new Date();

		// convert to msec
		// subtract local time zone offset
		// get UTC time in msec
		var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

		// create new Date object for different city
		// using supplied offset
		var nd = new Date(utc + (3600000*offset));

		return nd;
	}

	function get_sessions_history_open(sessionId){
		var resolution = screen.width + "x " + screen.height + "y";
		$.ajax({
			url: project_url+"/sessions/add_viewsessions_history_open",
			type: "post",
			data: {'sessions_id': sessionId, 'resolution': resolution},
			dataType: "json",
			success: function (data) {
				console.log('get_sessions_history_open');
				$("#logs_id").val(data.logs_id);
			}
		});
		return false;
	}

	/******* End of saving time spent on session - by Rexter ************/

	function play_music() {
		var audio = document.getElementById("audio_"+<?=$this->project->id?>);
		audio.play();
	}
	function stop_music() {
		var audio1 = document.getElementById("audio_"+<?=$this->project->id?>);
		audio1.pause();
		audio1.currentTime = 0;
	}

	/** Live user count **/
	$(function () {
		socket.emit(`ycl_session_active_users`, `${projectId}_${sessionId}`);
	});

	function ask_a_rep(){
		//Ask a rep
		$('#askARepSendBtn').on('click', function () {

			let rep_type = $('input[name=ask_rep_radio]:checked').val();

			$.post(project_url+"/sessions/ask_a_rep",
				{
					rep_type: rep_type,
					user_id: uid,
					session_id: sessionId
				})
				.done(function( data ) {
					data = JSON.parse(data);
					$('.ask-a-rep').html(data.msg);
				})
				.fail(function() {
					$('.ask-a-rep').html('Unable to request, please try again.');
				});

		});
	}

</script>
