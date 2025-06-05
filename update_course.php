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
if(isset($_POST['course_id'])) {

  // Initialize course ID
  $course_id = $_POST['course_id'];

}else{

  // If course_id is not set, redirect to index page
  header("Location: index.php");
  exit();

}

// Fetch course data based on the course_id
$course_data = $con->getCourseByID($course_id);

// Check if the form is submitted
if(isset($_POST['save'])) {

  // Get the form data
  $course_id = $_POST['course_id'];
  $course_name = $_POST['course_name'];

  // Update course data
  $userID = $con->updateCourse($course_id, $course_name);

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

      <!-- Disabled input to store the course ID -->
      <div class="mb-3">
        <label for="course_id" class="form-label">Course ID</label>
        <input type="text" name="c_id" value="<?php echo $course_data['course_id']?>" id="course_id" class="form-control" disabled equired>
      </div>

      <!-- Input fields for name -->
      <div class="mb-3">
        <label for="course_name" class="form-label">Course Name</label>
        <input type="text" name="course_name" value="<?php echo $course_data['course_name']?>" id="course_id" class="form-control" placeholder="Enter your new first name" required>
      </div>

      <input type="hidden" name="course_id" value="<?php echo $course_data['course_id']?>">
      
      <button type="submit" name="save" class="btn btn-primary w-100">Save</button>

      
    </form>
  </div>
  
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
  <script src="./package/dist/sweetalert2.js"></script>
  <?php echo $sweetAlertConfig; ?>

</body>
</html>