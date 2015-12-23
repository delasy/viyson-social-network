<? session_start();
include $_SERVER["DOCUMENT_ROOT"]."/includes/main.php";

if(isset($_SESSION['email'])){
 $email = $_SESSION['email'];
 $email_active = $viy->prepare("SELECT * FROM $table WHERE `email` = :email");
 $email_active->execute(array('email' => $email));
 if($num_rows = $email_active->fetch(PDO::FETCH_ASSOC)){	
  if($num_rows['active']==1){
   if(isset($_SESSION['pass'])){
	$pass	= $_SESSION['pass'];
	$pass_valid = $viy->query("SELECT COUNT(*) FROM $table WHERE `email` = '$email' AND `password` = '$pass'")->fetchColumn();
	if ($pass_valid > 0){
	 $proflink_grab = $viy->prepare("SELECT * FROM $table WHERE `email` = :email AND `password` = :pass");
	 $proflink_grab->execute(array('email' => $email, 'pass' => $pass));
	 if($num_row = $proflink_grab->fetch(PDO::FETCH_ASSOC)){
	  $_SESSION["fname"]	= $num_row['first_name'];
	  $_SESSION["sname"]	= $num_row['sur_name'];
	  $_SESSION["proflink"]	= $num_row['profile_link'];
	  header("Location: /news");
	 }else{header("Location: /sign-in");}
	}else{header("Location: /sign-in");}
   }else{header("Location: /sign-in");}
  }else{header("Location: /email");}
 }else{header("Location: /sign-in");}
}

include $_SERVER["DOCUMENT_ROOT"]."/includes/start.php";
