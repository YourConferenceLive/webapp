	<script src="https://code.jquery.com/pep/0.4.2/pep.min.js"></script>
	<script src="https://preview.babylonjs.com/babylon.js"></script>
	<script src="https://preview.babylonjs.com/loaders/babylonjs.loaders.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.2/dat.gui.min.js"></script>
	<script src="https://preview.babylonjs.com/cannon.js"></script>
	<script src="https://preview.babylonjs.com/Oimo.js"></script>
	<script src="https://preview.babylonjs.com/libktx.js"></script>
	<script src="https://preview.babylonjs.com/earcut.min.js"></script>
	<script src="https://preview.babylonjs.com/inspector/babylon.inspector.bundle.js"></script>
	<script src="https://preview.babylonjs.com/materialsLibrary/babylonjs.materials.min.js"></script>
	<script src="https://preview.babylonjs.com/proceduralTexturesLibrary/babylonjs.proceduralTextures.min.js"></script>
	<script src="https://preview.babylonjs.com/postProcessesLibrary/babylonjs.postProcess.min.js"></script>
	<script src="https://preview.babylonjs.com/serializers/babylonjs.serializers.min.js"></script>
	<script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>

	<link rel="stylesheet" href="<?= ycl_root ?>/vendor_frontend/3d_exhibition/assets/index.css">
	<link rel="stylesheet" href="<?= ycl_root ?>/vendor_frontend/3d_exhibition/assets/main.css">
	<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/exhibition_hall.css?v=<?=rand()?>" rel="stylesheet">
	<script src="<?= ycl_root ?>/vendor_frontend/3d_exhibition/assets/pep.min.js"></script>
	<style>
		[touch-action="none"]{ -ms-touch-action: none; touch-action: none; touch-action-delay: none; }
		[touch-action="auto"]{ -ms-touch-action: auto; touch-action: auto; touch-action-delay: none; }
		[touch-action="pan-x"]{ -ms-touch-action: pan-x; touch-action: pan-x; touch-action-delay: none; }
		[touch-action="pan-y"]{ -ms-touch-action: pan-y; touch-action: pan-y; touch-action-delay: none; }
		[touch-action="pan-x pan-y"],[touch-action="pan-y pan-x"]{ -ms-touch-action: pan-x pan-y; touch-action: pan-x pan-y; touch-action-delay: none; }
	</style>

	<script src="<?= ycl_root ?>/vendor_frontend/3d_exhibition/assets/demo.js"></script>

	<style type="text/css">
		@-webkit-keyframes spin1 {
			0% { -webkit-transform: rotate(0deg);}
			100% { -webkit-transform: rotate(360deg);}
		}
		@keyframes spin1 {
			0% { transform: rotate(0deg);}
			100% { transform: rotate(360deg);}
		}
		#mensaje
		{
			position:absolute;right:20px;top:10em;font-size:20px;color:#fff;text-shadow:2px 2px 0 #000
		}
		#stats
		{
			position:absolute;text-align:left;left:5px;top:3px;font-size:22px;color:#fff;text-shadow:2px 2px 0 #000
		}

		#loadingScreen {
			position: absolute;
			left: 45%;
			width: 10%;
			height: 5%;
			font-size: 50px;
			text-align: center;
			color: #aaa;
			z-index: 9999;
		}

		.vertical-center {
			margin: 0;
			position: absolute;
			top: 50%;
			-ms-transform: translateY(-50%);
			transform: translateY(-50%);
		}

		.multi-spinner-container {
			width: 150px;
			height: 150px;
			position: relative;
			margin: 30px auto;
			overflow: hidden;
		}

		.multi-spinner {
			position: absolute;
			width: calc(100% - 9.9px);
			height: calc(100% - 9.9px);
			border: 5px solid transparent;
			border-top-color: #ff5722;
			border-radius: 50%;
			-webkit-animation: spin 5s cubic-bezier(0.17, 0.49, 0.96, 0.76) infinite;
			animation: spin 5s cubic-bezier(0.17, 0.49, 0.96, 0.76) infinite;
		}

		.xy-center
		{
			position: absolute;
			z-index: 1001;
			left: 48.5%;
			top: 75%;
		}

		@-webkit-keyframes spin {
			from {
				-webkit-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			to {
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}

		@keyframes spin {
			from {
				-webkit-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			to {
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}

		.content2 {
                position: absolute;
                left: 50%;
                top: 50%;
                -webkit-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                background: rgba(255, 255, 255, 0.7);
                padding: 20px;
                border: 3px solid #eee;
                border-radius: 10px;
                text-align:center;
            }
		#buttonx
            {
                border-radius: 15px ;
                color:#444;
                font-size:20px;
            }
		.center {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 75%;
            }

		#mainMenu{
			z-index: 100;
		}
	</style>


<button id="enterButton" class="btn btn-primary xy-center">ENTER</button>
<img id="full-screen-background" src="<?=ycl_root?>/theme_assets/default_theme/images/exhibition/bg.jpg" usemap="#workmap" style="margin-top: 67px;z-index: 1000;">
<!--<img id="full-screen-background" src="https://dev.yourconference.live/cms_uploads/projects/3/other_images/exhibition_landing.jpeg" usemap="#workmap" style="margin-top: 67px;z-index: 1000;">-->

<div class="vertical-center" id="loadingScreen">Loading<br>
	<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/loading.gif">
</div>
<div id="bg"></div>

<div class="content2" id="instrucciones" style="display:none;">
        <img class="center" src="https://yourconference.live/vendor_frontend/3d_exhibition/assets/flechitas.png"><br>        
        <button type="button" onClick="cerrarventanas();" class="center" id="buttonx" value="entendido"><h3>Ok</h3></button>
</div>

<canvas id="renderCanvas" touch-action="none" style="touch-action: none; opacity: 1;width:100%; height:calc(100% - 67px);z-index: 0;" tabindex="1"></canvas>

<div id="controlPanel" style="display:none;">
	<div id="controlsZone">
		<p>
			<button id="enableDebug">Debug layer</button>
		</p>
		<p>
			<button id="fullscreen">Fullscreen</button>
		</p>
	</div>
	<div class="tag">Control panel</div>
	<div class="tag" id="clickableTag"></div>
</div>

<?
echo "<script>ycl_root='".ycl_root."';</script>";

if ($this->user['is_exhibitor'])
{
	echo "<script>is_exhibitor=true;</script>";
}
else
{
	echo "<script>is_exhibitor=false;</script>";
}
?>
<div id="notSupported" class="hidden">We are sorry but your browser does not support WebGL...</div>

<script>
	let is_exhibitor = "<?=$_SESSION['project_sessions']["project_{$this->project->id}"]['is_exhibitor']?>";
</script>
<script src="<?= ycl_root ?>/vendor_frontend/3d_exhibition/assets/loader.js"></script>
<script>
	$('#enterButton').on('click', function () {
		$(this).hide();
		$('#full-screen-background').hide();
		$("#bg").remove();
	});
</script>
