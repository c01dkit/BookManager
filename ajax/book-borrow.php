<?php
session_start();
include_once "../../../../config.php";
$card_number = test($_POST['card_number']);
$book_number = test($_POST['book_number']);
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
$result = array();
$result['new_class'] = "text-danger";
if ($card_number == "" || $book_number == "") {
    $result['new_text'] = "书号或借书卡号不能为空！";
    exit(json_encode($result));
}
$table = mysqli_query($con, "select * from books where book_number = '$book_number'");
if ($table->num_rows == 0) {
    $result['new_text'] = "此书未曾被收容！";
    exit(json_encode($result));
} else {
    $row = mysqli_fetch_assoc($table);
    if ($row['storage'] == 0) {
        $result['new_text'] = "此书暂被全部借出！";
        exit(json_encode($result));
    }
}
$table = mysqli_query($con, "select * from cards where card_number = '$card_number'");
if ($table->num_rows == 0) {
    $result['new_text'] = "不存在这样的借书卡号！";
    exit(json_encode($result));
}
$result['new_class'] = "text-info";
$result['new_text'] = "借出成功！";
$date = date("Y-m-d H:i:s");
if (isset($_SESSION['login'])) $operator = $_SESSION['login'];
else $operator = "admin";
mysqli_query($con, "insert into records (card_number, book_number, lent_date, operator) values ('$card_number','$book_number','$date','$operator')");
mysqli_query($con, "update books set storage = storage - 1 where book_number = '$book_number'");
echo json_encode($result);
?>