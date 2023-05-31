<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");


$account= new Account($con);

  if(isset($_POST["submitButton"])){
  
    $firstName = FromSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FromSanitizer::sanitizeFormString($_POST["lastName"]);
    $Username = FromSanitizer::sanitizeFormUsername($_POST["UserName"]);
    $email= FromSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2= FromSanitizer::sanitizeFormEmail($_POST["email2"]);
    $password= FromSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2= FromSanitizer::sanitizeFormPassword($_POST["password2"]);

    $success=$account->register($firstName,$lastName,$Username,$email,$email2,$password,$password2);

      
    if ($success){

      $_SESSION["userLoggedIn"]=$email;
      //store seesion
      header("Location: index.php");
    }
  }
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
            <h3>Sign Up</h3>
            <span>to continue to Watchflix</span>
            

          </div>
            <form method="post">

            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
            <input type="text" name="firstName" placeholder="First Name" value="<?php getInputValue("firstName"); ?>" required>
           
            <?php echo $account->getError(Constants::$lastNameCharacters); ?>

            <input type="text" name="lastName" placeholder="Last Name" value="<?php getInputValue("lastName"); ?>" required>

            <?php echo $account->getError(Constants::$UserNameCharacters); ?>
            <?php echo $account->getError(Constants::$UserNameTaken); ?>

            <input type="text" name="UserName" placeholder="UserName" value="<?php getInputValue("UserName"); ?>" required>

            <?php echo $account->getError(Constants::$emailsDontMatch); ?>
            <?php echo $account->getError(Constants::$emailInvalid); ?>
            <?php echo $account->getError(Constants::$emailTaken); ?>

            <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email"); ?>" required>

            <input type="email" name="email2" placeholder="Confirm email" value="<?php getInputValue("email2"); ?>"  required>
            
            <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
            <?php echo $account->getError(Constants::$passwordLength); ?>

            <input type="password" name="password" placeholder="Password" required>

            <input type="password" name="password2" placeholder="Confirm Password" required>

            <input type="submit" name="submitButton" value="SUBMIT">

        





            </form>

            <a href="login.php"class=""signInMessage>Already have an account? Sign in here! </a> 

          </div>
        </div>
      
    </body>


</html>