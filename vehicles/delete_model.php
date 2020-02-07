<?php
    include "../commons/header.php";
    require_once "../commons/db_connect.php";

        $id = $name = "";
        $global_err = "";
            //Get user info 
            $id = $name = $name_err = $global_err = "";
            if(isset($_GET['id']) && !empty($_GET['id'])){
                $id = trim($_GET['id']);
                $sql = "SELECT name FROM models where id = $id";
                $result = mysqli_query($db_connection, $sql);
                while($res = mysqli_fetch_array($result)){
                    $name = $res["name"];
                }
            }


            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $confirm = htmlspecialchars($_POST["confirm"],ENT_QUOTES);
                if($confirm == "yes"){
                    //Deleting record
                    $id = $_POST["id"];
                    $sql = "DELETE FROM models WHERE id =? LIMIT 1"; 
                    $q = mysqli_stmt_init($db_connection);
                    mysqli_stmt_prepare($q,$sql);
                    mysqli_stmt_bind_param($q,"s",$id);
                    mysqli_stmt_execute($q);
                    echo mysqli_affected_rows($db_connection);
                    if(mysqli_affected_rows($db_connection) == 1){
                        header("location:manage_models.php");
                        exit();
                    } else{
                        $global_err = mysqli_error($db_connection);
                        exit();
                    }
                }
                if($confirm == "no"){
                    header("location:manage_models.php");
                }
            }
        
  
?>
 
<div class="container-fluid">
    <div class="row">
        <?php include "vehicle_nav.php" ?>
        <div class= "col-md-10" style ="padding-top:20px;">
            <div class= "col-md-6 col-md-offset-3" style ="padding-top:20px;">
            <h3 class="text-center"> Delete Vehicle Model</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group text-center">
                <label>Are you sure you want to delete <?php  echo ucwords($name) ?>?</label>
                <input type="hidden" name="id" id="id" value="<?php echo $id?>"><br>
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