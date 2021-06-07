<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_controller = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();
?>

<style>
	.navbar-light .navbar-nav .nav-link
	{
		color: rgb(72, 115, 145);
	}
</style>

<header>
	<nav id="mainMenu" class="navbar navbar-expand-md navbar-light <?=($ci_controller == 'sessions' && $ci_method == 'view')?'':'fixed-top'?> bg-white">
		<a class="navbar-brand" href="#"><img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 80px;"></a>
		<button class="navbar-toggler collapsed navbar-light" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse" id="navbarCollapse" style="">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/lobby">Lobby</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/sessions">Agenda</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">ePosters</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/sponsor">Exhibition Hall</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Scavenger Hunt</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/relaxation_zone">Relaxation Zone</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Evaluation</a>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link disabled" href="#"><?=$user['name']?></a>
				</li>
			</ul>
		</div>
	</nav>
</header>
