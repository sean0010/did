<?php
$databaseHost = 'localhost';
$databaseName = 'did';
$databaseUsername = 'did';
//$databasePassword = 'ciou3nr343$#@!';
$databasePassword = 'did';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>