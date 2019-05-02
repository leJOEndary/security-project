

<?php 
//this page is used to update email and username.
include  'core/init.php';

$user_id=$_SESSION['user_id'];
$userData = $getFromUser->userData($user_id);
if($getFromUser->loggedIn()===false){
	header('Location: '.BASE_URL.'index.php');
}


if(isset($_POST['submit'])){
$username=$getFromUser->checkInput($_POST['username']);
$email=$getFromUser->checkInput($_POST['email']);
$Privacy=$getFromUser->checkInput($_POST['privacy']);

$error=array();
if(!empty($username) and !empty($email) and !empty($Privacy)){
	if($userData->username != $username and $getFromUser->checkUsername($username)===true){
		$error['username']="The username is not available";

	}elseif(preg_match("/[a-zA-Z0-9\!]",$username)){
		$error['username']="Only characters and numbers are allowed";
	}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$error['email']="invalid email format";
	}elseif($userData->email != $email and $getFromUser->checkEmail($email)===true){
		$error['email']="The email is already in use";

	}else{
		if($Privacy=='public'){
			$boolean=false;
		}
		elseif($Privacy=='private'){
			$boolean=true;
		}
			$splitted_mail=preg_split ("/\@/", $email);
			$salt=$splitted_mail[0];
			$currpassword=$userData->password;
			$password=md5($currpassword.$salt);
			$getFromUser->update('users',$user_id,array('username'=>$username,'email'=>$email ,'private'=>$boolean,'password'=>$password));

		header('Location: '.BASE_URL.'settings/account');
	}
}
else{
	$error['fields']="All fields are required";
}

}

 ?>


<html>
	<head>
		<title>Account settings page</title>
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
 				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$userData->profileImage; ?>"  style="height: 40px;"/></label>
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
						<h2>Account</h2>
						<h3>Change your basic account settings.</h3>
					</div>
					<div class="acc-content">
					<form method="POST">
						<div class="acc-wrap">
							<div class="acc-left">
								USERNAME
							</div>
							<div class="acc-right">
								<input type="text" name="username" value="<?php echo $userData->username; ?>"/>
								<span>
									<?php if(isset($error['username'])){
										echo $error['username'];
									} ?>
 								</span>
							</div>
						</div>

						<div class="acc-wrap">
							<div class="acc-left">
								Email
							</div>
							<div class="acc-right">
								<input type="text" name="email" value="<?php echo $userData->email; ?>"/>
								<span>
									<!-- Email Error -->
									<?php if(isset($error['email'])){
										echo $error['email'];
									} ?>
								</span>
							</div>
						</div>

						<div class="acc-wrap">
							<div class="acc-left">
								Account's Privacy
							</div>
							<div class="acc-right">
							<label class="container">Public
									  <input type="radio" checked="checked" name="privacy" value="public">
									  <span class="checkmark"></span>
									</label>
									<label class="container">Private
									  <input type="radio" name="privacy" value="private">
									  <span class="checkmark"></span>
									</label>
							</div>
						</div>


						<div class="acc-wrap">
							<div class="acc-left">
								
							</div>
							<div class="acc-right">
								<input type="Submit" name="submit" value="Save changes"/>
							</div>
							<div class="settings-error">
								<!-- Fields Error -->
								<?php if(isset($error['fields'])){
										echo $error['fields'];
									} ?>
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
		</div><!--RIGHTER ENDS-->

	</div>
	<!--CONTAINER_WRAP ENDS-->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/delete.js"></script>
	</div><!-- ends wrapper -->
</body>

</html>

