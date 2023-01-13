<?php
//if($view_settings){
//	print_r($view_settings);exit;
//}else{
//
//}
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_controller = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();?>
	<style>
		.navbar-light .navbar-nav .nav-link {
			color: #000;
			text-transform: uppercase;
		}
		.profile-dp {
			border-radius: 50%;
			float: left;
			height: 30px;
			width: 30px;
		}
		ul.navbar-nav li.dropdown:hover > div.dropdown-menu {
			display: block;
		}
		@media (min-width: 979px) {
			ul.navbar-nav li.dropdown:hover > div.dropdown-menu {
				display: block;
			}
		}

	</style>
	<header>
		<nav id="mainMenu" class="navbar navbar-expand-md navbar-light bg-white <?=(($ci_controller == 'sessions' && $ci_method == 'view') || ($ci_controller == 'sponsor' && $ci_method == 'index'))?'':'fixed-top'?>">
			<a class="navbar-brand" href="#"><img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="<?=(isset($view_settings[0]->header_logo_width) && $view_settings[0]->header_logo_width)? 'width:'.$view_settings[0]->header_logo_width:'max-width:80px'?>;height:<?=(isset($view_settings[0]->header_logo_width) && $view_settings[0]->header_logo_height)?'height:'.$view_settings[0]->header_logo_height:''?>"></a>
			<button class="navbar-toggler collapsed navbar-light" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse" id="navbarCollapse">

				<ul class="navbar-nav mr-auto">
					<?php if (ycl_env == 'testing'): ?>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">
							<badge class="badge badge-warning text-white"><i class="fas fa-exclamation-triangle"></i> TESTING ENVIRONMENT</badge>
						</a>
					</li>
					<?php elseif(ycl_env == 'development'): ?>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">
								<badge class="badge badge-warning text-white"><i class="fas fa-exclamation-triangle"></i> DEVELOPMENT ENVIRONMENT</badge>
							</a>
						</li>
					<?php endif; ?>
				</ul>
				<ul class="navbar-nav">
<!--					--><?php //print_r($view_settings);exit;?>
						<?php if(empty($view_settings) || $view_settings[0]->lobby == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/lobby"><strong>Lobby</strong></a></li>
						<?php endif; ?>
						<?php if(empty($view_settings) || $view_settings[0]->agenda == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/sessions"><strong>Agenda</strong></a></li>
						<?php endif;?>
						<?php if(empty($view_settings) || $view_settings[0]->eposter == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/eposters"><strong>ePosters</strong></a></li>
						<?php endif;?>
						<?php if(empty($view_settings) || $view_settings[0]->lounge == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/lounge"><strong>Lounge</strong></a></li>
						<?php endif;?>
						<?php if(empty($view_settings) || $view_settings[0]->exhibition_hall == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/sponsor"><strong>Exhibition Hall</strong></a></li>
						<?php endif;?>
						<?php if(empty($view_settings) || $view_settings[0]->scavenger_hunt == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/scavenger_hunt"><strong>Scavenger Hunt</strong></a></li>
						<?php endif;?>
						<?php if(empty($view_settings) || $view_settings[0]->relaxation_zone == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/relaxation_zone"><strong>Relaxation Zone</strong></a></li>
						<?php endif;?>
						<?php if(empty($view_settings) || $view_settings[0]->evaluation == 1):?>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/evaluation"><strong>Evaluation</strong></a></li>
						<?php endif;?>
					<?php if($this->router->fetch_class() == 'sessions'  && $this->router->fetch_method() == 'view' ) : ?>
					<li class="nav-item dropdown " id="header-toolbox">
						<a class="nav-link dropdown-toggle" style="font-weight:400" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<strong>Toolbox</strong>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item stickyMenu" data-sticky="questionsSticky" id="questionStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-question"></i> <?=(isset($session->toolbox_question_text) && !empty($session->toolbox_question_text))? $session->toolbox_question_text: 'Questions'?></a>
							<a class="dropdown-item stickyMenu" data-sticky="notesSticky" id="notesStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-edit"></i> <?=(isset($session->toolbox_note_text) && !empty($session->toolbox_note_text))? $session->toolbox_note_text: 'Take Notes'?></a>
<!--							<a class="dropdown-item stickyMenu" data-sticky="questionsSticky" id="questionsStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-comments"></i> Chat</a>-->
							<a class="dropdown-item stickyMenu" data-sticky="resourcesSticky" id="resourcesStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-paperclip"></i> <?=(isset($session->toolbox_resource_text) && !empty($session->toolbox_resource_text))? $session->toolbox_resource_text: 'Resources'?> </a>
							<a class="dropdown-item stickyMenu" data-sticky="askARepSticky" id="askARepStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-user-tie"></i> <?=(isset($session->toolbox_askrep_text) && !empty($session->toolbox_askrep_text))? $session->toolbox_askrep_text: 'Ask a Rep'?> </a>
						</div>
					</li>
						<?php endif; ?>

					<li class="nav-item" id="header_claim_credit" style="display:none">
						<a class="nav-link claim_credit_href" href="" target="_blank"><strong id="header_claim_credit_link"></strong></a>
					</li>

					<li class="nav-item" id="help-desk" style=" display: <?=(liveSupportChatStatus())?'none':'block'?>"><a class="nav-link" href="https://yourconference.live/support/" target="_blank"><strong>Help Desk</strong></a></li>
					<?php if ($this->router->fetch_class()!='sponsor' && $this->router->fetch_method()!='booth'): // Don't need support button in booths ?>
						<button class="live-support-open-button nav-item" onclick="openLiveSupportChat()"  style="background-color:  <?= (isset($view_settings) && !empty($view_settings[0]->live_support_color)? $view_settings[0]->live_support_color:'') ?>; display: <?=(liveSupportChatStatus())?'block':'none'?>;"><i class="far fa-life-ring"></i> Live Technical Support</button>
					<?php endif; ?>
					<?php if(empty($view_settings) || $view_settings[0]->mail_menu == 1):?>
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="badge badge-pill badge-primary" style="float:right;margin-bottom:-10px;">0</span>
							<i class="fas fa-envelope" style="color: #487391;"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
							<span class="ml-2">No new messages...</span>
<!--							<a class="dropdown-item" href="#">-->
<!--								<img class="person-icon-small" src="https://franchisematch.com/wp-content/uploads/2015/02/john-doe-300x300.jpg">-->
<!--								<span>John Doe</span><br>-->
<!--								<small style="margin-left: 30px;">Sample message...</small>-->
<!--							</a>-->
<!--							<div class="dropdown-divider"></div>-->
<!---->
<!--							<a class="dropdown-item" href="#">-->
<!--								<img class="person-icon-small" src="https://fwcdn.pl/ppo/01/59/159/449673.2.jpg">-->
<!--								<span>Daniel Day-Lewis</span><br>-->
<!--								<small style="margin-left: 30px;">Sample message 2...</small>-->
<!--							</a>-->

							<div class="dropdown-divider"></div>
							<!--<a class="dropdown-item" href="<?/*=base_url($this->project->main_route)*/?>/lounge"><strong>See all messages</strong></a>-->
						</div>
					</li>
					<?php endif; ?>
					<!--<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="profile-dp" src="<?/*=ycl_root*/?>/cms_uploads/user_photo/profile_pictures/<?/*=$user['photo'];*/?>" onerror="this.onerror=null;this.src='<?/*=ycl_root*/?>/ycl_assets/images/person_dp_placeholder.png';" alt="<?php /*echo $user['name'].' '.$user['surname'];*/?>">
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<?php /*if(empty($view_settings) || $view_settings[0]->profile == 1):*/?>
							<a class="dropdown-item" href="<?/*=base_url($this->project->main_route)*/?>/profile" style="color: rgb(72, 115, 145) !important;"><i class="far fa-id-card"></i> Profile</a>
							<?php /*endif;*/?>
							<?php /*if(empty($view_settings) || $view_settings[0]->briefcase == 1):*/?>
							<a class="dropdown-item" href="<?/*=base_url($this->project->main_route)*/?>/briefcase" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-briefcase"></i> Briefcase</a>
							<?php /*endif;*/?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?/*=base_url($this->project->main_route)*/?>/authentication/logout" style="color: rgb(72, 115, 145) !important;">Logout <i class="nav-icon fas fa-sign-out-alt"></i></a>
						</div>
					</li>-->

				</ul>
			</div>
		</nav>
	</header>
<?php $this->load->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/live_support_chat") ?>
<script>
	let previous ='';
		$('.stickyMenu').on('click', function(){
		let sticky = $(this).attr('data-sticky');
		$('#'+previous+'Minimize').trigger('click');
		$('#'+sticky).trigger('click');
			previous = sticky;
	})
</script>
