<?php

// Start the session
session_start();

/* Checks if there is a user logged in
if (!isset($_SESSION['admin_ID'])) {
  
  // If not logged in, redirect to login page
  header("Location: login.php");
  exit();

}
*/

// Connect to Database
require_once('classes/database.php');
$con = new database();

// Initialize a variable to hold the SweetAlert configuration
$sweetAlertConfig = "";

/* Check if the logout button is clicked
  if(isset($_POST['logout'])) {

    // Set SweetAlert configuration for logout success
    $sweetAlertConfig = "
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Logout Successful',
        text: 'You have been logged out successfully.',
        confirmButtonText: 'Login Again'
      }).then(() => {
        window.location.href = 'logout.php';
      });
    </script>";

  }
*/

// Check if add student has been clicked
if (isset($_POST['add_student'])){
     
      $firstname = $_POST['first_name'];
      $lastname = $_POST['last_name'];
      $email = $_POST['email'];
      $admin_id = $_SESSION['admin_ID'];

      $userID = $con->addStudent($firstname, $lastname, $email, $admin_id);
      
      if ($userID) {
        $sweetAlertConfig = "
        <script>
        Swal.fire({
          icon: 'success',
          title: 'Student Added Successfully',
          text: 'You have successfully added a student.',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = 'index.php';
        });
        </script>
        ";
      } else {
        $sweetAlertConfig = "
         <script>
        Swal.fire({
          icon: 'error',
          title: 'Student wasn't added',
          text: 'An error occurred while adding the student. Please try again.',
          confirmButtonText: 'OK'
        });
        </script>"
        
        ;
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student & Course CRUD (PHP PDO)</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Student Records</h2>
    <form id="logoutForm" method="POST" action="logout.php" class="text-end mb-4">
      <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add New Student</button>
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Course</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Jei Q. Pastrana</td>
          <td>jei@example.com</td>
          <td>DIT</td>
          <td>
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <h2 class="mb-4 mt-5">Courses</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Course Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>BS Information Technology</td>
          <td>
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <h2 class="mb-4 mt-5">Enrollments</h2>
    <button class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#enrollStudentModal">Enroll Student</button>
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-dark">
        <tr>
          <th>Enrollment ID</th>
          <th>Student Name</th>
          <th>Course</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Juan Dela Cruz</td>
          <td>BS Information Technology</td>
          <td>
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Add Student Modal -->
  <div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="">
        <div class="modal-header">
          <h5 class="modal-title">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
          <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name" required>
          <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_student" class="btn btn-primary">Add</button>
        </div>

      <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
      <script src="./package/dist/sweetalert2.js"></script>
      <?php echo $sweetAlertConfig; ?>

      </form>
    </div>
  </div>

  <!-- Add Course Modal -->
  <div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="add_course.php">
        <div class="modal-header">
          <h5 class="modal-title">Add Course</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="course_name" class="form-control mb-2" placeholder="Course Name" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add Course</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Enroll Student Modal -->
  <div class="modal fade" id="enrollStudentModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="enroll_student.php">
        <div class="modal-header">
          <h5 class="modal-title">Enroll Student to Course</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="student_id" class="form-control mb-2" placeholder="Student ID" required>
          <input type="text" disabled name="student_name" class="form-control mb-2" placeholder="Student Name" required>
          
          <select name="course_id" class="form-control" required>
            <option value="">Select Course</option>
            <option value="1">Computer Science</option>
            <option value="2">Information Technology</option>
            <option value="3">Software Engineering</option>
            <option value="4">Data Science</option>
          </select>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Enroll</button>
        </div>
      </form>
    </div>
  </div>

  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>
