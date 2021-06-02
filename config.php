<?php

$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password);

if($conn === false) {
    die("ERROR: Could Not connect. " . $conn->connect_error);
}

