<?php

class database{

    function opencon(){
        return new PDO( 
        'mysql:host=127.0.0.1; 
        dbname=dbs_app',   
        username: 'root', 
        password: '');
    }

    // Function to signup user (registration.php)
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

    // Function to check if username exists (registration.php)
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

    // Check if email exists (registration.php)
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

    // Function to login user (login.php)
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

    // Function to add a student (index.php)
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

    // Function to add a course (index.php)
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

    // Check if Course exists (index.php)
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

    // Function to get all students (index.php)
    function getStudents(){

        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to get all students
        // Fetch all students from the database
        // Return the result as an associative array
        return $con->query("SELECT * FROM students")->fetchAll();

    }

    // Function to get student data by ID (update_student.php)
    function getStudentByID($student_id){

        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to get student data by ID
        $stmt = $con->prepare("SELECT * FROM students WHERE student_id = ?");
        // Execute the statement with the student ID
        $stmt->execute([$student_id]);

        // Fetch the student data as an associative array
        $student_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the student data
        return $student_data;
    }

    // Function to update student data (update_student.php)
    function updateStudent($student_id, $student_FN, $student_LN, $student_email){

        // Establish Connection with Database
        $con = $this->opencon();

        try{
            $con->beginTransaction();

            $query = $con->prepare("UPDATE students SET student_FN = ?, student_LN = ?, student_email = ? WHERE student_id = ?");
            $query->execute([$student_FN, $student_LN, $student_email, $student_id]);

            $con->commit();

            return true;   
        }catch (PDOException $e){
            $con->rollBack();
            return false;
        }

    }

    // Function to get all courses (index.php)
    function getCourses(){

        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to get all students
        // Fetch all courses from the database
        // Return the result as an associative array
        return $con->query("SELECT * FROM courses")->fetchAll();

    }

    // Function to get course data by ID (update_course.php)
    function getCourseByID($course_id){

        // Open connection with database
        $con = $this->opencon();

        // Prepare SQL statement to get course data by ID
        $stmt = $con->prepare("SELECT * FROM courses WHERE course_id = ?");
        // Execute the statement with the course ID
        $stmt->execute([$course_id]);

        // Fetch the course data as an associative array
        $course_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the course data
        return $course_data;
    }

    // Function to update course data (update_course.php)
    function updateCourse($course_id, $course_name){

        // Establish Connection with Database
        $con = $this->opencon();

        try{
            $con->beginTransaction();

            $query = $con->prepare("UPDATE courses SET course_name = ? WHERE course_id = ?");
            $query->execute([$course_name, $course_id]);

            $con->commit();

            return true;   
        }catch (PDOException $e){
            $con->rollBack();
            return false;
        }

    }
    
}