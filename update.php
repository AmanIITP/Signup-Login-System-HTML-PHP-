<?php
// Start session
session_start();


// Get the user ID from the URL parameter
$user_id = $_GET['id'];


$servername = "localhost"; // replace with your server name
$username = "root"; // replace with your database username
$passwordx = ""; // replace with your database password
$dbname = "dblab8"; // replace with your database name

$conn = mysqli_connect($servername, $username, $passwordx, $dbname);


// Set default values for user data
$first_name = '';
$last_name = '';
$email = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password=$_POST['password'];

  // Update user data in database
  $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email',password = ' $password' WHERE id = '$user_id'";
  $result = mysqli_query($conn, $sql);

  // Check if update was successful
  if ($result) {
    // Redirect to update page with success message
    header('Location: update.php?success=1');
    exit();
  } else {
    // Show error message
    $error_message = 'Error updating user information';
  }
} 

// Display form
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update User Information</title>
</head>
<body>
  <h1>Update User Information</h1>
  <?php if (isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
  <?php } ?>
  <?php if (isset($_GET['success'])) { ?>
    <p>User information updated successfully</p>
  <?php } ?>
  <form method="post">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>"><br>
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>"><br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo $email; ?>"><br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="<?php echo $password; ?>"><br>
    <input type="submit" value="Update">
    
  </form>
</body>
</html>
