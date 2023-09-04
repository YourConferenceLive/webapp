<style>
    .chat_with_admin_body{
        padding: 5px 3px;
        max-height: 400px;
        min-height: 310px;
        overflow: auto;

    }
    .admin-to-user-text {
        color: white;
        background-color: #df941f;
        text-align: left;
        display: list-item;
        list-style: none;
        margin-top: 7px;
        margin-bottom: 7px;
        padding-left: 12px;
        border-radius: 15px;
        margin-right: 40px;
    }
    .user-to-admin-text {
        color: white;
        background-color: #1f8edf;
        text-align: left;
        display: list-item;
        list-style: none;
        margin-top: 7px;
        margin-bottom: 7px;
        padding-left: 12px;
        border-radius: 15px;
        margin-left: 40px;
    }
    .live-support-text-attendee{
        margin-bottom: 20px !important;
    }
    .live-support-text-admin{
        margin-bottom: 20px !important;
    }
    .progress_bar_new{
        padding-top: 10px;
    }
    .poll-modal-close{
        padding-top: 0 !important;
    }
    .chat_with_admin_body{
        max-height: 275px;
    }
</style>
<div class="row stickyQuestionbox" style="display: none">
    <div class="col d-flex" >
        <div  class="fixed-bottom " >
            <div class="card " style="height: 400px; width: 100%; left:0%; ">
                <div class="card-header text-white" style="<?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; font-size: 22px">Ask a Question <i class="fas fa-question"></i><button id="stickyQuestionboxHide" class="btn fa fa-minus float-right text-white shadow-none"></button></div>
                <div class="content">
					<div class="contentHeader" style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:'':''?>;"><?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></div>
					<div id="questionElement" class="questionElement" style="overflow: scroll;height: 170px;"></div>
					<div id="ask_questions_section" style="background-color: #fff; border-radius: 5px; position: absolute; bottom: 0; width: 100%;">
						<div style="padding:5px;">
							<div style="text-align: center; display: flex; " id="questions_section">
								<div class="col-md-10 input-group">
									<span class="input-group-addon" style="padding: 5px 6px"><img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/happy.png" id="questions_emjis_section_show" title="Check to Show Emoji" data-questions_emjis_section_show_status="0" style="width: 20px; height: 20px;" alt=""/></span>
									<input type="text" id="questionText" class="form-control" placeholder="Press enter to send..." value="">
								</div>
								<a id="askQuestionBtn" class="button color btn text-white" style=" <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; margin: 0px; text-wrap:nowrap" id="ask_questions_send"><span><i class="fas fa-paper-plane"></i> Send</span></a>
							</div>
							<div style="text-align: left; padding-left: 10px; display: flex;" id="questions_emojis_section">
								<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/happy.png" title="Happy" id="questions_happy" data-title_name="&#128578;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
								<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/sad.png" title="Sad" id="questions_sad" data-title_name="&#128543" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
								<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/laughing.png" title="Laughing" id="questions_laughing" data-title_name="😁" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
								<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/thumbs_up.png" title="Thumbs Up" id="questions_thumbs_up" data-title_name="&#128077;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
								<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/thumbs_down.png" title="Thumbs Down" id="questions_thumbs_down" data-title_name="&#128078" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
								<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/assets/images/emoji/clapping.png" title="Clapping" id="questions_clapping" data-title_name="&#128079;" style="width: 40px; height: 40px; padding: 5px;" alt=""/>
							</div>
							<span id='error_questions' style='color:red;'></span>
							<span id='success_questions' style='color:green;'></span>
						</div>
					</div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row stickyNotesbox" style="display: none">
    <div class="col d-flex" >
        <div  class="fixed-bottom " >
            <div class="card " style="height: 300px; width: 100%; left:0%; ">
                <div class="card-header text-white" style=" <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>;">Add Notes <button id="stickyNotesboxHide" class="btn fa fa-minus float-right text-white shadow-none"></button></div>
                <div class="content" style="">
                    <div id="briefcase_section">
                        <div id="briefcase_section">
                            <div class="col-md-12 input-group">
                                <textarea type="text" id="briefcase" class="form-control" placeholder="Enter Note" value="" style="background-color: #FFFFFF"><?= isset($sessions_notes_download) ? $sessions_notes_download : "" ?></textarea>
                            </div>
                            <a class="button btn" style=" <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>;"  id="briefcase_send"><span>Save</span></a>
                            <!-- <a class="button btn btn-info" id="downloadbriefcase"><span>Download</span></a> -->
                        </div>
                        <span id='error_briefcase' style='color:red;'></span>
                        <span id='success_briefcase' style='color:green;'></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row adminChatStickyIcon" id="adminChatStickyIcon" style="display: none">
    <div class="col d-flex" >
        <div  class="fixed-bottom " >
            <div class="card " style="height: 400px; width: 100%; left:0%; ">
                <div class="card-header text-white" style=" <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; font-size: 22px">Chat with Admin <button id="adminChatStickyboxHide" class="btn fa fa-minus float-right text-white shadow-none"></button></div>
                <div class="content">
                    <div class="chat_with_admin_body">
                    </div>

                    <div class="input-group">
                        <input type="text" class="form-control shadow-none" placeholder="Enter message" id='chat_with_admin_text'>
                        <button class="btn text-white" id="sendAdminChatBtn" style=" <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>;">Send <i class="fas fa-paper-plane-o"></i></button>
                    </div>



                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Poll Guide -->
<div class="modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Modal body text goes here.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<div class="row resourcesStickybox" style="display: none">
    <div class="col d-flex" >
        <div  class="fixed-bottom " >
            <div class="card " style="height: 400px; width: 100%; left:0%; ">
                <div class="card-header text-white" style=" <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; font-size: 22px">Resources <i class="fas fa-paperclip"></i><button id="resourcesStickyboxHide" class="btn fa fa-minus float-right text-white shadow-none"></button></div>
                        <?php
                        if (!empty($session_resource)) {
                            foreach ($session_resource as $val) {
                                if($val->is_active == 1){
                                ?>
                                <div class="row" style="margin-bottom: 10px; padding-bottom: 5px">
                                    <?php if ($val->resource_type == "url") { ?>
                                        <div class="col-md-12"><a class="resources-link-text" href="<?= $val->resource_path ?>" target="_blank" style="<?= ($view_settings)?( $view_settings[0]->stickyIcon_color!='')? 'color:'.$view_settings[0]->stickyIcon_color:'':''?>; font-size: 22px"><?= $val->resource_name ?></a></div>
                                    <?php } ?>
                                    <?php
                                    if ($val->resource_type == "file") {
                                        if ($val->resource_path != "") {
											$ext = pathinfo($val->resource_path, PATHINFO_EXTENSION);
											$resource_name = str_replace(' ', '_', $val->resource_name).'.'.$ext;

                                            ?>
                                            <div class="col-md-12"><a class="resources-link-text" href="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/resources/<?= $val->resource_path ?>" download="<?= $resource_name ?>" style="color: #EF5D21 !important; font-size: 22px"> <?= $val->resource_name ?> </a></div>
                                            <?php
                                        }
                                    }
                                
                                    ?>
                                </div>
                                <?php
                                }
                            }
                        }
                        ?>
            </div>
        </div>

    </div>
</div>

<script>
    $(function(){
        $('#stickyQuestionboxHide').on('click', function(){
            $('.stickyQuestionbox').css('display', 'none');
        })

        $('#stickyNotesboxHide').on('click', function(){
            $('.stickyNotesbox').css('display', 'none');
        })

        $('#adminChatStickyboxHide').on('click', function(){
            $('.adminChatStickybox').css('display', 'none');
        })

        $('#liveSupportChatFormHide').on('click', function(){
            $('#liveSupportChatForm').css('display', 'none');
        })

        $('#resourcesStickyboxHide').on('click', function(){
            $('.resourcesStickybox').css('display', 'none');
        })

        $('#adminChatStickyboxHide').on('click', function(){
            $('.adminChatStickyIcon').css('display', 'none');
        })

    })

</script>
