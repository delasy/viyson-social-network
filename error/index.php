<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/includes/main.php';
$url = $_SERVER['REQUEST_URI'];
$url = substr(strrchr($url, '/'), 1);
$sql = $viy->prepare("SELECT * FROM $ptable WHERE `profile_link` = :profile_link");
$sql->execute(array('profile_link' => $url));
$sql1 = $sql->fetch(PDO::FETCH_ASSOC);
echo $sql1['profile_image_link'] . "<br />";
echo $sql1['profile_full_name'] . "<br />";
echo $sql1['profile_status_text'];


include $_SERVER['DOCUMENT_ROOT'] . '/error/404.php';
