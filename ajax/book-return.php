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
$table = mysqli_query($con, "select * from cards where card_number = '$card_number'");
if ($table->num_rows == 0) {
    $result['new_text'] = "不存在这样的借书卡号！";
    exit(json_encode($result));
}
$table = mysqli_query($con, "select * from books where book_number = '$book_number'");
if ($table->num_rows == 0) {
    $result['new_text'] = "此书未曾被收容！";
    exit(json_encode($result));
} else {
    $row = mysqli_fetch_assoc($table);
}
$table = mysqli_query($con, "select * from records where book_number = '$book_number' and card_number = '$card_number'");
if ($table->num_rows == 0) {
    $result['new_text'] = "该读者未曾借出相关书籍！";
    exit(json_encode($result));
}
$flag = 0;
while ($row = mysqli_fetch_assoc($table)){
    if ($row['return_time'] != NULL || $row['return_time'] != "") continue;
    $flag = 1;
    mysqli_query($con, "update books set storage = storage + 1 where book_number = '$book_number'");
    if (isset($_SESSION['login'])) $operator = $_SESSION['login'];
    else $operator = "admin";
    $date = date("Y-m-d H:i:s");
    $id = $row['id'];
    mysqli_query($con, "update records set return_time = '$date' where id = $id");
}
if ($flag == 0) {
    $result['new_text'] = "该读者没有需要归还的书籍！";
    exit(json_encode($result));
}
$result['new_class'] = "text-info";
$result['new_text'] = "归还成功！";
$result['error'] = mysqli_error($con);
echo json_encode($result);
?>