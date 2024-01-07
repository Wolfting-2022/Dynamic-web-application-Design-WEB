<!--
Name: Ting Chen
Date: Nov. 18 , 2023
Section: CST 8285 section 303
Description: login page
-->
<?php
session_start();

// msg to show login result
$message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //connect db
    require("database.php");
    $conn = db_connect();

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");

    // Bind the parameter   $username??
    $stmt->bind_param("s", $inputUsername);

    // Set parameters and execute   $username??
    $inputUsername = $_POST['username'];
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the user data
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($_POST['password'], $user['password'])) {
            //login success
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Redirect to dashboard page
            header("Location: index.php");
            exit();
        } else {
            $message = "The password you entered was not valid.";
        }
    } else {
        $message = "No account found with that username.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!-- header -->
<?php
$pageTitle = "Login - Tools Rental System";
include('header.php');
?>

<div class="main-container">
    <main>
        <div class="login" id="content">

            <!-- login result msg -->
            <?php if ($message) : ?>
                <p class="msg-<?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'failed' ?>">
                    <?php echo $message; ?>
                </p>
            <?php endif; ?>

            <!-- login form -->
            <form action="login.php" method="post" class="login-form">
                <div class="title">Login</div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">

                <!-- Function for cookie to keep username will do later! -->
                <div class="remember-me">
                    <input type="checkbox" id="remember-me" name="remember_me">
                    <label for="remember-me">Remember Me</label>
                    <a href="forgot_password.php">Foget Password?</a>
                </div>

                <button type="submit" class="login-button">LOGIN</button>
                <div class="login-help-links">
                    <a href="signup.php">Sign Up</a>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- footer -->
<?php include('footer.php'); ?>