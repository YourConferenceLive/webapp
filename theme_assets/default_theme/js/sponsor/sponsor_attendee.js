$(document).ready(function () {
	get_resource_files();
	get_sponsor_group_chat();
	get_sponsor_attendee_chat();
	//  ############### Group Chat Message  ################
	$('.send-group-message').on('click', function () {
		var url = "/sponsor/save_sponsor_group_chat/";
		var chat_text = $('#group-chat-text').val();
		if(chat_text.trim()==""){
			return false;
		}

		$.post(project_url+url,{
			'booth_id':current_booth_id,
			'chat_text':chat_text
		}, function(success){
			if(success=="success"){

				$('.group-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img src="https://via.placeholder.com/150" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>'+current_user_fullname+'</b></span><span class="float-left "><small>'+date_now+'<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">'+chat_text+'</div></div></div></div></div><br>');
				$('#group-chat-text').val("");
				toastr['success']('message sent');
			}else{
				toastr["error"]("Problem sending chat!");
			}
		});


	});

	$('.upload_photo').on('change', function () {
		var file = this.files[0];
		var type=$(this).attr("data-type");
		var form_data=new FormData();
		form_data.append("file",file)
		form_data.append("project_id",project_id)
		form_data.append("current_booth_id",current_booth_id)
		form_data.append("type",type)

		$.ajax({
			url: project_url + "/sponsor/admin/home/upload_booth_photos/",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			success: function (response) {
				if(response){
					$(`#${type}`).attr("src",URL.createObjectURL(file));
				}
			}
		});

	});

	$('.save_tv_url').on('click', function () {
		var tv_url=$("#tv_url");
		console.log(tv_url.val());
		$.ajax({
			url: project_url + "/sponsor/admin/home/change_booth_url/",
			data: {
				tv_url:tv_url.val(),
				current_booth_id:current_booth_id
			},
			type: 'post',
			success: function (response) {

			}
		});

	});


	$('#group-chat-text').keypress(function (e) {
		var key = e.which;
		if(key==13){
			$('.send-group-message').click();
		}
	});

	function get_sponsor_group_chat(){
		var url = "/sponsor/get_sponsor_group_chat/";
		$.post(project_url+url,{'booth_id':current_booth_id},function(success){

		}).done(function(datas){
			// console.log(datas);
			datas = JSON.parse(datas);
			if(datas.status !=="error") {

				$.each(datas.result, function (index, data) {
					if (data.chat_from == current_user_id) {

						$('.group-chat-body').append('<div class="card group-outgoing-message w-90 float-right  mb-3 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right">'+data.name+' '+data.surname+'</span><span class="float-left text-white-50"><small>' + data.date_time + ' <i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col  text-right">' + data.chat_text + '</div></div></div></div></div><br>');
					} else {
						$('.group-chat-body').append('<div class="card group-incoming-message w-90  float-left  mb-3 pl-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left text-white">'+data.name+' '+data.surname+'</span><span class="float-right text-white-50"><small>' + data.date_time + ' <i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">' + data.chat_text + '</div></div></div></div></div>')
					}
				});
			}else{
				return false;
			}
		});
	}

	//  ############### End Group Chat Message  ################
	// ###############  Sponsor CHAT MESSAGE #####################
	$('.send-sponsor-message').on('click', function () {
		var chat_text = $('#sponsor-chat-text').val();
		var url = "/sponsor/save_sponsor_attendee_chat/";

		if(chat_text.trim()==""){
			toastr['error']('cannot send empty message');
			return false;
		}

		$.post(project_url+url, { 'chat_text':chat_text, 'booth_id':current_booth_id }, function(success){
			// console.log(success);
			if(success=='success'){

				$('.sponsor-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img src="https://via.placeholder.com/150" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>'+current_user_fullname+'</b></span><span class="float-left "><small>'+date_now+'<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">'+chat_text+'</div></div></div></div></div><br>');
				$('#sponsor-chat-text').val("");
				toastr['success']('message sent');
			}else{
				toastr['error']('unable to send message');
			}
		})



	});

	$('#sponsor-chat-text').keypress(function (e) {
		var key = e.which;
		if(key==13){
			$('.send-sponsor-message').click();
		}
	});

	function get_sponsor_attendee_chat(){

		$.post(project_url+"/sponsor/get_sponsor_attendee_chat/",
			{
				'booth_id':current_booth_id,
			},
			function(){

			}).done(function(datas){

					datas = JSON.parse(datas)

					if(datas.status=='success'){
						$.each(datas.result, function(index,data){
							// console.log(data);
							if(data.chat_from == "attendee"){
								$('.sponsor-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  mb-3 pr-2 text-white shadow-lg" ><div class="row"><div class="col"><span class="float-right"><img src="https://via.placeholder.com/150" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right">'+data.full_name+'</span><span class="float-left text-white-50"><small>'+data.date_time+' <i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col text-right">'+data.chat_text+'</div></div></div></div></div><br>');
							}else{
								$('.sponsor-chat-body').append('<div class="card sponsor-incoming-message w-90 float-left  mb-3 pl-2 text-white shadow-lg " data-to_id="'+data.to_id+'"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left text-white">'+data.full_name +'</span><span class="float-right text-white-50"><small>'+data.date_time+' <i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">'+data.chat_text+'</div></div></div></div></div>');
							}
						});
					}else{

					}

				});
			}

	// ############### End Sponsor CHAT MESSAGE #####################

	function get_resource_files(){
		$.post(project_url+"/sponsor/get_resource_files/",
			{
				'booth_id':current_booth_id
			},
			function(){
		}).done(function(datas){
			$('.resources-body').html('');
			datas = JSON.parse(datas);

			if(datas.status=="success"){


				$.each(datas.result, function (index,data){
					console.log(data);
					var extension = data.file_name.substr( (data.file_name.lastIndexOf('.') +1) );
					var icon;
					var hover = data.screen_name;
					if(extension == "docx") {
						icon = "fa-file-word";
					}
					else if(extension == "jpg") {
						icon = "fa-image";
					}
					else if(extension == "pdf") {
						icon = "fa-file-pdf";
					}
					else if(extension == "xls" || extension=="xlxs") {
						icon = "fa-file-excel";
					}
					else if(extension == "txt" ) {
						icon = "fa-file-alt";
					}
					else if(extension == "ppt" || extension == "pptx") {
						icon = "fa-file-powerpoint";
					}
					else {
						icon = "fa-question-circle";
					}
					$('.resources-body').append('<div class=" col-md-6 "><div class="card col-md-12 w-100 p-0 my-1"><div class="card-header bg-light-blue w-100 p-1 text-blue " style="cursor: pointer" title="' + hover + '" data-toggle="collapse" data-target="#resource_screen_name_' + data.id + '"><span class="fa ' + icon + ' text-info"></span> ' + data.resource_name + '<span class="fa fa-caret-down float-right text-blue"></span></div><div class="card-body collapse align-content-center" id="resource_screen_name_' + data.id + '"><div class="">' + data.screen_name + '</div><a target="_blank" href="' + ycl_root + '/cms_uploads/projects/' + project_id + '/sponsor_assets/uploads/resource_management_files/' + data.file_name + '" download="' + data.screen_name + '"  class="btn btn-success btn-sm float-right ml-2"><small><span class="fas fa-download"> </span> Open</small> </a> <a class="btn btn-info btn-sm float-right " id="btn-add-to-bag" data-sponsor_resource_id="' + data.id + '" ><small>Add to Sponsor bag</small></a></div></div></div>')
				});
			}else{
				return false;
			}
		});
	}


	$('#schedule-a-meet').click(function(){
		var modal='modal-schedule-meet';
		get_sponsor_list(modal);

		$("#modal-schedule-meet #date-time-picker").val('Select sponsor admin to book');
		$("#modal-schedule-meet #date-time-picker").prop('disabled', true);
		$('#modal-schedule-meet').modal('show');
	});

	function get_sponsor_list(modal){

		$.post(project_url+"/sponsor/get_sponsor_list/",
		{
			'booth_id':current_booth_id
		},
			function (success)
			{
			}).done(function(datas){

			$('#'+modal+ ' #sponsor-list').html('<option val="" disabled selected>Select sponsor</option>');
				datas = JSON.parse(datas);
				$.each(datas.result, function(index, data){

					$('#'+modal+ ' #sponsor-list').append('<option id="sponsor-list-option sponsor-list_'+data.sponsor_id+'" data-sponsor_id = "'+data.sponsor_id+'" >'+data.sponsor_name+'</option>');
				});
		});
	}

	$('#modal-schedule-meet').on('change','#sponsor-list',function(){

		var sponsor_id = $('#sponsor-list option:selected').data('sponsor_id');


		$.post(project_url+"/sponsor/getAvailableDatesOf/",
			{
				'booth_id': current_booth_id,
				'sponsor_id': sponsor_id,
			},
			function(dates){

				var enableDays = JSON.parse(dates);

				if (typeof(enableDays[0]) == 'undefined' || enableDays[0] == ''){
					$("#modal-schedule-meet #date-time-picker").val('No dates available!');
					$("#modal-schedule-meet #date-time-picker").prop('disabled', true);
					return false;
				}

				$("#modal-schedule-meet #date-time-picker").prop('disabled', false);
				$("#modal-schedule-meet #date-time-picker").val('');
				console.log(enableDays[0]);


				$.post( project_url+"/sponsor/getTimeSlotByDateOf",
					{
						'booth_id': current_booth_id,
						'sponsor_id': sponsor_id,
						'date': enableDays[0]
					},

					function(times){
						var enableTimes = JSON.parse(times);

						function enableAllTheseDays(date) {
							let d = new Date(Date.parse(date));
							var sdate = (d.getFullYear() + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2));
							//var sdate = date.format( 'yy/mm/dd');
							if($.inArray(sdate, enableDays) != -1) {
								return [true];
							}
							return [false];
						}

						$("#modal-schedule-meet #date-time-picker").datetimepicker({
							timepicker: true,
							beforeShowDay: enableAllTheseDays,
							allowTimes: enableTimes,
							onSelectDate:function(date,$i){
								let d = new Date(Date.parse(date));
								var sdate = (d.getFullYear() + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2));

								$.post( project_url+"/sponsor/getTimeSlotByDateOf",
									{
										'booth_id': current_booth_id,
										'sponsor_id': sponsor_id,
										'date': enableDays[0]
									},
									function(times){
										var enableTimes = JSON.parse(times);
										console.log(enableTimes);
										$("#modal-schedule-meet #date-time-picker").datetimepicker('setOptions', {allowTimes:enableTimes});
									});
							}
						});
					});
			});
	});

	$('#modal-schedule-meet ').on('click', '.book-meet-btn',function () {
		var sponsor_id = $('#sponsor-list option:selected').data('sponsor_id');
		var meetingDateTime = $('#date-time-picker').val();

		if (meetingDateTime == 'No dates available!' || meetingDateTime == '' || meetingDateTime=='Select sponsor admin to book')
			return;


		console.log(sponsor_id);
		let from = new Date(Date.parse(meetingDateTime));
		var sfdate = (from.getFullYear() + '/' + ('0' + (from.getMonth()+1)).slice(-2) + '/' + ('0' + from.getDate()).slice(-2) +' '+ from.getHours()+':'+(from.getMinutes()<10?'0':'') + from.getMinutes());
		var to = from;
		to.setMinutes(from.getMinutes()+30);
		var stdate = (to.getFullYear() + '/' + ('0' + (to.getMonth()+1)).slice(-2) + '/' + ('0' + to.getDate()).slice(-2) +' '+ to.getHours()+':'+to.getMinutes());
		var sttime = to.getHours()+':'+ (to.getMinutes()<10?'0':'') + to.getMinutes();

		Swal.fire({
			title: 'Are you sure?',
			html: "<h5>You are about to book a meeting with " +
				"<span style='color: #047d20'>"+company_name+"</span><br>" +
				"On <span style='color: #0f3e68'>"+sfdate+"</span> To <span style='color: #00a5b3'>"+sttime+"</span></h5>",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, book it!',
			cancelButtonText: 'No, go back!'
		}).then((result) => {
			if (result.value) {

				$.post(project_url+"/sponsor/makeBooking",
					{
						'sponsor_id': sponsor_id,
						'booth_id': current_booth_id,
						'meet_from': sfdate,
						'meet_to': stdate
					},
					function(data, status){
						if(status == 'success')
						{
							data = JSON.parse(data);

							if (data.status == 'success')
							{
								Swal.fire(
									'Booked!',
									data.message,
									'success'
								);
								$('#modal-schedule-meet').modal('hide');
							}
							else if(data.status == 'error')
							{
								Swal.fire(
									'Sorry!',
									data.message,
									'warning'
								)
							}
							else
								{
								Swal.fire(
									'Oh no!',
									data.message,
									'error'
								)
							}
						}
						else
							{
							toastr["error"]("Network problem!");
						}
					});

			}
		})
	});

	$('.resources-body').on('click','#btn-add-to-bag',function(){

		var resource_id = $(this).attr('data-sponsor_resource_id');

		Swal.fire({
			title: '<small>You can insert a note</small>',
			input: 'text',
			inputPlaceholder: "Insert a note",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Save',
			cancelButtonText: 'Cancel!',
			showLoaderOnConfirm: true
		}).then((result) => {
			if(result.isConfirmed)
			{
			$.post(project_url+"/sponsor/get_resource_by_id",
				{
					'resource_id':resource_id,
					'note':result.value
				},
				function(response)
				{
					if(response.status == 'success')
					{
						Swal.fire(
							'Success',
							response.message,
							'success'
						);
					}
					else if(response.status == 'exist')
					{
						Swal.fire(
							'Notification',
							response.message,
							'info'
						);
					}
					else
						{
						Swal.fire(
							'Error',
							'Problem adding to bag',
							'error'
						);
					}
				},'json');
			}
		});
	})

	$('.fish-bowl').click(function(){

		$.post(project_url+"/sponsor/save_fishbowl_card",
			{
				'booth_id':current_booth_id
			},
			function(result){
				if(result.status=="success"){
					toastr['success']('Card added to fishbowl!');
				}else{
					toastr['error']('Problem adding card to fishbowl');
				}
		},'json');
	});


});
