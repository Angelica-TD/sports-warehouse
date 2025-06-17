<?php
//this class is part of the business layer it uses the DBAccess class
// require_once("DBAccess.php");
class Authentication
{
    //constants hold values that do not change
    const LoginPageURL = "login.php";
    const SuccessPageURL = "admin.php";
    private static $_db;
    public static function login($uname, $pword, $db)
    {
        $hash = "";
        //get database settings
        // include "includes/database.php";

        //check if user exists in database
        try {
            //set up SQL and bind parameters
            $sql = "select password from user where username=:username";
            $stmt = $db->prepareStatement($sql);
            $stmt->bindParam(":username", $uname, PDO::PARAM_STR);
            //execute SQL as the class is static we need to use
            //the keyword self instead of this
            $hash = $db->executeSQLReturnOneValue($stmt);
        } catch (PDOException $e) {
            throw $e;
        }
        if (password_verify($pword, $hash)) {
            //success password and username match
            $_SESSION["username"] = $uname;
            //redirect the user to the success page
            header("Location: " . self::SuccessPageURL);
            exit;
        } else {
            return false;
        }
    }
    //log user out
    public static function logout()
    {
        //remove username from the session
        unset($_SESSION["username"]);
        //redirect the user to the login page
        header("Location: " . self::LoginPageURL);
        exit;
    }
    //check if user is logged in
    public static function protect()
    {
        if (!isset($_SESSION["username"])) {
            //redirect the user to the login page
            header("Location: " . self::LoginPageURL);
            exit;
        }
    }
    //create a new user
    public static function createUser($uname, $pword, $db)
    {
        //hash the password
        $hash = password_hash($pword, PASSWORD_DEFAULT);
        //get database settings
        // include "includes/database.php";
        
        //add user to database
        try {

            //set up SQL and bind parameters
            $sql = "insert into user(username, password) values(:username, :password)";
            $stmt = $db->prepareStatement($sql);
            $stmt->bindParam(":username", $uname, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
            //execute SQL as the class is static we need to use
            //the keyword self instead of this
            $result = $db->executeNonQuery($stmt);
        } catch (PDOException $e) {
            throw $e;
        }
        return "New user added";
    }
}
