<? session_start();
$title = "News | ViYSoN";
include $_SERVER["DOCUMENT_ROOT"]."/includes/main.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header_user.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/sidebar_user.php";?>
<div class="content">
 <div class="content_1">
  <div id="iframe">
   <h1>News</h1>
  </div>
 </div>
</div>
<script>
window.onpopstate=function(){
  alert("Back/Forward clicked!");
}
</script>
</body>
</html>