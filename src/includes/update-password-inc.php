<?php

    if(isset($_POST['submit'])) {
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (passwordMatch($password, $verifyPassword) !== false) {
            header("location: profile.php?error=passwordsDontMatch");
            exit();
        } else {
            updatePassword($conn, $password);
            header("location: profile.php?success=passwordUpdated");
            exit();
        }
    }

?>