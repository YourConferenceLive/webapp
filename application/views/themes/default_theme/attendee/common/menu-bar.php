<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_controller = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();?>
	<style>
		.navbar-light .navbar-nav .nav-link {
			color: rgb(72, 115, 145);
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
			<a class="navbar-brand" href="#"><img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 80px;"></a>
			<button class="navbar-toggler collapsed navbar-light" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto"></ul>
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/lobby"><strong>Lobby</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/sessions/day/2021-06-24"><strong>Agenda</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/eposters"><strong>ePosters</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/lounge"><strong>Lounge</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/sponsor"><strong>Exhibition Hall</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/scavenger_hunt"><strong>Scavenger Hunt</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/relaxation_zone"><strong>Relaxation Zone</strong></a></li>
					<li class="nav-item"><a class="nav-link" href="<?=base_url().$this->project->main_route?>/evaluation"><strong>Evaluation</strong></a></li>

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
							<a class="dropdown-item" href="<?=base_url($this->project->main_route)?>/lounge"><strong>See all messages</strong></a>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="profile-dp" src="<?=ycl_root?>/cms_uploads/user_photo/profile_pictures/<?=$user['photo']?>" onerror="this.onerror=null;this.src='<?=ycl_root?>/ycl_assets/images/person_dp_placeholder.png';" alt="DP">
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?=base_url($this->project->main_route)?>/profile" style="color: rgb(72, 115, 145) !important;"><i class="far fa-id-card"></i> Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?=base_url($this->project->main_route)?>/authentication/logout" style="color: rgb(72, 115, 145) !important;">Logout <i class="nav-icon fas fa-sign-out-alt"></i></a>
						</div>
					</li>

				</ul>
			</div>
		</nav>
	</header>
