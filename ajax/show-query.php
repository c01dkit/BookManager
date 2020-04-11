<?php
session_start();
include_once "../../../../config.php";
function convert_to_sql($string) {
    $string = test($string);
    $string = "'".$string."'";
    return $string;
}
$sql_book_number = ($_POST['book_number']!="") ? " and book_number = ".convert_to_sql($_POST['book_number']): "";
$sql_book_type   = ($_POST['book_type']!="")   ? " and book_type = ".convert_to_sql($_POST['book_type']) : "";
$sql_book_name   = ($_POST['book_name']!="")   ? " and book_name = ".convert_to_sql($_POST['book_name']) : "";
$sql_publisher   = ($_POST['publisher']!="")   ? " and publisher = ".convert_to_sql($_POST['publisher']) : "";
$sql_author      = ($_POST['author']!="")      ? " and author = ".convert_to_sql($_POST['author']) : "";
$sql_min_year    = ($_POST['min_year']!="")    ? " and year >= ".convert_to_sql($_POST['min_year']): "";
$sql_max_year    = ($_POST['max_year']!="")    ? " and year <= ".convert_to_sql($_POST["max_year"]): "";
$sql_min_price   = ($_POST['min_price']!="")   ? " and price >= ".convert_to_sql($_POST['min_price']) : "";
$sql_max_price   = ($_POST['max_price']!="")   ? " and price <= ".convert_to_sql($_POST['max_price']) : "";
$sql_min_storage = ($_POST['min_storage']!="") ? " and storage >= ".convert_to_sql($_POST['min_storage']) : "";
$sql_max_storage = ($_POST['max_storage']!="") ? " and storage <= ".convert_to_sql($_POST['max_storage']) : "";
switch ($_POST['order']) {
    case "0": $order = ""; break;
    case "1": $order = " order by year asc";break;
    case "2": $order = " order by year desc";break;
    case "3": $order = " order by price asc";break;
    case "4": $order = " order by price desc";break;
    case "5": $order = " order by storage asc";break;
    case "6": $order = " order by storage desc";break;
}
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
$SQL = "select * from books where 1=1".$sql_book_number.$sql_book_type.$sql_book_name.$sql_publisher.$sql_author.$sql_min_year
    .$sql_max_year.$sql_min_price.$sql_max_price.$sql_min_storage.$sql_max_storage.$order;
$table = mysqli_query($con, $SQL);
$SQL = "当前使用的查询语句为："."select * from books".$sql_book_number.$sql_book_type.$sql_book_name.$sql_publisher.$sql_author.$sql_min_year
    .$sql_max_year.$sql_min_price.$sql_max_price.$sql_min_storage.$sql_max_storage.$order;
echo "<div id = 'my_query' hidden class='text-primary'>".$SQL."</div>";
if (mysqli_error($con)) {
    echo mysqli_error($con);
} else {
    if ($table->num_rows == 0) {
        echo "<div class='text-muted'>空空如也……</div>";
        exit();
    }
    echo <<<TABLE
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">书号</th>
      <th scope="col">类型</th>
      <th scope="col">书名</th>
      <th scope="col">出版社</th>
      <th scope="col">作者</th>
      <th scope="col">出版年份</th>
      <th scope="col">总藏书量</th>
      <th scope="col">库存</th>
      <th scope="col">单价</th>
      <th scope="col">操作</th>
    </tr>
  </thead>
  <tbody>
TABLE;
    $i = 0;
    while (($row = mysqli_fetch_assoc($table)) != "") {
        $i = $i + 1;
        echo "<tr id='book-row-$i'>";
        echo "<th scope = 'row' >$i</th >";
        echo "<td title='$row[book_number]' id='book-$i'>" . $row['book_number'] . "</td>";
        echo "<td title='$row[book_type]'>" . $row['book_type'] . "</td>";
        echo "<td title='$row[book_name]'>" . $row['book_name'] . "</td>";
        echo "<td title='$row[publisher]'>" . $row['publisher'] . "</td>";
        echo "<td title='$row[author]'>" . $row['author'] . "</td>";
        echo "<td title='$row[year]'>" . $row['year'] . "</td>";
        echo "<td title='$row[total]'>" . $row['total'] . "</td>";
        echo "<td title='$row[storage]'>" . $row['storage'] . "</td>";
        echo "<td title='$row[price]'>" . $row['price'] . "</td>";
        if (isset($_SESSION['login']))  echo "<td title='记录更新时间：$row[update_time]。确定删除？' class='text-danger' title='删除此书籍' onclick=delete_this('book-$i','books','#book-row-$i')>" . "删除" . "</td>";
        else echo "<td>无</td>";
        echo "</tr>";
    }
    echo <<<TABLE_END
</tbody>
</table>
TABLE_END;

}
?>
