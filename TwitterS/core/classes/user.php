<?php 
class User
{
	protected $pdo; // only visible to this current class and classes extending this class.
	function __construct($pdo)
	{

		$this->pdo=$pdo;
	}

	public function checkInput($var){
		$var=htmlspecialchars($var); //encode the html code to html entities so that no html injection occurs
		$var=trim($var);   		 	 //remove the spaces from the string
		$var=stripcslashes($var);	 //remove the slashes from the string
		return $var;

	}

	public function login($email,$password,$salt){
		$hashedpassword=md5($password.$salt);
		$stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
		$stmt->bindParam(":email",$email,PDO::PARAM_STR);
		$stmt->bindParam(":password",$hashedpassword,PDO::PARAM_STR);
		$stmt->execute();

		$user=$stmt->fetch(PDO::FETCH_OBJ);
		
		$count=$stmt->rowCount();   //return the affected rows in db from this query
		 if($count>0){
			$_SESSION['user_id'] = $user->user_id;
			header('Location:home.php');
		}
		else{
			return false;
		}
	}

	public function register($email,$screenName,$password){
		$hashedpassword=md5($password);
		$stmt=$this->pdo->prepare("INSERT INTO users(email, password, screenName, profileImage, profileCover) VALUES (:email, :password, :screenName, 'assets/images/defaultProfileImage.png', 'assets/images/DefaultCoverImage.png')");
		$stmt->execute(array("email"=>$email,"screenName"=>$screenName,"password"=>$hashedpassword));
		$user_id=$this->pdo->lastInsertId();
		$_SESSION['user_id']=$user_id;
		echo "You Have Registered Successfully";


	}

		public function create($table,$fields){
		$columns=implode(',',array_keys($fields));
		$values=':'.implode(', :', array_keys($fields));
		$sql="INSERT INTO {$table}({$columns}) VALUES ({$values})";
		$stmt=$this->pdo->prepare($sql);
				foreach ($fields as $key => $value) {
					$stmt->bindValue(":".$key,$value);
				}
	    $stmt->execute();
		return $this->pdo->LastInsertId();

	}


	public function update($table, $user_id, $fields){
		$columns='';
		$i=1;
		foreach ($fields as $name => $value) {
			$columns.="{$name} = :{$name}";
			if ($i<count($fields)) {
				$columns.=', ';
			}
			$i++;
		}
		$sql="UPDATE {$table} SET {$columns} WHERE user_id = {$user_id}";
		if($stmt=$this->pdo->prepare($sql)){
		foreach ($fields as $key => $value) {
			$stmt->bindValue(':'.$key,$value);
		}
		$stmt->execute();
	 }
	}
	public function uploadImage($file){
		$filename=basename($file['name']);
		$fileTmp=$file['tmp_name'];
		$fileSize =$file['size'];
		$error =$file['error'];

		$ext=explode('.',$filename);
		$ext=strtolower(end($ext));

		$allowed_ext=array('jpg','png','jpeg');
		if(in_array($ext,$allowed_ext)===true){
              if($error===0){
              	if($fileSize<=209272152){
                   $fileRoot='users/'.$filename;
                   move_uploaded_file($fileTmp,$fileRoot);
                   return $fileRoot;
              	}else{
                    $GLOBALS['imageError']="The file size is too large!";

              	}
              }
		}else{

			$GLOBALS['imageError']="The extension is not allowed";
		}
	}

	public function userData($user_id){

		$stmt=$this->pdo->prepare("SELECT * FROM users WHERE user_id=:userid");
		$stmt->bindParam(":userid",$user_id,PDO::PARAM_INT);
		$stmt->execute();

		$userData=$stmt->fetch(PDO::FETCH_OBJ);
		return $userData;


	}

	public function userSaltByEmail($email){
		$stmt=$this->pdo->prepare("SELECT salt FROM users WHERE email=:email");
		$stmt->bindParam(":email",$email);
		$stmt->execute();
		$userData=$stmt->fetch(PDO::FETCH_OBJ);
		return $userData;


	}


	public function userSaltByUsername($username){
		$stmt=$this->pdo->prepare("SELECT salt FROM users WHERE username=:username");
		$stmt->bindParam(":username",$username);
		$stmt->execute();
		$userData=$stmt->fetch(PDO::FETCH_OBJ);
		return $userData;


	}

	public function logout(){
		$_SESSION=array();
		session_destroy();
		header('Location: '.BASE_URL.'../index.php');

	}


		public function checkUsername($username){

		$stmt=$this->pdo->prepare("SELECT username FROM users WHERE username=:username");
		$stmt->bindParam(":username",$username,PDO::PARAM_STR);
		$stmt->execute();

		$count=$stmt->rowCount();
		if($count>0){
			return true;
		}
		else{
			return false;
		}

	}

		public function checkPassword($username,$password){
		$salt=$this->userSaltByUsername($username);
		$saltfinal=$salt->salt;
		$stmt=$this->pdo->prepare("SELECT password FROM users WHERE username=:username and password=:password");
		$stmt->bindParam(":password",md5($password.$saltfinal) ,PDO::PARAM_STR);
		$stmt->bindParam(":username",$username ,PDO::PARAM_STR);
		$stmt->execute();

		$count=$stmt->rowCount();
		if($count>0){
			return true;
		}
		else{
			return false;
		}

	}


	public function checkEmail($email){

		$stmt=$this->pdo->prepare("SELECT email FROM users WHERE email=:email");
		$stmt->bindParam(":email",$email,PDO::PARAM_STR);
		$stmt->execute();

		$count=$stmt->rowCount();
		if($count>0){
			return true;
		}
		else{
			return false;
		}

	}
	public function loggedIn(){
		return(isset($_SESSION['user_id']))? true:false;
	}

	public function userIdByUsername($username){
		$stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE username =:username");
		$stmt->bindParam(":username",$username,PDO::PARAM_STR);
		$stmt->execute();
		$user =$stmt->fetch(PDO::FETCH_OBJ);
		return $user->user_id;

	}

	public function delete($table,$array){
		$sql="DELETE FROM {$table}";
		$where =" WHERE ";
		foreach ($array as $name => $value) {
			$sql .= "{$where} {$name} = :{$name}";
			$where=' AND ';
		}

		if($stmt=$this->pdo->prepare($sql)){
			foreach ($array as $name => $value) {
				$stmt->bindValue(':'.$name,$value);

			}
			$stmt->execute();
		}

	}


	public function search($search){
		$stmt=$this->pdo->prepare("SELECT user_id,username,screenName,profileImage,profileCover FROM users WHERE username LIKE ? OR screenName LIKE ?");
		$stmt->bindValue(1,$search.'%',PDO::PARAM_STR);
		$stmt->bindValue(2,$search.'%',PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}


	public function timeAgo($datetime){
		$time 	=	strtotime($datetime);
		$current=	time();
		$second	=	$current-$time;
		$minutes=	round($second/60);
		$hours	=	round($second/3600);
		$months =	round($second/2600640);


		if($second<=60){
			if($second==0){
				return 'now';
			}else{
				return $second.'s';
			}
		}else if ($minutes<=60){
				return $minutes.'m';

		}elseif ($hours<=24) {
				return $hours.'h';
		}elseif ($months<=12) {
			return date('M j',$time);

		}else{
			return date('j M Y',$time);
		}
	}

}


 ?>