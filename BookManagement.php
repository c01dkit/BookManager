<!doctype html>
<?php
session_start();
include_once "../../../config.php";

?>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>实验5-图书管理系统</title>
    <link rel="stylesheet" href="./bootstrap-4.4.1-dist/css/bootstrap.css" />
    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/jquery.form.js"></script>
    <script src="./bootstrap-4.4.1-dist/js/bootstrap.bundle.js"></script>
    <script src="./bootstrap-4.4.1-dist/js/bootstrap.js"></script>
    <script src="js/lab5.js"></script>
    <link rel="shortcut icon" href="./images/iconfinder_booklet_1055108.ico" />
    <link rel="bookmark" href="./images/iconfinder_booklet_1055108.ico" />
</head>
<body class="container-fluid" style="padding-top: 0 " background="images/planet-1702788_1920.jpg.png"  >
<div style="display: table;padding: 40px;width: 100%;vertical-align: center" class="text-muted text-center">
    <div id="SQL" style="display: table-cell">欢迎使用图书管理系统 :)</div>
</div>
<div class="row">
    <div class="col-3 ">
        <div class="nav flex-column nav-pills" id="v-pills-tab">
            <?php 
            if (isset($_SESSION['login']) && $_SESSION['login'] == "admin"){

                echo "<a class='nav-link' id='v-pills-logout-tab' data-toggle='pill' href='#v-pills-logout'>退出登录</a>
                      <a class='nav-link active' id='v-pills-query-tab' data-toggle='pill' href='#v-pills-query'>图书查询</a>
                      <a class='nav-link' id='v-pills-borrow-tab' data-toggle='pill' href='#v-pills-borrow'>借书管理</a>
                      <a class='nav-link' id='v-pills-return-tab' data-toggle='pill' href='#v-pills-return'>还书管理</a>
                      <a class='nav-link' id='v-pills-in-tab' data-toggle='pill' href='#v-pills-in'>图书入库</a>
                      <a class='nav-link' id='v-pills-certificate-tab' data-toggle='pill' href='#v-pills-certificate'>借书证管理</a>";
            } else {
                echo "<a class='nav-link' id='v-pills-login-tab' data-toggle='pill' href='#v-pills-login' >用户登录</a>
                      <a class='nav-link active' id='v-pills-profile-tab' data-toggle='pill' href='#v-pills-query'>图书查询</a>";
            }
                echo "<a class='nav-link' id='v-pills-history-tab' data-toggle='pill' href='#v-pills-history'>关于</a>"
            ?>
            
        </div>
    </div>
    <div class="col-9 border-left ">
        <div class="tab-content text-center" id="v-pills-tabContent">
            <div class="tab-pane fade" id="v-pills-login">
                <form onsubmit="return false">
                    <div class="form-group row">
                        <label for="inputID" class="col-sm-4 col-form-label">管理员ID</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputID">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-4 col-form-label">登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="inputPassword">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-outline-primary float-right col-sm-3" id="log_in" onclick="login_out();">登录</button>
                        </div>
                    </div>
                </form>
            </div><!--管理员登陆部分-->
            <div class="tab-pane fade" id="v-pills-logout" >
                <button class="btn btn-outline-danger col-md-4 mx-auto"  onclick='login_out();' >退出登录</button>
            </div><!--退出登录部分-->
            <div class="tab-pane fade show active" id="v-pills-query">
                <form onsubmit="return false;">
                    <div class="form-group row">
                        <label for="query_books_book_name" class="col-form-label col-sm-1">书名</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="query_books_book_name"/>
                        </div>
                        <label for="query_books_book_author" class="col-form-label col-sm-1">作者</label>
                        <div>
                            <input type="text" class="form-control" id="query_books_book_author" />
                        </div>
                        <div class="btn-group  col-sm-3">
                            <button id="query_books_book_reset" class="btn btn-outline-danger offset-1" type="reset">重置条件</button>
                            <button id="query_books_book_truncate" class="btn btn-outline-danger " type="button" onclick="$('#query').text('');">清空结果</button>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="query_books_book_number" class="col-form-label col-sm-1">书号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="query_books_book_number"/>
                        </div>
                        <label for="query_books_book_type" class="col-form-label col-sm-1">类别</label>
                        <div>
                            <input type="text" class="form-control" id="query_books_book_type"/>
                        </div>
                        <div class="btn-group col-sm-3">
                        <button id="query_books_book_submit" class="btn btn-outline-primary offset-1 " type="submit" onclick="query_book();">检索书籍</button>
                        <button id="query_books_book_extract" class="btn btn-outline-primary" onclick="window.open('./ajax/download-file.php')" >导出库存</button>
                        </div>
                    </div>
                    <details><summary class="text-muted" style="text-align: left">高级检索</summary>
                        <div class="form-group row">
                            <label for="query_books_book_publisher" class="col-form-label col-sm-2">出版社</label>
                            <div>
                                <input class="form-control" id="query_books_book_publisher" type="text">
                            </div>
                            <label for="order" class="col-form-label col-2">排序方式</label>

                                <select id="order" class="form-control col-2">
                                    <option value="0" selected>---请选择---</option>
                                    <option value="1">按出版年份升序</option>
                                    <option value="2">按出版年份降序</option>
                                    <option value="3">按单价升序</option>
                                    <option value="4">按单价降序</option>
                                    <option value="5">按库存升序</option>
                                    <option value="6">按库存降序</option>
                                </select>

                        </div>
                        <div class="form-group row">
                            <label for="query_books_book_min_year" class="col-sm-2 col-form-label">出版年份不早于</label>
                            <div>
                                <input class="form-control" id="query_books_book_min_year" type="text">
                            </div>
                            <label for="query_books_book_max_year" class="col-sm-2 col-form-label">出版年份不晚于</label>
                            <div>
                                <input class="form-control" id="query_books_book_max_year" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="query_books_book_min_price" class="col-sm-2 col-form-label">单价不低于</label>
                            <div>
                                <input class="form-control" id="query_books_book_min_price" type="text">
                            </div>
                            <label for="query_books_book_max_price" class="col-sm-2 col-form-label">单价不高于</label>
                            <div>
                                <input class="form-control" id="query_books_book_max_price" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="query_books_book_min_storage" class="col-sm-2 col-form-label">库存不低于</label>
                            <div>
                                <input class="form-control" id="query_books_book_min_storage" type="text">
                            </div>
                            <label for="query_books_book_max_storage" class="col-sm-2 col-form-label">库存不高于</label>
                            <div>
                                <input class="form-control" id="query_books_book_max_storage" type="text">
                            </div>
                        </div>
                    </details>
                </form>
                <div id="query" style="width: 100%;border: none"><!--查询结果界面-->
                </div>

            </div><!--查询部分-->
            <div class="tab-pane fade" id="v-pills-borrow">
                <form id="book_borrow" onsubmit="return false">
                    <div class="form-group row">
                        <label for="card_number" class="col-2 col-form-label">借书卡号</label>
                        <input id="card_number" type="text" class="col-2 form-control" />
                        <label for="book_number" class="col-1 col-form-label">书号</label>
                        <input id="book_number" type="text" class="col-2 form-control" />
                        <div class="btn-group offset-1">
                            <button class="btn btn-outline-danger clear" type="reset" >清空结果</button>
                        <button class="btn btn-outline-success" type="button" onclick="show_records('borrow')">查询借还情况</button>
                        <button class="btn btn-outline-primary" type="button" onclick="book_borrow()">确认借出</button>
                        </div>
                    </div>
                </form>
                <div id="records" style="width: 100%;border: none"></div>
            </div><!--借书部分-->
            <div class="tab-pane fade" id="v-pills-return">
                <form id="book_return" onsubmit="return false">
                    <div class="form-group row">
                        <label for="card_number_2" class="col-2 col-form-label">借书卡号</label>
                        <input id="card_number_2" type="text" class="col-2 form-control" />
                        <label for="book_number_2" class="col-1 col-form-label">书号</label>
                        <input id="book_number_2" type="text" class="col-2 form-control" />
                        <div class="btn-group offset-1">
                            <button class="btn btn-outline-danger clear" type="reset" >清空结果</button>
                            <button class="btn btn-outline-success" type="button" onclick="show_records('return')">查询借还情况</button>
                            <button class="btn btn-outline-primary" type="button" onclick="book_return()">确认归还</button>
                        </div>
                    </div>
                </form>
                <div id="records_2" style="width: 100%;border: none"></div>
            </div><!--还书部分-->
            <div class="tab-pane fade" id="v-pills-in">
                <form  method="post" id="upload_by_file_form" action="./ajax/upload-file.php" onsubmit="return upload_file();" style="margin-bottom: 40px" enctype="multipart/form-data">
                    <div class="btn-group col-12 ">
                        <button type="button" id="template_download" class="btn btn-outline-primary col-sm-2 " onclick="window.open('./template/BookManagementTemplate.xlsx')">模板下载</button>
                        <button type="button" class="btn btn-outline-primary col-sm-2" title="请使用模板进行导入" onclick="$('#file_upload').click();" >文件上传</button>
                        <button  type="submit" id="upload_by_file_button" class="btn btn-outline-primary  col-sm-2" title="请使用模板进行导入" >批量导入</button>
                    </div>
                    <input type="file" id="file_upload" accept=".xlsx" name="file" hidden>
                </form>
                <form onsubmit="return false" >
                    <div class="form-group row">
                        <label for="books_book_name" class="col-3 col-form-label">书名</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_book_name"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_book_number" class="col-3 col-form-label">书号</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_book_number"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_author" class="col-3 col-form-label">作者</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_author"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_book_type" class="col-3 col-form-label">类别</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_book_type"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_publisher" class="col-3 col-form-label">出版社</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_publisher"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_year" class="col-3 col-form-label">出版年份</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_year"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_price" class="col-3 col-form-label">单价</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_price"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="books_add" class="col-3 col-form-label">入库数量</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="books_add"/>
                        </div>
                    </div>
                    <div class="form-group " style="margin-top: 40px">
                                <button type="reset" class="offset-3 col-sm-3 btn btn-outline-danger" >清空条件</button>
                                <button id="upload_by_hand" type="submit" class="offset-1 col-sm-3 btn btn-outline-primary" onclick="add_book_manually();">单本入库</button>

                    </div>
                </form> <!--单本插入-->

            </div><!--图书入库部分-->
            <div class="tab-pane fade" id="v-pills-certificate">
                <form id="cards-manage" method="post" action="./ajax/manage-cards.php" onsubmit="return cards_manage();" >
                    <div class="form-group row">
                        <label for="cards_card_number" class="col-1 col-form-label">卡号</label>
                        <input type="text" class="form-control col-2" id="cards_card_number" name="cards_card_number"/>

                        <label for="cards_name" class="col-1 col-form-label">姓名</label>
                        <input type="text" class="form-control col-1" id="cards_name" name="cards_name"/>

                        <label for="cards_department" class="col-1 col-form-label">学院</label>
                        <label class="col-2" style="padding:0"  >
                            <select name="cards_department" class="form-control" >
                                <option value="不限" selected>---请选择---</option>
                                <option value="求是学院云峰学园">求是学院云峰学园</option>
                                <option value="求是学院蓝田学园">求是学院蓝田学园</option>
                                <option value="求是学院丹青学园">求是学院丹青学园</option>
                                <option value="竺可桢学院">竺可桢学院</option>
                                <option value="国际联合学院（海宁国际校区）">国际联合学院（海宁国际校区）</option>
                                <option value="机械工程学院">机械工程学院</option>
                                <option value="材料科学与工程学院">材料科学与工程学院</option>
                                <option value="能源工程学院">能源工程学院</option>
                                <option value="电气工程学院">电气工程学院</option>
                                <option value="化学工程与生物工程学院">化学工程与生物工程学院</option>
                                <option value="海洋学院">海洋学院</option>
                                <option value="高分子科学与工程学系">高分子科学与工程学系</option>
                                <option value="建筑工程学院">建筑工程学院</option>
                                <option value="航空航天学院">航空航天学院</option>
                                <option value="数学科学学院">数学科学学院</option>
                                <option value="地球科学学院">地球科学学院</option>
                                <option value="物理学系">物理学系</option>
                                <option value="化学系">化学系</option>
                                <option value="心理与行为科学系">心理与行为科学系</option>
                                <option value="光电科学与工程学院">光电科学与工程学院</option>
                                <option value="信息与电子工程学院">信息与电子工程学院</option>
                                <option value="控制科学与工程学院">控制科学与工程学院</option>
                                <option value="计算机科学与技术学院">计算机科学与技术学院</option>
                                <option value="软件学院">软件学院</option>
                                <option value="生物医学工程与仪器科学学院">生物医学工程与仪器科学学院</option>
                                <option value="生命科学学院">生命科学学院</option>
                                <option value="农业与生物技术学院">农业与生物技术学院</option>
                                <option value="生物系统工程与食品科学学院">生物系统工程与食品科学学院</option>
                                <option value="环境与资源学院">环境与资源学院</option>
                                <option value="动物科学学院">动物科学学院</option>
                                <option value="经济学院">经济学院</option>
                                <option value="光华法学院">光华法学院</option>
                                <option value="教育学院">教育学院</option>
                                <option value="管理学院">管理学院</option>
                                <option value="公共管理学院">公共管理学院</option>
                                <option value="马克思主义学院">马克思主义学院</option>
                                <option value="外国语言文化与国际交流学院">外国语言文化与国际交流学院</option>
                                <option value="传媒与国际文化学院">传媒与国际文化学院</option>
                                <option value="艺术与考古学院">艺术与考古学院</option>
                                <option value="人文学院">人文学院</option>
                                <option value="医学院">医学院</option>
                                <option value="药学院">药学院</option>
                                <option value="工程师学院">工程师学院</option>
                            </select>
                        </label>

                        <button id="cards_add" type="submit" class="offset-1 col-2 btn btn-outline-primary" onclick="$('#way').val('way1')">新建借书证</button>
                    </div>
                    <div class="form-group row">
                        <label for="cards_card_type" class="col-1 col-form-label">类别</label>
                        <label class="col-2" style="padding: 0">
                            <select name="cards_card_type" class="form-control">
                            <option value="不限" selected>---请选择---</option>
                            <option value="教师">教师</option>
                            <option value="学生">学生</option>
                            <option value="校外人员">校外人员</option>
                            <option value="其他人员">其他人员</option>
                            </select>
                        </label>

                        <label for="cards_contact" class="col-2 col-form-label">联系方式</label>
                        <input type="text" class="form-control col-3" id="cards_contact" name="cards_contact"/>
                        <button id="cards_query" type="submit" class="offset-1 col-2 btn btn-outline-primary" onclick="$('#way').val('way2')">查询借书证</button>
                    </div>
                    <label> <input id="way" name="way" type="text" value="way1" hidden> </label>
                </form>
                <div id="cards" style="width: 100%;border: none"><!--借书证查询结果界面-->
                </div>
            </div><!--借书证管理部分-->
            <div class="tab-pane fade text-left" id="v-pills-history"><!--开发文档部分-->
               <div class="row">
                   <div class="alert alert-success col-10">图书管理系统暂时上线！欢迎提交bug~<a class="alert-link float-right" href="http://www.c01dkit.com/comments.php" target="_blank">戳我留言XD</a></div>
                   <div class="col-6">
                       <dl>
                           <dt>2020-4-11 v1.1</dt>
                           <dd>图书查询增添排序功能</dd>
                           <dt>2020-4-10 v1.0</dt>
                           <dd>完成xlsx上传与处理部分</dd>
                           <dd>优化单本上传，分为插入与更新两种情况处理</dd>
                           <dd>完成xls表格导出库存功能</dd>
                           <dd>编写借书证插入、查询页面与后端代码</dd>
                           <dd>借书证、书籍增添删除功能</dd>
                           <dd>更换管理界面背景图案</dd>
                           <dd>编写借书管理、还书管理页面与后端代码</dd>
                           <dd>借书、还书清空结果优化</dd>
                           <dd>基本功能全部实现，bug后续修复中</dd>
                       </dl>
                   </div>
                   <div class="col-6">
                       <dl>
                           <dt>2020-4-9 v0.3</dt>
                           <dd>编写书籍查询后端代码</dd>
                           <dd>添加前端顶部状态栏</dd>
                           <dd>优化前端查询，添加清空结果、SQL语句展示</dd>
                           <dt>2020-4-6 v0.2</dt>
                           <dd>制作书籍插入页面</dd>
                           <dd>编写单本插入后端代码</dd>
                           <dd>制作书籍查询页面</dd>
                           <dt>2020-4-3 v0.1</dt>
                           <dd>创建首页</dd>
                           <dd>编写nav-groups</dd>
                           <dd>制作用户登录、登出页面</dd>
                           <dd>编写用户登录、登出后端代码</dd>
                           <dt>2020-4-2 v0.0</dt>
                           <dd>建立工程目录</dd>
                           <dd>配置前端框架、创建数据库</dd>
                       </dl>
                   </div>
               </div>
            </div><!--开发历史-->
        </div>
    </div>
</div>


</body>
</html>