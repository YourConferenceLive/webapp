<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- Messages Dropdown Menu -->
<li class="nav-item dropdown">
	<a class="nav-link" data-toggle="dropdown" href="#">
		<i class="far fa-comments fa-2x"></i>
		<span class="badge badge-danger navbar-badge" style="font-size: 0.8rem;">3</span>
	</a>
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		<span class="dropdown-item dropdown-header"><strong>Host Chat</strong></span>
		<div class="dropdown-divider"></div>
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
<!--		<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>-->
	</div>
</li>
