<?php

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputLogin($username, $password) !== false) {
            header("location: ../login.php?error=emptyInput");
            exit();
        } else if (passwordMatch($conn, $username, $password) === false) {
            header("location: ../login.php?error=invalidLogin");
            exit();
        } else {
            loginUser($conn, $username, $password);
            header("location: ../index.php?success=loginSuccess");
            exit();
        }
    }

?>