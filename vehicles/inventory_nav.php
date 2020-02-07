<?php session_start(); ?>
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
<div class="sidebar-sticky">
<button class="btn btn-primary btn-block" onclick="location.href = '../users/auth/logout.php'">Logout</button>
<button class="btn btn-primary btn-block" onclick="location.href = 'create_new_inventory.php'">New Vehicle Inventory</button>
<button class="btn btn-primary btn-block" onclick="location.href = 'manage_inventory.php'">Manage Vehicle Inventory</button>
<button class="btn btn-primary btn-block" onclick="location.href = '../users/member.php'"><?php echo $_SESSION["is_admin"] == 0 ? "Member Home Page" : "Administrator Home Page";?></button>

</div>
</nav>
