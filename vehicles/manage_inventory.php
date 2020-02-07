<?php

    include "../commons/db_connect.php";
    include "../commons/header.php";
?>

<div class="container-fluid">
    <div class="row">
       <?php include "inventory_nav.php";?>
        <div class= "col-md-10" style ="padding-top:20px;">
           <h3 class="text-center"> Vehicle Inventory</h3>
           <table class="table table-bordered table-hover text-center" style = "max-width: 95%; margin:auto;">
                    <?php
                    $get_vehicles = "SELECT v.vehicle_id, m.name as make, md.name as model, v.color, vt.name as type, vpt.name as power_type, 
                    DATE_FORMAT(v.dealer_purchase_date,'%M %d, %Y') as purchase_date, v.dealer_purchase_price as purchase_price,
                    DATE_FORMAT(v.sold_date,'%M %d, %Y') as sold_date,v.sold_price, v.additional_cost
                    FROM makes m, models md, vehicle_types vt,vehicle_power_types vpt, vehicles v
                    WHERE m.id = md.makeid AND v.model_id = md.id AND v.vehicle_type_id = vt.id 
                    AND v.vehicle_power_type_id = vpt.id
                    ORDER BY purchase_date";
                    $result = mysqli_query($db_connection,$get_vehicles);
                    if($result -> num_rows > 0){ 
                        echo  
                        "<thead class= 'thead-light'>
                        <tr>
                        <th scope='col'>Edit</th>
                        <th scope='col'>Delete</th>
                        <th scope='col'>Make</th>
                        <th scope='col'>Model</th>
                        <th scope='col'>Color</th>
                        <th scope='col'>Type</th>
                        <th scope='col'>Power</th>
                        <th scope='col'>Purchase Date</th>
                        <th scope='col'>Purchase Price</th>
                        <th scope='col'>Sold Date</th>
                        <th scope='col'>Sold Price</th>
                        <th scope='col'>Additional Cost</th>
                        </tr>
                        </thead>";
                        while($row = $result -> fetch_assoc()){
                            $formatted_purchase_price = empty($row["purchase_price"]) ? "":"$".$row["purchase_price"];
                            $formatted_sold_price = empty($row["sold_price"]) ? "":"$".$row["sold_price"];
                            $formatted_additional_cost = empty($row["additional_cost"]) ? "":"$".$row["additional_cost"];
                            echo " <tbody> <tr><td><a href='edit_inventory.php?vehicle_id={$row["vehicle_id"]}'>Edit</a></td>
                            <td><a href='delete_inventory.php?vehicle_id={$row["vehicle_id"]}'>Delete</a></td><td>"
                           .ucwords($row["make"])."</td><td>"
                           .ucwords($row["model"])."</td><td>"
                           .ucwords($row["color"])."</td><td>"
                           .ucwords($row["type"])."</td><td>"
                           .ucwords($row["power_type"])."</td><td>"
                           .$row["purchase_date"]."</td><td>"
                           .$formatted_purchase_price."</td><td>"
                           .$row["sold_date"]."</td><td>"
                           .$formatted_sold_price."</td><td>"
                           .$formatted_additional_cost
                           ."</td></tr></tbody>"; 
                     }
                    } else {
                        echo "<h4 class = 'text-center text-warning'> There is no other inventory exist! </h4>";
                    }
                    ?>
                </table>
        </div>
    </div>
</div>

<?
    include "../commons/footer.php";
?>


