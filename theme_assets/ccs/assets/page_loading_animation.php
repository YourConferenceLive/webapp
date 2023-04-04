<style>
.page-loading-animation{
	z-index: 1000;
	position: absolute;
	top: 0;
	border: 0;
	width: 100%;
	height: 95%;
	background-color: white;
}
</style>

<div class="page-loading-animation">
	<img src="<?=$_GET['ycl_root']?>/ycl_assets/ycl_anime_500kb.gif" width="200px" style="margin-top: 20%;margin-left: 45%;">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementsByClassName('page-loading-animation')[0].style.visibility = 'hidden';
    }, false);
</script>
