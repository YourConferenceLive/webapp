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
			<a href="<?=$this->project_url.'/admin/dashboard'?>" class="nav-link">Dashboard</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?=$this->project_url.'/admin/sessions'?>" class="nav-link">Sessions</a>
		</li>

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

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">

		<li class="nav-item">
			<a id="admin_timer" class="nav-link disabled" style="display: none;color: rgb(255, 255, 255);">
				Starts In: __ __
			</a>
		</li>

		<li class="nav-item">
			<select class="custom-select border-0" id="languageSelect">
				<option value="" disabled selected>Lang</option>
				<option value="english">English</option>
				<option value="spanish">Spanish</option>
			</select>
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

		<?php if(1==2): ?>
		<!-- Messages Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="far fa-comments"></i>
				<span class="badge badge-danger navbar-badge">3</span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="#" class="dropdown-item">
					<!-- Message Start -->
					<div class="media">
						<img src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
						<div class="media-body">
							<h3 class="dropdown-item-title">
								Brad Diesel
								<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm">Call me whenever you can...</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
						</div>
					</div>
					<!-- Message End -->
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<!-- Message Start -->
					<div class="media">
						<img src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
						<div class="media-body">
							<h3 class="dropdown-item-title">
								John Pierce
								<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm">I got your message bro</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
						</div>
					</div>
					<!-- Message End -->
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<!-- Message Start -->
					<div class="media">
						<img src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
						<div class="media-body">
							<h3 class="dropdown-item-title">
								Nora Silvester
								<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm">The subject goes here</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
						</div>
					</div>
					<!-- Message End -->
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
			</div>
		</li>
		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="far fa-bell"></i>
				<span class="badge badge-warning navbar-badge">15</span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">15 Notifications</span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-envelope mr-2"></i> 4 new messages
					<span class="float-right text-muted text-sm">3 mins</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-users mr-2"></i> 8 friend requests
					<span class="float-right text-muted text-sm">12 hours</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-file mr-2"></i> 3 new reports
					<span class="float-right text-muted text-sm">2 days</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
			</div>
		</li>
		<?php endif; ?>

		<!-- Fullscreen Btn -->
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

<script>
	
</script>