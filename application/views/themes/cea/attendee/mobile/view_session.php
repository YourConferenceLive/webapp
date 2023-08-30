
<section class="parallax" style="background-color: #FFFFFF;" >
    <!--<section class="parallax" style="background-image: url(<?= base_url() ?>front_assets/images/Sessions_BG_screened.jpg); top: 0; padding-top: 0px;">-->
    <div class="container-fluid">
        <!-- CONTENT -->
        <section class="content">
            <div>
                <div class="videContent">

                        <div class="row row1 justify-content-center">
                            <div class="col-12" style="margin-top: 30px; margin-left: 20px; margin-right: 20px;">
                                <div class="card m-auto text-center">
                                    <div class="row">
                                        <div class="col-sm-12 " style="margin: 30px 0px" >
                                            <h6 style="color:#EF5D21; font-size: 18px">Welcome to the</h6>
                                            <h4  style="color:#EF5D21"><b><?=$this->project->name?> Learner Resource App</b></h4>
                                            <div style="height: 1px;background-color: #EF5D21;" class="my-3"></div>

                                            <?php if(isset($session) && !empty($session)): ?>
<!--													--><?php //echo "<pre>"; print_r($session);  exit?>
                                                <b><p class="mx-3" id="sessionTitle" style="font-size: 25px; line-height: 1.2"><?=$session->name?></b>
                                                <?php if(isset ($session->presenters) && !empty($session->presenters)): ?>
                                                    <?php foreach ($session->presenters as $presenter):?>
                                                        <div id="moderators" style="font-size: 18px;">
                                                            <?=$presenter->name.' '.$presenter->surname.', '.$presenter->credentials?>
                                                        </div>
                                                    <?php endforeach;?>
                                                <?php endif ?>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row row2 d-flex justify-content-center mb-3">
                            <div class="col-12" style=" margin-left: 20px; margin-right: 20px;">
                                <div class="card text-center align-items-center justify-content-center align-content-center mx-auto mt-2" style="background-image: url(https://yourconference.live/CCO/front_assets/images/bg_login.png); top: 0; padding-top: 0px; height: 100%; background-size: cover">
                                    <?php if($session->header_question == 1):?>
                                    <button id="resource-btn" type="button"  class="btn btn-sm text-white" style="width: 95%; height: 70px; margin-top: 30px; <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; font-size: 20px; font-weight: 700">Resources <i class="fas fa-paperclip"></i></button>
                                    <?php endif; ?>
<!--                                    <button id="notes-btn" class="btn btn-sm mt-2 text-white" style="width: 80%; height: 30px; background-color: #EF5D21;">Take Notes <i class="far fa-edit"></i></button>-->
                                    <?php if($session->right_sticky_question == 1):?>
                                        <button id="question-btn" class="btn btn-sm mt-3 text-white" style="width: 95%; height: 70px;  <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; font-size: 20px; font-weight: 700">Ask a Question <i class="fas fa-question"></i></button>
                                    <?php endif; ?>
                                    <?php if ($session->claim_credit_link && $session->claim_credit_link!=='') {
                                    if ($session->claim_credit_url !== '') {
                                    ?>
                                    <button onclick="window.open('<?=isset($session->claim_credit_url)?$session->claim_credit_url:''?>', '_blank')" class="btn btn-sm mt-3 text-white" style="width: 95%; height: 70px; <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>; font-size: 20px; font-weight: 700" ><?=($session->claim_credit_link !== '')?$session->claim_credit_link:''?></button>
                                    <?php }} ?>

                                    <?php if(isset($isSessionWithPoll) && !empty($isSessionWithPoll)) : ?>
                                        <button id="polling-guide-btn" style="width: 95%; height: 70px;  <?= ($view_settings)?($view_settings[0]->stickyIcon_color!='')? 'background-color:'.$view_settings[0]->stickyIcon_color:'#EF5D21':'#EF5D21'?>;font-size: 20px; font-weight: 700" class="btn btn-sm mt-3 text-white" >Polling Guide <i class="fa fa-book"></i></button>
                                    <?php endif ?>

                                    <!-- <button id="live_support-btn" onclick="openLiveSupportChat()" style="display:block;width: 95%; height: 70px; margin-bottom: 30px; background-color: #EF5D21;font-size: 20px; font-weight: 700" class="btn btn-sm mt-3 text-white" >Live Technical Support <i class="far fa-life-ring"></i></button> -->
                                    <div class="mb-3"></div>
                                </div>
                            </div>

                        </div>
                        <div class="modal fade" id="viewPollModal" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none; text-align: left; margin-top: 50px !important;" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog" style="overflow-y: initial !important">
                                <div class="modal-content" style="padding: 0px; border: 0px solid #999; border-radius: 15px;">
                                    <div class="modal-header" style="height: 0">
                                        <button type="button" class="poll-modal-close close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!--                                                <div class="modal-header" style="padding: 0px;">
                                                                                                    <img class="kent_logo" src="<?= base_url() ?>assets/images/logo.png" alt="MLG">
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                </div>-->
                                    <div class="modal-body" style="padding: 0px; max-height: 80vh; overflow-y: auto; overflow-x:hidden">
                                        <div class="row" style="padding-top: 0px; padding-bottom: 20px;">
                                            <div class="col-sm-12">
                                                <div class="" id="timer_sectiom" style="padding-top: 0px; padding-bottom: 0px; display: none; border-top-right-radius: 15px; border-top-left-radius: 15px; background-color: #ebeaea; ">
                                                    <div class=""  style="text-align: right; font-size: 20px; font-weight: 700; border-top-right-radius: 15px; border-top-left-radius: 15px;  ">
                                                        TIME LEFT : <span id="id_day_time" style=" font-size: 20px; font-weight: 700; color: #ef5e25; padding: 0px 10px 0px 0px;"></span>
                                                    </div>
                                                </div>
                                                <div id="poll_vot_section" style="padding: 0px 0px 0px 0px; margin-top: 0px; background-color: #fff; border-radius: 15px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <p class="currentTime">
                        CURRENT TIME : <span id="show_time"></span> EDT <a class="button color currentTimeButton" id="close_session"><span>Close the Session</span></a>

                    </p>

                        <span class="borderFooter">test</span>
                    </p>-->

                    <div class="col-md-12">
                        <?php
                        if (isset($music_setting)) {
                            if ($music_setting->music_setting != "") {
                                ?>
                                <audio allow="autoplay" id="audio" src=""></audio>
                                <?php
                            }
                        }
                        ?>
                        <input type="hidden" id="view_sessions_history_id" value="">
                        <input type="hidden" id="sessions_id" value=" <?= isset($sessions) ? $sessions->id : "" ?>">
                        <input type="hidden" id="poll_vot_section_id_status" value="0">
                        <input type="hidden" id="poll_vot_section_is_ended" value="0">
                        <input type="hidden" id="poll_vot_section_last_status" value="0">
                        <!--                                    <div class="col-md-3">
                                                                <div id="poll_vot_section" style="padding: 0px 0px 0px 0px; margin-top: 10px; background-color: #fff; border-radius: 5px;">
                                                                </div>
                                                            </div>-->


                    </div>

                </div>

            </div>

        </section>
        <!-- END: SECTION -->


<script src="<?=base_url()?>theme_assets/cea/assets/js/mobile/sessions.js"></script>
<script src="<?=base_url()?>theme_assets/cea/assets/js/mobile/attendee_to_admin_chat.js"></script>
<script src="<?=base_url()?>theme_assets/cea/assets/js/mobile/front_assets/view_session.js"></script>
<script>
    let projectId = "<?=$this->project->id?>";
    let sessionId = "<?=$session->id?>"
    let session_id = "<?=$session->id?>"
	var note_page = 1;
   	let attendee_Fname = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['name'] ?>";
	let attendee_Lname = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['surname'] ?>";
	let attendee_FullName = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['name'].' '.$_SESSION['project_sessions']["project_{$this->project->id}"]['surname'] ?>";
	let uid = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] ?>";
	let room_id = "<?=($session->room_id && $session->room_id !== null) ? $session->room_id : ''?>"

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
</script>
<script>
$(function(){
	$('#question-btn').on('click', function(){

		$('.stickyQuestionbox').css('display', 'block');
		// $('.stickyNotesbox').css('display','none');
		$('.resourcesStickybox').css('display','none');
	});


	$('#resource-btn').on('click', function(){

		$('.stickyQuestionbox').css('display', 'none');
		// $('.stickyNotesbox').css('display','none');
		$('.resourcesStickybox').css('display','block');
	});

	$('#question-btn').on('click', function(){

		$('.stickyQuestionbox').css('display', 'block');
		// $('.stickyNotesbox').css('display','none');
		$('.resourcesStickybox').css('display','none');
		$('.resourcesStickybox').css('display','none');
	});

	$('#polling-guide-btn').on('click', function(){
		$('#pollGuideModal').modal('show');
	})

	$('#askQuestionBtn').on('click', function(){
		$('#questionText').trigger($.Event('keyup', { which: 13, key: 'Enter' }));
	})


	$('#questionText').on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$('#questionText').prop('disabled', true);

			let question = $(this).val();
			let sessionId = "<?=$session->id?>";

			if(question == '') {
				toastr.warning('Please enter your question');
				return false;
			}

			$.post(project_url+"/mobile/sessions/askQuestionAjax",{
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
							toastr.error(msg);
					}

					$('#questionText').prop('disabled', false);

				}).fail((error)=>{
                    toastr.error(msg);
				$('#questionText').prop('disabled', false);
			});
		}
	});

	$("#returnBtn").on('click', function(){
		window.location.href = project_url+"/mobile/sessions/room/"+room_id;
	})

})

$(function(){
		$(document).on("click", "#questions_clapping", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_sad", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_happy", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_laughing", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_thumbs_up", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_thumbs_down", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#clapping", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#sad", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#happy", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#laughing", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#thumbs_up", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#thumbs_down", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});
	})


	// Poll


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
						} else {
							toastr.error("Error");
						}
					}
			});
		});

		socket.on('ycl_launch_poll', (data)=>{
			$('#voteBtn').html('<i class="fas fa-vote-yea"></i> Vote')
			if(data.session_id == sessionId) {

				$('#pollId').val(data.id);
				$('#pollQuestion').html(data.poll_question);
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

			}

			markLaunchedPoll(data.id)
		});

		socket.on('start_poll_timer_notification', (data)=> {
			console.log(data);
			if($('#pollId').val() == data.id) {
				var timeleft = data.timer;
				var downloadTimer = setInterval(function () {
					// play_music();
					if (timeleft <= 0) {
						// stop_music();
						clearInterval(downloadTimer);
						// $('#pollModal').modal('hide');
						$('#howMuchSecondsLeft').hide();
						$('#voteBtn').attr('disabled', 'disabled');
						$('#pollModal').modal('hide');
						if (data.show_result == 1) {// Show result automatically
							$.get(project_url + "/mobile/sessions/getPollResultAjax/" + data.id, function (results) {
								show_poll_result(results)

								var resultTimeleft = 5;
								var resultTimer = setInterval(function () {
									if (resultTimeleft <= 0) {
										// stop_music();
										clearInterval(resultTimer);
										$('#pollResultModal').modal('hide');
									} else {
										$('#howMuchSecondsLeftResult').text(resultTimeleft + ((resultTimeleft <= 1)?" second left":"  seconds left"));
									}
									resultTimeleft -= 1;
								}, 1000);
							});
						}
					} else {
						$('#voteBtn').removeAttr('disabled')
						$('#howMuchSecondsLeft').show();
						$('#howMuchSecondsLeft').text(timeleft + ((timeleft <= 1)?" second left":"  seconds left"));
					}
					timeleft -= 1;
				}, 1000);
			}
		});

		socket.on('ycl_launch_poll_result', (data)=>{
			
			if(data.session_id == sessionId) {
				$('#pollModal').modal('hide');
				$('#pollResultModalLabel').html(data.poll_question);
				$.get(project_url+"/mobile/sessions/getPollResultAjax/"+data.poll_id, function (results) {
					show_poll_result(results)
				}).then(function(obj,results){
					obj = JSON.parse(obj);
					if(obj.poll_correct_answer1 !== '0' || obj.poll_correct_answer2 !== '0' ) {
						$('.progress-label').attr('style', 'margin-left:30px')
					}else{
						$('.progress-label').attr('style', '')
					}
					if(obj.poll_correct_answer1 || obj.poll_correct_answer2 ) {
						if(obj.poll_correct_answer1 !== 0  || obj.poll_correct_answer2 !== 0) {
							// console.log('tdsadsa');
							//
							$('#group-' + obj.poll_correct_answer1).prepend('<i class="fas fa-check text-success"></i>').css('color','green');
							$('#group-' + obj.poll_correct_answer2).prepend('<i class="fas fa-check text-success"></i>').css('color','green');

							$('#group-' + obj.poll_correct_answer1).find('label').attr('style', 'margin-left: 8px')
							$('#group-' + obj.poll_correct_answer2).find('label').attr('style', 'margin-left: 8px')
						}
					}
				});
			}
		});

		socket.on('ycl_close_poll_result', (data)=>{
			if(data.session_id == sessionId) {
				$('#pollResultModal').modal('hide');
			}
		});
	});

	function show_poll_result(results){
		$('#howMuchSecondsLeftResult').text("");
			results = JSON.parse(results);
					$('#pollResults').html('');
					// console.log(results);

					if(results.poll_type === 'poll' || results.poll_type === 'presurvey') {
						$.each(results.poll, function (poll_id, option_details) {
							$('#pollResults').append('' +
								'<div class="form-group" id="group-'+option_details.option_order+'">' +
								'  <label class="form-check-label progress-label">'+option_details.option_name+'</label>' +
								'  <div class="progress" style="height: 20px;">' +
								'    <div class="progress-bar" role="progressbar" style="width: '+((option_details.vote_percentage !== undefined)? option_details.vote_percentage  : 0 )+'%;" aria-valuenow="'+((option_details.vote_percentage !== undefined)? option_details.vote_percentage : 0) +'" aria-valuemin="0" aria-valuemax="100">'+((option_details.vote_percentage !== undefined)? option_details.vote_percentage: 0)+'%</div>' +
								'    <div class="progress-bar" role="progressbar" style="background-color:#007BFF; opacity:0.2; width: '+((option_details.vote_percentage !== undefined)? 100 - option_details.vote_percentage  : 100 )+'%;" aria-valuenow="'+((option_details.vote_percentage !== undefined)? 100-option_details.vote_percentage : 100) +'" aria-valuemin="0" aria-valuemax="100"></div>' +
								'  </div>' +
								'</div>');
						});
						$('#legend').html('');

					}else {
						$.each(results.poll, function (poll_id, option_details) {
							// console.log(option_details);
							$('#pollResults').append('' +
								'<div class="form-group " id="group-'+option_details.option_order+'" >' +
								'  <label class="form-check-label progress-label">' + option_details.option_name + '</label>' +
								' <div class="progress_section" id="progress-section-'+option_details.option_order+'"> ' +
								'	<div class="progress  mb-1" style="height: 20px;">' +
								'    	<div class="progress-bar" role="progressbar" style="width: ' + ((option_details.vote_percentage !== undefined)? option_details.vote_percentage: 0)+ '%;" aria-valuenow="' + ((option_details.vote_percentage !== undefined)? option_details.vote_percentage: 0) + '" aria-valuemin="0" aria-valuemax="100">' + ((option_details.vote_percentage !== undefined)? option_details.vote_percentage: 0) + '%</div>' +
								'    	<div class="progress-bar" role="progressbar" style="background-color:#007BFF; opacity: 0.2; width: ' + ((option_details.vote_percentage !== undefined)? 100 - option_details.vote_percentage: 100)+ '%;" aria-valuenow="' + ((option_details.vote_percentage !== undefined)? 100 - option_details.vote_percentage: 100) + '" aria-valuemin="0" aria-valuemax="100"></div>' +
								'	</div> ' +
								'</div>' +
								'</div>');

						});
						$.each(results.compere, function (poll_id, option_details) {
							$('#progress-section-'+option_details.option_order).prepend(
								'	<div class="progress mb-1" style="height: 20px;">' +
								'    	<div class="progress-bar bg-info" role="progressbar" style="width: ' + option_details.vote_percentage_compare + '%;" aria-valuenow="' + option_details.vote_percentage_compare + '" aria-valuemin="0" aria-valuemax="100">' + option_details.vote_percentage_compare + '%</div>' +
								'    	<div class="progress-bar" role="progressbar" style="background-color:#17A2B8; opacity: 0.2; width: ' + (100-option_details.vote_percentage_compare) + '%;" aria-valuenow="' + (100-option_details.vote_percentage_compare) + '" aria-valuemin="0" aria-valuemax="100"></div>' +
								'	</div> '
							);
						});

						$('#legend').html(
							'<span class="mr-4"><i style="width:20px; height:20px;" class="fa-solid fa-square bg-info text-info d-inline-block "></i> Presurvey</span>' +
							'<span><i  style="width:20px; height:20px;" class="fa-solid fa-square bg-primary text-primary d-inline-block "></i> Assessment</span>'
						)
					}

					$('#pollResultModal').modal({
						backdrop: 'static',
						keyboard: false
					});
	}

	socket.on('poll_close_notification', (data)=>{
		if(data.session_id == sessionId) {
			$('#pollModal').modal('hide');
		}
	});

	socket.on('reload-attendee-signal', function () {
			// location.reload();session_end_datetime
		const sessionEnd = new Date(session_end_datetime);
	
		console.log('end'+ sessionEnd)
		console.log('now'+ new Date())
		
		if(sessionEnd < new Date() ){
			window.location = (project_url+"/mobile/sessions/room/<?=$session->room_id?>")
		}else{
			location.reload();
		}
			
		});

	function markLaunchedPoll(poll_id){
		$.post(project_url+"/mobile/sessions/markLaunchedPoll/"+poll_id, function (results) {
			console.log(results)
		});
	}

	
	/******* Saving time spent on session - by Rexter ************/

	function saveTimeSpentOnSessionAfterSessionFinished(){
		$.ajax({
			url: project_url+"/mobile/sessions/saveTimeSpentOnSession/"+sessionId+'/'+uid,
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
			url: project_url+"/mobile/sessions/saveTimeSpentOnSession/"+sessionId+'/'+uid,
			type: "post",
			data: {'time': timeSpentUntilNow},
			dataType: "json",
			success: function (data) {
				update_viewsessions_history_open();
			}
		});

	}

	function getTimeSpentOnSession(){
		$.ajax({
			url: project_url+"/mobile/sessions/getTimeSpentOnSession/"+sessionId+'/'+uid,
			type: "post",
			dataType: "json",
			success: function (data) {
				timeSpentOnSessionFromDb = parseInt(data);
				startCounting();
				saveTimeSpentOnSession();
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
				saveTimeSpentOnSession();
			}


		},1000);
		// Swal.fire(
		// 	'INFO',
		// 	'Be sure to unmute the player located on the bottom right side of the page.',
		// 	'warning'
		// );

	}

	setInterval(saveTimeSpentOnSession, 30000); //Saving total time every 5 minutes as a backup

	function initiateTimerRecorder() {
		getTimeSpentOnSession();
	}

	initiateTimerRecorder();

	/******* End of saving time spent on session - by Rexter ************/

	/******* Update session history - by Rexter ************/
	function update_viewsessions_history_open()
	{
		$.ajax({
			url: project_url+"/mobile/sessions/update_viewsessions_history_open/"+sessionId,
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
			url: project_url+"/mobile/sessions/add_viewsessions_history_open",
			type: "post",
			data: {'sessions_id': sessionId, 'resolution': resolution},
			dataType: "json",
			success: function (data) {

				console.log(data);
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


$(function(){
		$(document).on("click", "#questions_clapping", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_sad", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_happy", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_laughing", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_thumbs_up", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_thumbs_down", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#clapping", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#sad", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#happy", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#laughing", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#thumbs_up", function () {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#thumbs_down", function () {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});
	})
</script>

