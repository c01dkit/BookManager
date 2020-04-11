<?php
    require_once  '../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
    require_once  '../PHPExcel-1.8/Classes/PHPExcel.php';
    require_once  '../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
    include_once  "../../../../config.php";

    //$objPHPExcel = new PHPExcel();                        //初始化PHPExcel(),不使用模板
    $template = '../template/BookManagementStorage.xlsx';          //使用模板
    $objPHPExcel = PHPExcel_IOFactory::load($template);     //加载excel文件,设置模板

    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  //设置保存版本格式

    //接下来就是写数据到表格里面去
    $objActSheet = $objPHPExcel->getActiveSheet();
    $objActSheet->setCellValue('B2',  "admin");
    $objActSheet->setCellValue('F2',  date('Y-m-d H:i:s'));

    $con = mysqli_connect($dbserver, $dbuser, $dbpassword, $lab5_database);
    $table = mysqli_query($con, "select * from books");
    $i = 4;
    while ($row = mysqli_fetch_assoc($table)) {
        $objActSheet->setCellValue('A'."$i", $row['book_name']);
        $objActSheet->setCellValue('B'."$i", $row['book_number']);
        $objActSheet->setCellValue('C'."$i", $row['author']);
        $objActSheet->setCellValue('D'."$i", $row['book_type']);
        $objActSheet->setCellValue('E'."$i", $row['publisher']);
        $objActSheet->setCellValue('F'."$i", $row['year']);
        $objActSheet->setCellValue('G'."$i", $row['total']);
        $objActSheet->setCellValue('H'."$i", $row['storage']);
        $objActSheet->setCellValue('I'."$i", $row['price']);
        $i++;
    }

    // 1.保存至本地Excel表格
    //$objWriter->save($filename.'.xls');

    // 2.接下来当然是下载这个表格了，在浏览器输出就好了
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");;
    header('Content-Disposition:attachment;filename="'."BookManagementStorageRecord-".date('Y-m-d').'.xls"');
    header("Content-Transfer-Encoding:binary");
    $objWriter->save('php://output');


?>