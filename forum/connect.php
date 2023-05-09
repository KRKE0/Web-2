<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

// Connect to AZURE MySQL in App database
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }

    $servername = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $username = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $password = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error No.".$conn->connect_errno." - Unable to connect to MySQL: ".$conn->connect_error);
}
//echo "Connected successfully<br>";

//$conn->close();

?>