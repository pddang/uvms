<?php
include 'check_login.php';
include '../../commons/header.php';
?>
<link rel="stylesheet" href="../../commons/css/style.css">
<link rel="stylesheet" href="../../commons/css/bootstrap.min.css">
<style>
 .form-signin {
    width: 100%;
    max-width: 400px;
    padding: 15px;
    margin: 0 auto;
  }
  .form-signin .checkbox {
    font-weight: 400;
  }
  .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
  }
  .form-signin .form-control:focus {
    z-index: 2;
  }
  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }
  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }
</style>

<div class="container-fluid">
        <div class="row">
            <?php include "../navs/login_nav.php" ?>
            <div class= "col-md-10" style ="padding-top:20px;">
            <div class="text-center">
              <form class = "form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <img class="mb-4" src="../../img/logo.png" alt="logo" width="72px" height="72px">
                  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                  <div class="<?php echo (!empty($username_err))?'has-error':'';?>" >
                    <label for="user_name" class="form-control" placeholder ="Username" required autofocus>
                    <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" required autofocus>
                    <span class="help-block"><?php echo $username_err;?></span>
                  </div>
                  
                  <div class="<?php echo (!empty($password_err))?'has-error':'';?>" >
                    <label for="password" class="form-control" placeholder ="Password" required autofocus>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autofocus>
                    <span class="help-block"><?php echo $password_err;?></span>
                  </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
              </form>
              </div>
                
            </div>

        </div>
 </div>

 <?php include "../../commons/footer.php" ?>




