$(function (){
	function rightStickyBar() {
		var $toolType = "";

		var $rightSticky = $(".rightSticky")
		var $embedVideo=$("#embededVideo");

		// $(document).on("click", ".rightSticky ul li,.rightSticykPopup .open > .dropdown-menu li a,.rightSticykPopup .header .rightTool i,.toolboxCustomDrop li a,.sticky_resources_open", function () {
		$(document).on("click", ".rightSticky ul li, .rightSticykPopup .header .rightTool .dropdown-menu li", function () {

			// console.log("test")

			var screen = $rightSticky.data("screen");
			$toolType = $(this).data("type");
			var $toolType2 = $(this).data("type2");

			if(screen=="presenter"){

			}else{
				if(window.innerWidth<=601){
					$(".rightSticykPopup").css("display","none");
				}


				if($toolType2=="off"){

					$(".rightSticykPopup").css("display","none");
				}
				$("." + $toolType).css("display", "block")



				if($toolType=="messagesSticky"){
					$(this).find(".notify").addClass("displayNone");
					var $messagesContent=$('.messagesSticky .content .messages');
					$($messagesContent).scrollTop($($messagesContent)[0].scrollHeight);
				}


				//for mobile
				if(window.innerWidth<=601){
					$embedVideo.css("height","50vh");
				}else{
					$rightSticky.css("display", "none");

					var $screenWidth = $(document).width();
					var rightStickyWidth=390;
					if(screen=="customer")rightStickyWidth=320;
					else if(screen=="admin")rightStickyWidth=400;
					$screenWidth = $screenWidth - rightStickyWidth;

					$(".videContent,.main-content").animate({
						marginRight: '40%',
						width: `${$screenWidth}px`
					})
				}
			}

			var presenter_allmessages_el = document.getElementById('allmessage');
			if (presenter_allmessages_el != null)
			{
				var height = presenter_allmessages_el.scrollHeight; - $('#allmessage').height();
				$('#allmessage').scrollTop(height);
			}
		});

		$(document).on("click", ".rightSticykPopup .header .rightTool i", function () {
			var screen = $rightSticky.data("screen");

			if(screen=="presenter"){
				var stickyId=$(this).attr("data-right-id");

				$(".presenterRightSticky ul ."+stickyId).css("display","");


				$(this).parent().parent().parent().css("display","none");
				var $presenterRightStickyPopup=$(".presenterRightSticykPopup");
				var stickyBool=true;
				$presenterRightStickyPopup.each(function (){
					if($(this).css("display")=="block"){
						stickyBool=false;
					}
				})
				if(stickyBool){
					leftRightSideColChange("add");
					$(".presenterRightSticky").css("display","")
				}

			}else{
				$(".rightSticykPopup").css("display","none");
				if(window.innerWidth<=601){
					$embedVideo.css("height","92vh");

				}else {
					$rightSticky.css("display", "");

					$(".videContent,.main-content").animate({
						marginRight: 0,
						width: '100%'
					})
				}
			}

		})
	}

	rightStickyBar()
});
