<?php session_start();
include $_SERVER['DOCUMENT_ROOT'].'/includes/main.php';

if( isset($_SESSION["email"] ) ){
 $email	= $_SESSION["email"];
 $sql = $viy->prepare("SELECT * FROM $table WHERE `email` = :email LIMIT 1");
 $sql->execute(array('email' => $email));
 $num_row		= $sql->fetch(PDO::FETCH_ASSOC);
 $activate		= $num_row['activate'];
 if($activate==1){header("Location: /news");}
 
$title = "Confirm your Email! | ViYSoN";
include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
include $_SERVER["DOCUMENT_ROOT"]."/includes/header_start.php"; ?>

<div class="content" style="width:100%;text-align:center;left:0;">
 <div class="content_1">
  <div id="iframe">
   <h1>Please, visit your email: <span style="color:red"><?php echo $email; ?></span>!</h1>
  </div>
 </div>
</div>
<script>
window.onload = setTimeout(function(){
	var ww = window.open(window.location, '_self');
	ww.close();
}, 10000);
</script>
<? }else{header("Location: /error");}?>