<?php 

if(isset($_GET['username'])===true &&empty($_GET['username'])===false){
	include 'core/init.php';
	$username   =$getFromUser->checkInput($_GET['username']);
	$profileId  =$getFromUser->userIdByUsername($username);
	$profileData=$getFromUser->userData($profileId);
	$boolVisitorOwner=false;
	$privateProfile=$profileData->private;

	if(isset($_SESSION['user_id'])){
		$user_id=$_SESSION['user_id'];
		$userData=$getFromUser->userData($user_id);
		if($user_id==$profileData->user_id){
			$boolVisitorOwner=true;
		}
	}
	else{
		$user_id='';
	}
	if(!$profileData){
		header("Location: index.php");
	}

}

 ?>


 <!--
   This template created by Meralesson.com 
   This template only use for educational purpose 
-->
<!doctype html>
<html>
	<head>
		<title>twitter</title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	  

    </head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">	
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL;?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<?php if($getFromUser->loggedIn()===true){ ?>
				<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
				<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
				 <?php } ?>
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result"> 			
					</div>
				</li>

				<?php if($getFromUser->loggedIn()===true){ ?>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img style="height: 40px;" src="<?php echo BASE_URL.$userData->profileImage;?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$userData->username;?>"><?php echo $userData->username;?></a></li>
							<li><a href="<?php echo BASE_URL; ?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL; ?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet" class="addTweetBtn">Tweet</label></li>
			    <?php }else{
			    	echo '<li><a href="'.BASE_URL.'index.php">Have an account? Log in!</a></li>';
			    } ?>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->
<!-- imporing js query used to handle search -->
<script type="text/javascript" src="assets/js/search.js"></script>
<script type="text/javascript" src="assets/js/hashtag.js"></script>

<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
		<!-- PROFILE-COVER -->
		<img src="<?php echo BASE_URL.$profileData->profileCover;?>"/>
	</div>
</div>
<div class="profile-nav">
 <div class="profile-navigation">
	<ul>
		<li>
		<div class="n-head">
			TWEETS

		</div>
		<div class="n-bottom">
		  <?php $getFromTweet->countTweets($profileId); ?>
		</div>
		</li>
		<li>
			<a href="<?php echo BASE_URL.$profileData->username;?>/following">
				<div class="n-head">
					<a href="<?php echo BASE_URL.$profileData->username;?>/following">FOLLOWING</a>
				</div>
				<div class="n-bottom">
					<span class="count-following"><?php echo $profileData->following;?></span>
				</div>
			</a>
		</li>
		<li>
		 <a href="<?php echo BASE_URL.$profileData->username;?>/followers">
				<div class="n-head">
					FOLLOWERS
				</div>
				<div class="n-bottom">
					<span class="count-followers"><?php echo $profileData->followers;?></span>
				</div>
			</a>
		</li>
		<li>
			<a href="#">
				<div class="n-head">
					LIKES
				</div>
				<div class="n-bottom">
				<?php $getFromTweet->countlikes($profileId); ?>

				</div>
			</a>
		</li>
	</ul>
	<div class="edit-button">
		<span>
				<?php echo  $getFromFollow->followBtn($profileId,$user_id,$profileData->user_id); ?>	
		</span>
	</div>
    </div>
</div>
</div><!--Profile Cover End-->


<!---Inner wrapper-->
<div class="in-wrapper">
 <div class="in-full-wrap">
   <div class="in-left">
     <div class="in-left-wrap">
	<!--PROFILE INFO WRAPPER END-->
	<div class="profile-info-wrap">
	 <div class="profile-info-inner">
	 <!-- PROFILE-IMAGE -->
		<div class="profile-img">
			<img src="<?php echo BASE_URL.$profileData->profileImage;?>"/>
		</div>	

		<div class="profile-name-wrap">
			<div class="profile-name">
				<a href="<?php echo BASE_URL.$profileData->username;?>"><?php echo $profileData->screenName;?></a>
			</div>
			<div class="profile-tname">
				@<span class="username"><?php echo $profileData->username;?></span>
			</div>
		</div>

		<div class="profile-bio-wrap">
		 <div class="profile-bio-inner">
		    <?php echo $profileData->bio;?>
		 </div>
		</div>

<div class="profile-extra-info">
	<div class="profile-extra-inner">
		<ul>
			<!-- This is only to be displayed iff country value is set in user's profile. -->
			<?php if(!empty($profileData->country)){ ?> 
				<li>
					<div class="profile-ex-location-i">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
					</div>
					<div class="profile-ex-location">
							<?php echo $profileData->country;?>
					</div>
				</li>
			<?php } ?>

			<?php if(!empty($profileData->website)){  ?>

			<li>
				<div class="profile-ex-location-i">
					<i class="fa fa-link" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
					<a href="<?php echo $profileData->website;?>" target="_blink"><?php echo $profileData->website;?></a>
				</div>
			</li>
			<?php } ?>


			<li>
				<div class="profile-ex-location-i">
					<!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
				</div>
				<div class="profile-ex-location">
 				</div>
			</li>
			<li>
				<div class="profile-ex-location-i">
					<!-- <i class="fa fa-tint" aria-hidden="true"></i> -->
				</div>
				<div class="profile-ex-location">
				</div>
			</li>
		</ul>						
	</div>
</div>

<div class="profile-extra-footer">
	<div class="profile-extra-footer-head">
		<div class="profile-extra-info">
			<ul>
				<li>
					<div class="profile-ex-location-i">
						<i class="fa fa-camera" aria-hidden="true"></i>
					</div>
					<div class="profile-ex-location">
						<a href="#">0 Photos and videos </a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="profile-extra-footer-body">
		<ul>
			 <!-- <li><img src="#"/></li> -->
		</ul>		
	</div>
</div>

	 </div>
	<!--PROFILE INFO INNER END-->

	</div>
	<!--PROFILE INFO WRAPPER END-->

	</div>
	<!-- in left wrap-->

  </div>
	<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">
	<!--Tweet SHOW WRAPER-->

    <?php
    $getFromTweet->tweets($user_id,$profileId,$boolVisitorOwner,$privateProfile); 

    ?>


	<!--Tweet SHOW WRAPER END-->
	</div><!-- in left wrap-->
  <div class="popupTweet"></div>
</div>
<!-- in center end -->
 			<script type="text/javascript" src ="assets/js/like.js"></script>
 			<script type="text/javascript" src ="assets/js/retweet.js"></script>
 			<script type="text/javascript" src ="assets/js/popuptweets.js"></script>
 			<script type="text/javascript" src ="assets/js/comment.js"></script>
 			<script type="text/javascript" src ="assets/js/delete.js"></script>
 			<script type="text/javascript" src ="assets/js/follow.js"></script>
 			<script type="text/javascript" src ="assets/js/messages.js"></script>
<div class="in-right">
	<div class="in-right-wrap">
			
		<!--==WHO TO FOLLOW==-->
	      <!--who to follow-->
		<!--==WHO TO FOLLOW==-->
			
		<!--==TRENDS==-->
	 	   <!--Trends-->
	 	<!--==TRENDS==-->
			
	</div><!-- in right wrap-->
</div>
<!-- in right end -->

		</div>
		<!--in full wrap end-->
	</div>
	<!-- in wrappper ends-->	
 </div>
 <!-- ends wrapper -->
</body>
</html>
