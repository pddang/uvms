<?php
    include "../commons/header.php";
    require_once "../commons/db_connect.php";
    
        $name = $name_err = "";
        $global_err = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Validate first name and last name 
            if(empty(trim($_POST["name"]))){
                $name_err = "Please enter a name";
            } else {
                $name = trim($_POST["name"]);
                $sql = "SELECT name FROM makes WHERE name = '$name'";
                $result = $db_connection->query($sql);
                if($result -> num_rows > 0){
                    $name_err = "The name is already exist. Please choose another one. ";
                } else {
                    $name = trim($_POST["name"]);
                }
            }

            //Check input errors before inserting into database
            if(empty($name_err)){
                $sql= "INSERT INTO makes(name) VALUES (?)";
                $q=mysqli_stmt_init($db_connection);
                mysqli_stmt_prepare($q,$sql);
                mysqli_stmt_bind_param($q,"s", $name);
                mysqli_stmt_execute($q);
                if(mysqli_stmt_affected_rows($q) == 1){
                    header("location: manage_makes.php");
                    exit();
                } else {
                    $global_err = mysqli_error($db_connection);

                }   
            }
        }
    

?>
<div class="container-fluid">
    <div class="row">
       <?php include "makes_nav.php";?>
        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
           <h3 class="text-center"> Add Vehicle Make</h3>
           <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Vehicle Make: </label>
                <div class="col-sm-8">
                <input type="text" name="name" class="form-control" id="name" placeholder="">
                <div class="text-danger"> <?php echo $name_err ?></div>
                </div> 
            </div>
           
            
            <div class="form-group row">
                <div class="col-sm-6 col-sm-offset-3">
                <button type="submit" style="min-width:100px;" class="btn btn-block btn-primary">Add</button>
                </div>
            </div>
            <div class="text-danger text-center"> <?php echo $global_err ?></div>
            </form>
        </div>

    


    </div>
</div>

<?php
    include "../commons/footer.php";
?>
