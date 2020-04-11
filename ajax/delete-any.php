<?php
include_once "../../../../config.php";
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
$table = $_POST['table'];
$field = "";
if ($table == "cards") $field = "card_number";
else if ($table == "books") $field = "book_number";
$key = "'".$_POST['ID']."'";
$sql = "delete from $table where $field = $key";
mysqli_query($con, $sql);
echo mysqli_error($con);
var_dump($sql);
mysqli_close($con);
?>