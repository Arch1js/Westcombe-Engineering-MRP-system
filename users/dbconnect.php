<?php
$host = "wedatabase.cr3lqvgcf76h.us-west-2.rds.amazonaws.com";
$user = "archijs";
$password = "y9wWVqSue9wX9JpM";
$db = "WE_database";

$mysqli=mysqli_connect($host,$user,$password,$db);

if (!$mysqli) {
  die("Connection error: " . mysqli_connect_error());
}
?>
