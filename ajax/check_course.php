<?php

// Find the file in the same project folder
require_once('../classes/database.php');
// Connect to class in the file
$con = new database();

// If there is a POST request with the email
if(isset($_POST['course_name'])) {
    $course_name = $_POST['course_name'];
    
    //Check if the usrname exitsts
    if($con->isCourseExists($course_name)) {

        // If the course_name exists, return a JSON response of true
        echo json_encode((['exists'=>true]));

    } else {

        // If the course_name does not exist, return a JSON response of false
        echo json_encode((['exists'=>false]));

    }

// If the course_name is not set, return an error message
} else {

    // If the course_name is not set, return an error message
    echo json_encode(['error'=>'Invalid Request']);

}