<?php 

	if(isset($_POST['signup'])){
		$screenName=$_POST['screenName'];
		$password=$_POST['password'];
		$email=$_POST['email'];
		$error='';

		if(!empty($screenName) and  !empty($password) and !empty($email)){
			$screenName=$getFromUser->checkInput($screenName);
			$email=$getFromUser->checkInput($email);
			$password=$getFromUser->checkInput($password);
			$salt=uniqid();
			

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$error="Invalid Email format";
			}
			elseif (strlen($screenName>20)) {
						$error="Name must be in range 6-20 characters.";
			}
			elseif (strlen($password)<5) {
				$error = "Password is too short";			}
			else{
				 if($getFromUser->checkEmail($email)===true){
				 	$error="Email is already in use";
				 }
				 else{
				 		$dbpassword=md5($password.$salt);
				 		$user_id=$getFromUser->create('users',array('email'=>$email,'screenName'=>$screenName,'password'=>$dbpassword,'profileImage'=>'assets/images/defaultProfileImage.png','profileCover'=>'assets/images/defaultCoverImage.png','salt'=>$salt));
				 		$_SESSION['user_id']=$user_id;
				 		header('Location: includes/signup.php?step=1');
					 }

			}


			}
		}
		else{
			$error='All fields are required';	
		}

 ?>


 <form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Full Name" required />
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email" required />
		</li>
		<li>
			<input type="password" name="password" placeholder="Password" required/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup for Twitter">
		</li>
		<?php 
			if(isset($error)){

			echo'<li class="error-li">
	  		<div class="span-fp-error">'.$error.'</div>
	 		</li>'
	 	    ;}
    ?>
	</ul>
	
	 

</div>
</form>