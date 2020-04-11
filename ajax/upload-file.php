<?php
include_once "../../../../config.php";
if ($_FILES["file"]["error"] > 0)
{
    echo "错误：" . $_FILES["file"]["error"] . "<br>";
}
else
{
    if ($_FILES['file']['type']!= "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
        exit("Wrong type");
    }

    /*读取excel文件，并进行相应处理*/
    $fileName = $_FILES["file"]["tmp_name"];
    if (!file_exists($fileName)) {
        exit("文件" . $fileName . "不存在");
    }

    require_once '../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';      //引入PHPExcel类库
    $objPHPExcel = PHPExcel_IOFactory::load($fileName);                 //创建对象
    $sheetCount = $objPHPExcel->getSheetCount();                        //获取sheet表格数目
    $sheetSelected = 0;                                                 //默认选中sheet0表
    $objPHPExcel->setActiveSheetIndex($sheetSelected);                  //选中表
    $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();        //获取表格行数
    $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();  //获取表格列数
    $dataArr = array();
    /* 循环读取每个单元格的数据 */
//行数循环
    $con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
    for ($row = 2; $row <= $rowCount; $row++) {
//列数循环 , 列数是以A列开始
        for ($column = 'A'; $column <= $columnCount; $column++) {
            $input = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
            $dataArr[] = test($input);
        }
        $iu_books_book_name = $dataArr[0];
        $iu_books_book_number = $dataArr[1];
        $iu_books_author = $dataArr[2];
        $iu_books_book_type = $dataArr[3];
        $iu_books_publisher = $dataArr[4];
        $iu_books_year = intval($dataArr[5]);
        $iu_books_price = intval($dataArr[6]);
        $iu_books_add_num = intval($dataArr[7]);
        $table = mysqli_query($con,"select * from books where book_number = '$iu_books_book_number'");
        if ($table->num_rows != 0){
            //update
            $sql_row = mysqli_fetch_assoc($table);
            var_dump($sql_row);
            $total = $sql_row['total'] + $iu_books_add_num;
            $storage = $sql_row['storage'] + $iu_books_add_num;

            $sql = "update books set price = '$iu_books_price' , book_name = '$iu_books_book_name' , book_type = '$iu_books_book_type'
                    , author = '$iu_books_author' , publisher = '$iu_books_publisher' , year = '$iu_books_year' , total = '$total' 
                    , storage = '$storage' where book_number = '$iu_books_book_number'";
            mysqli_query($con, $sql);
            echo mysqli_error($con);
        } else{
            //insert
            $sql = "insert into books (book_name, book_number, book_type, author, publisher, year, price, total, storage)
                    values ('$iu_books_book_name', '$iu_books_book_number', '$iu_books_book_type', '$iu_books_author', '$iu_books_publisher',
                    '$iu_books_year', '$iu_books_price', '$iu_books_add_num', '$iu_books_add_num')";
            mysqli_query($con, $sql);
            echo mysqli_error($con);
        }
        $dataArr = NULL;
    }
    mysqli_close($con);
}



?>