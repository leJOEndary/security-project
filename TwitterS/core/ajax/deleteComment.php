<?php 
	include '../init.php';
			if(isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])){
				$user_id	=$_SESSION['user_id'];
				$commentID	=$_POST['deleteComment'];
				$getFromUser->delete('comments',array('commentBy'=>$user_id,'commentID'=>$commentID));


			}




 ?>