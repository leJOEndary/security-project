<?php 
class Tweet  extends User
{
	function __construct($pdo)
	{

		$this->pdo=$pdo;
	}

	public function tweets($visitor_id,$user_id,$visitorEqowner,$privateAccount){
		if($visitorEqowner){
		$sql="SELECT * FROM tweets LEFT JOIN users ON tweetBy = user_id WHERE tweetBy = :user_id  AND retweetID='0'OR retweetBy=:user_id";
		$stmt=$this->pdo->prepare($sql);
		$stmt->bindParam(':user_id',$user_id);
		}
		else{
		$sql="SELECT * FROM tweets LEFT JOIN users ON tweetBy = user_id LEFT JOIN follow ON receiver = user_id WHERE tweetBy = :user_id AND private = 0 AND privateTweet=0 AND retweetID = '0' OR retweetBy=:user_id AND private =0 AND privateTweet=0 OR receiver=:user_id AND sender =:visitor_id AND privateTweet=0";

		$stmt=$this->pdo->prepare($sql);
		$stmt->bindParam(':user_id',$user_id);
		$stmt->bindParam(':visitor_id',$visitor_id);
		}

	
		$stmt->execute();
		$tweets=$stmt->fetchAll(PDO::FETCH_OBJ);

		foreach ($tweets as $tweet) {
			$likes=$this->likes($user_id,$tweet->tweetID);
			$retweet=$this->checkRetweet($tweet->tweetID,$user_id);
			$user = $this->userData($tweet->retweetBy);

			echo '<div class="all-tweet">
			<div class="t-show-wrap">	
			 <div class="t-show-inner">
			 	'.(($retweet['retweetID']===$tweet->retweetID OR $tweet->retweetID>0)? '

				<div class="t-show-banner">
					<div class="t-show-banner-inner">
						<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user->screenName.' Retweeted</span>
					</div>
				</div>'
			:'' ) .'


			'.((!empty($tweet->retweetMsg) && $tweet->tweetID ===$retweet['tweetID'] or $tweet->retweetID>0)? 
				//true part
				'<div class="t-show-head">
								<div class="t-show-img">
									<img src="'.BASE_URL.$user->profileImage.'"/>
								</div>
								<div class="t-s-head-content">
									<div class="t-h-c-name">
										<span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
										<span>@'.$user->username.'</span>
										<span>'.$this->timeAgo($retweet['postedOn']).'</span>
									</div>
									<div class="t-h-c-dis">
										'.$this->getTweetLinks($tweet->retweetMsg).'
									</div>
								</div>
							</div>
							<div class="t-s-b-inner">
								<div class="t-s-b-inner-in">
									<div class="retweet-t-s-b-inner">
									'.((!empty($tweet->tweetImage))? '
										<div class="retweet-t-s-b-inner-left">
											<img src="'.BASE_URL.$tweet->tweetImage.'"/>	
										</div>'

										:
										'' ).'
										<div >
											<div class="t-h-c-name">
												<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
												<span>@'.BASE_URL.$tweet->username.'</span>
												<span>'.$this->timeAgo($tweet->postedOn).'</span>
											</div>
											<div class="retweet-t-s-b-inner-right-text">		
												'.$this->getTweetLinks($tweet->status).'
											</div>
										</div>
									</div>
								</div>
							</div>'
					
							:
							// else part
					'<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
					<div class="t-show-head">
						<div class="t-show-img">
							<img src="'.$tweet->profileImage.'"/>
						</div>
						<div class="t-s-head-content">
							<div class="t-h-c-name">
								<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
								<span>@'.$tweet->username.'</span>
								<span>'.$this->timeAgo($tweet->postedOn).'</span>
							</div>
							<div class="t-h-c-dis">
								'.$this->getTweetLinks($tweet->status).'
							</div>
						</div>
					</div>'.
						((!empty($tweet->tweetImage))? '
							 
							<div class="t-show-body">
							  <div class="t-s-b-inner">
							   <div class="t-s-b-inner-in"> 
							     <img src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup"/>
							   </div>
							  </div>
							</div>
							': '').'
							
				</div> ').
				'<div class="t-show-footer">
					<div class="t-s-f-right">
						<ul> 
						    '.(($this->loggedIn()===true)? '
							<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
							<li>'.(($tweet->tweetID===$retweet['retweetID'])? '<button class ="retweeted" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCount">'.$tweet->retweetCount.'</span></button>':'<button class ="retweet" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCount">'.(($tweet->retweetCount>0)? $tweet->retweetCount : '' ).'</span></button>' ).'</li>

							<li>'.(($likes['likeOn']===$tweet->tweetID)?'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-heart"aria-hidden="true"></i></a><span class="likesCounter">'.$tweet->likesCount.'</span></button>':'<button class="like-btn" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($tweet->likesCount>0)?$tweet->likesCount:'').'</span></button>').'</li>
							'.(($tweet->tweetBy===$visitor_id)? '
							<li>
								<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
								<ul> 
								  <li><label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">Delete Tweet</label></li>
								</ul>
							</li>':'').'
							':'').'
						</ul>
					</div>
				</div>
			</div>
			</div>
			</div>';
					}

				}


public function tweetshome($user_id){

		$sql="SELECT * FROM tweets,users,follow WHERE tweetBy = user_id AND receiver=user_id AND privateTweet = 0 AND  tweetBy IN (SELECT receiver FROM follow WHERE sender = :user_id) AND retweetID = 0 ORDER BY tweetID DESC ";
		// /OR tweetBy= user_id AND  retweetBy != :user_id
	

		$stmt=$this->pdo->prepare($sql);
		$stmt->bindParam(':user_id',$user_id);
		$stmt->execute();
		$tweets=$stmt->fetchAll(PDO::FETCH_OBJ);

		foreach ($tweets as $tweet) {
			$likes=$this->likes($user_id,$tweet->tweetID);
			$retweet=$this->checkRetweet($tweet->tweetID,$user_id);
			$user = $this->userData($tweet->retweetBy);

			echo '<div class="all-tweet">
			<div class="t-show-wrap">	
			 <div class="t-show-inner">
			 	'.(($retweet['retweetID']===$tweet->retweetID OR $tweet->retweetID>0)? '

				<div class="t-show-banner">
					<div class="t-show-banner-inner">
						<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user->screenName.' Retweeted</span>
					</div>
				</div>'
			:'' ) .'


			'.((!empty($tweet->retweetMsg) && $tweet->tweetID ===$retweet['tweetID'] or $tweet->retweetID>0)? 
				//true part
				'<div class="t-show-head">
								<div class="t-show-img">
									<img src="'.BASE_URL.$user->profileImage.'"/>
								</div>
								<div class="t-s-head-content">
									<div class="t-h-c-name">
										<span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
										<span>@'.$user->username.'</span>
										<span>'.$this->timeAgo($retweet['postedOn']).'</span>
									</div>
									<div class="t-h-c-dis">
										'.$this->getTweetLinks($tweet->retweetMsg).'
									</div>
								</div>
							</div>
							<div class="t-s-b-inner">
								<div class="t-s-b-inner-in">
									<div class="retweet-t-s-b-inner">
									'.((!empty($tweet->tweetImage))? '
										<div class="retweet-t-s-b-inner-left">
											<img src="'.BASE_URL.$tweet->tweetImage.'"/>	
										</div>'

										:
										'' ).'
										<div>
											<div class="t-h-c-name">
												<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
												<span>@'.$tweet->username.'</span>
												<span>'.$this->timeAgo($tweet->postedOn).'</span>
											</div>
											<div class="retweet-t-s-b-inner-right-text">		
												'.$this->getTweetLinks($tweet->status).'
											</div>
										</div>
									</div>
								</div>
							</div>'
					
							:
							// else part
					'<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
					<div class="t-show-head">
						<div class="t-show-img">
							<img src="'.$tweet->profileImage.'"/>
						</div>
						<div class="t-s-head-content">
							<div class="t-h-c-name">
								<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
								<span>@'.$tweet->username.'</span>
								<span>'.$this->timeAgo($tweet->postedOn).'</span>
							</div>
							<div class="t-h-c-dis">
								'.$this->getTweetLinks($tweet->status).'
							</div>
						</div>
					</div>'.
						((!empty($tweet->tweetImage))? '
							 
							<div class="t-show-body">
							  <div class="t-s-b-inner">
							   <div class="t-s-b-inner-in"> 
							     <img src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup"/>
							   </div>
							  </div>
							</div>
							': '').'
							
				</div> ').
				'<div class="t-show-footer">
					<div class="t-s-f-right">
						<ul> 

						'.(($this->loggedIn()===true)? '
							<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
							<li>'.(($tweet->tweetID===$retweet['retweetID'])? '<button class ="retweeted" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCount">'.$tweet->retweetCount.'</span></button>':'<button class ="retweet" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCount">'.(($tweet->retweetCount>0)? $tweet->retweetCount : '' ).'</span></button>' ).'</li>

							<li>'.(($likes['likeOn']===$tweet->tweetID)?'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-heart"aria-hidden="true"></i></a><span class="likesCounter">'.$tweet->likesCount.'</span></button>':'<button class="like-btn" data-tweet="'.$tweet->tweetID.'"  data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($tweet->likesCount>0)?$tweet->likesCount:'').'</span></button>').'</li>
								'.(($tweet->tweetBy===$user_id)? '
							<li>
								<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
								<ul> 
								  <li><label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">Delete Tweet</label></li>
								</ul>
							</li>':'').'
							' : '<li><button><a href="#"><i class="fa fa-share" 							     aria-hidden="true"></i></a></button></li>
								 <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>
								 <li><button><a href="#"><i class="fa fa-like" aria-hidden="true"></i></a></button></li>').'
						</ul>
					</div>
				</div>
			</div>
			</div>
			</div>';
					}

				}				




public function getTrendByHash($hashtag){
	$stmt =$this->pdo->prepare("SELECT * FROM trends WHERE hashtag LIKE :hashtag LIMIT 5");
	$stmt->bindValue(':hashtag',$hashtag.'%');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);

}

public function getMention($mention){

$stmt=$this->pdo->prepare("SELECT user_id,username,screenName,profileImage FROM users WHERE username LIKE :mention OR screenName LIKE :mention LIMIT 6");
$stmt->bindValue(':mention',$mention.'%');
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_OBJ);
}


public function addTrend($hashtag){
	preg_match_all('/#+([a-zA-Z0-9_]+)/i',$hashtag,$matches);
	if($matches){
		$result=array_values($matches[1]);

	}

	$sql="INSERT INTO trends (hashtag,createdOn) VALUES(:hashtag, CURRENT_TIMESTAMP)";
	
	foreach ($result as $trend) {
	$stmt=$this->pdo->prepare($sql);
	$stmt->bindParam(":hashtag",$trend);
	$stmt->execute();

	}
  }

public function  getTweetLinks($tweet){

	$tweet=preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href= '$0', target='_blink'>$0</a>", $tweet);
	$tweet=preg_replace("/#([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>",$tweet);
	$tweet=preg_replace("/@([\w]+)/", "<a href='".BASE_URL."$1'>$0</a>",$tweet);

	return $tweet;
}

public function getPopupTweet($tweet_id){
	$stmt= $this->pdo->prepare("SELECT * FROM tweets,users WHERE tweetID = :tweetID AND tweetBy=user_id");
	$stmt->bindParam(":tweetID",$tweet_id);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_OBJ);

}

public function retweet($tweet_id,$user_id,$get_id,$comment){
	$stmt=$this->pdo->prepare("UPDATE tweets SET retweetCount = retweetCount+1  WHERE tweetID = :tweet_id");
	$stmt->bindParam(":tweet_id",$tweet_id);
	$stmt->execute();

	$stmt=$this->pdo->prepare("INSERT INTO tweets (status,tweetBy,tweetImage,retweetID,retweetBy,postedOn,likesCount,retweetCount,retweetMsg) 
		SELECT status,tweetBy,tweetImage,tweetID,:user_id,postedOn,likesCount,retweetCount,:retweetMsg FROM tweets WHERE tweetID = :tweet_id");

	$stmt->bindParam(":user_id",$user_id);
	$stmt->bindParam(":tweet_id",$tweet_id);
	$stmt->bindParam(":retweetMsg",$comment);
	$stmt->execute();


}

public function checkRetweet($tweet_id,$user_id){
	$stmt=$this->pdo->prepare("SELECT * FROM tweets WHERE  retweetID = :tweet_id AND retweetBy = :user_id  OR tweetID = :tweet_id AND retweetBy = :user_id");
	$stmt->bindParam(":user_id",$user_id);
	$stmt->bindParam(":tweet_id",$tweet_id);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);

}

public function addLike($user_id,$tweet_id,$get_id){

$stmt= $this->pdo->prepare("UPDATE tweets SET likesCount=likesCount+1 WHERE tweetID = :tweet_id");
$stmt->bindParam(":tweet_id",$tweet_id);
$stmt->execute();
$this->create('likes',array('likeBy'=>$user_id,'likeOn'=>$tweet_id));
}


public function comments($tweet_id){
$stmt= $this->pdo->prepare("SELECT * FROM comments LEFT JOIN users ON  commentBy = user_id WHERE commentOn = :tweet_id");
$stmt->bindParam(":tweet_id",$tweet_id);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_OBJ);

}


public function countTweets($user_id){
$stmt=$this->pdo->prepare("SELECT COUNT(tweetID) AS totalTweets FROM tweets WHERE tweetBy = :user_id AND retweetID = 0 OR retweetBy = :user_id ");
$stmt->bindParam(":user_id",$user_id);
$stmt->execute();
$count=$stmt->fetch(PDO::FETCH_OBJ);
echo $count->totalTweets;
}


public function countLikes($user_id){
$stmt=$this->pdo->prepare("SELECT COUNT(likeID) AS totalLikes FROM likes WHERE likeBy = :user_id");
$stmt->bindParam(":user_id",$user_id);
$stmt->execute();
$count=$stmt->fetch(PDO::FETCH_OBJ);
echo $count->totalLikes;


}

public function unlike($user_id,$tweet_id,$get_id){
$stmt= $this->pdo->prepare("UPDATE tweets SET likesCount=likesCount-1 WHERE tweetID = :tweet_id");
$stmt->bindParam(":tweet_id",$tweet_id);
$stmt->execute();
$stmt=$this->pdo-prepare("DELETE FROM likes WHERE likeBy = :user_id AND likeOn = :tweet_id");
$stmt->bindParam(":user_id",$user_id);
$stmt->bindParam(":tweet_id",$tweet_id);
$stmt->execute();
}

public function likes($user_id,$tweet_id){

	$stmt=$this->pdo->prepare("SELECT * FROM likes WHERE likeBy=:user_id and likeOn =:tweet_id");
	$stmt->bindParam(":user_id",$user_id);
	$stmt->bindParam(":tweet_id",$tweet_id);
	$stmt->execute();

	return $stmt->fetch(PDO::FETCH_ASSOC);

}

}


 ?>