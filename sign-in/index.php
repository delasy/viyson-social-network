<? session_start();
$title = "Sign in | ViYSoN";
include $_SERVER["DOCUMENT_ROOT"]."/includes/main.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header_start.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/sidebar_lr.php";

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

if( isset( $_POST['email'] ) and isset( $_POST['password'] ) ){
 $email			= $_POST['email'];
 $pass			= $_POST['password'];
 $password		= md5(md5(trim($pass)));
 
 $stmt = $viy->prepare("SELECT * FROM $table WHERE email = :email and password = :password");
 $stmt->bindParam(':email', $email);
 $stmt->bindParam(':password', $password);
 $stmt->execute();
 
 if($stmt->rowCount()==0) {
    $message = "1";
 }

 if(count($message) == 0){
	$ipv4 = $_SERVER['REMOTE_ADDR'];
    $ipv4_stmt = $viy->prepare("UPDATE $table SET `ipv4` = INET_ATON('$ipv4') WHERE `email` = :email LIMIT 1");
    $ipv4_stmt->execute(array("email" => $email));
	
	$sql = $viy->prepare("SELECT * FROM $table WHERE `email` = :email LIMIT 1");
	$sql->execute(array('email' => $email));
	$num_row		= $sql->fetch(PDO::FETCH_ASSOC);
	$activate		= $num_row['activate'];
	$proflink		= $num_row['profile_link'];
	$first_name		= $num_row['first_name'];
	$sur_name		= $num_row['sur_name'];
	if($activate==0){header("Location: /email");}
	
	$_SESSION["email"]		= $email;
	$_SESSION["pass"]		= $password;
	$_SESSION["proflink"]	= $proflink;
    $_SESSION['fname']		= $first_name;
    $_SESSION['sname']		= $sur_name;
  header("Location: /news");
 }
}
 
include $_SERVER['DOCUMENT_ROOT'].'/viy/includes/viyson_header.php';
include $_SERVER['DOCUMENT_ROOT'].'/viy/includes/sidebar_login.php'; ?>

<div class="content"><div class="main_content">
 <div id="iframe">
<div id="error">
<?php if (!empty($message)) {echo $message;} ?>
</div>
<div class="container">
 <form name="loginform" id="loginform" method="post">
  <table>
   <tbody>
    <tr>
     <td style="padding-right:5%;text-align:left;">
	  <h3>Email<h3>
	 </td>     
    </tr>
    <tr>
     <td style="padding-right:5%;text-align:left;">
	  <input type='text' name='email' class="input" value='<? echo $_POST["email"]; ?>'>
	 </td>
	</tr>
    <tr>
     <td style="padding-right:5%;text-align:left;">
	  <h3>Password<h3>
	 </td>     
    </tr>
    <tr>
     <td style="padding-right:5%;text-align:left;">
	  <input type='password' name='password' class="input">
	 </td>     
    </tr>
    <tr class="submit">
     <td>
	  <input name="submit" type="submit" class="button" value="Log in">
	 </td>
    </tr>
    <tr>
     <td>
	  <p><a href="/forgot-password" class="register_here">Can't enter?</a></p>
	 </td>
    </tr>
   </tbody>
  </table>
 </form>
</div>
</div>
</div></div>
</body>
</html>
<div class="content">
 <div class="content_1">
  <div id="iframe">
  <table style="width:100%;height:auto;position:relative;">
   <tbody>
    <tr>
     <td style="width:69%;position:relative;height:auto;padding:0;margin:0;top:0;left:0;">
      <form name="loginform" method="post">
       <table style="width:100%;height:auto;position:relative;">
        <tbody>
         <tr>
          <td style="padding-right:5%;text-align:left;">
	       <h3>Email<h3>
		  </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:center;">
           <input type='text' name='email' class="input" value='<? echo $_POST["email"]; ?>'>
          </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <h3>Password<h3>
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <input type='password' name='password' class="input">
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
		   <input name="submit" type="submit" class="button" value="Sign in">	       
	      </td>
         </tr><tr>
          <td style="padding-right:5%;text-align:left;">
	       <p><a href="/forgot-password" class="register_here">Can't enter?</a></p>
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