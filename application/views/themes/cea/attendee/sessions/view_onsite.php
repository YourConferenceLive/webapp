<?php
defined('BASEPATH') or exit('No direct script access allowed');
//print_r($_SESSION['project_sessions']["project_{$this->project->id}"]);exit;

?>
<style>
	body {
		overflow: hidden;
		background-color: #151515;
		font-family: "Open Sans", Helvetica, Arial, sans-serif
	}
	#pollResultModal, #pollModal{
		font-size: 2rem !important;
	}
	#pollModal input[type="radio"]{
		width:25px;
		height:40px
	}
	#pollModal label{
		margin-left: 10px !important;
	}
</style>

<link href="<?= ycl_root ?>/theme_assets/<?= $this->project->theme ?>/assets/css/sessions.css?v=<?= rand() ?>" rel="stylesheet">

<div class="sessions-view-container container-fluid p-0">

</div>

<?php if (isset($view_settings) && !empty($view_settings[0]->poll_music)):
		if ($view_settings[0]->poll_music != "") : ?>
			<audio allow="autoplay" id="audio_<?=$this->project->id?>" src="<?= ycl_root.'/cms_uploads/projects/'.$this->project->id.'/sessions/music/'.$view_settings[0]->poll_music ?>" ></audio>

<?php endif; endif ?>

<input type="hidden" id="logs_id" value="">
<style>
	.list-group {
		overflow: auto;
		height: 100px;
	}

	.list-group-item:nth-child(odd) {
		background-color: #FFFFFF;
	}

	.list-group-item:nth-child(even) {
		background-color: #ECECEC;
	}
</style>
<!--<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dRp5VbWCQ3A?playlist=dRp5VbWCQ3A&controls=1&autoplay=1&mute=1&loop=1"></iframe>-->

<script src="<?= ycl_root ?>/theme_assets/<?= $this->project->theme ?>/assets/js/sponsor/sessions.js?v=<?= rand() ?>"></script>
<script src="<?= ycl_root ?>/theme_assets/<?= $this->project->theme ?>/assets/js/common/sessions/attendee_to_admin_chat.js?v=<?= rand() ?>"></script>
<script src="<?= ycl_root ?>/theme_assets/<?= $this->project->theme ?>/assets/js/common/sessions/custom_full_screen.js?v=<?= rand() ?>"></script>

<script type="application/javascript">
	let projectId = "<?= $this->project->id ?>";
	let sessionId = "<?= $session->id ?>";
	var note_page = 1;
	let attendee_Fname = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['name'] ?>";
	let attendee_Lname = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['surname'] ?>";
	let attendee_FullName = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['name'] . ' ' . $_SESSION['project_sessions']["project_{$this->project->id}"]['surname'] ?>";
	let uid = "<?= $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] ?>";

	var timeSpentOnSessionFromDb;
	var timeSpentUntilNow;

	<?php
	$dtz = new DateTimeZone($this->project->timezone);
	$time_in_project = new DateTime('now', $dtz);
	$gmtOffset = $dtz->getOffset($time_in_project) / 3600;
	$gmtOffset = "GMT" . ($gmtOffset < 0 ? $gmtOffset : "+" . $gmtOffset);
	?>

	let session_start_datetime = "<?= date('M j, Y H:i:s', strtotime($session->start_date_time)) . ' ' . $gmtOffset ?>";
	let session_end_datetime = "<?= date('M j, Y H:i:s', strtotime($session->end_date_time)) . ' ' . $gmtOffset ?>";

	function loadNotes(entity_type, entity_type_id, note_page) {
		Swal.fire({
			title: 'Please Wait',
			text: 'Loading notes...',
			imageUrl: '<?= ycl_root ?>/cms_uploads/projects/<?= $this->project->id ?>/theme_assets/loading.gif',
			imageUrlOnError: '<?= ycl_root ?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		$.ajax({
			type: "GET",
			url: project_url + "/eposters/notes/" + entity_type + '/' + entity_type_id + '/' + note_page,
			data: '',
			success: function(response) {
				Swal.close();
				jsonObj = JSON.parse(response);
				// Add response in Modal body
				if (jsonObj.total) {
					var iHTML = '<ul class="list-group">';

					for (let x in jsonObj.data) {
						let note_id = jsonObj.data[x].id;
						let note = jsonObj.data[x].note_text.replace(/(?:\r\n|\r|\n)/g, '<br>');
						let datetime = jsonObj.data[x].time;

						iHTML += '<!-- Start List Note ' + (x) + ' --><li class="list-group-item p-1">' + ((note.length > 20) ? note.substr(0, 20) + '&hellip; <a href="javascript:void(0);" class="note_detail" data-note-text="' + note + '">more&raquo;</a>' : note) + '</li>';
					}

					iHTML += '</ul>';

					$('#notes_list_container').html(iHTML);
				} else {}
			}
		});
	}

	//Load div when Iframe is ready;
	$('#sessionIframe').on('load', function() {
		$('#embededVideo').css('display', 'block');
	})

	$(function() {
		ask_a_rep();
		iframeResize();
		$(window).on('resize', function() {
			iframeResize();
		});

		$('.sendQuestionBtn').on('click', function() {
			var e = $.Event("keyup");
			e.keyCode = 13;
			$('#questionText').trigger(e);
		})

		$('#questionText').on('keyup', function(e) {
			if (e.key === 'Enter' || e.keyCode === 13) {
				$('#questionText').prop('disabled', true);

				let question = $(this).val();
				let sessionId = "<?= $session_id ?>";

				if (question == '') {
					toastr.warning('Please enter your question');
					return false;
				}

				$.post(project_url + "/sessions/askQuestionAjax", {
						session_id: sessionId,
						question: question,
					},
					function(response) {
						response = JSON.parse(response);
						console.log(response.data);
						if (response.status == 'success') {
							socket.emit("ycl_session_question", {
								sessionId: sessionId,
								question: question,
								sender_name: attendee_Fname,
								sender_surname: attendee_Lname,
								sender_id: uid,
								question_id: (response.data) ? response.data : ''

							});

							$('#questionText').val('');
							$('#questionElement').prepend('<p>' + question + '</p>');
							toastr.success("Question sent");
						} else {
							toastr.error("Unable to send the question");
						}

						$('#questionText').prop('disabled', false);

					}).fail((error) => {
					toastr.error("Unable to send the question");
					$('#questionText').prop('disabled', false);
				});
			}
		});
	});

	function iframeResize() {
		let totalHeight = window.innerHeight;
		let menuHeight = document.getElementById('mainMenu').offsetHeight;
		let iFrameHeight = totalHeight - menuHeight;

		$('#sessionIframe').css('height', iFrameHeight + 'px');
	}

	$(function() {

		get_sessions_history_open(sessionId);

		$('#notes_list_container').on('click', '.note_detail', function(e) {
			$('#noteModal').modal('hide');
			let note_text = $(this).data('note-text');
			$('.modal-body .note-text').text(note_text);
			$('#noteModal').modal('show');
			$('#pollModal').modal('hide');
			$('#pollResultModal').modal('hide');
		});

		$('#briefcase_send').on('click', function() {
			let entity_type = 'session';
			let entity_type_id = $('#session_id').val();
			let note_text = $('#briefcase').val();

			if (entity_type_id == '' || note_text == '') {
				toastr.error('Invalid request.');
				return;
			}

			Swal.fire({
				title: 'Please Wait',
				text: 'Posting your notes...',
				imageUrl: '<?= ycl_root ?>/cms_uploads/projects/<?= $this->project->id ?>/theme_assets/loading.gif',
				imageUrlOnError: '<?= ycl_root ?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			let formData = new FormData();
			formData.append("entity_type_id", entity_type_id);
			formData.append("origin_type", entity_type);
			formData.append("notes", $('#briefcase').val());

			$.ajax({
				type: "POST",
				url: project_url + "/eposters/add_notes/session",
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

		socket.on('ycl_launch_poll', (data) => {
			// $('#voteBtn').html('<i class="fas fa-vote-yea"></i> Vote')
			if (data.session_id == sessionId) {

				$('#pollId').val(data.id);
				$('#pollQuestion').html(data.poll_question);
				$('#howMuchSecondsLeft').text('');

				$('#pllOptions').html('');
				$.each(data.options, function(key, option) {
					$('#pllOptions').append('' +
						'<div class="form-check mb-2">' +
						'  <input class="form-check-input" type="radio" name="poll_option" value="' + option.id + '">' +
						'  <label class="form-check-label">' + option.option_text + '</label>' +
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

		socket.on('start_poll_timer_notification', (data) => {
			console.log(data);
			if ($('#pollId').val() == data.id) {
				var timeleft = data.timer;
				var downloadTimer = setInterval(function() {
					play_music();
					if (timeleft <= 0) {
						stop_music();
						clearInterval(downloadTimer);
						// $('#pollModal').modal('hide');
						$('#howMuchSecondsLeft').hide();
						$('#voteBtn').attr('disabled', 'disabled');
						$('#pollModal').modal('hide');
						if (data.show_result == 1) { // Show result automatically
							$.get(project_url + "/sessions/getPollResultAjax/" + data.id, function(results) {
								results = JSON.parse(results);

								$('#pollResults').html('');
								$('#pollResultModalLabel').text(data.poll_question);
								$.each(results, function(poll_id, option_details) {
									$('#pollResults').append('' +
										'<div class="form-group">' +
										'  <label class="form-check-label">' + option_details.option_name + '</label>' +
										'  <div class="progress" style="height: 25px;">' +
										'    <div class="progress-bar" role="progressbar" style="width: ' + option_details.vote_percentage + '%;" aria-valuenow="' + option_details.vote_percentage + '" aria-valuemin="0" aria-valuemax="100">' + option_details.vote_percentage + '%</div>' +
										'  </div>' +
										'</div>');
								});

								$('#pollResultModal').modal({
									backdrop: 'static',
									keyboard: false
								});

								var resultTimeleft = 5;
								var resultTimer = setInterval(function() {
									if (resultTimeleft <= 0) {
										stop_music();
										clearInterval(resultTimer);
										$('#pollResultModal').modal('hide');
									} else {
										$('#howMuchSecondsLeftResult').text(resultTimeleft + ((resultTimeleft <= 1) ? " second left" : "  seconds left"));
									}
									resultTimeleft -= 1;
								}, 1000);
							});
						}
					} else {
						$('#voteBtn').removeAttr('disabled')
						
						$('#howMuchSecondsLeft').show();
						$('#howMuchSecondsLeft').text(timeleft + ((timeleft <= 1) ? " second left" : "  seconds left"));
					}
					timeleft -= 1;
				}, 1000);
			}
		});

		socket.on('ycl_launch_poll_result', (data) => {if(data.session_id == sessionId) {
				$('#pollModal').modal('hide');
				$('#pollResultModalLabel').html(data.poll_question);
				$.get(project_url+"/sessions/getPollResultAjax/"+data.poll_id, function (results) {
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

		socket.on('ycl_close_poll_result', (data) => {
			if (data.session_id == sessionId) {
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

	socket.on('poll_close_notification', (data) => {
		if (data.session_id == sessionId) {
			$('#pollModal').modal('hide');
		}
	});

	function markLaunchedPoll(poll_id) {
		$.post(project_url + "/sessions/markLaunchedPoll/" + poll_id, function(results) {
			console.log(results)
		});
	}

	$(function() {
		Swal.fire(
			'INFO',
			'Be sure to unmute the player located on the bottom right side of the page.',
			'warning'
		);

		let header_toolbox_status = "<?= (isset($session->header_toolbox_status) ? $session->header_toolbox_status : '') ?>";
		let header_question = "<?= (isset($session->header_question) ? $session->header_question : '') ?>"
		let header_notes = "<?= (isset($session->header_notes) ? $session->header_notes : '') ?>"
		let header_resources = "<?= (isset($session->header_resources) ? $session->header_resources : '') ?>"
		let header_askrep = "<?= (isset($session->header_askrep) ? $session->header_askrep : '') ?>"
		let right_sticky_resources = "<?= (isset($session->right_sticky_resources) ? $session->right_sticky_resources : '') ?>"
		let right_sticky_question = "<?= (isset($session->right_sticky_question) ? $session->right_sticky_question : '') ?>"
		let right_sticky_notes = "<?= (isset($session->right_sticky_notes) ? $session->right_sticky_notes : '') ?>"
		let right_sticky_askrep = "<?= (isset($session->right_sticky_askrep) ? $session->right_sticky_askrep : '') ?>"
		let claim_credit_link = "<?= (isset($session->claim_credit_link) ? $session->claim_credit_link : '') ?>"
		let claim_credit_url = "<?= (isset($session->claim_credit_url) ? $session->claim_credit_url : '') ?>"

		// console.log('res'+header_resources);
		if (header_toolbox_status == 0) {
			$('#header-toolbox').css('display', 'none')
		} else {
			$('#header-toolbox').css('display', 'block')
		}

		if (header_question == 0) {
			$('#questionStickyMenu').css('display', 'none')
		} else {
			$('#questionStickyMenu').css('display', 'block')
		}

		if (header_notes == 0) {
			$('#notesStickyMenu').css('display', 'none')
		} else {
			$('#notesStickyMenu').css('display', 'block')
		}

		if (header_resources == 0) {
			$('#resourcesStickyMenu').css('display', 'none')
		} else {
			$('#resourcesStickyMenu').css('display', 'block')
		}

		if (header_resources == 0) {
			$('#resourcesStickyMenu').css('display', 'none')
		} else {
			$('#resourcesStickyMenu').css('display', 'block')
		}

		if (header_askrep == 0) {
			$('#askARepStickyMenu').css('display', 'none')
		} else {
			$('#askARepStickyMenu').css('display', 'block')
		}


		if (right_sticky_resources == 0) {
			$('#resourcesSticky').css('display', 'none')
			$('li[data-type][data-type="resourcesSticky"]').hide();
		} else {
			$('#resourcesSticky').css('display', 'block')
		}

		if (right_sticky_question == 0) {
			$('#questionsSticky').css('display', 'none')
			$('li[data-type][data-type="questionsSticky"]').hide();
		} else {
			$('#questionsSticky').css('display', 'block')
		}

		if (right_sticky_notes == 0) {
			$('#notesSticky').css('display', 'none')
			$('li[data-type][data-type="notesSticky"]').hide();
		} else {
			$('#notesSticky').css('display', 'block')
		}

		if (right_sticky_askrep == 0) {
			$('#askARepSticky').css('display', 'none')
			$('li[data-type][data-type="askARepSticky"]').hide();
		} else {
			$('#askARepSticky').css('display', 'block')
		}

		if (claim_credit_link !== '') {
			$('#header_claim_credit').css('display', 'block')
			$('.claim_credit_href').attr('href', claim_credit_url);
			$('#header_claim_credit_link').html(claim_credit_link);
		} else {
			$('#header_claim_credit').css('display', 'none')
		}

		socket.on('reload-attendee-signal', function() {
			update_viewsessions_history_open();
			saveTimeSpentOnSessionAfterSessionFinished();

		});

	})


	/******* Saving time spent on session - by Rexter ************/

	function saveTimeSpentOnSessionAfterSessionFinished() {
		$.ajax({
			url: project_url + "/sessions/saveTimeSpentOnSession/" + sessionId + '/' + uid,
			type: "post",
			data: {
				'time': timeSpentUntilNow
			},
			dataType: "json",
			success: function(data) {
				location.reload();
			}
		});
	}

	function getTimeSpentOnSiteFromLocalStorage() {
		timeSpentOnSite = parseInt(localStorage.getItem('timeSpentOnSite'));
		timeSpentOnSite = isNaN(timeSpentOnSite) ? 0 : timeSpentOnSite;
		return timeSpentOnSite;
	}

	function saveTimeSpentOnSession() {
		// console.log(timeSpentUntilNow)
		$.ajax({
			url: project_url + "/sessions/saveTimeSpentOnSession/" + sessionId + '/' + uid,
			type: "post",
			data: {
				'time': timeSpentUntilNow
			},
			dataType: "json",
			success: function(data) {
				update_viewsessions_history_open();
			}
		});

	}

	function getTimeSpentOnSession() {
		$.ajax({
			url: project_url + "/sessions/getTimeSpentOnSession/" + sessionId + '/' + uid,
			type: "post",
			dataType: "json",
			success: function(data) {
				timeSpentOnSessionFromDb = parseInt(data);
				startCounting();
				saveTimeSpentOnSession();
				return parseInt(data);
			}
		});

	}

	function startCounting() {
		timeSpentUntilNow = timeSpentOnSessionFromDb;
		onSessiontimer = setInterval(function() {
			var datetime_now_newyork = calcTime('-5');
			if (datetime_now_newyork >= session_start_datetime && datetime_now_newyork <= session_end_datetime)
				timeSpentUntilNow = timeSpentUntilNow + 1;
			if (datetime_now_newyork > session_end_datetime) {
				saveTimeSpentOnSession();
			}


		}, 1000);
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
	function update_viewsessions_history_open() {
		$.ajax({
			url: project_url + "/sessions/update_viewsessions_history_open/" + sessionId,
			type: "post",
			data: {
				'logs_id': $("#logs_id").val()
			},
			dataType: "json",
			success: function(data) {

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
		var nd = new Date(utc + (3600000 * offset));

		return nd;
	}

	function get_sessions_history_open(sessionId) {
		var resolution = screen.width + "x " + screen.height + "y";
		$.ajax({
			url: project_url + "/sessions/add_viewsessions_history_open",
			type: "post",
			data: {
				'sessions_id': sessionId,
				'resolution': resolution
			},
			dataType: "json",
			success: function(data) {

				console.log(data);
				$("#logs_id").val(data.logs_id);
			}
		});
		return false;
	}

	/******* End of saving time spent on session - by Rexter ************/

	function play_music() {
		var audio = document.getElementById("audio_<?=$this->project->id?>");
		audio.play();
	}

	function stop_music() {
		var audio1 = document.getElementById("audio_<?=$this->project->id?>");
		audio1.pause();
		audio1.currentTime = 0;
	}

	/** Live user count **/
	$(function() {
		socket.emit(`ycl_session_active_users`, `${projectId}_${sessionId}`);
	});

	function ask_a_rep() {
		//Ask a rep
		$('#askARepSendBtn').on('click', function() {

			let rep_type = $('input[name=ask_rep_radio]:checked').val();

			$.post(project_url + "/sessions/ask_a_rep", {
					rep_type: rep_type,
					user_id: uid,
					session_id: sessionId
				})
				.done(function(data) {
					data = JSON.parse(data);
					$('.ask-a-rep').html(data.msg);
				})
				.fail(function() {
					$('.ask-a-rep').html('Unable to request, please try again.');
				});

		});
	}
	//######## Emoji functions
	$(function() {
		$(document).on("click", "#questions_clapping", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_sad", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_happy", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_laughing", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_thumbs_up", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#questions_thumbs_down", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#clapping", function() {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#sad", function() {
			var value = $(this).attr("data-title_name");
			var questions = $("#questionText").val();
			if (questions != "") {
				$("#questionText").val(questions + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#happy", function() {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#laughing", function() {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#thumbs_up", function() {
			var value = $(this).attr("data-title_name");
			var send_message = $("#questionText").val();
			if (send_message != "") {
				$("#questionText").val(send_message + ' ' + value);
			} else {
				$("#questionText").val(value);
			}
		});

		$(document).on("click", "#thumbs_down", function() {
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
