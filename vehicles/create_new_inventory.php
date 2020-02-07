
<?php
    include "../commons/db_connect.php";
    include "../commons/header.php";
    //Declare all variables//
    $selected_model = $selected_make = $selected_power_type = $selected_vehicle_type= "";
    $year = $year_err = $color = $color_err = $vin = $vin_err = $purchase_date = $purchase_date_err = "";
    $purchase_price = $purchase_price_err = $sold_date =$sold_price = $sold_date_err = $sold_price_err = $add_cost = $add_cost_err = $global_err = "";
    $makes = $makes_models = $models = $power_types = $vehicle_types = array();
    $selected_make_id = $selected_model_id = $selected_power_type_id = $selected_vehicle_type_id =  0;
    //Get model names
    $get_models = "SELECT CONCAT(models.name,'(',makes.name,')') as model_make FROM models,makes WHERE makes.id = models.makeid";
    $result = mysqli_query($db_connection,$get_models);
    if($result -> num_rows > 0){
        while($row = $result -> fetch_assoc()){
            $models_makes[] = $row["model_make"];
            }
        } else{
            $global_err = "Could not fetch models. Something went wrong.";
    }




     //Get vehicle types
     $get_vehicle_types = "SELECT name FROM vehicle_types";
     $result = mysqli_query($db_connection,$get_vehicle_types);
     if($result -> num_rows > 0){
         while($row = $result -> fetch_assoc()){
             $vehicle_types[] = $row["name"]; 
         }
         } else{
             $global_err = "Could not fetch vehicle types. Something went wrong.";
     }

      //Get vehicle types
      $get_power_types = "SELECT name FROM vehicle_power_types";
      $result = mysqli_query($db_connection,$get_power_types);
      if($result -> num_rows > 0){
          while($row = $result -> fetch_assoc()){
              $power_types[] = $row["name"]; 
          }
          } else{
              $global_err = "Could not fetch power types. Something went wrong.";
      }
      
      //Validate inputs 

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST['selected_model'])){
            $global_err  = "You forgot to select a model!";
        } else {
            $selected_model = $_POST["selected_model"];
        }
     

        if(!isset($_POST['selected_power_type'])){
            $global_err  = "You forgot to select a model!";
        } else {
            $selected_power_type = $_POST["selected_power_type"];
        }

        if(!isset($_POST['selected_vehicle_type'])){
            $global_err  = "You forgot to select a make!";
        } else {
            $selected_vehicle_type = $_POST["selected_vehicle_type"];
        }

        $year = trim(($_POST["year"]));
        if(empty($year)){
            $year_err = "Please enter a valid year!";
        } elseif (intVal($year) < 1000 || intVal(trim($year) > 2100)){
            $year_err = "Please select a valid year!";
        } else {
            $year = trim(($_POST["year"]));
        }

        $color = trim(($_POST["color"]));
        if(empty($color)){
            $color_err = "Please enter a color!";
        }else {
            $color = trim(($_POST["color"]));
        }

        $vin = trim(($_POST["vin"]));
        if(empty($vin)){
            $vin_err = "Please enter a VIN number!";
        } elseif(strlen($vin) != 17){
            $vin_err = "VIN must have 17 digits!."; 
        } else {
            $sql = "SELECT * FROM vehicles WHERE vin = '$vin'";
            $result = $db_connection->query($sql);
            if($result -> num_rows > 0){
                $vin_err = "The vin is already exist. Please choose another one. ";
            } else{
                $vin = trim($_POST["vin"]);
            }
        }

        $purchase_date = trim($_POST["purchase_date"]);
        if(empty($purchase_date)){
            $purchase_date_err = "Purchase Date cannot be empty";
        } else {
            $purchase_date = trim($_POST["purchase_date"]);
        }

        $purchase_price = trim($_POST["purchase_price"]);
        if(empty($purchase_price)){
            $purchase_price_err = "Please enter the purchase price!";
        } elseif(!filter_var($purchase_price,FILTER_VALIDATE_FLOAT)){
            $purchase_price_err = "The number you entered is not valid.";
        } else {
            $purchase_price = trim($_POST["purchase_price"]); 
        }


        $sold_date = trim($_POST["sold_date"]);
        if(empty($sold_date)){
            $sold_date = NULL;
        } else {
            $sold_date = trim($_POST["sold_date"]);
        }

        $sold_price = trim($_POST["sold_price"]);
        if(empty($sold_price)){
            $sold_price = NULL;
        } elseif(!filter_var($sold_price,FILTER_VALIDATE_FLOAT)){
            $sold_price_err = "The number you entered is not valid.";
        } else {
            $sold_price = trim($_POST["sold_price"]); 
        }

        $add_cost = trim($_POST["add_cost"]);
        if(empty($add_cost)){
            $add_cost = NULL;
        } else if(!filter_var($add_cost,FILTER_VALIDATE_FLOAT)){
            $add_cost_err= "The number you entered is not valid.";
        } else {
            $add_cost = trim($_POST["add_cost"]); 
        }



       
        
       
        //Reformat date to upload to mySQL
        $formatted_purchase_date  = date("Y-m-d",strtotime($purchase_date));
        $formatted_sold_date = date("Y-m-d",strtotime($sold_date));
      

        //Check everything before inserting into the database;
        if(empty($global_err) && empty($year_err) && empty($color_err) && empty($vin_err) 
        && empty($purchase_date_err) && empty($purchase_price_err) && empty($sold_date_err) && empty($sold_price_err) && empty($add_cost_err )){
            //Get model_id from selected_model_name
            $stmt = $db_connection->prepare('SELECT id FROM models WHERE name = ?');
            $stmt->bind_param('s', $selected_model); // 's' specifies the variable type => 'string
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $selected_model_id = $row['id'];
            }

            //Get vehicle_type_id
            $stmt = $db_connection->prepare('SELECT id FROM vehicle_types WHERE name = ?');
            $stmt->bind_param('s', $selected_vehicle_type); // 's' specifies the variable type => 'string
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $selected_vehicle_type_id = $row['id'];
            }

            //Get vehicle_power_type_id
            $stmt = $db_connection->prepare('SELECT id FROM vehicle_power_types WHERE name = ?');
            $stmt->bind_param('s', $selected_power_type); // 's' specifies the variable type => 'string
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $selected_power_type_id = $row['id'];

            }

            // Add new record.
            $query = "INSERT INTO vehicles(model_id, year, vehicle_type_id, vehicle_power_type_id, vin, dealer_purchase_date, dealer_purchase_price, sold_date, sold_price, additional_cost, color) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $preparedStmt = @mysqli_prepare($db_connection, $query);
            $purchase_date = date("Y-m-d",strtotime($purchase_date));
           empty($sold_date)? $sold_date =  NULL : $sold_date = date("Y-m-d",strtotime($sold_date));
            if (@mysqli_stmt_bind_param($preparedStmt, 
                                        "iiiissdsdds", 
                                        $selected_model_id, 
                                        $year, 
                                        $selected_vehicle_type_id, 
                                        $selected_power_type_id, 
                                        $vin,
                                        $purchase_date,
                                        $purchase_price,
                                        $sold_date,
                                        $sold_price,
                                        $add_cost,
                                        $color) &&
                @mysqli_stmt_execute($preparedStmt))
            {
                @mysqli_stmt_close($preparedStmt); 
                header("Location: manage_inventory.php");
            } 
            else
            {
                
                echo '<p class="error">This page has been accessed in error.</p>';
                echo "<p>" . @mysqli_error($db_connection) . "<br><br/>Query: "."</p>";                            
            } 

        }
        }

?>


<div class="container-fluid">
    <div class="row">
       <?php include "inventory_nav.php";?>
       <h3 class = "text-center"> Add Vehicle Inventory</h3>
        <div class= "col-md-6 col-md-offset-3" style ="padding-top:20px;">
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           
            <div class="form-group row">
                <label for="selected_model" class="col-sm-3 col-form-label"> Model:</label>
                <div class = "col-sm-9">
                <select class = "form-control" id ="selected_model" name="selected_model" style="max-width: 50%">
                    <?php foreach($models_makes as $key => $value) { ?>
                    <option  <?php if ($selected_model == $value ) echo 'selected' ; ?> value="<?php echo explode("(",$value)[0] ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="year" class="col-sm-3 col-form-label">Year: </label>
                <div class="col-sm-9">
                    <input type="text" name="year" class="form-control" id="year" value = "<?php echo $year; ?>" placeholder="" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $year_err ?></div>
                </div> 
            </div>

            <div class="form-group row">
                <label for="color" class="col-sm-3 col-form-label">Color: </label>
                <div class="col-sm-9">
                    <input type="text" name="color" class="form-control" id="color" value = "<?php echo $color; ?>" placeholder="" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $color_err ?></div>
                </div> 
            </div>

            <div class="form-group row">
                <label for="vin" class="col-sm-3 col-form-label">VIN: </label>
                <div class="col-sm-9">
                    <input type="text" name="vin" class="form-control" id="vin" value = "<?php echo $vin; ?>" placeholder="" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $vin_err ?></div>
                </div> 
            </div>

            <div class="form-group row">
                <label for="selected_type" class="col-sm-3 col-form-label"> Vehicle Type:</label>
                <div class = "col-sm-9">
                <select class = "form-control" id ="selected_type" name="selected_vehicle_type" style="max-width: 50%">
                    <?php foreach($vehicle_types as $key => $value) { ?>
                    <option  <?php if ($selected_vehicle_type == $value ) echo 'selected' ; ?> value="<?php echo $value ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="selected_power_type" class="col-sm-3 col-form-label"> Power Type:</label>
                <div class = "col-sm-9">
                <select class = "form-control" id ="selected_power_type" name="selected_power_type" style="max-width: 50%">
                    <?php foreach($power_types as $key => $value) { ?>
                    <option  <?php if ($selected_power_type == $value ) echo 'selected' ; ?> value="<?php echo $value ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>
                </div>
            </div>


            <div class="form-group row">
                <label for="purchase_date" class="col-sm-3 col-form-label">Purchase Date: </label>
                <div class="col-sm-9">
                    <input type="text" name="purchase_date" class="form-control" id="purchase_date" value ="<?php echo $purchase_date ?>" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $purchase_date_err ?></div>
                </div> 
            </div>


            <div class="form-group row">
                <label for="purchase_price" class="col-sm-3 col-form-label">Purchase Price: </label>
                <div class="col-sm-9">
                    <input type="text" name="purchase_price" class="form-control" id="purchase_price" value = "<?php echo $purchase_price ?>" placeholder="" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $purchase_price_err ?></div>
                </div> 
            </div>

            <div class="form-group row">
                <label for="sold_date" class="col-sm-3 col-form-label">Sold Date: </label>
                <div class="col-sm-9">
                    <input type="text" name="sold_date" class="form-control" id="sold_date" value ="<?php echo $sold_date ?>" placeholder="" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $sold_date_err ?></div>
                </div> 
            </div>

            <div class="form-group row">
                <label for="sold_price" class="col-sm-3 col-form-label">Sold Price: </label>
                <div class="col-sm-9">
                    <input type="text" name="sold_price" class="form-control" id="sold_price" value = "<?php echo $sold_price ?>" placeholder="" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $sold_price_err ?></div>
                </div> 
            </div>

            <div class="form-group row">
                <label for="add_cost" class="col-sm-3 col-form-label">Additional Cost: </label>
                <div class="col-sm-9">
                    <input type="text" name="add_cost" class="form-control" id="add_cost" placeholder="" value = "<?php echo $add_cost ?>" style="max-width: 50%">
                    <div class="text-danger"> <?php echo $add_cost_err ?></div>
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


<!-- For Datepicker -->
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- Javascript -->
      <script>
         $(function() {
            $( "#purchase_date" ).datepicker();
            $( "#sold_date" ).datepicker();
         });
      </script> 