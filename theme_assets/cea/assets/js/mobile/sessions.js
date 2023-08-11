$(function () {
	rightStickyBar()

	var questions_emojis_section = $("#questions_emojis_section");
	var questions_emjis_section_show = $("#questions_emjis_section_show");
	questions_emojis_section.hide();
	$(document).on("click", "#questions_emjis_section_show", function () {
		var emjis_section_show_status = questions_emjis_section_show.attr("data-questions_emjis_section_show_status");
		if (emjis_section_show_status == 0) {
			questions_emojis_section.show();
			questions_emjis_section_show.attr('data-questions_emjis_section_show_status', 1);
		} else {
			questions_emojis_section.hide();
			questions_emjis_section_show.attr('data-questions_emjis_section_show_status', 0);
		}
	});

	$(document).on("click", "#questions_emojis_section img", function () {
		var value = $(this).attr("data-title_name");
		var $questions = $("#questions");
		if ($questions.val() != "") {
			$questions.val($questions.val() + ' ' + value);
		} else {
			$questions.val(value);
		}
	});
});

function rightStickyBar() {
		var $toolType = "";

		var $rightSticky = $(".rightSticky")
		var $embedVideo = $("#embededVideo");

		// $(document).on("click", ".rightSticky ul li,.rightSticykPopup .open > .dropdown-menu li a,.rightSticykPopup .header .rightTool i,.toolboxCustomDrop li a,.sticky_resources_open", function () {
		$(document).on("click", ".rightSticky ul li, .rightSticykPopup .header .rightTool .dropdown-menu li", function () {
			var screen = $rightSticky.data("screen");
			$toolType = $(this).data("type");
			var $toolType2 = $(this).data("type2");

			if (window.innerWidth <= 601) {
				$(".rightSticykPopup").css("display", "none");
			}

			if ($toolType2 == "off") {

				$(".rightSticykPopup").css("display", "none");
			}
			$("." + $toolType).css("display", "block")

			if ($toolType == "messagesSticky") {
				$(this).find(".notify").addClass("displayNone");
				var $messagesContent = $('.messagesSticky .content .messages');
				$($messagesContent).scrollTop($($messagesContent)[0].scrollHeight);
			}


			//for mobile
			if (window.innerWidth <= 601) {
				$embedVideo.css("height", "50vh");
			} else {
				$rightSticky.css("display", "none");

				var $screenWidth = $(document).width();
				var rightStickyWidth = 390;
				if (screen == "customer") rightStickyWidth = 320;
				else if (screen == "admin") rightStickyWidth = 400;
				$screenWidth = $screenWidth - rightStickyWidth;

				$(".sessions-view-container").animate({
					marginRight: '40%',
					width: `${$screenWidth}px`
				})
			}

			var presenter_allmessages_el = document.getElementById('allmessage');
			if (presenter_allmessages_el != null) {
				var height = presenter_allmessages_el.scrollHeight;
				-$('#allmessage').height();
				$('#allmessage').scrollTop(height);
			}
		});

		$(document).on("click", ".rightSticykPopup .header .rightTool i", function () {
			$(".rightSticykPopup").css("display", "none");
			if (window.innerWidth <= 601) {
				$embedVideo.css("height", "92vh");

			} else {
				$rightSticky.css("display", "");

				$(".sessions-view-container").animate({
					marginRight: 0,
					width: '100%'
				})
			}
		})
	}
