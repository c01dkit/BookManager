function welcome_recover() {
    $("#SQL").text("欢迎使用图书管理系统 :)");
    $("#SQL").attr("class","text-muted");
}
$(document).ready(function () {
   $(".clear").click(function () {
       $("#records_2").html("<div id='records_2' style='width: 100%;border: none'>空空如也……</div>");
       $("#records").html("<div id='records' style='width: 100%;border: none'>空空如也……</div>");
   });
});
function delete_this(id,table,row) {
    const ID = "#"+id;
    $.post("./ajax/delete-any.php",
        {
            ID: $(ID).text(),
            table : table
        }
    );
    $(row).html("");
}
function login_out() {
    const ID = $("#inputID").val();
    const password = $("#inputPassword").val();
    $.post("./ajax/log-inout.php",
        {
            ID : ID,
            password : password
        },
        function (data) {
            if (data === "login"){
                window.location.reload();
            } else if (data === "logout") {
                window.location.reload();
            } else if (data === "login_failed") {
                $("#log_in").text("用户名与密码不匹配！");
                $("#log_in").attr("class","btn btn-outline-danger float-right col-sm-3");
                setTimeout(restore_log_in,1500);
            }
        });
}
function restore_log_in() {
    $("#log_in").text("登录");
    $("#log_in").attr("class","btn btn-outline-primary float-right col-sm-3");
}
function restore_upload_by_hand() {
    $("#upload_by_hand").attr("class","offset-1 col-sm-3 btn btn-outline-primary");
    $("#upload_by_hand").text("单本入库");

}

function upload_file() {
    $("#upload_by_file_form").ajaxSubmit();
    return false;
}
function book_borrow() {
    const card_number = $("#card_number").val();
    const book_number = $("#book_number").val();
    $.post("./ajax/book-borrow.php",
        {
            card_number:card_number,
            book_number:book_number
        },
        function (data) {
            data = jQuery.parseJSON(data);
            $("#SQL").attr("class",data.new_class);
            $("#SQL").text(data.new_text);
            setTimeout(welcome_recover, 2400);
        })
}
function book_return() {
    const card_number = $("#card_number_2").val();
    const book_number = $("#book_number_2").val();
    $.post("./ajax/book-return.php",
        {
            card_number:card_number,
            book_number:book_number
        },
        function (data) {
            data = jQuery.parseJSON(data);
            $("#SQL").attr("class",data.new_class);
            $("#SQL").text(data.new_text);
            setTimeout(welcome_recover, 2400);
        })
}
function show_records(section) {
    let card_number, book_number;
    if (section === "borrow") {
        card_number = $("#card_number").val();
        book_number = $("#book_number").val();
    }else if (section === "return") {
        card_number = $("#card_number_2").val();
        book_number = $("#book_number_2").val();
    }
    $.post("./ajax/show-records.php",
        {
            card_number:card_number,
            book_number:book_number
        },
        function (data) {
           if (section === "borrow") $("#records").html(data);
           else if (section === "return") $("#records_2").html(data);
        })
}
function cards_manage() {
    $("#cards-manage").ajaxSubmit({
        resetForm:true,
        success:function (data) {
            $("#cards").html(data);
        }
    });
    return false;
}
function add_book_manually(){
    const book_number = $("#books_book_number").val();
    const author = $("#books_author").val();
    const book_name = $("#books_book_name").val();
    const book_type = $("#books_book_type").val();
    const price = $("#books_price").val();
    const publisher = $("#books_publisher").val();
    const year = $("#books_year").val();
    const add = $("#books_add").val();

    $.post("./ajax/upload-by-hand.php",
        {
            book_name : book_name,
            book_number : book_number,
            author : author,
            book_type : book_type,
            price :price,
            publisher : publisher,
            year : year,
            add : add
        },
        function (data) {
            const result = jQuery.parseJSON(data);
            $("#upload_by_hand").attr("class",result.new_Class);
            $("#upload_by_hand").text(result.new_Text);
            setTimeout(restore_upload_by_hand,1500);
        })
}

function query_book() {
    const book_number = $("#query_books_book_number").val();
    const book_type = $("#query_books_book_type").val();
    const book_name = $("#query_books_book_name").val();
    const publisher = $("#query_books_book_publisher").val();
    const author = $("#query_books_book_author").val();
    const min_year = $("#query_books_book_min_year").val();
    const max_year = $("#query_books_book_max_year").val();
    const min_price = $("#query_books_book_min_price").val();
    const max_price = $("#query_books_book_max_price").val();
    const min_storage = $("#query_books_book_min_storage").val();
    const max_storage = $("#query_books_book_max_storage").val();
    const order = $("#order").val();
    $.post("ajax/show-query.php",
        {
            book_number:book_number,
            book_type:book_type,
            book_name:book_name,
            publisher:publisher,
            author:author,
            min_year:min_year,
            max_year:max_year,
            min_price:min_price,
            max_price:max_price,
            min_storage:min_storage,
            max_storage:max_storage,
            order:order
        },
        function (data) {
            $("#query").html(data);
            $("#SQL").html($("#my_query").html());
            setTimeout(welcome_recover,3000);
        });

}