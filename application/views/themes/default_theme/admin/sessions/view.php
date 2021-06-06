<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($session);exit("</pre>");
?>

<style>
	html,
	body,
	.wrapper,
	#presentationEmbed,
	#presentationRow,
	#presentationColumn
	{
		height: 100% !important;
		overflow: hidden;
	}

	#presentationEmbed
	{
		margin-top: calc(3.5rem + 1px);
	}
	#presentationEmbed iframe
	{
		padding: unset !important;
	}

	.middleText
	{
		position: absolute;
		width: auto;
		height: 50px;
		top: 30%;
		left: 45%;
		margin-left: -50px; /* margin is -0.5 * dimension */
		margin-top: -25px;
	}
</style>


<div id="presentationEmbed">
	<div id="presentationRow" class="row m-0 p-0">
		<div id="presentationColumn" class="col-10 m-0 p-0">
			<?php if ($session->presenter_embed_code != ''): ?>
				<?=$session->presenter_embed_code?>
			<?php else: ?>
				<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
					<div class="middleText">
						<h3>No Presentation Found</h3>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-2 m-0 p-0">

			<!-- Host Chat -->
			<div class="card card-primary card-outline direct-chat direct-chat-primary" style="height: 43%;">
				<div class="card-header">
					<h3 class="card-title">Host Chat</h3>

					<div class="card-tools">
<!--						<span title="3 New Messages" class="badge bg-primary">3</span>-->
<!--						<button type="button" class="btn btn-tool" data-card-widget="collapse">-->
<!--							<i class="fas fa-minus"></i>-->
<!--						</button>-->
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<!-- Conversations are loaded here -->
					<div class="direct-chat-messages" style="height: 100% !important;">
						<!-- Message. Default to the left -->
						<div class="direct-chat-msg">
							<div class="direct-chat-infos clearfix">
								<span class="direct-chat-name float-left">Alexander Pierce</span>
								<span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
							</div>
							<!-- /.direct-chat-infos -->
							<img class="direct-chat-img" src="https://localhost/adminLTE/dist/img/user1-128x128.jpg" alt="Message User Image">
							<!-- /.direct-chat-img -->
							<div class="direct-chat-text">
								This is a sample chat text!
							</div>
							<!-- /.direct-chat-text -->
						</div>
						<!-- /.direct-chat-msg -->

						<!-- Message to the right -->
						<div class="direct-chat-msg right">
							<div class="direct-chat-infos clearfix">
								<span class="direct-chat-name float-right">Sarah Bullock</span>
								<span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
							</div>
							<!-- /.direct-chat-infos -->
							<img class="direct-chat-img" src="https://localhost/adminLTE/dist/img/user3-128x128.jpg" alt="Message User Image">
							<!-- /.direct-chat-img -->
							<div class="direct-chat-text">
								This is another sample chat text!
							</div>
							<!-- /.direct-chat-text -->
						</div>
						<!-- /.direct-chat-msg -->
					</div>
					<!--/.direct-chat-messages-->

					<!-- Contacts are loaded here -->
					<div class="direct-chat-contacts">
						<ul class="contacts-list">
							<li>
								<a href="#">
									<img class="contacts-list-img" src="https://localhost/adminLTE/dist/img/user1-128x128.jpg" alt="User Avatar">

									<div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Count Dracula
                            <small class="contacts-list-date float-right">2/28/2015</small>
                          </span>
										<span class="contacts-list-msg">How have you been? I was...</span>
									</div>
									<!-- /.contacts-list-info -->
								</a>
							</li>
							<!-- End Contact Item -->
						</ul>
						<!-- /.contatcts-list -->
					</div>
					<!-- /.direct-chat-pane -->
				</div>
				<!-- /.card-body -->
				<div class="card-footer">
					<form action="#" method="post">
						<div class="input-group">
							<input type="text" name="message" placeholder="Type Message ..." class="form-control">
							<span class="input-group-append">
                      <button type="submit" class="btn btn-primary">Send</button>
                    </span>
						</div>
					</form>
				</div>
				<!-- /.card-footer-->
			</div>

			<!-- Questions -->
			<div class="card card-widget" style="height: 43%;">
				<div class="card-header">
					<h3 class="card-title">Questions</h3>

					<div class="card-tools">
<!--						<span title="3 New Messages" class="badge bg-primary">3</span>-->
<!--						<button type="button" class="btn btn-tool" data-card-widget="collapse">-->
<!--							<i class="fas fa-minus"></i>-->
<!--						</button>-->
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body card-comments" style="height: 100% !important;overflow: scroll;">
					<div class="card-comment">
						<!-- User image -->
						<img class="img-circle img-sm" src="https://localhost/adminLTE/dist/img/user3-128x128.jpg" alt="User Image">

						<div class="comment-text">
                    <span class="username">
                      Maria Gonzales
                      <span class="text-muted float-right">8:03 PM Today</span>
                    </span><!-- /.username -->
							It is a long established fact that a reader will be distracted
							by the readable content of a page when looking at its layout.
						</div>
						<!-- /.comment-text -->
					</div>
					<!-- /.card-comment -->
					<div class="card-comment">
						<!-- User image -->
						<img class="img-circle img-sm" src="https://localhost/adminLTE/dist/img/user4-128x128.jpg" alt="User Image">

						<div class="comment-text">
                    <span class="username">
                      Luna Stark
                      <span class="text-muted float-right">8:03 PM Today</span>
                    </span><!-- /.username -->
							It is a long established fact that a reader will be distracted
							by the readable content of a page when looking at its layout.
						</div>
						<!-- /.comment-text -->
					</div>
					<!-- /.card-comment -->
				</div>
				<!-- /.card-body -->

			</div>

		</div>
	</div>
</div>

<script>
	$(function () {
		$('#mainTopMenu').css('margin-left', 'unset !important');
		$('#pushMenuItem').hide();
	});
</script>
