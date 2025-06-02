<?php

class database{

    function opencon(){
        return new PDO( 
        'mysql:host=127.0.0.1; 
        dbname=dbs_app',   
        username: 'root', 
        password: '');
    }

    function signupUser($username, $password, $firstname, $lastname, $email){
        $con = $this->opencon();

        try{
            $con->beginTransaction();

            $stmt = $con->prepare("INSERT INTO Admin (admin_FN, admin_LN, admin_username, admin_email, admin_password) VALUES (?,?,?,?,?)");
            $stmt->execute([$firstname, $lastname, $username, $email, $password]);

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

    // Check if Email exists
    function isEmailExists($email){
        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to check if username exists
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_email = ?");
        // Executes the statement
        $stmt->execute([$email]);

        // Fetch the count of rows and its values and assign to $count
        $count = $stmt->fetchColumn();

        // Check if the count is greater than 0 and return true if greater than zero, else false
        return $count > 0;
    }

    // Function to login user
    function loginUser($username, $password){

        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to check if username exists
        $stmt = $con->prepare("SELECT * FROM Admin WHERE admin_username = ?");
        // Executes the statement
        $stmt->execute([$username]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password if user exists
        // If user exists and password matches, return user data
        if($user && password_verify($password, $user['admin_password'])) {
            // If password matches, return user data
            return $user;
        } else {
            // If user does not exist or password does not match, return false
            return false;
        }

    }

    function addStudent($firstname, $lastname, $email, $admin_id){
        $con = $this->opencon();

        try{
            $con->beginTransaction();

            $stmt = $con->prepare("INSERT INTO students (student_FN, student_LN, student_email, admin_id) VALUES (?,?,?,?)");
            $stmt->execute([$firstname, $lastname, $email, $admin_id]);

            $userID = $con->lastInsertId();
            $con->commit();

            return $userID;   
        }catch (PDOException $e){
            $con->rollBack();
            return false;
        }

    }

    function addCourse($coursename, $admin_id){
        $con = $this->opencon();

        try{
            $con->beginTransaction();

            $stmt = $con->prepare("INSERT INTO courses (course_name, admin_id) VALUES (?,?)");
            $stmt->execute([$coursename, $admin_id]);

            $userID = $con->lastInsertId();
            $con->commit();

            return $userID;   
        }catch (PDOException $e){
            $con->rollBack();
            return false;
        }

    }

    // Check if Email exists
    function isCourseExists($course_name){
        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to check if username exists
        $stmt = $con->prepare("SELECT COUNT(*) FROM courses WHERE course_name = ?");
        // Executes the statement
        $stmt->execute([$course_name]);

        // Fetch the count of rows and its values and assign to $count
        $count = $stmt->fetchColumn();

        // Check if the count is greater than 0 and return true if greater than zero, else false
        return $count > 0;
    }

    
}