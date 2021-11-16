$(function () {
	$('#reg_login').click(function (e) {
		e.preventDefault();

		var name = $('#contact-name').val();
		var email = $('#contact-email').val();
		var phone = $('#contact-phone').val();
		var message = $('#contact-message').val();
		var mailto = $('#mailto').val();

		var response = grecaptcha.getResponse();
		var response2 = 'g-recaptcha-response';

		if (name == '') {
			$('#contact-name-error').text("Please Enter Name").fadeIn('slow').fadeOut(5000);
			return false;
		} else if (email == '') {
			$('#contact-email-error').text("Please Enter Email").fadeIn('slow').fadeOut(5000);
			return false;
		} else if (phone == '') {
			$('#contact-phone-error').text("Please Enter Phone").fadeIn('slow').fadeOut(5000);
			return false;
		} else if (message == '') {
			$('#contact-message-error').text("Please Enter Message").fadeIn('slow').fadeOut(5000);
			return false;
		} else if (response.length == 0) {
			$("#errorcaptcha").text("Please check captcha").fadeIn('slow').fadeOut(5000);
			return false;
		} else if (response2 == '') {
			$("#errorcaptcha").text("Please check captcha").fadeIn('slow').fadeOut(5000);
			return false;
		} else {


			$.post(base_url + 'testSmtp', {'name': name, 'email': email, 'phone': phone, 'message': message, 'mailto':mailto},
				function (result) {
					if (result === 'success') {

						swal.fire({
							icon: 'success',
							title: '',
							text: 'Successfully sent!',
							timer: 2000,
							showCancelButton: false,
							showConfirmButton: false
						}).then(
							function () {},
							function (dismiss) {
								if (dismiss === 'timer') {
								}
							}
						)

						$('#contact-name').val('');
						$('#contact-email').val('');
						$('#contact-phone').val('');
						$('#contact-message').val('');
					} else {
						Swal.fire(
							'',
							'Something went wrong!',
							'error'
						)
					}
				})
			grecaptcha.reset();
		}
	})
})
