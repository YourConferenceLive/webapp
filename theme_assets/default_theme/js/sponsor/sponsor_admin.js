$(document).ready(function () {
	var toastMixin = Swal.mixin({
		toast: true,
		title: 'General Title',
		animation: false,
		position: 'top',
		showConfirmButton: false,
		timer: 4000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	$('.btn-cover').on('click', function () {
		$('#cover-upload').trigger('click');

	});

	$('.cover-upload').change(function () {
		var file_data = $("#cover-upload").prop("files")[0];
		var form_data = new FormData();

		form_data.append("file",file_data)
		form_data.append("project_id",booth_project_id)
		form_data.append("current_booth_id",booth_id)
		form_data.append("type","cover_photo")

		$.ajax({
			url: project_url + "/sponsor/admin/home/upload_booth_photos/",
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			success: function (cover) {
				$('#cover_photo').css('background-image', 'url(' + URL.createObjectURL(file_data)+')');
				toastr["success"]("Cover updated!")
			},

		});
	});

	$('.btn-logo').on('click', function () {
		$('#logo-upload').trigger('click');

	});

	$('.logo-upload').change(function () {
		var file_data = $(".logo-upload").prop("files")[0];
		var form_data = new FormData();

		form_data.append("logo", file_data);

		$.ajax({
			url: project_url + "/sponsor/admin/home/upload_logo/",
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			success: function (logo) {

				var version = Math.floor(Math.random() * 10000) + 1;
				$('.sponsor-main-logo').attr('src', '');
				$('.sponsor-main-logo').attr('src', '' + ycl_root + "/cms_uploads/projects/" + project_id + "/sponsor_assets/uploads/logo/" + logo + '?v=' + version + ')');
				toastr["success"]("Logo updated!")
			},
			error: function () {
				toastr["error"]("Unable to update the logo!")
			}
		});
	});

	$('.save-sponsor-name').on('click', function () {

		var sponsor_name = $('.sponsor-name').val();

		$.post(project_url + "/sponsor/admin/home/update_sponsor_name/", {'name': sponsor_name}, function (success) {

			if (success == "success") {
				toastr['success']('Sponsor name updated');
			} else {
				toastr['error']('Unable to update sponsor name');
			}
		}, 'text');

	});

	$('.save-about-us').on('click', function () {
		var about_us = $('.text-about-us').val();

		$.post(project_url + "/sponsor/admin/home/update_about_us/", {'about_us': about_us}, function (success) {

			if (success == "success") {
				toastr['success']('Sponsor name updated');
			} else {
				toastr['error']('Unable to update about us');
			}
		}, 'text');

	});

	$('.btn-save-website').on('click', function () {
		var website = $('#website').val();

		$.post(project_url + "/sponsor/admin/home/update_website/", {'website': website}, function (success) {
			if (success == "success") {
				toastr['success']('website updated');
			} else {
				toastr['error']('Unable to update website');
			}
		}, 'text');

	});

	$('.btn-save-twitter').on('click', function () {
		var twitter = $('#twitter').val();

		$.post(project_url + "/sponsor/admin/home/update_twitter/", {'twitter': twitter}, function (success) {
			if (success == "success") {
				toastr['success']('twitter updated');
			} else {
				toastr['error']('Unable to update twitter');
			}
		}, 'text');
	});

	$('.btn-save-facebook').on('click', function () {
		var facebook = $('#facebook').val();


		$.post(project_url + "/sponsor/admin/home/update_facebook/", {'facebook': facebook}, function (success) {
			if (success == "success") {
				toastr['success']('facebook updated');
			} else {
				toastr['error']('Unable to update facebook');
			}
		}, 'text');
	});

	$('.btn-save-linkedin').on('click', function () {
		var linkedin = $('#linkedin').val();

		$.post(project_url + "/sponsor/admin/home/update_linkedin/", {'linkedin': linkedin}, function (success) {
			if (success == "success") {
				toastr['success']('linkedin updated');
			} else {
				toastr['error']('Unable to update linkedin');
			}
		}, 'text');
	});


	$('.btn-customize').on('click', function () {

		if($(this).hasClass('fa-wrench')){
			$(this).removeClass('fa-wrench').addClass('fa-check').html('').append(' Done').removeClass('btn-outline-info').addClass('btn-success');
		}else{
			$(this).removeClass('fa-check').addClass('fa-wrench').html('').append(' Customize').removeClass('btn-success').addClass('btn-outline-info');
		}


		if ($('.text-about-us').attr('disabled')) {
			$('.text-about-us').removeAttr('disabled');
			disabled = false;
		} else {
			$('.text-about-us').attr('disabled', 'disabled');
			disabled = true;
		}

		if ($('.sponsor-name').attr('disabled')) {
			$('.sponsor-name').removeAttr('disabled');
			disabled = false;
		} else {
			$('.sponsor-name').attr('disabled', 'disabled');
			disabled = true;
		}

		if ($('#website').attr('disabled')) {
			$('#website').removeAttr('disabled');
			disabled = false;
		} else {
			$('#website').attr('disabled', 'disabled');
			disabled = true;
		}

		if ($('#facebook').attr('disabled')) {
			$('#facebook').removeAttr('disabled');
			disabled = false;
		} else {
			$('#facebook').attr('disabled', 'disabled');
			disabled = true;
		}

		if ($('#linkedin').attr('disabled')) {
			$('#linkedin').removeAttr('disabled');
			disabled = false;
		} else {
			$('#linkedin').attr('disabled', 'disabled');
			disabled = true;
		}

		if ($('#twitter').attr('disabled')) {
			$('#twitter').removeAttr('disabled');
			disabled = false;
		} else {
			$('#twitter').attr('disabled', 'disabled');
			disabled = true;
		}

		$('.btn-logo').toggle().removeAttr('hidden');
		$('.save-sponsor-name').toggle().removeAttr('hidden');
		$('.save-about-us').toggle().removeAttr('hidden');
		$('.btn-save-website').toggle().removeAttr('hidden');
		$('.btn-save-twitter').toggle().removeAttr('hidden');
		$('.btn-save-facebook').toggle().removeAttr('hidden');
		$('.btn-save-linkedin').toggle().removeAttr('hidden');

	});

	$('#btn-hide-about').click(function(){
		var btn= $(this);
		collapse_hide(btn);
	});

	$('#btn-collapse-availability').click(function(){
		var btn= $(this);
		collapse_hide(btn);
	});

	$('#btn-collapse-resource').click(function(){
		var btn= $(this);
		collapse_hide(btn);
	});

	$('#btn-collapse-booking').click(function(){
		var btn= $(this);
		collapse_hide(btn);
	});

	$('#btn-collapse-gc').click(function(){
		var btn= $(this);
		collapse_hide(btn);
	});

	$('#btn-collapse-sc').click(function(){
		var btn= $(this);
		collapse_hide(btn);
	});

	function collapse_hide(btn){
			if(btn.hasClass('fa-minus')){
				btn.removeClass('fa-minus').addClass('fa-plus');
			}else{
				btn.removeClass('fa-plus').addClass('fa-minus');
			}
	}


	$('.upload_photo').on('change', function () {
		var file = this.files[0];
		var type=$(this).attr("data-type");
		var form_data=new FormData();
		form_data.append("file",file)
		form_data.append("project_id",booth_project_id)
		form_data.append("current_booth_id",booth_id)
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

	$('.save_booth_url').on('click', function () {
		var $parent=$(this).parent();
		var value=$parent.find("input").val();
		var type=$parent.find("input").attr("data-type");
		$.ajax({
			url: project_url + "/sponsor/admin/home/change_booth_url/",
			data: {
				value:value,
				type:type,
				current_booth_id:booth_id
			},
			type: 'post',
			success: function (response) {

			}
		});

	});

});



$(document).ready(function () {


	get_sponsor_group_chat();
	get_sponsor_attendee_lists();
	get_resource_files();
	get_availability_list();
	get_full_calendar_events();

	$('#sponsor-chat-text').keypress(function (e) {
		if (e.which == 13) {
			$('.btn-sponsor-send').click();
		}
	});


	$('.btn-sponsor-send').on('click', function () {
		var chat_to_id = $('.sponsor-chat-header').attr('data-to_id');
		var chat_text = $('#sponsor-chat-text').val();

		if (logo.trim() !== "" || logo.trim() !== undefined) {
			logo_url = ycl_root + "/cms_uploads/projects/" + project_id + "/sponsor_assets/uploads/logo/" + logo;
		} else {
			logo_url = "https://via.placeholder.com/150";
		}

		if (chat_text.trim() == "") {
			toastr['error']('cannot send empty message');
			return false;
		}
		if (chat_to_id == undefined || chat_to_id == '') {
			toastr['error']('message recipient is empty');
			return false;
		}

		$.post(project_url + "/sponsor/admin/home/save_sponsor_attendee_chat/",
			{
				'chat_text': chat_text,
				'chat_to_id': chat_to_id
			}, function (success) {

				if (success == 'success') {
					get_sponsor_attendee_chat(chat_to_id);
					// $('.sponsor-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img src="'+logo_url+'" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>'+sponsor_name+'</b></span><span class="float-left "><small>'+date_now+'<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">'+chat_text+'</div></div></div></div></div><br>');
					$('#sponsor-chat-text').val("");
					toastr['success']('message sent');
				} else {
					toastr['error']('unable to send message');
				}
				swal.close();
			})

	});


	$('#group-chat-text').keypress(function (e) {

		if (e.which == 13) {
			$('.btn-group-send').click();
		}

	});

	$('.btn-group-send').on('click', function () {

		var chat_text = $('#group-chat-text').val();

		if (logo.trim() !== "" || logo.trim() !== undefined) {
			logo_url = ycl_root + "/cms_uploads/projects/" + project_id + "/sponsor_assets/uploads/logo/" + logo;
		} else {
			logo_url = "https://via.placeholder.com/150";
		}
		if (chat_text.trim() == "") {
			return false;
		}

		// $('.group-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img src="'+logo_url+'" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><b>'+sponsor_name+'</b></span><span class="float-left "><small>'+date_now+'<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">'+chat_text+'</div></div></div></div></div><br>');
		$('#group-chat-text').val("");

		$.post(project_url + "/sponsor/admin/home/save_sponsor_group_chat/", {'chat_text': chat_text}, function (success) {
			if (success == 'success') {
				swal.showLoading();
				toastr['success']('message sent');
				get_sponsor_group_chat();
			} else {
				toastr['error']('unable to send message');
			}
			swal.close();
		})
	});

	function get_sponsor_group_chat() {

		$.post(project_url + "/sponsor/admin/home/get_sponsor_group_chat/",
			{}, function (success) {

			}).done(function (datas) {

			datas = JSON.parse(datas);
			if (datas.status !== "error") {
				// console.log(datas);
				$('.group-chat-body').html('');

				$.each(datas.result, function (index, data) {
					if (data.chat_from == current_id) {

						$('.group-chat-body').append('<div class="card group-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><small>' + data.name + ' ' + data.surname + '</small></span><span class="float-left text-white-50"><small>' + data.date_time + '<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col  text-right">' + data.chat_text + '</div></div></div></div></div><br>');
					} else {
						$('.group-chat-body').append('<div class="card group-incoming-message w-90  float-left  my-1 pl-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left "><small>' + data.name + ' ' + data.surname + '</small></span><span class="float-right text-white-50"><small>' + data.date_time + '<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">' + data.chat_text + '</div></div></div></div></div>')
					}
				});

				$('.group-chat-body').scrollTop($('.group-chat-body')[0].scrollHeight);
			} else {
				$('.group-chat-body').html('');

			}

		});
	}

	function get_sponsor_attendee_lists() {

		$.post(project_url + "/sponsor/admin/home/get_sponsor_attendee_lists/",
			{}, function (success) {

			}).done(function (datas) {
			// console.log(datas);

			datas = JSON.parse(datas);
			if (datas.status !== "error") {

				$('#other_attendees_list').html('');
				$.each(datas.result, function (index, data) {

					$('#other_attendees_list').append('' +
						'<li class="all-users-item list-group-item" user-id="' + data.user_id + '" active-status="0" style="cursor: pointer;" data-list_id = "' + data.user_id + '" data-chatting_to ="' + data.name + ' ' + data.surname + '" data-to_id="' + data.id + '">\n' +
						'  <div class="row">\n' +
						'    <div class="col-1 p-0">\n' +
						'      <img src="'+ycl_root+'/vendor_frontend/adminlte/dist/img/user.png" style="width: 30px; border-radius: 50%;">\n' +
						'    </div>\n' +
						'    <div class="col-8 p-0 pl-2">\n' +
						'       <span>' + data.name + ' ' + data.surname + ' <i class="user-status-indicator fas fa-dot-circle" user-id="' + data.user_id + '" style="color: grey;"></i></span>\n' +
						'    </div>\n' +
						'    <div class="col-3 p-0 pl-1">\n' +
						'    <button style="display: none;" class="btn btn-info btn-sm video-call" user-id="' + data.user_id + '" user-name="' + data.name + ' ' + data.surname + '"><i class="fas fa-video"></i></button>\n' +
						'     <span class="user-info fas fa-id-card" data-user_id="' + data.user_id + '" style="font-size: 20px;cursor: pointer;position: absolute;left: 65px;top: -10px;color: #01b57a;"></span>' +
						'    </div>\n' +
						'   </div>\n' +
						'</li>')
				});
			}
		});
	}


	$('#search-attendee-chat').keyup(function () {
		var filter = $(this).val();
		search_attendee(filter);

	});

	$('#clear-search').on('click', function () {
		var filter = $('#search-attendee-chat').val('');
		search_attendee(filter);
	});

	function search_attendee(filter) {
		$(".attendee-list-body .all-users-item").each(function () {
			if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				$(this).hide();
			} else {
				$(this).show();
			}
		});
	}

	$('.attendee-list-body').on('click', '.all-users-item', function () {
		var chat_from_id = $(this).attr('data-list_id');
		var chatting_to = $(this).attr('data-chatting_to');

		$('.attendee-list-body .all-users-item').css('background-color', 'white');
		$(this).css('background-color', 'gray');
		$('.sponsor-chat-header').html('<div class="text-center">' + chatting_to + '<span class="float-right btn  text-danger pt-0" id="close_chat"><i class="fas fa-times"></i></span></div>').attr('data-to_id', chat_from_id);
		$('.sponsor-chat-body').html('');

		get_sponsor_attendee_chat(chat_from_id);

	});

	$('.sponsor-chat-header').on('click', '#close_chat', function () {

		$('.sponsor-chat-body').html('');
		$('.attendee-list-body .all-users-item').css('background-color', 'white');
		$('.sponsor-chat-header').html('');
		$('.sponsor-chat-header').attr('data-to_id', '');

	});

	function get_sponsor_attendee_chat(chat_from_id) {

		$.post(project_url + "/sponsor/admin/home/get_sponsor_attendee_chat/", {'chat_from_id': chat_from_id}, function () {

		}).done(function (datas) {
			datas = JSON.parse(datas)

			if (datas.status == 'success') {

				$('.sponsor-chat-body').html('');

				$.each(datas.result, function (index, data) {

					if (data.chat_from == "sponsor") {
						$('.sponsor-chat-body').append('<div class="card sponsor-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg" ><div class="row"><div class="col"><span class="float-right"><img src="https://via.placeholder.com/150" class="my-2" src="" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><small>' + data.name + ' ' + data.surname + '</small></span><span class="float-left text-white-50"><small>' + data.date_time + ' <i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col text-right">' + data.chat_text + '</div></div></div></div></div><br>');
					} else {
						$('.sponsor-chat-body').append('<div class="card sponsor-incoming-message w-90 float-left  my-1 pl-2 text-white shadow-lg " data-to_id="' + data.to_id + '"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left "><small>' + data.name + ' ' + data.surname + '</small></span><span class="float-right text-white-50"><small>' + data.date_time + ' <i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">' + data.chat_text + '</div></div></div></div></div>');
					}
				});
				$('.sponsor-chat-body').scrollTop($('.sponsor-chat-body')[0].scrollHeight);
			}
		});
	}

	$('.attendee-list-body').on('click', '.user-info', function () {
		var attendee_id = $(this).attr('data-user_id');

		user_info_modal(attendee_id);
	});

	function user_info_modal(attendee_id) {

		swal.showLoading();
		$.post(project_url + "/sponsor/admin/home/get_attendee_info/",
			{
				'attendee_id': attendee_id
			},
			function (success) {
			}).done(function (datas) {

			datas = JSON.parse(datas);
			if (datas.status !== "error") {

				$.each(datas.result, function (index, data) {

					$('#modal-user-info .modal-title').html('<img class=" btn p-0 " src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%">' + data.name + ' ' + data.surname);
					$('#modal-user-info .modal-body').html('<span class="far fa-envelope text-primary "></span> ' + data.email);
					swal.close();
				});
				$('#modal-user-info').modal('show');
			} else {
				toastr['error']('unable to get user-info');
				return false;
			}
		});
	}

	$('.btn-add-resource').on('click', function () {
		$('#modal-add-resource').modal('show');
	});

	$('#modal-add-resource').on('click', '.btn-resource-upload', function () {
		var resource_name = $('#resource_name').val();
		var formData = new FormData();
		var files = $('#resource_file')[0].files[0];
		formData.append('resource_file', files);
		formData.append('resource_name', resource_name);
		swal.showLoading()

		if (resource_name.trim() == '') {
			swal.close();
			toastr['error']('Resource name is empty');
			return false;
		}
		if ($('#resource_file').val() == '') {
			swal.close();
			toastr['error']('File is empty');
			return false;
		}
		$.ajax({
			url: project_url + "/sponsor/admin/home/upload_resource_file/",
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			success: function (response) {
				if (response != 0) {
					swal.close();
					Swal.fire(
						'File Successfully Uploaded!',
						'',
						'success'
					)
					$('#modal-add-resource #resource_file').val('');
					$('#modal-add-resource #resource_name').val('');

					get_resource_files();
				} else {
					swal.close();
					Swal.fire(
						'File Uploaded Unsuccessful!',
						'',
						'error'
					)
				}
			},
		});
	});

	function get_resource_files() {

		$.post(project_url + "/sponsor/admin/home/get_resource_files/",
			{}, function () {

			}).done(function (datas) {
			$('.resources-body').html('');
			datas = JSON.parse(datas);
			if (datas.status == "success") {

				$.each(datas.result, function (index, data) {

					var extension = data.file_name.substr((data.file_name.lastIndexOf('.') + 1));
					// console.log(extension);
					var icon;
					var hover = data.screen_name;
					if (extension == "docx") {
						icon = "fa-file-word";
					} else if (extension == "jpg" || extension == "png" || extension == "jpeg") {
						icon = "fa-image";
					} else if (extension == "pdf") {
						icon = "fa-file-pdf";
					} else if (extension == "xls" || extension == "xlxs") {
						icon = "fa-file-excel";
					} else if (extension == "txt") {
						icon = "fa-file-alt";
					} else if (extension == "ppt" || extension == "pptx") {
						icon = "fa-file-powerpoint";
					} else {
						icon = "";
					}
					// $('.resources-body').append('<div class="resource-item col-md-6 col-sm-12 my-3"><div class="resource-title col-md-12 border rounded my-2 bg-light py-2 text-brown"><h4 class="font-1">'+data.resource_name+'</h4><a class="btn btn-danger float-right ml-2 delete_resource_file " data-resource_id="'+data.id+'" data-screen_name="'+data.screen_name+'" data-resource_name="'+data.resource_name+'"><i class="fa fa-trash"><small> Remove </small></i></a><a target="_blank" href="'+ycl_root+'/cms_uploads/projects/'+project_id+'/sponsor_assets/uploads/resource_management_files/'+data.file_name+'" download="'+data.screen_name+'" class="btn btn-success float-right" ><i class="fa fa-external-link-square"><small> Open </small></i></a></div></div>')
					$('.resources-body').append('<div class="resource-item col-md-6 col-sm-12 my-1"><div class="card"><div class="card-header resource-title col-md-12 bg-white py-1 text-brown border-bottom-0" style="cursor: pointer" title="' + hover + '"><h4 class="font-1"><span class="far ' + icon + ' text-info"></span> ' + data.resource_name + '</h4></div><div class="card-footer bg-white p-1 border-top-0"><a class="btn btn-danger btn-sm float-right ml-2 delete_resource_file " data-resource_id="' + data.id + '" data-screen_name="' + data.screen_name + '" data-resource_name="' + data.resource_name + '"><i class="fas fa-trash-alt"><small> Remove </small></i></a><a target="_blank" href="' + ycl_root + '/cms_uploads/projects/' + project_id + '/sponsor_assets/uploads/resource_management_files/' + data.file_name + '" download="' + data.screen_name + '" class="btn btn-success btn-sm float-right"><i class="fas fa-external-link-alt"><small> Open </small></i></a></div></div></div>')
				});
			} else {
				return false;
			}
		});
	}

	$('.resources-body').on('click', '.delete_resource_file', function () {

		var resource_id = $(this).attr('data-resource_id');
		var file_name = $(this).attr('data-screen_name');
		var resource_name = $(this).attr('data-resource_name');

		Swal.fire({
			title: '<small style="font-size: 16px"> Confirm Delete <br><br> Resource Name: ' + resource_name + '<br><br>Filename: ' + file_name + '</small>',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {

				$.post(project_url + "/sponsor/admin/home/delete_resource_file/",
					{
						'resource_id': resource_id
					}, function (success) {

						if (success == "success") {
							Swal.fire(
								'Deleted!',
								'Your file has been deleted.',
								'success'
							)
							get_resource_files();
						} else {
							Swal.fire(
								'Error!',
								'Delete File Unsuccessful',
								'error')
						}
					});
			}
		})
	});

	$(function daterangepicker() {

		$('input[name="date_picker"]').daterangepicker({
			minDate: new Date(),
			timePicker: true,
			startDate: moment().startOf('hour'),
			endDate: moment().startOf('hour').add(32, 'hour'),
			applyButtonClasses: "btn-info",
			cancelButtonClasses: "btn-secondary",
			locale: {
				format: 'M/DD hh:mm A'
			}
		}, function (start, end, label) {
			var availability_start = start.format('YYYY-MM-DD HH:mm');
			var availability_end = end.format('YYYY-MM-DD HH:mm');

			var availableFromD = new Date(Date.parse(availability_start));
			var availableToD = new Date(Date.parse(availability_end));
			var availability_range = Math.abs(availableToD - availableFromD);
			var minMeetingDuration = 30;

			if (availability_range / 60000 < minMeetingDuration) {
				toastr["warning"]('Availability duration must be at least ' + minMeetingDuration + ' minutes!');
				return;
			}

			$.post(project_url + "/sponsor/admin/home/add_availability_date_time/",
				{
					'available_from': availability_start,
					'available_to': availability_end,
				}, function (result) {
					if (result == "success") {
						Swal.fire(
							'Success',
							'Availability Added',
							'success'
						)
						get_availability_list();
					} else if (result == "error") {
						Swal.fire(
							'Error',
							'Availability overlaps another availability',
							'warning'
						)

					} else {
						Swal.fire(
							'Error',
							'Problem adding availability',
							'error'
						)

					}

				});
		});
	});

	function get_availability_list() {

		$.post(project_url + "/sponsor/admin/home/get_availability_list/",
			{}, function () {

			}).done(function (datas) {
			datas = JSON.parse(datas);

			if (datas.status == "success") {
				$('.availability-list-body').html('');
				$.each(datas.result, function (index, data) {

					$('.availability-list-body').append('<div class="row mb-1"><div class="col-md-5 text-center text-blue"><i class="far fa-calendar-check text-blue"></i> ' + data.available_from + '</div><div class="col-md-2 text-center"> TO </div><div class="col-md-5 text-center text-blue"><i class="far fa-calendar-check text-blue"></i> ' + data.available_to + '<span class="btn fas fa-times text-danger" id="delete-availability" data-availability_id ="' + data.id + '"></span></div><hr class="w-100 mb-0 pb-0"></div>')
				});
			} else {
				$('.availability-list-body').html('');
				return false;
			}
		});
	}

	$('.availability-list-body').on('click', '#delete-availability', function () {

		var availability_id = $(this).attr('data-availability_id');

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {

				$.post(project_url + "/sponsor/admin/home/delete_availability/",
					{
						'availability_id': availability_id
					},

					function (success) {
						if (success != 0) {

							get_availability_list();
							Swal.fire(
								'Deleted!',
								'Your file has been deleted.',
								'success'
							)
						} else {
							Swal.fire(
								'Failed',
								'Problem deleting this file',
								'error'
							)
							get_availability_list();
						}
					});
			}
		})
	});

	function get_full_calendar_events() {

		$.post(project_url + "/sponsor/admin/home/get_calendar_events/",
			{}, function (events) {

				events = JSON.parse(events);
				// console.log(events.result);

				var calendarEl = $('#calendar')[0];
				var calendar = new FullCalendar.Calendar(calendarEl, {
					initialView: 'dayGridMonth',
					initialDate: '2021-04-07',
					headerToolbar: {
						left: 'prev,next today',
						center: 'title',
						right: $(window).width() < 765 ? '' : 'dayGridMonth,timeGridWeek,timeGridDay'
					},
					footerToolbar: {
						center: $(window).width() < 765 ? 'dayGridMonth,timeGridWeek,timeGridDay' : ''
					},
					themeSystem: 'bootstrap',

					eventClick: function (info) {
						user_info_modal(info.event.extendedProps.attendee_id);
					},

					events: events.result

				});

				calendar.render();
			});
	}

	$(function () {
		$(document).mouseup(function (e) {
			var container = $(".attendee-list");
			var show_attendee = $('.show-attendees');
			if ($('.show-attendees').css('display') == 'block') {
				if (!container.is(e.target) && (!show_attendee.is(e.target)) &&
					container.has(e.target).length === 0) {
					container.hide('transisition');
				}
			}
		});
	});

	$("#btn-clear-group-chat").on("click", function () {

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, clear chat!'
		}).then((result) => {
			if (result.value) {

				$.post(project_url + "/sponsor/admin/home/clear_group_chat",
					{},
					function (data) {

						if (data == 'success') {

							get_sponsor_group_chat();

							Swal.fire(
								'Cleared!',
								'Group chat has been cleared.',
								'success'
							).then(function () {

							})
						} else {
							toastr["info"](data)
						}
					}, 'text');
			}
		})
	});

	$('#btn-save-group-chat').click(function () {
		Swal.fire({
			title: 'Save a copy of chat',
			text: "Backup name (required)",
			input: 'text',
			inputPlaceholder: 'input name here',
			icon: '',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, clear chat!'
		}).then((result) => {
			if (result.isConfirmed) {
				if (result.value) {
					$.post(project_url + "/sponsor/admin/home/copy_from_group_chat",
						{
							'backup_name': result.value
						}, function (data) {

							if (data.status == 'success') {

								Swal.fire(
									'Success',
									data.message,
									'success'
								)
							} else if (data.status == 'no_update') {
								Swal.fire(
									'',
									data.message,
									'warning'
								)
							} else {
								Swal.fire(
									'error',
									data.message,
									'error'
								)
							}
						}, 'json');
				} else {
					Swal.fire(
						'Error!',
						'Backup name required!',
						'error'
					).then(function () {
						$('#btn-save-group-chat').click();
					})
				}
			}
		});
		// toastr['warning']('under development');
	});

	$('#btn-show-saved-chat').click(function () {
		swal.showLoading();
		get_saved_group_chats();
		swal.close();
	});

	function get_saved_group_chats() {

		$.post(project_url + "/sponsor/admin/home/get_saved_group_chats/",
			{}, function (success) {

			}).done(function (datas) {

			datas = JSON.parse(datas);
			if (datas) {
				$('.group-chat-body').html('');
				$('.group-chat-header .card-saved-chat').remove('.card-saved-chat');
				$('.group-chat-header').append(' <div class="card mt-4 pb-0 mb-0 card-saved-chat"><div class="card-header bg-light text-dark p-1 text-center"><i class="fas fa-save text-info"></i> Saved Chats <span class="btn float-right fas fa-times text-danger mt-1 pt-0" id="btn-close-save-chat"></span><i class="far fa-trash-alt btn badge badge-danger float-left mt-1" id="delete-saved-chat"> Delete </i></div></div></div>');

				$.each(datas.result, function (index, data) {

					if (data.chat_from == current_id) {

						$('.group-chat-body').append('<div class="card group-outgoing-message w-90 float-right  my-1 pr-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-right"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-right"><small>' + data.name + ' ' + data.surname + '</small></span><span class="float-left text-white-50"><small>' + data.date_time + '<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col  text-right">' + data.chat_text + '</div></div></div></div></div><br>');
					} else {
						$('.group-chat-body').append('<div class="card group-incoming-message w-90  float-left  my-1 pl-2 text-white shadow-lg"><div class="row"><div class="col"><span class="float-left"><img class="my-2" src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></span><div class="row ml-1"><div class="col"><span class="float-left "><small>' + data.name + ' ' + data.surname + '</small></span><span class="float-right text-white-50"><small>' + data.date_time + '<i class="far fa-clock"></i></small> </span></div></div><div class="row"><div class="col">' + data.chat_text + '</div></div></div></div></div>')
					}
				});

				$('.group-chat-body').scrollTop($('.group-chat-body')[0].scrollHeight);
			}

		});
	}

	$('.group-chat-header').on('click', '#btn-close-save-chat', function () {
		$('.card-saved-chat').hide();
		get_sponsor_group_chat();
	})

	$('.group-chat-header').on('click', '#delete-saved-chat', function () {

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, clear saved chat!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post(project_url + "/sponsor/admin/home/delete_saved_chats/",
					{}, function (result) {
						get_saved_group_chats();
						if (result) {
							Swal.fire(
								'Success',
								'Saved chats cleared! ',
								'success'
							)
						} else {
							toastr['error']('Problem deleting saved chats');
						}

					});
			}
		});

	})
});

