<?php
include_once "../../../../config.php";
$card_number = test($_POST['card_number']);
$book_number = test($_POST['book_number']);
$sql_card_number = ($card_number == "") ? "" : " and card_number = '$card_number'";
$sql_book_number = ($book_number == "") ? "" : " and book_number = '$book_number'";
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
$sql = "select * from records where 1=1".$sql_card_number.$sql_book_number;
$table =mysqli_query($con, $sql);
if ($table->num_rows != 0) {
    echo <<<TABLE
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">借书卡号</th>
      <th scope="col">书号</th>
      <th scope="col">借出时间</th>
      <th scope="col">归还时间</th>
      <th scope="col">操作员</th>
    </tr>
  </thead>
  <tbody>
TABLE;
    $i = 0;
    while (($row = mysqli_fetch_assoc($table)) != "") {
        $i = $i + 1;
        echo "<tr>";
        echo "<th scope = 'row' >$i</th >";
        echo "<td title='$row[card_number]' >" . $row['card_number'] . "</td>";
        echo "<td title='$row[book_number]' >" . $row['book_number'] . "</td>";
        echo "<td title='$row[lent_date]' >" . $row['lent_date'] . "</td>";
        echo "<td title='$row[return_time]' >" . $row['return_time'] . "</td>";
        echo "<td title='$row[operator]' >" . $row['operator'] . "</td>";
        echo "</tr>";
    }
    echo <<<TABLE_END
</tbody>
</table>
TABLE_END;
} else {
    echo "<div class='text-muted'>空空如也……</div>";
}
mysqli_close($con);
?>
