<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($user);exit("</pre>");
// print_r($settings);exit;
?>
<style>
	#questions-tab-content, #starred-questions-tab-content{
		font-size:1.5rem
	}
	#pollModal{
		font-family: "Open Sans", Helvetica, Arial, sans-serif;
	}
</style>
	
<main>
	<div class="card">
		<div class="card-header">
			<h3>Attendee Questions</h3>
		</div>
		<div class="card-body">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="question-tab" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="true">Questions</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="favorites-tab" data-toggle="tab" href="#favorites" role="tab" aria-controls="favorites" aria-selected="false">Favorites</a>
			</li>
			</ul>
			<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
				<div id="chatBody" class="panel-body">
					<div id="questions-tab-content" style="height:73vh; overflow-y:auto; overflow-x:hidden"></div>
				</div>
			</div>
			<div class="tab-pane fade" id="favorites" role="tabpanel" aria-labelledby="favorites-tab">
				<div id="chatBody" class="panel-body">
					<div id="starred-questions-tab-content" style="height:73vh; overflow-y:auto; overflow-x:hidden"></div>
				</div>
			
			</div>
			</div>
		</div>
		<div class="card-footer">
			
		</div>
	</div>
</main>
<!-- Direct attendee chat modal -->
<div class="modal fade" id="attendeeChatModal" tabindex="-1" role="dialog" aria-labelledby="attendeeChatModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="min-width:100vw; min-height:90vh">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="attendeeChatModalLabel" style="font-size:30px">Chat with <span id="chatAttendeeName"></span></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="user-question" style="font-size:30px">Question: <span id="chattAttendeeQuestion" ></span><br></div><br>
			<div class="attendeeChatmodal-body card " style="height:55vh; overflow: auto">
				<div class="panel panel-default">
					<div id="attendeeChatModalBody" class="panel-body attendeeChatModalBody">

					</div>
				</div>
			</div>
			<div class="col-md-12 mb-2" style="height:300px">
				<div style="height:30px"> <span class="typing-icon" style="display:none">Someone is typing <span style="" class="dot-flashing"></span></span>
				</div>
				<div class="input-group">
					<input id="chatToAttendeeText" type="text" class="form-control" placeholder="Enter your message">
					<span class="input-group-btn">
                                <button id="sendMessagetoAttendee" class="btn btn-success" type="button"><i class="fas fa-paper-plane"></i> Send</button>
                            </span>
				</div>
			</div>
			<div class="modal-footer">
				<button id="endChatBtn" type="button" class="btn btn-danger" userId=""><i class="fas fa-times-circle"></i> End Chat</button>
				<button type="button" class="btn btn-info" data-dismiss="modal"><i class="fas fa-folder-minus"></i> Minimize</button>
			</div>
		</div>
	</div>
</div>

<script>
	let controllerPath = project_presenter_url;

	let projectId = "<?=$this->project->id?>";
	let session_id = "<?=$session->id?>";

	let user_id = "<?=$user->user_id?>";
	let user_name = "<?=$user->name?> <?=$user->surname?>";
	let user_photo = "<?=$user->photo?>";

	<?php
	$dtz = new DateTimeZone($this->project->timezone);
	$time_in_project = new DateTime('now', $dtz);
	$gmtOffset = $dtz->getOffset( $time_in_project ) / 3600;
	$gmtOffset = "GMT" . ($gmtOffset < 0 ? $gmtOffset : "+".$gmtOffset);
	$timezone = (isset($settings->time_zone) && !empty($settings->time_zone)) ? $settings->time_zone:'';

	?>
	let session_start_datetime = "<?= date('M j, Y H:i:s', strtotime($session->start_date_time)).' '.(($timezone != '') ? $timezone : $gmtOffset ) ?>";
	let session_end_datetime = "<?= date('M j, Y H:i:s', strtotime($session->end_date_time)).' '.(($timezone != '') ? $timezone : $gmtOffset ) ?>";

	$(function(){
		fillQuestions();
		fillSavedQuestions();
			socket.on('ycl_session_question', function (data) {
				if (data.sessionId == session_id)
				{
					console.log(data.question_id);
					fillQuestions();
			
				}
			});
			
			$('#questions-tab-content').on('click','.questionList', function(e){
				e.preventDefault();

				let sender_id = $(this).attr('sender_id');
				let sender_name = $(this).attr('sender_name');
				let sender_surname = $(this).attr('sender_surname');
				let question_selected = $(this).attr('question');
				let question_id = $(this).attr('question-id');

				questionListClick(sender_id,sender_name,sender_surname,question_selected, question_id)
			})

			$('#starred-questions-tab-content').on('click','.questionList', function(e){
				e.preventDefault();

				let sender_id = $(this).attr('sender_id');
				let sender_name = $(this).attr('sender_name');
				let sender_surname = $(this).attr('sender_surname');
				let question_selected = $(this).attr('question');

				questionListClick(sender_id,sender_name,sender_surname,question_selected)
			})

			$('#chatToAttendeeText').on('input', function(){
				let question_id = $(this).attr('question-id');
				socket.emit('typing-attendee-admin-chat',{
					'userType': 'presenter',
					'user_id': user_id,
					'project_id': project_id,
					'question_id': question_id,
				})
			})

			socket.on('typing-attendee-admin-chat-notification', function(data){
				// console.log($('#attendeeChatModal').attr('question-id'));
				if(data.user_id !== user_id && data.project_id === project_id){
					// console.log(data.question_id);
					if(data.question_id == $('#attendeeChatModal').attr('question-id')){
						let timeout = 1000;
						$('.typing-icon').css('display', 'block')
						setTimeout(function () {
							$('.typing-icon').css('display', 'none')
						}, timeout);
					}

				}
			})

			$('#sendMessagetoAttendee').on('click', function(){
				let chat = $('#chatToAttendeeText').val();
				let sender_id = $(this).attr('sender_id');
				let question_id = $(this).attr('question_id')
				if(chat == ''){
					toastr.info('Cannot send empty message');
					return false;
				}
				let url = project_presenter_url+"/sessions/save_presenter_attendee_chat";

				$.get(project_presenter_url+"/sessions/markQuestionReplied/"+question_id,function( data ) {
					});

				$.post(url,
					{
						'chat': chat,
						'sender_id': sender_id,
						'session_id': session_id
					}, function(response){
						// console.log(response);
						if(response.status == 'success') {

							socket.emit('new-attendee-to-admin-chat', {"session_id":session_id, "sent_from":"admin", "sender_id": sender_id, "chat_text":chat, "from_id": user_id, 'presenter_name': user_name });
							socket.emit('update-admin-attendee-chat');

							$('#attendeeChatModalBody').append('<span class="admin-to-attendee-chat btn btn-warning float-right mr-2 my-1" style="width:90%"><span style="float: right; text-right margin-left:5px"><strong>' + user_name + ': </strong>' + chat + '</span></span>')
							$('#chatToAttendeeText').val('');


							$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight);
						}else{
							toastr.error(response.status)
						}
				}, 'json')

				fillQuestions()
			})

			socket.on('update-admin-attendee-chat', function(){
				fillQuestions()
			})

			socket.on('new-attendee-to-admin-chat-notification', function (data) {
				// console.log(data);
					if (data.sent_from == 'attendee')
					{
						admin_chat_presenter_ids=data.cp_ids;
						if(data.cp_ids.includes(user_id)){
							attendeeChatPopup(data.from_id, data.user_name);
						}
					}
			});

			$('#questions-tab-content').on('click', '.save-question', function(){
			let that = this;
			let question_id = $(this).attr('question-id');

			$.post(project_presenter_url+'/sessions/saveQuestionAjax/',
					{
						'question_id':question_id
					},function(response){
					if(response){
						console.log(response);
						fillSavedQuestions();
						socket.emit('presenter_like_questions', {
							"type": "like",
							"question": response,
						});
						$(that).html('<i style="color:yellow" class="fas fa-star"></>')
					}
						// console.log(response);
				})
			})

			$('#questions-tab-content').on('click', '.hide-question', function(){
				let question_id = $(this).attr('question-id');

				$.post(project_presenter_url+'/sessions/hideQuestionAjax/',
					{
						'question_id':question_id
					},function(response){
						// console.log(response);
					if(response){
						fillQuestions();
					}
					})
			})

			$('#starred-questions-tab-content').on('click', '.hide-saved-question', function(){
				let question_id = $(this).attr('question-id');

				Swal.fire({
					title: 'Remove From Starred Question',
					text: 'This starred question will be removed on admin and presenter',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, Remove it!',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						$.post(project_presenter_url+'/sessions/hideSavedQuestionAjax/',
							{
								'question_id':question_id
							},function(response){
								if(response){
									fillSavedQuestions();
									$('#save-question-'+question_id).children().removeClass('fas fa-star').addClass('far fa-star')
									toastr.success("Starred question removed successfully");
								}else{
									toastr.error("Something went wrong");
								}
							})
					}
				})
				
			})

	})

	function fillQuestions() {
		$.get(project_presenter_url+"/sessions/getQuestionsAjax/"+session_id, function (questions) {
			questions = JSON.parse(questions);
			console.log(questions)
			$('#questions-tab-content').html('');
			$.each(questions, function (poll_id, question) {
				let comment_icon_btn = ''
				if(question.marked_replied == 1){
					comment_icon_btn = '<span class=""><i class="fas fa-comment-dots" title="Marked replied"></i></span>'
				}
				$('#questions-tab-content').prepend('' +
						'<div class="container-fluid mr-2">' +
						'<div class="row" style="padding-right: 15px">' +
						'<div class="col-7">' +
						'<strong></strong>' +
						'</div>' +
						'<div class="col-3">' +
						'<small class="text-secondary"></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary hide-question" id="hide-question-'+question.id+'" question-id="'+question.id+'"><i class="fas fa-ban" style="color: red; cursor: pointer;"></i></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<span class="text-secondary save-question" id="save-question-'+question.id+'" question-id="'+question.id+'">'+((question.isOnSaveQuestion == "1")?'<i class="fas fa-star" style="color: yellow; cursor: pointer;"></i>':'<i class="far fa-star" style="color: yellow;cursor: pointer;"></i>')+'</span>' +
						'</div>' +
						'</div>' +
						'<div class="row">' +
						'<div class="col-12"><a class="questionList" href="#" style="cursor:pointer" question-id="'+question.id+'" question="'+question.question+'" session_id="'+session_id+'" sender_id="'+question.user_id+'" sender_name="'+question.user_name+'" sender_surname="'+question.user_surname+'">'+question.user_name+' '+ question.user_surname+' '+comment_icon_btn+'</a></div>' +
						'<div class="col-12">'+question.question+'</div>' +
						'</div>' +
						'<div class="col"><hr></div>');
			});

		});
	}

	
	function fillSavedQuestions() {
		$.get(project_presenter_url+"/sessions/getSavedQuestions/"+session_id, function (questions) {
			questions = JSON.parse(questions);
			console.log(questions)
			// console.log(questions)
			$('#starred-questions-tab-content').html('');
			$.each(questions.data, function (poll_id, question) {
				// console.log(question)
				$('#starred-questions-tab-content').prepend('' +
					'<div class="container-fluid mr-2">' +
					'<div class="row" style="padding-right: 15px">' +
					'<div class="col-7">' +
					'<strong></strong>' +
					'</div>' +
					'<div class="col-3">' +
					'<small class="text-secondary"></small>' +
					'</div>' +
					'<div class="col-1">' +
					'<small class="text-secondary hide-saved-question" id="hide-saved-question-'+question.id+'" question-id="'+question.question_id+'"><i class="fas fa-ban" style="color: red; cursor: pointer;"></i></small>' +
					'</div>' +
					// '<div class="col-1">' +
					// '<small class="text-secondary save-question" id="'+question.id+'" question-id="'+question.id+'"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>' +
					// '</div>' +
					'</div>' +
					'<div class="row">' +
					'<div class="col-12"><a class="questionList" href="#" style="cursor:pointer" question-id="'+question.id+'" question="'+question.question+'" session_id="'+session_id+'" sender_id="'+question.user_id+'" sender_name="'+question.q_from_name+'" sender_surname="'+question.q_from_surname+'" >'+question.q_from_name+' '+ question.q_from_surname+'</a></div>' +
					'<div class="col-12">'+question.question+'</div>' +
					'</div>' +
					'<div class="col"><hr></div>');
			});

		});
	}

	function attendeeChatPopup(attendee_id, attendee_name, attendee_question, question_id){

		$('#attendeeChatModalLabel').html("Chat With: "+attendee_name);
		$('#chattAttendeeQuestion').text(attendee_question);
		$('#chattAttendeeQuestion').attr('question-id', question_id)
		$('#sendMessagetoAttendee').attr('sender_id', attendee_id);
		$('#endChatBtn').attr('userId', attendee_id);


		$.post(project_presenter_url+"/sessions/getAttendeeChatsAjax/",

			{
				session_id: session_id,
				sender_id: attendee_id,
			}

		).done(function(response) {
				response = JSON.parse(response)
				if (response.status == 'success') {
					$('#attendeeChatModalBody').html('');
					$.each(response.chats, function (i, chat) {
						if (chat.sent_from == 'admin' || chat.sent_from == 'presenter') {
							if (chat.sent_from == 'presenter') {
								$('#attendeeChatModalBody').append('<span class="attendee-to-admin-chat btn btn-warning mr-2 m-1 float-right" style="width:90%"><span style="float: right; margin-left:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span>')
							} else {
								$('#attendeeChatModalBody').append('<span class="attendee-to-admin-chat btn btn-warning mr-2 m-1 float-right" style="width:90%"><span style="float: right; margin-left:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span>')
							}
						} else {
							$('#attendeeChatModalBody').append('<span class="admin-to-attendee-chat btn btn-primary float-left ml-2 m-1" style="width:90%"><span style="float: left; text-right margin-right:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span>')
						}
					});
					$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight + 100);
				}
			}
		).fail((error)=>{
			toastr.error('Unable to load the chat.');
		});

		$('#attendeeChatModal').modal('show');
		$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight + 100);
	}

	function questionListClick(sender_id, sender_name, sender_surname, question_selected, question_id)
	{

		// console.log(question_id);
		$('#sendMessagetoAttendee').attr(
			{
				'sender_id': sender_id,
				'sender_name': sender_name,
				'sender_surname': sender_surname,
				'question_id': question_id
			});

		$('#chatToAttendeeText').attr('question-id', question_id)

		$.post(project_presenter_url+'/sessions/getAttendeeChatsAjax/',
			{
				'sender_id': sender_id,
				'session_id': session_id
			}, function(response){
				response = JSON.parse(response)
				$('#attendeeChatModalBody').html('');
				if(response.status == 'success'){
					$('#attendeeChatModalBody').html('');
					$.each(response.chats, function(i, chat){
						// console.log(chat);

						if(chat.sent_from == 'attendee'){
							$('#attendeeChatModalBody').append('<span class="attendee-to-admin-chat btn btn-primary ml-2 my-1" style="width:90%"><span style="float: left; margin-right:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span><br><span class="float-right" style="margin-right:73px; margin-top: -8px">'+chat.date_time+'</span><br>')
						}else{
							$('#attendeeChatModalBody').append('<span class="admin-to-attendee-chat btn btn-warning float-right mr-2 my-1" style="width:90%"><span style="float: right; text-right margin-left:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span><br><span class="float-left" style="margin-left:73px; margin-top: -8px; margin-bottom:20px">'+chat.date_time+'</span><br><br>')
						}
					})
				}
			})


		$('#attendeeChatModalLabel').html('Chat With: '+sender_name+' '+sender_surname)
		$('#chattAttendeeQuestion').html(question_selected);
		$('#attendeeChatModal').attr('question-id', question_id)
		$('#attendeeChatModal').modal('show');

		$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight);
	}

	$('#endChatBtn').on('click', function () {

		let userId = $(this).attr('userId');

		Swal.fire({
			title: 'Are you sure?',
			text: 'Ending chat will disable attendee from sending you texts until you texts attendee.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, end it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				socket.emit('end-attendee-to-admin-chat', {"session_id":session_id, "from_id":"admin", "to_id":userId});

				$('#attendeeChatModal').modal('hide');
			}
		})
		
	});



</script>