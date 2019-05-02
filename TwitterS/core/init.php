<?php 
// this file is used to store all classes in a SESSION

include "database/connection.php";
include "classes/user.php";
include "classes/follow.php";
include "classes/tweet.php";
include "classes/message.php";
global $pdo;
session_start();


$getFromUser= new User($pdo);
$getFromFollow= new Follow($pdo);
$getFromTweet= new Tweet($pdo);
$getFromMessage= new Message($pdo);


define("BASE_URL","http://localhost/Twitter/");


 ?>