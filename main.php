<?php
// register.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internship_management";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con) {
    die("Connection failed: ".mysquli_error($con));
}
?>