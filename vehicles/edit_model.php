<?php
include "../commons/header.php";
require_once "../commons/db_connect.php";

        $id = $model_name =$make_name = $model_name_err = $global_err = "";
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = trim($_GET['id']);
            $sql = "SELECT models.name as model_name, makes.name as make_name FROM models,makes WHERE models.makeid = makes.id AND models.id = $id";
            $result = mysqli_query($db_connection, $sql);
            while($res = mysqli_fetch_array($result)){
                $model_name = $res["model_name"];
                $make_name = $res["make_name"];
            }
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id= $_POST["id"];
            $make_name = $_POST["make_name"];
            if(empty(trim($_POST["model_name"]))){
                $model_name_err = "Please enter a name";
            } else {
                $model_name = $_POST["model_name"];
            }
        
            if(empty($model_name_err)) {
                $stmt = "UPDATE models SET name =? WHERE id = ? ";
                $preparedStmt = @mysqli_prepare($db_connection, $stmt);
                $q = mysqli_stmt_init($db_connection);
                if (@mysqli_stmt_bind_param($preparedStmt,
                        "ss", $model_name, $id) &&
                    @mysqli_stmt_execute($preparedStmt)) {
                    @mysqli_stmt_close($preparedStmt);
                    header("Location: manage_models.php");
                } else {
                    $global_err = @mysqli_error($db_connection);
                }
            }

        }
    
?>
<body>
<div class="container-fluid">
    <div class="row">
       <?php include "models_nav.php";?>
        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
           <h3 class="text-center"> Edit Model</h3>
           <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           <div class="form-group row">
                <label for="model-name" class="col-sm-2 col-form-label">Vehicle Model</label>
                <div class="col-sm-8">
                <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                <input type="text" name="model_name" class="form-control" id="model_name" placeholder="" value="<?php echo $model_name; ?>">
                </div>
            </div>
            <div class ="form-group row">
                <label for="make_name" class="col-sm-2 col-form-label">Vehicle Make</label>
                <div class ="col-sm-8">
                <input type="text" name="make_name" class="form-control" id="make_name" placeholder="" value="<?php echo $make_name;?>"  readonly >
                <div class="text-danger"> <?php echo $model_name_err ?></div>
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-sm-6 col-sm-offset-3">
                <button type="submit" name ="save" style="min-width:100px;" class="btn btn-block btn-primary">Save</button>
                </div>
            </div>
            <div class="text-danger text-center"> <?php echo $global_err ?></div>
            </form>
        </div>

    


    </div>
</div>  

</body>



<?php
    include "../commons/footer.php";
?>

