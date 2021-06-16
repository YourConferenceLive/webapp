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
	<nav
			id="mainMenu"
			class="navbar navbar-expand-md navbar-light bg-white
			<?=
			(
					($ci_controller == 'sessions' && $ci_method == 'view') ||
					($ci_controller == 'sponsor' && $ci_method == 'index')
			)?'':'fixed-top'?>
			">
		<a class="navbar-brand" href="#"><img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 80px;"></a>
		<button class="navbar-toggler collapsed navbar-light" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse" id="navbarCollapse" style="">
			<ul class="navbar-nav mr-auto">
			</ul>
			<ul class="navbar-nav">

				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/sponsor/admin"><strong><i class="fas fa-tachometer-alt"></i> Dashboard</strong></a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/sponsor/admin/analytics"><strong><i class="far fa-chart-bar"></i> Analytics</strong></a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?=$user['name']?>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?=$this->project_url?>/authentication/logout/<?=base64_encode('sponsor/admin')?>">Logout <i class="fas fa-sign-out-alt"></i></a>
<!--						<a class="dropdown-item" href="#">Another action</a>-->
<!--						<div class="dropdown-divider"></div>-->
<!--						<a class="dropdown-item" href="#">Something else here</a>-->
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>
