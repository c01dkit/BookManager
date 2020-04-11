<?php
session_start();
include_once "../../../../config.php";

if (isset($_SESSION['login'])){
    session_destroy();
    echo "logout";
} else {
    if (isset($_POST['ID']) && isset($_POST['password'])){
        $ID = test($_POST['ID']);
        $password = test($_POST['password']);
        if ($ID == "admin" && $password == "admin"){
            $_SESSION['login'] = "admin";
            echo "login";
        }else {
            echo "login_failed";
        }
    }else{
        echo "logout";
    }
}
?>
