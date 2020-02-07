
<?php
    session_start();
    include "../commons/db_connect.php";
    include "../commons/header.php";

    $make_name_err = $global_err= "";
    $make_names = array();
    $id = "";
    $sql = "SELECT name FROM makes";
    $result = mysqli_query($db_connection,$sql);
    if($result -> num_rows > 0){
        while($row = $result -> fetch_assoc()){
                 $make_names[] = $row["name"];
     }
    } else{
        $global_err = "Could not fetch makes. Something went wrong.";
    }
    $selected_make = $make_names{0}; //Default value

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST['selected_make'])){
        $global_err  = "You forgot to select a make !</li>";
    } else {
        $selected_make = $_POST["selected_make"];
    }       
    }
?>
<div class="container-fluid">
    <div class="row">
       <?php include "models_nav.php";?>
        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
            <h3 class = "text-center"> Vehicle Makes Selection</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="make" class="col-sm-3"> Select Vehicle Make</label>
            <div class = "col-sm-5">
            <select class = "form-control" id ="selected_make" name="selected_make" >
                <?php foreach($make_names as $key => $value) { ?>
                <option  <?php if ($selected_make == $value ) echo 'selected' ; ?> value="<?php echo $value ?>"><?php echo $value ?></option>
                <?php }?>
            </select>
            </div>
            <div class = "col-sm-4">
                <button type="submit" name ="submit" style="min-width:100px;" class="btn btn-block btn-info">Submit</button>
                <div class="text-danger text-center"> <?php echo $global_err ?></div>
            </div>
            </form>
        </div>

        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
            <h3 class = "text-center"> Vehicle Models</h3>
            <table class="table table-bordered">
                    <tbody>
                        <?php
                        $get_makes = "SELECT models.id, models.name FROM models, makes WHERE models.makeid = makes.id and makes.name = '$selected_make'"; 
                        $result = mysqli_query($db_connection,$get_makes);

                        if($result -> num_rows > 0){
                            echo "<thead class='thead-light'>
                            <tr>
                            <th scope='col'>Edit</th>
                            <th scope='col'>Delete</th>
                            <th scope='col'>Model Name</th>
                            </tr>
                            </thead>";
                            while($row = $result -> fetch_assoc()){
                                    echo "<tr><td><a href='edit_model.php?id={$row["id"]}'>Edit</a></td>
                                    <td><a href='delete_model.php?id={$row["id"]}'>Delete</a></td><td>"
                                    .ucwords($row["name"])."</td></tr>";
                                } 
                        } else {
                            echo "<h4 class = 'text-center text-warning'>No models available</h4>";
                        }
                        ?>
                    </tbody>
                    </table>
        </div>


    </div>
</div>

<?
    include "../commons/footer.php";
?>

