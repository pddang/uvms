
<?php
    session_start();
    include "../commons/header.php";
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php include "vehicle_nav.php" ?>
            <p class ="text-center text-info" style="font-weight:bold; padding-top:10px;"><?php echo "You are currently logged in as: ". $_SESSION["user_name"]; ?></p>
            <div class= "col-md-8 col-md-offset-2" style ="padding-top:30px;">
                <img class = "img-responsive" src="../img/cars.jpg">
            </div>

        </div>
    </div>
    <?
    include "../commons/footer.php";

?>



