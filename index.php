<?php
session_start();

if (isset($_SESSION['alert_msg'])){
    $alertMsg = $_SESSION['alert_msg'];
    echo "<script type='text/javascript'> alert('$alertMsg') </script>";

$_SESSION = array();
session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Easy Parking login and registration</title>
        
        <!-- Style CSS -->
        <link rel="stylesheet" href="./assets/styles.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    </head>

    <body>
    <div class="main">

        <!-- Login Area -->
        <div class="login" id="loginForm">
            <h1 class="text-center">Login Form</h1>
            <div class="login-form">
                <form action="./auth/login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="user_pw">
                    </div>
                    <p class="registrationForm" onclick="showRegistrationForm()"> <i>No Account? Register Here.</i></p>
                    <button type="submit" class="btn btn-dark login-btn form-control" name="submit">Login</button>
                </form>
            </div>
        </div>


        <!-- Registration Area -->
        <div class="registration" id="registrationForm">
            <h1 class="text-center">Registration Form</h1>
            <div class="registration-form">
            <form action="./auth/register.php" method="POST">
                <div class="form-group row">
                    <div class="col-6">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="fname">
                    </div>
                    <div class="col-6">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" name="lname">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-5">
                        <label for="contactNumber">Contact Number:</label>
                        <input type="number" class="form-control" id="contactNumber" name="phone" maxlength="11">
                    </div>
                    <div class="col-7">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="registerUsername">Username:</label>
                    <input type="text" class="form-control" id="registerUsername" name="username">
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password:</label>
                    <input type="password" class="form-control" id="registerPassword" name="user_pw" minlength="6">
                </div>
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" name="userType" value="user" checked>User</label>
                    <label class="radio-inline"><input type="radio" name="userType" value="admin">Admin</label>
                </div>
                <p class="registrationForm" onclick="showLoginForm()"><i> <- Back</i></p>
                <button type="submit" class="btn btn-dark login-register form-control" name="submit">Register</button>
            </form>

            </div>

        </div>

    </div>

    <script>
        // Constant variables
        const loginForm = document.getElementById('loginForm');
        const registrationForm = document.getElementById('registrationForm');

        // Hide registration form
        registrationForm.style.display = "none";


        function showRegistrationForm() {
            registrationForm.style.display = "";
            loginForm.style.display = "none";
        }

        function showLoginForm() {
            registrationForm.style.display = "none";
            loginForm.style.display = "";
        }

    </script>

    </body>
</html>