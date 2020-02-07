<?php
include "../commons/header.php";
require_once "../commons/db_connect.php";

    $id = $name = $name_err = $global_err = "";
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = trim($_GET['id']);
        $sql = "SELECT name FROM makes where id = $id";
        $result = mysqli_query($db_connection, $sql);
        while($res = mysqli_fetch_array($result)){
            $name = $res["name"];
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id= $_POST["id"];
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter a name";
        } else {
            $name = $_POST["name"];
            //Get make name
            $stmt = $db_connection->prepare("SELECT * FROM makes WHERE name = ?");
            $stmt->bind_param('s', $name); // 's' specifies the variable type => 'string
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $make_name = $row['name'];
                if($result -> num_rows == 1 && $make_name != $_POST["name"] ){
                    $name_err = "The name is already exist. Please choose another one. ";
                } else{
                    $name = trim($_POST["name"]);
                }
            }
        }
    
        if(empty($name_err)){
            $stmt = "UPDATE makes SET name =? WHERE id = ? ";
            $preparedStmt = @mysqli_prepare($db_connection, $stmt);
            $q = mysqli_stmt_init($db_connection);
            if (@mysqli_stmt_bind_param($preparedStmt,
                    "ss",$name,$id) &&
                @mysqli_stmt_execute($preparedStmt))
            {
                @mysqli_stmt_close($preparedStmt);
                header("Location: manage_makes.php");
            }
            else
            {
                $global_err =  @mysqli_error($db_connection);
            }

        }
    }


?>
<body>
<div class="container-fluid">
    <div class="row">
       <?php include "makes_nav.php";?>
        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
           <h3 class="text-center"> Edit Make</h3>
           <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-8">
                <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?php echo $name; ?>">
                <div class="text-danger"> <?php echo $name_err ?></div>
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

