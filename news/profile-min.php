<? session_start();
$title = "Profile | ViYSoN";
include $_SERVER["DOCUMENT_ROOT"]."/includes/main.php";
$url = $_SESSION["proflink"];
$sql = $viy->prepare("SELECT * FROM $ptable WHERE `profile_link` = :profile_link");
$sql->execute(array('profile_link' => $url));
$sql1 = $sql->fetch(PDO::FETCH_ASSOC);
$pil	= $sql1['profile_image_link'];
$pfn	= $sql1['profile_full_name'];
$pst	= $sql1['profile_status_text'];
?>
<img src="<?=$pil?>" />
<h2><?=$pst?></h2>