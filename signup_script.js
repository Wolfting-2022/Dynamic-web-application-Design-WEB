function validate() {
  // Get references to form elements
  const emailInput = document.getElementById("email");
  const f_loginInput = document.getElementById("firstname");
  const l_loginInput = document.getElementById("lastname");
  const userInput = document.getElementById("username");
  const passInput = document.getElementById("password");
  const pass2Input = document.getElementById("confirm_password");
  // const newsletterCheckbox = document.getElementById("newsletter");
  const termsCheckbox = document.getElementById("terms");

  // Initialize error flag
  let hasErrors = false;

  // Regular expression for valid email.
  // "/  /" is begining and end
  // "^  $" is the start and end of the string
  // []+ This quantifier mean previous character class [] should occur one or more times
  // @ and  \.(escaped with a backslash) is required part
  // {3,} is a quantifier that specifies a minimum of three characters.
  const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{3,}$/;

  // Clear any previous error messages
  const errorMessages = document.getElementsByClassName("error");
  for (let i = 0; i < errorMessages.length; i++) {
    errorMessages[i].style.display = "none";
  }

  // Validate email
  // .test() is a method checks if emailPattern matches the value of the email input field
  // const.value and const.style
  if (!emailPattern.test(emailInput.value)) {
    hasErrors = true;
    // If the email is invalid, this line accesses an HTML element with
    //  the id "emailError" and changes its CSS display property to "block".
    document.getElementById("emailError").style.display = "block";
    emailInput.style.border = "1px solid red";
  } else {
    emailInput.style.border = "1px solid #ccc";
  }

  // FirstName validation
  // if login input field is empty using .trim() method removing leading and trailing whitespace
  // OR the length of the login input is greater than or equal to 20 characters
  if (f_loginInput.value.trim() === "" || f_loginInput.value.length > 20) {
    hasErrors = true;
    document.getElementById("f_loginError").style.display = "block";
    f_loginInput.style.border = "1px solid red";
  } else {
    f_loginInput.style.border = "1px solid #ccc";
    // Convert login to lowercase
    f_loginInput.value = f_loginInput.value.toLowerCase();
  }

  // LastName validation
  if (l_loginInput.value.trim() === "" || l_loginInput.value.length > 20) {
    hasErrors = true;
    document.getElementById("l_loginError").style.display = "block";
    l_loginInput.style.border = "1px solid red";
  } else {
    l_loginInput.style.border = "1px solid #ccc";
    // Convert login to lowercase
    l_loginInput.value = l_loginInput.value.toLowerCase();
  }

  // UserName validation
  if (userInput.value.trim() === "" || userInput.value.length > 8) {
    hasErrors = true;
    document.getElementById("userError").style.display = "block";
    userInput.style.border = "1px solid red";
  } else {
    userInput.style.border = "1px solid #ccc";
    // Convert login to lowercase
    userInput.value = userInput.value.toLowerCase();
  }

  // Validate password
  // (?=.*[a-z])  This is a positive lookahead assertion. It checks
  // if the string contains at least one lowercase letter (from 'a' to 'z').
  // .*:          This part matches any character (represented by .)
  // zero or more times (indicated by *)
  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  if (!passwordPattern.test(passInput.value)) {
    hasErrors = true;
    document.getElementById("passError").style.display = "block";
    passInput.style.border = "1px solid red";
  } else {
    passInput.style.border = "1px solid #ccc";
  }

  // Validate re-type password
  if (pass2Input.value !== passInput.value || pass2Input.value.trim() === "") {
    hasErrors = true;
    document.getElementById("pass2Error").style.display = "block";
    pass2Input.style.border = "1px solid red";
  } else {
    pass2Input.style.border = "1px solid #ccc";
  }

  // Validate terms checkbox  始终出现4次才消除?????
  // !termsCheckbox.checked returns true if the checkbox is unchecked
  // "block" means that the element will be rendered as a block-level
  //   element, taking up the full width of its container and starting on a new line.
  if (!termsCheckbox.checked) {
    hasErrors = true;
    document.getElementById("termsError").style.display = "block";
  }

  // Prevent form submission if there are errors
  // If there are errors (hasErrors is true), !hasErrors will be false.
  // If there are validation errors in the form, the function will set hasErrors to true,
  // and returning !hasErrors as false will prevent the form submission.
  return !hasErrors;

  // !! Can ignore this method-call statement
  // since there are onkeyup="checkPasswordStrength()" in signup.php
  // checkPasswordStrength();
}

function checkPasswordStrength() {
  var strengthBar = document.getElementById("password-strength");
  // FK!!!! Original setting is "password" not work then rename "passCheck" that make sense
  var passwordCheck = document.getElementById("password").value;
  var strength = 0;

  if (passwordCheck.match(/[0-9]/) && passwordCheck.match(/[a-zA-Z]/)) {
    strength += 1;
  }
  if (passwordCheck.match(/[~!@#$%^&*()_+-]/)) {
    strength += 1;
  }
  if (passwordCheck.length > 10) {
    strength += 1;
  }

  // switch (strength) {
  //   case 0:
  //   case 1:
  //     strengthBar.innerHTML = "Weak";
  //     strengthBar.style.color = "yellow";
  //     break;
  //   case 2:
  //     strengthBar.innerHTML = "Medium";
  //     strengthBar.style.color = "orange";
  //     break;
  //   case 3:
  //     strengthBar.innerHTML = "Strong";
  //     strengthBar.style.color = "green";
  //     break;
  // }
}

function resetForm() {
  //reset form
  document.getElementById("signupForm").reset();

  // Clear any error messages
  const errorMessages = document.querySelectorAll(".error");
  errorMessages.forEach(function (errorMessage) {
    errorMessage.style.display = "none";
  });

  // Reset the style of input fields
  const inputFields = document.querySelectorAll(".textfield input");
  inputFields.forEach(function (inputField) {
    inputField.style.border = "1px solid #888772";
  });

  // Clear the password strength indicator
  const strengthBar = document.getElementById("password-strength");
  if (strengthBar) {
    strengthBar.innerHTML = "";
    strengthBar.style.color = ""; // Also reset the color if needed
  }
}
