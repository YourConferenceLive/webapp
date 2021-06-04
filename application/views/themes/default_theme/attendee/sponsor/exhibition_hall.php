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
			width: 100%;
			height: 50%;
			font-size: 50px;
			text-align: center;
			color: #aaa;
			background-color: #fff;
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
	</style>


<div class="vertical-center" id="loadingScreen">Loading<br>
	<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/loading.gif">
</div>
<canvas id="renderCanvas" touch-action="none" width="1794" height="824" style="touch-action: none; opacity: 1;" tabindex="1"></canvas>

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

<div id="notSupported" class="hidden">We are sorry but your browser does not support WebGL...</div>

<script src="<?= ycl_root ?>/vendor_frontend/3d_exhibition/assets/loader.js"></script>