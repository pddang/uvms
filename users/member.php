
<?php
    session_start();
    include "../commons/header.php";
?>
    <div class="container-fluid">
        <div class="row">
            <?php include "navs/member_nav.php" ?>
            <div class= "col-md-10" style ="padding-top:20px;">
                <p class ="text-center text-info" style="font-weight:bold;"><?php echo "You are currently logged in as: ". $_SESSION["user_name"]; ?></p>
                <img class = "img-responsive" src="../img/member.jpg">
            </div>

        </div>
    </div>
    <?
    include "../commons/footer.php";

?>


