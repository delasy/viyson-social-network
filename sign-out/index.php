<? session_start();

unset($_SESSION['email']);
unset($_SESSION['pass']);
unset($_SESSION['proflink']);
unset($_SESSION['fname']);
unset($_SESSION['sname']);
session_destroy();
header("location: /");