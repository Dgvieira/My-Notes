<?php

$db_name = "my_notes";
$db_host = "localhost";
$db_user = "root";
$db_pass = "";

$conn = new PDO("mysql:dbname=". $db_name . ";host=" . $db_host, $db_user, $db_pass);
