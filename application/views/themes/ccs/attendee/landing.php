<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	<?php if(file_exists(FCPATH."cms_uploads/projects/{$this->project->id}/theme_assets/ccs/landing_background.jpg")): ?>
	body{
		background-image: url("<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/landing_background.jpg");
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	<?php endif; ?>
</style>

<link href="<?=ycl_root?>/theme_assets/ccs/<?=$this->project->theme?>/css/landing.css" rel="stylesheet">
<body class="text-center">
<div class="cover-container d-flex h-100 p-3 mx-auto flex-column" style="padding-top: 15% !important;">
	<main role="main" class="inner cover">
		<p class="lead">
			<a href="<?=$this->project_url?>/login" class="btn btn-lg btn-secondary">Login</a>
			<a href="<?=$this->project_url?>/register" class="btn btn-lg btn-secondary">Register</a>
		</p>
	</main>
</div>
</body>
