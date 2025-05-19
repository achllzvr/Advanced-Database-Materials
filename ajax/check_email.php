<?php

// Find the file in the same project folder
require_once('../classes/database.php');
// Connect to class in the file
$con = new database();

// If there is a POST request with the email
if(isset($_POST['email'])) {
    $email = $_POST['email'];
    
    //Check if the usrname exitsts
    if($con->isEmailExists($email)) {

        // If the email exists, return a JSON response of true
        echo json_encode((['exists'=>true]));

    } else {

        // If the email does not exist, return a JSON response of false
        echo json_encode((['exists'=>false]));

    }

// If the email is not set, return an error message
} else {

    // If the email is not set, return an error message
    echo json_encode(['error'=>'Invalid Request']);

}