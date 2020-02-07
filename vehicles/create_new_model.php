
<?php
    include "../commons/db_connect.php";
    include "../commons/header.php";
   
        /*Select Make Name */
        $model_name = $model_name_err = $global_err= "";
        $make_names = array();
        $selected_make = "";
        $selected_make_id = 0;
        $sql = "SELECT name FROM makes";
        $result = mysqli_query($db_connection,$sql);
        if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
                    $make_names[] = $row["name"]; 

        }
        } else{
            $global_err = "Could not fetch makes. Something went wrong.";
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!isset($_POST['selected_make'])){
            $global_err  = "You forgot to select a make!";
        } else {
            $selected_make = $_POST["selected_make"];
        }

        /* Check and Insert Model to Database */
        if(empty($_POST["model_name"])){
            $model_name_err = "Please enter a model name!";
        } else {
            $model_name = $_POST["model_name"]; // Model name to be inserted 
            if(empty($name_err)){
                $sql1 = "SELECT id FROM makes WHERE name = '$selected_make'"; //Get makeid from selected make name 
                $result = mysqli_query($db_connection,$sql1);
                if($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()){
                        $selected_make_id =  $row["id"];
                } 
                } else{
                    $global_err = "Could not fetch makes. Something went wrong.";
                }
                $sql = "INSERT INTO models(name,makeid) VALUES(?,?)";
                $q = mysqli_stmt_init($db_connection);
                mysqli_stmt_prepare($q,$sql);
                mysqli_stmt_bind_param($q,"ss",$model_name,$selected_make_id);
                mysqli_stmt_execute($q);
                if(mysqli_stmt_affected_rows($q) == 1){
                    header("location: manage_models.php");
                    exit();
                } else {
                    $global_err =  @mysqli_error($db_connection);
                }
            } else {
                $global_err = "Something went wrong. Please check again later.";
            }
        
        } 
        }




?>
<div class="container-fluid">
    <div class="row">
       <?php include "models_nav.php";?>
       <h3 class = "text-center"> Add Vehicle Model</h3>
        <div class= "col-md-6 col-md-offset-3" style ="padding-top:20px;">
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group row">
                <label for="model_name" class="col-sm-3 col-form-label">Vehicle Model: </label>
                <div class="col-sm-9">
                <input type="text" name="model_name" class="form-control" id="model_name" placeholder="" style="max-width: 50%">
                <div class="text-danger"> <?php echo $model_name_err ?></div>
            </div> 
            </div>
            <div class="form-group row">
                <label for="make" class="col-sm-3 col-form-label"> Vehicle Make:</label>
                <div class = "col-sm-9">
                <select class = "form-control" id ="selected_make" name="selected_make" style="max-width: 50%">
                    <?php foreach($make_names as $key => $value) { ?>
                    <option  <?php if ($selected_make == $value ) echo 'selected' ; ?> value="<?php echo $value ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>
                </div>
            </div>

            <div class = "col-sm-8 col-sm-offset-2">
                <button type="submit" name ="submit" style="max-width: 50%" class="btn btn-block btn-info">Add</button>
                <div class="text-danger"> <?php echo $global_err ?></div>
            </div>
            </form>
        </div>



    </div>
</div>

<?
    include "../commons/footer.php";
?>
