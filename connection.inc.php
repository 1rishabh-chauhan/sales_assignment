<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbnameForm = "sales_database";
$dbnameDropdown = "world_countries";

// Create connection
$connForm = new mysqli($servername, $username, $password, $dbnameForm);
$connDropdown = new mysqli($servername, $username, $password, $dbnameDropdown);

// Check connection
if ($connForm->connect_error || $connDropdown->connect_error) {
    die("Connection failed: " . $connForm->connect_error . $connDropdown->connect_error);
}
?>
