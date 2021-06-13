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
					<a class="nav-link disabled" href="#"><?=$user['name']?></a>
				</li>
			</ul>
		</div>
	</nav>
</header>
