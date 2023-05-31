<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account= new Account($con);


  if(isset($_POST["submitButton"])){

 
    $email= FromSanitizer::sanitizeFormEmail($_POST["email"]);
 
    $password= FromSanitizer::sanitizeFormPassword($_POST["password"]);
  
    $success=$account->login($email , $password);

      
    if ($success){
      $_SESSION["userLoggedIn"]=$email;
    
      //store seesion
      header("Location: index.php");
    }

  }

  // عشان الايميل ميتمسحش بعد ما اكتبة لو كان غلط
function getInputValue($name){
  if(isset($_POST[$name])){
    echo $_POST[$name];
  }

}


  

?>

<!DOCTYPE html>
<html> 
    <head>
        <title> Welcome to Watchflix </title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css">
    </head>
    <body>
        <div class="signInContainer">
          <div class="column"> 

          <div class="header">
            <img src="assets\style/logo.png.png" title="Logo" alt="site logo">
            <h3>Sign In</h3>
            <span>to continue to Watchflix</span>
            

          </div>
            <form method="post">

       

            <?php echo $account->getError(Constants::$loginFailed); ?>

            <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email"); ?>" required>
    
            <input type="password" name="password" placeholder="Password" required>


            <input type="submit" name="submitButton" value="SUBMIT">

        





            </form>

            <a href="register.php"class=""signInMessage>Need an account? Sign up here!   </a> 

          </div>
        </div>
      
    </body>


</html>