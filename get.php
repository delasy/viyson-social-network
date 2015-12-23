<?php
    $db = new mysqli("mysql.hostinger.com.ua", "u533043863_viy", "secret", "u533043863_viy");
    $q = $db->query("SELECT * FROM messages");
    $row = $q->fetch_assoc();
    $last_mtime = $row["time"];
    $last_qtime = $_GET["time"];
    $i=0;
    while ($last_qtime >= $last_mtime) {
        usleep("500");
        $q = $db->query("SELECT * FROM messages ORDER BY time DESC LIMIT 1");
        $row = $q->fetch_assoc();
        $last_mtime = $row["time"];
        ++$i;
    }
    $row["cycles"] = $i;
    exit(json_encode($row));
