<?php
class Account{

    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con=$con;
        
    }

    public function updateDetails($fn,$ln,$em,$un){
        $this->validateFirstName($fn);
        $this->validatelastName($ln);
        $this->validateNewEmail($em,$un);

        if(empty($this->errorArray)){
            //updatde data
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln , username=:un
                                    WHERE email=:em ");

           $query->bindValue(":fn",$fn);
           $query->bindValue(":ln",$ln);
           $query->bindValue(":em",$em);
           $query->bindValue(":un",$un);

           return $query->execute();

        }

        return false;
    }


    public function register($fn,$ln,$un,$em,$em2,$pw,$pw2){
        $this->validateFirstName($fn);
        $this->validatelastName($ln);
        $this->validateUserName($un);
        $this->validateEmails($em ,$em2);
        $this->validatePasswords($pw ,$pw2);


        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn,$ln,$un,$em,$pw);
        }
        return false;

    }

    public function login($em,$pw){
        //عشان نقارن الباسور اللي في الداتا بيز اللي عندي باللي انا بعمل لوجين بية 
        $pw = hash("sha512",$pw);

        $query=$this->con->prepare("SELECT * from users where email=:em AND password=:pw ");
        $query->bindValue(":em",$em);
        $query->bindValue(":pw",$pw);

        $query->execute();

        if($query->rowCount()==1){
            return true;
        }
        array_push($this->errorArray, Constants::$loginFailed);
        return false;

    }

    private function insertUserDetails($fn,$ln,$un,$em,$pw){

        $pw = hash("sha512",$pw);
        $query = $this->con->prepare("INSERT INTO users(firstName,lastName,username,email,password)
                                                values(:fn,:ln,:un,:em,:pw)");
        $query->bindValue(":fn",$fn);
        $query->bindValue(":ln",$ln);
        $query->bindValue(":un",$un);
        $query->bindValue(":em",$em);
        $query->bindValue(":pw",$pw);

        // $query->execute();
        // var_dump($query->errorInfo());

        // return false;

        return $query->execute();


    }

     

//we change the public to private for secure and we can called into this class only .
    private function validateFirstName($fn){
        if(strlen($fn) <2 || strlen($fn) >25){
            array_push($this->errorArray, Constants::$firstNameCharacters);


        }

    }

    private function validateLastName($ln){
        if(strlen($ln) <2 || strlen($ln) >25){
            array_push($this->errorArray, Constants::$lastNameCharacters);


        }

    }

    private function validateUserName($un){
        if(strlen($un) <2 || strlen($un) >=50){
            array_push($this->errorArray, Constants::$UserNameCharacters);

            return;
        }

        $query = $this->con->prepare("SELECT * FROM users where username =:un ");
        $query->bindValue(":un" , $un);

        $query->execute();

        if($query->rowCount()!=0){
            array_push($this->errorArray, Constants::$UserNameTaken);
        }
    }

    private function validateEmails($em , $em2){
        if($em != $em2){

            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;

        }
        //عشان يكون اخرها .COM
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){

            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users where email =:em ");
        $query->bindValue(":em" , $em);

        $query->execute();

        if($query->rowCount()!=0){
            array_push($this->errorArray, Constants::$emailTaken);
        }

    }


    private function validateNewEmail($em , $un){

        //عشان يكون اخرها .COM
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){

            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users where email =:em AND username != :un");
        $query->bindValue(":em" , $em);
        $query->bindValue(":un" , $un);

        $query->execute();

        if($query->rowCount()!=0){
            array_push($this->errorArray, Constants::$emailTaken);
        }

    }

    // عشان الباسورد يكون زي بعضة
    private function validatePasswords($pw,$pw2){
        if($pw != $pw2){

            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;

        }
        if(strlen($pw) <7 || strlen($pw) >25){
            array_push($this->errorArray, Constants::$passwordLength);


        }
    }

    public function getError($error){
        if(in_array($error,$this->errorArray)){
            return "<span class='errorMessage'>$error</span>";

        }
        
    }

    public function getFirstError(){
        if(!empty($this->errorArray)){
            return $this->errorArray[0];
        }
    }

    public function updatdePassword($oldpw,$pw,$pw2,$em){
        $this->validatePassword($oldpw,$em);
        $this->validatePasswords($pw,$pw2);

        if(empty($this->errorArray)){
            //updatde data
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE email=:em");
            
            $pw = hash("sha512",$pw);
            $query->bindValue(":pw",$pw);
            $query->bindValue(":em",$em);

            return $query->execute();

        }

        return false;

    }

    public function validatePassword($oldpw,$em){

             //عشان نقارن الباسور اللي في الداتا بيز اللي عندي باللي انا بعمل لوجين بية 
        $pw = hash("sha512",$oldpw);

        $query=$this->con->prepare("SELECT * from users where email=:em AND password=:pw ");
        $query->bindValue(":em",$em);
        $query->bindValue(":pw",$pw);
        
        $query->execute();

        if($query->rowCount()==0){
            array_push($this->errorArray,Constants::$passwordIncorrect);
        }
    }




}





?>