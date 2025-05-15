<?php

class database{

    function opencon(){
        return new PDO( 
   'mysql:host=localhost; 
        dbname=dbs_app',   
        username: 'root', 
        password: '');
    }

    function signupUser($username, $password, $firstname, $lastname){
        $con = $this->opencon();

        try{
            $con->beginTransaction();

            $stmt = $con->prepare("INSERT INTO Admin (admin_FN, admin_LN, admin_username, admin_password) VALUES (?,?,?,?)");
            $stmt->execute([$firstname, $lastname, $username,$password]);

            $userID = $con->lastInsertId();
            $con->commit();

            return $userID;   
        }catch (PDOException $e){
            $con->rollBack();
            return false;
        }
    }

    // Check if username exists
    function isUsernameExists($username){
        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to check if username exists
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_username = ?");
        // Executes the statement
        $stmt->execute([$username]);

        // Fetch the count of rows and its values and assign to $count
        $count = $stmt->fetchColumn();

        // Check if the count is greater than 0 and return true if greater than zero, else false
        return $count > 0;
    }


}