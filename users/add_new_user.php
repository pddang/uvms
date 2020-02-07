<?php
    include "../commons/header.php";
    require_once "../commons/db_connect.php";

    $user_name = $password = $password_confirm = $email = $first_name = $last_name = "";
    $is_admin = 0;
    $username_err = $password_err = $password_confirm_err = $email_err = $firstname_err = $lastname_err = "";
    $global_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Validate username
        if(empty(trim($_POST["user_name"]))){
            $username_err = "Please enter a username.";
        } else{
            // Prepare a select statement
            $user_name = $_POST["user_name"];
            $sql = "SELECT * FROM users WHERE user_name = '$user_name'";
            $result = $db_connection->query($sql);
            if($result -> num_rows > 0){
                $username_err = "The username is already exist. Please choose another one. ";
            } else{
                $user_name = trim($_POST["user_name"]);
            }
        }

        //Validate first name and last name 
        if(empty(trim($_POST["first_name"]))){
            $firstname_err = "Please enter your first name";
        } else {
            $first_name = trim($_POST["first_name"]);
        }
        if(empty(trim($_POST["last_name"]))){
            $lastname_err = "Please enter your last name";
        } else {
            $last_name = trim($_POST["last_name"]);
        }
        //Validate email
        if(empty(trim($_POST["email"]))){
            $email_err ="Please enter your email";
        } else {
            $email = trim($_POST["email"]);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $email_err = "Invalid email format";
            } 
            $sql = "SELECT * FROM users WHERE user_name = '$user_name'";
            $result = $db_connection->query($sql);
            if($result -> num_rows > 0){
                    $email_err = "The email is already exist. Please choose another one. ";
                } else {
                    $email = trim($_POST["email"]);
             }
            }
        

        //Validate password
        if(empty(trim($_POST["password"]))){
            $password_err ="Please enter a password";
        } elseif(strlen(trim($_POST["password"])) < 8){
            $password_err = "Password must have at least 8 characters.";
        } else {
            $password = trim($_POST["password"]);
        }

         //Validate password confirm
         if(empty(trim($_POST["password_confirm"]))){
            $password_err ="Please comfirm password";
        } else {
            $password_confirm = trim($_POST["password_confirm"]);
            if(empty($password_err)&& $password != $password_confirm){
                $password_confirm_err = "Password did not match";
            }
        }
       // Get isAdmin value
       if(isset($_POST['admin'])&& $_POST['admin'] == '1'){
           $is_admin = 1;
       } else {
           $is_admin = 0; 
       }
        //Get today date and assign it to registration date
        $registration_date = date("Y-m-d");
       
        //Check input errors before inserting into database
        if(empty($username_err)&&empty($firstname_err)
        &&empty($lastname_err)&&empty($email_err)
        &&empty($password_err)){
            $password_hashed = sha1($password); // hashing password for security
            $sql2= "INSERT INTO users (user_name,last_name, first_name, email, password,is_admin,registration_date) VALUES (?,?,?,?,?,?,?)";
            $q=mysqli_stmt_init($db_connection);
            mysqli_stmt_prepare($q,$sql2);
            mysqli_stmt_bind_param($q,"sssssis", $user_name, $first_name, $last_name, $email, $password_hashed,$is_admin,$registration_date);
            mysqli_stmt_execute($q);
            if(mysqli_stmt_affected_rows($q) == 1){
                header("location: manage_users.php");
                exit();
            } else {
                $global_err = mysqli_error($db_connection);

            }   
    } else{
        $global_err = "Something went wrong. Please check it again later.";
    }
    }



?>
<div class="container-fluid">
    <div class="row">
       <?php include "navs/users_nav.php";?>
        <div class= "col-md-6 col-md-offset-2" style ="padding-top:20px;">
           <h3 class="text-center"> Add New User</h3>
           <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           <div class="form-group row">
                <label for="user_name" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-8">
                <input type="text" name="user_name" class="form-control" id="user_name" placeholder="" value="<?php echo $user_name; ?>">
                <div class="text-danger"> <?php echo $username_err ?></div>
                </div>
               
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-8">
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="" value="<?php echo $first_name; ?>">
                <div class="text-danger"> <?php echo $firstname_err ?></div>
                </div>

            </div>
            <div class="form-group row">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-8">
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="" value="<?php echo $last_name; ?>">
                <div class="text-danger"> <?php echo $lastname_err ?></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-8">
                <input type="email" name ="email" class="form-control" id="email" placeholder="" value="<?php echo $email; ?>">
                <div class="text-danger"> <?php echo $email_err ?></div>
                </div>

            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-8">
                <input type="password" name ="password" class="form-control" id="password" placeholder="">
                <div class="text-danger"> <?php echo $password_err ?></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="password_confirm" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-8">
                <input type="password" name ="password_confirm" class="form-control" id="password_confirm" placeholder="">
                <div class="text-danger"> <?php echo $password_confirm_err ?></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2 col-form-label">Is Admin</div>
                <div class="col-sm-8">
                <div class="form-check">
                    <input class="form-check-input" name ="admin" value=1 type="checkbox" id="admin">
                </div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-sm-6 col-sm-offset-3">
                <button type="submit" style="min-width:100px;" class="btn btn-block btn-primary">Add</button>
                </div>
            </div>
            <div class="text-danger text-center"> <?php echo $global_err ?></div>
            </form>
        </div>

    


    </div>
</div>

<?php
    include "../commons/footer.php";
?>
