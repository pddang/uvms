
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
<div class="sidebar-sticky">
<button class="btn btn-primary btn-block" onclick="location.href = 'auth/logout.php'">Logout</button>
<?php
$is_admin = $_SESSION["is_admin"];
if($is_admin == 1) {
    echo "<button class='btn btn-primary btn-block' onclick=\"location.href = 'manage_users.php'\">Manage Users</button>";
    echo "<button class='btn btn-primary btn-block' onclick=\"location.href = '../vehicles/vehicles.php'\">Manage Vehicles</button> ";
} else {
    echo "";
}
 ?>
<button class="btn btn-primary btn-block" onclick="location.href = '../vehicles/inventory.php'">Manage Inventory</button>
</div>
</nav>

