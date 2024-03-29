<?php 
include '../init.php';

if(isset($_POST['showChatMessage']) && !empty($_POST['showChatMessage'])){

	$user_id=$_SESSION['user_id'];
	$messageFrom = $_POST['showChatMessage'];
	$getFromMessage->getMessages($messageFrom,$user_id);
}
if(isset($_POST['showMessage']) && !empty($_POST['showMessage'])){

	$user_id=$_SESSION['user_id'];
	$messages=$getFromMessage->recentMessages($user_id);
	?>

		<div class="popup-message-wrap">
			<input id="popup-message-tweet" type="checkbox" checked="unchecked"/>
			<div class="wrap2">
			<div class="message-send">
				<div class="message-header">
					<div class="message-h-left">
						<label for="mass"><i class="fa fa-angle-left" aria-hidden="true"></i></label>
					</div>
					<div class="message-h-cen">
						<h4>New message</h4>
					</div>
					<div class="message-h-right">
						<label for="popup-message-tweet" ><i class="fa fa-times" aria-hidden="true"></i></label>
					</div>
				</div>
				<div class="message-input">
					<h4>Send message to:</h4>
				  	<input type="text" placeholder="Search people" class="search-user"/>
					<ul class="search-result down">
							
					</ul>
				</div>
				<div class="message-body">
					<h4>Recent</h4>
					<div class="message-recent">
					<?php foreach ($messages as $message) : ?>
						echo '<!--Direct Messages-->
						<div class="people-message" data-user="'.$message->user_id.'">
							<div class="people-inner">
								<div class="people-img">
									<img src="<?php echo BASE_URL.$message->profileImage; ?>"/>
								</div>
								<div class="name-right2">
									<span><a href="#"><?php echo $message->screenName;?></a></span><span>@<?php echo $message->username; ?></span>
								</div>
								
								<span>
									<?php echo $getFromUser->timeAgo($message->messageOn); ?>
								</span>
							</div>
						</div>
						<!--Direct Messages-->';

				 
					<?php  endforeach;?>	
						
					</div>
				</div>
				<!--message FOOTER-->
				<div class="message-footer">
					<div class="ms-fo-right">
						<label>Next</label>
					</div>
				</div><!-- message FOOTER END-->
			</div><!-- MESSGAE send ENDS-->
			 
			 
				<input id="mass" type="checkbox" checked="unchecked" />
				<div class="back">
					<div class="back-header">
						<div class="back-left">
							Direct message
						</div>
						<div class="back-right">
							<label for="mass"  class="new-message-btn">New messages</label>
							<label for="popup-message-tweet"><i class="fa fa-times" aria-hidden="true"></i></label>
						</div>
					</div>
					<div class="back-inner">
						<div class="back-body">
					<?php foreach ($messages as $message) :?>		
						<!--Direct Messages-->
							<div class="people-message" data-user="<?php echo $message->user_id;?>">
								<div class="people-inner">
									<div class="people-img">
										<img src="<?php echo BASE_URL.$message->profileImage; ?>"/>
									</div>
									<div class="name-right2">
										<span><a href="#"><?php echo $message->screenName;?></a></span><span>@<?php echo $message->username; ?></span>
									</div>
									<div class="msg-box">
										<?php echo $message->message; ?>
									</div>

									<span>
										<?php echo $getFromUser->timeAgo($message->messageOn); ?>
									</span>
								</div>
							</div>
							<!--Direct Messages-->
						 <?php endforeach ;?>	
						</div>
					</div>
					<div class="back-footer">

					</div>
				</div>
			</div>
			</div>
			<!-- POPUP MESSAGES END HERE -->
	
 <?php 
    }
 ?>


 <?php 
   if(isset($_POST['showChatPopup']) && !empty($_POST['showChatPopup'])){
  	$messageFrom = $_POST['showChatPopup'];
  	$user_id	 = $_SESSION['user_id'];
  	$user 		 = $getFromUser->userData($messageFrom);

  	?>
		<!-- MESSAGE CHAT START -->
	<div class="popup-message-body-wrap">
		<input id="popup-message-tweet" type="checkbox" checked="unchecked"/>
		<input id="message-body" type="checkbox" checked="unchecked"/>
		<div class="wrap3">
		<div class="message-send2">
			<div class="message-header2">
				<div class="message-h-left">
					<label class="back-messages" for="mass"><i class="fa fa-angle-left" aria-hidden="true"></i></label>
				</div>
				<div class="message-h-cen">
					<div class="message-head-img">
					<img src="<?php echo BASE_URL.$user->profileImage; ?>"/><h4>Messages</h4>
					</div>
				</div>
				<div class="message-h-right">
				  <label class="close-msgPopup" for="message-body" ><i class="fa fa-times" aria-hidden="true"></i></label> 
				</div>
				<div class="message-del">
					<div class="message-del-inner">
						<h4>Are you sure you want to delete this message? </h4>
						<div class="message-del-box">
							<span>
								<button class="cancel" value="Cancel">Cancel</button>
							</span>
							<span>	
								<button class="delete" value="Delete">Delete</button>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="main-msg-wrap">
		      <div id="chat" class="main-msg-inner">
		     <!-- HERE WE WILL DISPLAY THE MESSAGES -->

		 	  </div>
			</div>
			<div class="main-msg-footer">
				<div class="main-msg-footer-inner">
					<ul>
						<li><textarea id="msg" name="msg" placeholder="Write some thing!"></textarea></li>
						<li><input id="msg-upload" type="file" value="upload"/><label for="msg-upload"><i class="fa fa-camera" aria-hidden="true"></i></label></li>
						<li><input id="send" type="submit" value="Send"/></li>
					</ul>
				</div>
			</div>
		 </div> <!--MASSGAE send ENDS-->
		</div> <!--wrap 3 end-->
		</div><!--POP UP message WRAP END-->
<?php } ?>