<?php
require_once("includes/header.php");
require_once("includes/paypalConfig.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/BillingDetails.php");

$user=new User($con,$userLoggedIn);
$detailsMessage="";
$passwordMessage="";
$subscriptionMessage="";

if(isset($_POST["saveDetailsButton"])){
    $account= new Account($con);

    $firstName= FromSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName= FromSanitizer::sanitizeFormString($_POST["lastName"]);
    $email= FromSanitizer::sanitizeFormEmail($_POST["email"]);


    if($account->updateDetails($firstName,$lastName,$email,$userLoggedIn)){
        // success

        $detailsMessage ="<div class='alertSuccess'>
                            Details updated successfully!
                          </div>";


    }
    else {
        $errorMessage=$account->getFirstError();

        $detailsMessage ="<div class='alertError'>
                              $errorMessage
                          </div>";


    }

    //failure
   



}



if(isset($_POST["savePasswordButton"])){
    $account= new Account($con);

    $oldPassword= FromSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword= FromSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2= FromSanitizer::sanitizeFormPassword($_POST["newPassword2"]);


    if($account->updatdePassword($oldPassword,$newPassword,$newPassword2,$userLoggedIn)){
        // success

        $passwordMessage ="<div class='alertSuccess'>
                            Password updated successfully!
                          </div>";


    }
    else {
        $errorMessage=$account->getFirstError();

        $passwordMessage ="<div class='alertError'>
                              $errorMessage
                          </div>";


    }

    //failure
   

}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();

    $subscriptionMessage = "<div class='alertError'>
                               somthing went wrong!
                            </div>";
  
    try {
      // Execute agreement
      $agreement->execute($token, $apiContext);

      // Update user's account status
      $result = BillingDetails::insertDetails($con, $agreement, $token, $userLoggedIn);
      $result = $result && $user->setIsSubscribed(1);

        if($result) {
            $subscriptionMessage = "<div class='alertSuccess'>
                                       You're all signed up!
                                    </div>";
        }

    } catch (PayPal\Exception\PayPalConnectionException $ex) {
      echo $ex->getCode();
      echo $ex->getData();
      die($ex);
    } catch (Exception $ex) {
      die($ex);
    }
  } 
  else if (isset($_GET['success']) && $_GET['success'] == 'false') {
    $subscriptionMessage ="<div class='alertError'>
                              User cancelled or somthing went wrong!
                           </div>";
  }

?>

<div class="setitingsContainer column">
    <div class="formSectin">
        <form method="POST">
            <h2>User details</h2>

            <?php 


            $firstName= isset($_POST["firstName"]) ? $_POST["firstName"]: $user->getFirstName();
            $lastName= isset($_POST["lastName"]) ? $_POST["lastName"]: $user->getlastName();
            $email= isset($_POST["email"]) ? $_POST["email"]: $user->getEmail();
            
            
            ?>

            <input type="text" name="firstName" placeholder="First name" value="<?php echo $firstName?>">
            <input type="text" name="lastName" placeholder="Last name" value="<?php echo $lastName?>">
            <input type="email" name="email" placeholder=" Email" value="<?php echo $email?>">
           
            <div class="Message">
                <?php echo $detailsMessage ;?>

            </div>
            <input type="submit" name="saveDetailsButton" value="Save">

        </form>
    </div>

    <div class="formSectin">
        <form method="POST">
            <h2>Update password</h2>

            <input type="password" name="oldPassword" placeholder="Old password">
            <input type="password" name="newPassword" placeholder="New password">
            <input type="password" name="newPassword2" placeholder="Confirm password">
            
            <div class="Message">
                <?php echo $passwordMessage ;?>

            </div>
            <input type="submit" name="savePasswordButton" value="Save">

        </form>
    </div>
    <div class="formSectin">
        <h2>Subscription</h2>
        <div class="Message">
            <?php echo $subscriptionMessage ;?>

        </div>

        <?php 

        if($user->getSubscribed()){
            echo "<h3>Congrats you are subscribed! Go to PayPal to cancel.</h3>";
        }
        else{
             echo "<a href='billing.php'>Harry up Subscribe to Watchflix and get 1 month for free</a>";

        }
        


        ?>
    </div>


</div>