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

$sql = "SELECT id, first_name, last_name, email FROM users WHERE id = '$user_id'";

// Execute the SQL statement
$result = mysqli_query($conn, $sql);

// Check if there is a result
if (mysqli_num_rows($result) > 0) {

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    // Set session variables
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['first_name'] = $row['first_name'];
    $_SESSION['last_name'] = $row['last_name'];
    $_SESSION['email'] = $row['email'];

    echo "<br><b>WELCOME TO OUR DATABASE</b><br>";
    echo "<br>";
    echo "<b>User Id: </b>" . $_SESSION['user_id'] . "<br>";
    echo "<b>First name: </b>" . $_SESSION['first_name'] . "<br>";
    echo "<b>Last name: </b>" . $_SESSION['last_name'] . "<br>";
    echo "<b>Email: </b>" . $_SESSION['email'] . "<br>";
    exit;

}

// Display form
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Information</title>
</head>
<body>
  <h1>User Information</h1>
  <?php if (isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
  <?php } ?>
  <?php if (isset($_GET['success'])) { ?>
    <p>information fetched successfully</p>
  <?php } ?>
</body>
</html>
