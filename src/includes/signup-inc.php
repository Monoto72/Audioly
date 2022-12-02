<?php

if (isset($_POST['submit'])) {
    $fullName = $_POST['full-name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password1'];
    $verifyPassword = $_POST['password2'];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    if (emptyInputSignup($fullName, $username, $email, $password, $verifyPassword) !== false) {
        header("location: ../signup.php?error=emptyInput");
        exit();
    } else if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidEmail");
        exit();
    } else if (passwordMatch($password, $verifyPassword) !== false) {
        header("location: ../signup.php?error=passwordsDontMatch");
        exit();
    } else if (usernameExists($conn, $username, $email) !== false) {
        header("location: ../signup.php?error=usernameTaken");
        exit();
    } else {
        createUser($conn, $fullName, $username, $email, $password);
        header("location: ../index.php");
    }
}

?>