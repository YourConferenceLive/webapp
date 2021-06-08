<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_controller = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();
?>
<!-- Navbar -->
<nav
		id="mainTopMenu"
		class="main-header navbar navbar-expand navbar-dark"
		<?=($ci_controller == 'sessions' && $ci_method == 'view')?'style="margin-left: unset !important;"':''?>
>

	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li id="pushMenuItem" class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?=$this->project_url.'/presenter/dashboard'?>" class="nav-link">Home</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?=$this->project_url.'/presenter/sessions'?>" class="nav-link">My Sessions</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">

		<li class="nav-item">
			<a id="presenter_timer" class="nav-link disabled" style="display: none;color: rgb(255, 255, 255);">
				Starts In: __ __
			</a>
		</li>


		<!-- Navbar Search -->
		<li class="nav-item">
			<a class="nav-link" data-widget="navbar-search" href="#" role="button">
				<i class="fas fa-search"></i>
			</a>
			<div class="navbar-search-block">
				<form class="form-inline">
					<div class="input-group input-group-sm">
						<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-navbar" type="submit">
								<i class="fas fa-search"></i>
							</button>
							<button class="btn btn-navbar" type="button" data-widget="navbar-search">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</li>

		<?php if (isset($host_chat_html)): ?>
			<?=$host_chat_html?>
		<?php endif; ?>

		<?php if (isset($questions_html)): ?>
			<?=$questions_html?>
		<?php endif; ?>

		<li class="nav-item">
			<a class="nav-link" data-widget="fullscreen" href="#" role="button">
				<i class="fas fa-expand-arrows-alt"></i>
			</a>
		</li>
<!--		<li class="nav-item">-->
<!--			<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">-->
<!--				<i class="fas fa-th-large"></i>-->
<!--			</a>-->
<!--		</li>-->
	</ul>
</nav>
<!-- /.navbar -->
