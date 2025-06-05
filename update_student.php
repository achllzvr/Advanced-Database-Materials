<?php

// Error Display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection file
require_once('classes/database.php');

// Create an instance of the database class
$con = new database();

// SweetAlert Initialization
$sweetAlertConfig = "";

// Start the session
session_start();

// Checks if there is a user logged in
if (!isset($_SESSION['admin_ID'])) {
  
  // If not logged in, redirect to login page
  header("Location: login.php");
  exit();

}

// Check if the ID is set in the POST request
if(isset($_POST['student_id'])) {

  // Initialize Student ID
  $student_id = $_POST['student_id'];

}else{

  // If student_id is not set, redirect to index page
  header("Location: index.php");
  exit();

}

// Fetch student data based on the student_id
$student_data = $con->getStudentByID($student_id);

// Check if the form is submitted
if(isset($_POST['save'])) {

  // Get the form data
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $student_id = $_POST['student_id'];

  // Update student data
  $userID = $con->updateStudent($student_id, $first_name, $last_name, $email);

  // Success message if $userID is returned
    if($userID) {
      $sweetAlertConfig = "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'User updated successfully.',
          confirmButtonText: 'Continue'
        }).then(() => {
          window.location.href = 'index.php';
        });
      </script>";
    } else {
      $sweetAlertConfig = "
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to update user. Please try again.',
          confirmButtonText: 'Try Again'
        });
      </script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
</head>

<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Edit User</h2>

    <form method="POST" action="" class="bg-white p-4 rounded shadow-sm">

      <!-- Disabled input to store the student ID -->
      <div class="mb-3">
        <label for="student_id" class="form-label">Student ID</label>
        <input type="text" name="s_id" value="<?php echo $student_data['student_id']?>" id="student_id" class="form-control" disabled equired>
      </div>

      <!-- Input fields for first name -->
      <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" value="<?php echo $student_data['student_FN']?>" id="first_name" class="form-control" placeholder="Enter your new first name" required>
      </div>

      <!-- Input fields for last name -->
      <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" value="<?php echo $student_data['student_LN']?>" id="last_name" class="form-control" placeholder="Enter your new last name" required>
      </div>

      <!-- Input fields for email -->
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" value="<?php echo $student_data['student_email']?>" id="email" class="form-control" placeholder="Enter your new email" required>
      </div>

      <input type="hidden" name="student_id" value="<?php echo $student_data['student_id']?>">
      
      <button type="submit" name="save" class="btn btn-primary w-100">Save</button>

      
    </form>
  </div>
  
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
  <script src="./package/dist/sweetalert2.js"></script>
  <?php echo $sweetAlertConfig; ?>

</body>
</html>