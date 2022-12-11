<?php

    if (isset($_POST['submit'])) {
        $slug = $_POST['slug'];
        $quantity = $_POST['quantity'];
        $type = $_POST['submit'];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputAddToCart($quantity) !== false) {
            header("location: ../index.php?error=emptyInput");  
            exit();
        } else if (productExistsSlug($conn, $slug) === false) {
            header("location: ../index.php?error=productDoesNotExist");
            exit();
        } else {
            if (isset($_SESSION['userId'])) {
                $duplicates = addProductDuplicate($conn, $slug, $quantity);

                if ($duplicates === false) {
                    addToCart($conn, $slug, $quantity);
                }
            } else {
                addToCart($conn, $slug, $quantity);
            }
            if ($type == "continue") header("location: ../index.php");
            if ($type == "product") header("location: ../index.php");
            if ($type == "checkout") header("location: ../cart.php");
            exit();
        }
    }

?>