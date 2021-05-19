<header>
	<nav class="navbar navbar-expand-md navbar-light fixed-top bg-white">
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
					<a class="nav-link" href="<?=base_url().$this->project->main_route?>/sessions">Sessions</a>
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
