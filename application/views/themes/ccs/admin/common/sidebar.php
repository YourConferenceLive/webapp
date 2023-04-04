<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?=$this->project_url.'/admin/dashboard'?>" class="brand-link">
		<img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="Logo" class="brand-image <?=(($this->project->name)=='Demo')?'':'img-circle'?>" style="opacity: .8 <?=(($this->project->name=="Demo"))?'max-width: 120px':''?>">
		<span class="brand-text font-weight-light"><?=$this->project->name?> Admin</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img class="img-circle elevation-2" src="<?=ycl_root?>/cms_uploads/user_photo/profile_pictures/<?=$user->photo;?>" onerror="this.onerror=null;this.src='<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user.png';" alt="<?php echo $user->name.' '.$user->surname;?>">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?=$user->name?> <?=$user->surname?></a>
			</div>
		</div>

		<!-- SidebarSearch Form -->
		<div class="form-inline">
			<div class="input-group" data-widget="sidebar-search">
				<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn btn-sidebar">
						<i class="nav-icon fas fa-search fa-fw"></i>
					</button>
				</div>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/dashboard'?>" class="nav-link<?=($this->router->fetch_class()=='dashboard')?' active':''?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/users'?>" class="nav-link<?=($this->router->fetch_class()=='users' && $this->router->fetch_method()=='index')?' active':''?>">
						<i class="nav-icon fas fa-users"></i>
						<p>Users</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/users/exhibitorsWithoutBooth'?>" class="nav-link<?=($this->router->fetch_method()=='exhibitorsWithoutBooth')?' active':''?>">
						<i class="nav-icon fas fa-child"></i>
						<p>Exhibitors Without Booth</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/sessions'?>" class="nav-link<?=($this->router->fetch_class()=='sessions')?' active':''?>">
						<i class="nav-icon fas fa-chalkboard-teacher"></i>
						<p>Sessions</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/eposters'?>" class="nav-link<?=($this->router->fetch_class()=='eposters')?' active':''?>">
						<i class="nav-icon fas fa fa-print" aria-hidden="true"></i>
						<p>ePosters</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/sponsors'?>" class="nav-link<?=($this->router->fetch_class()=='sponsors')?' active':''?>">
						<i class="nav-icon fas fa-border-all"></i>
						<p>Sponsors</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/evaluation'?>" class="nav-link<?=($this->router->fetch_class()=='evaluation')?' active':''?>">
						<i class="nav-icon fas fa-clipboard-check"></i>
						<p>Evaluations</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/live_support_chat'?>" class="nav-link<?=($this->router->fetch_class()=='live_support_chat')?' active':''?>">
						<i class="nav-icon far fa-life-ring"></i>
						<p>Live Support</p>
					</a>
				</li>

				<li class="nav-item<?=($this->router->fetch_class()=='analytics')?' menu-is-opening menu-open':''?>">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-chart-pie"></i>
						<p>Analytics <i class="nav-icon fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview" style="display:<?=($this->router->fetch_class()=='analytics')?' block':' none'?>;">
						<li class="nav-item sr-only">
							<a href="<?=$this->project_url.'/admin/analytics'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='index')?' active':''?>">
								<i class="nav-icon fas fa-book"></i>
								<p class="text">All Logs</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/scavenger_hunt'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='scavenger_hunt')?' active':''?>">
								<i class="nav-icon fas fa-bullseye"></i>
								<p class="text">Scavenger Hunt</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/relaxation_zone'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='relaxation_zone')?' active':''?>">
								<i class="nav-icon fas fa-couch"></i>
								<p class="text">Relaxation Zone</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/trivia_night'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='trivia_night')?' active':''?>">
								<i class="nav-icon fas fa-info"></i>
								<p class="text">Trivia Night</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/exhibition_hall'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='exhibition_hall')?' active':''?>">
								<i class="nav-icon fas fa-palette"></i>
								<p class="text">Exhibition Hall</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/scientific_sessions'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='scientific_sessions')?' active':''?>">
								<i class="nav-icon fas fa-vials"></i>
								<p class="text">Scientific Sessions</p>
							</a>
						</li>

						<li class="nav-item sr-only">
							<a href="<?=$this->project_url.'/admin/analytics/session_recordings'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='session_recordings')?' active':''?>">
								<i class="nav-icon fas fa-record-vinyl"></i>
								<p class="text">Session Recordings</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/skills_transfer_courses'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='skills_transfer_courses')?' active':''?>">
								<i class="nav-icon fas fa-tools"></i>
								<p class="text">Skills Transfer Courses</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/eposters'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='eposters')?' active':''?>">
								<i class="nav-icon fas fa-user-md"></i>
								<p class="text">ePosters/Surgical Videos</p>
							</a>
						</li>

						<li class="nav-item sr-only">
							<a href="<?=$this->project_url.'/admin/analytics/overall'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='overall')?' active':''?>">
								<i class="nav-icon fas fa-globe"></i>
								<p class="text">Overall</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/sessions_questions'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='sessions_questions')?' active':''?>">
								<i class="nav-icon fas fa-chalkboard-teacher"></i>
								<p class="text">Sessions Q&A</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/credits_report/1'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='credits_report' && $this->uri->segment(5) == 1)?' active':''?>">
								<i class="nav-icon fas fa-chart-bar"></i>
								<p class="text">Section 1 - Credits Report</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/credits_report/2'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='credits_report' && $this->uri->segment(5) == 2)?' active':''?>">
								<i class="nav-icon fas fa-chart-area"></i>
								<p class="text">Section 2 - Credits Report</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/credits_report/3'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='credits_report' && $this->uri->segment(5) == 3)?' active':''?>">
								<i class="nav-icon fas fa-chart-line"></i>
								<p class="text">Section 3 - Credits Report</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/annual_general_meeting'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='annual_general_meeting')?' active':''?>">
								<i class="nav-icon fas fa-handshake"></i>
								<p class="text">Annual General Meeting</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/presidents_celebration'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='presidents_celebration')?' active':''?>">
								<i class="nav-icon fas fa-glass-cheers"></i>
								<p class="text">President's Celebration</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/awards_ceremony'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='awards_ceremony')?' active':''?>">
								<i class="nav-icon fas fa-award"></i>
								<p class="text">Awards Ceremony</p>
							</a>
						</li>

<!--						<li class="nav-item">
							<a href="<?/*=$this->project_url.'/admin/analytics/session_evaluation'*/?>" class="nav-link<?/*=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='session_evaluation')?' active':''*/?>">
								<i class="nav-icon fas fa-poll"></i>
								<p class="text">Session Evaluation/Polls</p>
							</a>
						</li>-->

						<li class="nav-item">
							<a href="<?=$this->project_url.'/admin/analytics/overallConference'?>" class="nav-link<?=($this->router->fetch_class()=='analytics' && $this->router->fetch_method()=='overallConference')?' active':''?>">
								<i class="nav-icon fas fa-desktop"></i>
								<p class="text">Overall Conference</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/push_notification'?>" class="nav-link<?=($this->router->fetch_class()=='push_notification')?' active':''?>">
						<i class="nav-icon fas fa-comment-alt" aria-hidden="true"></i>
						<p>Push Notification</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?=$this->project_url.'/admin/settings'?>" class="nav-link<?=($this->router->fetch_class()=='settings')?' active':''?>">
						<i class="nav-icon fas fa fa-cog" aria-hidden="true"></i>
						<p>Settings</p>
					</a>
				</li>

<!--				<li class="nav-item">-->
<!--					<a href="pages/widgets.html" class="nav-link">-->
<!--						<i class="nav-icon fas fa-th"></i>-->
<!--						<p>-->
<!--							Widgets-->
<!--							<span class="right badge badge-danger">New</span>-->
<!--						</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-copy"></i>-->
<!--						<p>-->
<!--							Layout Options-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--							<span class="badge badge-info right">6</span>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/top-nav.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Top Navigation</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/top-nav-sidebar.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Top Navigation + Sidebar</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/boxed.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Boxed</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/fixed-sidebar.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Fixed Sidebar</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Fixed Sidebar <small>+ Custom Area</small></p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/fixed-topnav.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Fixed Navbar</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/fixed-footer.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Fixed Footer</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/layout/collapsed-sidebar.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Collapsed Sidebar</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-chart-pie"></i>-->
<!--						<p>-->
<!--							Charts-->
<!--							<i class="right fas fa-angle-left"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/charts/chartjs.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>ChartJS</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/charts/flot.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Flot</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/charts/inline.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Inline</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/charts/uplot.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>uPlot</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-tree"></i>-->
<!--						<p>-->
<!--							UI Elements-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/general.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>General</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/icons.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Icons</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/buttons.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Buttons</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/sliders.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Sliders</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/modals.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Modals & Alerts</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/navbar.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Navbar & Tabs</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/timeline.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Timeline</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/UI/ribbons.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Ribbons</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-edit"></i>-->
<!--						<p>-->
<!--							Forms-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/forms/general.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>General Elements</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/forms/advanced.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Advanced Elements</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/forms/editors.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Editors</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/forms/validation.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Validation</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-table"></i>-->
<!--						<p>-->
<!--							Tables-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/tables/simple.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Simple Tables</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/tables/data.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>DataTables</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/tables/jsgrid.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>jsGrid</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-header">EXAMPLES</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="pages/calendar.html" class="nav-link">-->
<!--						<i class="nav-icon fas fa-calendar-alt"></i>-->
<!--						<p>-->
<!--							Calendar-->
<!--							<span class="badge badge-info right">2</span>-->
<!--						</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="pages/gallery.html" class="nav-link">-->
<!--						<i class="nav-icon far fa-image"></i>-->
<!--						<p>-->
<!--							Gallery-->
<!--						</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="pages/kanban.html" class="nav-link">-->
<!--						<i class="nav-icon fas fa-columns"></i>-->
<!--						<p>-->
<!--							Kanban Board-->
<!--						</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon far fa-envelope"></i>-->
<!--						<p>-->
<!--							Mailbox-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/mailbox/mailbox.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Inbox</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/mailbox/compose.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Compose</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/mailbox/read-mail.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Read</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-book"></i>-->
<!--						<p>-->
<!--							Pages-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/invoice.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Invoice</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/profile.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Profile</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/e-commerce.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>E-commerce</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/projects.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Projects</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/project-add.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Project Add</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/project-edit.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Project Edit</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/project-detail.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Project Detail</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/contacts.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Contacts</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/faq.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>FAQ</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/contact-us.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Contact us</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon far fa-plus-square"></i>-->
<!--						<p>-->
<!--							Extras-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="#" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>-->
<!--									Login & Register v1-->
<!--									<i class="nav-icon fas fa-angle-left right"></i>-->
<!--								</p>-->
<!--							</a>-->
<!--							<ul class="nav nav-treeview">-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/login.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Login v1</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/register.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Register v1</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/forgot-password.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Forgot Password v1</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/recover-password.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Recover Password v1</p>-->
<!--									</a>-->
<!--								</li>-->
<!--							</ul>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="#" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>-->
<!--									Login & Register v2-->
<!--									<i class="nav-icon fas fa-angle-left right"></i>-->
<!--								</p>-->
<!--							</a>-->
<!--							<ul class="nav nav-treeview">-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/login-v2.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Login v2</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/register-v2.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Register v2</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/forgot-password-v2.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Forgot Password v2</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="pages/examples/recover-password-v2.html" class="nav-link">-->
<!--										<i class="far fa-circle nav-icon"></i>-->
<!--										<p>Recover Password v2</p>-->
<!--									</a>-->
<!--								</li>-->
<!--							</ul>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/lockscreen.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Lockscreen</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/legacy-user-menu.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Legacy User Menu</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/language-menu.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Language Menu</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/404.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Error 404</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/500.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Error 500</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/pace.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Pace</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/examples/blank.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Blank Page</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="starter.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Starter Page</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-search"></i>-->
<!--						<p>-->
<!--							Search-->
<!--							<i class="nav-icon fas fa-angle-left right"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/search/simple.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Simple Search</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="pages/search/enhanced.html" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Enhanced</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-header">MISCELLANEOUS</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="iframe.html" class="nav-link">-->
<!--						<i class="nav-icon fas fa-ellipsis-h"></i>-->
<!--						<p>Tabbed IFrame Plugin</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="https://adminlte.io/docs/3.1/" class="nav-link">-->
<!--						<i class="nav-icon fas fa-file"></i>-->
<!--						<p>Documentation</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-header">MULTI LEVEL EXAMPLE</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-circle nav-icon"></i>-->
<!--						<p>Level 1</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-circle"></i>-->
<!--						<p>-->
<!--							Level 1-->
<!--							<i class="right fas fa-angle-left"></i>-->
<!--						</p>-->
<!--					</a>-->
<!--					<ul class="nav nav-treeview">-->
<!--						<li class="nav-item">-->
<!--							<a href="#" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Level 2</p>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="#" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>-->
<!--									Level 2-->
<!--									<i class="right fas fa-angle-left"></i>-->
<!--								</p>-->
<!--							</a>-->
<!--							<ul class="nav nav-treeview">-->
<!--								<li class="nav-item">-->
<!--									<a href="#" class="nav-link">-->
<!--										<i class="far fa-dot-circle nav-icon"></i>-->
<!--										<p>Level 3</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="#" class="nav-link">-->
<!--										<i class="far fa-dot-circle nav-icon"></i>-->
<!--										<p>Level 3</p>-->
<!--									</a>-->
<!--								</li>-->
<!--								<li class="nav-item">-->
<!--									<a href="#" class="nav-link">-->
<!--										<i class="far fa-dot-circle nav-icon"></i>-->
<!--										<p>Level 3</p>-->
<!--									</a>-->
<!--								</li>-->
<!--							</ul>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a href="#" class="nav-link">-->
<!--								<i class="far fa-circle nav-icon"></i>-->
<!--								<p>Level 2</p>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon fas fa-circle nav-icon"></i>-->
<!--						<p>Level 1</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-header">LABELS</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon far fa-circle text-danger"></i>-->
<!--						<p class="text">Important</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon far fa-circle text-warning"></i>-->
<!--						<p>Warning</p>-->
<!--					</a>-->
<!--				</li>-->
<!--				<li class="nav-item">-->
<!--					<a href="#" class="nav-link">-->
<!--						<i class="nav-icon far fa-circle text-info"></i>-->
<!--						<p>Informational</p>-->
<!--					</a>-->
<!--				</li>-->

				<li class="nav-item">
					<a href="<?=$this->project_url.'/authentication/logout/'.base64_encode('admin')?>" class="nav-link">
						<i class="nav-icon fas fa-sign-out-alt text-danger"></i>
						<p class="text">Logout</p>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
