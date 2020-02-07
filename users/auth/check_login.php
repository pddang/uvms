<?php
 session_start();
 //Check if the user is already logged in, if yes then redirect him to welcome page
 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
     header("location: ../member.php");
     exit();
 }
 require_once("../../commons/db_connect.php");

 // Define variables and initialize with empty values
$user_name = $password = "";
$is_admin = 0;
$global_err = $username_err = $password_err = "";
//Check if the form has been submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){
  //Get user and password sent from form
  $user_name = mysqli_real_escape_string($db_connection,$_POST['user_name']);
  $password = mysqli_real_escape_string($db_connection,$_POST['password']);
  if(empty(trim($_POST["user_name"]))){
    $username_err = "Please enter your username";
  } else{
    $user_name = trim($_POST["user_name"]);
  }
  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter your password";
  } else{
    $password = trim($_POST['password']);
  }
  if(empty($username_err)&&empty($password_err)){
    $sql = "SELECT user_id,user_name,password, is_admin FROM users WHERE user_name =? ";
    if($stmt = mysqli_prepare($db_connection,$sql)){
      mysqli_stmt_bind_param($stmt,"s",$user_name);
      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
          mysqli_stmt_bind_result($stmt,$user_id, $user_name,$hashed_password, $is_admin);
          if(mysqli_stmt_fetch($stmt)){
            if(sha1($password) == $hashed_password){
              session_start();        
              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["user_name"] = $user_name;
              $_SESSION["is_admin"] = $is_admin;
              header("location:../../users/member.php");
              exit();
            } else{
              $password_err ="The password you entered did not match. Please try again.";
            }
          }
        } else {
          $username_err = "No account found with that username";
        }
      } else {
        $global_err = mysqli_error($db_connection);
      }
    }
    echo($user_name);
    mysqli_stmt_close($stmt);
  }
  mysqli_close($db_connection);
 
}
?>