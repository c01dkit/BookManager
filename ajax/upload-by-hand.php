<?php
session_start();
include_once "../../../../config.php";

$book_name = test($_POST['book_name']);
$book_type = test($_POST['book_type']);
$book_number = test($_POST['book_number']);
$author = test($_POST['author']);
$price = intval(test($_POST['price']));
$publisher = test($_POST['publisher']);
$year = intval(test($_POST['year']));
$add = intval(test($_POST['add']));
$result = array();
$con = mysqli_connect("$dbserver","$dbuser","$dbpassword","$lab5_database");
$table = mysqli_query($con, "select * from books where book_number = '$book_number'");
if ($table->num_rows != 0) {
    //update
    $row = mysqli_fetch_assoc($table);
    $total = $row['total'] + $add;
    $storage = $row['storage'] + $add;
    $sql = "update books set price = $price, book_name = '$book_name', book_type = '$book_type', author = '$author', publisher = '$publisher', year = $year, total = $total, storage = $storage where book_number = '$book_number'";
    $result['sql'] = $sql;
    mysqli_query($con, $sql);

    $result['total'] = $total;
    $result['storage'] = $storage;

    if (mysqli_error($con) == ""){
        $result['new_Class'] = "offset-1 col-sm-3 btn btn-outline-success";
        $result['new_Text'] = "更新成功";
    } else {
        $result['new_Class'] = "offset-1 col-sm-3 btn btn-outline-danger";
        $result['new_Text'] = "更新失败！";
    }

} else {
    //insert
    mysqli_query($con,"insert into $lab5_table_books(book_number,book_type,book_name,publisher,author,year,price,total,storage)
    values ('$book_number','$book_type','$book_name','$publisher','$author','$year','$price','$add','$add')");
    $result['error'] = mysqli_error($con);
    if (mysqli_error($con) == ""){
        $result['new_Class'] = "offset-1 col-sm-3 btn btn-outline-success";
        $result['new_Text'] = "图书入库成功！";
    } else {
        $result['new_Class'] = "offset-1 col-sm-3 btn btn-outline-danger";
        $result['new_Text'] = "图书入库失败！";
    }
}
$result['error'] = mysqli_error($con);
$result = json_encode($result);
echo $result;
mysqli_close($con);
?>