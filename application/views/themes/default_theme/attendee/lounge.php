<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "<pre>";
//print_r($lounge_user);
//exit("</pre>");
?>

<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/lounge.css?v=<?=rand()?>" rel="stylesheet">
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/lounge_chats/group_chat.css?v=<?=rand()?>" rel="stylesheet">

<div class="loung-container">
    <div class="tv">
        <img src="<?=ycl_root?>/theme_assets/lounge/tv.png" id="tv">
        <iframe src="https://player.vimeo.com/video/565322231?autoplay=1&loop=1&title=0&byline=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>
<img id="peoples" src="<?=ycl_root?>/theme_assets/lounge/peoples.png">


<div class="chat-boxes-container"> <!-- position: absolute (lounge.css:193) -->
    <div class="container-fluid">

        <!-- Everything is inside this row -->
        <div class="row">

            <!-- Column for group chat -->
            <div class="col-md-4 col-sm-12">
                <div class="card" style="background: #ffffffe3;">
                    <h6 class="card-header text-center">Group Chat</h6>
                    <div class="card-body p-0 pl-1 pr-1 pb-2">

                        <div id="groupChatBody">
                            <div id="groupChatMessages" style="height: 100%;overflow: scroll;padding-top: 15px;">
                                <?php foreach ($allGroupChats as $groupChat): ?>
                                    <?php if ($groupChat->from_id == $lounge_user->id): ?>
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-right"><?=$groupChat->name?> <?=$groupChat->surname?><?=($groupChat->credentials!='')?', '.$groupChat->credentials:''?><br><small><?=$groupChat->company_name?></small></span>
                                                <span class="direct-chat-timestamp float-left"><?=date('F d g:i A', strtotime($groupChat->date_time))?></span>
                                            </div>
                                            <img class="direct-chat-img" src="<?=ycl_root?>/cms_uploads/user_photo/profile_pictures/<?=$groupChat->photo?>" onerror="this.onerror=null;this.src=`<?=ycl_root?>/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">
                                            <div class="direct-chat-text"><?=$groupChat->message?></div>
                                        </div>
                                    <?php else: ?>
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name float-left"><?=$groupChat->name?> <?=$groupChat->surname?><?=($groupChat->credentials!='')?', '.$groupChat->credentials:''?><br><small><?=$groupChat->company_name?></small></span>
                                                <span class="direct-chat-timestamp float-right"><?=date('F d g:i A', strtotime($groupChat->date_time))?></span>
                                            </div>
                                            <img class="direct-chat-img" src="<?=ycl_root?>/cms_uploads/user_photo/profile_pictures/<?=$groupChat->photo?>" onerror="this.onerror=null;this.src=`<?=ycl_root?>/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">
                                            <div class="direct-chat-text"><?=$groupChat->message?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <div class="input-group mb-1">
                            <input id="groupChatMsg" type="text" class="form-control" placeholder="Press enter key to send..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button id="sendGroupChatBtn" class="btn btn-outline-success" type="button"><i class="far fa-paper-plane"></i> Send</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Column for OTO Chat -->
            <div class="col-md-8  col-sm-12">
                <div class="card" style="background: #ffffffe3;">
                    <h6 class="card-header text-center">Direct Chat <span id="directChatWithName"></span></h6>
                    <div class="card-body p-0 pl-1 pr-1">
                        <div id="otoChatBody">
                            <div class="row">
                                <div id="otoChatUsersBody" class="col-md-6">
                                    <input id="directChatUserSearch" type="text" class="form-control" placeholder="Search for people" >
                                    <ul id="directChatUsersList" class="list-group" style="height: 90%; overflow: scroll;">
                                        <?php foreach ($allUsers as $user): ?>
                                            <li class="directChatUsersListItem list-group-item pl-1" user-id="<?=$user->id?>" user-name="<?=$user->name?> <?=$user->surname?>" style="cursor: pointer;">
                                                <img class="direct-chat-img mr-1" src="https://www.yourconference.live/ycl_assets/images/person_dp_placeholder.png" onerror="this.onerror=null;this.src=`https://www.yourconference.live/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">
                                                <!--<span class="float-right"><i class="fas fa-circle" style="color: #ffb425;"></i></span>-->
                                                <?=$user->name?> <?=$user->surname?><?=($user->credentials!='')?', '.$user->credentials:''?>
                                                <br><small><?=$user->company_name?></small>
                                                <!--<button class="btn btn-sm btn-info float-right"><i class="fas fa-video"></i></button>-->
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div id="otoChatMessagesBody" class="col-md-6">
                                    <div id="otoChatMessages" style="height: 89%;overflow: scroll;padding-top: 15px;">
                                        <span>Select a person to chat</span>
                                    </div>

                                    <div class="input-group mb-1">
                                        <input id="directChatMessage" type="text" class="form-control" placeholder="Press enter key to send..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button id="directChatSendBtn" user-id="0" class="btn btn-outline-success" type="button"><i class="far fa-paper-plane"></i> Send</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let lounge_user_id = "<?=$lounge_user->id?>";
    let lounge_user_name = "<?=$lounge_user->name?> <?=$lounge_user->surname?>";
    let lounge_user_credentials = "<?=($lounge_user->credentials!='')?', '.$lounge_user->credentials:''?>";
    let lounge_user_company_name = "<?=$lounge_user->company_name?>";
    let lounge_user_photo = "<?=$lounge_user->photo?>";
</script>
<script src="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/lounge_chats/group_chat.js?v=<?=rand()?>"></script>
<script src="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/lounge_chats/direct_chat.js?v=<?=rand()?>"></script>
