<?
include $_SERVER["DOCUMENT_ROOT"].'/delasy.php';

$user_host	= DB_SERVER;
$user_db	= DB_NAME;

$user_info = "mysql:host=$user_host;dbname=$user_db;";
$viy = new PDO($user_info, DB_USER, DB_PASS);

$table = 'viy_a';
$ctable = 'viy_b';
$ptable = 'viy_c';

$viy->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$viy->exec("set names utf8");

$sql ="CREATE TABLE IF NOT EXISTS $table (
 `id` int(11) NOT NULL auto_increment,
 `first_name` varchar(32) collate utf8_unicode_ci NOT NULL default '',
 `sur_name` varchar(32) collate utf8_unicode_ci NOT NULL default '',
 `profile_link` varchar(20) collate utf8_unicode_ci NOT NULL default '',
 `password` varchar(32) collate utf8_unicode_ci NOT NULL default '',
 `email` varchar(32) collate utf8_unicode_ci NOT NULL default '',
 `ipv4` int(11) UNSIGNED NOT NULL default '0',
 `active` binary(1) NOT NULL default '0',
 PRIMARY KEY  (`id`),
 UNIQUE KEY `profile_link` (`profile_link`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;" ;
$viy->exec($sql);

$csql ="CREATE TABLE IF NOT EXISTS $ctable (
  `profile_link` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `key` varchar(128) NOT NULL default '',
  `email` varchar(32) collate utf8_unicode_ci NOT NULL default '',
 UNIQUE KEY `profile_link` (`profile_link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;" ;
$viy->exec($csql);

$psql ="CREATE TABLE IF NOT EXISTS $ptable (
   `profile_link` varchar(30) collate utf8_unicode_ci NOT NULL,
   `profile_image_link` varchar(50) collate utf8_unicode_ci NOT NULL,
   `profile_full_name` varchar(100) collate utf8_unicode_ci NOT NULL,
   `profile_status_text` TEXT collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `profile_link` (`profile_link`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$viy->exec($psql);
