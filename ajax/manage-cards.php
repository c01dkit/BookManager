<?php
include_once "../../../../config.php";
$con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
$cards_card_number = test($_POST['cards_card_number']);
$cards_name = test($_POST['cards_name']);
$cards_department = test($_POST['cards_department']);
if ($cards_department == "不限") $cards_department = "";
$cards_card_type = test($_POST['cards_card_type']);
if ($cards_card_type == "不限") $cards_card_type = "";
$cards_contact = test($_POST['cards_contact']);

if ($_POST['way'] == "way2") {
    //query
    $sql = "select * from cards where 1=1";
    if ($cards_card_number != "") $sql .= " and card_number = "."'".$cards_card_number."'";
    if ($cards_name != "") $sql .= " and name = "."'".$cards_name."'";
    if ($cards_department != "") $sql .= " and department = "."'".$cards_department."'";
    if ($cards_card_type != "") $sql .= " and card_type = "."'".$cards_card_type."'";
    if ($cards_contact != "") $sql .= " and contact = "."'".$cards_contact."'";
    $table = mysqli_query($con, $sql);
    if ($table->num_rows == 0) {
        echo "<div class='text-muted'>空空如也……</div>";
    }else{
        echo <<<TABLE
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">借书卡号</th>
      <th scope="col">姓名</th>
      <th scope="col">学院</th>
      <th scope="col">读者类型</th>
      <th scope="col">联系方式</th>
      <th scope="col">添加时间</th>
      <th scope="col">操作</th>
    </tr>
  </thead>
  <tbody>
TABLE;
        $i = 0;
        while (($row = mysqli_fetch_assoc($table)) != "") {
            $i = $i + 1;
            echo "<tr id='card-row-$i'>";
            echo "<th scope = 'row' >$i</th >";
            echo "<td title='$row[card_number]' id='card-$i'>" . $row['card_number'] . "</td>";
            echo "<td title='$row[name]'>" . $row['name'] . "</td>";
            echo "<td title='$row[department]'>" . $row['department'] . "</td>";
            echo "<td title='$row[card_type]'>" . $row['card_type'] . "</td>";
            echo "<td title='$row[contact]'>" . $row['contact'] . "</td>";
            echo "<td title='$row[update_time]'>" . $row['update_time'] . "</td>";
            echo "<td title='删除此借书证' class='text-danger' onclick=delete_this('card-$i','cards','#card-row-$i')>" ."删除". "</td>";
            echo "</tr>";
        }
        echo <<<TABLE_END
</tbody>
</table>
TABLE_END;
    }
} else if ($_POST['way'] == "way1") {
    //insert
    $sql = "insert into cards(card_number, name, department, contact, card_type) values ('$cards_card_number','$cards_name','$cards_department','$cards_contact','$cards_card_type')";
    mysqli_query($con, $sql);
    if (mysqli_error($con) == "") echo "插入成功：".$sql;
    else echo "插入失败".mysqli_error($con);
}
mysqli_close($con);
?>
