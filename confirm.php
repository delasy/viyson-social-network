<? session_start();
include $_SERVER['DOCUMENT_ROOT']."/includes/main.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/fun_confirm.php";

if(!(empty($_GET['email'])) || !(empty($_GET['key']))){
	$email = $_GET['email'];
	$key = $_GET['key'];
	
	$check_key = $viy->query("SELECT COUNT(*) FROM $ctable WHERE `email` = '$email' AND `key` = '$key'")->fetchColumn();
	
	if($check_key > 0){
		$get_proflink = $viy->prepare("SELECT * FROM $table WHERE `email` = :email");
		$get_proflink->execute(array('email' => $email));
		$num_rowss	= $get_proflink->fetch(PDO::FETCH_ASSOC);
		$proflink	= $num_rowss["profile_link"];
		
		$update_users = $viy->prepare("UPDATE $table SET `active` = '1' WHERE `profile_link` = :profile_link LIMIT 1");
		$update_users->execute(array("profile_link" => $proflink));
		$delete = $viy->prepare("DELETE FROM $ctable WHERE `email` = :email");
		$delete->execute(array("email" => $email));
		
		$sth= $viy->prepare("SELECT * FROM $table WHERE `email` = :email");
		$sth->execute(array("email" => $email));
		$num_row = $sth->fetch(PDO::FETCH_ASSOC);
		$profile_link = $num_row['profile_link'];
		$first_name = $num_row['first_name'];
		$sur_name = $num_row['sur_name'];
		
		$profile_image_link = '/cloud/img/default.jpg';
		$profile_status_text = 'Here you should type what are u thinking about...';
		$profile_full_name = $first_name.' '.$sur_name;
		
		$new_profile=$viy->prepare("INSERT INTO $ptable(profile_link, profile_image_link, profile_full_name, profile_status_text) VALUES(:profile_link, '$profile_image_link', '$profile_full_name', '$profile_status_text')");
		$new_profile->execute(array("profile_link" => $profile_link));
		
		$count = $viy->exec("OPTIMIZE TABLE $table, $ptable, $ctable");
		
		if($update_users and $delete and $new_profile){
			$_SESSION["proflink"]	= $profile_link;
			
			if((isset($_SESSION["pass"])) && (isset($_SESSION["email"]))){			
				header("Location: /news");
			}else{
				header("Location: /sign-in");
			}			
		}else{header("Location: /error");}
	}else{header("Location: /error");}
}else{header("Location: /error");}
?>