<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome To Our Registration Page</title>
</head>
<body>
<?php
// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = $confirm_password = "";
$first_name_err = $last_name_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate first name
  if (empty($_POST["first_name"])) {
    $first_name_err = "First name is required";
  } else {
    $first_name = test_input($_POST["first_name"]);
    // Check if first name contains only letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
      $first_name_err = "Only letters and white space allowed";
    }
  }

  // Validate last name
  if (empty($_POST["last_name"])) {
    $last_name_err = "Last name is required";
  } else {
    $last_name = test_input($_POST["last_name"]);
    // Check if last name contains only letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
      $last_name_err = "Only letters and white space allowed";
    }
  }

  // Validate email
  if (empty($_POST["email"])) {
    $email_err = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // Check if email address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }
  }

  // Validate password
  if (empty($_POST["password"])) {
    $password_err = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
    // Check if password meets requirements
    if (strlen($password) < 8) {
      $password_err = "Password must be at least 8 characters";
    } elseif (!preg_match("#[0-9]+#", $password)) {
      $password_err = "Password must include at least one number";
    } elseif (!preg_match("#[a-zA-Z]+#", $password)) {
      $password_err = "Password must include at least one letter";
    }
  }

  // Validate confirm password
  if (empty($_POST["confirm_password"])) {
    $confirm_password_err = "Please confirm password";
  } else {
    $confirm_password = test_input($_POST["confirm_password"]);
    if ($confirm_password !== $password) {
      $confirm_password_err = "Passwords do not match";
    }
  }

  // If no errors, insert data into database
  if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

    // Connect to the database
    $servername = "localhost"; // replace with your server name
    $username = "root"; // replace with your database username
    $passwordx = ""; // replace with your database password
    $dbname = "dblab8"; // replace with your database name

    $conn = mysqli_connect($servername, $username, $passwordx, $dbname);

    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error); 
    }

    // Prepare and execute SQL statement to insert data into the "users" table
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $password);
    mysqli_stmt_execute($stmt);

    

    // Show user information
    
    echo "<b>Thank You For Registering!</b><br>";
    echo "<b>Your Information Has Been Saved:</b><br>";
    echo "  <br>";
    echo "<b>User Details: </b><br>";
    echo "<b>First Name: </b>" . $first_name . "<br>";
    echo "<b>Last Name: </b>" . $last_name . "<br>";
    echo "<b>Email: </b>" . $email . "<br>";

    // After successful insertion of user data into the database
    // Get the ID of the inserted user
    $user_id = mysqli_insert_id($conn);


    // Provide link to update information page
    echo '<br><a href="update.php?id=' . $user_id . '">Update Your Information</a>';
    echo '<br><a href="delete.php?id=' . $user_id . '">Delete Your Account</a>';
    

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
  }
}

// Function to sanitize user input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Welcome To Our Registration Page</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label>First Name:</label>
  <input type="text" name="first_name" value="<?php echo $first_name; ?>">
  <span><?php echo $first_name_err; ?></span><br><br>

  <label>Last Name:</label>
  <input type="text" name="last_name" value="<?php echo $last_name; ?>">
  <span><?php echo $last_name_err; ?></span><br><br>

  <label>Email  :  </label>
  <input type="text" name="email" value="<?php echo $email; ?>">
  <span><?php echo $email_err; ?></span><br><br>

  <label>Password:</label>
  <input type="password" name="password" value="<?php echo $password; ?>">
  <span><?php echo $password_err; ?></span><br><br>

  <label>Confirm Password:</label>
  <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
  <span><?php echo $confirm_password_err; ?></span><br><br>

  <input type="submit" name="submit" value="Submit">
</form>
