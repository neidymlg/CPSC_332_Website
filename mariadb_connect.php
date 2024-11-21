<?php
$severname = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Could not connect" . $conn->connect_error);
}

echo "Connected successfully";
?>