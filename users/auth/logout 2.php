<?php
session_start();
if(isset($_SESSION['user_name'])){
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
}
header("location:../../index.php");
?>