<!DOCTYPE html>
<html>
<head>
    <script src="js/jquery-3.3.1.js?ver=002"></script>
    <script src="js/1register.js?ver=006"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: fixed linear-gradient(to bottom right, #FFD166, #118AB2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #registrationFormContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 1000px;
            width: 100%;
            padding: 0 20px;
        }
        #registrationForm {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 70%;
            max-width: 600px;
            text-align: center;
        }
        #logo {
            max-width: 400px; 
            margin-right: 20px; 
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #FFD166;
            color: #fff;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #FFAB00;
            color: black;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        
    </style>
</head>
<body>

<div id="registrationFormContainer">
    <img id="logo" src="images/regback.png" alt="Logo">
    
    <form id="registrationForm" onsubmit="return addUser();">
        <h2>Registration Form</h2>
        First Name: <input type="text" id="firstname" name="firstname" onfocusout="validateUserForm();"><br>
        <span id="firstname_error" class="error-message"></span><br>

        Last Name: <input type="text" id="lastname" name="lastname" onfocusout="validateUserForm();"><br>
        <span id="lastname_error" class="error-message"></span><br>

        Student ID: <input type="text" id="studID" name="studID" onfocusout="validateUserForm();"><br>
        <span id="studID_error" class="error-message"></span><br>

        Username: <input type="text" id="username" name="username" onfocusout="validateUserForm();"><br>
        <span id="username_error" class="error-message"></span><br>

        Password: <input type="password" id="password" name="password" onfocusout="validateUserForm();"><br>
        <span id="password_error" class="error-message"></span><br>

        Confirm Password: <input type="password" id="confirmpass" name="confirmpass" onfocusout="validateUserForm();"><br>
        <span id="confirmpass_error" class="error-message"></span><br>
        <button type="submit" name="registerButton" id="registerButton">Register</button>
        <button type="button" name="gotologinButton" id="gotologinButton" onclick="goToLoginPage()">Login</button>
    </form>
</div>

<script>
    function goToLoginPage() {
        window.location.href = "2login.php";
    }
</script>

<?php include("footer.php"); ?>
</body>
</html>
