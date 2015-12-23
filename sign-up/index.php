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

include $_SERVER["DOCUMENT_ROOT"]."/includes/fun_confirm.php";

$title = "Sign up | ViYSoN";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header_start.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/sidebar_lr.php";

if(isset($_POST['submit'])){
 $fname			= $_POST['first_name'];
 $sname			= $_POST['sur_name'];
 $profile_link	= $_POST['profile_link'];
 $pass			= $_POST['password'];
 $pass_r		= $_POST['password_r'];
 $email			= $_POST['email'];
 $email_r		= $_POST['email_r'];
 $ipv4			= $_SERVER['REMOTE_ADDR'];
 
 if(empty($email)) {$err = "Please type email";}else{
  $email_ver_stmt = $viy->prepare("SELECT * FROM $table WHERE email = :email");
  $email_ver_stmt->bindParam(':email', $email);
  $email_ver_stmt->execute();	  
	  
  if($email_ver_stmt->rowCount()>0) {$err = "An user with this email currently is registered";}
  elseif(strlen($email)<7 or strlen($email)>30) {$err = "Email should be more than 7 symbols and less than 30 symbols";}
  elseif(!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/",$email)) {$err = "Please, type correct email";}
  elseif($email != $email_r) {$err = "Email's don't match";}
 }
 
 if(empty($pass)) {$err = "Please type password";}else{					 
  if(!preg_match("/^[a-zA-Z0-9]+$/",$pass)) {$err = "Password can include only letters and numbers of English alphabet";}
  elseif(strlen($pass)<6 or strlen($pass)>30) {$err = "Password should be more than 6 symbols and less than 30 symbols";}
  elseif($pass != $pass_r) {$err = "Password's don't match";} 
 }
 
 if(empty($profile_link)) {$err = "Please type profile link";}else{
  $link_ver_stmt = $viy->prepare("SELECT * FROM $table WHERE profile_link = :profile_link");
  $link_ver_stmt->bindParam(':profile_link', $profile_link);
  $link_ver_stmt->execute();
 
  if($link_ver_stmt->rowCount()>0) {$err = "An user with this profile link currently is registered";}
  elseif(!preg_match("/^[a-zA-Z0-9]+$/",$profile_link)) {$err = "Profile link can include only letters and numbers of English alphabet";}
  elseif(strlen($profile_link)<2 or strlen($profile_link)>10) {$err = "Profile link should be more than 2 symbols and less than 10 symbols";}
 }
 
 if(empty($sname)) {$err = "Please type surname";}else{
  if(strlen($sname)<3 or strlen($sname)>30) {$err = "Surname should be more than 3 symbols and less than 30 symbols";}
  elseif(!preg_match('/^[a-zа-я]/ui',$sname)) {$err = "Surname can include only letters";}
 }
 
 if(empty($fname)) {$err = "Please type first name";}else{
  if(strlen($fname)<3 or strlen($fname)>30){$err = "First name should be more than 3 symbols and less than 30 symbols";}
  elseif(!preg_match('/^[a-zа-я]/ui',$fname)) {$err = "First name can include only letters";}
 }
 
 if(count($err) == 0){
  $password = md5(md5(trim($pass)));
  $info_con=$viy->prepare("INSERT INTO $table(first_name, sur_name, profile_link, password, email, ipv4) VALUES(:first_name, :sur_name, :profile_link, :password, :email, :ipv4)");
  $info_con->execute(array("first_name" => $fname,"sur_name" => $sname,"profile_link" => $profile_link,"password" => $password,"email" => $email,"ipv4" => $ipv4));
  
  $ipv4 = $_SERVER['REMOTE_ADDR'];
  $ipv4_stmt = $viy->prepare("UPDATE $table SET `ipv4` = INET_ATON('$ipv4') WHERE `email` = :email LIMIT 1");
  $ipv4_stmt->execute(array("email" => $email));
  
  $key		= $profile_link . $email . date('m Y h:i:s');
  $key		= md5($key);
  
  $id_grab	= $viy->prepare("SELECT * FROM $table WHERE `email` = :email");
  $id_grab->execute(array('email' => $email));
  $num_row_id = $id_grab->fetch(PDO::FETCH_ASSOC);
  $id		= $num_row_id["id"];
  $confirm	= $viy->prepare("INSERT INTO $ctable VALUES(:profile_link, :key, :email)");
  $confirm->execute(array("profile_link" => $profile_link, "key" => $key,"email" => $email));
  
  if($confirm){
	include $_SERVER['DOCUMENT_ROOT'].'/swift/swift_required.php';
	$info = array('username' => $profile_link,'email' => $email,'key' => $key);
    if(send_email($info)){
		$_SESSION["email"]		= $email;
		$_SESSION["pass"]		= $password;
		$_SESSION["fname"]		= $fname;
		$_SESSION["sname"]		= $sname;
		$_SESSION["proflink"]	= $profile_link;
		
	 header("Location: /email");
	}
  }
 }
}
?>
<div class="content">
 <div class="content_1">
  <div id="iframe">
  <table style="width:100%;height:auto;position:relative;">
   <tbody>
    <tr>
     <td style="width:69%;position:relative;height:auto;padding:0;margin:0;top:0;left:0;">
      <form name="registerform" method="post">
       <table style="width:100%;height:auto;position:relative;">
        <tbody>
         <tr>
          <td style="padding-right:5%;text-align:left;">
	       <h3>First name</h3>
	      </td><td>
		   <h3>Surname</h3>
		  </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:center;">
           <input type='text' name='first_name' class="input" value='<? echo $_POST["first_name"]; ?>'>
	      </td><td>
           <input type='text' name='sur_name' class="input" value='<? echo $_POST["sur_name"]; ?>'>
          </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <h3>Profile link<h3>
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <input type='text' name='profile_link' class="input" value='<? echo $_POST["profile_link"]; ?>'>
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <h3>Password<h3>
	      </td><td>
	       <h3>Confirm password<h3>
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <input type='password' name='password' class="input">
	      </td><td>
	       <input type='password' name='password_r' class="input">
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <h3>Email<h3>
	      </td><td>
	       <h3>Confirm email<h3>
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <input type='text' name='email' class="input" value='<? echo $_POST["email"]; ?>'>
	      </td><td>
	       <input type='text' name='email_r' class="input">
	      </td>
         </tr><tr class="submit">
          <td>
	       <input name="submit" type="submit" class="button margintop" value="Register">
	      </td>
         </tr>
        </tbody>
       </table>
      </form>
     </td><td style="width:2%;position:relative;height:auto;padding:0;margin:0;top:0;left:0;"></td><td style="width:29%;position:relative;height:auto;padding:0;margin:0;top:0;left:0;">
      <div id="error"><h3>Here will display errors:</h3><p style="margin:5px;"><?php if (!empty($err)) {echo $err;} ?></p></div>
     </td>
    </tr>
   </tbody>
  </table>
  </div>
 </div>
</div>
</body>
</html>