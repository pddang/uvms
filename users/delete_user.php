<?php
    include "../commons/header.php";
    require_once "../commons/db_connect.php";
   
   $user_name = $password = $password_confirm = $email = $first_name = $last_name = "";
   $user_id = "";
   $global_err = "";
    $is_admin = 0;
    //Get user info 
    if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
        $user_id = htmlspecialchars($_GET['user_id'],ENT_QUOTES);
        $sql = "SELECT user_name,first_name, last_name, email, is_admin FROM users WHERE user_id =$user_id";
        $result = mysqli_query($db_connection,$sql);
        while($res = mysqli_fetch_array($result)){
            $user_name = $res["user_name"];
            $first_name = $res["first_name"];
            $last_name = $res["last_name"];
            $email = $res["email"];
            $is_admin = $res["is_admin"];
        }
        
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $confirm = htmlspecialchars($_POST["confirm"],ENT_QUOTES);
        if($confirm == "yes"){
            //Deleting record
            $user_id = $_POST["user_id"];
            $sql = "DELETE FROM users WHERE user_id =? LIMIT 1"; 
            $q = mysqli_stmt_init($db_connection);
            mysqli_stmt_prepare($q,$sql);
            mysqli_stmt_bind_param($q,"s",$user_id);
            mysqli_stmt_execute($q);
            if(mysqli_affected_rows($db_connection) == 1){
                header("location:manage_users.php");
                exit();
            } else{
                $global_err = mysqli_error($db_connection);
                exit();
            }
        }
        
    }

   

?>
 
<div class="container-fluid">
    <div class="row">
        <?php include "navs/users_nav.php" ?>
        <div class= "col-md-10" style ="padding-top:20px;">
            <div class= "col-md-6 col-md-offset-3" style ="padding-top:20px;">
            <h3 class="text-center"> Delete User</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group text-center">
                <label>Are you sure you want to delete <?php  echo ucwords($first_name)." ".ucwords($last_name) ?>?</label>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id?>"><br>
                <button type="submit" name="confirm" value="yes" style="min-width:100px;" class="btn btn-info">Yes</button>
                <button type="submit" name="confirm" value="no" style="min-width:100px;" class="btn btn-info">No</button>
                <p class ="text-center"> <?php echo $global_err ?></p>
            </div>
            </form>
        </div>
    </div>
</div>


<?
include "../commons/footer.php";

    ?>