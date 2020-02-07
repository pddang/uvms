<?php
    include "../commons/header.php";
    require_once "../commons/db_connect.php";

     
            //Get user info 
            $global_err = "";
                //Get info from vehicle
                if(isset($_GET['vehicle_id']) && !empty($_GET['vehicle_id'])){
                    $vehicle_id = $_GET['vehicle_id'];
                    $stmt = $db_connection -> prepare("SELECT m.name as make, md.name as model, v.color, v.year, v.vin, vt.name as type, vpt.name as power_type, v.dealer_purchase_date as purchase_date, v.dealer_purchase_price as purchase_price,v.sold_date,v.sold_price, v.additional_cost
                    FROM makes m, models md, vehicle_types vt,vehicle_power_types vpt, vehicles v
                    WHERE m.id = md.makeid AND v.model_id = md.id AND v.vehicle_type_id = vt.id 
                    AND v.vehicle_power_type_id = vpt.id AND v.vehicle_id = ?");
                    $stmt->bind_param('s', $vehicle_id); // 's' specifies the variable type => 'string'
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $make = $row["make"];
                        $model = $row["model"];
                        $vin = $row["vin"];
                        $year = $row["year"];
                    }
                }

            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $confirm = htmlspecialchars($_POST["confirm"],ENT_QUOTES);
                if($confirm == "yes"){
                    //Deleting record
                    $vehicle_id = $_POST["vehicle_id"];
                    $sql = "DELETE FROM vehicles WHERE vehicle_id =? LIMIT 1"; 
                    $q = mysqli_stmt_init($db_connection);
                    mysqli_stmt_prepare($q,$sql);
                    mysqli_stmt_bind_param($q,"s",$vehicle_id);
                    mysqli_stmt_execute($q);
                    echo mysqli_affected_rows($db_connection);
                    if(mysqli_affected_rows($db_connection) == 1){
                        header("location:manage_inventory.php");
                        exit();
                    } else{
                        $global_err = mysqli_error($db_connection);
                        exit();
                    }
                }
                if($confirm == "no"){
                    header("location:manage_inventory.php");
                }
            }
        
  
?>
 
<div class="container-fluid">
    <div class="row">
        <?php include "vehicle_nav.php" ?>
        <div class= "col-md-10" style ="padding-top:20px;">
            <div class= "col-md-6 col-md-offset-3" style ="padding-top:20px;">
            <h3 class="text-center"> Delete Inventory</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group text-center">
                <label>Are you sure you want to delete <?php  echo "(".$make."/".$model."/".$year."/".$vin.")" ?>?</label>
                <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicle_id?>"><br>
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