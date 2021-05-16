$(document).ready(function () {
	get_resource_files();
	get_sponsor_group_chat();
	get_sponsor_attendee_chat();
	//  ############### Group Chat Message  ################
	$('.send-group-message').on('click', function () {
		var url = "/sponsor/save_sponsor_group_chat/";
		var logo_url = "<?= ycl_root.'cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/logo/'.$data->logo?>";
		var chat_text = $('#group-chat-text').val();
		if(chat_text.trim()==""){
			return false;
		}

		$.post(project_url+url,{
			'booth_id':current_booth_id,
			'chat_text':chat_text
		}, function(success){
			if(success=="success"){

				$('.group-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img src="'+logo_url+'" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>Name</b></span><span class="float-left "><small>'+date_now+'<i class="fa fa-clock-o"></i></small> </span></div></div><div class="row"><div class="col">'+chat_text+'</div></div></div></div></div><br>');
				$('#group-chat-text').val("");
			}else{
				toastr["error"]("Problem sending chat!")
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

						$('.group-chat-body').append('<div class="card group-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>'+data.name+' '+data.surname+'</b></span><span class="float-left "><small>' + data.date_time + ' <i class="fa fa-clock-o"></i></small> </span></div></div><div class="row"><div class="col  text-right">' + data.chat_text + '</div></div></div></div></div><br>');
					} else {
						$('.group-chat-body').append('<div class="card group-incoming-message w-90  float-left  my-1 pl-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left"><b>'+data.name+' '+data.surname+'</b></span><span class="float-right "><small>' + data.date_time + ' <i class="fa fa-clock-o"></i></small> </span></div></div><div class="row"><div class="col">' + data.chat_text + '</div></div></div></div></div>')
					}
				});
			}else{
				toastr['error']('unable to fetch group chats');
				return false;
			}
		});
	}

	//  ############### End Group Chat Message  ################
	// ###############  Sponsor CHAT MESSAGE #####################
	$('.send-sponsor-message').on('click', function () {
		var chat_text = $('#sponsor-chat-text').val();
		var url = "/sponsor/save_sponsor_attendee_chat/";

		if(logo.trim() !=="" || logo.trim()!==undefined){
			logo_url =ycl_root+"/uploads/sponsor/logo/"+logo;
		}else{
			logo_url = "https://via.placeholder.com/150";
		}
		if(chat_text.trim()==""){
			toastr['error']('cannot send empty message');
			return false;
		}

		// console.log(chat_text);
		// console.log(project_url+url);
		// console.log(current_booth_id);

		$.post(project_url+url, { 'chat_text':chat_text, 'booth_id':current_booth_id }, function(success){
			// console.log(success);
			if(success=='success'){

				$('.sponsor-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img src="'+logo_url+'" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>Name</b></span><span class="float-left "><small>'+date_now+'<i class="fa fa-clock-o"></i></small> </span></div></div><div class="row"><div class="col">'+chat_text+'</div></div></div></div></div><br>');
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
								$('.sponsor-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg" ><div class="row"><div class="col"><span class="float-right"><img src="https://via.placeholder.com/150" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>'+data.full_name+'</b></span><span class="float-left "><small>'+data.date_time+' <i class="fa fa-clock-o"></i></small> </span></div></div><div class="row"><div class="col text-right">'+data.chat_text+'</div></div></div></div></div><br>');
							}else{
								$('.sponsor-chat-body').append('<div class="card sponsor-incoming-message w-90 float-left  my-1 pl-2 text-white shadow-lg " data-to_id="'+data.to_id+'"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left"><b>'+data.full_name+'</b></span><span class="float-right "><small>'+data.date_time+' <i class="fa fa-clock-o"></i></small> </span></div></div><div class="row"><div class="col">'+data.chat_text+'</div></div></div></div></div>');
							}
						});
					}else{

					}

				});
			}

	// ############### End Sponsor CHAT MESSAGE #####################

	function get_resource_files(){
		// console.log(current_booth_id);
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
					var extension = data.file_name.substr( (data.file_name.lastIndexOf('.') +1) );

					var icon;
					var hover = data.screen_name;
					if(extension == "docx") {
						icon = "fa-file-word-o";
					}
					else if(extension == "jpg") {
						icon = "fa-picture-o";
					}
					else if(extension == "pdf") {
						icon = "fa-file-pdf-o";
					}
					else if(extension == "xls" || extension=="xlxs") {
						icon = "fa-file-excel-o";
					}
					else if(extension == "txt" ) {
						icon = "fa-file-text-o";
					}
					else if(extension == "ppt" || extension == "pptx") {
						icon = "fa-file-powerpoint-o";
					}
					else {
						icon = "fa-question-circle";
					}
					$('.resources-body').append('<div class=" col-md-6 "><div class="card col-md-12 w-100 p-0 my-1"><div class="card-header bg-light-blue w-100 p-1 text-blue " style="cursor: pointer" title="'+hover+'" data-toggle="collapse" data-target="#resource_screen_name_'+data.id+'"><span class="fa '+icon+' text-info"></span> '+data.resource_name+'<span class="fa fa-caret-down float-right text-blue"></span></div><div class="card-body collapse align-content-center" id="resource_screen_name_'+data.id+'"><div class="badge badge-success">'+data.screen_name+'</div><a target="_blank" href="'+ycl_root+'/cms_uploads/projects/'+project_id+'/sponsor_assets/uploads/resource_management_files/'+data.file_name+'" download="'+data.screen_name+'"  class="btn btn-success btn-sm float-right"><small><span class="fa fa-external-link"> </span> Open</small>  </a></div></div></div>')
					// $('.resources-body').append('<div class="resource-item col-md-6 col-sm-12 my-3"><div class="resource-title col-md-12 border rounded my-2 bg-light py-2 text-brown "><h4 class="font-1">'+data.resource_name+'</h4><a class="btn btn-danger float-right ml-2 delete_resource_file " data-resource_id="'+data.id+'" data-screen_name="'+data.screen_name+'" data-resource_name="'+data.resource_name+'"><i class="fa fa-trash"><small> Remove </small></i></a><a target="_blank" href="'+ycl_root+'/cms_uploads/projects/'+project_id+'/sponsor_assets/uploads/resource_management_files/'+data.file_name+'" download="'+data.screen_name+'" class="btn btn-success float-right" ><i class="fa fa-external-link-square"><small> Open </small></i></a></div></div>')

				});
			}else{

				return false;
			}

		});
	}


	$('#schedule-a-meet').click(function(){
		get_sponsor_list();

		$('#modal-schedule-meet').modal('show');
	});

	function get_sponsor_list(){
		$.post(project_url+"/sponsor/get_sponsor_list/",
		{ 'booth_id':current_booth_id },
			function (success){

			}).done(function(datas){
			$('#modal-schedule-meet #sponsor-list').html('<option val="" disabled selected>Select sponsor to book a meeting</option>');

				datas = JSON.parse(datas);

				$.each(datas.result, function(index, data){
					$('#modal-schedule-meet #sponsor-list').append('<option id="sponsor-list-option sponsor-list_'+data.sponsor_id+'" data-sponsor_id = "'+data.sponsor_id+'" >'+data.sponsor_name+'</option>');
				});
		});
	}

	$('#modal-schedule-meet').on('change','#sponsor-list',function(){

		var id = $('#sponsor-list option:selected').data('sponsor_id');

		$.post(project_url+"/sponsor/get_sponsor_date_slot/",
			{
				'booth_id': current_booth_id,
				'sponsor_id': id,
			},
			function(datas){
				if(datas.status=="success"){
					console.log(datas.result[0]);
					$('#modal-schedule-meet #date-time-picker').prop('disabled',false);
					$('#modal-schedule-meet #date-time-picker').val('');
					$.each(datas.result, function(index, data){
							console.log(data);

							$('#modal-schedule-meet #date-time-picker').datetimepicker({
							formatDate:'Y-m-d H:i:s',
							minDate: data.start,
							maxDate: data.end
						});
					})
				}else{
					$('#modal-schedule-meet #date-time-picker').prop('disabled',true);
					$('#modal-schedule-meet #date-time-picker').val('No dates available');
					return	 false;
				}
			},'json');
	});


});
