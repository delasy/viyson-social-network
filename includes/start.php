<? session_start();
$title = "Welcome to ViYSoN!";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/header_start.php";
include $_SERVER["DOCUMENT_ROOT"]."/includes/sidebar_start.php"; ?>

<div class="content">
 <div class="content_1">
  <div id="iframe">
  </div>
 </div>
</div>
<script>
ъ("#iframe").load( "/includes/welcome.php" );
</script>
</body>
</html>