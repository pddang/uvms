<?php
    session_start();
    include "../commons/db_connect.php";
    include "../commons/header.php";
?>

<div class="container-fluid">
    <div class="row">
       <?php include "navs/users_nav.php";?>
        <div class= "col-md-8 col-md-offset-1" style ="padding-top:20px;">
           <h3 class="text-center"> Registered Users</h3>
           <table class="table table-bordered">
                    <?php
                    $get_users = "SELECT user_id,first_name, last_name,user_name, email, DATE_FORMAT(registration_date,'%M %d, %Y') as registration_date FROM users";
                    $result = mysqli_query($db_connection,$get_users);
                    if($result -> num_rows > 1){ //Excluding the logged in user. 
                        echo  
                        "<thead class= 'thead-light'>
                        <tr>
                        <th scope='col'>Edit</th>
                        <th scope='col'>Delete</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Username</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Date Registered</th>
                        </tr>
                        </thead>";
                        while($row = $result -> fetch_assoc()){
                            if($row["user_name"] != $_SESSION["user_name"]){
                                echo " <tbody> <tr><td><a href='edit_user.php?user_id={$row["user_id"]}'>Edit</a></td>
                                <td><a href='delete_user.php?user_id={$row["user_id"]}'>Delete</a></td><td>"
                           .ucwords($row["last_name"]).", "
                           .ucwords($row["first_name"])."</td><td>"
                           .strtolower($row["user_name"])."</td><td>"
                           .$row["email"]."</td><td>"
                           .$row["registration_date"]."</td></tr></tbody>";
                            }
                     }
                    } else {
                        echo "<h4 class = 'text-center text-warning'> There is no other users exist! </h4>";
                    }
                    ?>
                </table>
        </div>
    </div>
</div>

<?
    include "../commons/footer.php";
?>


