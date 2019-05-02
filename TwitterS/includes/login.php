<?php 
if (isset($_POST['login']) && !empty ($_POST['login'])) {

	$email=$_POST['email'];
	$password=$_POST['password'];

	if(!empty($email)&& !empty($password)){
		$email 			 = $getFromUser->checkInput($email);
		$password   	 = $getFromUser->checkInput($password);
		if($getFromUser->checkEmail($email)===true){
			$salt			 = $getFromUser->userSaltByEmail($email);
			$saltfinal       = $salt->salt;
		}
		else{
			$saltfinal='';
		}
		
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$error= "Invalid Email!";
		}else{

			if($getFromUser->login($email,$password,$saltfinal)===false){
				$error="Invalid Email or password";
				//echo '<h1>'.md5($password.$saltfinal).'</h1>';

			}
		}
	}else{
		$error = "Please enter email and password";
	}




}

 ?>

 <div class="login-div">
<form method="post"> 
	<ul>
		<li>
		  <input type="email" name="email" placeholder="Please enter your Email here" required />
		</li>
		<li>
		  <input type="password" name="password" placeholder="password" required= />
		  <input type="submit" name="login" value="Log in"/>
		</li>
		<li>
		  <input type="checkbox" Value="Remember me">Remember me
		</li>
		<?php 
		if (isset($error)) {
		echo'	
		 <li class="error-li">
		 <div class="span-fp-error">'.$error.'</div>
		 </li>'; 
			}
		?>

	</ul>
		
	
		
	</form>
</div>