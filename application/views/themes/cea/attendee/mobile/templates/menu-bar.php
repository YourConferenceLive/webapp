<?php
//if($view_settings){
//	print_r($view_settings);exit;
//}else{
//
//}
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_controller = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();

$name = $this->session->userdata('project_sessions')['project_' . $this->project->id]['name'];
$user_id = $this->session->userdata('project_sessions')['project_' . $this->project->id]['user_id'];

//print_r(($this->session->userdata('project_sessions')['project_' . $this->project->id]['user_id']));exit;

//print_r($ci_method);exit;
?>
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

		.navbar{
			background-color: #a3a1a1;
		}
		

	</style>
	<header>
		<nav id="mainMenu" class="navbar  navbar-light <?=(($ci_controller == 'sessions' && $ci_method == 'viewMobileSession'))?'':'fixed-top'?>">
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
					<?php if($this->router->fetch_class() == 'sessions'  && $this->router->fetch_method() == 'view' ) : ?>
					<li class="nav-item dropdown " id="header-toolbox">
						<a class="nav-link dropdown-toggle" style="font-weight:400" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<strong>Toolbox</strong>
						</a>
						<div class="dropdown-menu dropdown-menu-right mb-4" aria-labelledby="navbarDropdown">
							<a class="dropdown-item stickyMenu" data-sticky="questionsSticky" id="questionStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-question"></i> Ask Question</a>
							<a class="dropdown-item stickyMenu" data-sticky="notesSticky" id="notesStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-edit"></i> Take Notes</a>
<!--							<a class="dropdown-item stickyMenu" data-sticky="questionsSticky" id="questionsStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-comments"></i> Chat</a>-->
							<a class="dropdown-item stickyMenu" data-sticky="resourcesSticky" id="resourcesStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-paperclip"></i> Resources </a>
<!--							<a class="dropdown-item stickyMenu" data-sticky="notesSticky" id="notesStickyMenu" href="#" style="color: rgb(72, 115, 145) !important;"><i class="fas fa-user-tie"></i> Ask A Rep </a>-->
						</div>
					</li>
						<?php endif; ?>

					<li class="nav-item" id="header_claim_credit" style="display:none">
						<a class="nav-link claim_credit_href" href="" target="_blank"><strong id="header_claim_credit_link"></strong></a>
					</li>

					<!-- <li class="nav-item" id="help-desk" style=" display: <?=(liveSupportChatStatus())?'none':'block'?>"><a class="nav-link" href="https://yourconference.live/support/" target="_blank"><strong>Help Desk</strong></a></li>
					<?php if ($this->router->fetch_class()!='sponsor' && $this->router->fetch_method()!='booth'): // Don't need support button in booths ?>
						<button class="live-support-open-button nav-item" onclick="openLiveSupportChat()"  style="background-color:  <?= (isset($view_settings) && !empty($view_settings[0]->live_support_color)? $view_settings[0]->live_support_color:'') ?>; display: <?=(liveSupportChatStatus())?'block':'none'?>;"><i class="far fa-life-ring"></i> Live Technical Support</button>
					<?php endif; ?> -->
					<!-- <?php if ($user_id): // Don't need support button in booths ?>
						<a href="" class=" nav-item btn btn-primary btn-sm mt-4" id="logoutBtn" ><i class="far fa-logout"></i> Log Out</a>
					<?php endif; ?> -->
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
