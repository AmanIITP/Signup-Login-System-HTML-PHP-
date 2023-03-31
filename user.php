
<?php
// Start the session
session_start();

// Connect to the database
$servername = "localhost"; // replace with your server name
$username = "root"; // replace with your database username
$passwordx = ""; // replace with your database password
$dbname = "dblab8"; // replace with your database name

$conn = mysqli_connect($servername, $username, $passwordx, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Get the user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $sql = "SELECT id, first_name, last_name FROM users WHERE email = '$email' AND password = '$password'";

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

        echo "<b>WELCOME TO OUR DATABASE</b><br>";
        echo "<b> </b><br>";
        echo "<b>First name: </b>" . $_SESSION['first_name'] . "<br>";
        echo "<b>Last name: </b>" . $_SESSION['last_name'] . "<br>";
        //echo "Email: " . $email . "<br>";

        echo '<br><a href="view.php?id=' . $_SESSION['user_id'] . '">View Your Full Information</a>';
        echo '<br><a href="user.php?id=' . $_SESSION['user_id'] . '">Logout</a>';

        exit;

    } else {
        // Display an error message
        $error_message = "Invalid email or password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome To Our Login Page</title>
</head>
<body>

<?php if (isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
<?php } ?>

<h2>Welcome To Our Login Page</h2>
<form method="post" action="">
    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" name="submit" value="Login">
</form>

</body>
</html>
