<!--
Name: Ting Chen
Date: Nov. 17 , 2023
Section: CST 8285 section 303
Description: signup page
-->
<?php
// msg to show signup result
$message = "";

//handle signup post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //connect db
    require("database.php");
    $conn = db_connect();

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $hashedPassword);

    // Set parameters and execute
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Execute the statement
    try {
        if ($stmt->execute()) {
            $message = "Registration successfully. Redirect to <a href='login.php'>Login Page</a> in 2s";
        } else {
            $message = "Error: " . $stmt->error;
        }
    } catch (mysqli_sql_exception $e) {
        $message = "Error: " . $e->getMessage();
    }
    $stmt->close();
    $conn->close();
}
?>

<!-- header -->
<?php
$pageTitle = "Signup - Tools Rental System";
include("header.php")
?>
<!-- script to check signup form  -->
<script src="../scripts/signup_script.js"></script>

<div class="main-container">
    <main>
        <!-- display result -->
        <?php if ($message) : ?>
            <p class="msg-<?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'failed' ?>">
                <?php echo $message; ?>
            </p>
            <?php if (strpos($message, 'successfully')) {
                echo '<script> setTimeout(function() { window.location.href = "login.php"; }, 2000);</script>';
            }
            ?>
        <?php endif; ?>

        <!-- signup form -->
        <form id="signupForm" action="signup.php" method="POST" onsubmit="return validate();" class="signup-form">
            <div class="title">Register</div>
            <!-- You will need to write the validate function for this form. -->
            <div class="textfield">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname" id="firstname" placeholder="Firstname">
                <!-- Not use required tag！-->
                <span class="error" id="f_loginError">Firstname should be non-empty,
                    and within 20 characters long.</span>
            </div>

            <div class="textfield">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastname" id="lastname" placeholder="Lastname">
                <span class="error" id="l_loginError">Lastname should be non-empty,
                    and within 20 characters long.</span>
            </div>

            <div class="textfield">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username">
                <span class="error" id="userError">Username should WITHIN 8 characters long WITHOUT empty.</span>
            </div>

            <div class="textfield">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" placeholder="Email">
                <span class="error" id="emailError">Email address should be non-empty
                    with the format xyz@xyz.xyz which there must be 3 characters after dot,such as .com.</span>
            </div>

            <div class="textfield">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password" onkeyup="checkPasswordStrength();">
                <span class="error" id="passError">Pssword should be at least 8 characters:
                    1 uppercase, 1 lowercase.</span>
                <span id="password-strength"></span>
            </div>

            <div class="textfield">
                <label for="confirm_password">Re-type Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-type Password">
                <span class="error" id="pass2Error">Please retype password.</span>
            </div>

            <!-- <div class="checkbox">
                <input type="checkbox" name="newsletter" id="newsletter">
                <label for="newsletter">I agree to receive Weekly Kitten Pictures newsletters</label>
            </div> -->

            <div class="checkbox">
                <!-- The order of the "input" and "label" tags in the checkbox structure is 
                    a matter of convention and accessibility. -->
                <input type="checkbox" name="terms" id="terms">
                <label for="terms" class="terms-lable">I agree to the terms and conditions</label>
                <span class="error" id="termsError">Please accept the terms and conditions.</span>
            </div>

            <button type="submit">REGISTER</button>
            <button type="button" id="resetButton" onclick="resetForm()">RESET</button>
        </form>
    </main>
</div>

<!-- footer -->
<?php include('footer.php'); ?>