<?php
// Start session
session_start();


// Get the user ID from the URL parameter
$user_id = $_GET['id'];
echo "Registration successful! Your user ID is: " . $user_id;

$servername = "localhost"; // replace with your server name
$username = "root"; // replace with your database username
$passwordx = ""; // replace with your database password
$dbname = "dblab8"; // replace with your database name

$conn = mysqli_connect($servername, $username, $passwordx, $dbname);


// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $sql = "DELETE FROM users WHERE id = '$user_id'";
  $result = mysqli_query($conn, $sql);

  // Check if update was successful
  if ($result) {
    // Redirect to update page with success message
    header('Location: delete.php?success=1');
    exit();
  } else {
    // Show error message
    $error_message = 'Error Deleting user information';
  }
} 

// Display form
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete User Information</title>
</head>
<body>
  <h1>Delete User Information</h1>
  <?php if (isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
  <?php } ?>
  <?php if (isset($_GET['success'])) { ?>
    <p>User Deleted successfully</p>
  <?php } ?>
  <form method="post">
    <input type="submit" value="Confirm Delete">
    <input type="submit" value="Not Now">
  </form>
</body>
</html>
