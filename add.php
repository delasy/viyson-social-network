<?php
    $db = new mysqli("mysql.hostinger.com.ua", "u533043863_viy", "secret", "u533043863_viy");
    $db->query("INSERT INTO messages (text, time) VALUES ('".$_POST["text"]."', '".time()."');");
