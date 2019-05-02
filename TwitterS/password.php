<?php 
include 'core/init.php';
$user_id = $_SESSION['user_id'];
$userData=$getFromUser->userData($user_id);
if($getFromUser->loggedIn()===false){
	header("Location: ".BASE_URL."index.php");
 }
if(isset($_POST['submit'])){
	$currentPwd=$_POST['currentPwd'];
	$newPassword=$_POST['newPassword'];
	$rePassword=$_POST['rePassword'];
	$error=array();
	if(!empty($currentPwd)&& !empty($newPassword)&& !empty($rePassword)){
		if($getFromUser->checkPassword($userData->username,$currentPwd)===true){
			if(strlen($newPassword)<6){
				$error['newPassword']="Password is too short";

			}elseif ($newPassword != $rePassword) {
				$error['rePassword'] ="Password does not  match";
			}else{
			$salt=$userData->salt;
			$getFromUser->update('users',$user_id,array('password'=>md5($newPassword.$salt)));
			header("Location: ".BASE_URL.$userData->username);
			}
		}else{$error['currentPwd']="Password is incorrect";}
	}
	else{$error['fields']="All fields are required";}


	

}

 ?>
<html>
	<head>
		<title>Password settings page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
	</head>
	<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">

<div class="nav-container">
  <!-- Nav -->
   <div class="nav">
		 <div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL;?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
 				<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
				<li id="messagePopup" rel="user_id"><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
 			</ul>
		</div>
		<!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i></li>
				<div class="nav-right-down-wrap">
					<ul class="search-result">
					
					</ul>
				</div>
 				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$userData->profileImage; ?>" style="height: 50px;"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$userData->username; ?>"><?php echo $userData->username;?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet">Tweet</label></li>

			</ul>
		</div>
		<!-- nav right ends-->
 
	</div>
	<!-- nav ends -->

</div><!-- nav container ends -->
</div><!-- header wrapper end -->
		<!-- imporing js query used to handle search -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/delete.js"></script>
	<div class="container-wrap">

		<div class="lefter">
			<div class="inner-lefter">

				<div class="acc-info-wrap">
					<div class="acc-info-bg">
						<!-- PROFILE-COVER -->
						<img src="<?php echo BASE_URL.$userData->profileCover ?>"/>  
					</div>
					<div class="acc-info-img">
						<!-- PROFILE-IMAGE -->
						<img src="<?php echo BASE_URL.$userData->profileImage; ?>"/>
					</div>
					<div class="acc-info-name">
						<h3><?php echo $userData->screenName;?></h3>
						<span><a href="<?php echo BASE_URL.$userData->username; ?>"><?php echo $userData->username ;?></a></span>
					</div>
				</div><!--Acc info wrap end-->

				<div class="option-box">
					<ul> 
						<li>
							<a href="<?php echo BASE_URL; ?>settings/account" class="bold">
							<div>
								Account
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL; ?>settings/password">
							<div>
								Password
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL; ?>profileEdit.php">
							<div>
								Edit Profile
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
					</ul>
				</div>

			</div>
		</div><!--LEFTER ENDS-->
	
	<div class="righter">
		<div class="inner-righter">
			<div class="acc">
				<div class="acc-heading">
					<h2>Password</h2>
					<h3>Change your password or recover your current one.</h3>
				</div>
				<form method="POST">
				<div class="acc-content">
					<div class="acc-wrap">
						<div class="acc-left">
							Current password
						</div>
						<div class="acc-right">
							<input type="password" name="currentPwd"/>
							<span>
								<!-- Current Pwd Error -->
								<?php if(isset($error['currentPwd'])){echo $error['currentPwd'];} ?>
							</span>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left">
							New password
						</div>
						<div class="acc-right">
							<input type="password" name="newPassword" />
							<span>
								<!-- NewPassword Error -->
								<?php if(isset($error['newPassword'])){echo $error['newPassword'];} ?>
							</span>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left">
							Verify password
						</div>
						<div class="acc-right">
							<input type="password" name="rePassword"/>
							<span>
								<!-- RePassword Error -->
								<?php if(isset($error['rePassword'])){echo $error['rePassword'];} ?>

							</span>
						</div>
					</div>
					<div class="acc-wrap">
						<div class="acc-left">
						</div>
						<div class="acc-right">
							<input type="Submit" name="submit" value="Save changes"/>
						</div>
						<div class="settings-error">
							<?php if(isset($error['fields'])){echo $error['fields'];} ?>
							<!-- Fields Error -->
 						</div>	
					</div>
				 </form>
				</div>
			</div>
			<div class="content-setting">
				<div class="content-heading">
					
				</div>
				<div class="content-content">
					<div class="content-left">
						
					</div>
					<div class="content-right">
						
					</div>
				</div>
			</div>
		</div>	
	</div>
	 		<script type="text/javascript" src ="assets/js/like.js"></script>
 			<script type="text/javascript" src ="assets/js/retweet.js"></script>
 			<script type="text/javascript" src ="assets/js/popuptweets.js"></script>
 			<script type="text/javascript" src ="assets/js/comment.js"></script>
 			<script type="text/javascript" src ="assets/js/delete.js"></script>
	<!--RIGHTER ENDS-->
</div>
<!--CONTAINER_WRAP ENDS-->
</div>
<!-- ends wrapper -->
</body>
</html>
