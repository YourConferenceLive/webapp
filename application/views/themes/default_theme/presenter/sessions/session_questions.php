<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- Questions Dropdown Menu -->
<li class="nav-item dropdown">
	<a class="nav-link" data-toggle="dropdown" href="#">
		<i class="far fa-question-circle"></i>
		<span class="badge badge-warning navbar-badge">15</span>
	</a>
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		<span class="dropdown-item dropdown-header"><strong>Questions</strong></span>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item">
			<img src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle" style="width: 25px;">
			Question 1
			<span class="float-right text-muted text-sm">3 mins</span>
		</a>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item">
			<img src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle" style="width: 25px;">
			Question 2
			<span class="float-right text-muted text-sm">12 hours</span>
		</a>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item">
			<img src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle" style="width: 25px;">
			Question 3
			<span class="float-right text-muted text-sm">2 days</span>
		</a>
		<div class="dropdown-divider"></div>
		<!--				<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>-->
	</div>
</li>
