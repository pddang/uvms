
<?php
    session_start();
    include "../commons/db_connect.php";
    include "../commons/header.php";
?>

<div class="container-fluid">
    <div class="row">
       <?php include "makes_nav.php";?>
        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
        <h3 class = "text-center"> Vehicle Makes</h3>
           <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                    <th scope="col">Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_makes = "SELECT id,name FROM makes"; 
                    $result = mysqli_query($db_connection,$get_makes);
                    if($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()){
                                echo "<tr><td><a href='edit_make.php?id={$row["id"]}'>Edit</a></td>
                                <td><a href='delete_make.php?id={$row["id"]}'>Delete</a></td><td>"
                           .ucwords($row["name"])."</td></tr>"; 
                     }
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

