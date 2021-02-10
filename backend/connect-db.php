<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'lalanote';

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$conn->set_charset("utf8");

session_start();
